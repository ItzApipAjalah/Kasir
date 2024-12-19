<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Petugas Dashboard</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="stylesheet" href="../css/petugas/index.css">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap-theme.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.min.js"></script>
</head>

<body class="bg-gray-100">
    <div class="min-h-screen flex flex-col">
        <nav class="navbar shadow-md">
            <div class="navbar-content flex justify-between items-center">
                <h1 class="text-xl font-bold">Petugas Dashboard</h1>
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <input type="hidden" name="role" value="petugas">
                    <button type="submit" class="logout-button">Logout</button>
                </form>
            </div>
            <div class="bg-gray-50 border-t border-gray-200">
                <div class="container mx-auto flex space-x-4 p-4">
                    <a href="{{ route('petugas.dashboard') }}" class="text-blue-500 font-semibold border-b-2 border-blue-500 active">Dashboard</a>
                    <a href="{{ route('petugas.history') }}" class="text-gray-600 hover:text-gray-900 transition duration-200">History Transaksi</a>
                </div>
            </div>
        </nav>

        <main class="flex-grow container mx-auto p-8 flex flex-col lg:flex-row">
            <!-- Available Items -->
            <section class="w-full lg:w-2/3 pr-0 lg:pr-4">
                <h2 class="text-2xl font-bold mb-6">Available Items</h2>
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-5 xl:grid-cols-5 gap-4">
                    <!-- Dynamic Item Card Rendering -->
                    @foreach ($produk as $item)
                        <div class="item-card bg-white p-4 rounded-lg shadow-md" data-produk-id="{{ $item->produk_id }}" data-namaproduk="{{ $item->namaproduk }}" data-harga="{{ $item->harga }}">
                            <div class="relative">
                                <img src="{{ asset('storage/' . $item->thumbnail) }}" alt="{{ $item->namaproduk }}" class="w-full h-32 object-cover rounded-md mb-5">
                                <div class="item-overlay">
                                    <p>{{ $item->namaproduk }}</p>
                                </div>
                            </div>
                            <h3 class="text-lg font-semibold mb-2">{{ $item->namaproduk }}</h3>
                            <p class="text-gray-600 mb-2">{{ $item->deskripsi }}</p>
                            <p class="text-gray-800 font-bold">Rp. {{ number_format($item->harga, 2) }}</p>
                            <p>Stok: {{ $item->stok }}</p>
                        </div>
                    @endforeach
                    <!-- End of Dynamic Item Card Rendering -->
                </div>
            </section>
            <!-- Selected Items and Total -->
            <section class="w-full lg:w-1/3 pl-0 lg:pl-4 mt-8 lg:mt-0">
                <h2 class="text-2xl font-bold mb-6">Selected Items</h2>
                <div id="selected-items" class="bg-white p-4 rounded-lg shadow-md mb-6">
                    <h6 class="text-1xl mb-6">Selected Items</h6>
                    <!-- Selected Item Template -->
                </div>
                <div class="bg-white p-4 rounded-lg shadow-md mb-6">
                    <h3 class="text-lg font-semibold mb-4">Add Item by ID / Barcode</h3>
                    <div class="input-container">
                        <input type="text" id="input-produk-id" placeholder="Enter Produk ID">
                        <button id="add-by-id-button">Add</button>
                    </div>
                    <div id="input-error" class="input-error"></div>
                </div>
                <div class="bg-white p-4 rounded-lg shadow-md">
                    <h3 class="text-lg font-semibold mb-4">Total</h3>
                    <p id="total-price" class="text-2xl font-bold">Rp. 0</p>
                    <button id="confirm-transaction" class="mt-4 bg-green-500 text-white p-2 rounded-md hover:bg-green-600">Confirm Transaction</button>
                </div>
            </section>
        </main>
    </div>

    <div id="transaction-modal" class="transaction-modal flex">
        <div class="transaction-modal-content">
            <div class="modal-header">
                <h3>Transaction Confirmation</h3>
                <button id="close-modal">Close</button>
            </div>
            <div class="transaction-details">
                <h4 class="font-bold text-lg">Transaction Details</h4>
                <table>
                    <thead>
                        <tr>
                            <th>Produk ID</th>
                            <th>Nama Produk</th>
                            <th>Harga</th>
                            <th>Kuantitas</th>
                            <th>Total</th>
                        </tr>
                    </thead>
                    <tbody id="transaction-table-body">
                        <!-- Transaction Details Template -->
                    </tbody>
                </table>
            </div>
            <div class="mb-4">
                <label for="payment-amount" class="block text-gray-700">Payment Amount:</label>
                <input type="number" id="payment-amount" class="form-input mt-1 block w-full" placeholder="Enter Payment Amount" value="0">
            </div>

            <!-- Buttons for preset payment amounts -->
            <div class="mb-4">
                <label class="block text-gray-700">Quick Add Amount:</label>
                <div class="flex space-x-2 mt-1">
                    <button type="button" class="add-amount bg-gray-200 p-2 rounded-md" data-amount="1000">+1,000</button>
                    <button type="button" class="add-amount bg-gray-200 p-2 rounded-md" data-amount="2000">+2,000</button>
                    <button type="button" class="add-amount bg-gray-200 p-2 rounded-md" data-amount="5000">+5,000</button>
                    <button type="button" class="add-amount bg-gray-200 p-2 rounded-md" data-amount="10000">+10,000</button>
                    <button type="button" class="add-amount bg-gray-200 p-2 rounded-md" data-amount="20000">+20,000</button>
                    <button type="button" class="add-amount bg-gray-200 p-2 rounded-md" data-amount="50000">+50,000</button>
                    <button type="button" class="add-amount bg-gray-200 p-2 rounded-md" data-amount="75000">+75,000</button>
                    <button type="button" class="add-amount bg-gray-200 p-2 rounded-md" data-amount="100000">+100,000</button>
                </div>
            </div>

            <div class="transaction-summary mb-4">
                <span>Change: Rp. <span id="transaction-change">0</span></span>
            </div>
            <div class="transaction-summary mb-4">
                <span>Total Price: Rp. <span id="transaction-total-price">0</span></span>
            </div>
            <div class="mb-4">
                <label for="customer-select" class="block text-gray-700">Select Customer (optional default AMWP):</label>
                <select id="customer-select" class="form-select mt-1 block w-full">
                    <!-- Customer options will be added dynamically -->
                </select>
            </div>
            <div class="flex justify-end">
                <button id="submit-transaction" class="bg-blue-500 text-white p-2 rounded-md hover:bg-blue-600">Submit</button>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="../js/petugas.js"></script>
    <script>
    document.addEventListener('DOMContentLoaded', () => {
        const paymentAmountInput = document.getElementById('payment-amount');
        const changeElement = document.getElementById('transaction-change');
        const totalTransactionAmount = parseFloat(document.getElementById('transaction-total-price').textContent.replace(/,/g, ''));

        // Add event listener for each quick add amount button
        document.querySelectorAll('.add-amount').forEach(button => {
            button.addEventListener('click', () => {
                const addValue = parseFloat(button.getAttribute('data-amount'));
                const currentPaymentAmount = parseFloat(paymentAmountInput.value) || 0;
                const newPaymentAmount = currentPaymentAmount + addValue;

                paymentAmountInput.value = newPaymentAmount;

                // Update change
                const change = newPaymentAmount - totalTransactionAmount;
                changeElement.textContent = formatCurrency(change);
            });
        });

        function formatCurrency(value) {
            return value.toFixed(2).replace(/\d(?=(\d{3})+\.)/g, '$&,');
        }
    });

    </script>
</body>

</html>
