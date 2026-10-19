// Elemen flashcard
const wrapper   = document.getElementById('flashcardWrapper');
const tombolFilter = document.querySelectorAll('.filter-btn');
const elTracker = document.querySelector('.tracker-info');
const elBar     = document.querySelector('.tracker-progress .progress-fill');
const elQueue   = document.querySelector('.queue-list');
const tombolNilai = document.querySelectorAll('.btn-assess');

const SEMUA_KARTU = [
  {
    id: 'f1', topik: 'Aljabar Linear', label: 'ALJABAR & EKSPONEN',
    judul: 'Tantangan Logika Pemfaktoran',
    tanya: 'Bagaimana rumus pemfaktoran selisih dua kuadrat dari bentuk aljabar berikut?',
    ekspresi: 'a² − b²',
    petunjuk: 'Ingat perkalian sekawan yang saling menghilangkan suku tengah.',
    rumus: 'a² − b² = (a − b)(a + b)',
    catatan: 'Atau secara ekuivalen: (a + b)(a − b) (berlaku sifat komutatif perkalian).',
    ikon: 'ri-function-line', ringkas: 'a² − b² = (a−b)(a+b)', lengkap: true
  },
  {
    id: 'f2', topik: 'Geometri & Bangun', label: 'GEOMETRI & BANGUN RUANG',
    judul: 'Bangun Ruang Sisi Lengkung',
    tanya: 'Berapa rumus luas permukaan tabung dengan jari-jari r dan tinggi t?',
    ekspresi: 'L = ?', petunjuk: 'Tabung punya dua alas lingkaran dan satu selimut.',
    rumus: 'L = 2πr(r + t)', catatan: 'Jumlah luas dua lingkaran alas dan luas selimut tabung.',
    ikon: 'ri-ruler-2-line', ringkas: 'L = 2πr(r + t)'
  },
  {
    id: 'f3', topik: 'Aljabar Linear', label: 'ALJABAR LINEAR',
    judul: 'Garis pada Bidang Koordinat',
    tanya: 'Bagaimana bentuk umum persamaan garis lurus dengan gradien m?',
    ekspresi: 'y = ?', petunjuk: 'm menentukan kemiringan, c menentukan titik potong sumbu y.',
    rumus: 'y = mx + c', catatan: 'm adalah gradien dan c adalah titik potong terhadap sumbu y.',
    ikon: 'ri-line-chart-line', ringkas: 'y = mx + c (Gradien & Titik Potong)'
  },
  {
    id: 'f4', topik: 'Aljabar Linear', label: 'ALJABAR & EKSPONEN',
    judul: 'Sifat Bilangan Berpangkat',
    tanya: 'Berapa hasil perkalian dua bilangan berpangkat dengan basis yang sama?',
    ekspresi: 'aᵐ × aⁿ = ?', petunjuk: 'Basis sama, yang berubah cuma pangkatnya.',
    rumus: 'aᵐ × aⁿ = aᵐ⁺ⁿ', catatan: 'Kalau basisnya sama, pangkatnya tinggal dijumlahkan.',
    ikon: 'ri-percent-line', ringkas: 'aᵐ × aⁿ = aᵐ⁺ⁿ'
  },
  {
    id: 'f5', topik: 'Teorema Pythagoras', label: 'TEOREMA PYTHAGORAS',
    judul: 'Segitiga Siku-siku',
    tanya: 'Bagaimana hubungan sisi miring c dengan dua sisi siku-sikunya a dan b?',
    ekspresi: 'c² = ?', petunjuk: 'Sisi miring selalu sisi yang paling panjang.',
    rumus: 'c² = a² + b²', catatan: 'Kuadrat sisi miring sama dengan jumlah kuadrat dua sisi lainnya.',
    ikon: 'ri-triangle-line', ringkas: 'c² = a² + b² (Sisi Miring)'
  },
  {
    id: 'f6', topik: 'Pecahan & Desimal', label: 'PECAHAN & DESIMAL',
    judul: 'Operasi Pecahan',
    tanya: 'Bagaimana cara menjumlahkan dua pecahan berpenyebut beda?',
    ekspresi: 'a/b + c/d = ?', petunjuk: 'Samakan penyebutnya dulu.',
    rumus: 'a/b + c/d = (ad + bc) / bd', catatan: 'Samakan penyebut, baru jumlahkan pembilangnya.',
    ikon: 'ri-divide-line', ringkas: 'a/b + c/d = (ad + bc)/bd'
  },
  {
    id: 'f7', topik: 'Pecahan & Desimal', label: 'PECAHAN & DESIMAL',
    judul: 'Persen dan Desimal',
    tanya: 'Bagaimana mengubah x persen menjadi pecahan?',
    ekspresi: 'x% = ?', petunjuk: 'Persen artinya per seratus.',
    rumus: 'x% = x / 100', catatan: 'Contoh: 25% = 25/100 = 0,25.',
    ikon: 'ri-percent-line', ringkas: 'x% = x / 100'
  },
  {
    id: 'f8', topik: 'Geometri & Bangun', label: 'GEOMETRI & BANGUN DATAR',
    judul: 'Bangun Datar',
    tanya: 'Berapa rumus luas lingkaran dengan jari-jari r?',
    ekspresi: 'L = ?', petunjuk: 'Kuadratkan jari-jarinya, bukan diameternya.',
    rumus: 'L = πr²', catatan: 'Dengan π ≈ 3,14 atau 22/7 tergantung soal.',
    ikon: 'ri-focus-3-line', ringkas: 'L = πr²'
  }
];

