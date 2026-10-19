// Dipakai di semua halaman user

// Data user disimpan di localStorage
const KUNCI_STATE = 'numa_state';

const STATE_AWAL = {
  nama: 'Jey Raditya Pratama',
  hati: 5,
  streak: 3,
  xp: 105,
  koin: 30,
  petiTerakhir: '',          // Tanggal terakhir buka peti harian
  misiKlaim: {},             // Misi yang sudah diklaim
  soalTerjawab: 64,
  riwayat: [
    { materi: 'Aljabar Linear',   waktu: 'Kemarin',     hasil: '9/10 Benar', xp: 150 },
    { materi: 'Geometri Segitiga', waktu: '2 Hari Lalu', hasil: '8/10 Benar', xp: 120 }
  ],
  labBeres: [],              // Soal lab yang sudah diperbaiki
  flashNilai: {}             // Nilai tiap kartu flashcard
};

const Numa = {
  // Ambil data tersimpan, atau pakai data awal
  ambil() {
    try {
      const mentah = localStorage.getItem(KUNCI_STATE);
      if (!mentah) return structuredClone(STATE_AWAL);
      return Object.assign(structuredClone(STATE_AWAL), JSON.parse(mentah));
    } catch (e) {
      console.warn('storage bermasalah, pake data awal dulu', e);
      return structuredClone(STATE_AWAL);
    }
  },

  simpan(data) {
    try { localStorage.setItem(KUNCI_STATE, JSON.stringify(data)); }
    catch (e) { console.warn('gagal nyimpen', e); }
    Numa.render();
  },

  // Ubah jumlah XP, koin, atau hati
  ubah(kunci, jumlah) {
    const d = Numa.ambil();
    d[kunci] = Math.max(0, (d[kunci] || 0) + jumlah);
    if (kunci === 'hati') d.hati = Math.min(d.hati, 99);
    Numa.simpan(d);
    return d[kunci];
  },

  // Tampilkan data di elemen dengan data-stat
  render() {
    const d = Numa.ambil();
    document.querySelectorAll('[data-stat]').forEach(el => {
      const k = el.dataset.stat;
      if (d[k] !== undefined) el.textContent = d[k];
    });
  },

  reset() { localStorage.removeItem(KUNCI_STATE); Numa.render(); }
};

// Jeda beberapa milidetik
const tunggu = (ms) => new Promise(resolve => setTimeout(resolve, ms));

// Tampilkan popup
function tampilModal({ ikon = 'ri-information-line', tipe = '', judul = '', isi = '', input = null,
                       tombol = [{ teks: 'Oke', gaya: 'utama', nilai: true }] }) {
  return new Promise(selesai => {
    const overlay = document.createElement('div');
    overlay.className = 'modal-overlay';
    overlay.innerHTML = `
      <div class="modal-box" role="dialog" aria-modal="true">
        <div class="modal-ikon ${tipe}"><i class="${ikon}"></i></div>
        <h3>${judul}</h3>
        <p>${isi}</p>
        ${input ? `<input class="modal-input" type="text" placeholder="${input.placeholder || ''}" value="${input.nilai || ''}">` : ''}
        <div class="modal-actions"></div>
      </div>`;

    const aksi = overlay.querySelector('.modal-actions');
    const kolom = overlay.querySelector('.modal-input');

    function tutup(hasil) {
      overlay.classList.remove('buka');
      document.removeEventListener('keydown', saatTekan);
      setTimeout(() => overlay.remove(), 300);
      selesai(hasil);
    }

    tombol.forEach(t => {
      const b = document.createElement('button');
      b.className = 'btn-modal ' + (t.gaya || '');
      b.textContent = t.teks;
      b.addEventListener('click', () => tutup(input && t.nilai === true ? kolom.value : t.nilai));
      aksi.appendChild(b);
    });

    // Klik area gelap atau tekan Esc untuk batal
    overlay.addEventListener('click', e => { if (e.target === overlay) tutup(null); });
    function saatTekan(e) {
      if (e.key === 'Escape') tutup(null);
      if (e.key === 'Enter' && kolom) tutup(kolom.value);
    }
    document.addEventListener('keydown', saatTekan);

    document.body.appendChild(overlay);
    requestAnimationFrame(() => overlay.classList.add('buka'));
    if (kolom) kolom.focus();
  });
}

