// Dipakai di halaman kuis kilat dan course
const MODE    = document.body.dataset.mode;           // Mode kuis
const JUMLAH  = parseInt(document.body.dataset.jumlah, 10);

const elInfoSoal  = document.getElementById('infoSoal');
const elInfoPersen = document.getElementById('infoPersen');
const elBar       = document.getElementById('barProgress');
const elTag       = document.getElementById('tagMateri');
const elIntro     = document.getElementById('soalIntro');
const elSoal      = document.getElementById('soalTeks');
const elOpsi      = document.getElementById('opsiGrid');
const elFeedback  = document.getElementById('feedbackBar');
const elTimerPill = document.getElementById('timerPill');
const elTimerTeks = document.getElementById('timerTeks');
const areaSoal    = document.getElementById('areaSoal');
const areaHasil   = document.getElementById('areaHasil');

const BANK_SOAL = [
  { id: 1, materi: 'Operasi Dasar', level: 3, intro: 'Hitung perkalian berikut secepat mungkin!', soal: '12 × 8 = ?', opsi: ['86', '96', '108', '112'], jawaban: 1, trik: '12 × 8 = 12 × (4 × 2) = 48 × 2 = 96' },
  { id: 2, materi: 'Operasi Dasar', level: 3, intro: 'Hitung perkalian berikut secepat mungkin!', soal: '15 × 6 = ?', opsi: ['80', '85', '90', '95'], jawaban: 2, trik: '15 × 6 = (10 × 6) + (5 × 6) = 60 + 30 = 90' },
  { id: 3, materi: 'Aljabar Linear', level: 2, intro: 'Cari nilai x dari persamaan ini!', soal: '3x + 7 = 22, x = ?', opsi: ['3', '5', '7', '9'], jawaban: 1, trik: '3x = 22 − 7 = 15, lalu x = 15 ÷ 3 = 5' },
  { id: 4, materi: 'Eksponen', level: 2, intro: 'Hitung dengan teliti ya!', soal: '2² + 3² = ?', opsi: ['10', '12', '13', '25'], jawaban: 2, trik: '2² = 4 dan 3² = 9, jadi 4 + 9 = 13' },
  { id: 5, materi: 'Aljabar Linear', level: 2, intro: 'Cari nilai x dari persamaan ini!', soal: 'x − 5 = 8, x = ?', opsi: ['3', '11', '13', '40'], jawaban: 2, trik: 'Pindahkan −5 ke kanan jadi +5, maka x = 8 + 5 = 13' },
  { id: 6, materi: 'Persen', level: 2, intro: 'Hitung persentasenya!', soal: '25% dari 80 = ?', opsi: ['15', '20', '25', '40'], jawaban: 1, trik: '25% = ¼, jadi 80 ÷ 4 = 20' },
  { id: 7, materi: 'Bilangan Bulat', level: 3, intro: 'Awas tanda minusnya!', soal: '−15 + 8 × (−3) = ?', opsi: ['−39', '−21', '−9', '9'], jawaban: 0, trik: 'Kalikan dulu: 8 × (−3) = −24, lalu −15 + (−24) = −39' },
  { id: 8, materi: 'Aljabar Linear', level: 3, intro: 'Cari nilai x dari persamaan ini!', soal: '2x + 3 = 4x − 5, x = ?', opsi: ['2', '3', '4', '8'], jawaban: 2, trik: 'Pindahkan suku: 3 + 5 = 4x − 2x, jadi 8 = 2x dan x = 4' },
  { id: 9, materi: 'Operasi Dasar', level: 2, intro: 'Hitung pembagian berikut!', soal: '144 ÷ 12 = ?', opsi: ['10', '11', '12', '14'], jawaban: 2, trik: '12 × 12 = 144, jadi hasilnya 12' },
  { id: 10, materi: 'Pythagoras', level: 3, intro: 'Sisi miring segitiga siku-siku (alas 9, tinggi 12)', soal: 'c = ?', opsi: ['13', '15', '17', '21'], jawaban: 1, trik: '9² + 12² = 81 + 144 = 225, akar dari 225 adalah 15' },
  { id: 11, materi: 'Eksponen', level: 3, intro: 'Sederhanakan bentuk pangkat!', soal: '2³ × 2⁴ = 2^?', opsi: ['7', '12', '14', '24'], jawaban: 0, trik: 'Pangkat dijumlah kalau bilangan pokoknya sama: 3 + 4 = 7' },
  { id: 12, materi: 'Pecahan', level: 2, intro: 'Jumlahkan pecahan berikut!', soal: '½ + ¼ = ?', opsi: ['¾', '⅔', '⅖', '1'], jawaban: 0, trik: 'Samakan penyebut: 2/4 + 1/4 = 3/4' },
  { id: 13, materi: 'Operasi Dasar', level: 3, intro: 'Hitung perkalian berikut secepat mungkin!', soal: '17 × 5 = ?', opsi: ['75', '80', '85', '95'], jawaban: 2, trik: '17 × 5 = 17 × 10 ÷ 2 = 170 ÷ 2 = 85' },
  { id: 14, materi: 'Akar', level: 2, intro: 'Hitung akar kuadratnya!', soal: '√169 = ?', opsi: ['11', '12', '13', '14'], jawaban: 2, trik: '13 × 13 = 169, jadi akarnya 13' },
  { id: 15, materi: 'Aljabar Linear', level: 3, intro: 'Sederhanakan bentuk aljabar!', soal: '3(x + 4) − 2x = ?', opsi: ['x + 4', 'x + 12', '5x + 12', 'x − 12'], jawaban: 1, trik: '3x + 12 − 2x = x + 12' },
  { id: 16, materi: 'Persen', level: 3, intro: 'Hitung diskonnya!', soal: 'Harga 200.000 diskon 15%, bayar = ?', opsi: ['170.000', '175.000', '185.000', '30.000'], jawaban: 0, trik: 'Diskon 15% = 30.000, jadi bayar 200.000 − 30.000 = 170.000' },
  { id: 17, materi: 'Bilangan Bulat', level: 2, intro: 'Awas tanda minusnya!', soal: '(−7) × (−6) = ?', opsi: ['−42', '−13', '42', '13'], jawaban: 2, trik: 'Negatif kali negatif hasilnya positif, 7 × 6 = 42' },
  { id: 18, materi: 'Pythagoras', level: 2, intro: 'Tripel Pythagoras, cari sisi yang hilang!', soal: 'Sisi siku-siku 3 dan 4, sisi miringnya = ?', opsi: ['5', '6', '7', '8'], jawaban: 0, trik: '3² + 4² = 9 + 16 = 25, akarnya 5' },
  { id: 19, materi: 'Selisih Kuadrat', level: 3, intro: 'Pakai trik a² − b² = (a−b)(a+b)!', soal: '105² − 95² = ?', opsi: ['1.000', '2.000', '2.500', '10.000'], jawaban: 1, trik: '(105 + 95)(105 − 95) = 200 × 10 = 2.000' },
  { id: 20, materi: 'Aljabar Linear', level: 3, intro: 'Cari nilai x dari persamaan ini!', soal: '5x − 9 = 2x + 6, x = ?', opsi: ['3', '4', '5', '15'], jawaban: 2, trik: '5x − 2x = 6 + 9, jadi 3x = 15 dan x = 5' }
];
const DAFTAR_TIPS = [
  'Latihan matriks 2×2 akan mempermudah penyelesaian soal SPLDV kompleks.',
  'Kerjakan perkalian dulu sebelum penjumlahan, ingat urutan PEMDAS/KABATAKU.',
  'Beri tanda kurung pada bilangan negatif biar tanda minusnya nggak tertukar.',
  'Kalau ragu, coba masukkan jawabanmu balik ke soal buat ngecek.',
  'Hafalkan kuadrat 1 sampai 20, banyak soal jadi terasa lebih ringan.',
  'Istirahat 5 menit setiap 25 menit belajar bikin ingatan lebih awet.'
];

