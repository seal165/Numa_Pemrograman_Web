// Hitung waktu sampai misi direset
function hitungMundur() {
  const sekarang = new Date();
  const besok = new Date(sekarang);
  besok.setHours(24, 0, 0, 0);
  const selisih = Math.floor((besok - sekarang) / 1000);
  const jam = Math.floor(selisih / 3600);
  const menit = Math.floor((selisih % 3600) / 60);
  const nilai = document.querySelectorAll('.time-val');
  nilai[0].textContent = String(jam).padStart(2, '0');
  nilai[1].textContent = String(menit).padStart(2, '0');
}
hitungMundur();
setInterval(hitungMundur, 1000 * 30);    // Update tiap 30 detik

const kartuSiap = document.querySelector('.misi-card.ready');
const tombolKlaim = kartuSiap.querySelector('.btn-claim');
const badgeSelesai = document.querySelector('.badge-counter');

function tandaiDiklaim() {
  kartuSiap.classList.remove('ready');
  kartuSiap.classList.add('selesai');
  tombolKlaim.disabled = true;
  tombolKlaim.innerHTML = '<i class="ri-check-double-line"></i> Sudah Diklaim';
  kartuSiap.querySelector('.tag-status').textContent = 'Selesai';
  kartuSiap.querySelector('.tag-status').className = 'tag-status gray';
  badgeSelesai.textContent = '2 / 3 Selesai';
}

tombolKlaim.addEventListener('click', async () => {
  const pilihan = await tampilModal({
    ikon: 'ri-gift-line', tipe: 'sukses', judul: 'Klaim hadiah?',
    isi: 'Kamu bakal dapat <b>+30 XP</b> dan <b>30 koin</b> dari misi Pemanasan Pagi.',
    tombol: [{ teks: 'Nanti aja', nilai: false }, { teks: 'Klaim Sekarang', gaya: 'utama', nilai: true }]
  });
  if (!pilihan) return;
  const d = Numa.ambil();
  d.xp += 30; d.koin += 30;
  d.misiKlaim.pemanasan = true;
  Numa.simpan(d);
  tandaiDiklaim();
  toast('sukses', 'Hadiah diklaim!', '+30 XP dan +30 koin masuk akun.');
});
if (Numa.ambil().misiKlaim.pemanasan) tandaiDiklaim();

const tujuan = {
  'Lanjut': 'quiz.html', 'Mulai': 'course.html',
  'Lanjut Soal': 'quiz-kilat.html', 'Buka Lab': 'lab-kesalahan.html'
};
document.querySelectorAll('.misi-card .btn:not(.btn-claim)').forEach(b => {
  b.addEventListener('click', () => {
    const url = tujuan[b.textContent.trim()];
    if (url) location.href = url;
  });
});

// Perbarui progres soal mingguan
function perbaruiMaraton() {
  const terjawab = Math.min(Numa.ambil().soalTerjawab, 100);
  const kartu = document.querySelector('.weekly-card');
  kartu.querySelector('.progress-fill').style.width = terjawab + '%';
  kartu.querySelector('.progress-labels span').textContent = terjawab + ' Soal Terjawab';
  kartu.querySelector('.tag-status').textContent = terjawab + '% Selesai';
}
perbaruiMaraton();

// Beli hati dengan koin
document.querySelectorAll('.shop-item').forEach(item => {
  item.addEventListener('click', () => {
    const jumlah = parseInt(item.querySelector('.item-left').textContent.trim(), 10);
    const harga = parseInt(item.querySelector('.item-price').textContent, 10);
    const d = Numa.ambil();

    if (d.hati >= 5) { alert('Hati kamu udah penuh, nggak perlu beli dulu.'); return; }
    if (d.koin < harga) { alert(`Koin kamu belum cukup. Butuh ${harga}, kamu punya ${d.koin}.`); return; }

    if (confirm(`Beli ${jumlah} hati seharga ${harga} koin?`)) {
      d.koin -= harga;
      d.hati = Math.min(5, d.hati + jumlah);     // Maksimal 5 hati
      Numa.simpan(d);
      toast('sukses', 'Pembelian berhasil', `Hati kamu sekarang ${d.hati}.`);
    }
  });
  // Beri petunjuk saat kursor diarahkan
  item.addEventListener('mouseenter', () => { item.title = 'Klik buat beli'; });
});

// Tampilkan semua pencapaian
document.querySelector('.link-see-all').addEventListener('click', e => {
  e.preventDefault();
  const daftar = [...document.querySelectorAll('.achieve-header h4')].map(h => h.textContent).join('<br>');
  tampilModal({ ikon: 'ri-trophy-line', tipe: 'info', judul: 'Pencapaian Spesial', isi: daftar + '<br><br><i>...dan 13 lainnya.</i>' });
});
