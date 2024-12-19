@extends('layouts.produk.table_main')
@section('content')
<main class="main-content container mx-auto">
    <div class="flex justify-between items-center mb-6">
        <h2 class="text-3xl font-semibold text-gray-800">Produk List</h2>
        <a href="{{ route('produk.create') }}" class="button bg-blue-500 hover:bg-blue-600 add-button">Add New Produk</a>
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
                            <a href="{{ route('produk.edit', $produk->produk_id) }}" class="text-blue-500 hover:text-blue-700 transition duration-200">Edit</a>
                            <form action="{{ route('produk.destroy', $produk->produk_id) }}" method="POST" style="display:inline;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-red-500 hover:text-red-700 transition duration-200">Delete</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</main>
@endsection
