<?php
session_start();
if (empty($_SESSION['user_id'])) {
    header('Location: login.php');
    exit;
}
include '../includes/header.php';
$preset = [
    'title' => htmlspecialchars($_GET['title'] ?? ''),
    'author' => htmlspecialchars($_GET['author'] ?? ''),
    'original_price' => htmlspecialchars($_GET['original_price'] ?? '')
];
?>
<section class="sell-page">
    <div class="sell-header">
        <h1 class="sell-heading">Sell a Book</h1>
        <p class="sell-intro">List your book and find it a new home. Fill in the details below and publish when ready.</p>
    </div>

    <form id="sell-form" class="sell-card" enctype="multipart/form-data" novalidate>

        <!-- Book Information -->
        <div class="sell-section">
            <h2 class="sell-section-title">Book Information</h2>
            <div class="sell-row">
                <div class="sell-field flex-2">
                    <label for="title">Title <span class="required">*</span></label>
                    <input type="text" id="title" value="<?php echo $preset['title']; ?>" required placeholder="e.g. The Great Gatsby" maxlength="200">
                    <span class="field-hint">The full title of your book.</span>
                </div>
                <div class="sell-field flex-1">
                    <label for="author">Author</label>
                    <input type="text" id="author" value="<?php echo $preset['author']; ?>" placeholder="e.g. F. Scott Fitzgerald">
                </div>
            </div>
            <div class="sell-field">
                <label for="description">Description <span class="char-count" id="desc-count">0/2000</span></label>
                <textarea id="description" rows="5" placeholder="Describe the book's condition, content, and why someone should buy it..." maxlength="2000"></textarea>
            </div>
        </div>

        <!-- Book Condition -->
        <div class="sell-section">
            <h2 class="sell-section-title">Book Condition</h2>
            <div class="sell-row">
                <div class="sell-field">
                    <label for="condition_type">Condition <span class="required">*</span></label>
                    <div class="condition-chips">
                        <label class="chip">
                            <input type="radio" name="condition_type" value="new" required>
                            <span class="chip-label">New</span>
                        </label>
                        <label class="chip">
                            <input type="radio" name="condition_type" value="used" required>
                            <span class="chip-label">Used</span>
                        </label>
                    </div>
                    <span class="field-hint">Select the overall condition of your book.</span>
                </div>
                <div class="sell-field">
                    <label for="condition_notes">Condition Notes</label>
                    <input type="text" id="condition_notes" placeholder="e.g. Minor wear on cover, highlighting inside">
                </div>
            </div>
            <div id="price-suggestion" class="price-suggestion"></div>
        </div>

        <!-- Pricing -->
        <div class="sell-section">
            <h2 class="sell-section-title">Pricing</h2>
            <div class="sell-row">
                <div class="sell-field">
                    <label for="price">Selling Price ($) <span class="required">*</span></label>
                    <div class="input-with-prefix">
                        <span class="input-prefix">$</span>
                        <input type="number" id="price" step="0.01" min="0" required placeholder="0.00">
                    </div>
                </div>
                <div class="sell-field">
                    <label for="original_price">Original Price ($)</label>
                    <div class="input-with-prefix">
                        <span class="input-prefix">$</span>
                        <input type="number" id="original_price" step="0.01" min="0" placeholder="0.00" value="<?php echo $preset['original_price']; ?>">
                    </div>
                    <span class="field-hint">What you originally paid (shows savings to buyers).</span>
                </div>
            </div>
            <div id="savings-estimate" class="savings-box" hidden>
                <span class="savings-icon">🏷️</span>
                <span id="savings-text"></span>
            </div>
        </div>

        <!-- Location & Image -->
        <div class="sell-section">
            <h2 class="sell-section-title">Location & Cover Image</h2>
            <div class="sell-row">
                <div class="sell-field">
                    <label for="district">District <span class="required">*</span></label>
                    <select id="district" required>
                        <option value="">Select district</option>
                        <optgroup label="Koshi">
                            <option value="Bhojpur">Bhojpur</option><option value="Dhankuta">Dhankuta</option><option value="Ilam">Ilam</option><option value="Jhapa">Jhapa</option><option value="Khotang">Khotang</option><option value="Morang">Morang</option><option value="Okhaldhunga">Okhaldhunga</option><option value="Panchthar">Panchthar</option><option value="Sankhuwasabha">Sankhuwasabha</option><option value="Solukhumbu">Solukhumbu</option><option value="Sunsari">Sunsari</option><option value="Taplejung">Taplejung</option><option value="Terhathum">Terhathum</option><option value="Udayapur">Udayapur</option>
                        </optgroup>
                        <optgroup label="Madhesh">
                            <option value="Bara">Bara</option><option value="Dhanusha">Dhanusha</option><option value="Mahottari">Mahottari</option><option value="Parsa">Parsa</option><option value="Rautahat">Rautahat</option><option value="Saptari">Saptari</option><option value="Sarlahi">Sarlahi</option><option value="Siraha">Siraha</option>
                        </optgroup>
                        <optgroup label="Bagmati">
                            <option value="Bhaktapur">Bhaktapur</option><option value="Chitwan">Chitwan</option><option value="Dhading">Dhading</option><option value="Dolakha">Dolakha</option><option value="Kathmandu">Kathmandu</option><option value="Kavrepalanchok">Kavrepalanchok</option><option value="Lalitpur">Lalitpur</option><option value="Makwanpur">Makwanpur</option><option value="Nuwakot">Nuwakot</option><option value="Ramechhap">Ramechhap</option><option value="Rasuwa">Rasuwa</option><option value="Sindhuli">Sindhuli</option><option value="Sindhupalchok">Sindhupalchok</option>
                        </optgroup>
                        <optgroup label="Gandaki">
                            <option value="Baglung">Baglung</option><option value="Gorkha">Gorkha</option><option value="Kaski">Kaski</option><option value="Lamjung">Lamjung</option><option value="Manang">Manang</option><option value="Mustang">Mustang</option><option value="Myagdi">Myagdi</option><option value="Nawalpur">Nawalpur</option><option value="Parbat">Parbat</option><option value="Syangja">Syangja</option><option value="Tanahu">Tanahu</option>
                        </optgroup>
                        <optgroup label="Lumbini">
                            <option value="Arghakhanchi">Arghakhanchi</option><option value="Banke">Banke</option><option value="Bardiya">Bardiya</option><option value="Dang">Dang</option><option value="Gulmi">Gulmi</option><option value="Kapilvastu">Kapilvastu</option><option value="Palpa">Palpa</option><option value="Pyuthan">Pyuthan</option><option value="Rolpa">Rolpa</option><option value="East Rukum">East Rukum</option><option value="Rupandehi">Rupandehi</option><option value="West Nawalparasi">West Nawalparasi</option>
                        </optgroup>
                        <optgroup label="Karnali">
                            <option value="Dailekh">Dailekh</option><option value="Dolpa">Dolpa</option><option value="Humla">Humla</option><option value="Jajarkot">Jajarkot</option><option value="Jumla">Jumla</option><option value="Kalikot">Kalikot</option><option value="Mugu">Mugu</option><option value="Salyan">Salyan</option><option value="Surkhet">Surkhet</option><option value="West Rukum">West Rukum</option>
                        </optgroup>
                        <optgroup label="Sudurpashchim">
                            <option value="Achham">Achham</option><option value="Baitadi">Baitadi</option><option value="Bajhang">Bajhang</option><option value="Bajura">Bajura</option><option value="Dadeldhura">Dadeldhura</option><option value="Darchula">Darchula</option><option value="Doti">Doti</option><option value="Kailali">Kailali</option><option value="Kanchanpur">Kanchanpur</option>
                        </optgroup>
                    </select>
                </div>
                <div class="sell-field">
                    <label for="location">Specific Location</label>
                    <input type="text" id="location" placeholder="e.g. Ward No., Tole, Landmark">
                    <span class="field-hint">Optional details beyond the district.</span>
                </div>
            </div>
            <div class="sell-field">
                <label>Book Cover Image</label>
                <div class="upload-area" id="upload-area">
                    <input type="file" id="image" accept="image/jpeg,image/png,image/gif,image/webp" hidden>
                    <div class="upload-placeholder" id="upload-placeholder">
                        <span class="upload-icon">📁</span>
                        <p class="upload-text">Drag & drop or <strong>browse</strong></p>
                        <p class="upload-hint">JPEG, PNG, GIF, WebP &bull; Max 5MB</p>
                    </div>
                    <div class="upload-preview" id="upload-preview" hidden>
                        <img id="preview-img" alt="Preview">
                        <button type="button" class="upload-remove" id="upload-remove">✕</button>
                    </div>
                </div>
            </div>
        </div>

        <div class="submit-bar">
            <button type="submit" class="sell-submit" id="sell-submit">
                <span class="btn-text">List Book</span>
                <span class="btn-loader" hidden>⏳</span>
            </button>
        </div>
    </form>
    <div id="sell-msg" class="sell-msg"></div>
