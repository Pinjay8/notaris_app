<?php

namespace App\Http\Controllers;

use App\Models\Documents;
use App\Models\Product;
use App\Models\ProductDocuments;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ProductDocumentsController extends Controller
{
    public function selectProduct()
    {
        $products = Product::all();
        return view('pages.ProductDocument.index', compact('products'));
    }

    public function index(Product $product)
    {
        $availableDocuments = Documents::all();
        $documents = $product->documents;

        return view('pages.ProductDocument.document', compact('product', 'availableDocuments', 'documents'));
    }


    public function store(Request $request, Product $product)
    {
        $request->validate(
            [
                'document_code' => 'required',
                'description' => 'required|string',
                'status' => 'required'
            ],
            [
                'document_code.required' => 'Dokumen harus diisi.',
                'description.required' => 'Catatan dokumen harus diisi.',
                'status.required' => 'Status dokumen harus diisi.',
            ]
        );

        $product->documents()->attach($request->document_code, [
            'description' => $request->description,
            'status' => $request->status
        ]);

        notyf()->position('x', 'right')->position('y', 'top')->success('Dokumen berhasil ditambahkan');
        return back();
    }


    public function update(Request $request, Product $product, Documents $document)
    {
        $validator = Validator::make(
            $request->all(),
            [
                'description' => 'required|string',
                'status' => 'required'
            ],
            [
                'description.required' => 'Catatan dokumen harus diisi.',
                'status.required' => 'Status dokumen harus diisi.',
            ]
        );


        $product->documents()->updateExistingPivot($document->id, [
            'description' => $request->description,
            'status' => $request->status
        ]);

        notyf()->position('x', 'right')->position('y', 'top')->success('Dokumen berhasil diubah');
        return back();
    }

    public function destroy(Product $product, Documents $document)
    {
        $product->documents()->detach($document->id);

        notyf()->position('x', 'right')->position('y', 'top')->success('Dokumen berhasil dihapus');
        return back();
    }
}
