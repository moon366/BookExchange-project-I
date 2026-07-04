<?php include '../includes/header.php'; ?>

<!-- Hero -->
<section class="home-hero">
    <div class="home-hero-inner">
        <div class="home-hero-text">
            <h1 class="home-hero-title">Buy &amp; Sell Second-Hand Books Easily</h1>
            <p class="home-hero-desc">Find great deals on quality second-hand books from sellers near you, or list your own books and earn money. Join our local reading community today.</p>
            <div class="home-hero-actions">
                <a href="browse.php" class="home-btn home-btn-primary">Browse Books</a>
                <a href="sell-book.php" class="home-btn home-btn-secondary">Sell a Book</a>
            </div>
        </div>
        <div class="home-hero-visual">
            <svg class="home-illustration" viewBox="0 0 400 320" fill="none" xmlns="http://www.w3.org/2000/svg">
                <rect x="60" y="180" width="280" height="12" rx="6" fill="#dbeafe"/>
                <rect x="90" y="150" width="22" height="70" rx="4" fill="#2563eb" opacity="0.3"/>
                <rect x="120" y="130" width="22" height="90" rx="4" fill="#3b82f6" opacity="0.5"/>
                <rect x="150" y="110" width="22" height="110" rx="4" fill="#2563eb" opacity="0.7"/>
                <rect x="180" y="100" width="22" height="120" rx="4" fill="#3b82f6"/>
                <rect x="210" y="120" width="22" height="100" rx="4" fill="#2563eb" opacity="0.6"/>
                <rect x="240" y="140" width="22" height="80" rx="4" fill="#3b82f6" opacity="0.4"/>
                <rect x="270" y="160" width="22" height="60" rx="4" fill="#2563eb" opacity="0.25"/>
                <circle cx="200" cy="60" r="32" fill="#eff6ff" stroke="#bfdbfe" stroke-width="2"/>
                <path d="M190 55 L200 45 L210 55 M195 60 L205 60 L205 70 L195 70 Z" fill="#2563eb" opacity="0.6"/>
            </svg>
        </div>
    </div>
</section>

<!-- Features -->
<section class="home-section">
    <h2 class="home-section-title">How BookExchange Works</h2>
    <div class="home-features">
        <div class="home-feature-card">
            <div class="home-feature-icon">📚</div>
            <h3 class="home-feature-title">Browse Books</h3>
            <p class="home-feature-desc">Search through hundreds of books across all genres and conditions at great prices from local sellers.</p>
        </div>
        <div class="home-feature-card">
            <div class="home-feature-icon">💰</div>
            <h3 class="home-feature-title">Sell Your Books</h3>
            <p class="home-feature-desc">Have books you no longer need? List them for sale and earn money while helping other readers.</p>
        </div>
        <div class="home-feature-card">
            <div class="home-feature-icon">📍</div>
            <h3 class="home-feature-title">Local Exchange</h3>
            <p class="home-feature-desc">Find sellers near your district for faster delivery, lower costs, and community connections.</p>
        </div>
    </div>
</section>

<!-- Recently Added -->
<section class="home-section">
    <div class="home-section-header">
        <h2 class="home-section-title">Recently Added Books</h2>
        <a href="browse.php" class="home-link">View All &rarr;</a>
    </div>
    <div class="home-recent-grid" id="recent-books">
        <div class="home-skeleton"></div>
        <div class="home-skeleton"></div>
        <div class="home-skeleton"></div>
        <div class="home-skeleton"></div>
    </div>
</section>

<!-- How It Works -->
<section class="home-section home-steps-section">
    <h2 class="home-section-title">Get Started in 3 Simple Steps</h2>
    <div class="home-steps">
        <div class="home-step">
            <div class="home-step-num">1</div>
            <h3 class="home-step-title">List Your Book</h3>
            <p class="home-step-desc">Add a title, set your price, upload a photo, and share the condition details in minutes.</p>
        </div>
        <div class="home-step">
            <div class="home-step-num">2</div>
            <h3 class="home-step-title">Find a Buyer</h3>
            <p class="home-step-desc">Buyers browse by category, location, and price. Receive orders and connect locally.</p>
        </div>
        <div class="home-step">
            <div class="home-step-num">3</div>
            <h3 class="home-step-title">Exchange Safely</h3>
            <p class="home-step-desc">Meet or arrange delivery. Confirm the exchange and leave a review for each other.</p>
        </div>
    </div>
</section>

<script>
fetch('/book-exchange/api/get_books.php')
    .then(r => r.json())
    .then(books => {
        const container = document.getElementById('recent-books');
        const recent = books.slice(0, 6);
        if (!recent.length) {
            container.innerHTML = '<p class="home-empty">No books listed yet. Be the first!</p>';
            return;
        }
        container.innerHTML = recent.map(b => {
            const img = b.image_url || '';
            const condClass = b.condition_type === 'new' ? 'badge-new' : 'badge-used';
            const condLabel = b.condition_type === 'new' ? 'New' : 'Used';
            const loc = [b.district, b.location].filter(Boolean).join(', ');
            return `
                <a href="book-details.php?id=${b.id}" class="home-book-card">
                    <div class="home-book-img-wrap">
                        ${img ? `<img src="${img}" alt="${b.title}" class="home-book-img">` : `<div class="home-book-img home-book-img-placeholder"></div>`}
                        <span class="home-book-badge ${condClass}">${condLabel}</span>
                    </div>
                    <div class="home-book-body">
                        <h3 class="home-book-title">${b.title}</h3>
                        <p class="home-book-author">${b.author || 'Unknown Author'}</p>
                        <div class="home-book-footer">
                            <span class="home-book-price">$${parseFloat(b.price).toFixed(2)}</span>
                            <span class="home-book-loc">${loc || 'Nepal'}</span>
                        </div>
                    </div>
                </a>
            `;
        }).join('');
    })
    .catch(() => {
        document.getElementById('recent-books').innerHTML = '<p class="home-empty">Could not load books. Try again later.</p>';
    });
</script>

<?php include '../includes/footer.php'; ?>
