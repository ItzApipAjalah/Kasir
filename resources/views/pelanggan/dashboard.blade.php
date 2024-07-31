<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pelanggan Dashboard</title>
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

        /* Item card styles */
        .item-card {
            background: #ffffff;
            border-radius: 8px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
            padding: 1rem;
            display: flex;
            flex-direction: column;
            align-items: center;
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }

        .item-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 8px 16px rgba(0, 0, 0, 0.2);
        }

        .item-card img {
            border-radius: 8px;
            margin-bottom: 1rem;
        }

        .item-card h3 {
            font-size: 1.25rem;
            font-weight: 600;
            color: #333;
            margin-bottom: 0.5rem;
        }

        .item-card p {
            color: #666;
            margin-bottom: 0.5rem;
        }

        .item-card .price {
            font-weight: bold;
            color: #333;
        }
    </style>
</head>

<body class="bg-gray-100">
    <div class="min-h-screen flex flex-col">
        <nav class="navbar shadow-md">
            <div class="navbar-content flex justify-between items-center">
                <h1 class="text-xl font-bold">Pelanggan Dashboard</h1>
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <input type="hidden" name="role" value="pelanggan">
                    <button type="submit" class="logout-button">Logout</button>
                </form>
            </div>
            <div class="bg-gray-50 border-t border-gray-200">
                <div class="container mx-auto flex space-x-4 p-4">
                    <a href="{{ route('pelanggan.dashboard') }}" class="text-blue-500 font-semibold border-b-2 border-blue-500 active">Dashboard</a>
                    <a href="" class="text-gray-600 hover:text-gray-900 transition duration-200">Orders</a>
                    <a href="" class="text-gray-600 hover:text-gray-900 transition duration-200">Profile</a>
                </div>
            </div>
        </nav>
        <main class="flex-grow container mx-auto p-8 flex flex-col lg:flex-row">
            <!-- Purchased Items -->
            <section class="w-full">
                <h2 class="text-2xl font-bold mb-6">History Transaksi</h2>
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 xl:grid-cols-4 gap-4">
                    <!-- Dynamic Purchased Item Rendering -->
                        <div class="item-card">
                            <img src="" alt="" class="w-full h-32 object-cover mb-4">
                            <h3 class="text-lg font-semibold"></h3>
                            <p></p>
                            <p class="price">Rp. </p>
                        </div>
                    <!-- End of Dynamic Purchased Item Rendering -->
                </div>
            </section>
        </main>
    </div>
</body>

</html>
