<?php

namespace App\Http\Controllers;

use App\Models\Client;
use App\Models\Notaris;
use App\Models\NotaryRelaasAkta;
use App\Models\NotaryRelaasLogs;
use App\Services\NotaryRelaasLogsService;
use Illuminate\Http\Request;

class NotaryRelaasLogsController extends Controller
{
    protected $service;

    public function __construct(NotaryRelaasLogsService $service)
    {
        $this->service = $service;
    }

    public function index()
    {
        $logs = $this->service->getAll();
        return view('pages.BackOffice.RelaasAkta.AktaLogs.index', compact('logs'));
    }

    public function create()
    {
        $relaasAktas = NotaryRelaasAkta::with('notaris', 'client')->where('deleted_at', null)->get();
        return view('pages.BackOffice.RelaasAkta.AktaLogs.form', compact('relaasAktas'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'relaas_id' => 'required|integer',
            'step' => 'required|string',
            'note' => 'nullable|string',
        ], [
            'relaas_id.required' => 'Relaas Akta harus dipilih.',
            'step.required' => 'Langkah harus diisi.',
        ]);

        $relaas = NotaryRelaasAkta::find(
            $validated['relaas_id']
        );

        $this->service->create([
            'notaris_id' => $relaas->notaris_id,
            'client_id' => $relaas->client_id,
            'registration_code' => $relaas->registration_code,
            'relaas_id' => $validated['relaas_id'],
            'step' => $validated['step'],
            'note' => $validated['note'],
        ]);
        notyf()->position('x', 'right')->position('y', 'top')->success('Relaas Log berhasil ditambahkan.');
        return redirect()->route('relaas-logs.index');
    }

    public function edit($id)
    {
        $data = $this->service->findById($id);
        $relaasAktas = NotaryRelaasAkta::with('notaris', 'client')->where('deleted_at', null)->get();
        return view('pages.BackOffice.RelaasAkta.AktaLogs.form', compact('data', 'relaasAktas'));
    }

    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'relaas_id' => 'required|integer',
            'step' => 'required|string',
            'note' => 'nullable|string',
        ], [
            'relaas_id.required' => 'Relaas Akta harus dipilih.',
            'step.required' => 'Langkah harus diisi.',
        ]);

        $this->service->update($id, $validated);
        notyf()->position('x', 'right')->position('y', 'top')->success('Relaas Log berhasil diperbarui.');
        return redirect()->route('relaas-logs.index');
    }

    public function destroy($id)
    {
        $this->service->delete($id);
        notyf()->position('x', 'right')->position('y', 'top')->success('Relaas Log berhasil dihapus.');
        return redirect()->route('relaas-logs.index');
    }
}
