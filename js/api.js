const API_BASE = '/book-exchange/api';

async function apiGet(path) {
  const res = await fetch(`${API_BASE}/${path}`, { credentials: 'include' });
  const data = await res.json();
  if (!res.ok) throw new Error(data.error || 'Request failed');
  return data;
}

async function apiPost(path, data) {
  const opts = {
    method: 'POST',
    credentials: 'include',
  };
  if (data instanceof FormData) {
    opts.body = data;
  } else {
    opts.headers = { 'Content-Type': 'application/json' };
    opts.body = JSON.stringify(data);
  }
  const res = await fetch(`${API_BASE}/${path}`, opts);
  const json = await res.json();
  if (!res.ok) throw new Error(json.error || 'Request failed');
  return json;
}
