<?php
session_start();
if (empty($_SESSION['user_id'])) {
    header('Location: login.php');
    exit;
}
include '../includes/header.php';
$userId = $_SESSION['user_id'];
$userName = htmlspecialchars($_SESSION['name'] ?? 'Guest');
$initial = strtoupper($userName[0] ?? 'U');
?>
<section class="dash-page">
    <!-- Welcome -->
    <div class="dash-welcome">
        <div class="dash-avatar"><?php echo $initial; ?></div>
        <div class="dash-welcome-text">
            <h1 class="dash-welcome-title">Welcome back, <?php echo $userName; ?>!</h1>
            <p class="dash-welcome-sub">Here's an overview of your account.</p>
        </div>
    </div>

    <!-- Stats -->
    <div class="dash-stats" id="dash-stats">
        <div class="dash-stat-card"><div class="stat-icon stat-icon-blue">📚</div><div class="stat-body"><span class="stat-num" id="stat-listings">—</span><span class="stat-label">Listed Books</span></div></div>
        <div class="dash-stat-card"><div class="stat-icon stat-icon-amber">📦</div><div class="stat-body"><span class="stat-num" id="stat-orders">—</span><span class="stat-label">Active Orders</span></div></div>
        <div class="dash-stat-card"><div class="stat-icon stat-icon-green">✅</div><div class="stat-body"><span class="stat-num" id="stat-sold">—</span><span class="stat-label">Books Sold</span></div></div>
        <div class="dash-stat-card"><div class="stat-icon stat-icon-purple">💰</div><div class="stat-body"><span class="stat-num" id="stat-earnings">—</span><span class="stat-label">Total Earnings</span></div></div>
    </div>

    <div class="dash-layout">
        <div class="dash-main">
            <!-- My Listings -->
            <section class="dash-section-card">
                <div class="dash-card-header">
                    <h2 class="dash-card-title">My Listings</h2>
                    <a href="my-listings.php" class="dash-link">Manage All &rarr;</a>
                </div>
                <div class="dash-listing-grid" id="dash-listings">
                    <p class="dash-loading">Loading...</p>
                </div>
            </section>

            <!-- My Orders -->
            <section class="dash-section-card">
                <div class="dash-card-header">
                    <h2 class="dash-card-title">My Orders</h2>
                    <a href="orders.php" class="dash-link">View All &rarr;</a>
                </div>
                <div id="dash-orders"><p class="dash-loading">Loading...</p></div>
            </section>
        </div>

        <aside class="dash-sidebar">
            <!-- Quick Actions -->
            <section class="dash-side-card">
                <h2 class="dash-card-title">Quick Actions</h2>
                <div class="dash-actions">
                    <a href="sell-book.php" class="dash-action-btn"><span class="dash-action-icon">➕</span> Sell a Book</a>
                    <a href="browse.php" class="dash-action-btn"><span class="dash-action-icon">🔍</span> Browse Books</a>
                    <a href="my-listings.php" class="dash-action-btn"><span class="dash-action-icon">📋</span> My Listings</a>
                    <a href="orders.php" class="dash-action-btn"><span class="dash-action-icon">📦</span> My Orders</a>
                </div>
            </section>

            <!-- Recent Activity -->
            <section class="dash-side-card">
                <h2 class="dash-card-title">Recent Activity</h2>
                <div id="dash-activity"><p class="dash-loading">Loading...</p></div>
            </section>
        </aside>
    </div>
</section>

