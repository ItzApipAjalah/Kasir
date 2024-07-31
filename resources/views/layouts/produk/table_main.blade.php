<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Produk</title>
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
            color: #4f46e5;
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
        <!-- Navbar -->
        <nav class="navbar shadow-md">
            <div class="navbar-content flex justify-between items-center">
                <h1>Manage Produk</h1>
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <input type="hidden" name="role" value="admin">
                    <button type="submit" class="logout-button">Logout</button>
                </form>
            </div>
            <div class="bg-gray-50 border-t border-gray-200">
                <div class="container mx-auto flex space-x-4 p-4">
                    <a href="{{ route('admin.dashboard') }}" class="text-gray-600 hover:text-gray-900 transition duration-200">Dashboard</a>
                    <a href="{{ route('petugas.index') }}" class="text-gray-600 hover:text-gray-900 transition duration-200">Manage Petugas</a>
                    <a href="{{ route('petugas_gudang.index') }}" class="text-gray-600 hover:text-gray-900 transition duration-200">Manage Petugas Gudang</a>
                    <a href="{{ route('produk.index') }}" class="text-blue-500 font-semibold border-b-2 border-blue-500 active">Manage Produk</a>
                </div>
            </div>
        </nav>
        <!-- Main Content -->
        @yield('content')
    </div>
</body>
</html>
