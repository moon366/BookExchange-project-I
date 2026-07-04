<?php
session_start();
if (empty($_SESSION['user_id'])) {
    header('Location: login.php');
    exit;
}
include '../includes/header.php';
$userId = $_SESSION['user_id'];
?>

<section class="page-section">
    <h1 class="page-heading">My Listings</h1>
    <div id="my-listings"></div>

    <div id="edit-modal" class="modal-overlay" hidden>
        <div class="modal-box">
            <h2>Edit Listing</h2>
            <form id="edit-form" class="book-form" enctype="multipart/form-data">
                <input type="hidden" id="edit-id">
                <div class="form-group">
                    <label for="edit-title">Title *</label>
                    <input type="text" id="edit-title" required>
                </div>
                <div class="form-group">
                    <label for="edit-author">Author</label>
                    <input type="text" id="edit-author">
                </div>
                <div class="form-group">
                    <label for="edit-description">Description</label>
                    <textarea id="edit-description" rows="3"></textarea>
                </div>
                <div class="form-row">
                    <div class="form-group">
                        <label for="edit-condition_type">Condition *</label>
                        <select id="edit-condition_type" required>
                            <option value="new">New</option>
                            <option value="used">Used</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="edit-price">Price ($) *</label>
                        <input type="number" id="edit-price" step="0.01" min="0" required>
                    </div>
                </div>
                <div class="form-group">
                    <label for="edit-original_price">Original Price</label>
                    <input type="number" id="edit-original_price" step="0.01" min="0">
                </div>
                <div class="form-row">
                    <div class="form-group">
                        <label for="edit-district">District</label>
                        <select id="edit-district">
                            <option value="">Select district</option>
                            <optgroup label="Koshi Province">
                                <option value="Bhojpur">Bhojpur</option><option value="Dhankuta">Dhankuta</option><option value="Ilam">Ilam</option><option value="Jhapa">Jhapa</option><option value="Khotang">Khotang</option><option value="Morang">Morang</option><option value="Okhaldhunga">Okhaldhunga</option><option value="Panchthar">Panchthar</option><option value="Sankhuwasabha">Sankhuwasabha</option><option value="Solukhumbu">Solukhumbu</option><option value="Sunsari">Sunsari</option><option value="Taplejung">Taplejung</option><option value="Terhathum">Terhathum</option><option value="Udayapur">Udayapur</option>
                            </optgroup>
                            <optgroup label="Madhesh Province">
                                <option value="Bara">Bara</option><option value="Dhanusha">Dhanusha</option><option value="Mahottari">Mahottari</option><option value="Parsa">Parsa</option><option value="Rautahat">Rautahat</option><option value="Saptari">Saptari</option><option value="Sarlahi">Sarlahi</option><option value="Siraha">Siraha</option>
                            </optgroup>
                            <optgroup label="Bagmati Province">
                                <option value="Bhaktapur">Bhaktapur</option><option value="Chitwan">Chitwan</option><option value="Dhading">Dhading</option><option value="Dolakha">Dolakha</option><option value="Kathmandu">Kathmandu</option><option value="Kavrepalanchok">Kavrepalanchok</option><option value="Lalitpur">Lalitpur</option><option value="Makwanpur">Makwanpur</option><option value="Nuwakot">Nuwakot</option><option value="Ramechhap">Ramechhap</option><option value="Rasuwa">Rasuwa</option><option value="Sindhuli">Sindhuli</option><option value="Sindhupalchok">Sindhupalchok</option>
                            </optgroup>
                            <optgroup label="Gandaki Province">
                                <option value="Baglung">Baglung</option><option value="Gorkha">Gorkha</option><option value="Kaski">Kaski</option><option value="Lamjung">Lamjung</option><option value="Manang">Manang</option><option value="Mustang">Mustang</option><option value="Myagdi">Myagdi</option><option value="Nawalpur">Nawalpur</option><option value="Parbat">Parbat</option><option value="Syangja">Syangja</option><option value="Tanahu">Tanahu</option>
                            </optgroup>
                            <optgroup label="Lumbini Province">
                                <option value="Arghakhanchi">Arghakhanchi</option><option value="Banke">Banke</option><option value="Bardiya">Bardiya</option><option value="Dang">Dang</option><option value="Gulmi">Gulmi</option><option value="Kapilvastu">Kapilvastu</option><option value="Palpa">Palpa</option><option value="Pyuthan">Pyuthan</option><option value="Rolpa">Rolpa</option><option value="East Rukum">East Rukum</option><option value="Rupandehi">Rupandehi</option><option value="West Nawalparasi">West Nawalparasi</option>
                            </optgroup>
                            <optgroup label="Karnali Province">
                                <option value="Dailekh">Dailekh</option><option value="Dolpa">Dolpa</option><option value="Humla">Humla</option><option value="Jajarkot">Jajarkot</option><option value="Jumla">Jumla</option><option value="Kalikot">Kalikot</option><option value="Mugu">Mugu</option><option value="Salyan">Salyan</option><option value="Surkhet">Surkhet</option><option value="West Rukum">West Rukum</option>
                            </optgroup>
                            <optgroup label="Sudurpashchim Province">
                                <option value="Achham">Achham</option><option value="Baitadi">Baitadi</option><option value="Bajhang">Bajhang</option><option value="Bajura">Bajura</option><option value="Dadeldhura">Dadeldhura</option><option value="Darchula">Darchula</option><option value="Doti">Doti</option><option value="Kailali">Kailali</option><option value="Kanchanpur">Kanchanpur</option>
                            </optgroup>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="edit-location">Specific Location</label>
                        <input type="text" id="edit-location">
                    </div>
                </div>
                <div class="form-group">
                    <label for="edit-condition_notes">Condition Notes</label>
                    <input type="text" id="edit-condition_notes">
                </div>
                <div class="form-group">
                    <label for="edit-image">Replace Cover Image (optional)</label>
                    <input type="file" id="edit-image" accept="image/jpeg,image/png,image/gif,image/webp">
                </div>
                <div class="modal-actions">
                    <button type="submit">Save Changes</button>
                    <button type="button" id="edit-cancel" class="btn-secondary">Cancel</button>
                </div>
            </form>
            <div id="edit-msg"></div>
        </div>
    </div>