<!-- Edit Modal -->
<div id="edit-modal" class="dash-modal-overlay" hidden>
    <div class="dash-modal-box">
        <button type="button" class="dash-modal-close" id="edit-cancel">&times;</button>
        <h2 class="dash-modal-title">Edit Listing</h2>
        <form id="edit-form" enctype="multipart/form-data">
            <input type="hidden" id="edit-id">
            <div class="dash-modal-row">
                <div class="dash-modal-field flex-2">
                    <label for="edit-title">Title *</label>
                    <input type="text" id="edit-title" required>
                </div>
                <div class="dash-modal-field">
                    <label for="edit-author">Author</label>
                    <input type="text" id="edit-author">
                </div>
            </div>
            <div class="dash-modal-field">
                <label for="edit-description">Description</label>
                <textarea id="edit-description" rows="3"></textarea>
            </div>
            <div class="dash-modal-row">
                <div class="dash-modal-field">
                    <label for="edit-condition_type">Condition *</label>
                    <select id="edit-condition_type">
                        <option value="new">New</option>
                        <option value="used">Used</option>
                    </select>
                </div>
                <div class="dash-modal-field">
                    <label for="edit-price">Price ($) *</label>
                    <input type="number" id="edit-price" step="0.01" min="0" required>
                </div>
            </div>
            <div class="dash-modal-row">
                <div class="dash-modal-field">
                    <label for="edit-district">District</label>
                    <select id="edit-district">
                        <option value="">Select district</option>
                        <optgroup label="Koshi"><option value="Bhojpur">Bhojpur</option><option value="Dhankuta">Dhankuta</option><option value="Ilam">Ilam</option><option value="Jhapa">Jhapa</option><option value="Khotang">Khotang</option><option value="Morang">Morang</option><option value="Okhaldhunga">Okhaldhunga</option><option value="Panchthar">Panchthar</option><option value="Sankhuwasabha">Sankhuwasabha</option><option value="Solukhumbu">Solukhumbu</option><option value="Sunsari">Sunsari</option><option value="Taplejung">Taplejung</option><option value="Terhathum">Terhathum</option><option value="Udayapur">Udayapur</option></optgroup>
                        <optgroup label="Madhesh"><option value="Bara">Bara</option><option value="Dhanusha">Dhanusha</option><option value="Mahottari">Mahottari</option><option value="Parsa">Parsa</option><option value="Rautahat">Rautahat</option><option value="Saptari">Saptari</option><option value="Sarlahi">Sarlahi</option><option value="Siraha">Siraha</option></optgroup>
                        <optgroup label="Bagmati"><option value="Bhaktapur">Bhaktapur</option><option value="Chitwan">Chitwan</option><option value="Dhading">Dhading</option><option value="Dolakha">Dolakha</option><option value="Kathmandu">Kathmandu</option><option value="Kavrepalanchok">Kavrepalanchok</option><option value="Lalitpur">Lalitpur</option><option value="Makwanpur">Makwanpur</option><option value="Nuwakot">Nuwakot</option><option value="Ramechhap">Ramechhap</option><option value="Rasuwa">Rasuwa</option><option value="Sindhuli">Sindhuli</option><option value="Sindhupalchok">Sindhupalchok</option></optgroup>
                        <optgroup label="Gandaki"><option value="Baglung">Baglung</option><option value="Gorkha">Gorkha</option><option value="Kaski">Kaski</option><option value="Lamjung">Lamjung</option><option value="Manang">Manang</option><option value="Mustang">Mustang</option><option value="Myagdi">Myagdi</option><option value="Nawalpur">Nawalpur</option><option value="Parbat">Parbat</option><option value="Syangja">Syangja</option><option value="Tanahu">Tanahu</option></optgroup>
                        <optgroup label="Lumbini"><option value="Arghakhanchi">Arghakhanchi</option><option value="Banke">Banke</option><option value="Bardiya">Bardiya</option><option value="Dang">Dang</option><option value="Gulmi">Gulmi</option><option value="Kapilvastu">Kapilvastu</option><option value="Palpa">Palpa</option><option value="Pyuthan">Pyuthan</option><option value="Rolpa">Rolpa</option><option value="East Rukum">East Rukum</option><option value="Rupandehi">Rupandehi</option><option value="West Nawalparasi">West Nawalparasi</option></optgroup>
                        <optgroup label="Karnali"><option value="Dailekh">Dailekh</option><option value="Dolpa">Dolpa</option><option value="Humla">Humla</option><option value="Jajarkot">Jajarkot</option><option value="Jumla">Jumla</option><option value="Kalikot">Kalikot</option><option value="Mugu">Mugu</option><option value="Salyan">Salyan</option><option value="Surkhet">Surkhet</option><option value="West Rukum">West Rukum</option></optgroup>
                        <optgroup label="Sudurpashchim"><option value="Achham">Achham</option><option value="Baitadi">Baitadi</option><option value="Bajhang">Bajhang</option><option value="Bajura">Bajura</option><option value="Dadeldhura">Dadeldhura</option><option value="Darchula">Darchula</option><option value="Doti">Doti</option><option value="Kailali">Kailali</option><option value="Kanchanpur">Kanchanpur</option></optgroup>
                    </select>
                </div>
                <div class="dash-modal-field">
                    <label for="edit-location">Specific Location</label>
                    <input type="text" id="edit-location">
                </div>
            </div>
            <div class="dash-modal-field">
                <label for="edit-image">Replace Cover Image</label>
                <input type="file" id="edit-image" accept="image/jpeg,image/png,image/gif,image/webp">
            </div>
            <div class="dash-modal-actions">
                <button type="submit" class="dash-btn dash-btn-primary">Save Changes</button>
                <button type="button" id="edit-cancel-btn" class="dash-btn dash-btn-secondary">Cancel</button>
            </div>
        </form>
        <div id="edit-msg" class="dash-msg"></div>
    </div>