</section>

<script>
const descField = document.getElementById('description');
const descCount = document.getElementById('desc-count');
descField.addEventListener('input', () => {
    const len = descField.value.length;
    descCount.textContent = `${len}/2000`;
});

const priceField = document.getElementById('price');
const origField = document.getElementById('original_price');
const savingsBox = document.getElementById('savings-estimate');
const savingsText = document.getElementById('savings-text');

function updateSavings() {
    const p = parseFloat(priceField.value);
    const o = parseFloat(origField.value);
    if (p > 0 && o > p) {
        const saved = (o - p).toFixed(2);
        const pct = Math.round((1 - p / o) * 100);
        savingsText.textContent = `Buyer saves $${saved} (${pct}%) compared to original price.`;
        savingsBox.hidden = false;
    } else {
        savingsBox.hidden = true;
    }
}
priceField.addEventListener('input', updateSavings);
origField.addEventListener('input', updateSavings);

const uploadArea = document.getElementById('upload-area');
const uploadInput = document.getElementById('image');
const placeholder = document.getElementById('upload-placeholder');
const preview = document.getElementById('upload-preview');
const previewImg = document.getElementById('preview-img');
const removeBtn = document.getElementById('upload-remove');

uploadArea.addEventListener('click', () => uploadInput.click());

