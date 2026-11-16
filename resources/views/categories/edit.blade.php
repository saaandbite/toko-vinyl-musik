@extends('layouts.app')

@section('content')
    <div class="page-head">
        <div>
            <h1>Ubah Genre: {{ $category->name }}</h1>
            <p class="subtitle">Perbarui data genre berikut.</p>
        </div>
    </div>

    <div class="card">
        @include('categories._form', [
            'category' => $category,
            'action' => route('categories.update', $category),
            'method' => 'PUT',
            'submitLabel' => 'Perbarui Genre',
        ])
    </div>
@endsection
