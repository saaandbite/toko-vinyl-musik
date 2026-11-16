<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $title ?? 'Toko Vinyl Musik' }}</title>
    <style>
        * { box-sizing: border-box; }
        body { margin: 0; font-family: system-ui, -apple-system, "Segoe UI", sans-serif; background: #f6f4ef; color: #1f1a17; line-height: 1.5; }
        a { color: #9a6206; }
        .topbar { background: #1f1a17; color: #fff; padding: 14px 0; }
        .topbar .container { display: flex; align-items: center; justify-content: space-between; flex-wrap: wrap; gap: 8px; }
        .brand { font-size: 20px; font-weight: 700; color: #fff; text-decoration: none; }
        .brand span { color: #e8a33d; }
        nav a { color: #e8dcc8; text-decoration: none; margin-left: 18px; font-size: 15px; }
        nav a:hover, nav a.active { color: #e8a33d; }
        .container { max-width: 960px; margin: 0 auto; padding: 0 16px; }
        main.container { padding-top: 24px; padding-bottom: 48px; }
        h1 { font-size: 26px; margin: 0 0 4px; }
        .subtitle { color: #6b6259; margin: 0 0 20px; }
        .page-head { display: flex; align-items: flex-start; justify-content: space-between; gap: 12px; margin-bottom: 20px; flex-wrap: wrap; }
        .card { background: #fff; border: 1px solid #e3ddd2; border-radius: 10px; padding: 20px; margin-bottom: 20px; }
        .stats { display: grid; grid-template-columns: repeat(3, 1fr); gap: 16px; margin-bottom: 20px; }
        .stat { background: #fff; border: 1px solid #e3ddd2; border-radius: 10px; padding: 16px; }
        .stat .num { font-size: 32px; font-weight: 700; }
        .stat .lbl { color: #6b6259; font-size: 14px; }
        table { width: 100%; border-collapse: collapse; background: #fff; }
        th, td { text-align: left; padding: 10px 12px; border-bottom: 1px solid #ece6da; vertical-align: top; }
        th { background: #f1ece2; font-size: 13px; text-transform: uppercase; letter-spacing: .04em; }
        tr:last-child td { border-bottom: none; }
        .table-wrap { overflow-x: auto; border: 1px solid #e3ddd2; border-radius: 10px; background: #fff; }
        .btn { display: inline-block; padding: 8px 14px; border-radius: 8px; border: 1px solid #d8d0c0; background: #fff; color: #1f1a17; text-decoration: none; font-size: 14px; cursor: pointer; }
        .btn:hover { background: #f1ece2; }
        .btn-primary { background: #e8a33d; border-color: #e8a33d; color: #1f1a17; font-weight: 600; }
        .btn-primary:hover { background: #d9952a; }
        .btn-danger { background: #b3261e; border-color: #b3261e; color: #fff; }
        .btn-danger:hover { background: #9c1f18; }
        .btn-small { padding: 5px 10px; font-size: 13px; }
        .actions-row { display: flex; gap: 6px; flex-wrap: wrap; }
        .actions-row form { display: inline; }
        .alert { border-radius: 8px; padding: 12px 16px; margin-bottom: 20px; }
        .alert-success { background: #e6f4ea; border: 1px solid #a8d5b5; color: #1e6b34; }
        .alert-error { background: #fdecea; border: 1px solid #f5a9a2; color: #8f1d16; }
        .alert ul { margin: 8px 0 0; padding-left: 20px; }
        .field { margin-bottom: 16px; }
        .field label { display: block; font-weight: 600; margin-bottom: 6px; }
        .field input, .field select, .field textarea { width: 100%; padding: 9px 12px; border: 1px solid #cfc7b8; border-radius: 8px; font-size: 15px; background: #fff; }
        .field input:focus, .field select:focus, .field textarea:focus { outline: 2px solid #e8a33d; border-color: #e8a33d; }
        .field-error { color: #b3261e; font-size: 13px; margin: 4px 0 0; }
        .hint { color: #6b6259; font-size: 13px; margin-top: 4px; }
        .form-actions { display: flex; gap: 10px; margin-top: 20px; }
        .badge { display: inline-block; padding: 3px 10px; border-radius: 999px; font-size: 12px; font-weight: 600; }
        .badge-pending { background: #fef3c7; color: #92400e; }
        .badge-paid { background: #dcfce7; color: #166534; }
        .badge-shipped { background: #dbeafe; color: #1e40af; }
        .badge-low { background: #fdecea; color: #8f1d16; }
        .detail { display: grid; grid-template-columns: 180px 1fr; gap: 8px 16px; }
        .detail dt { font-weight: 600; color: #6b6259; }
        .detail dd { margin: 0; }
        .empty { text-align: center; color: #6b6259; padding: 32px 0; }
        .pagination { display: flex; gap: 6px; list-style: none; padding: 0; margin: 16px 0 0; }
        .pagination a, .pagination span { padding: 6px 12px; border: 1px solid #d8d0c0; border-radius: 6px; background: #fff; text-decoration: none; color: #1f1a17; }
        .pagination .active span { background: #e8a33d; border-color: #e8a33d; font-weight: 700; }
        footer { text-align: center; color: #6b6259; font-size: 13px; padding: 24px 0; }
        @media (max-width: 640px) { .stats { grid-template-columns: 1fr; } .detail { grid-template-columns: 1fr; } }
    </style>
</head>
<body>
    <header class="topbar">
        <div class="container">
            <a class="brand" href="{{ route('dashboard') }}">Toko <span>Vinyl</span> Musik</a>
            <nav>
                <a href="{{ route('dashboard') }}">Dashboard</a>
                <a href="{{ route('categories.index') }}">Genre</a>
                <a href="{{ route('products.index') }}">Piringan Hitam</a>
                <a href="{{ route('orders.index') }}">Pesanan</a>
            </nav>
        </div>
    </header>

    <main class="container">
        @if (session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        @if (session('error'))
            <div class="alert alert-error">{{ session('error') }}</div>
        @endif

        @yield('content')
    </main>

    <footer>
        Toko Vinyl Musik &mdash; Tugas Proyek Kecil, Teknologi Framework &mdash; Kelompok: Haris Sandi Purna Yudha &amp; Farhan Pratama
    </footer>
</body>
</html>
