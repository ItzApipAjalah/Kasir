<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Pelanggan</title>
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

.modal {
    display: none;
    position: fixed;
    z-index: 50;
    left: 0;
    top: 0;
    width: 100%;
    height: 100%;
    overflow: auto;
    background-color: rgba(0, 0, 0, 0.5);
}
.modal-content {
    background-color: #fefefe;
    margin: 15% auto;
    padding: 20px;
    border: 1px solid #888;
    width: 80%;
    max-width: 600px;
}
.close {
    color: #aaa;
    float: right;
    font-size: 28px;
    font-weight: bold;
}
.close:hover,
.close:focus {
    color: black;
    text-decoration: none;
    cursor: pointer;
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
                    <a href="{{ route('pelanggan.dashboard') }}" class="text-gray-600 hover:text-gray-900 transition duration-200">Dashboard</a>
                    @php
                        $userId = Auth::id();
                    @endphp

                    <a href="{{ route('pelanggan.show', ['id' => $userId]) }}" class="text-blue-500 font-semibold border-b-2 border-blue-500 active">Profile</a>
                </div>
            </div>
        </nav>
        <main class="flex-grow container mx-auto p-8 flex flex-col lg:flex-row">
            <div class="bg-white shadow-lg rounded-lg p-8 w-full lg:w-2/3 mx-auto">
                <h2 class="text-2xl font-semibold mb-6">Edit Profile</h2>
                <form action="{{ route('pelanggan.update', $pelanggan->id) }}" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="mb-4">
                        <label for="name" class="block text-gray-700 font-medium mb-2">Name:</label>
                        <input type="text" class="form-input w-full border-gray-300 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500" id="name" name="name" value="{{ old('name', $pelanggan->name) }}" required>
                    </div>
                    <div class="mb-4">
                        <label for="email" class="block text-gray-700 font-medium mb-2">Email:</label>
                        <input type="email" class="form-input w-full border-gray-300 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500" id="email" name="email" value="{{ old('email', $pelanggan->email) }}" required>
                    </div>
                    <div class="mb-4">
                        <label for="alamat" class="block text-gray-700 font-medium mb-2">Alamat:</label>
                        <input type="text" class="form-input w-full border-gray-300 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500" id="alamat" name="alamat" value="{{ old('alamat', $pelanggan->alamat) }}">
                    </div>
                    <div class="mb-4">
                        <label for="nomor_telepon" class="block text-gray-700 font-medium mb-2">Nomor Telepon:</label>
                        <input type="text" class="form-input w-full border-gray-300 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500" id="nomor_telepon" name="nomor_telepon" value="{{ old('nomor_telepon', $pelanggan->nomor_telepon) }}">
                    </div>
                    <div class="mb-4">
                        <label for="password" class="block text-gray-700 font-medium mb-2">Password:</label>
                        <input type="password" class="form-input w-full border-gray-300 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500" id="password" name="password">
                    </div>
                    <div class="mb-6">
                        <label for="password_confirmation" class="block text-gray-700 font-medium mb-2">Confirm Password:</label>
                        <input type="password" class="form-input w-full border-gray-300 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500" id="password_confirmation" name="password_confirmation">
                    </div>
                    <button type="submit" class="w-full py-2 px-4 bg-blue-500 text-white font-semibold rounded-lg shadow-md hover:bg-blue-600 focus:outline-none focus:ring-2 focus:ring-blue-500 transition duration-200">Update</button>
                </form>
            </div>
        </main>
    </div>
</body>

</html>
