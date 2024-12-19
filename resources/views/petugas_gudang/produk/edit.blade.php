<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Produk</title>
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <style>
        body {
            background: linear-gradient(135deg, #f5f7fa, #c3cfe2);
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }
        .navbar {
            background: #ffffff;
            border-bottom: 1px solid #e5e7eb;
        }
        .navbar-content {
            padding: 1rem;
        }
        .navbar h1 {
            font-size: 1.875rem;
            font-weight: 700;
            color: #333;
        }
        .navbar a {
            color: #4f46e5;
            text-decoration: none;
            margin-right: 1rem;
            font-weight: 600;
        }
        .navbar a.active {
            border-bottom: 2px solid #4f46e5;
        }
        .main-content {
            padding: 2rem;
        }
        .card {
            background: #ffffff;
            border-radius: 8px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
            padding: 2rem;
            margin-bottom: 2rem;
        }
        .card h2 {
            font-size: 2rem;
            color: #333;
        }
        .button {
            background: #4f46e5;
            color: #ffffff;
            padding: 0.5rem 1rem;
            border-radius: 6px;
            text-decoration: none;
            font-weight: 600;
            display: inline-block;
            transition: background-color 0.3s ease;
        }
        .button:hover {
            background: #4338ca;
        }
        .form-group {
            margin-bottom: 1.5rem;
        }
        .form-group label {
            display: block;
            font-size: 0.875rem;
            color: #4b5563;
            margin-bottom: 0.5rem;
        }
        .form-group input, .form-group select {
            width: 100%;
            padding: 0.75rem;
            border: 1px solid #d1d5db;
            border-radius: 6px;
            background: #ffffff;
        }
        .submit-button {
            background: #4f46e5;
            color: #ffffff;
            padding: 0.75rem 1.5rem;
            border-radius: 6px;
            border: none;
            font-weight: 600;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }
        .submit-button:hover {
            background: #4338ca;
        }
        .error-message {
            color: #ef4444;
            font-size: 0.875rem;
        }
    </style>
</head>
<body class="bg-gray-100">
    <div class="min-h-screen flex flex-col">
        <!-- Navbar -->
        <nav class="navbar shadow-md">
            <div class="navbar-content flex justify-between items-center">
                <h1>Edit Produk</h1>
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <input type="hidden" name="role" value="admin">
                    <button type="submit" class="button bg-red-500 hover:bg-red-600">Logout</button>
                </form>
            </div>
            <div class="bg-gray-50 border-t border-gray-200">
                <div class="container mx-auto flex space-x-4 p-4">
                    <a href="{{ route('admin.dashboard') }}" class="text-gray-600 hover:text-gray-900 transition duration-200">Dashboard</a>
                    <a href="{{ route('produk.index') }}" class="text-blue-500 border-b-2 border-blue-500">Manage Produk</a>
                </div>
            </div>
        </nav>
        <!-- Main Content -->
        <main class="main-content container mx-auto">
            <h2 class="text-3xl font-semibold text-gray-800 mb-6">Edit Produk</h2>

            <form action="{{ route('produk.update', $produk->produk_id) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <div class="form-group">
                    <label for="namaproduk">Nama Produk</label>
                    <input type="text" id="namaproduk" name="namaproduk" value="{{ old('namaproduk', $produk->namaproduk) }}" required>
                    @error('namaproduk')
                        <span class="error-message">{{ $message }}</span>
                    @enderror
                </div>
                <div class="form-group">
                    <label for="thumbnail">Thumbnail</label>
                    <input type="file" id="thumbnail" name="thumbnail" accept="image/*">
                    @error('thumbnail')
                        <span class="error-message">{{ $message }}</span>
                    @enderror
                </div>
                <div class="form-group">
                    <label for="harga">Harga</label>
                    <input type="number" step="0.01" id="harga" name="harga" value="{{ old('harga', $produk->harga) }}" required>
                    @error('harga')
                        <span class="error-message">{{ $message }}</span>
                    @enderror
                </div>
                <div class="form-group">
                    <label for="stok">Stok</label>
                    <input type="number" id="stok" name="stok" value="{{ old('stok', $produk->stok) }}" required>
                    @error('stok')
                        <span class="error-message">{{ $message }}</span>
                    @enderror
                </div>
                <div>
                    <button type="submit" class="submit-button">Update Produk</button>
                </div>
            </form>
        </main>
    </div>
</body>
</html>