let daftarSoal = [];
let idx = 0;              // Posisi soal
let jumlahBenar = 0;
let combo = 0, comboMax = 0;
let sudahJawab = false;
let sesiBerjalan = false;
let detik = 60;
let intervalTimer = null;
const waktuMulai = Date.now();
const HURUF = ['A', 'B', 'C', 'D'];

// Acak urutan soal
function acak(arr) {
  const a = [...arr];
  for (let i = a.length - 1; i > 0; i--) {
    const j = Math.floor(Math.random() * (i + 1));
    [a[i], a[j]] = [a[j], a[i]];
  }
  return a;
}

// Materi untuk tiap topik
const PETA_TOPIK = {
  'Aljabar Linear Dasar': ['Aljabar Linear'],
  'Operasi Bilangan & Eksponen': ['Operasi Dasar', 'Eksponen', 'Akar', 'Bilangan Bulat'],
  'Persamaan & Pertidaksamaan': ['Aljabar Linear', 'Persen'],
  'Geometri & Pythagoras': ['Pythagoras', 'Selisih Kuadrat']
};

function siapkanSoal() {
  let bank = BANK_SOAL;

  if (MODE === 'kilat') {
    const mode = sessionStorage.getItem('numa_mode');
    const topik = sessionStorage.getItem('numa_topik');
    bank = acak(bank);
    // Dahulukan soal sesuai topik yang dipilih
    if (mode === 'spesifik' && PETA_TOPIK[topik]) {
      const cocok = bank.filter(s => PETA_TOPIK[topik].includes(s.materi));
      const sisa  = bank.filter(s => !cocok.includes(s));
      bank = [...cocok, ...sisa];
    }
    bank = bank.slice(0, JUMLAH);
  }
  // Acak pilihan jawaban
  return bank.map(s => {
    const benarTeks = s.opsi[s.jawaban];
    const opsi = acak(s.opsi);
    return { ...s, opsi, jawaban: opsi.indexOf(benarTeks) };
  });
}

