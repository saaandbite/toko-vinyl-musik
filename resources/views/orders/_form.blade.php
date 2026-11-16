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
        <label for="product_id">Piringan Hitam</label>
        <select id="product_id" name="product_id" required>
            <option value="">-- Pilih Piringan Hitam --</option>
            @foreach ($products as $item)
                <option value="{{ $item->id }}" @selected(old('product_id', $order->product_id) == $item->id)>{{ $item->title }} &mdash; {{ $item->artist }} (Stok: {{ $item->stock }}, Rp {{ number_format($item->price, 0, ',', '.') }})</option>
            @endforeach
        </select>
        @error('product_id')
            <p class="field-error">{{ $message }}</p>
        @enderror
    </div>

    <div class="field">
        <label for="buyer_name">Nama Pembeli</label>
        <input type="text" id="buyer_name" name="buyer_name" value="{{ old('buyer_name', $order->buyer_name) }}" maxlength="100" required>
        @error('buyer_name')
            <p class="field-error">{{ $message }}</p>
        @enderror
    </div>

    <div class="field">
        <label for="buyer_phone">Nomor Telepon Pembeli</label>
        <input type="text" id="buyer_phone" name="buyer_phone" value="{{ old('buyer_phone', $order->buyer_phone) }}" maxlength="20" required>
        @error('buyer_phone')
            <p class="field-error">{{ $message }}</p>
        @enderror
    </div>

    <div class="field">
        <label for="quantity">Jumlah</label>
        <input type="number" id="quantity" name="quantity" value="{{ old('quantity', $order->quantity ?? 1) }}" min="1" step="1" required>
        <p class="hint">Jumlah tidak boleh melebihi stok yang tersedia.</p>
        @error('quantity')
            <p class="field-error">{{ $message }}</p>
        @enderror
    </div>

    <div class="field">
        <label for="order_date">Tanggal Pesanan</label>
        <input type="date" id="order_date" name="order_date" value="{{ old('order_date', $order->order_date?->format('Y-m-d') ?? date('Y-m-d')) }}" required>
        @error('order_date')
            <p class="field-error">{{ $message }}</p>
        @enderror
    </div>

    <div class="field">
        <label for="status">Status</label>
        <select id="status" name="status" required>
            @php $statusLabels = ['pending' => 'Menunggu Pembayaran', 'paid' => 'Dibayar', 'shipped' => 'Dikirim']; @endphp
            @foreach ($statusLabels as $value => $label)
                <option value="{{ $value }}" @selected(old('status', $order->status ?? 'pending') === $value)>{{ $label }}</option>
            @endforeach
        </select>
        @error('status')
            <p class="field-error">{{ $message }}</p>
        @enderror
    </div>

    <div class="form-actions">
        <button type="submit" class="btn btn-primary">{{ $submitLabel }}</button>
        <a href="{{ route('orders.index') }}" class="btn">Batal</a>
    </div>
</form>
