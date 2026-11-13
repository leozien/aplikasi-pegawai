document.addEventListener("DOMContentLoaded", function () {
    initFormValidation();
    initLiveSearch();
});

function initFormValidation() {
    const formPegawai = document.getElementById("formPegawai");

    if (!formPegawai) return;

    formPegawai.addEventListener("submit", function (e) {
        let isValid = true;

        const nipInput = document.getElementById("nip");
        const namaInput = document.getElementById("nama");
        const emailInput = document.getElementById("email");
        const jabatanInput = document.getElementById("jabatan");
        const noTeleponInput = document.getElementById("no_telepon");

        function setValidation(input, isFieldValid, message) {
            const feedbackEl = input.nextElementSibling;
            if (isFieldValid) {
                input.classList.remove("is-invalid");
                input.classList.add("is-valid");
            } else {
                input.classList.remove("is-valid");
                input.classList.add("is-invalid");
                if (feedbackEl && feedbackEl.classList.contains("invalid-feedback")) {
                    feedbackEl.textContent = message;
                }
                isValid = false;
            }
        }

        const nipVal = nipInput ? nipInput.value.trim() : "";
        if (nipVal === "") {
            setValidation(nipInput, false, "NIP wajib diisi.");
        } else if (!/^[0-9]+$/.test(nipVal)) {
            setValidation(nipInput, false, "NIP harus berupa angka.");
        } else if (nipVal.length < 5) {
            setValidation(nipInput, false, "NIP minimal 5 digit angka.");
        } else {
            setValidation(nipInput, true);
        }

        const namaVal = namaInput ? namaInput.value.trim() : "";
        if (namaVal === "") {
            setValidation(namaInput, false, "Nama lengkap wajib diisi.");
        } else if (namaVal.length < 3) {
            setValidation(namaInput, false, "Nama minimal 3 karakter.");
        } else {
            setValidation(namaInput, true);
        }

        const emailVal = emailInput ? emailInput.value.trim() : "";
        const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
        if (emailVal === "") {
            setValidation(emailInput, false, "Email wajib diisi.");
        } else if (!emailRegex.test(emailVal)) {
            setValidation(emailInput, false, "Format email tidak valid (contoh: leorendra.id@gmail.com).");
        } else {
            setValidation(emailInput, true);
        }

        const jabatanVal = jabatanInput ? jabatanInput.value.trim() : "";
        if (jabatanVal === "") {
            setValidation(jabatanInput, false, "Jabatan wajib diisi.");
        } else {
            setValidation(jabatanInput, true);
        }

        const noTelpVal = noTeleponInput ? noTeleponInput.value.trim() : "";
        const phoneRegex = /^[0-9+]{10,16}$/;
        if (noTelpVal === "") {
            setValidation(noTeleponInput, false, "Nomor telepon wajib diisi.");
        } else if (!phoneRegex.test(noTelpVal)) {
            setValidation(noTeleponInput, false, "Nomor telepon harus 10-16 angka (contoh: 081234567890).");
        } else {
            setValidation(noTeleponInput, true);
        }

        if (!isValid) {
            e.preventDefault();
            e.stopPropagation();
        }
    });
}

function confirmDelete(id, nama) {
    if (confirm(`Yakin ingin menghapus data pegawai: ${nama}?`)) {
        window.location.href = `proses/hapus.php?id=${encodeURIComponent(id)}`;
    }
}

function initLiveSearch() {
    const inputCari = document.getElementById("inputCari");
    const tabelBody = document.getElementById("tabelPegawaiBody");
    const btnResetCari = document.getElementById("btnResetCari");
    const loadingSpinner = document.getElementById("loadingSpinner");
    const badgeTotalHasil = document.getElementById("totalHasil");

    if (!inputCari || !tabelBody) return;

    let debounceTimer = null;

    function performSearch(keyword) {
        if (loadingSpinner) loadingSpinner.classList.remove("d-none");

        axios
            .get(`proses/cari.php?keyword=${encodeURIComponent(keyword)}`)
            .then(function (response) {
                renderTableData(response.data);
            })
            .catch(function () {
                tabelBody.innerHTML = `
                    <tr>
                        <td colspan="7" class="text-center py-4 text-danger">
                            <i class="bi bi-exclamation-circle me-1"></i> Gagal memuat data pencarian.
                        </td>
                    </tr>
                `;
            })
            .finally(function () {
                if (loadingSpinner) loadingSpinner.classList.add("d-none");
            });
    }

    function escapeHtml(text) {
        if (!text) return "";
        return String(text)
            .replace(/&/g, "&amp;")
            .replace(/</g, "&lt;")
            .replace(/>/g, "&gt;")
            .replace(/"/g, "&quot;")
            .replace(/'/g, "&#039;");
    }

    function renderTableData(pegawaiList) {
        if (!pegawaiList || pegawaiList.length === 0) {
            tabelBody.innerHTML = `
                <tr>
                    <td colspan="7" class="text-center py-4 text-muted">
                        <i class="bi bi-info-circle me-1"></i> Data pegawai tidak ditemukan.
                    </td>
                </tr>
            `;
            if (badgeTotalHasil) badgeTotalHasil.textContent = "0 pegawai ditemukan";
            return;
        }

        let html = "";
        pegawaiList.forEach((pegawai, index) => {
            const no = index + 1;
            const id = escapeHtml(pegawai.id);
            const nip = escapeHtml(pegawai.nip);
            const nama = escapeHtml(pegawai.nama);
            const email = escapeHtml(pegawai.email);
            const jabatan = escapeHtml(pegawai.jabatan);
            const noTelepon = escapeHtml(pegawai.no_telepon);

            html += `
                <tr>
                    <td class="text-center fw-semibold text-secondary">${no}</td>
                    <td><span class="badge bg-light text-dark border font-monospace">${nip}</span></td>
                    <td class="fw-semibold text-dark">${nama}</td>
                    <td><a href="mailto:${email}" class="text-decoration-none text-muted">${email}</a></td>
                    <td><span class="badge-jabatan">${jabatan}</span></td>
                    <td><span class="text-muted">${noTelepon}</span></td>
                    <td class="text-center">
                        <div class="btn-group" role="group">
                            <a href="detail.php?id=${id}" class="btn btn-sm btn-outline-dark btn-action" title="Detail">
                                <i class="bi bi-eye"></i>
                            </a>
                            <a href="edit.php?id=${id}" class="btn btn-sm btn-outline-dark btn-action" title="Edit">
                                <i class="bi bi-pencil"></i>
                            </a>
                            <button type="button" class="btn btn-sm btn-outline-danger btn-action" title="Hapus" 
                                onclick="confirmDelete('${id}', '${nama.replace(/'/g, "\\'")}')">
                                <i class="bi bi-trash"></i>
                            </button>
                        </div>
                    </td>
                </tr>
            `;
        });

        tabelBody.innerHTML = html;
        if (badgeTotalHasil) badgeTotalHasil.textContent = `${pegawaiList.length} pegawai ditemukan`;
    }

    inputCari.addEventListener("input", function () {
        const keyword = inputCari.value.trim();
        clearTimeout(debounceTimer);
        debounceTimer = setTimeout(function () {
            performSearch(keyword);
        }, 250);
    });

    if (btnResetCari) {
        btnResetCari.addEventListener("click", function () {
            inputCari.value = "";
            performSearch("");
            inputCari.focus();
        });
    }
}
