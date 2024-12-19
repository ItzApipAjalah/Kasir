<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pelanggan Dashboard</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../css/pelanggan.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.5.1/jspdf.umd.min.js"></script>

</head>

<body class="bg-gray-100">
    <div class="min-h-screen flex flex-col">
        <nav class="navbar shadow-md">
            <div class="navbar-content flex justify-between items-center">
                <h1 class="text-xl font-bold">Petugas Dashboard</h1>
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <input type="hidden" name="role" value="admin">
                    <button type="submit" class="logout-button">Logout</button>
                </form>
            </div>
            <div class="bg-gray-50 border-t border-gray-200">
                <div class="container mx-auto flex space-x-4 p-4">
                    <a href="{{ route('petugas.dashboard') }}" class="text-gray-600 hover:text-gray-900 transition duration-200">Dashboard</a>
                    <a href="{{ route('petugas.history') }}" class="text-blue-500 font-semibold border-b-2 border-blue-500 active">History Transaksi</a>
                    @php
                        $userId = Auth::id();
                    @endphp
                    @php
                    $totalPenghasilan = $transactions->sum('total');
                @endphp

                </div>
            </div>
        </nav>
        <main class="flex-grow container mx-auto p-8 flex flex-col lg:flex-row">
            <!-- Total Earnings Section -->
            <section class="w-full">
                <div class="mt-8 grid grid-cols-1 md:grid-cols-3 gap-6">
                    <!-- Total Earnings Card -->
                    <div class="bg-blue-500 text-white rounded-xl shadow-md p-6">
                        <div class="flex items-center justify-between">
                            <div>
                                <h2 class="text-2xl font-bold">Total Penghasilan</h2>
                                <p class="text-4xl font-semibold mt-4">Rp. {{ number_format($totalPenghasilan, 2, ',', '.') }}</p>
                            </div>
                            <div>
                                <svg class="w-16 h-16 text-blue-300" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c.596 0 1.17-.265 1.575-.735l4.717-5.528A1.8 1.8 0 0016.717 0H7.283a1.8 1.8 0 00-1.575 1.737l4.717 5.528c.405.47.979.735 1.575.735zM12 12c-2.485 0-4.5 2.015-4.5 4.5S9.515 21 12 21s4.5-2.015 4.5-4.5S14.485 12 12 12z"></path>
                                </svg>
                            </div>
                        </div>
                    </div>
                    <!-- Other Stats Card (if needed) -->
                    <!-- Add more cards here if you need to show other statistics -->
                </div>

                <!-- Transaction History Section -->
                <h2 class="text-2xl font-bold text-gray-900 mt-10 mb-6">History Transaksi</h2>
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
                    @foreach ($transactions as $transaction)
                    <div class="item-card bg-white rounded-xl shadow-md overflow-hidden hover:shadow-lg transition-shadow duration-300 transform hover:-translate-y-1" data-transaction-id="{{ $transaction->id }}">
                        <div class="p-6">
                            <h3 class="text-lg font-semibold text-gray-800 mb-2">Transaction ID: {{ $transaction->id }}</h3>
                            <p class="text-gray-500 mb-1">Nama Pelanggan: {{ $transaction->pelanggan->name }}</p>
                            <p class="text-gray-500 mb-1">Date: {{ $transaction->created_at->format('d-m-Y') }}</p>
                            <p class="text-gray-700 font-bold mt-4">Total: Rp. {{ number_format($transaction->total, 2, ',', '.') }}</p>
                        </div>
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
                <button id="view-pdf" class="mt-4 bg-blue-500 hover:bg-blue-600 text-white font-bold py-2 px-4 rounded">
                    View PDF
                </button>
            </div>
        </div>
        <script>
            document.addEventListener('DOMContentLoaded', () => {
                const modal = document.getElementById('transaction-modal');
                const closeModal = document.getElementsByClassName('close')[0];
                const transactionDetailsContainer = document.getElementById('transaction-details');
                const downloadPdfButton = document.getElementById('download-pdf');
                const viewPdfButton = document.getElementById('view-pdf');
                let currentTransactionData = null;

                document.querySelectorAll('.item-card').forEach(card => {
                    card.addEventListener('click', () => {
                        const transactionId = card.getAttribute('data-transaction-id');
                        fetch(`/api/v1/transactions/${transactionId}/details`)
                            .then(response => response.json())
                            .then(data => {
                                currentTransactionData = data;
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

                viewPdfButton.addEventListener('click', () => {
                    if (currentTransactionData) {
                        const { jsPDF } = window.jspdf;
                        const doc = new jsPDF({
                            unit: 'mm',
                            format: [90, 297],
                            orientation: 'portrait'
                        });

                        const lineHeight = 5;
                        let yPos = 10;

                        // Header
                        doc.setFontSize(12);
                        doc.setFont('helvetica', 'bold');
                        doc.text('Transaction Receipt', 40, yPos, { align: 'center' });
                        yPos += lineHeight * 2;

                        doc.setFontSize(8);
                        doc.setFont('helvetica', 'normal');

                        // Transaction ID and Date
                        doc.text(`Transaction ID: ${currentTransactionData[0].transaction_id}`, 5, yPos);
                        yPos += lineHeight;
                        doc.text(`Date: ${new Date().toLocaleString()}`, 5, yPos);
                        yPos += lineHeight * 2;

                        // Column headers
                        doc.setFont('helvetica', 'bold');
                        doc.text('Item', 5, yPos);
                        doc.text('Qty', 45, yPos);
                        doc.text('Price', 55, yPos);
                        doc.text('Total', 70, yPos);
                        yPos += lineHeight;

                        // Separator line
                        doc.line(5, yPos, 75, yPos);
                        yPos += lineHeight;

                        // Items
                        doc.setFont('helvetica', 'normal');
                        let totalAmount = 0;
                        currentTransactionData.forEach((detail) => {
                            const itemName = detail.namaproduk.length > 20 ? detail.namaproduk.substring(0, 17) + '...' : detail.namaproduk;
                            doc.text(itemName, 5, yPos);
                            doc.text(detail.quantity.toString(), 45, yPos);
                            doc.text(formatCurrency(detail.total), 55, yPos);
                            doc.text(formatCurrency(detail.harga), 70, yPos);
                            yPos += lineHeight;

                            totalAmount += parseFloat(detail.harga);

                            if (yPos > 280) {
                                doc.addPage();
                                yPos = 10;
                            }
                        });

                        // Separator line
                        yPos += lineHeight / 2;
                        doc.line(5, yPos, 75, yPos);
                        yPos += lineHeight;

                        // Total
                        doc.setFont('helvetica', 'bold');
                        doc.text('Total:', 55, yPos);
                        doc.text(formatCurrency(totalAmount), 70, yPos);

                        // Footer
                        yPos += lineHeight * 3;
                        doc.setFont('helvetica', 'normal');
                        doc.setFontSize(6);
                        doc.text('Thank you for your purchase!', 40, yPos, { align: 'center' });

                        // Create a Blob from the PDF and open it in a new tab
                        const blob = doc.output('blob');
                        const url = URL.createObjectURL(blob);
                        window.open(url, '_blank');
                    }
                });

                function formatCurrency(amount) {
                    return parseFloat(amount).toLocaleString('id-ID', { minimumFractionDigits: 2, maximumFractionDigits: 2 });
                }

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
