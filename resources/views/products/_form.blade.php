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
        <label for="category_id">Genre</label>
        <select id="category_id" name="category_id" required>
            <option value="">-- Pilih Genre --</option>
            @foreach ($categories as $category)
                <option value="{{ $category->id }}" @selected(old('category_id', $product->category_id) == $category->id)>{{ $category->name }}</option>
            @endforeach
        </select>
        @error('category_id')
            <p class="field-error">{{ $message }}</p>
        @enderror
    </div>

    <div class="field">
        <label for="sku">SKU</label>
        <input type="text" id="sku" name="sku" value="{{ old('sku', $product->sku) }}" maxlength="20" required>
        <p class="hint">Kode unik produk, maksimal 20 karakter. Contoh: VNL-ROCK-001</p>
        @error('sku')
            <p class="field-error">{{ $message }}</p>
        @enderror
    </div>

    <div class="field">
        <label for="title">Judul Album</label>
        <input type="text" id="title" name="title" value="{{ old('title', $product->title) }}" maxlength="100" required>
        @error('title')
            <p class="field-error">{{ $message }}</p>
        @enderror
    </div>

    <div class="field">
        <label for="artist">Artis</label>
        <input type="text" id="artist" name="artist" value="{{ old('artist', $product->artist) }}" maxlength="100" required>
        @error('artist')
            <p class="field-error">{{ $message }}</p>
        @enderror
    </div>

    <div class="field">
        <label for="price">Harga (Rp)</label>
        <input type="number" id="price" name="price" value="{{ old('price', $product->price) }}" min="0" step="0.01" required>
        @error('price')
            <p class="field-error">{{ $message }}</p>
        @enderror
    </div>

    <div class="field">
        <label for="stock">Stok</label>
        <input type="number" id="stock" name="stock" value="{{ old('stock', $product->stock) }}" min="0" step="1" required>
        @error('stock')
            <p class="field-error">{{ $message }}</p>
        @enderror
    </div>

    <div class="form-actions">
        <button type="submit" class="btn btn-primary">{{ $submitLabel }}</button>
        <a href="{{ route('products.index') }}" class="btn">Batal</a>
    </div>
</form>
