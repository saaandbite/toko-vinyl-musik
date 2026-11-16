@extends('layouts.app')

@section('content')
    <div class="page-head">
        <div>
            <h1>Pesanan</h1>
            <p class="subtitle">Daftar pembelian piringan hitam.</p>
        </div>
        <a href="{{ route('orders.create') }}" class="btn btn-primary">+ Buat Pesanan</a>
    </div>

    @if ($orders->isEmpty())
        <div class="card"><p class="empty">Belum ada pesanan. <a href="{{ route('orders.create') }}">Buat pesanan pertama</a>.</p></div>
    @else
        <div class="table-wrap">
            <table>
                <thead>
                    <tr>
                        <th>Pembeli</th>
                        <th>Piringan Hitam</th>
                        <th>Jumlah</th>
                        <th>Total</th>
                        <th>Tanggal</th>
                        <th>Status</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($orders as $order)
                        <tr>
                            <td><a href="{{ route('orders.show', $order) }}">{{ $order->buyer_name }}</a></td>
                            <td>{{ $order->product->title }} &mdash; {{ $order->product->artist }}</td>
                            <td>{{ $order->quantity }}</td>
                            <td>Rp {{ number_format($order->total_price, 0, ',', '.') }}</td>
                            <td>{{ $order->order_date->format('d M Y') }}</td>
                            <td>
                                @php $labels = ['pending' => 'Menunggu Pembayaran', 'paid' => 'Dibayar', 'shipped' => 'Dikirim']; @endphp
                                <span class="badge badge-{{ $order->status }}">{{ $labels[$order->status] }}</span>
                            </td>
                            <td>
                                <div class="actions-row">
                                    <a href="{{ route('orders.edit', $order) }}" class="btn btn-small">Ubah</a>
                                    <form action="{{ route('orders.destroy', $order) }}" method="POST" onsubmit="return confirm('Hapus pesanan {{ $order->buyer_name }}? Stok akan dikembalikan.')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-small btn-danger">Hapus</button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        {{ $orders->links() }}
    @endif
@endsection
