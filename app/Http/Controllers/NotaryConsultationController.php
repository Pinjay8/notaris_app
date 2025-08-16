<?php

namespace App\Http\Controllers;

use App\Models\Client;
use App\Models\NotaryClientProduct;
use App\Models\NotaryConsultation;
use App\Models\Product;
use App\Services\NotaryConsultationService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class NotaryConsultationController extends Controller
{
    protected $notaryConsultationService;

    public function __construct(NotaryConsultationService $notaryConsultationService)
    {
        $this->notaryConsultationService = $notaryConsultationService;
    }

    public function selectClient()
    {
        // $notarisId = auth()->user()->notaris_id;
        // $clients = Client::where('notaris_id', $notarisId)->get();
        $clients = Client::all();
        return view('pages.Client.Consultation.selectClient', compact('clients'));
    }


    public function index()
    {
        $notarisId = auth()->user()->notaris_id;
        $clients = Client::where('notaris_id', $notarisId)->get();
        return view('pages.Client.Consultation.index', compact('clients'));
    }

    public function getConsultationByClient($id)
    {
        $client = Client::findOrFail($id);
        $notaryConsultations = NotaryConsultation::where('client_id', $client->id)->get();
        return view('pages.Client.Consultation.consultation', compact('notaryConsultations', 'client'));
    }

    public function create()
    {
        $notarisId = auth()->user()->notaris_id;

        // Ambil semua client untuk dropdown
        $clients = Client::where('notaris_id', $notarisId)->get();

        // Generate registration code dari service
        $registrationCode = $this->notaryConsultationService->generateRegistrationCode($notarisId);

        return view('pages.Client.Consultation.form', compact('clients', 'registrationCode'));
    }

    public function store(Request $request)
    {
        $this->notaryConsultationService->create($request->all());
        notyf()->position('x', 'right')->position('y', 'top')->success('Konsultasi nama' . $request->client_id . ' berhasil ditambahkan');
        return redirect()->route('consultation.getConsultationByClient', ['id' => $request->client_id]);
    }

    public function show(NotaryConsultation $notaryConsultation) {}

    public function edit($id)
    {
        $notaryConsultation = $this->notaryConsultationService->findById($id);
        $notarisId = auth()->user()->notaris_id;
        $clients = Client::where('notaris_id', $notarisId)->get();

        // Jangan lupa pass juga registration_code jika mau tampilkan di form
        $registrationCode = $notaryConsultation->registration_code;

        return view('pages.Client.Consultation.form', compact('notaryConsultation', 'clients', 'registrationCode'));
    }

    public function update(Request $request, $id)
    {
        $result = $this->notaryConsultationService->update($id, $request->all());
        notyf()->position('x', 'right')->position('y', 'top')->success('Konsultasi berhasil diperbarui');
        return redirect()->route('consultation.getConsultationByClient', ['id' => $request->client_id]);
    }

    public function getConsultationByProduct(Request $request, $consultationId)
    {
        $consultation = $this->notaryConsultationService->findById($consultationId);
        // Ambil semua produk yang terkait konsultasi ini
        $notaryClientProduct = NotaryClientProduct::where('registration_code', $consultation->registration_code)->get();

        // Kirim consultationId langsung dari parameter untuk digunakan di view
        return view('pages.Client.Consultation.detail', [
            'notaryClientProduct' => $notaryClientProduct,
            'consultationId' => $consultationId,
            'consultation' => $consultation
        ]);
    }

    public function creates(Request $request, $consultationId)
    {
        $products = Product::all(); // ambil semua produk, sesuaikan namespace jika perlu
        $consultation = $this->notaryConsultationService->findById($consultationId);
        return view('pages.Client.Consultation.form-product', compact('consultationId', 'products', 'consultation'));
    }


    public function storeProduct(Request $request, $consultationId)
    {

        $validated = $request->validate([
            'product_id' => 'required',
            'note' => 'nullable',
            'status' => 'nullable', // tambah 'new' kalau memang status itu valid
        ]);

        // Ambil data konsultasi supaya dapat notaris_id, client_id, registration_code
        $consultation = $this->notaryConsultationService->findById($consultationId);
        // dd($consultation);

        if (!$consultation) {
            return redirect()->back()->with('error', 'Konsultasi tidak ditemukan.');
        }

        $completedAt = ($validated['status'] ?? '') === 'done' ? now() : null;
        NotaryClientProduct::create([
            'notaris_id' => $consultation->notaris_id,
            'client_id' => $consultation->client_id,
            'registration_code' => $consultation->registration_code,
            'product_id' => $validated['product_id'],
            'note' => $validated['note'] ?? null,
            'status' => $validated['status'] ?? 'pending',
            'completed_at' => $completedAt,
        ]);


        return redirect()->route('consultation.detail', ['id' => $consultationId])
            ->with('success', 'Produk berhasil ditambahkan.');
    }


    public function deleteProduct($consultationId, $productId)
    {
        $consultation = $this->notaryConsultationService->findById($consultationId);

        $product = NotaryClientProduct::where('registration_code', $consultation->registration_code)
            ->where('product_id', $productId)
            ->first();

        if (!$product) {
            return redirect()->back()->with('error', 'Produk tidak ditemukan.');
        }

        $product->delete();
        notyf()->position('x', 'right')->position('y', 'top')->success('Produk berhasil dihapus');
        return redirect()->route('consultation.detail', ['id' => $consultationId]);
    }
}
