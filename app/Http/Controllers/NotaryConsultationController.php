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
    public function selectClient(Request $request)
    {
        $query = Client::where('notaris_id', auth()->user()->notaris_id);

        if ($request->has('search') && !empty($request->search)) {
            $query->where('fullname', 'like', '%' . $request->search . '%');
        }

        // gunakan paginate, bukan get
        $clients = $query->paginate(10);

        return view('pages.Client.Consultation.selectClient', compact('clients'));
    }


    public function index(Request $request)
    {
        $query = Client::where('notaris_id', auth()->user()->notaris_id);

        if ($request->filled('search')) {
            $query->where('fullname', 'like', '%' . $request->search . '%');
        }

        // paginate + bawa query string pencarian
        $clients = $query->paginate(10)->withQueryString();

        return view('pages.Client.Consultation.index', compact('clients'));
    }

    public function getConsultationByClient($id)
    {
        $client = Client::findOrFail($id);

        // Gunakan paginate untuk pagination
        $notaryConsultations = NotaryConsultation::where('client_code', $client->client_code)
            ->latest()
            ->paginate(10) // tampilkan 10 per halaman
            ->withQueryString();
        // dd($notaryConsultations);

        return view('pages.Client.Consultation.consultation', compact('notaryConsultations', 'client'));
    }

    public function create(Request $request)
    {
        $notarisId = auth()->user()->notaris_id;

        $clientId = $request->client_id;
        $client = Client::find($clientId);

        return view('pages.Client.Consultation.form', compact('client'));
    }

    // public function store(Request $request)
    // {
    //     $this->notaryConsultationService->create($request->all());

    //     // Ambil client_id dari client_code
    //     $client = Client::where('client_code', $request->client_code)->first();
    //     $clientId = $client ? $client->id : null;

    //     notyf()->position('x', 'right')->position('y', 'top')
    //         ->success('Konsultasi nama ' . ($client->fullname ?? '') . ' berhasil ditambahkan');

    //     return redirect()->route('consultation.getConsultationByClient', ['id' => $clientId]);
    // }

    public function store(Request $request)
    {
        $client = Client::findOrFail($request->client_id);

        $data = $request->all();
        $data['client_code'] = $client->client_code;
        $data['notaris_id'] = $client->notaris_id;

        $this->notaryConsultationService->create($data);

        notyf()->position('x', 'right')->position('y', 'top')->success('Konsultasi untuk ' . $client->fullname . ' berhasil ditambahkan');

        return redirect()->route('consultation.getConsultationByClient', ['id' => $client->id]);
    }


    public function edit($id)
    {
        $notaryConsultation = $this->notaryConsultationService->findById($id);
        $notarisId = auth()->user()->notaris_id;
        $client = Client::where('client_code', $notaryConsultation->client_code)->first();

        // Jangan lupa pass juga registration_code jika mau tampilkan di form
        $registrationCode = $notaryConsultation->registration_code;

        return view('pages.Client.Consultation.form', compact('notaryConsultation', 'client'));
    }
    public function update(Request $request, $id)
    {
        // Update konsultasi
        $result = $this->notaryConsultationService->update($id, $request->all());

        // Ambil client_code dari client_code
        $client = Client::where('client_code', $request->client_code)->first();
        $clientId = $client ? $client->id : null;

        notyf()->position('x', 'right')->position('y', 'top')
            ->success('Konsultasi berhasil diperbarui');

        return redirect()->route('consultation.getConsultationByClient', ['id' => $clientId]);
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

        // Ambil data konsultasi supaya dapat notaris_id, client_code, registration_code
        $consultation = $this->notaryConsultationService->findById($consultationId);
        // dd($consultation);

        if (!$consultation) {
            return redirect()->back()->with('error', 'Konsultasi tidak ditemukan.');
        }

        $completedAt = ($validated['status'] ?? '') === 'done' ? now() : null;
        NotaryClientProduct::create([
            'notaris_id' => $consultation->notaris_id,
            'client_code' => $consultation->client_code,
            'registration_code' => $consultation->registration_code,
            'product_id' => $validated['product_id'],
            'note' => $validated['note'] ?? null,
            'status' => $validated['status'] ?? 'pending',
            'completed_at' => $completedAt,
        ]);


        notyf()->position('x', 'right')->position('y', 'top')->success('Produk berhasil ditambahkan');
        return redirect()->route('consultation.detail', ['id' => $consultationId]);
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
