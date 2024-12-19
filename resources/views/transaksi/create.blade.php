@extends('layouts.petugas.table_main')

@section('content')
<main class="main-content container mx-auto">
    <div class="card">
        <h2 class="text-3xl font-semibold text-gray-800 mb-4">Buat Transaksi Baru</h2>

        <form action="{{ route('transaksi.store') }}" method="POST">
            @csrf
            <div class="mb-4">
                <label for="petugas_id" class="block text-gray-700">Petugas</label>
                <select name="petugas_id" id="petugas_id" class="form-select w-full">
                    @foreach($petugas as $p)
                        <option value="{{ $p->id }}">{{ $p->name }}</option>
                    @endforeach
                </select>
            </div>

            <div class="mb-4">
                <label for="pelanggan_id" class="block text-gray-700">Pelanggan (Opsional)</label>
                <select name="pelanggan_id" id="pelanggan_id" class="form-select w-full">
                    <option value="">Pilih Pelanggan</option>
                    @foreach($pelanggans as $pelanggan)
                        <option value="{{ $pelanggan->id }}">{{ $pelanggan->name }}</option>
                    @endforeach
                </select>
            </div>

            <div class="mb-4">
                <label for="produk_id" class="block text-gray-700">Produk</label>
                <input type="text" id="input-produk-id" class="form-input w-full" placeholder="Masukkan Produk ID">
                <button type="button" id="add-by-id-button" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded mt-2">Tambahkan Produk</button>
                <p id="input-error" class="text-red-500 mt-2"></p>
            </div>

            <div id="selected-items" class="mb-4">
                <h4 class="text-xl font-semibold text-gray-800 mb-2">Produk Terpilih</h4>
                <!-- Selected items will be dynamically added here -->
            </div>

            <div class="mb-4">
                <label for="total_price" class="block text-gray-700">Total Harga</label>
                <p id="total-price" class="text-2xl font-bold">Rp. 0</p>
            </div>

            <button type="submit" class="bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-4 rounded">Simpan Transaksi</button>
        </form>
    </div>
</main>

<script>
    document.addEventListener('DOMContentLoaded', () => {
        const selectedItems = {};
        const selectedItemsContainer = document.getElementById('selected-items');
        const totalPriceElement = document.getElementById('total-price');
        const inputProdukId = document.getElementById('input-produk-id');
        const addByIdButton = document.getElementById('add-by-id-button');
        const inputError = document.getElementById('input-error');

        const addItem = (produkId, namaProduk, harga) => {
            if (selectedItems[produkId]) {
                selectedItems[produkId].quantity++;
            } else {
                selectedItems[produkId] = {
                    namaProduk,
                    harga,
                    quantity: 1
                };
            }
            updateSelectedItems();
            updateTotalPrice();
        };

        const handleAddById = () => {
            const produkId = inputProdukId.value.trim();
            if (produkId) {
                const itemCard = document.querySelector(`.item-card[data-produk-id="${produkId}"]`);
                if (itemCard) {
                    const namaProduk = itemCard.getAttribute('data-namaproduk');
                    const harga = parseFloat(itemCard.getAttribute('data-harga'));
                    addItem(produkId, namaProduk, harga);
                    inputError.textContent = '';
                    inputProdukId.value = ''; // Clear input after adding
                } else {
                    inputError.textContent = 'Produk ID tidak ditemukan.';
                }
            }
        };

        const updateSelectedItems = () => {
            selectedItemsContainer.innerHTML = '';
            for (const [key, item] of Object.entries(selectedItems)) {
                const itemElement = document.createElement('div');
                itemElement.className = 'flex justify-between mb-4';
                itemElement.innerHTML = `<span class="font-semibold">${item.namaProduk} (x${item.quantity})</span><span>Rp. ${formatCurrency(item.harga)}</span>`;
                selectedItemsContainer.appendChild(itemElement);
            }
        };

        const updateTotalPrice = () => {
            let totalPrice = 0;
            for (const item of Object.values(selectedItems)) {
                totalPrice += item.harga * item.quantity;
            }
            totalPriceElement.textContent = `Rp. ${formatCurrency(totalPrice)}`;
        };

        const formatCurrency = (value) => {
            return new Intl.NumberFormat('id-ID').format(value);
        };

        addByIdButton.addEventListener('click', handleAddById);

        inputProdukId.addEventListener('keydown', (event) => {
            if (event.key === 'Enter') {
                handleAddById();
            }
        });
    });
</script>
@endsection