let semuaKartu = [];
let deck = [];           // Kartu yang sedang ditampilkan
let posisi = 0;
let filterAktif = 'Semua';

function tampilkanKartu() {
  if (!deck.length) return;
  const k = deck[posisi];
  wrapper.classList.remove('flipped');            // Tampilkan sisi depan saat ganti kartu

  // Tampilkan isi kartu
  document.querySelectorAll('.tag-topic').forEach(t => t.textContent = '● ' + k.label);
  document.querySelector('.badge-subtopic').textContent = k.judul;
  document.querySelector('.card-question-text').textContent = k.tanya;
  document.querySelector('.math-display-box').textContent = k.ekspresi;
  document.querySelector('.hint-box').innerHTML = '<i class="ri-lightbulb-line"></i> ' + k.petunjuk;
  document.querySelector('.solution-formula').textContent = k.rumus;
  document.querySelector('.solution-equiv').textContent = k.catatan;

  // Bagian tambahan hanya untuk kartu tertentu
  ['.fast-intuition-note', '.proof-section', '.mental-math-box'].forEach(sel => {
    document.querySelector(sel).style.display = k.lengkap ? '' : 'none';
  });

  elTracker.innerHTML = `<strong>Kartu #${posisi + 1}</strong> <span class="muted">dari ${deck.length} Kartu</span>`;
  elBar.style.width = ((posisi + 1) / deck.length * 100) + '%';

  // Tampilkan penilaian sebelumnya
  const nilai = Numa.ambil().flashNilai[k.id];
  tombolNilai.forEach(b => b.classList.remove('active'));
  if (nilai) document.querySelector('.assess-' + nilai).classList.add('active');

  isiAntrean();
  localStorage.setItem('numa_flash_pos', posisi);   // Simpan posisi terakhir
}

function isiAntrean() {
  elQueue.innerHTML = '';
  const sisa = deck.length - posisi - 1;
  document.querySelector('.queue-count').textContent = sisa + ' Tersisa';
  // Tampilkan maksimal 4 kartu berikutnya
  for (let i = 1; i <= 4 && posisi + i < deck.length; i++) {
    const k = deck[posisi + i];
    const item = document.createElement('div');
    item.className = 'queue-item';
    item.innerHTML = `<div class="queue-icon-box"><i class="${k.ikon}"></i></div>
      <div class="queue-info"><h4>${k.judul}</h4><p>${k.ringkas}</p></div>
      <i class="ri-arrow-right-s-line arrow-icon"></i>`;
    item.addEventListener('click', () => { posisi += i; tampilkanKartu(); });
    elQueue.appendChild(item);
  }
  if (sisa <= 0) elQueue.innerHTML = '<p class="muted text-sm">Ini kartu terakhir di deck. Mantap!</p>';
}

function balik() { wrapper.classList.toggle('flipped'); }

