<?php

namespace App\Http\Controllers;

use App\Models\Client;
use App\Models\PicDocuments;
use App\Services\NotaryCostService;
use Illuminate\Http\Request;
use Mpdf\Mpdf;

class NotaryCostController extends Controller
{
    protected $service;

    public function __construct(NotaryCostService $service)
    {
        $this->service = $service;
    }

    public function index(Request $request)
    {
        $search = $request->get('search');
        $costs = $this->service->list(['search' => $search]);
        return view('pages.Biaya.TotalBiaya.index', compact('costs', 'search'));
    }

    public function create()
    {
        $clients = Client::where('deleted_at', null)->get();
        $picDocuments = PicDocuments::where('deleted_at', null)->get();
        $cost = null;
        return view('pages.Biaya.TotalBiaya.form', compact('clients', 'picDocuments', 'cost'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'client_id' => 'required',
            'pic_document_id' => 'required',
            'payment_code' => 'required|string',
            'product_cost' => 'required',
            'admin_cost' => 'nullable',
            'other_cost' => 'nullable',
            'amount_paid' => 'nullable',
            'payment_status' => 'required|string',
            'paid_date' => 'nullable|date',
            'due_date' => 'required|date',
            'note' => 'nullable',
        ]);
        // dd($validated);

        $validated['notaris_id'] = auth()->user()->notaris_id;

        $this->service->create($validated);
        notyf()->position('x', 'right')->position('y', 'top')->success("Biaya berhasil ditambahkan.");
        return redirect()->route('notary_costs.index');
    }

    public function edit($id)
    {
        $cost = $this->service->detail($id);
        $clients = Client::where('deleted_at', null)->get();
        $picDocuments = PicDocuments::where('deleted_at', null)->get();
        return view('pages.Biaya.TotalBiaya.form', compact('cost', 'clients', 'picDocuments'));
    }

    // public function show($id)
    // {
    //     $cost = $this->service->detail($id);
    //     $clients = Client::where('deleted_at', null)->get();
    //     return view('pages.Biaya.TotalBiaya.show', compact('cost', 'clients'));
    // }

    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'client_id' => 'required',
            'pic_document_id' => 'required',
            'payment_code' => 'required|string',
            'product_cost' => 'required',
            'admin_cost' => 'nullable',
            'other_cost' => 'nullable',
            'amount_paid' => 'nullable',
            'payment_status' => 'required',
            'paid_date' => 'required|date',
            'due_date' => 'required|date',
            'note' => 'nullable',
        ]);

        $validated['notaris_id'] = auth()->user()->notaris_id;

        $this->service->update($id, $validated);
        notyf()->position('x', 'right')->position('y', 'top')->success("Biaya berhasil diubah.");
        return redirect()->route('notary_costs.index');
    }

    public function destroy($id)
    {
        $this->service->delete($id);
        notyf()->position('x', 'right')->position('y', 'top')->success("Biaya berhasil dihapus.");
        return back();
    }
    public function print($id)
    {
        $costs = $this->service->detail($id);

        // ✅ Gunakan format A4 (bisa portrait atau landscape)
        $mpdf = new \Mpdf\Mpdf([
            'format' => 'A4', // A4 portrait
            // 'format' => 'A4-L', // jika ingin landscape
            'margin_left'   => 15,
            'margin_right'  => 15,
            'margin_top'    => 10,
            'margin_bottom' => 0,
        ]);

        $html = view('pages.Biaya.TotalBiaya.print', compact('costs'))->render();
        $mpdf->WriteHTML($html);
        $mpdf->Output("notary_cost_$id.pdf", "I");
    }
}
