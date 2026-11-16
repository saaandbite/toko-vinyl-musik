@extends('layouts.app')

@section('content')
    <div class="page-head">
        <div>
            <h1>Genre</h1>
            <p class="subtitle">Daftar genre piringan hitam di toko.</p>
        </div>
        <a href="{{ route('categories.create') }}" class="btn btn-primary">+ Tambah Genre</a>
    </div>

    @if ($categories->isEmpty())
        <div class="card"><p class="empty">Belum ada genre. <a href="{{ route('categories.create') }}">Tambah genre pertama</a>.</p></div>
    @else
        <div class="table-wrap">
            <table>
                <thead>
                    <tr>
                        <th>Nama</th>
                        <th>Deskripsi</th>
                        <th>Piringan Hitam</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($categories as $category)
                        <tr>
                            <td><a href="{{ route('categories.show', $category) }}">{{ $category->name }}</a></td>
                            <td>{{ $category->description ?? '—' }}</td>
                            <td>{{ $category->products_count }}</td>
                            <td>
                                <div class="actions-row">
                                    <a href="{{ route('categories.edit', $category) }}" class="btn btn-small">Ubah</a>
                                    <form action="{{ route('categories.destroy', $category) }}" method="POST" onsubmit="return confirm('Hapus genre {{ $category->name }}?')">
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
        {{ $categories->links() }}
    @endif
@endsection
