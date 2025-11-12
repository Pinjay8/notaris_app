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

    // public function store(Request $request)
    // {
    //     $data = $request->validate(
    //         [
    //             // 'notaris_id' => 'required|exists:notaris,id',
    //             'category' => 'required|in:pendirian,perubahan,pemutusan',
    //             'type' => 'required|string',
    //             'description' => 'nullable|string',
    //             'documents' => 'nullable|string',
    //         ],
    //         [
    //             'category.required' => 'Kategori akta harus dipilih.',
    //             'type.required' => 'Tipe akta harus diisi.',
    //         ]
    //     );

    //     $data['notaris_id'] = auth()->user()->notaris_id;

    //     $this->service->create($data);
    //     notyf()->position('x', 'right')->position('y', 'top')->success('Berhasil menambahkan akta type.');
    //     return redirect()->route('akta-types.index');
    // }

    public function edit($id)
    {
        $aktaType = $this->service->get($id);
        $notaris = Notaris::whereNull('deleted_at')->get();
        return view('pages.BackOffice.AktaType.form', compact('aktaType', 'notaris'));
    }

    public function update(Request $request, $id)
    {
        $data = $request->validate([
            // 'notaris_id' => 'required|exists:notaris,id',
            'category' => 'nullable',
            'other_category' => 'nullable|string|max:50',
            'type' => 'nullable|string',
            'description' => 'nullable|string',
            'documents' => 'required|string',
        ]);

        $data['notaris_id'] = auth()->user()->notaris_id;

        if ($data['category'] === 'lainnya' && $request->filled('other_category')) {
            $data['category'] = $request->other_category;
        }

        $this->service->update($id, $data);
        notyf()->position('x', 'right')->position('y', 'top')->success('Berhasil memperbarui tipe akta.');
        return redirect()->route('akta-types.index');
    }
    public function destroy($id)
    {
        $this->service->delete($id);
        notyf()->position('x', 'right')->position('y', 'top')->success('Berhasil menghapus akta type.');
        return redirect()->route('akta-types.index');
    }

    public function store(Request $request)
    {
        $data = $request->validate(
            [
                'category' => 'required|string',
                'other_category' => 'nullable|string|max:50',
                'type' => 'required|string',
                'description' => 'nullable|string',
                'documents' => 'nullable|string',
            ],
            [
                'category.required' => 'Kategori akta harus dipilih.',
                'type.required' => 'Tipe akta harus diisi.',
            ]
        );

        // Kalau user pilih "lainnya" dan isi kategori manual,
        // maka simpan hasil inputnya ke field category
        if ($data['category'] === 'lainnya' && $request->filled('other_category')) {
            $data['category'] = $request->other_category;
        }

        // Tambahkan notaris_id dari user login
        $data['notaris_id'] = auth()->user()->notaris_id;

        // Simpan data melalui service
        $this->service->create($data);

        notyf()->position('x', 'right')->position('y', 'top')->success('Berhasil menambahkan akta type.');
        return redirect()->route('akta-types.index');
    }
}
