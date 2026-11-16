@extends('layouts.app')

@section('content')
    <div class="page-head">
        <div>
            <h1>Ubah Piringan Hitam: {{ $product->title }}</h1>
            <p class="subtitle">Perbarui data album berikut.</p>
        </div>
    </div>

    <div class="card">
        @include('products._form', [
            'product' => $product,
            'categories' => $categories,
            'action' => route('products.update', $product),
            'method' => 'PUT',
            'submitLabel' => 'Perbarui Piringan Hitam',
        ])
    </div>
@endsection
