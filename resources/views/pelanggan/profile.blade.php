<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pelanggan Dashboard</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../css/pelanggan.css">
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
        <main class="flex-grow container mx-auto items-center justify-center flex flex-col lg:flex-row">
            <div class="bg-white shadow-md rounded-lg p-8 w-full max-w-lg ">
                <div class="flex flex-col items-center mb-4">
                    <h2 class="text-2xl font-semibold mb-2">Detail Profile</h2>
                    <div class="w-24 h-24 bg-gray-200 rounded-full flex items-center justify-center mb-4">
                        <span class="text-3xl text-gray-500 font-bold">{{ strtoupper(substr($pelanggan->name, 0, 2)) }}</span>
                    </div>
                </div>
                <div class="w-full">
                    <div class="mb-4">
                        <label class="block text-gray-600">Name:</label>
                        <div class="text-lg font-semibold text-gray-800">{{ $pelanggan->name }}</div>
                    </div>
                    <div class="mb-4">
                        <label class="block text-gray-600">Email:</label>
                        <div class="text-lg font-semibold text-gray-800">{{ $pelanggan->email }}</div>
                    </div>
                    <div class="mb-4">
                        <label class="block text-gray-600">Alamat:</label>
                        <div class="text-lg font-semibold text-gray-800">{{ $pelanggan->alamat ?? 'N/A' }}</div>
                    </div>
                    <div class="mb-4">
                        <label class="block text-gray-600">Nomor Telepon:</label>
                        <div class="text-lg font-semibold text-gray-800">{{ $pelanggan->nomor_telepon ?? 'N/A' }}</div>
                    </div>
                </div>
                <div class="flex justify-center mt-6">
                    <a href="{{ route('pelanggan.edit', $pelanggan->id) }}" class="px-4 py-2 bg-blue-500 text-white rounded-lg shadow hover:bg-blue-600 transition duration-200">Edit Profile</a>
                </div>
            </div>
        </main>
    </div>
</body>

</html>
