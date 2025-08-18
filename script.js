// Function to render transactions in the table
function renderTransactionTable(transactions) {
    const tableBody = document.getElementById('historyTable');

    if (!transactions || transactions.length === 0) {
        tableBody.innerHTML = `<tr>
            <td colspan="6" style="text-align:center; padding:2rem;">No transactions yet.</td>
        </tr>`;
        return;
    }

    tableBody.innerHTML = transactions.map(t => `
        <tr>
            <td>${t.description}</td>
            <td>${t.type}</td>
            <td class="${t.type}">${t.type==='income'?'+':'-'}₹${parseFloat(t.amount).toLocaleString('en-IN')}</td>
            <td>${t.category}</td>
            <td>${new Date(t.date).toLocaleDateString('en-IN', {day:'2-digit',month:'short',year:'numeric'})}</td>
            <td><button onclick="deleteTransaction(${t.id}, '${t.type}')">Delete</button></td>
        </tr>
    `).join('');
}

// Example fetch and render
async function loadTransactions(filter = 'all') {
    try {
        const res = await fetch('fetch_data.php?filter=' + filter);
        const data = await res.json();
        if(data.ok) {
            renderTransactionTable(data.transactions);
        } else {
            console.error('Error fetching transactions');
        }
    } catch(err) {
        console.error(err);
    }
}

// Call on page load
document.addEventListener('DOMContentLoaded', () => {
    loadTransactions();
});

// Optional delete function
async function deleteTransaction(id, type) {
    if(!confirm('Are you sure you want to delete this transaction?')) return;
    try {
        await fetch(`delete_transaction.php?id=${id}&type=${type}`);
        await loadTransactions(); // reload table after deletion
    } catch(err) {
        console.error(err);
    }
}
