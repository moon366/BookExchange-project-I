<?php include '../includes/header.php'; ?>

<section class="page-section">
    <div id="book-detail"></div>
</section>

<script>
async function loadBookDetail() {
    const params = new URLSearchParams(window.location.search);
    const id = params.get('id');
    const container = document.getElementById('book-detail');
    if (!id) { container.innerHTML = '<p>No book specified.</p>'; return; }
    try {
        const b = await apiGet(`get_book.php?id=${id}`);
        container.innerHTML = `
            <div class="detail-card">
                <img src="${b.image_url || '/book-exchange/uploads/placeholder.svg'}" alt="${b.title}" class="detail-img">
                <div class="detail-info">
                    <h1>${b.title}</h1>
                    <p class="author">by ${b.author || 'Unknown'}</p>
                    <p class="price">$${parseFloat(b.price).toFixed(2)}
                    ${b.original_price ? `<span class="orig-price"> (Orig: $${parseFloat(b.original_price).toFixed(2)})</span>` : ''}
                    </p>
                    ${b.district ? `<p class="location">📍 ${b.district}${b.location ? ` (${b.location})` : ''}</p>` : b.location ? `<p class="location">📍 ${b.location}</p>` : ''}
                    <span class="condition-tag ${b.condition_type}">${b.condition_type}</span>
                    ${b.condition_notes ? `<p class="notes">${b.condition_notes}</p>` : ''}
                    <p class="desc">${b.description || 'No description.'}</p>
                    <p class="seller">Seller: ${b.seller_name}</p>
                    <div id="seller-reviews" class="seller-reviews"></div>
                    <div class="buy-section">
                        <label for="delivery-location">Enter your delivery location:</label>
                        <input type="text" id="delivery-location" placeholder="e.g. 123 Main St, New York, NY" required>
                        <button class="btn-buy" data-id="${b.id}">Buy Now</button>
                        <div id="buy-msg"></div>
                    </div>
                </div>
            </div>
        `;
        document.querySelector('.btn-buy')?.addEventListener('click', async (e) => {
            const msg = document.getElementById('buy-msg');
            const loc = document.getElementById('delivery-location').value.trim();
            if (!loc) {
                msg.innerHTML = '<p class="error">Please enter your delivery location.</p>';
                return;
            }
            try {
                await apiPost('place_order.php', { book_id: e.target.dataset.id, delivery_location: loc });
                msg.innerHTML = '<p class="success">Order placed! The seller will review your delivery location.</p>';
                document.querySelector('.btn-buy').disabled = true;
            } catch (err) {
                msg.innerHTML = `<p class="error">${err.message}</p>`;
            }
        });
        loadSellerReviews(b.seller_id);
    } catch (err) {
        container.innerHTML = `<p class="error">${err.message}</p>`;
    }
}
document.addEventListener('DOMContentLoaded', loadBookDetail);
async function loadSellerReviews(sellerId) {
    const container = document.getElementById('seller-reviews');
    if (!container) return;
    try {
        const data = await apiGet(`get_seller_reviews.php?seller_id=${sellerId}`);
        if (data.total === 0) {
            container.innerHTML = '<p class="no-reviews">No reviews yet for this seller.</p>';
            return;
        }
        const stars = '★'.repeat(Math.round(data.average)) + '☆'.repeat(5 - Math.round(data.average));
        container.innerHTML = `
            <h3>Seller Rating: ${stars} (${data.average}/5 from ${data.total} review${data.total !== 1 ? 's' : ''})</h3>
            ${data.reviews.map(r => `
                <div class="review-card">
                    <p>${'★'.repeat(r.rating)}${'☆'.repeat(5 - r.rating)} — <strong>${r.reviewer_name}</strong></p>
                    ${r.comment ? `<p>${r.comment}</p>` : ''}
                    <p class="review-date">${new Date(r.created_at).toLocaleDateString()} on "${r.book_title}"</p>
                </div>
            `).join('')}
        `;
    } catch (err) {
        container.innerHTML = '';
    }
}
</script>
<?php include '../includes/footer.php'; ?>
