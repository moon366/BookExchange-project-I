<?php include '../includes/header.php'; ?>

<section class="browse-section">
    <div class="section-title">
        <div>
            <h2>Browse Available Books</h2>
            <p>Search, filter, and explore the latest posted listings in one dedicated place.</p>
        </div>
    </div>
        <form id="search-form" class="browse-filters">
        <div class="filter-row">
            <div class="filter-input-wrap">
                <span class="filter-icon">🔍</span>
                <input type="text" name="search" placeholder="Search by title, author..." class="filter-input">
            </div>
            <select name="condition" class="filter-select">
                <option value="">All conditions</option>
                <option value="new">New</option>
                <option value="used">Used</option>
            </select>
            <select name="district" class="filter-select">
                <option value="">All districts</option>
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
            <button type="submit" class="filter-btn">Search</button>
        </div>
    </form>
    <div id="book-list" class="browse-grid"></div>
</section>

<script src="/book-exchange/js/books.js?v=2"></script>
<?php include '../includes/footer.php'; ?>
