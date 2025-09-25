@extends('layouts.app')

@section('content')
@include('layouts.navbars.auth.topnav', ['title' => isset($data) ? 'Edit Relaas Log' : 'Tambah Relaas Log'])

<div class="row mt-4 mx-4">
    <div class="col-12">
        <div class="card mb-4">
            <div class="card-header pb-0">
                <h6>{{ isset($data) ? 'Edit Relaas Log' : 'Tambah Relaas Log' }}</h6>
            </div>
            <div class="card-body px-4 pt-3 pb-2">
                <form action="{{ isset($data) ? route('relaas-logs.update', $data->id) : route('relaas-logs.store') }}"
                    method="POST">
                    @csrf
                    @if(isset($data)) @method('PUT') @endif


                    {{-- Relaas ID --}}
                    <div class="mb-3">
                        <label for="relaas_id" class="form-label">Relaas Akta</label>
                        <select name="relaas_id" id="relaas_id"
                            class="form-select @error('relaas_id') is-invalid @enderror">
                            <option value="" hidden>Pilih Relaas Akta</option>
                            @foreach($relaasAktas as $ra)
                            <option value="{{ $ra->id }}" {{ old('relaas_id', $data->relaas_id ?? '') == $ra->id ?
                                'selected' : '' }}>
                                {{ $ra->registration_code }} - {{ $ra->client->fullname }} ({{
                                $ra->notaris->display_name }}) - {{ $ra->title }}
                            </option>
                            @endforeach
                        </select>
                        @error('relaas_id')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror

                        {{-- Step --}}
                        <div class="mb-3">
                            <label for="step" class="form-label">Step</label>
                            <input type="text" name="step" id="step"
                                class="form-control @error('step') is-invalid @enderror"
                                value="{{ old('step', $data->step ?? '') }}">
                            @error('step')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        {{-- Note --}}
                        <div class="mb-3">
                            <label for="note" class="form-label">Catatan</label>
                            <textarea name="note" id="note" rows="3"
                                class="form-control @error('note') is-invalid @enderror">{{ old('note', $data->note ?? '') }}</textarea>
                            @error('note')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <a href="{{ route('relaas-logs.index') }}" class="btn btn-secondary">Kembali</a>

                        <button type="submit" class="btn btn-primary">
                            {{ isset($data) ? 'Update' : 'Simpan' }}
                        </button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection