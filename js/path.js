// Klik materi di peta belajar
document.querySelectorAll('.path-node-wrapper').forEach(node => {
  const lingkaran = node.querySelector('.node-circle, .node-box-reward');
  if (!lingkaran) return;
  const judul = node.querySelector('.node-title').textContent.trim();

  node.addEventListener('click', e => {
    if (lingkaran.classList.contains('active-play')) return;
    if (lingkaran.classList.contains('locked')) {
      // Beri tahu kalau materi masih terkunci
      alert('"' + judul + '" masih terkunci. Selesaikan level sebelumnya dulu ya!');
      return;
    }
    if (lingkaran.classList.contains('completed')) {
      // Tawarkan latihan ulang
      if (confirm('"' + judul + '" udah tuntas. Mau latihan ulang?')) location.href = 'quiz-kilat.html';
    }
  });

  // Ubah warna judul saat diarahkan
  node.addEventListener('mouseover', () => { node.querySelector('.node-title').style.color = '#3d3ac0'; });
  node.addEventListener('mouseout',  () => { node.querySelector('.node-title').style.color = ''; });
});

// Tampilkan panduan konsep
document.querySelector('.btn-concept').addEventListener('click', () => {
  tampilModal({
    ikon: 'ri-lightbulb-flash-line', tipe: 'info', judul: 'Panduan Konsep Unit 1',
    isi: 'Ada <b>5 level</b>. Selesaikan berurutan buat dapat bintang dan XP. Level hijau udah tuntas, ungu lagi aktif, abu-abu masih terkunci. Pas level terakhir kebuka, kamu bisa klaim lencana emas.'
  });
});

// Klaim peti harian
const petiKartu = document.querySelector('.chest-card');
const tombolKlaim = petiKartu.querySelector('.btn-claim');
const hariIni = new Date().toISOString().slice(0, 10);

function tandaiPetiSudahDibuka() {
  petiKartu.classList.add('dibuka');
  tombolKlaim.textContent = 'Sudah';
  tombolKlaim.disabled = true;
  petiKartu.querySelector('h4').textContent = 'Peti Harian Sudah Dibuka';
  petiKartu.querySelector('p').textContent = 'Balik lagi besok ya!';
}

tombolKlaim.addEventListener('click', async () => {
  const d = Numa.ambil();
  if (d.petiTerakhir === hariIni) return toast('info', 'Udah dibuka', 'Peti harian cuma bisa sekali sehari.');
  tombolKlaim.textContent = '...';
  await tunggu(700);                                   // Jeda sebelum peti terbuka
  const koin = 10 + Math.floor(Math.random() * 15);    // Dapat 10-24 koin
  d.petiTerakhir = hariIni;
  d.koin += koin; d.xp += 10;
  Numa.simpan(d);
  tandaiPetiSudahDibuka();
  tampilModal({ ikon: 'ri-gift-line', tipe: 'sukses', judul: 'Peti Terbuka!', isi: `Kamu dapat <b>${koin} koin</b> dan <b>10 XP</b>. Lumayan buat beli hati.` });
});
if (Numa.ambil().petiTerakhir === hariIni) tandaiPetiSudahDibuka();

// Perbarui data di sidebar
document.addEventListener('DOMContentLoaded', () => {
  const d = Numa.ambil();
  const angka = document.querySelectorAll('.stat-mini-box .stat-num');
  angka[0].textContent = d.streak + ' Hari';
  angka[1].textContent = d.xp;
  document.querySelector('.league-item.active-user .xp-value').textContent = d.xp + ' XP';
  document.querySelector('.tag-level-purple').textContent = 'Level ' + (Math.floor(d.xp / 500) + 1);
});
