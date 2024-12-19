<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Petugas Dashboard</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
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

        .logout-button {
            background: #ef4444;
            color: #ffffff;
            padding: 0.75rem 1.5rem;
            border-radius: 6px;
            border: none;
            font-weight: 600;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }

        .logout-button:hover {
            background: #dc2626;
        }

        /* Hover effect for available items */
        .item-card {
            transition: transform 0.3s ease, box-shadow 0.3s ease;
            position: relative;
            -webkit-user-select: none; /* Safari */
  -ms-user-select: none; /* IE 10 and IE 11 */
  user-select: none; /* Standard syntax */
        }

        .item-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 8px 16px rgba(0, 0, 0, 0.2);
        }

        .item-overlay {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, 0.5);
            display: flex;
            align-items: center;
            justify-content: center;
            opacity: 0;
            transition: opacity 0.3s ease;
            border-radius: 8px;
        }

        .item-card:hover .item-overlay {
            opacity: 1;
        }

        .item-overlay p {
            color: #ffffff;
            font-size: 1.25rem;
            font-weight: 600;
            text-align: center;
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
        .add-button {
            background: #4f46e5;
            color: #ffffff;
            padding: 0.5rem 1rem;
            border-radius: 6px;
            text-decoration: none;
            font-weight: 600;
            display: inline-block;
            transition: background-color 0.3s ease;
        }
        .add-button:hover {
            background: #4338ca;
        }
        .table-wrapper {
            overflow-x: auto;
            margin-top: 1.5rem;
        }
        .table {
            width: 100%;
            border-collapse: collapse;
            background: #ffffff;
            border-radius: 8px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
        }
        .table thead {
            background: #f3f4f6;
        }
        .table th, .table td {
            padding: 1rem;
            text-align: left;
            border-bottom: 1px solid #e5e7eb;
        }
        .table th {
            font-weight: 600;
            color: #333;
        }
        .table td {
            color: #666;
        }
        .table tr:last-child td {
            border-bottom: none;
        }
        .table .action-buttons a, .table .action-buttons button {
            margin-right: 0.5rem;
            text-decoration: none;
            transition: color 0.3s ease;
        }
        .table .action-buttons a:hover, .table .action-buttons button:hover {
            color: #4338ca;
        }
        .success-message {
            background: #d1fae5;
            color: #059669;
            padding: 1rem;
            border-radius: 6px;
            margin-bottom: 1.5rem;
            border: 1px solid #a3e635;
        }

        .logout-button {
            background: #ef4444;
            color: #ffffff;
            padding: 0.75rem 1.5rem;
            border-radius: 6px;
            border: none;
            font-weight: 600;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }
        .logout-button:hover {
            background: #dc2626;
        }
    </style>
</head>

<body class="bg-gray-100">
    <div class="min-h-screen flex flex-col">
        <nav class="navbar shadow-md">
            <div class="navbar-content flex justify-between items-center">
                <h1 class="text-xl font-bold">Petugas Dashboard</h1>
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <input type="hidden" name="role" value="petugas_gudang">
                    <button type="submit" class="logout-button">Logout</button>
                </form>
            </div>
            <div class="bg-gray-50 border-t border-gray-200">
                <div class="container mx-auto flex space-x-4 p-4">
                    <a href="{{ route('petugas_gudang.dashboard') }}" class="text-blue-500 font-semibold border-b-2 border-blue-500 active">Dashboard</a>
                    <a href="{{ route('produk.index') }}" class="text-gray-600 hover:text-gray-900 transition duration-200">Manage Produk</a>
                </div>
            </div>
        </nav>
        <main class="main-content container mx-auto">
            <div class="flex justify-between items-center mb-6">
                <h2 class="text-3xl font-semibold text-gray-800">Produk List</h2>
                <a href="{{ route('gudang.produk.create') }}" class="button bg-blue-500 hover:bg-blue-600 add-button">Add New Produk</a>
            </div>

            @if (session('success'))
                <div class="bg-green-100 text-green-700 p-4 rounded-lg mb-6">
                    {{ session('success') }}
                </div>
            @endif

            <div class="table-wrapper">
                <table class="table">
                    <thead>
                        <tr>
                            <th>ProdukID</th>
                            <th>Nama Produk</th>
                            <th>Thumbnail</th>
                            <th>Harga</th>
                            <th>Stok</th>
                            <th>Barcode</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($produks as $produk)
                            <tr>
                                <td>{{ $produk->produk_id }}</td>
                                <td>{{ $produk->namaproduk }}</td>
                                <td>
                                    <img src="{{ asset('storage/' . $produk->thumbnail) }}" alt="{{ $produk->namaproduk }}" class="w-16 h-16 object-cover">
                                </td>
                                <td>{{ number_format($produk->harga, 2) }}</td>
                                <td>{{ $produk->stok }}</td>
                                <td>
                                    @php
                                        $barcode = DNS1D::getBarcodePNG($produk->produk_id, 'C128');
                                    @endphp
                                    <img src="data:image/png;base64,{{ $barcode }}" alt="Barcode for {{ $produk->produk_id }}" class="w-full h-auto">
                                </td>
                                <td class="action-buttons">
                                    <a href="{{ route('gudang.produk.edit', $produk->produk_id) }}" class="text-blue-500 hover:text-blue-700 transition duration-200">Edit</a>
                                    <form action="{{ route('gudang.produk.destroy', $produk->produk_id) }}" method="POST" style="display:inline;">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="text-red-500 hover:text-red-700 transition duration-200">Delete</button>
                                    </form>
                                    <a href="{{ route('gudang.produk.downloadBarcode', $produk->produk_id) }}" class="text-green-500 hover:text-green-700 transition duration-200">Download Barcode</a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </main>
    </div>


</body>

</html>
