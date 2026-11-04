// [PHP] Data user yang lagi login dikirim dari session PHP lewat window.NUMA_USER
// (lihat <script> di user/dashboard.php). Kalau kosong pakai data default.
const NUMA_USER = window.NUMA_USER || { nama: "Jey Raditya Pratama", email: "jey.pratama@sekolah.sch.id", username: "jey_math" };
// [PERBAIKAN] kunci localStorage dibedain per username. Dulu cuma "jey_profile_name",
// jadi kalau ganti akun di browser yang sama, nama akun lama masih muncul.
const KUNCI_NAMA = "jey_profile_name_" + NUMA_USER.username;
const KUNCI_EMAIL = "jey_profile_email_" + NUMA_USER.username;

// [PHP] kirim perubahan nama/email ke server biar $_SESSION ikut berubah
async function kirimKeServer(nama, email) {
    try {
        const fd = new FormData();
        fd.append("nama", nama);
        if (email) fd.append("email", email);
        const res = await fetch("update_profil.php", { method: "POST", body: fd });
        return await res.json();
    } catch (err) {
        return null;   // kalau gagal, localStorage tetap tersimpan
    }
}

// -----------------------------------------------------------------
// 1. WEB STORAGE (LocalStorage) - Narik data profil lokal
// -----------------------------------------------------------------
function muatDataProfilJey() {
    // Ambil data dari storage browser, kalau belum ada ya pakai data default Jey
    const namaTersimpan = localStorage.getItem(KUNCI_NAMA) || NUMA_USER.nama;
    const emailTersimpan = localStorage.getItem(KUNCI_EMAIL) || NUMA_USER.email;

    const inputNama = document.getElementById("inputNamaJey");
    const inputEmail = document.getElementById("inputEmailJey");
    const displayName = document.getElementById("displayNameJey");
    const displayEmail = document.getElementById("displayEmailJey");
    const rankName = document.getElementById("rankNameJey");

    if (inputNama && inputEmail) {
        inputNama.value = namaTersimpan;
        inputEmail.value = emailTersimpan;
    }
    if (displayName) displayName.innerText = namaTersimpan;
    if (displayEmail) displayEmail.innerText = emailTersimpan;
    if (rankName) rankName.innerText = namaTersimpan + " (Kamu)";
}

// -----------------------------------------------------------------
// 2. ASYNCHRONOUS & PROMISE - Simulasi proses simpan data ala server
// -----------------------------------------------------------------
function simpanDataAsync(dataBaru) {
    return new Promise((resolve, reject) => {
        // Simulasi jeda waktu jaringan (pending state) selama 1.5 detik
        setTimeout(() => {
            if (dataBaru.nama.trim() !== "") {
                resolve("Mantap! Data profil berhasil diperbarui ke Web Storage.");
            } else {
                reject("Waduh, namanya jangan dikosongkan ya!");
            }
        }, 1500);
    });
}

// -----------------------------------------------------------------
// 3. FETCH API - Ambil quote motivasi belajar secara asynchronous
// -----------------------------------------------------------------
async function ambilQuotesHarian() {
    try {
        const response = await fetch("https://api.quotable.io/random?tags=technology|education");
        if (!response.ok) throw new Error("Gagal fetch data API");
        
        const hasil = await response.json();
        const teksQuote = document.getElementById("teksApiQuote");
        if (teksQuote) {
            teksQuote.innerHTML = `"${hasil.content}" — <b>${hasil.author}</b>`;
        }
    } catch (err) {
        // Kalau offline atau error, pake quote cadangan lokal biar tetap aman
        const teksQuote = document.getElementById("teksApiQuote");
        if (teksQuote) {
            teksQuote.innerHTML = `"Tetap semangat belajar matematika dan kodingnya, ${NUMA_USER.nama.split(" ")[0]}! Konsistensi itu kunci." — <b>Numa System</b>`;
        }
    }
}

// -----------------------------------------------------------------
// 4. IMPLEMENTASI EVENT LISTENERS & POPUP BOXES
// -----------------------------------------------------------------

// Event 1: DOMContentLoaded (Window Event) -> Jalan pas halaman kelar dimuat
document.addEventListener("DOMContentLoaded", function () {
    muatDataProfilJey();
    ambilQuotesHarian();
});

// Toggle Tombol Edit Profil untuk memunculkan form CRUD
const btnBukaFormEdit = document.getElementById("btnBukaFormEdit");
const formEditContainer = document.getElementById("formEditContainer");
if (btnBukaFormEdit && formEditContainer) {
    btnBukaFormEdit.addEventListener("click", function () {
        if (formEditContainer.style.display === "none") {
            formEditContainer.style.display = "block";
        } else {
            formEditContainer.style.display = "none";
        }
    });
}

