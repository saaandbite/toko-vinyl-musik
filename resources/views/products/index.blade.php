@extends('layouts.app')

@section('content')
    <div class="page-head">
        <div>
            <h1>Piringan Hitam</h1>
            <p class="subtitle">Katalog album, harga, dan stok toko.</p>
        </div>
        <a href="{{ route('products.create') }}" class="btn btn-primary">+ Tambah Piringan Hitam</a>
    </div>

    @if ($products->isEmpty())
        <div class="card"><p class="empty">Belum ada piringan hitam. <a href="{{ route('products.create') }}">Tambah yang pertama</a>.</p></div>
    @else
        <div class="table-wrap">
            <table>
                <thead>
                    <tr>
                        <th>SKU</th>
                        <th>Judul Album</th>
                        <th>Artis</th>
                        <th>Genre</th>
                        <th>Harga</th>
                        <th>Stok</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($products as $product)
                        <tr>
                            <td>{{ $product->sku }}</td>
                            <td><a href="{{ route('products.show', $product) }}">{{ $product->title }}</a></td>
                            <td>{{ $product->artist }}</td>
                            <td>{{ $product->category->name }}</td>
                            <td>Rp {{ number_format($product->price, 0, ',', '.') }}</td>
                            <td>
                                @if ($product->stock <= 5)
                                    <span class="badge badge-low">{{ $product->stock }}</span>
                                @else
                                    {{ $product->stock }}
                                @endif
                            </td>
                            <td>
                                <div class="actions-row">
                                    <a href="{{ route('products.edit', $product) }}" class="btn btn-small">Ubah</a>
                                    <form action="{{ route('products.destroy', $product) }}" method="POST" onsubmit="return confirm('Hapus piringan hitam {{ $product->title }}?')">
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
        {{ $products->links() }}
    @endif
@endsection
