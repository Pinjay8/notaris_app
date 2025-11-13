<?php

namespace App\Http\Controllers;

use App\Models\RelaasType;
use Illuminate\Http\Request;

class RelaasTypeController extends Controller
{
    public function index()
    {
        $notarisId = auth()->user()->notaris_id;
        $aktaTypes  = RelaasType::where('notaris_id', $notarisId)->orderBy('created_at', 'desc')->paginate(10);

        return view('pages.BackOffice.RelaasAkta.AktaType.index', compact('aktaTypes'));
    }

    public function create()
    {
        return view('pages.BackOffice.RelaasAkta.AktaType.form'); // form untuk create
    }

    public function store(Request $request)
    {
        // dd($request->all());
        $validated = $request->validate(
            [
                'category' => 'required|string|max:255',
                'other_category' => 'nullable|string|max:50',
                'type' => 'required|string|max:255',
                'description' => 'nullable|string',
                'documents' => 'nullable',
            ],
            [
                'category.required' => 'Kategori akta harus dipilih.',
                'type.required' => 'Tipe akta harus diisi.',
            ]
        );

        if ($validated['category'] === 'lainnya' && $request->filled('other_category')) {
            $validated['category'] = $request->other_category;
        }

        $validated['notaris_id'] = auth()->user()->notaris_id;


        RelaasType::create($validated);

        notyf()->position('x', 'right')->position('y', 'top')->success('Jenis akta berhasil ditambahkan.');
        return redirect()->route('relaas-types.index');
    }


    public function edit(RelaasType $relaasType)
    {
        return view('pages.BackOffice.RelaasAkta.AktaType.form', compact('relaasType'));
    }

    public function update(Request $request, RelaasType $relaasType)
    {
        $validated = $request->validate([
            'category' => 'required|string|max:255',
            'other_category' => 'nullable|string|max:50',
            'type' => 'required|string|max:255',
            'description' => 'nullable|string',
            'documents' => 'nullable',
        ]);

        if ($validated['category'] === 'lainnya' && $request->filled('other_category')) {
            $validated['category'] = $request->other_category;
        }

        // if ($request->hasFile('documents')) {
        //     $validated['documents'] = $request->file('documents')->storeAs('documents', $request->file('documents')->getClientOriginalName());
        // }

        $relaasType->update($validated);

        notyf()->position('x', 'right')->position('y', 'top')->success('Jenis akta berhasil diubah.');

        return redirect()->route('relaas-types.index');
    }

    public function destroy(RelaasType $relaasType)
    {
        $relaasType->delete();

        notyf()->position('x', 'right')->position('y', 'top')->success('Jenis akta berhasil dihapus.');
        return redirect()->route('relaas-types.index');
    }
}