function lanjutKartu() {
  if (posisi < deck.length - 1) { posisi++; tampilkanKartu(); }
  else toast('info', 'Deck selesai', 'Kamu udah sampai kartu terakhir.');
}
function mundurKartu() {
  if (posisi > 0) { posisi--; tampilkanKartu(); }
}

function terapkanFilter(nama) {
  filterAktif = nama;
  deck = nama === 'Semua' ? [...semuaKartu] : semuaKartu.filter(k => k.topik === nama);
  posisi = 0;
  if (!deck.length) {
    toast('info', 'Kosong', 'Belum ada kartu di topik ini.');
    deck = [...semuaKartu]; filterAktif = 'Semua';
    tombolFilter.forEach(b => b.classList.toggle('active', b.dataset.topik === 'Semua'));
  }
  tampilkanKartu();
}

// Balik kartu lewat tombol
document.querySelectorAll('.btn-flip-trigger').forEach(b => b.addEventListener('click', balik));
// Balik kartu dengan dobel klik
wrapper.addEventListener('dblclick', balik);

document.querySelector('.btn-nav-next').addEventListener('click', lanjutKartu);
document.querySelector('.btn-nav-prev').addEventListener('click', mundurKartu);

// Acak urutan kartu
document.querySelector('.btn-shuffle').addEventListener('click', () => {
  deck = acakArray(deck);
  posisi = 0;
  tampilkanKartu();
  toast('sukses', 'Deck diacak', 'Urutan kartu sekarang random.');
});
function acakArray(a) {
  const b = [...a];
  for (let i = b.length - 1; i > 0; i--) {
    const j = Math.floor(Math.random() * (i + 1));
    [b[i], b[j]] = [b[j], b[i]];
  }
  return b;
}

// Simpan penilaian kartu
tombolNilai.forEach(b => {
  b.addEventListener('click', () => {
    const jenis = b.classList.contains('assess-red') ? 'red' : b.classList.contains('assess-yellow') ? 'yellow' : 'green';
    tombolNilai.forEach(x => x.classList.remove('active'));
    b.classList.add('active');

    const d = Numa.ambil();
    d.flashNilai[deck[posisi].id] = jenis;
    Numa.simpan(d);

    const pesan = { red: 'Kartu ini bakal muncul lebih sering.', yellow: 'Oke, nanti diulang lagi.', green: 'Mantap, kartu ini udah kamu kuasai!' }[jenis];
    toast(jenis === 'red' ? 'error' : 'sukses', 'Penilaian tersimpan', pesan, 1800);
    if (jenis === 'green') setTimeout(lanjutKartu, 700);
  });
});

// Spasi untuk membalik kartu, panah untuk pindah
document.addEventListener('keydown', e => {
  if (['INPUT', 'TEXTAREA'].includes(e.target.tagName)) return;
  if (e.code === 'Space') { e.preventDefault(); balik(); }
  if (e.key === 'ArrowRight') lanjutKartu();
  if (e.key === 'ArrowLeft') mundurKartu();
});

// Tampilkan daftar semua kartu
document.querySelector('.view-all-link').addEventListener('click', e => {
  e.preventDefault();
  const daftar = semuaKartu.map((k, i) => `${i + 1}. ${k.judul}`).join('<br>');
  tampilModal({ ikon: 'ri-stack-line', judul: `Semua Kartu (${semuaKartu.length})`, isi: daftar });
});

(function init() {
  semuaKartu = SEMUA_KARTU;
  // Hubungkan topik ke tombol filter
  const namaTopik = ['Semua', 'Aljabar Linear', 'Geometri & Bangun', 'Pecahan & Desimal', 'Teorema Pythagoras'];
  tombolFilter.forEach((b, i) => {
    b.dataset.topik = namaTopik[i];
    if (i === 0) b.textContent = `Semua Topik (${semuaKartu.length})`;
    b.addEventListener('click', () => {
      tombolFilter.forEach(x => x.classList.remove('active'));
      b.classList.add('active');
      terapkanFilter(b.dataset.topik);
    });
  });

  deck = [...semuaKartu];
  // Buka posisi terakhir yang tersimpan
  const simpanan = parseInt(localStorage.getItem('numa_flash_pos'), 10);
  posisi = Number.isInteger(simpanan) && simpanan < deck.length ? simpanan : 0;
  tampilkanKartu();
})();
