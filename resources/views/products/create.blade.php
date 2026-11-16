@extends('layouts.app')

@section('content')
    <div class="page-head">
        <div>
            <h1>Tambah Piringan Hitam</h1>
            <p class="subtitle">Isi form berikut untuk menambahkan album ke katalog.</p>
        </div>
    </div>

    <div class="card">
        @include('products._form', [
            'product' => new \App\Models\Product,
            'categories' => $categories,
            'action' => route('products.store'),
            'method' => 'POST',
            'submitLabel' => 'Simpan Piringan Hitam',
        ])
    </div>
@endsection