uploadArea.addEventListener('dragover', (e) => {
    e.preventDefault();
    uploadArea.classList.add('drag-over');
});
uploadArea.addEventListener('dragleave', () => {
    uploadArea.classList.remove('drag-over');
});
uploadArea.addEventListener('drop', (e) => {
    e.preventDefault();
    uploadArea.classList.remove('drag-over');
    if (e.dataTransfer.files.length) {
        uploadInput.files = e.dataTransfer.files;
        showPreview(e.dataTransfer.files[0]);
    }
});

uploadInput.addEventListener('change', () => {
    if (uploadInput.files[0]) showPreview(uploadInput.files[0]);
});

function showPreview(file) {
    if (!file.type.match(/image\/(jpeg|png|gif|webp)/)) return;
    if (file.size > 5 * 1024 * 1024) return;
    const reader = new FileReader();
    reader.onload = (e) => {
        previewImg.src = e.target.result;
        placeholder.hidden = true;
        preview.hidden = false;
    };
    reader.readAsDataURL(file);
}
removeBtn.addEventListener('click', (e) => {
    e.stopPropagation();
    uploadInput.value = '';
    preview.hidden = true;
    placeholder.hidden = false;
    previewImg.src = '';
});

document.querySelectorAll('.condition-chips input').forEach(radio => {
    radio.addEventListener('change', async (e) => {
        const container = document.getElementById('price-suggestion');
        const val = e.target.value;
        container.innerHTML = '';
        if (!val) return;
        try {
            const data = await apiGet(`suggest_price.php?condition=${val}`);
            if (data.suggested) {
                container.innerHTML = `
                    <div class="suggestion-text">
                        Suggested price for <strong>${val}</strong> books: <strong>$${data.suggested.toFixed(2)}</strong>
                        ${data.count > 0 ? `<span class="suggestion-range">Range: $${data.range_min.toFixed(2)} – $${data.range_max.toFixed(2)} (${data.count} listings)</span>` : '<span class="suggestion-range">Default estimate</span>'}
                    </div>`;
            }
        } catch (_) {}
    });
});

document.getElementById('sell-form').addEventListener('submit', async (e) => {
    e.preventDefault();
    const msg = document.getElementById('sell-msg');
    msg.innerHTML = '';
    const submitBtn = document.getElementById('sell-submit');
    submitBtn.disabled = true;
    submitBtn.querySelector('.btn-text').textContent = 'Listing...';
    submitBtn.querySelector('.btn-loader').hidden = false;

    const fd = new FormData();
    fd.append('title', document.getElementById('title').value);
    fd.append('author', document.getElementById('author').value);
    fd.append('description', descField.value);
    const condEl = document.querySelector('input[name="condition_type"]:checked');
    fd.append('condition_type', condEl ? condEl.value : '');
    fd.append('condition_notes', document.getElementById('condition_notes').value);
    fd.append('price', priceField.value);
    if (origField.value) fd.append('original_price', origField.value);
    fd.append('district', document.getElementById('district').value);
    fd.append('location', document.getElementById('location').value);
    if (uploadInput.files[0]) fd.append('image', uploadInput.files[0]);
    try {
        const result = await apiPost('add_book.php', fd);
        msg.innerHTML = '<div class="success">Book listed successfully! <a href="my-listings.php">View my listings</a></div>';
        document.getElementById('sell-form').reset();
        preview.hidden = true;
        placeholder.hidden = false;
        previewImg.src = '';
        savingsBox.hidden = true;
        descCount.textContent = '0/2000';
    } catch (err) {
        msg.innerHTML = `<div class="error">${err.message}</div>`;
    } finally {
        submitBtn.disabled = false;
        submitBtn.querySelector('.btn-text').textContent = 'List Book';
        submitBtn.querySelector('.btn-loader').hidden = true;
    }
});
</script>
<?php include '../includes/footer.php'; ?>
