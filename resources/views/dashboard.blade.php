@extends('layouts.app')

@section('content')
    <div class="page-head">
        <div>
            <h1>Dashboard</h1>
            <p class="subtitle">Ringkasan toko: genre, katalog piringan hitam, dan pesanan.</p>
        </div>
    </div>

    <div class="stats">
        <div class="stat">
            <div class="num">{{ $categoryCount }}</div>
            <div class="lbl">Genre</div>
        </div>
        <div class="stat">
            <div class="num">{{ $productCount }}</div>
            <div class="lbl">Piringan Hitam</div>
        </div>
        <div class="stat">
            <div class="num">{{ $orderCount }}</div>
            <div class="lbl">Pesanan</div>
        </div>
    </div>

    <div class="card">
        <h2 style="margin-top:0;">Stok Menipis (&#8804; 5)</h2>
        @if ($lowStockProducts->isEmpty())
            <p class="empty">Tidak ada piringan hitam dengan stok menipis.</p>
        @else
            <div class="table-wrap">
                <table>
                    <thead>
                        <tr>
                            <th>SKU</th>
                            <th>Judul Album</th>
                            <th>Artis</th>
                            <th>Stok</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($lowStockProducts as $product)
                            <tr>
                                <td>{{ $product->sku }}</td>
                                <td><a href="{{ route('products.show', $product) }}">{{ $product->title }}</a></td>
                                <td>{{ $product->artist }}</td>
                                <td><span class="badge badge-low">{{ $product->stock }}</span></td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @endif
    </div>

    <div class="card">
        <h2 style="margin-top:0;">Pesanan Terbaru</h2>
        @if ($latestOrders->isEmpty())
            <p class="empty">Belum ada pesanan. <a href="{{ route('orders.create') }}">Buat pesanan pertama</a>.</p>
        @else
            <div class="table-wrap">
                <table>
                    <thead>
                        <tr>
                            <th>Pembeli</th>
                            <th>Piringan Hitam</th>
                            <th>Jumlah</th>
                            <th>Total</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($latestOrders as $order)
                            <tr>
                                <td><a href="{{ route('orders.show', $order) }}">{{ $order->buyer_name }}</a></td>
                                <td>{{ $order->product->title }} &mdash; {{ $order->product->artist }}</td>
                                <td>{{ $order->quantity }}</td>
                                <td>Rp {{ number_format($order->total_price, 0, ',', '.') }}</td>
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
