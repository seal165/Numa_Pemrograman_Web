// Data soal kuis
   const questions = [
  {
    q: "Jika 3x + 7 = 22, berapakah nilai dari x?",
    options: ["3", "5", "7", "9"],
    answer: 1 // Pilihan B
  },
  {
    q: "Berapakah hasil dari 2² + 3²?",
    options: ["10", "12", "13", "25"],
    answer: 2 // Pilihan C
  },
  {
    q: "Jika x − 5 = 8, berapakah nilai x?",
    options: ["3", "11", "13", "40"],
    answer: 2 // Pilihan C
  },
  {
    q: "Berapakah 25% dari 80?",
    options: ["15", "20", "25", "40"],
    answer: 1 // Pilihan B
  },
  {
    q: "Jika 2x + 3 = 4x − 5, berapakah nilai x?",
    options: ["2", "3", "4", "8"],
    answer: 2 // Pilihan C
  }
];

// Status kuis
let currentQuestion = 0;
let score = 0;
let timeLeft = 60;
let timerInterval = null;
let answered = false;

// Elemen halaman kuis
const timerBadge   = document.getElementById('timerBadge');
const progressFill = document.getElementById('progressFill');
const questionNumber = document.getElementById('questionNumber');
const questionText = document.getElementById('questionText');
const optionsGrid  = document.getElementById('optionsGrid');
const scoreTag     = document.getElementById('scoreTag');
const toastContainer = document.getElementById('toastContainer');

// Tampilkan notifikasi singkat
function showToast(type, title, message, duration = 3000) {
  const toast = document.createElement('div');
  toast.className = `toast ${type}`;

  // Pilih ikon sesuai jenis pesan
  let icon = 'ℹ';
  if (type === 'success') icon = '✓';
  if (type === 'error')   icon = '✕';

  toast.innerHTML = `
    <div class="toast-icon">${icon}</div>
    <div class="toast-content">
      <div class="toast-title">${title}</div>
      <div class="toast-message">${message}</div>
    </div>
  `;

  toastContainer.appendChild(toast);

  // Tampilkan animasi
  setTimeout(() => toast.classList.add('show'), 10);

  // Hapus setelah beberapa saat
  setTimeout(() => {
    toast.classList.remove('show');
    setTimeout(() => toast.remove(), 450);
  }, duration);
}

// Timer 60 detik untuk tiap soal
function formatTime(seconds) {
  const m = String(Math.floor(seconds / 60)).padStart(2, '0');
  const s = String(seconds % 60).padStart(2, '0');
  return `${m}:${s}`;
}

function startTimer() {
  timeLeft = 60;
  timerBadge.textContent = `⏱ ${formatTime(timeLeft)}`;
  timerBadge.classList.remove('danger');

  clearInterval(timerInterval);
  timerInterval = setInterval(() => {
    timeLeft--;
    timerBadge.textContent = `⏱ ${formatTime(timeLeft)}`;

    // Beri tanda saat waktu hampir habis
    if (timeLeft <= 10) timerBadge.classList.add('danger');

    if (timeLeft <= 0) {
      clearInterval(timerInterval);
      handleTimeout();
    }
  }, 1000);
}

function handleTimeout() {
  if (answered) return;
  answered = true;

  const q = questions[currentQuestion];
  revealAnswer(-1);
  showToast('error', '⏰ Waktu Habis!', `Jawaban benar: ${q.options[q.answer]}`);
  setTimeout(nextQuestion, 2400);
}

// Tampilkan soal
function loadQuestion() {
  answered = false;
  const q = questions[currentQuestion];
  const labels = ['A', 'B', 'C', 'D'];

  // Perbarui nomor soal
  questionNumber.textContent = `SOAL ${currentQuestion + 1} DARI ${questions.length}`;

  questionText.textContent = q.q;

  // Perbarui progres
  const progressPercent = (currentQuestion / questions.length) * 100;
  progressFill.style.width = `${progressPercent}%`;

  // Tampilkan pilihan jawaban
  optionsGrid.innerHTML = '';
  q.options.forEach((opt, idx) => {
    const btn = document.createElement('div');
    btn.className = 'option-btn';
    btn.dataset.index = idx;
    btn.innerHTML = `
      <span>${labels[idx]}. ${opt}</span>
      <span class="radio-circle"></span>
    `;
    btn.addEventListener('click', () => selectOption(idx));
    optionsGrid.appendChild(btn);
  });

  startTimer();
}