</div>

<script>
const USER_ID = <?php echo $userId; ?>;

async function loadDashboard() {
    try {
        const [listings, buyerOrders, sellerOrders] = await Promise.all([
            apiGet(`get_books.php?seller_id=${USER_ID}`),
            apiGet('get_orders.php?role=buyer'),
            apiGet('get_orders.php?role=seller')
        ]);

        const allOrders = [...(buyerOrders||[]), ...(sellerOrders||[])];

        // Stats
        const activeOrders = allOrders.filter(o => ['pending','confirmed','shipped'].includes(o.status)).length;
        const soldBooks = (sellerOrders||[]).filter(o => o.status === 'completed').length;
        const earnings = (sellerOrders||[]).filter(o => o.status === 'completed').reduce((s, o) => s + parseFloat(o.price || 0), 0);

        document.getElementById('stat-listings').textContent = listings.length;
        document.getElementById('stat-orders').textContent = activeOrders;
        document.getElementById('stat-sold').textContent = soldBooks;
        document.getElementById('stat-earnings').textContent = `$${earnings.toFixed(0)}`;

        // Listings grid
        const listContainer = document.getElementById('dash-listings');
        if (listings.length) {
            listContainer.innerHTML = listings.slice(0, 6).map(b => `
                <div class="dash-listing-card" data-id="${b.id}">
                    <div class="dash-listing-img-wrap">
                        <img src="${b.image_url || '/book-exchange/uploads/placeholder.svg'}" alt="${b.title}" class="dash-listing-img" loading="lazy">
                        <span class="dash-listing-badge badge-${b.condition_type}">${b.condition_type}</span>
                    </div>
                    <div class="dash-listing-body">
                        <h3 class="dash-listing-title">${b.title}</h3>
                        <p class="dash-listing-author">${b.author || 'Unknown'}</p>
                        <div class="dash-listing-meta">
                            <span class="dash-listing-price">$${parseFloat(b.price).toFixed(2)}</span>
                            <span class="dash-listing-status status-${b.status}">${b.status}</span>
                        </div>
                        <div class="dash-listing-actions">
                            <button class="dash-act-btn dash-act-edit" data-id="${b.id}">Edit</button>
                            ${b.status === 'available' ? `<button class="dash-act-btn dash-act-sold" data-id="${b.id}">Mark Sold</button>` : ''}
                            <button class="dash-act-btn dash-act-delete" data-id="${b.id}">Delete</button>
                        </div>
                    </div>
                </div>
            `).join('');
        } else {
            listContainer.innerHTML = `<div class="dash-empty"><p>You haven't listed any books yet.</p><a href="sell-book.php" class="dash-btn dash-btn-primary">Sell Your First Book</a></div>`;
        }

        // Orders
        const ordContainer = document.getElementById('dash-orders');
        if (allOrders.length) {
            const rows = allOrders.slice(0, 5).map(o => {
                const isSeller = sellerOrders && sellerOrders.some(so => so.id === o.id);
                const partner = isSeller ? o.buyer_name : o.seller_name;
                const roleLabel = isSeller ? 'Sale' : 'Purchase';
                return `
                    <div class="dash-order-row">
                        <div class="dash-order-info">
                            <strong class="dash-order-title">${o.book_title}</strong>
                            <span class="dash-order-partner">${isSeller ? 'Buyer' : 'Seller'}: ${partner || 'N/A'}</span>
                            <span class="dash-order-date">${new Date(o.created_at).toLocaleDateString()}</span>
                        </div>
                        <div class="dash-order-right">
                            <span class="status-${o.status}">${o.status}</span>
                            <span class="dash-order-role">${roleLabel}</span>
                        </div>
                    </div>
                `;
            }).join('');
            ordContainer.innerHTML = `<div class="dash-order-list">${rows}</div>`;
        } else {
            ordContainer.innerHTML = `
                <div class="dash-empty">
                    <p>You haven't placed or received any orders yet.</p>
                    <a href="browse.php" class="dash-btn dash-btn-primary">Browse Books</a>
                </div>`;
        }

        // Activity
        const activities = [];
        (listings||[]).slice(0, 3).forEach(b => {
            activities.push({ date: b.created_at, text: `Listed <strong>${b.title}</strong> for $${parseFloat(b.price).toFixed(2)}`, type: 'listing' });
        });
        (allOrders||[]).slice(0, 3).forEach(o => {
            const isSeller = sellerOrders && sellerOrders.some(so => so.id === o.id);
            const action = o.status === 'completed' ? 'Completed' : o.status === 'cancelled' ? 'Cancelled' : 'Received';
            activities.push({ date: o.created_at, text: `${action} order for <strong>${o.book_title}</strong>`, type: 'order' });
        });
        activities.sort((a, b) => new Date(b.date) - new Date(a.date));

        const actContainer = document.getElementById('dash-activity');
        if (activities.length) {
            actContainer.innerHTML = activities.slice(0, 5).map(a => `
                <div class="dash-activity-item">
                    <span class="dash-activity-dot ${a.type}"></span>
                    <span class="dash-activity-text">${a.text}</span>
                    <span class="dash-activity-date">${new Date(a.date).toLocaleDateString()}</span>
                </div>
            `).join('');
        } else {
            actContainer.innerHTML = '<p class="dash-empty-sm">No activity yet.</p>';
        }
    } catch (err) {
        document.getElementById('dash-listings').innerHTML = `<p class="dash-error">${err.message}</p>`;
        document.getElementById('dash-orders').innerHTML = `<p class="dash-error">${err.message}</p>`;
    }

    // Attach listing action listeners
    document.querySelectorAll('.dash-act-edit').forEach(btn => {
        btn.addEventListener('click', () => openEditModal(btn.dataset.id));
    });
    document.querySelectorAll('.dash-act-delete').forEach(btn => {
        btn.addEventListener('click', async () => {
            if (!confirm('Delete this listing?')) return;
            try {
                await apiPost('delete_book.php', { id: btn.dataset.id });
                loadDashboard();
            } catch (err) { alert(err.message); }
        });
    });
    document.querySelectorAll('.dash-act-sold').forEach(btn => {
        btn.addEventListener('click', async () => {
            if (!confirm('Mark this book as sold?')) return;
            try {
                await apiPost('mark_sold.php', { id: btn.dataset.id });
                loadDashboard();
            } catch (err) { alert(err.message); }
        });
    });
}

