// Dipakai di halaman admin

document.addEventListener('DOMContentLoaded', () => {

  // Atur aksi tombol dari teksnya
  document.querySelectorAll('button, a.btn').forEach(el => {
    const teks = el.textContent.trim().toLowerCase();
    if (el.type === 'submit') return;

    if (teks.includes('hapus')) {
      el.addEventListener('click', e => {
        e.preventDefault();
        if (confirm('Yakin mau menghapus data ini? Tindakan ini nggak bisa dibatalkan.')) {
          const baris = el.closest('tr, .course-card, .card');
          if (baris) baris.remove();
          alert('Data berhasil dihapus.');
        }
      });
    } else if (teks.includes('simpan') || teks.includes('publikasi')) {
      el.addEventListener('click', e => {
        e.preventDefault();
        alert('Perubahan berhasil disimpan.');
      });
    } else if (teks.includes('ekspor')) {
      el.addEventListener('click', () => {
        const format = prompt('Mau diekspor ke format apa? (csv / pdf)', 'csv');
        if (format) alert('Data diekspor sebagai ' + format.toLowerCase() + '. (simulasi)');
      });
    }
  });

  // Tandai halaman yang dipilih
  document.querySelectorAll('.btn-page').forEach(b => {
    b.addEventListener('click', () => {
      b.parentElement.querySelectorAll('.btn-page').forEach(x => x.classList.remove('active'));
      if (/^\d+$/.test(b.textContent.trim())) b.classList.add('active');
    });
  });

  // Filter tabel saat mencari
  const cari = document.querySelector('input[type="search"], input[placeholder*="Cari"], input[placeholder*="cari"]');
  if (cari) {
    cari.addEventListener('input', () => {
      const kata = cari.value.toLowerCase();
      document.querySelectorAll('tbody tr').forEach(tr => {
        tr.style.display = tr.textContent.toLowerCase().includes(kata) ? '' : 'none';
      });
    });
  }

  // Konfirmasi sebelum keluar
  document.querySelectorAll('a, button').forEach(el => {
    if (/keluar|logout/i.test(el.textContent)) {
      el.addEventListener('click', e => {
        e.preventDefault();
        if (confirm('Keluar dari panel admin?')) location.href = '../login.html';
      });
    }
  });
});
