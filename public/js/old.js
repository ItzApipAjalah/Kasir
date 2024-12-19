document.addEventListener('DOMContentLoaded', () => {
    const selectedItems = {};
    const selectedItemsContainer = document.getElementById('selected-items');
    const totalPriceElement = document.getElementById('total-price');
    const inputProdukId = document.getElementById('input-produk-id');
    const addByIdButton = document.getElementById('add-by-id-button');
    const inputError = document.getElementById('input-error');
    const confirmTransactionButton = document.getElementById('confirm-transaction');
    const transactionModal = document.getElementById('transaction-modal');
    const closeModalButton = document.getElementById('close-modal');
    const submitTransactionButton = document.getElementById('submit-transaction');
    const transactionTableBody = document.getElementById('transaction-table-body');
    const transactionTotalPrice = document.getElementById('transaction-total-price');
    const customerSelect = document.getElementById('customer-select');

    document.querySelectorAll('.item-card').forEach(card => {
        card.addEventListener('click', () => {
            const produkId = card.getAttribute('data-produk-id');
            const namaProduk = card.getAttribute('data-namaproduk');
            const harga = parseFloat(card.getAttribute('data-harga'));

            addItem(produkId, namaProduk, harga);
        });
    });

    addByIdButton.addEventListener('click', () => {
        const produkId = inputProdukId.value.trim();
        if (produkId) {
            const itemCard = document.querySelector(`.item-card[data-produk-id="${produkId}"]`);
            if (itemCard) {
                const namaProduk = itemCard.getAttribute('data-namaproduk');
                const harga = parseFloat(itemCard.getAttribute('data-harga'));
                addItem(produkId, namaProduk, harga);
                inputError.textContent = '';
            } else {
                alert('Produk ID tidak ditemukan.');
            }
        }
    });

    function addItem(produkId, namaProduk, harga) {
        if (selectedItems[produkId]) {
            selectedItems[produkId].quantity++;
        } else {
            selectedItems[produkId] = {
                produkId,
                namaProduk,
                harga,
                quantity: 1
            };
        }
        updateSelectedItems();
        updateTotalPrice();
    }

    function removeItem(produkId) {
        if (selectedItems[produkId]) {
            selectedItems[produkId].quantity--;
            if (selectedItems[produkId].quantity <= 0) {
                delete selectedItems[produkId];
            }
            updateSelectedItems();
            updateTotalPrice();
        }
    }

    function updateSelectedItems() {
        selectedItemsContainer.innerHTML = '';
        for (const item of Object.values(selectedItems)) {
            const itemElement = document.createElement('div');
            itemElement.className = 'flex justify-between items-center mb-4';
            itemElement.innerHTML = `
                <span class="font-semibold">${item.namaProduk} (x${item.quantity})</span>
                <div class="item-controls">
                    <button onclick="removeItem('${item.produkId}')">-</button>
                    <span>Rp. ${formatCurrency(item.harga * item.quantity)}</span>
                </div>
            `;
            selectedItemsContainer.appendChild(itemElement);
        }
    }

    function updateTotalPrice() {
        let total = 0;
        for (const item of Object.values(selectedItems)) {
            total += item.harga * item.quantity;
        }
        totalPriceElement.textContent = `Rp. ${formatCurrency(total)}`;
    }

    function formatCurrency(value) {
        return value.toFixed(2).replace(/\d(?=(\d{3})+\.)/g, '$&,');
    }

    async function fetchCustomers() {
        try {
            const response = await fetch('http://127.0.0.1:8000/customers/list');
            const customers = await response.json();

            customerSelect.innerHTML = '';
            customers.forEach(customer => {
                const option = document.createElement('option');
                option.value = customer.id;
                option.textContent = customer.name;
                customerSelect.appendChild(option);
            });
        } catch (error) {
            console.error('Failed to fetch customers:', error);
        }
    }

    function showTransactionModal() {
        transactionTableBody.innerHTML = '';
        let total = 0;

        for (const item of Object.values(selectedItems)) {
            const row = document.createElement('tr');
            row.innerHTML = `
                <td>${item.produkId}</td>
                <td>${item.namaProduk}</td>
                <td>Rp. ${formatCurrency(item.harga)}</td>
                <td>${item.quantity}</td>
                <td>Rp. ${formatCurrency(item.harga * item.quantity)}</td>
            `;
            transactionTableBody.appendChild(row);
            total += item.harga * item.quantity;
        }

        transactionTotalPrice.textContent = formatCurrency(total);
        transactionModal.style.display = 'flex';
        fetchCustomers(); // Fetch customers when the modal is shown
    }

    function hideTransactionModal() {
        transactionModal.style.display = 'none';
    }

    confirmTransactionButton.addEventListener('click', showTransactionModal);
    closeModalButton.addEventListener('click', hideTransactionModal);

    submitTransactionButton.addEventListener('click', async () => {
        const customerId = customerSelect.value;
        const staffId = 1; // Replace with actual staff ID

        if (!customerId) {
            alert('Please select a customer.');
            return;
        }

        const transactionData = {
            items: Object.values(selectedItems),
            total: parseFloat(transactionTotalPrice.textContent.replace(/,/g, '')),
            customer_id: customerId,
            staff_id: staffId
        };

        try {
            const response = await fetch('http://127.0.0.1:8000/transactions', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                },
                body: JSON.stringify(transactionData)
            });

            const responseText = await response.text();
            if (response.ok) {
                const result = JSON.parse(responseText);
                Swal.fire({
                    title: 'Success!',
                    text: 'Transaction Submitted Successfully!',
                    icon: 'success',
                    confirmButtonText: 'OK'
                });
                // Clear selected items after submission
                for (const produkId of Object.keys(selectedItems)) {
                    removeItem(produkId);
                }
                hideTransactionModal();
            } else {
                Swal.fire({
                    title: 'Error!',
                    text: 'Something went wrong: ' + responseText,
                    icon: 'error',
                    confirmButtonText: 'OK'
                });
            }
        } catch (error) {
            Swal.fire({
                title: 'Network Error!',
                text: 'Failed to submit transaction: ' + error.message,
                icon: 'error',
                confirmButtonText: 'OK'
            });
        }
    });

    window.removeItem = removeItem;
});
