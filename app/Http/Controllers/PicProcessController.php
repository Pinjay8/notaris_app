<?php

namespace App\Http\Controllers;

use App\Models\PicDocuments;
use App\Services\PicProcessService;
use Illuminate\Http\Request;

class PicProcessController extends Controller
{
    protected $service;

    public function __construct(PicProcessService $service)
    {
        $this->service = $service;
    }

    public function index(Request $request)
    {
        $processes = collect();

        if ($request->filled('pic_document_code')) {
            $doc = PicDocuments::where('pic_document_code', $request->pic_document_code)->first();

            if ($doc) {
                $processes = $this->service->listProcesses(['pic_document_id' => $doc->id]);
            }
        }

        return view('pages.PIC.PicProcess.index', compact('processes'));
    }

    public function create(Request $request)
    {
        $picDocument = null;
        if ($request->filled('pic_document_code')) {
            $picDocument = PicDocuments::where('pic_document_code', $request->pic_document_code)->first();
        }

        return view('pages.PIC.PicProcess.form', compact('picDocument'));
    }

    public function store(Request $request)
    {
        // dd($request->all());
        $validated = $request->validate([
            'pic_document_id'   => 'required',
            'step_name'      => 'required',
            'step_status'            => 'required',
            'step_date'              => 'required',
            'note'              => 'nullable',
        ]);
        // dd($validated);


        $validated['notaris_id'] = auth()->user()->notaris_id;
        $this->service->createProcess($validated);

        notyf()->position('x', 'right')->position('y', 'top')->success('Proses pengurusan berhasil ditambahkan.');
        return redirect()->route(
            'pic_process.index',
            [
                'pic_document_code' => $request->pic_document_code
            ]
        );
    }

    public function edit($id)
    {
        $process = $this->service->getProcessById($id);
        return view('pages.PIC.PicProcess.form', compact('process'));
    }

    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'pic_document_id'   => 'required',
            'step_name'      => 'required',
            'step_status'            => 'required',
            'step_date'              => 'required',
            'note'              => 'nullable',
        ]);

        $validated['notaris_id'] = auth()->user()->notaris_id;

        $this->service->updateProcess($id, $validated);

        notyf()->position('x', 'right')->position('y', 'top')->success('Proses pengurusan berhasil diperbarui.');
        return redirect()->route('pic_process.index');
    }

    public function destroy($id)
    {
        $this->service->deleteProcess($id);

        notyf()->position('x', 'right')->position('y', 'top')->success('Proses pengurusan berhasil dihapus.');
        return redirect()->back();
    }

    public function indexProcess(Request $request)
    {
        $processes = collect();

        if ($request->filled('pic_document_code')) {
            $doc = PicDocuments::where('pic_document_code', $request->pic_document_code)->first();

            if ($doc) {
                $processes = $this->service->listProcesses(['pic_document_id' => $doc->id]);
            }
        }

        return view('pages.ManagementProcess.index2', compact('processes'));
    }
}