function formatWaktu(d) {
  return String(Math.floor(d / 60)).padStart(2, '0') + ':' + String(d % 60).padStart(2, '0');
}

function tampilkanSoal() {
  sudahJawab = false;
  const s = daftarSoal[idx];

  elInfoSoal.textContent = `SOAL ${idx + 1} DARI ${daftarSoal.length}`;
  const persen = Math.round((idx / daftarSoal.length) * 100);
  elInfoPersen.textContent = persen + '% Selesai';
  elBar.style.width = persen + '%';

  elTag.textContent = `${s.materi.toUpperCase()} • LEVEL ${s.level}`;
  elIntro.textContent = s.intro;
  // Beri warna khusus pada tanda tanya
  elSoal.innerHTML = s.soal.replace('?', '<span class="tanya">?</span>');

  elOpsi.innerHTML = '';
  s.opsi.forEach((teks, i) => {
    const kartu = document.createElement('button');
    kartu.className = 'opsi-card';
    kartu.innerHTML = `<span class="opsi-huruf">${HURUF[i]}</span><span class="opsi-isi">${teks}</span><span class="opsi-bulat"></span>`;
    kartu.addEventListener('click', () => jawab(i));
    // Beri efek saat kursor diarahkan
    kartu.addEventListener('mouseenter', () => { if (!sudahJawab) kartu.style.zIndex = 2; });
    kartu.addEventListener('mouseleave', () => { kartu.style.zIndex = ''; });
    elOpsi.appendChild(kartu);
  });

  elFeedback.hidden = true;
  if (MODE === 'kilat') mulaiTimer();
}

// Timer untuk mode kuis kilat
function mulaiTimer() {
  detik = 60;
  elTimerPill.classList.remove('bahaya');
  elTimerTeks.textContent = formatWaktu(detik);
  clearInterval(intervalTimer);
  intervalTimer = setInterval(() => {
    detik--;
    elTimerTeks.textContent = formatWaktu(detik);
    if (detik <= 10) elTimerPill.classList.add('bahaya');
    if (detik <= 0) {
      clearInterval(intervalTimer);
      jawab(-1);   // -1 berarti waktu habis
    }
  }, 1000);
}

