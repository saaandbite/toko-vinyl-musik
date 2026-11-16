@extends('layouts.app')

@section('content')
    <div class="page-head">
        <div>
            <h1>Tambah Genre</h1>
            <p class="subtitle">Isi form berikut untuk menambahkan genre baru.</p>
        </div>
    </div>

    <div class="card">
        @include('categories._form', [
            'category' => new \App\Models\Category,
            'action' => route('categories.store'),
            'method' => 'POST',
            'submitLabel' => 'Simpan Genre',
        ])
    </div>
@endsection
