// Pengaturan sebelum mulai kuis

const kartuMode  = document.querySelectorAll('.mode-card');
const kartuTopik = document.querySelectorAll('.topic-card');
const wadahTopik = document.querySelector('.topic-list-container');
const elMateri   = document.querySelector('.summary-info-row .value');

let modeDipilih = 'spesifik';
let topikDipilih = 'Aljabar Linear Dasar';
const DAFTAR_TIPS = [
  'Latihan matriks 2×2 akan mempermudah penyelesaian soal SPLDV kompleks.',
  'Kerjakan perkalian dulu sebelum penjumlahan, ingat urutan PEMDAS/KABATAKU.',
  'Beri tanda kurung pada bilangan negatif biar tanda minusnya nggak tertukar.',
  'Kalau ragu, coba masukkan jawabanmu balik ke soal buat ngecek.',
  'Hafalkan kuadrat 1 sampai 20, banyak soal jadi terasa lebih ringan.',
  'Istirahat 5 menit setiap 25 menit belajar bikin ingatan lebih awet.'
];

kartuMode.forEach((kartu, i) => {
  const radio = kartu.querySelector('input[type="radio"]');
  radio.value = i === 0 ? 'spesifik' : 'acak';

  // Perbarui pilihan mode
  radio.addEventListener('change', () => {
    kartuMode.forEach(k => k.classList.remove('selected'));
    kartu.classList.add('selected');
    modeDipilih = radio.value;
    // Nonaktifkan topik di mode acak
    kartuTopik.forEach(t => t.classList.toggle('disabled', modeDipilih === 'acak'));
    wadahTopik.style.opacity = modeDipilih === 'acak' ? '.5' : '1';
    perbaruiRingkasan();
    if (modeDipilih === 'acak') toast('info', 'Mix Adaptif', 'Bonus +25% XP aktif buat sesi ini.', 2200);
  });
});

kartuTopik.forEach(t => {
  t.addEventListener('click', () => {
    if (modeDipilih === 'acak') return;
    kartuTopik.forEach(x => x.classList.remove('active'));
    t.classList.add('active');
    topikDipilih = t.querySelector('h3').textContent.trim();
    perbaruiRingkasan();
  });
});

function perbaruiRingkasan() {
  elMateri.textContent = modeDipilih === 'acak' ? 'Campuran Semua Materi' : topikDipilih;
}

document.getElementById('btnMulaiKuis').addEventListener('click', () => {
  // Simpan pilihan untuk quiz-play.js
  sessionStorage.setItem('numa_mode', modeDipilih);
  sessionStorage.setItem('numa_topik', topikDipilih);
  const ok = confirm('Mulai kuis kilat sekarang?\nAda 10 soal, tiap soal dibatasi 60 detik.');
  if (ok) location.href = 'quiz-kilat.html';
});

// Tampilkan riwayat kuis
function isiRiwayat() {
  const daftar = Numa.ambil().riwayat.slice(0, 3);
  const wadah = document.querySelector('.history-list');
  wadah.innerHTML = '';
  daftar.forEach(r => {
    const baris = document.createElement('div');
    baris.className = 'history-item';
    baris.innerHTML = `<div class="history-status check"><i class="ri-check-line"></i></div>
      <div class="history-info"><h4>${r.materi}</h4><p>${r.waktu} • ${r.hasil}</p></div>
      <span class="history-xp">+${r.xp} XP</span>`;
    wadah.appendChild(baris);
  });
}

document.querySelector('.link-all').addEventListener('click', e => {
  e.preventDefault();
  const isi = Numa.ambil().riwayat.map(r => `${r.materi}: ${r.hasil} (+${r.xp} XP)`).join('<br>');
  tampilModal({ ikon: 'ri-history-line', judul: 'Riwayat Kuis', isi });
});

// Tampilkan tips belajar acak
function muatTips() {
  const p = document.querySelector('.tips-content p');
  p.classList.add('sedang-muat');
  p.textContent = '"' + DAFTAR_TIPS[Math.floor(Math.random() * DAFTAR_TIPS.length)] + '"';
  p.classList.remove('sedang-muat');
}

// Klik kartu untuk ganti tips
document.querySelector('.tips-card').addEventListener('click', muatTips);

document.addEventListener('DOMContentLoaded', () => { isiRiwayat(); muatTips(); });
