<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProductRequest;
use App\Models\Product;
use App\Services\ProductService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ProductsController extends Controller
{
    public function __construct(protected ProductService $productService) {}

    public function index(Request $request)
    {
        $search = $request->input('search');
        $status = $request->input('status', '1'); // default = 1 (aktif)

        $products = $this->productService->getAll($search, $status);

        return view('pages.Products.index', compact('products'));
    }

    public function create()
    {
        return view('pages.Products.form');
    }

    public function store(ProductRequest $request)
    {
        $validated = $request->validated();

        if ($request->hasFile('image')) {
            $validated['image'] = $request->file('image')->storeAs('img', $request->file('image')->getClientOriginalName());
        }

        $this->productService->createProduct($validated);

        notyf()->position('x', 'right')->position('y', 'top')->success('Berhasil menambahkan data layanan');

        return redirect()->route('products.index');
    }

    public function edit(Product $product)
    {
        return view('pages.Products.form', compact('product'));
    }


    public function update(ProductRequest $request, Product $product)
    {
        $validated = $request->validated();

        $productPath = $product->image;

        if ($request->hasFile('image')) {
            if ($productPath) {
                Storage::delete($productPath);
            }
            $validated['image'] = $request->file('image')->storeAs("img", $request->file('image')->getClientOriginalName());
        } else {
            $validated['image'] = $productPath;
        }

        $this->productService->updateProduct($product, $validated);

        notyf()->position('x', 'right')->position('y', 'top')->success('Berhasil mengubah data layanan');
        return redirect()->route('products.index');
    }

    public function deactivate($id)
    {
        try {
            $this->productService->deactivate($id);
            return redirect()->route('products.index')->with('success', 'Layanan berhasil dinonaktifkan.');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', $e->getMessage());
        }
    }
}
