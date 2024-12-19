<!DOCTYPE html>
<html>
<head>
    <title>Transaction Receipt</title>
    <style>
        body { font-family: Arial, sans-serif; font-size: 10pt; }
        .header { text-align: center; font-size: 14pt; font-weight: bold; margin-bottom: 20px; }
        .details { margin-bottom: 20px; }
        table { width: 100%; border-collapse: collapse; }
        th, td { border: 1px solid #ddd; padding: 8px; text-align: left; }
        th { background-color: #f2f2f2; }
        .total { font-weight: bold; }
    </style>
</head>
<body>
    <div class="header">Transaction Receipt</div>

    <div class="details">
        <p><strong>Transaction ID:</strong> {{ $transaction->id }}</p>
        <p><strong>Customer:</strong> {{ $transaction->pelanggan->name ?? 'N/A' }}</p>
        <p><strong>Date:</strong> {{ $transaction->created_at->format('d-m-Y H:i:s') }}</p>
    </div>

    <table>
        <thead>
            <tr>
                <th>Item</th>
                <th>Quantity</th>
                <th>Price</th>
                <th>Subtotal</th>
            </tr>
        </thead>
        <tbody>
            @foreach($transaction->details as $detail)
            <tr>
                <td>{{ $detail->produk->name ?? 'Unknown Product' }}</td>
                <td>{{ $detail->quantity }}</td>
                <td>Rp. {{ number_format($detail->price, 2, ',', '.') }}</td>
                <td>Rp. {{ number_format($detail->subtotal, 2, ',', '.') }}</td>
            </tr>
            @endforeach
        </tbody>
        <tfoot>
            <tr class="total">
                <td colspan="3">Total</td>
                <td>Rp. {{ number_format($transaction->total, 2, ',', '.') }}</td>
            </tr>
        </tfoot>
    </table>

    <div style="margin-top: 20px; text-align: center;">
        <p>Thank you for your purchase!</p>
    </div>
</body>
</html>
