// Dipakai di halaman dashboard

const namaEl = document.getElementById('namaUser');

function sapaanWaktu() {
  const jam = new Date().getHours();
  if (jam < 11) return 'Selamat pagi';
  if (jam < 15) return 'Selamat siang';
  if (jam < 18) return 'Selamat sore';
  return 'Selamat malam';
}

function isiProfil() {
  const d = Numa.ambil();
  namaEl.textContent = d.nama;

  // Level naik tiap 500 XP
  const level = Math.floor(d.xp / 500) + 1;
  const xpLevel = d.xp % 500;
  const kotak = document.querySelectorAll('.stats-overview .stat-box');
  kotak[1].querySelector('.stat-value').textContent = d.xp;
  kotak[2].querySelector('.stat-value').innerHTML = `Lv. ${level} <span class="sub-value">${xpLevel} / 500 XP</span>`;
  kotak[2].querySelector('.progress-fill').style.width = (xpLevel / 500 * 100) + '%';
  kotak[2].querySelector('.stat-sub').textContent = `${500 - xpLevel} XP lagi ke Level ${level + 1}`;
  kotak[3].querySelector('.stat-value').innerHTML = `${d.hati} <span class="sub-value">/ 5 Hati</span>`;
  kotak[3].querySelector('.status-active').textContent = d.hati >= 5 ? '• Energi Penuh' : '• Energi Kurang';
  kotak[0].querySelector('.stat-value').textContent = d.streak + ' Hari';
  document.querySelector('.my-rank .xp-score').textContent = d.xp + ' XP';
}

// Data XP tiap bulan
const DATA_XP = {
  2023: [20, 35, 15, 40, 60, 25, 45, 30, 55, 20, 10, 35],
  2024: [0, 0, 0, 0, 0, 105, 0, 0, 0, 0, 0, 0],
  2025: [0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0]
};
let tahunAktif = 2024;
const tombolTahun = document.querySelectorAll('.btn-year');

function gambarGrafik() {
  const data = DATA_XP[tahunAktif];
  const maks = Math.max(...data, 1);
  const total = data.reduce((a, b) => a + b, 0);
  const kolom = document.querySelectorAll('.bar-column');

  kolom.forEach((k, i) => {
    const bar = k.querySelector('.bar');
    const persen = data[i] > 0 ? Math.max(15, data[i] / maks * 80) : 4;
    bar.style.height = persen + '%';
    k.classList.toggle('active', data[i] === maks && data[i] > 0);
    // Tampilkan XP di atas grafik
    let tip = k.querySelector('.tooltip');
    if (!tip) {
      tip = document.createElement('span');
      tip.className = 'tooltip';
      k.insertBefore(tip, bar);
    }
    tip.textContent = data[i] > 0 ? '★ ' + data[i] : '';
  });

  const ringkas = document.querySelectorAll('.summary-item h4');
  ringkas[0].textContent = total + ' XP';
  ringkas[1].innerHTML = `${Math.round(total / 3)} <small>/bln</small>`;
  const naik = tahunAktif === 2024 ? 0 : tahunAktif === 2025 ? -100 : 35;
  ringkas[2].textContent = (naik >= 0 ? '+' : '') + naik + '% YoY';
  document.querySelector('.summary-item .text-muted').textContent = `Total 1 Tahun (${tahunAktif})`;
}

tombolTahun.forEach((b, i) => {
  b.addEventListener('click', () => {
    // Pilih tahun untuk grafik
    tahunAktif = [2023, 2024, 2025][i];
    tombolTahun.forEach(x => { x.classList.remove('active'); });
    tombolTahun[1].textContent = tahunAktif + (tahunAktif === 2024 ? ' (Aktif)' : '');
    tombolTahun[1].classList.add('active');
    gambarGrafik();
  });
});

// Klik grafik untuk lihat XP bulan itu
document.querySelectorAll('.bar-column').forEach(k => {
  k.addEventListener('click', () => {
    const bulan = k.querySelector('span:last-child').textContent;
    const nilai = DATA_XP[tahunAktif][[...k.parentNode.children].indexOf(k)];
    toast('info', `${bulan} ${tahunAktif}`, nilai ? `Kamu dapat ${nilai} XP di bulan ini.` : 'Belum ada aktivitas di bulan ini.', 1800);
  });
});

