<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Notaris;
use App\Models\NotaryAktaTypes;
use App\Services\NotaryAktaTypeService;
use Illuminate\Http\Request;

class NotaryAktaTypesController extends Controller
{
    protected $service;

    public function __construct(NotaryAktaTypeService $service)
    {
        $this->service = $service;
    }

    public function index(Request $request)
    {
        $filters = $request->only(['search', 'status']);
        $aktaTypes = $this->service->list($filters);
        return view('pages.BackOffice.AktaType.index', compact('aktaTypes', 'filters'));
    }

    public function create()
    {
        $notaris = Notaris::whereNull('deleted_at')->get();
        return view('pages.BackOffice.AktaType.form', compact('notaris'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            // 'notaris_id' => 'required|exists:notaris,id',
            'category' => 'nullable|in:pendirian,perubahan,pemutusan',
            'type' => 'nullable|string',
            'description' => 'nullable|string',
            'documents' => 'required|string',
        ]);

        $data['notaris_id'] = auth()->user()->notaris_id;

        $this->service->create($data);
        notyf()->position('x', 'right')->position('y', 'top')->success('Berhasil menambahkan akta type.');
        return redirect()->route('akta-types.index');
    }

    public function edit($id)
    {
        $aktaType = $this->service->get($id);
        $notaris = Notaris::whereNull('deleted_at')->get();
        return view('pages.BackOffice.AktaType.form', compact('aktaType', 'notaris'));
    }

    public function update(Request $request, $id)
    {
        $data = $request->validate([
            'notaris_id' => 'required|exists:notaris,id',
            'category' => 'nullable|in:pendirian,perubahan,pemutusan',
            'type' => 'nullable|string',
            'description' => 'nullable|string',
            'documents' => 'required|string',
        ]);

        $this->service->update($id, $data);
        notyf()->position('x', 'right')->position('y', 'top')->success('Berhasil memperbarui akta type.');
        return redirect()->route('akta-types.index');
    }
    public function destroy($id)
    {
        $this->service->delete($id);
        notyf()->position('x', 'right')->position('y', 'top')->success('Berhasil menghapus akta type.');
        return redirect()->route('akta-types.index');
    }
}
