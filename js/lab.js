// Data soal remedial
const SOAL_LAB = [
  { id: 'lab1', kategori: 'tanda',      xp: 20, jawaban: ['-39'] },
  { id: 'lab2', kategori: 'konsep',     xp: 15, jawaban: ['2x^2+5x-12', '2x2+5x-12'],
    tanya: 'Sederhanakan bentuk: (2x - 3)(x + 4)\n(tulis pangkat dua pakai ^, contoh x^2)' },
  { id: 'lab3', kategori: 'aritmatika', xp: 15, jawaban: ['15', '15cm'],
    tanya: 'Sisi miring segitiga siku-siku dengan alas 9 cm dan tinggi 12 cm = ... cm' }
];

const kartuLab = [...document.querySelectorAll('.remedial-card')];
const pil = document.querySelectorAll('.filter-btn');
let kesempatan = 1;

// Samakan format jawaban sebelum dicek
function rapikan(teks) {
  return teks.toLowerCase().replace(/\s+/g, '')
    .replace(/[−–—]/g, '-').replace(/²/g, '^2').replace(/,/g, '.');
}

kartuLab.forEach((k, i) => { k.dataset.id = SOAL_LAB[i].id; k.dataset.kat = SOAL_LAB[i].kategori; });

// Hapus soal yang sudah diperbaiki
Numa.ambil().labBeres.forEach(id => {
  const k = document.querySelector(`.remedial-card[data-id="${id}"]`);
  if (k) k.remove();
});

function perbaruiHitungan() {
  const sisa = [...document.querySelectorAll('.remedial-card')];
  const hitung = kat => sisa.filter(k => k.dataset.kat === kat).length;
  const angka = document.querySelectorAll('.filter-btn .badge-count');
  angka[0].textContent = sisa.length;
  angka[1].textContent = hitung('aritmatika');
  angka[2].textContent = hitung('konsep');
  angka[3].textContent = hitung('tanda');

  // Tampilkan pesan kalau semua soal sudah selesai
  if (!sisa.length && !document.getElementById('labKosong')) {
    const kosong = document.createElement('div');
    kosong.id = 'labKosong';
    kosong.className = 'remedial-card';
    kosong.innerHTML = '<h3 style="font-size:1.3rem">Semua kesalahan udah diperbaiki 🎉</h3><p class="muted" style="margin-top:6px">Hebat! Coba lanjut ke Quiz Kilat buat nambah XP.</p>';
    document.querySelector('.lab-main-section').appendChild(kosong);
  }
}

// Hapus kartu setelah animasi
async function hapusKartu(kartu, id) {
  kartu.classList.add('hilang');
  await tunggu(350);
  kartu.remove();
  const d = Numa.ambil();
  if (!d.labBeres.includes(id)) d.labBeres.push(id);
  Numa.simpan(d);
  perbaruiHitungan();
}

const urutanKat = ['semua', 'aritmatika', 'konsep', 'tanda'];
pil.forEach((b, i) => {
  b.addEventListener('click', () => {
    pil.forEach(x => x.classList.remove('active'));
    b.classList.add('active');
    document.querySelectorAll('.remedial-card[data-kat]').forEach(k => {
      k.style.display = (urutanKat[i] === 'semua' || k.dataset.kat === urutanKat[i]) ? '' : 'none';
    });
  });
});

const input = document.querySelector('.input-answer');
const tombolVerif = document.querySelector('.btn-verify');
const chance = document.querySelector('.chance-tag');

async function verifikasi() {
  const nilai = rapikan(input.value);
  if (!nilai) {
    input.classList.add('salah');
    toast('error', 'Masih kosong', 'Tulis dulu jawabanmu.');
    setTimeout(() => input.classList.remove('salah'), 500);
    return;
  }

  if (SOAL_LAB[0].jawaban.includes(nilai)) {
    input.classList.remove('salah'); input.classList.add('benar');
    tombolVerif.disabled = true;
    Numa.ubah('xp', SOAL_LAB[0].xp);
    // Tampilkan pesan kalau jawaban benar
    await tampilModal({ ikon: 'ri-check-double-line', tipe: 'sukses', judul: 'Perbaikanmu Benar!',
      isi: 'Urutan operasinya udah pas: <b>perkalian dulu, baru penjumlahan</b>. Kamu dapat <b>+20 XP</b>.' });
    hapusKartu(document.querySelector('.remedial-card.active-item'), 'lab1');
    return;
  }

  // Jawaban salah
  input.classList.add('salah');
  setTimeout(() => input.classList.remove('salah'), 500);
  if (kesempatan >= 2) {
    tombolVerif.disabled = true;
    await tampilModal({ ikon: 'ri-close-circle-line', tipe: 'bahaya', judul: 'Kesempatan habis',
      isi: 'Jawaban yang benar adalah <b>-39</b>. Baca lagi langkah 1 dan 2 di atas ya.' });
    hapusKartu(document.querySelector('.remedial-card.active-item'), 'lab1');
  } else {
    kesempatan++;
    chance.textContent = `Kesempatan ${kesempatan} dari 2`;
    toast('error', 'Belum tepat', 'Coba perhatiin urutan operasinya lagi.');
  }
}

tombolVerif.addEventListener('click', verifikasi);
// Enter untuk mengecek jawaban
input.addEventListener('keydown', e => { if (e.key === 'Enter') verifikasi(); });
// Hapus tanda salah saat mulai mengetik
input.addEventListener('input', () => input.classList.remove('salah'));

// Coba kerjakan ulang soal
document.querySelectorAll('.btn-retry').forEach(btn => {
  btn.addEventListener('click', async () => {
    const kartu = btn.closest('.remedial-card');
    const soal = SOAL_LAB.find(s => s.id === kartu.dataset.id);

    const jawab = prompt(soal.tanya);
    if (jawab === null) return;
    if (soal.jawaban.includes(rapikan(jawab))) {
      Numa.ubah('xp', soal.xp);
      toast('sukses', 'Benar!', `+${soal.xp} XP buat kamu.`);
      hapusKartu(kartu, soal.id);
    } else {
      alert('Belum tepat. Baca lagi catatan evaluasinya terus coba sekali lagi ya.');
    }
  });
});

document.addEventListener('DOMContentLoaded', perbaruiHitungan);
