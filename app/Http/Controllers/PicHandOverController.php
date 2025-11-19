<?php

namespace App\Http\Controllers;

use App\Models\PicDocuments;
use App\Services\PicHandoverService;
use Illuminate\Http\Request;
use PDF; // gunakan dompdf / barryvdh
use Mpdf\Mpdf;

class PicHandoverController extends Controller
{
    protected $service;

    public function __construct(PicHandoverService $service)
    {
        $this->service = $service;
    }

    public function index(Request $request)
    {
        $handovers = $this->service->listHandovers([
            'search' => $request->get('search')
        ]);

        return view('pages.PIC.PicHandovers.index', compact('handovers'));
    }

    public function create()
    {
        $picDocuments = PicDocuments::all();
        return view('pages.PIC.PicHandovers.form', compact('picDocuments'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'pic_document_id' => 'required|exists:pic_documents,id',
            'handover_date'   => 'required|date',
            'recipient_name'  => 'required|string',
            'recipient_contact' => 'required|string',
            'note'            => 'nullable|string',
            'file_path'       => 'nullable|file|mimes:pdf,jpg,png,png|max:1024',
        ]);

        $validated['notaris_id'] = auth()->user()->notaris_id;

        if ($request->hasFile('file_path')) {
            $validated['file_path'] = $request->file('file_path')->storeAs('documents', $request->file('file_path')->getClientOriginalName());
        }

        $this->service->createHandover($validated);

        notyf()->position('x', 'right')->position('y', 'top')->success('Serah terima berhasil ditambahkan.');
        return redirect()->route('pic_handovers.index');
    }

    public function destroy($id)
    {
        $this->service->deleteHandover($id);
        notyf()->success('Data serah terima dihapus.');
        return back();
    }

    public function print($id)
    {
        $handover = $this->service->listHandovers([])->firstWhere('id', $id);

        if (!$handover) {
            abort(404, 'Data serah terima tidak ditemukan');
        }

        // Ambil view dan render jadi HTML string
        $html = view('pages.PIC.PicHandovers.print', compact('handover'))->render();

        // Pakai mpdf
        $mpdf = new \Mpdf\Mpdf();

        $mpdf->WriteHTML($html);

        // Unduh file PDF
        return response($mpdf->Output("handover-{$handover->id}.pdf", \Mpdf\Output\Destination::STRING_RETURN))
            ->header('Content-Type', 'application/pdf')
            ->header('Content-Disposition', 'attachment; filename="handover-' . $handover->id . '.pdf"');
    }
}
