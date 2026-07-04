async function loadOrders(role) {
  const container = document.getElementById('order-list');
  if (!container) return;
  try {
    const orders = await apiGet(`get_orders.php?role=${role}`);
    container.innerHTML = orders.length
      ? orders.map(o => {
          let actions = '';
          if (role === 'seller') {
            if (!o.location_finalized) {
              actions = `<button class="btn-finalize" data-order-id="${o.id}">Finalize Location</button>
                         <button class="btn-cancel-order" data-order-id="${o.id}">Cancel</button>`;
            } else if (o.status !== 'completed' && o.status !== 'cancelled') {
              actions = `
                <select class="status-select" data-order-id="${o.id}">
                  <option value="">Update status</option>
                  ${o.status === 'confirmed' ? '<option value="shipped">Ship</option>' : ''}
                  ${o.status === 'shipped' ? '<option value="completed">Complete</option>' : ''}
                  <option value="cancelled">Cancel</option>
                </select>`;
            }
          } else if (role === 'buyer' && o.status === 'completed' && !o.has_review) {
            actions = `
              <div class="review-form" data-order-id="${o.id}">
                <select class="review-rating">
                  <option value="5">★★★★★</option>
                  <option value="4">★★★★</option>
                  <option value="3">★★★</option>
                  <option value="2">★★</option>
                  <option value="1">★</option>
                </select>
                <input type="text" class="review-comment" placeholder="Optional comment">
                <button class="btn-submit-review" data-order-id="${o.id}">Leave Review</button>
              </div>`;
          } else if (role === 'buyer' && o.has_review) {
            actions = '<p class="review-done">✓ You reviewed this order</p>';
          }
          return `
            <div class="order-item" data-id="${o.id}">
              <p><strong>${o.book_title}</strong></p>
              <p>Price: $${parseFloat(o.price).toFixed(2)}</p>
              <p>${role === 'buyer' ? 'Seller' : 'Buyer'}: ${role === 'buyer' ? o.seller_name : o.buyer_name}</p>
              ${o.delivery_location ? `<p>📍 Deliver to: ${o.delivery_location}</p>` : ''}
              <p>Status: <span class="status-${o.status}">${o.status}</span>
              ${!o.location_finalized && role === 'seller' ? ' <em>(awaiting location finalization)</em>' : ''}
              </p>
              ${actions}
            </div>
          `;
        }).join('')
      : '<p>No orders found.</p>';

    document.querySelectorAll('.status-select').forEach(sel => {
      sel.addEventListener('change', async (e) => {
        try {
          await apiPost('update_order_status.php', { order_id: e.target.dataset.orderId, status: e.target.value });
          loadOrders(role);
        } catch (err) {
          alert(err.message);
        }
      });
    });
    document.querySelectorAll('.btn-finalize').forEach(btn => {
      btn.addEventListener('click', async (e) => {
        if (!confirm('Finalize this delivery location?')) return;
        try {
          await apiPost('finalize_location.php', { order_id: e.target.dataset.orderId });
          loadOrders(role);
        } catch (err) {
          alert(err.message);
        }
      });
    });
    document.querySelectorAll('.btn-cancel-order').forEach(btn => {
      btn.addEventListener('click', async (e) => {
        if (!confirm('Cancel this order?')) return;
        try {
          await apiPost('update_order_status.php', { order_id: e.target.dataset.orderId, status: 'cancelled' });
          loadOrders(role);
        } catch (err) {
          alert(err.message);
        }
      });
    });
    document.querySelectorAll('.btn-submit-review').forEach(btn => {
      btn.addEventListener('click', async (e) => {
        const orderId = e.target.dataset.orderId;
        const formEl = e.target.closest('.review-form');
        const rating = formEl.querySelector('.review-rating').value;
        const comment = formEl.querySelector('.review-comment').value;
        try {
          await apiPost('add_review.php', { order_id: orderId, rating, comment });
          loadOrders(role);
        } catch (err) {
          alert(err.message);
        }
      });
    });
  } catch (err) {
    container.innerHTML = `<p class="error">${err.message}</p>`;
  }
}