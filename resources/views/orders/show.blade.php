@extends('layouts.app')

@section('content')
    <div class="page-head">
        <div>
            <h1>Pesanan: {{ $order->buyer_name }}</h1>
            <p class="subtitle">Detail pembelian piringan hitam.</p>
        </div>
        <div class="actions-row">
            <a href="{{ route('orders.edit', $order) }}" class="btn">Ubah</a>
            <a href="{{ route('orders.index') }}" class="btn">Kembali</a>
        </div>
    </div>

    <div class="card">
        @php $labels = ['pending' => 'Menunggu Pembayaran', 'paid' => 'Dibayar', 'shipped' => 'Dikirim']; @endphp
        <dl class="detail">
            <dt>Pembeli</dt>
            <dd>{{ $order->buyer_name }}</dd>
            <dt>Telepon</dt>
            <dd>{{ $order->buyer_phone }}</dd>
            <dt>Piringan Hitam</dt>
            <dd><a href="{{ route('products.show', $order->product) }}">{{ $order->product->title }} &mdash; {{ $order->product->artist }}</a> ({{ $order->product->category->name }})</dd>
            <dt>Jumlah</dt>
            <dd>{{ $order->quantity }}</dd>
            <dt>Harga Satuan</dt>
            <dd>Rp {{ number_format($order->unit_price, 0, ',', '.') }}</dd>
            <dt>Total Harga</dt>
            <dd><strong>Rp {{ number_format($order->total_price, 0, ',', '.') }}</strong></dd>
            <dt>Tanggal Pesanan</dt>
            <dd>{{ $order->order_date->format('d M Y') }}</dd>
            <dt>Status</dt>
            <dd><span class="badge badge-{{ $order->status }}">{{ $labels[$order->status] }}</span></dd>
        </dl>
    </div>
@endsection