// Data teman belajar
const DAFTAR_PENGIKUT = [
  { nama: 'Salsa Putri', inisial: 'SP', streak: 5, xp: 190 },
  { nama: 'Dimas A.', inisial: 'DA', streak: 2, xp: 75 },
  { nama: 'Rani Wijaya', inisial: 'RW', streak: 9, xp: 310 },
  { nama: 'budi_math', inisial: 'BM', streak: 4, xp: 140 }
];
const WARNA = ['bg-teal', 'bg-orange', 'bg-purple', 'bg-blue'];
const DAFTAR_TEMAN = [
  { nama: 'Jono', inisial: 'J', streak: 7, xp: 120 },
  { nama: 'Haechan Lee', inisial: 'HL', streak: 10, xp: 256 },
  { nama: 'manusia', inisial: 'MS', streak: 1, xp: 50 },
  { nama: 'rkdppf01', inisial: 'RP', streak: 3, xp: 80 }
];
let dataTeman = [];

function gambarTeman(list) {
  const wadah = document.querySelector('.friend-list');
  wadah.innerHTML = '';
  list.forEach((t, i) => {
    const baris = document.createElement('div');
    baris.className = 'friend-item';
    baris.innerHTML = `<div class="friend-avatar ${WARNA[i % 4]}">${t.inisial}</div>
      <div class="friend-info"><h4>${t.nama}</h4><p>Streak ${t.streak} Hari 🔥</p></div>
      <span class="friend-xp">${t.xp} XP</span>`;
    wadah.appendChild(baris);
  });
}

async function muatTeman() {
  const wadah = document.querySelector('.friend-list');
  wadah.innerHTML = '<p class="muted text-sm">Lagi ngambil data teman...</p>';
  await tunggu(500);
  dataTeman = DAFTAR_TEMAN;
  gambarTeman(dataTeman);
}

// Ganti daftar teman dari tab
const tabs = document.querySelectorAll('.tab-pill span');
tabs.forEach((t, i) => {
  t.addEventListener('click', () => {
    tabs.forEach(x => x.classList.remove('active'));
    t.classList.add('active');
    gambarTeman(i === 0 ? dataTeman : DAFTAR_PENGIKUT);
  });
});

// Ganti nama profil
document.getElementById('btnEditProfil').addEventListener('click', () => {
  const baru = prompt('Mau ganti nama jadi apa?', Numa.ambil().nama);
  if (baru === null) return;
  if (baru.trim().length < 3) {
    alert('Nama minimal 3 huruf ya.');
    return;
  }
  const d = Numa.ambil();
  d.nama = baru.trim();
  Numa.simpan(d);
  isiProfil();
  toast('sukses', 'Profil diperbarui', 'Nama barumu udah disimpan.');
});

// Salin link portofolio
document.getElementById('btnBagikan').addEventListener('click', async () => {
  const link = location.origin === 'null' || location.protocol === 'file:'
    ? 'numa.id/portofolio/jey_math' : location.href;
  try {
    await navigator.clipboard.writeText(link);
    toast('sukses', 'Link disalin', link);
  } catch (err) {
    // Tampilkan link kalau tidak bisa disalin
    tampilModal({ ikon: 'ri-share-box-line', judul: 'Bagikan Portofolio', isi: 'Salin link ini: <b>' + link + '</b>' });
  }
});

document.getElementById('btnMulaiBelajar').addEventListener('click', () => { location.href = 'path-learning.html'; });

document.getElementById('btnCariTeman').addEventListener('click', async () => {
  const hasil = await tampilModal({
    ikon: 'ri-user-add-line', judul: 'Cari Teman',
    isi: 'Masukkan username teman sekelasmu.',
    input: { placeholder: 'contoh: arka_juara' },
    tombol: [{ teks: 'Batal', nilai: null }, { teks: 'Cari', gaya: 'utama', nilai: true }]
  });
  if (hasil && hasil.trim()) toast('sukses', 'Permintaan terkirim', `Ajakan buat @${hasil.trim()} udah dikirim.`);
  else if (hasil !== null) toast('error', 'Kosong', 'Isi dulu username-nya.');
});

// Info avatar
document.querySelector('.avatar-wrapper').addEventListener('click', () => {
  toast('info', 'Avatar', 'Fitur ganti foto bakal nyusul.', 2000);
});

document.addEventListener('DOMContentLoaded', () => {
  isiProfil();
  gambarGrafik();
  muatTeman();
  // Tampilkan sapaan sekali tiap sesi
  if (!sessionStorage.getItem('numa_disapa')) {
    sessionStorage.setItem('numa_disapa', '1');
    setTimeout(() => toast('info', sapaanWaktu() + '!', 'Lanjutkan streak belajarmu hari ini.'), 600);
  }
});