function jawab(pilihan) {
  if (sudahJawab) return;
  sudahJawab = true;
  clearInterval(intervalTimer);

  const s = daftarSoal[idx];
  const benar = pilihan === s.jawaban;
  const kartu = elOpsi.querySelectorAll('.opsi-card');

  kartu.forEach((k, i) => {
    k.disabled = true;
    if (i === s.jawaban) k.classList.add('benar');
    if (i === pilihan && !benar) k.classList.add('salah');
    if (i === pilihan) k.querySelector('.opsi-bulat').innerHTML = '<i class="ri-check-line"></i>';
  });

  const fbJudul = document.getElementById('fbJudul');
  const fbDetail = document.getElementById('fbDetail');
  const fbIkon = document.getElementById('fbIkon');
  const jawabanBenar = s.opsi[s.jawaban];

  if (benar) {
    jumlahBenar++; combo++; comboMax = Math.max(combo, comboMax);
    elFeedback.className = 'feedback-bar benar';
    fbIkon.innerHTML = '<i class="ri-check-line"></i>';
    fbJudul.textContent = ['Luar Biasa, Benar!', 'Mantap, Tepat Sekali!', 'Keren, Jawabanmu Benar!'][Math.floor(Math.random() * 3)];
    fbDetail.textContent = s.soal.replace('?', jawabanBenar);
  } else {
    combo = 0;
    elFeedback.className = 'feedback-bar salah';
    fbIkon.innerHTML = '<i class="ri-close-line"></i>';
    fbJudul.textContent = pilihan === -1 ? 'Waktu Habis!' : 'Jawabanmu Salah';
    fbDetail.innerHTML = pilihan === -1
      ? `Jawaban yang benar adalah <span class="hijau">${jawabanBenar}</span>.`
      : `Kamu pilih <span class="merah">${s.opsi[pilihan]}</span>, tapi jawaban yang benar adalah <span class="hijau">${jawabanBenar}</span>.`;
    // Jawaban salah mengurangi hati di mode course
    if (MODE === 'course') kurangiHati();
  }
  document.getElementById('fbTrik').textContent = s.trik;
  elFeedback.hidden = false;
  elFeedback.scrollIntoView({ behavior: 'smooth', block: 'nearest' });
}

function kurangiHati() {
  const sisa = Numa.ubah('hati', -1);
  document.querySelector('.badge-hati').classList.add('goyang');
  setTimeout(() => document.querySelector('.badge-hati').classList.remove('goyang'), 500);
  if (sisa <= 0) {
    clearInterval(intervalTimer);
    sesiBerjalan = false;
    // Hentikan sesi kalau hati habis
    alert('Yah, hati kamu habis! Beli hati dulu di halaman Misi (Shop Hati) buat lanjut belajar.');
    window.location.href = 'misi.html';
  }
}

function lanjut() {
  if (!sudahJawab) return;
  idx++;
  if (idx >= daftarSoal.length) return selesai();
  tampilkanSoal();
  window.scrollTo({ top: 0, behavior: 'smooth' });
}

async function selesai() {
  sesiBerjalan = false;
  clearInterval(intervalTimer);
  elBar.style.width = '100%';
  elInfoPersen.textContent = '100% Selesai';

  const total = daftarSoal.length;
  const akurasi = Math.round((jumlahBenar / total) * 100);
  const detikTotal = Math.round((Date.now() - waktuMulai) / 1000);
  const bonus = comboMax >= 3 ? (MODE === 'kilat' ? 5 : 10) : 0;
  const xp = MODE === 'kilat' ? jumlahBenar * 3 + bonus : jumlahBenar * 2 + bonus;
  const koinDapat = Math.floor(jumlahBenar / 2);

  // Simpan hasil sesi
  const d = Numa.ambil();
  d.xp += xp;
  d.koin += koinDapat;
  d.soalTerjawab += total;
  d.riwayat.unshift({
    materi: MODE === 'kilat' ? 'Quiz Kilat Campuran' : 'Course Unit 1',
    waktu: 'Baru saja', hasil: `${jumlahBenar}/${total} Benar`, xp
  });
  d.riwayat = d.riwayat.slice(0, 5);
  Numa.simpan(d);

  // Tampilkan halaman hasil
  areaSoal.hidden = true;
  elFeedback.hidden = true;
  areaHasil.hidden = false;
  document.getElementById('hasilXp').textContent = xp;
  document.getElementById('hasilAkurasi').textContent = akurasi;
  document.getElementById('hasilBenar').textContent = `${jumlahBenar} dari ${total} Soal Tepat`;
  document.getElementById('hasilWaktu').textContent = formatWaktu(detikTotal);
  document.getElementById('hasilRata').textContent = `~${Math.round(detikTotal / total)} Detik / Soal`;
  document.getElementById('hasilBonus').style.display = bonus ? '' : 'none';
  document.getElementById('hasilJudul').textContent = akurasi >= 80 ? 'Kerja Bagus!' : akurasi >= 50 ? 'Lumayan, Terus Semangat!' : 'Jangan Menyerah!';
  document.getElementById('hasilDesk').innerHTML =
    `Kamu menuntaskan sesi <b>${MODE === 'kilat' ? 'Kuis Kilat' : 'Course Operasi Bilangan'}</b> dan mendapat <b>${koinDapat} koin</b> tambahan. ${akurasi >= 80 ? 'Fokus tajam dan tempo sangat mengesankan!' : 'Coba ulangi lagi buat nambah akurasi.'}`;

  document.getElementById('hasilTips').textContent = DAFTAR_TIPS[Math.floor(Math.random() * DAFTAR_TIPS.length)];
  toast('sukses', 'Sesi selesai!', `+${xp} XP masuk ke akunmu`);
}

