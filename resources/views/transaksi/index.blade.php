<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Input Transaksi</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
</head>
<body class="bg-gray-100">
    <div class="container mx-auto p-8">
        <h2 class="text-2xl font-bold mb-6">Input Transaksi</h2>
        <form method="POST" action="{{ route('transaksi.store') }}">
            @csrf
            <div class="mb-4">
                <label for="petugas_id" class="block text-gray-700">Petugas ID</label>
                <input type="number" id="petugas_id" name="petugas_id" class="w-full p-2 border border-gray-300 rounded" required>
            </div>
            <div class="mb-4">
                <label for="pelanggan_id" class="block text-gray-700">Pelanggan ID</label>
                <input type="number" id="pelanggan_id" name="pelanggan_id" class="w-full p-2 border border-gray-300 rounded" required>
            </div>
            <div id="produk-list">
                <div class="mb-4 flex items-center">
                    <input type="number" name="produk[0][id]" class="w-1/4 p-2 border border-gray-300 rounded" placeholder="Produk ID" required>
                    <input type="number" name="produk[0][quantity]" class="w-1/4 p-2 border border-gray-300 rounded ml-4" placeholder="Quantity" required>
                    <button type="button" onclick="removeProduct(this)" class="ml-4 bg-red-500 text-white p-2 rounded">Remove</button>
                </div>
            </div>
            <button type="button" onclick="addProduct()" class="bg-blue-500 text-white p-2 rounded">Add Product</button>
            <button type="submit" class="mt-4 bg-green-500 text-white p-2 rounded">Submit Transaksi</button>
        </form>
    </div>

    <script>
        let productCount = 1;

        function addProduct() {
            const produkList = document.getElementById('produk-list');
            const newProductDiv = document.createElement('div');
            newProductDiv.className = 'mb-4 flex items-center';
            newProductDiv.innerHTML = `
                <input type="number" name="produk[${productCount}][id]" class="w-1/4 p-2 border border-gray-300 rounded" placeholder="Produk ID" required>
                <input type="number" name="produk[${productCount}][quantity]" class="w-1/4 p-2 border border-gray-300 rounded ml-4" placeholder="Quantity" required>
                <button type="button" onclick="removeProduct(this)" class="ml-4 bg-red-500 text-white p-2 rounded">Remove</button>
            `;
            produkList.appendChild(newProductDiv);
            productCount++;
        }

        function removeProduct(button) {
            button.parentElement.remove();
        }
    </script>
</body>
</html>