// Edit modal
const editModal = document.getElementById('edit-modal');
document.getElementById('edit-cancel').addEventListener('click', () => { editModal.hidden = true; });
document.getElementById('edit-cancel-btn').addEventListener('click', () => { editModal.hidden = true; });

async function openEditModal(id) {
    document.getElementById('edit-msg').innerHTML = '';
    try {
        const b = await apiGet(`get_book.php?id=${id}`);
        document.getElementById('edit-id').value = b.id;
        document.getElementById('edit-title').value = b.title || '';
        document.getElementById('edit-author').value = b.author || '';
        document.getElementById('edit-description').value = b.description || '';
        document.getElementById('edit-condition_type').value = b.condition_type;
        document.getElementById('edit-price').value = b.price;
        document.getElementById('edit-district').value = b.district || '';
        document.getElementById('edit-location').value = b.location || '';
        editModal.hidden = false;
    } catch (err) { alert(err.message); }
}

document.getElementById('edit-form').addEventListener('submit', async (e) => {
    e.preventDefault();
    const msg = document.getElementById('edit-msg');
    const fd = new FormData();
    fd.append('id', document.getElementById('edit-id').value);
    fd.append('title', document.getElementById('edit-title').value);
    fd.append('author', document.getElementById('edit-author').value);
    fd.append('description', document.getElementById('edit-description').value);
    fd.append('condition_type', document.getElementById('edit-condition_type').value);
    fd.append('price', document.getElementById('edit-price').value);
    fd.append('district', document.getElementById('edit-district').value);
    fd.append('location', document.getElementById('edit-location').value);
    const fi = document.getElementById('edit-image');
    if (fi.files[0]) fd.append('image', fi.files[0]);
    try {
        await apiPost('update_book.php', fd);
        editModal.hidden = true;
        loadDashboard();
    } catch (err) { msg.innerHTML = `<p class="dash-msg-error">${err.message}</p>`; }
});

document.addEventListener('DOMContentLoaded', loadDashboard);
</script>
<?php include '../includes/footer.php'; ?>
