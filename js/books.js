function getBadgeClass(val) {
  const map = { new: 'badge-new', used: 'badge-used', available: 'badge-avail', pending: 'badge-pend', sold: 'badge-sold' };
  return map[val] || '';
}

function renderBookCard(book) {
  const bookUrl = `/book-exchange/pages/book-details.php?id=${book.id}`;
  const loc = book.district || book.location || 'Nepal';
  const detail = book.location && book.district ? book.location : '';

  return `
    <a href="${bookUrl}" class="browse-card" aria-label="View details for ${book.title}">
      <div class="browse-card-img-wrap">
        <img src="${book.image_url || '/book-exchange/uploads/placeholder.svg'}" alt="${book.title}" class="browse-card-img" loading="lazy">
        <span class="browse-badge ${getBadgeClass(book.condition_type)}">${book.condition_type}</span>
      </div>
      <div class="browse-card-body">
        <div class="browse-card-top">
          <span class="browse-price">$${parseFloat(book.price).toFixed(2)}</span>
        </div>
        <h3 class="browse-card-title">${book.title}</h3>
        <p class="browse-card-author">${book.author || 'Unknown'}</p>
        <div class="browse-card-footer">
          <span class="browse-loc">📍 ${loc}${detail ? ` · ${detail}` : ''}</span>
          <span class="browse-seller">${book.seller_name}</span>
        </div>
      </div>
    </a>
  `;
}

function renderSkeleton() {
  return Array.from({ length: 8 }, () => `
    <div class="browse-card skeleton">
      <div class="browse-card-img-wrap">
        <div class="skeleton-img"></div>
      </div>
      <div class="browse-card-body">
        <div class="skeleton-line w-40"></div>
        <div class="skeleton-line w-90"></div>
        <div class="skeleton-line w-60"></div>
        <div class="skeleton-line w-70"></div>
      </div>
    </div>
  `).join('');
}

async function loadBooks(params = {}) {
  const q = new URLSearchParams(params).toString();
  const url = `/book-exchange/api/get_books.php${q ? `?${q}` : ''}`;
  const container = document.getElementById('book-list');
  if (!container) return;

  container.innerHTML = renderSkeleton();

  try {
    const res = await fetch(url, { credentials: 'include' });
    if (!res.ok) {
      const err = await res.json().catch(() => ({}));
      throw new Error(err.error || 'Request failed');
    }
    const books = await res.json();
    container.innerHTML = books.length
      ? books.map(renderBookCard).join('')
      : '<p class="no-results">No books found matching your filters.</p>';
  } catch (err) {
    container.innerHTML = `<p class="error">${err.message}</p>`;
  }
}

document.addEventListener('DOMContentLoaded', () => {
  const searchForm = document.getElementById('search-form');
  if (!searchForm) {
    loadBooks();
    return;
  }

  searchForm.addEventListener('submit', (e) => {
    e.preventDefault();
    const fd = new FormData(searchForm);
    const params = {};
    for (const [key, val] of fd) {
      if (val) params[key] = val;
    }
    window.history.replaceState(null, '', `?${new URLSearchParams(params)}`);
    loadBooks(params);
  });

  const urlParams = new URLSearchParams(window.location.search);
  const initial = {};
  for (const [key, val] of urlParams) {
    initial[key] = val;
    const el = searchForm.elements[key];
    if (el) el.value = val;
  }
  loadBooks(initial);
});
