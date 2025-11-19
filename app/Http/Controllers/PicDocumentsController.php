<?php

namespace App\Http\Controllers;

use App\Models\Client;
use App\Models\NotaryAktaTransaction;
use App\Models\NotaryRelaasAkta;
use App\Models\PicDocuments;
use App\Models\PicStaff;
use App\Services\PicDocumentsService;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Mpdf\Mpdf;

class PicDocumentsController extends Controller
{
    protected $service;

    public function __construct(PicDocumentsService $service)
    {
        $this->service = $service;
    }

    public function index(Request $request)
    {
        $filters = [
            'search' => $request->search,
            'status' => $request->status,
        ];

        $picDocuments = $this->service->getAllDocuments($filters);

        return view('pages.PIC.PicDocuments.index', compact('picDocuments'));
    }

    public function create()
    {
        $clients = Client::where('deleted_at', null)->get();
        $picStaffList = PicStaff::where('deleted_at', null)->get();
        $aktaTransaction = NotaryAktaTransaction::where('deleted_at', null)->where('status', 'draft')->get();
        $relaasTransaction = NotaryRelaasAkta::where('deleted_at', null)->where('status', 'draft')->get();
        return view('pages.PIC.PicDocuments.form', compact('clients', 'picStaffList', 'aktaTransaction', 'relaasTransaction'));
    }
    public function store(Request $request)
    {
        // dd($request->all());
        $validated = $request->validate([
            'pic_id' => 'required',
            'client_code' => 'required',
            'transaction_id' => 'required',
            'transaction_type' => 'required',
            'received_date' => 'required|date',
            'status' => 'required',
            'note' => 'nullable',
        ]);

        $validated['notaris_id'] = auth()->user()->notaris_id;

        $this->service->createDocument($validated);

        notyf()->position('x', 'right')->position('y', 'top')->success('PIC Dokumen berhasil ditambahkan.');
        return redirect()->route('pic_documents.index');
    }

    public function edit($id)
    {
        $clients =  Client::where('deleted_at', null)->get();
        $picStaffList = PicStaff::where('deleted_at', null)->get();
        $picDocument = $this->service->getDocumentById($id);
        $aktaTransaction = NotaryAktaTransaction::all();
        $relaasTransaction = NotaryRelaasAkta::all();

        return view('pages.PIC.PicDocuments.form', compact('picDocument', 'clients', 'picStaffList', 'aktaTransaction', 'relaasTransaction'));
    }

    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'pic_id' => 'required',
            'client_code' => 'required',
            'received_date' => 'required',
            'transaction_type' => 'required',
            'transaction_id' => 'nullable',
            'status' => 'required',
            'note' => 'nullable',
        ]);

        $validated['notaris_id'] = auth()->user()->notaris_id;

        $this->service->updateDocument($id, $validated);

        notyf()->position('x', 'right')->position('y', 'top')->success('PIC Dokumen berhasil diperbarui.');
        return redirect()->route('pic_documents.index');
    }

    public function destroy($id)
    {
        $this->service->deleteDocument($id);

        notyf()->position('x', 'right')->position('y', 'top')->success('PIC Dokumen berhasil dihapus.');
        return redirect()->route('pic_documents.index');
    }

    public function print($id)
    {
        $picDocuments = PicDocuments::findOrFail($id);
        // Render blade ke HTML
        $html = view('pages.PIC.PicDocuments.print', compact('picDocuments'))->render();

        // Inisialisasi mPDF
        $mpdf = new Mpdf([
            'default_font' => 'dejavusans',
            'format'       => 'A4',
            'margin_top'   => 10,
            'margin_bottom' => 0,
            'margin_left'  => 15,
            'margin_right' => 15,
            'tempDir' => storage_path('app/mpdf-temp'),
        ]);

        // Tulis HTML ke PDF
        $mpdf->WriteHTML($html);

        // Output langsung ke browser (inline)
        return response($mpdf->Output("Pic Dokumen.pdf", 'I'))
            ->header('Content-Type', 'application/pdf');
    }
}