document.getElementById('btnLanjut').addEventListener('click', lanjut);

// Konfirmasi sebelum keluar dari sesi
document.getElementById('btnTutup').addEventListener('click', () => {
  const keluar = confirm('Yakin mau keluar? Progress sesi ini nggak akan kesimpen.');
  if (keluar) {
    sesiBerjalan = false;
    window.location.href = MODE === 'kilat' ? 'quiz.html' : 'path-learning.html';
  }
});

// Angka 1-4 untuk menjawab, Enter untuk lanjut
document.addEventListener('keydown', e => {
  if (areaSoal.hidden) return;
  if (['1', '2', '3', '4'].includes(e.key) && !sudahJawab) jawab(parseInt(e.key, 10) - 1);
  else if (e.key === 'Enter' && sudahJawab) lanjut();
});

// Konfirmasi sebelum tab ditutup
window.addEventListener('beforeunload', e => {
  if (sesiBerjalan) { e.preventDefault(); e.returnValue = ''; }
});

// Aktifkan papan coretan di mode course
function aktifkanCoretan() {
  const kanvas = document.getElementById('scratchCanvas');
  if (!kanvas) return;
  const ctx = kanvas.getContext('2d');
  const papan = document.getElementById('scratchBoard');
  const hint = document.getElementById('scratchHint');
  let lagiNggambar = false;
  let terakhir = { x: 60, y: 100 };

  // Sesuaikan ukuran kanvas saat jendela berubah
  function sesuaikanUkuran() {
    const gambar = kanvas.toDataURL();
    kanvas.width = papan.clientWidth;
    kanvas.height = papan.clientHeight;
    const img = new Image();
    img.onload = () => ctx.drawImage(img, 0, 0);
    img.src = gambar;
  }
  sesuaikanUkuran();
  window.addEventListener('resize', sesuaikanUkuran);

  const posisi = e => {
    const r = kanvas.getBoundingClientRect();
    return { x: e.clientX - r.left, y: e.clientY - r.top };
  };

  kanvas.addEventListener('pointerdown', e => {
    lagiNggambar = true;
    terakhir = posisi(e);
    hint.style.display = 'none';
    kanvas.setPointerCapture(e.pointerId);
  });
  kanvas.addEventListener('pointermove', e => {
    if (!lagiNggambar) return;
    const p = posisi(e);
    ctx.strokeStyle = '#3d3ac0';
    ctx.lineWidth = 2.5;
    ctx.lineCap = 'round';
    ctx.beginPath();
    ctx.moveTo(terakhir.x, terakhir.y);
    ctx.lineTo(p.x, p.y);
    ctx.stroke();
    terakhir = p;
  });
  ['pointerup', 'pointerleave'].forEach(n => kanvas.addEventListener(n, () => { lagiNggambar = false; }));

  document.getElementById('btnBersih').addEventListener('click', () => {
    ctx.clearRect(0, 0, kanvas.width, kanvas.height);
    hint.style.display = '';
  });
  document.getElementById('btnGrid').addEventListener('click', e => {
    papan.classList.toggle('grid');
    e.currentTarget.classList.toggle('aktif');
  });
  // Tambahkan simbol di posisi terakhir
  document.querySelectorAll('.sym-btn').forEach(b => {
    b.addEventListener('click', () => {
      ctx.fillStyle = '#131b2e';
      ctx.font = '700 28px "Plus Jakarta Sans", sans-serif';
      ctx.fillText(b.textContent, terakhir.x, terakhir.y);
      hint.style.display = 'none';
      terakhir.x += 30;
    });
  });
}

(async function init() {
  // Cek hati sebelum mulai course
  if (MODE === 'course' && Numa.ambil().hati <= 0) {
    alert('Hati kamu habis. Beli hati dulu di halaman Misi ya.');
    window.location.href = 'misi.html';
    return;
  }
  elSoal.textContent = 'Menyiapkan soal...';
  daftarSoal = await siapkanSoal();
  sesiBerjalan = true;
  tampilkanSoal();
  aktifkanCoretan();
})();
