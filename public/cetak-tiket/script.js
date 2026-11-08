// ===== Upload foto (drag & drop + klik) =====
const dropzone = document.getElementById("dropzone");
const fileInput = document.getElementById("foto");
const dzTitle = document.getElementById("dzTitle");
const dzHint = document.getElementById("dzHint");

const DEFAULT_TITLE = dzTitle.textContent;
const DEFAULT_HINT = dzHint.textContent;
const MAX_SIZE = 5 * 1024 * 1024;
const ALLOWED = ["image/jpeg", "image/png"];

function handleFile(file) {
  if (!file) return;
  if (!ALLOWED.includes(file.type)) {
    dzTitle.textContent = "Format file tidak didukung";
    dzHint.textContent = "Gunakan JPG atau PNG";
    fileInput.value = "";
    return;
  }
  if (file.size > MAX_SIZE) {
    dzTitle.textContent = "Ukuran file terlalu besar";
    dzHint.textContent = "Maksimal 5 MB";
    fileInput.value = "";
    return;
  }
  dzTitle.textContent = file.name;
  dzHint.textContent = (file.size / 1024 / 1024).toFixed(2) + " MB";
}

fileInput.addEventListener("change", () => handleFile(fileInput.files[0]));

["dragenter", "dragover"].forEach((evt) =>
  dropzone.addEventListener(evt, (e) => { e.preventDefault(); dropzone.classList.add("drag"); })
);
["dragleave", "drop"].forEach((evt) =>
  dropzone.addEventListener(evt, (e) => { e.preventDefault(); dropzone.classList.remove("drag"); })
);
dropzone.addEventListener("drop", (e) => {
  const file = e.dataTransfer.files[0];
  if (file) {
    const dt = new DataTransfer();
    dt.items.add(file);
    fileInput.files = dt.files;
    handleFile(file);
  }
});

// ===== Submit & Batal =====
const form = document.getElementById("ticketForm");

form.addEventListener("submit", (e) => {
  e.preventDefault();
  const required = form.querySelectorAll("[required]");
  for (const el of required) {
    if (!el.value.trim()) {
      el.focus();
      return;
    }
  }
  const data = {
    perangkat: form.perangkat.value,
    kategori: form.kategori.value,
    judul: form.judul.value,
    deskripsi: form.deskripsi.value,
    urgensi: form.urgensi.value,
    foto: fileInput.files[0]?.name ?? null,
  };
  console.log("Tiket dikirim:", data); // TODO: ganti dengan request ke backend
  alert("Tiket berhasil dikirim!");
  form.reset();
  dzTitle.textContent = DEFAULT_TITLE;
  dzHint.textContent = DEFAULT_HINT;
});

document.getElementById("btnBatal").addEventListener("click", () => {
  form.reset();
  dzTitle.textContent = DEFAULT_TITLE;
  dzHint.textContent = DEFAULT_HINT;
});
