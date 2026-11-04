// 1. DATA SOAL (5 Pertanyaan Pilihan Ganda)
   const questions = [
  {
    q: "Jika 3x + 7 = 22, berapakah nilai dari x?",
    options: ["3", "5", "7", "9"],
    answer: 1 // index 1 = pilihan B (5)
  },
  {
    q: "Berapakah hasil dari 2² + 3²?",
    options: ["10", "12", "13", "25"],
    answer: 2 // index 2 = pilihan C (13)
  },
  {
    q: "Jika x − 5 = 8, berapakah nilai x?",
    options: ["3", "11", "13", "40"],
    answer: 2 // index 2 = pilihan C (13)
  },
  {
    q: "Berapakah 25% dari 80?",
    options: ["15", "20", "25", "40"],
    answer: 1 // index 1 = pilihan B (20)
  },
  {
    q: "Jika 2x + 3 = 4x − 5, berapakah nilai x?",
    options: ["2", "3", "4", "8"],
    answer: 2 // index 2 = pilihan C (4)
  }
];

// 2. STATE (Status Quiz Saat Ini)
let currentQuestion = 0;
let score = 0;
let timeLeft = 60;
let timerInterval = null;
let answered = false;

// 3. DOM REFERENCES (Element yang Akan Dimanipulasi)
const timerBadge   = document.getElementById('timerBadge');
const progressFill = document.getElementById('progressFill');
const questionNumber = document.getElementById('questionNumber');
const questionText = document.getElementById('questionText');
const optionsGrid  = document.getElementById('optionsGrid');
const scoreTag     = document.getElementById('scoreTag');
const toastContainer = document.getElementById('toastContainer');

// 4. TOAST / SNACKBAR FUNCTION
/**
 * Menampilkan toast notification.
 * @param {string} type    - 'success' | 'error' | 'info'
 * @param {string} title   - Judul singkat
 * @param {string} message - Pesan detail
 * @param {number} duration - Berapa lama tampil (ms)
 */
function showToast(type, title, message, duration = 3000) {
  // Buat element toast
  const toast = document.createElement('div');
  toast.className = `toast ${type}`;

  // Icon berdasarkan tipe
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

  // Tambahkan ke container
  toastContainer.appendChild(toast);

  // Animasi masuk (delay 10ms agar transition ter-trigger)
  setTimeout(() => toast.classList.add('show'), 10);

  // Auto hapus setelah `duration`
  setTimeout(() => {
    toast.classList.remove('show');
    setTimeout(() => toast.remove(), 450);
  }, duration);
}

// 5. TIMER (Hitung Mundur 60 Detik per Soal)
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

    // Warnai merah jika <= 10 detik
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

// 6. LOAD & RENDER SOAL
function loadQuestion() {
  answered = false;
  const q = questions[currentQuestion];
  const labels = ['A', 'B', 'C', 'D'];

  // ---- DOM Manipulation #1: Update teks nomor soal ----
  questionNumber.textContent = `SOAL ${currentQuestion + 1} DARI ${questions.length}`;

  // ---- DOM Manipulation #2: Update teks pertanyaan ----
  questionText.textContent = q.q;

  // ---- DOM Manipulation #3: Update lebar progress bar ----
  const progressPercent = (currentQuestion / questions.length) * 100;
  progressFill.style.width = `${progressPercent}%`;

  // ---- DOM Manipulation #4: Regenerate tombol opsi jawaban ----
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

  // Mulai timer untuk soal ini
  startTimer();
}

// 7. HANDLE PILIHAN JAWABAN
function selectOption(selectedIdx) {
  if (answered) return;
  answered = true;
  clearInterval(timerInterval);

  const q = questions[currentQuestion];
  const isCorrect = selectedIdx === q.answer;

  if (isCorrect) {
    score += 10;
    // ---- DOM Manipulation #5: Update skor ----
    scoreTag.textContent = `🔥 Skor: ${score}`;
    showToast('success', '🎉 Jawaban Benar!', `+10 XP • ${q.options[selectedIdx]} tepat!`);
  } else {
    showToast('error', '❌ Jawaban Salah', `Jawaban benar: ${q.options[q.answer]}`);
  }

  revealAnswer(selectedIdx);
  setTimeout(nextQuestion, 2400);
}

// 8. TAMPILKAN JAWABAN BENAR & SALAH
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

// 9. LANJUT KE SOAL BERIKUTNYA / SELESAI
function nextQuestion() {
  currentQuestion++;

  if (currentQuestion >= questions.length) {
    // Selesai semua soal
    progressFill.style.width = '100%';
    showToast(
      'info',
      '🏆 Quiz Selesai!',
      `Skor akhir kamu: ${score} XP dari ${questions.length * 10} XP.`,
      4500
    );

    // Reset quiz setelah 5 detik
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

// 10. INIT
document.addEventListener('DOMContentLoaded', () => {
  loadQuestion();
  setTimeout(() => {
    showToast('info', '👋 Selamat Datang!', 'Coba jawab quiz kilat di samping kanan!', 3500);
  }, 800);
});