// Tampilkan notifikasi singkat
function toast(tipe, judul, pesan, durasi = 3000) {
  let wadah = document.querySelector('.toast-wrap');
  if (!wadah) {
    wadah = document.createElement('div');
    wadah.className = 'toast-wrap';
    document.body.appendChild(wadah);
  }
  const ikon = { sukses: 'ri-checkbox-circle-fill', error: 'ri-close-circle-fill', info: 'ri-information-fill' }[tipe] || 'ri-information-fill';
  const t = document.createElement('div');
  t.className = 'toast ' + tipe;
  t.innerHTML = `<i class="${ikon}"></i><div><b>${judul}</b><span>${pesan}</span></div>`;
  wadah.appendChild(t);
  setTimeout(() => t.classList.add('show'), 20);
  setTimeout(() => { t.classList.remove('show'); setTimeout(() => t.remove(), 400); }, durasi);
}

// Isi popup di footer
const ISI_FOOTER = {
  bantuan: { ikon: 'ri-question-line', judul: 'Bantuan Belajar',
    isi: 'Bingung mulai dari mana? Buka menu <b>Belajar</b> buat ngikutin jalur materi, atau coba <b>Quiz Kilat</b> kalau mau latihan cepat. Tips: pakai tombol 1-4 di keyboard biar jawab lebih ngebut.' },
  privasi: { ikon: 'ri-shield-check-line', judul: 'Privasi',
    isi: 'Data belajarmu (XP, hati, koin) cuma disimpan di browser kamu lewat localStorage. Nggak ada yang dikirim ke server mana pun.' },
  syarat: { ikon: 'ri-file-list-3-line', judul: 'Syarat & Ketentuan',
    isi: 'Numa dibuat untuk tugas Pemrograman Web. Konten soal bersifat latihan dan boleh dipakai buat belajar.' }
};

function cekStatusServer() {
  tampilModal({ ikon: 'ri-server-line', tipe: 'sukses', judul: 'Data Lokal Siap',
    isi: 'Data belajar tersimpan langsung di JavaScript, jadi bisa dipakai tanpa mengambil file dari server.' });
}

// Event umum di halaman user
document.addEventListener('DOMContentLoaded', () => {
  Numa.render();

  // Klik link footer untuk membuka popup
  document.querySelectorAll('[data-popup]').forEach(a => {
    a.addEventListener('click', e => {
      e.preventDefault();
      const kunci = a.dataset.popup;
      if (kunci === 'status') return cekStatusServer();
      tampilModal(ISI_FOOTER[kunci]);
    });
  });

  // Tampilkan tombol ke atas setelah scroll
  const btnAtas = document.createElement('button');
  btnAtas.className = 'btn-ke-atas';
  btnAtas.innerHTML = '<i class="ri-arrow-up-line"></i>';
  btnAtas.title = 'Balik ke atas';
  btnAtas.addEventListener('click', () => window.scrollTo({ top: 0, behavior: 'smooth' }));
  document.body.appendChild(btnAtas);
  window.addEventListener('scroll', () => {
    btnAtas.classList.toggle('tampil', window.scrollY > 400);
  });

  // Beri tahu status koneksi
  window.addEventListener('offline', () => toast('error', 'Koneksi putus', 'Kamu lagi offline, tapi data lokal tetap aman.'));
  window.addEventListener('online',  () => toast('sukses', 'Udah online lagi', 'Koneksi nyambung kembali.'));

  // Dobel klik badge hati untuk reset data
  const badgeHati = document.querySelector('.badge-hati');
  if (badgeHati) {
    badgeHati.addEventListener('dblclick', async () => {
      const yakin = confirm('Reset semua data belajar (XP, hati, koin) ke awal?');
      if (yakin) { Numa.reset(); toast('info', 'Data direset', 'Semua angka balik ke awal.'); }
    });
  }
});
