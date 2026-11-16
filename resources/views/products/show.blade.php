@extends('layouts.app')

@section('content')
    <div class="page-head">
        <div>
            <h1>{{ $product->title }}</h1>
            <p class="subtitle">{{ $product->artist }} &mdash; {{ $product->category->name }}</p>
        </div>
        <div class="actions-row">
            <a href="{{ route('products.edit', $product) }}" class="btn">Ubah</a>
            <a href="{{ route('products.index') }}" class="btn">Kembali</a>
        </div>
    </div>

    <div class="card">
        <dl class="detail">
            <dt>SKU</dt>
            <dd>{{ $product->sku }}</dd>
            <dt>Judul Album</dt>
            <dd>{{ $product->title }}</dd>
            <dt>Artis</dt>
            <dd>{{ $product->artist }}</dd>
            <dt>Genre</dt>
            <dd><a href="{{ route('categories.show', $product->category) }}">{{ $product->category->name }}</a></dd>
            <dt>Harga</dt>
            <dd>Rp {{ number_format($product->price, 0, ',', '.') }}</dd>
            <dt>Stok</dt>
            <dd>{{ $product->stock }}</dd>
            <dt>Jumlah Pesanan</dt>
            <dd>{{ $product->orders->count() }}</dd>
        </dl>
    </div>

    <div class="card">
        <h2 style="margin-top:0;">Pesanan untuk Album Ini</h2>
        @if ($product->orders->isEmpty())
            <p class="empty">Belum ada pesanan untuk album ini.</p>
        @else
            <div class="table-wrap">
                <table>
                    <thead>
                        <tr>
                            <th>Pembeli</th>
                            <th>Jumlah</th>
                            <th>Total</th>
                            <th>Tanggal</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($product->orders as $order)
                            <tr>
                                <td><a href="{{ route('orders.show', $order) }}">{{ $order->buyer_name }}</a></td>
                                <td>{{ $order->quantity }}</td>
                                <td>Rp {{ number_format($order->total_price, 0, ',', '.') }}</td>
                                <td>{{ $order->order_date->format('d M Y') }}</td>
                                <td>
                                    @php $labels = ['pending' => 'Menunggu Pembayaran', 'paid' => 'Dibayar', 'shipped' => 'Dikirim']; @endphp
                                    <span class="badge badge-{{ $order->status }}">{{ $labels[$order->status] }}</span>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @endif
    </div>
@endsection
