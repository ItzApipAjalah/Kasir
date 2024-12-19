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


        <div class="container mx-auto px-4 py-8">
            <h2 class="text-3xl font-bold text-gray-800 mb-6">Latest Transaction</h2>
            <div id="transaction-details" class="bg-white shadow-lg rounded-lg overflow-hidden">
                <!-- Transaction details will be displayed here -->
            </div>
        </div>
    </div>

    <script>
    document.addEventListener('DOMContentLoaded', function() {
        function updateTransactionDetails() {
            fetch('/display-transactions')
                .then(response => response.json())
                .then(displayTransactions => {
                    if (displayTransactions.length > 0) {
                        // Group and count items by produk_id
                        const groupedItems = displayTransactions.reduce((acc, item) => {
                            if (!acc[item.produk_id]) {
                                acc[item.produk_id] = { ...item, quantity: 0 };
                            }
                            acc[item.produk_id].quantity += item.quantity;
                            return acc;
                        }, {});

                        // Display current display transactions
                        let html = `
                            <div class="p-6">
                                <h3 class="text-2xl font-semibold text-gray-800 mb-4">Current Transaction</h3>
                                <ul class="space-y-2">
                        `;
                        Object.values(groupedItems).forEach(item => {
                            html += `
                                <li class="flex justify-between items-center bg-gray-50 p-3 rounded">
                                    <span class="font-medium text-gray-700">${item.namaproduk}</span>
                                    <span class="text-gray-600">Quantity: ${item.quantity} - Price: Rp. ${(parseFloat(item.harga) * item.quantity).toLocaleString()}</span>
                                </li>
                            `;
                        });
                        html += `
                                </ul>
                            </div>
                        `;
                        document.getElementById('transaction-details').innerHTML = html;
                    } else {
                        // Fetch and display the latest completed transaction
                        fetch('/latest-transaction')
                            .then(response => response.json())
                            .then(latestTransaction => {
                                if (latestTransaction) {
                                    let html = `
                                        <div class="p-6">
                                            <h3 class="text-2xl font-semibold text-gray-800 mb-4">Latest Completed Transaction</h3>
                                            <div class="grid grid-cols-2 gap-4 mb-6">
                                                <div class="bg-gray-50 p-3 rounded">
                                                    <p class="text-sm text-gray-600">Transaction ID</p>
                                                    <p class="font-medium text-gray-800">${latestTransaction.id}</p>
                                                </div>
                                                <div class="bg-gray-50 p-3 rounded">
                                                    <p class="text-sm text-gray-600">Customer</p>
                                                    <p class="font-medium text-gray-800">${latestTransaction.customer.name}</p>
                                                </div>
                                                <div class="bg-gray-50 p-3 rounded">
                                                    <p class="text-sm text-gray-600">Staff</p>
                                                    <p class="font-medium text-gray-800">${latestTransaction.staff.name}</p>
                                                </div>
                                                <div class="bg-gray-50 p-3 rounded">
                                                    <p class="text-sm text-gray-600">Total</p>
                                                    <p class="font-medium text-gray-800">Rp. ${parseFloat(latestTransaction.total).toLocaleString()}</p>
                                                </div>
                                                <div class="bg-gray-50 p-3 rounded">
                                                    <p class="text-sm text-gray-600">Payment</p>
                                                    <p class="font-medium text-gray-800">Rp. ${parseFloat(latestTransaction.pay).toLocaleString()}</p>
                                                </div>
                                                <div class="bg-gray-50 p-3 rounded">
                                                    <p class="text-sm text-gray-600">Refund</p>
                                                    <p class="font-medium text-gray-800">Rp. ${parseFloat(latestTransaction.refund).toLocaleString()}</p>
                                                </div>
                                            </div>
                                            <h4 class="text-xl font-semibold text-gray-800 mb-3">Items:</h4>
                                            <ul class="space-y-2">
                                    `;
                                    latestTransaction.transaction_details.forEach(detail => {
                                        html += `
                                            <li class="flex justify-between items-center bg-gray-50 p-3 rounded">
                                                <span class="font-medium text-gray-700">${detail.namaproduk}</span>
                                                <span class="text-gray-600">Quantity: ${detail.quantity} - Price: Rp. ${parse Float(detail.harga).toLocaleString()}</span>
                                            </li>
                                        `;
                                    });
                                    html += `
                                            </ul>
                                        </div>
                                    `;
                                    document.getElementById('transaction-details').innerHTML = html;
                                } else {
                                    document.getElementById('transaction-details').innerHTML = '<div class="p-6"><p class="text-gray-600">No transactions found.</p></div>';
                                }
                            })
                            .catch(error => {
                                console.error('Error:', error);
                                document.getElementById('transaction-details').innerHTML = '<div class="p-6"><p class="text-red-600">Error loading transaction details.</p></div>';
                            });
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    document.getElementById('transaction-details').innerHTML = '<div class="p-6"><p class="text-red-600">Error loading transaction details.</p></div>';
                });
        }

        // Initial update
        updateTransactionDetails();

        // Set up polling to update every 5 seconds (5000 milliseconds)
        setInterval(updateTransactionDetails, 5000);
    });
    </script>
</body>

</html>