</section>

<script>
const CURRENT_USER_ID = <?php echo $userId; ?>;
const editModal = document.getElementById('edit-modal');

async function loadMyListings() {
    const container = document.getElementById('my-listings');
    try {
        const myBooks = await apiGet(`get_books.php?seller_id=${CURRENT_USER_ID}`);
        container.innerHTML = myBooks.length
            ? myBooks.map(b => `
                <div class="listing-card" data-id="${b.id}">
                    <div class="listing-card-img-wrap">
                        <img src="${b.image_url || '/book-exchange/uploads/placeholder.svg'}" alt="${b.title}" class="listing-card-img" loading="lazy">
                        <div class="listing-card-badges">
                            <span class="badge badge-${b.condition_type}">${b.condition_type}</span>
                            <span class="badge badge-${b.status}">${b.status}</span>
                        </div>
                    </div>
                    <div class="listing-card-body">
                        <h3 class="listing-card-title">${b.title}</h3>
                        <p class="listing-card-author">by ${b.author || 'Unknown'}</p>
                        <p class="listing-card-price">$${parseFloat(b.price).toFixed(2)}</p>
                        <div class="listing-card-actions">
                            <button class="btn-edit" data-id="${b.id}">Edit</button>
                            <button class="btn-delete" data-id="${b.id}">Delete</button>
                        </div>
                    </div>
                </div>
            `).join('')
            : '<p>You have no listings. <a href="sell-book.php">List your first book</a></p>';

        document.querySelectorAll('.btn-delete').forEach(btn => {
            btn.addEventListener('click', async (e) => {
                if (!confirm('Delete this listing?')) return;
                try {
                    await apiPost('delete_book.php', { id: e.target.dataset.id });
                    loadMyListings();
                } catch (err) {
                    alert(err.message);
                }
            });
        });

        document.querySelectorAll('.btn-edit').forEach(btn => {
            btn.addEventListener('click', () => openEditModal(btn.dataset.id));
        });
    } catch (err) {
        container.innerHTML = `<p class="error">${err.message}</p>`;
    }
}

async function openEditModal(id) {
    const msg = document.getElementById('edit-msg');
    msg.innerHTML = '';
    try {
        const b = await apiGet(`get_book.php?id=${id}`);
        document.getElementById('edit-id').value = b.id;
        document.getElementById('edit-title').value = b.title || '';
        document.getElementById('edit-author').value = b.author || '';
        document.getElementById('edit-description').value = b.description || '';
        document.getElementById('edit-condition_type').value = b.condition_type;
        document.getElementById('edit-price').value = b.price;
        document.getElementById('edit-original_price').value = b.original_price || '';
        document.getElementById('edit-district').value = b.district || '';
        document.getElementById('edit-location').value = b.location || '';
        document.getElementById('edit-condition_notes').value = b.condition_notes || '';
        editModal.hidden = false;
    } catch (err) {
        alert(err.message);
    }
}

document.getElementById('edit-cancel').addEventListener('click', () => {
    editModal.hidden = true;
});

document.getElementById('edit-form').addEventListener('submit', async (e) => {
    e.preventDefault();
    const msg = document.getElementById('edit-msg');
    const fd = new FormData();
    fd.append('id', document.getElementById('edit-id').value);
    fd.append('title', document.getElementById('edit-title').value);
    fd.append('author', document.getElementById('edit-author').value);
    fd.append('description', document.getElementById('edit-description').value);
    fd.append('condition_type', document.getElementById('edit-condition_type').value);
    fd.append('condition_notes', document.getElementById('edit-condition_notes').value);
    fd.append('price', document.getElementById('edit-price').value);
    const origPrice = document.getElementById('edit-original_price').value;
    if (origPrice) fd.append('original_price', origPrice);
    fd.append('district', document.getElementById('edit-district').value);
    fd.append('location', document.getElementById('edit-location').value);
    const fileInput = document.getElementById('edit-image');
    if (fileInput.files[0]) fd.append('image', fileInput.files[0]);

    try {
        await apiPost('update_book.php', fd);
        editModal.hidden = true;
        loadMyListings();
    } catch (err) {
        msg.innerHTML = `<p class="error">${err.message}</p>`;
    }
});

document.addEventListener('DOMContentLoaded', loadMyListings);
</script>
<?php include '../includes/footer.php'; ?>