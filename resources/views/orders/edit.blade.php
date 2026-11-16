@extends('layouts.app')

@section('content')
    <div class="page-head">
        <div>
            <h1>Ubah Pesanan: {{ $order->buyer_name }}</h1>
            <p class="subtitle">Perbarui data pesanan berikut. Stok akan disesuaikan otomatis.</p>
        </div>
    </div>

    <div class="card">
        @include('orders._form', [
            'order' => $order,
            'products' => $products,
            'action' => route('orders.update', $order),
            'method' => 'PUT',
            'submitLabel' => 'Perbarui Pesanan',
        ])
    </div>
@endsection
