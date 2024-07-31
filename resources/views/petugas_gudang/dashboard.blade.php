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
        <main class="flex-grow container mx-auto p-8 flex flex-col lg:flex-row">
            <!-- Available Items -->
            <section class="w-full lg:w-2/3 pr-0 lg:pr-4">
                <h2 class="text-2xl font-bold mb-6">Available Items</h2>
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-5 xl:grid-cols-5 gap-4">
                    <!-- Dynamic Item Card Rendering -->
                    {{-- @foreach ($produk as $item)
                        <div class="item-card bg-white p-4 rounded-lg shadow-md" data-namaproduk="{{ $item->namaproduk }}" data-harga="{{ $item->harga }}">
                            <div class="relative">
                                <img src="{{ asset('storage/' . $item->thumbnail) }}" alt="{{ $item->namaproduk }}" class="w-full h-32 object-cover rounded-md mb-5">
                                <div class="item-overlay">
                                    <p>{{ $item->namaproduk }}</p>
                                </div>
                            </div>
                            <h3 class="text-lg font-semibold mb-2">{{ $item->namaproduk }}</h3>
                            <p class="text-gray-600 mb-2">{{ $item->deskripsi }}</p>
                            <p class="text-gray-800 font-bold">Rp. {{ number_format($item->harga, 2) }}</p>
                            <p>Stok: {{ $item->stok }}  </p>
                        </div>
                    @endforeach
                    <!-- End of Dynamic Item Card Rendering --> --}}
                </div>
            </section>
            <!-- Selected Items and Total -->
            {{-- <section class="w-full lg:w-1/3 pl-0 lg:pl-4 mt-8 lg:mt-0">
                <h2 class="text-2xl font-bold mb-6">Selected Items</h2>
                <div id="selected-items" class="bg-white p-4 rounded-lg shadow-md mb-6">
                    <h6 class="text-1xl mb-6">Selected Items</h6>
                    <!-- Selected Item Template -->
                </div>
                <div class="bg-white p-4 rounded-lg shadow-md">
                    <h3 class="text-lg font-semibold mb-4">Total</h3>
                    <p id="total-price" class="text-2xl font-bold">Rp. 0</p>
                </div>
            </section> --}}
        </main>
    </div>


</body>

</html>
