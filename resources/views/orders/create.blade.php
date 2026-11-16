@extends('layouts.app')

@section('content')
    <div class="page-head">
        <div>
            <h1>Buat Pesanan</h1>
            <p class="subtitle">Catat pembelian piringan hitam. Stok akan berkurang otomatis.</p>
        </div>
    </div>

    <div class="card">
        @include('orders._form', [
            'order' => new \App\Models\Order,
            'products' => $products,
            'action' => route('orders.store'),
            'method' => 'POST',
            'submitLabel' => 'Simpan Pesanan',
        ])
    </div>
@endsection