// Cek jawaban yang dipilih
function selectOption(selectedIdx) {
  if (answered) return;
  answered = true;
  clearInterval(timerInterval);

  const q = questions[currentQuestion];
  const isCorrect = selectedIdx === q.answer;

  if (isCorrect) {
    score += 10;
    scoreTag.textContent = `🔥 Skor: ${score}`;
    showToast('success', '🎉 Jawaban Benar!', `+10 XP • ${q.options[selectedIdx]} tepat!`);
  } else {
    showToast('error', '❌ Jawaban Salah', `Jawaban benar: ${q.options[q.answer]}`);
  }

  revealAnswer(selectedIdx);
  setTimeout(nextQuestion, 2400);
}

// Tandai jawaban benar dan salah
function revealAnswer(selectedIdx) {
  const q = questions[currentQuestion];
  const optionEls = optionsGrid.querySelectorAll('.option-btn');

  optionEls.forEach((el, idx) => {
    el.style.pointerEvents = 'none';

    if (idx === q.answer) {
      el.classList.add('correct-option');
    }

    if (idx === selectedIdx && idx !== q.answer) {
      el.classList.add('wrong-option');
    }
  });
}

// Lanjut ke soal berikutnya
function nextQuestion() {
  currentQuestion++;

  if (currentQuestion >= questions.length) {
    // Tampilkan hasil akhir
    progressFill.style.width = '100%';
    showToast(
      'info',
      '🏆 Quiz Selesai!',
      `Skor akhir kamu: ${score} XP dari ${questions.length * 10} XP.`,
      4500
    );

    // Mulai ulang kuis setelah 5 detik
    setTimeout(() => {
      currentQuestion = 0;
      score = 0;
      scoreTag.textContent = `🔥 Skor: 0`;
      loadQuestion();
    }, 5000);
    return;
  }

  loadQuestion();
}

// Mulai kuis saat halaman siap
document.addEventListener('DOMContentLoaded', () => {
  loadQuestion();
  setTimeout(() => {
    showToast('info', '👋 Selamat Datang!', 'Coba jawab quiz kilat di samping kanan!', 3500);
  }, 800);
});

// Tampilkan petunjuk rumus
document.getElementById('hintLink').addEventListener('click', () => {
  const q = questions[currentQuestion];
  alert('Petunjuk: pindahkan angka yang bukan variabel ke ruas sebelahnya dulu, baru bagi.\n\nSoal ini: ' + q.q);
});

// Gunakan tombol 1-4 untuk menjawab
document.addEventListener('keydown', e => {
  const n = parseInt(e.key, 10);
  if (n >= 1 && n <= 4 && !answered) selectOption(n - 1);
});

// Ubah bayangan header saat scroll
window.addEventListener('scroll', () => {
  const header = document.querySelector('.landing-header');
  if (header) header.style.boxShadow = window.scrollY > 30 ? '0 4px 18px rgba(40,40,120,.12)' : '';
});

// Arahkan ke daftar untuk fitur yang belum tersedia
document.querySelectorAll('.feature-link').forEach(a => {
  a.addEventListener('click', e => {
    e.preventDefault();
    if (confirm('Fitur ini bisa dipakai setelah kamu punya akun. Daftar sekarang?')) location.href = 'register.html';
  });
});

// Animasikan angka statistik saat terlihat
const penghitung = document.querySelectorAll('.stat-number');
const pengamat = new IntersectionObserver((daftar) => {
  daftar.forEach(item => {
    if (!item.isIntersecting || item.target.dataset.sudah) return;
    item.target.dataset.sudah = '1';
    const teksAsli = item.target.textContent;
    const angka = parseFloat(teksAsli.replace(/\./g, '').replace(',', '.'));
    const akhiran = teksAsli.replace(/[0-9.,\s]/g, '');
    let sekarang = 0;
    const langkah = angka / 40;
    const t = setInterval(() => {
      sekarang += langkah;
      if (sekarang >= angka) { sekarang = angka; clearInterval(t); }
      item.target.textContent = (angka % 1 ? sekarang.toFixed(1) : Math.round(sekarang).toLocaleString('id-ID')) + (teksAsli.includes(' ') ? ' ' : '') + akhiran;
    }, 30);
  });
});
penghitung.forEach(el => pengamat.observe(el));
