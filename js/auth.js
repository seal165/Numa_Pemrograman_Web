// Dipakai di halaman login dan register

const form = document.querySelector('form');
const inputs = form.querySelectorAll('input:not([type="checkbox"])');
const adalahRegister = !!document.getElementById('fullname');

// Tampilkan atau sembunyikan password
const mata = document.querySelector('.toggle-password');
const kolomPass = document.getElementById('password');
if (mata) {
  mata.style.cursor = 'pointer';
  mata.addEventListener('click', () => {
    const tampak = kolomPass.type === 'text';
    kolomPass.type = tampak ? 'password' : 'text';
    mata.className = tampak ? 'fa-regular fa-eye toggle-password' : 'fa-regular fa-eye-slash toggle-password';
  });
}

inputs.forEach(inp => {
  // Tandai kolom yang sedang dipilih
  inp.addEventListener('focus', () => { inp.parentElement.style.boxShadow = '0 0 0 3px rgba(79,70,229,.25)'; });
  inp.addEventListener('blur',  () => { inp.parentElement.style.boxShadow = ''; });
  // Hapus tanda error saat mulai mengetik
  inp.addEventListener('input', () => { inp.parentElement.style.outline = ''; });
});

// Cek kekuatan password saat daftar
if (adalahRegister) {
  const info = document.createElement('small');
  info.style.cssText = 'display:block;margin-top:6px;font-size:12px;font-weight:700;color:#777587';
  kolomPass.parentElement.after(info);
  kolomPass.addEventListener('input', () => {
    const p = kolomPass.value;
    let skor = 0;
    if (p.length >= 8) skor++;
    if (/[A-Za-z]/.test(p) && /\d/.test(p)) skor++;
    if (/[^A-Za-z0-9]/.test(p) || p.length >= 12) skor++;
    const label = ['Terlalu pendek', 'Lemah', 'Lumayan', 'Kuat'][skor];
    info.textContent = p ? 'Kekuatan sandi: ' + label : '';
    info.style.color = ['#ba1a1a', '#ba1a1a', '#d97706', '#006c49'][skor];
  });
}

// Isi username kalau sebelumnya memilih "Ingat saya"
const ingat = form.querySelector('input[type="checkbox"]');
if (!adalahRegister) {
  const tersimpan = localStorage.getItem('numa_ingat');
  if (tersimpan) {
    document.getElementById('username').value = tersimpan;
    if (ingat) ingat.checked = true;
  }
}

function tandaiError(inp) {
  inp.parentElement.style.outline = '2px solid #ba1a1a';
  inp.focus();
}

form.addEventListener('submit', e => {
  e.preventDefault();

  if (adalahRegister) {
    const nama = document.getElementById('fullname');
    const email = document.getElementById('email');
    if (nama.value.trim().length < 3) { tandaiError(nama); return alert('Nama lengkap minimal 3 huruf ya.'); }
    if (!/^\S+@\S+\.\S+$/.test(email.value)) { tandaiError(email); return alert('Format email belum bener, contoh: nama@sekolah.sch.id'); }
    if (kolomPass.value.length < 8 || !/\d/.test(kolomPass.value)) { tandaiError(kolomPass); return alert('Password minimal 8 karakter dan harus ada angkanya.'); }

    // Simpan akun lalu buka halaman login
    localStorage.setItem('numa_akun', JSON.stringify({ nama: nama.value.trim(), email: email.value.trim() }));
    const d = Numa_bacaState();
    d.nama = nama.value.trim();
    localStorage.setItem('numa_state', JSON.stringify(d));
    alert('Akun berhasil dibuat! Silakan masuk, ' + nama.value.trim().split(' ')[0] + '.');
    location.href = 'login.html';
    return;
  }

  const user = document.getElementById('username');
  if (user.value.trim().length < 3) { tandaiError(user); return alert('Username / email minimal 3 karakter.'); }
  if (kolomPass.value.length < 8) { tandaiError(kolomPass); return alert('Password minimal 8 karakter.'); }

  if (ingat.checked) localStorage.setItem('numa_ingat', user.value.trim());
  else localStorage.removeItem('numa_ingat');
  sessionStorage.setItem('numa_login', user.value.trim());     // Login aktif sampai tab ditutup
  sessionStorage.removeItem('numa_disapa');

  const tombol = form.querySelector('.btn-submit');
  tombol.textContent = 'Memeriksa akun...';
  tombol.disabled = true;
  setTimeout(() => { location.href = 'user/dashboard.html'; }, 800);
});

// Ambil data belajar yang sudah tersimpan
function Numa_bacaState() {
  try { return JSON.parse(localStorage.getItem('numa_state')) || {}; } catch (e) { return {}; }
}

// Tombol yang belum tersedia di versi demo
document.querySelectorAll('.btn-social').forEach(b => {
  b.addEventListener('click', () => alert('Login ' + b.textContent.trim() + ' belum tersedia di versi demo. Pakai akun Numa dulu ya.'));
});
const lupa = document.querySelector('.link-forgot');
if (lupa) lupa.addEventListener('click', e => {
  e.preventDefault();
  const email = prompt('Masukkan email kamu, nanti dikirim link reset:');
  if (email) alert('Link reset dikirim ke ' + email + ' (pura-pura dulu ya).');
});
