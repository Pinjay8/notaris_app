<?php

namespace App\Http\Controllers;

use App\Models\Client;
use App\Models\PicStaff;
use App\Services\PicStaffService;
use Illuminate\Http\Request;

class PicStaffController extends Controller
{
    protected $service;

    public function __construct(PicStaffService $service)
    {
        $this->service = $service;
    }

    public function index(Request $request)
    {
        $search = $request->input('search');
        $picStaffs = $this->service->getAll($search);

        return view('pages.PIC.PicStaff.index', compact('picStaffs', 'search'));
    }

    public function create()
    {
        return view('pages.PIC.PicStaff.form');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            // 'notaris_id'   => 'required|exists:notaris,id',
            'full_name'    => 'required|string|max:255',
            'email'        => 'required|email',
            'phone_number' => 'required|string|max:50',
            'position'     => 'required|string|max:100',
            'address'      => 'required|string|max:255',
            'note'         => 'nullable|string|max:255',
        ]);

        $validated['notaris_id'] = auth()->user()->notaris_id;

        $this->service->store($validated);

        notyf()->position('x', 'right')->position('y', 'top')->success('PIC Staff berhasil ditambahkan.');
        return redirect()->route('pic_staff.index');
    }

    public function edit(PicStaff $pic_staff)
    {
        return view('pages.PIC.PicStaff.form', compact('pic_staff'));
    }

    public function update(Request $request, PicStaff $pic_staff)
    {
        $validated = $request->validate([
            // 'notaris_id'   => 'required|exists:notaris,id',
            'full_name'    => 'required|string|max:255',
            'email'        => 'required|email',
            'phone_number' => 'required|string|max:50',
            'position'     => 'required|string|max:100',
            'address'      => 'required|string|max:255',
            'note'         => 'nullable|string|max:255',
        ]);

        $validated['notaris_id'] = auth()->user()->notaris->id;

        $this->service->update($pic_staff, $validated);

        notyf()->position('x', 'right')->position('y', 'top')->success('PIC Staff berhasil diperbarui.');
        return redirect()->route('pic_staff.index');
    }

    public function destroy(PicStaff $pic_staff)
    {
        $this->service->destroy($pic_staff);

        notyf()->position('x', 'right')->position('y', 'top')->success('PIC Staff berhasil dihapus.');
        return redirect()->route('pic_staff.index');
    }
}
