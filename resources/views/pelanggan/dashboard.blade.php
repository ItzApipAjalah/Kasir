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
                    <a href="{{ route('pelanggan.dashboard') }}" class="text-blue-500 font-semibold border-b-2 border-blue-500 active">Dashboard</a>
                    @php
                        $userId = Auth::id();
                    @endphp

                    <a href="{{ route('pelanggan.show', ['id' => $userId]) }}" class="text-gray-600 hover:text-gray-900 transition duration-200">Profile</a>

                </div>
            </div>
        </nav>
        <main class="flex-grow container mx-auto p-8 flex flex-col lg:flex-row">
            <!-- Purchased Items -->
            <section class="w-full">
                <h2 class="text-2xl font-bold mb-6">History Transaksi</h2>
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 xl:grid-cols-4 gap-4">
                    @foreach ($transactions as $transaction)
                        <div class="item-card p-4" data-transaction-id="{{ $transaction->id }}">
                            <h3 class="text-lg font-semibold mb-2">Transaction ID: {{ $transaction->id }}</h3>
                            <p class="text-gray-600 mb-1">Date: {{ $transaction->created_at->format('d-m-Y') }}</p>
                            <p class="text-gray-600 mb-4">Total: Rp. {{ number_format($transaction->total, 2, ',', '.') }}</p>
                        </div>
                    @endforeach
                </div>
            </section>
        </main>
        <!-- Modal -->
        <div id="transaction-modal" class="modal">
            <div class="modal-content">
                <span class="close">&times;</span>
                <h3 class="text-lg font-semibold mb-2">Transaction Details</h3>
                <div id="transaction-details"></div>
            </div>
        </div>
        <script>
            document.addEventListener('DOMContentLoaded', () => {
                const modal = document.getElementById('transaction-modal');
                const closeModal = document.getElementsByClassName('close')[0];
                const transactionDetailsContainer = document.getElementById('transaction-details');

                document.querySelectorAll('.item-card').forEach(card => {
                    card.addEventListener('click', () => {
                        const transactionId = card.getAttribute('data-transaction-id');
                        fetch(`/api/v1/transactions/${transactionId}/details`)
                            .then(response => response.json())
                            .then(data => {
                                transactionDetailsContainer.innerHTML = '';
                                data.forEach(detail => {
                                    const detailElement = document.createElement('div');
                                    detailElement.classList.add('mb-2');
                                    detailElement.innerHTML = `
                                        <p class="font-semibold">${detail.namaproduk}</p>
                                        <p>Quantity: ${detail.quantity}</p>
                                        <p>Price: Rp. ${parseFloat(detail.total).toLocaleString('id-ID', { minimumFractionDigits: 2 })}</p>
                                        <p>Subtotal: Rp. ${parseFloat(detail.harga).toLocaleString('id-ID', { minimumFractionDigits: 2 })}</p>
                                    `;
                                    transactionDetailsContainer.appendChild(detailElement);
                                });
                                modal.style.display = 'block';
                            })
                            .catch(error => console.error('Error fetching transaction details:', error));
                    });
                });

                closeModal.onclick = function() {
                    modal.style.display = 'none';
                }

                window.onclick = function(event) {
                    if (event.target == modal) {
                        modal.style.display = 'none';
                    }
                }
            });
        </script>
    </div>
</body>

</html>