// Event 2: input (Form Event) -> Cek kekuatan sandi secara real-time pas diketik
const inputSandi = document.getElementById("inputSandiJey");
const notifSandi = document.getElementById("notifSandi");

if (inputSandi && notifSandi) {
    inputSandi.addEventListener("input", function (e) {
        let jumlahKarakter = e.target.value.length;
        if (jumlahKarakter === 0) {
            notifSandi.innerText = "";
        } else if (jumlahKarakter < 6) {
            notifSandi.innerText = "⚠️ Sandi terlalu pendek (minimal 6 karakter ya)";
            notifSandi.style.color = "#dc2626";
        } else {
            notifSandi.innerText = "✅ Sip, kekuatan sandi sudah aman!";
            notifSandi.style.color = "#059669";
        }
    });
}

// Event 3 & 4: focus & blur (Focus Event) -> Efek interaktif warna border input nama
const inputNama = document.getElementById("inputNamaJey");
if (inputNama) {
    inputNama.addEventListener("focus", function () {
        this.style.border = "2px solid #4f46e5";
        this.style.backgroundColor = "#faf5ff";
    });
    inputNama.addEventListener("blur", function () {
        this.style.border = "1px solid #cbd5e1";
        this.style.backgroundColor = "#ffffff";
    });
}

// Event 5: submit (Form Event) -> Proses simpan form pake Async/Await + Confirm & Alert PopUp Boxes
const formProfilJey = document.getElementById("formProfilJey");
if (formProfilJey) {
    formProfilJey.addEventListener("submit", async function (e) {
        e.preventDefault(); // Cegah halaman reload otomatis

        // PopUp Box 1: Confirm Box -> Tanya user sebelum data disimpan
        let yakinSimpan = confirm("Yakin mau simpan perubahan data profil ini?");
        if (!yakinSimpan) return;

        let dataBaru = {
            nama: document.getElementById("inputNamaJey").value,
            email: document.getElementById("inputEmailJey").value
        };

        const btnSimpan = document.getElementById("btnSimpanPerubahan");

        try {
            if (btnSimpan) btnSimpan.innerText = "Sedang Memproses...";
            
            // Panggil fungsi Asynchronous & Promise
            let pesanBerhasil = await simpanDataAsync(dataBaru);

            // Simpan permanen ke Web Storage (LocalStorage)
            localStorage.setItem(KUNCI_NAMA, dataBaru.nama);
            localStorage.setItem(KUNCI_EMAIL, dataBaru.email);
            await kirimKeServer(dataBaru.nama, dataBaru.email);   // [PHP] sinkron ke session

            // PopUp Box 2: Alert Box -> Info sukses
            alert(pesanBerhasil);
            muatDataProfilJey();
            formEditContainer.style.display = "none";
        } catch (pesanError) {
            alert(pesanError); // PopUp Alert kalau gagal
        } finally {
            if (btnSimpan) btnSimpan.innerText = "Simpan Perubahan";
        }
    });
}

// PopUp Box 3: Prompt Box -> Fitur ubah nama cepat lewat kotak dialog prompt
const btnEditPrompt = document.getElementById("btnEditPrompt");
if (btnEditPrompt) {
    btnEditPrompt.addEventListener("click", function () {
        let namaLama = localStorage.getItem(KUNCI_NAMA) || "";
        let inputPromptBaru = prompt("Masukkan nama lengkap baru kamu:", namaLama);

        if (inputPromptBaru !== null && inputPromptBaru.trim() !== "") {
            localStorage.setItem(KUNCI_NAMA, inputPromptBaru);
            kirimKeServer(inputPromptBaru);   // [PHP] sinkron ke session
            const inputNamaJey = document.getElementById("inputNamaJey");
            if (inputNamaJey) inputNamaJey.value = inputPromptBaru;
            alert(`Berhasil ubah nama jadi: ${inputPromptBaru}`);
            muatDataProfilJey();
        }
    });
}

// Tombol buat bersihin Web Storage
const btnResetStorage = document.getElementById("btnResetStorage");
if (btnResetStorage) {
    btnResetStorage.addEventListener("click", function () {
        if (confirm("Mau hapus semua data dari Web Storage browser?")) {
            localStorage.removeItem(KUNCI_NAMA);
            localStorage.removeItem(KUNCI_EMAIL);
            alert("Web Storage sudah dibersihkan!");
            muatDataProfilJey();
        }
    });
}
