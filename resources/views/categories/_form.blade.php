@if ($errors->any())
    <div class="alert alert-error">
        <strong>Periksa kembali isian berikut:</strong>
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

<form action="{{ $action }}" method="POST">
    @csrf
    @if ($method !== 'POST')
        @method($method)
    @endif

    <div class="field">
        <label for="name">Nama Genre</label>
        <input type="text" id="name" name="name" value="{{ old('name', $category->name) }}" maxlength="100" required>
        @error('name')
            <p class="field-error">{{ $message }}</p>
        @enderror
    </div>

    <div class="field">
        <label for="description">Deskripsi</label>
        <textarea id="description" name="description" rows="3">{{ old('description', $category->description) }}</textarea>
        <p class="hint">Boleh dikosongkan.</p>
        @error('description')
            <p class="field-error">{{ $message }}</p>
        @enderror
    </div>

    <div class="form-actions">
        <button type="submit" class="btn btn-primary">{{ $submitLabel }}</button>
        <a href="{{ route('categories.index') }}" class="btn">Batal</a>
    </div>
</form>
