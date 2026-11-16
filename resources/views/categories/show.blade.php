@extends('layouts.app')

@section('content')
    <div class="page-head">
        <div>
            <h1>Genre: {{ $category->name }}</h1>
            <p class="subtitle">Detail genre dan piringan hitam di dalamnya.</p>
        </div>
        <div class="actions-row">
            <a href="{{ route('categories.edit', $category) }}" class="btn">Ubah</a>
            <a href="{{ route('categories.index') }}" class="btn">Kembali</a>
        </div>
    </div>

    <div class="card">
        <dl class="detail">
            <dt>Nama</dt>
            <dd>{{ $category->name }}</dd>
            <dt>Deskripsi</dt>
            <dd>{{ $category->description ?? '—' }}</dd>
            <dt>Jumlah Piringan Hitam</dt>
            <dd>{{ $category->products->count() }}</dd>
        </dl>
    </div>

    <div class="card">
        <h2 style="margin-top:0;">Piringan Hitam dalam Genre Ini</h2>
        @if ($category->products->isEmpty())
            <p class="empty">Belum ada piringan hitam dalam genre ini.</p>
        @else
            <div class="table-wrap">
                <table>
                    <thead>
                        <tr>
                            <th>SKU</th>
                            <th>Judul Album</th>
                            <th>Artis</th>
                            <th>Harga</th>
                            <th>Stok</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($category->products as $product)
                            <tr>
                                <td>{{ $product->sku }}</td>
                                <td><a href="{{ route('products.show', $product) }}">{{ $product->title }}</a></td>
                                <td>{{ $product->artist }}</td>
                                <td>Rp {{ number_format($product->price, 0, ',', '.') }}</td>
                                <td>{{ $product->stock }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @endif
    </div>
@endsection
