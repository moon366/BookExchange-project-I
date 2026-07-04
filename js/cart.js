async function placeOrder(bookId) {
  try {
    const result = await apiPost('place_order.php', { book_id: bookId });
    alert('Order placed successfully!');
    window.location.href = '/book-exchange/pages/orders.php';
  } catch (err) {
    alert(err.message);
  }
}

async function loadCart() {
  try {
    const orders = await apiGet('get_orders.php?role=buyer');
    const container = document.getElementById('cart-list');
    if (!container) return;
    container.innerHTML = orders.length
      ? orders.map(o => `
        <div class="order-item" data-id="${o.id}">
          <p><strong>${o.book_title}</strong></p>
          <p>Price: $${parseFloat(o.price).toFixed(2)}</p>
          <p>Seller: ${o.seller_name}</p>
          <p>Status: <span class="status-${o.status}">${o.status}</span></p>
        </div>
      `).join('')
      : '<p>No orders yet.</p>';
  } catch (err) {
    const container = document.getElementById('cart-list');
    if (container) container.innerHTML = `<p class="error">${err.message}</p>`;
  }
}
