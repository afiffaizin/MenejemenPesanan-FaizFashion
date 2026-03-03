document.addEventListener("DOMContentLoaded", function () {
    const modalEl = document.getElementById("modalTambahPesanan");

    if (modalEl) {
        // Initialize when modal is shown
        modalEl.addEventListener("show.bs.modal", function () {
            setTimeout(function () {
                initializeSelect2();
                setupEventListeners();
            }, 100);
        });
    }
});

function initializeSelect2() {
    // Check if Select2 is available
    if (
        typeof jQuery === "undefined" ||
        typeof jQuery.fn.select2 === "undefined"
    ) {
        console.warn("Select2 is not loaded yet");
        return;
    }

    const element = $("#selectPelanggan");

    // Destroy existing Select2 instance if it exists
    if (element.data("select2")) {
        element.select2("destroy");
    }

    // Initialize Select2
    element.select2({
        theme: "bootstrap-5",
        width: "100%",
        placeholder: "-- Pilih Pelanggan --",
        allowClear: true,
        dropdownParent: $("#modalTambahPesanan"),
    });
}

function setupEventListeners() {
    // Load customer sizes when customer is selected
    $("#selectPelanggan").on("change", function () {
        const customerId = $(this).val();
        if (customerId) {
            loadCustomerSizes(customerId);
        } else {
            resetSizeDisplay();
        }
    });

    // Toggle between existing and new customer sections
    $('input[name="customerType"]').on("change", function () {
        toggleCustomerType();
    });

    // Toggle between atasan and bawahan measurements
    $('input[name="nameCategory"]').on("change", function () {
        toggleMeasurementInputs();
    });
}

/**
 * Load customer sizes via AJAX
 * @param {number} customerId - The customer ID
 */
function loadCustomerSizes(customerId) {
    const loadingEl = document.getElementById("loadingSizeExisting");
    const displayEl = document.getElementById("displaySizeExisting");
    const errorEl = document.getElementById("errorSizeExisting");
    const contentEl = document.getElementById("textUkuranExisting");

    // Show loading state
    loadingEl.classList.remove("d-none");
    displayEl.classList.add("d-none");
    errorEl.classList.add("d-none");

    // Fetch data from server
    fetch(`/customers/${customerId}/sizes`)
        .then((response) => {
            if (!response.ok) {
                throw new Error(`HTTP error! status: ${response.status}`);
            }
            return response.json();
        })
        .then((data) => {
            loadingEl.classList.add("d-none");

            if (!data.success) {
                // Show error message
                showErrorMessage(data.message || "Gagal mengambil data ukuran");
                return;
            }

            // Display the sizes
            displaySizes(data.sizes);
        })
        .catch((error) => {
            console.error("Error loading customer sizes:", error);
            loadingEl.classList.add("d-none");
            showErrorMessage(
                "Terjadi kesalahan saat mengambil data. Silakan coba lagi.",
            );
        });
}

/**
 * Display customer sizes in a formatted manner
 * @param {Array} sizes - Array of size objects
 */
function displaySizes(sizes) {
    const displayEl = document.getElementById("displaySizeExisting");
    const contentEl = document.getElementById("textUkuranExisting");

    if (!sizes || sizes.length === 0) {
        showErrorMessage("Belum ada data ukuran untuk pelanggan ini");
        return;
    }

    let htmlContent = "";

    sizes.forEach((size, index) => {
        const category = size.category?.nameCategory ?? "-";
        const categoryLabel = category === "atasan" ? "Atasan" : "Bawahan";

        htmlContent += `<div class="size-item ${index > 0 ? "mt-4" : ""}">`;
        htmlContent += `<h6 class="text-primary mb-2"><i class="bi bi-tag me-1"></i>Kategori: ${categoryLabel}</h6>`;
        htmlContent += '<ul class="list-unstyled small">';

        if (category === "atasan") {
            htmlContent += `<li class="mb-1"><strong>Panjang Baju:</strong> ${size.panjang ?? "-"} cm</li>`;
            htmlContent += `<li class="mb-1"><strong>Lingkar Badan:</strong> ${size.lingkar_badan ?? "-"} cm</li>`;
            htmlContent += `<li class="mb-1"><strong>Lingkar Pinggang:</strong> ${size.lingkar_pinggang ?? "-"} cm</li>`;
            htmlContent += `<li class="mb-1"><strong>Lebar Punggung:</strong> ${size.punggung ?? "-"} cm</li>`;
            htmlContent += `<li class="mb-1"><strong>Panjang Lengan:</strong> ${size.panjang_lengan ?? "-"} cm</li>`;
        } else if (category === "bawahan") {
            htmlContent += `<li class="mb-1"><strong>Panjang:</strong> ${size.panjang_pinggang ?? "-"} cm</li>`;
            htmlContent += `<li class="mb-1"><strong>Lingkar Pinggul:</strong> ${size.pinggul ?? "-"} cm</li>`;
            htmlContent += `<li class="mb-1"><strong>Pisak (Crotch):</strong> ${size.pisak ?? "-"} cm</li>`;
            htmlContent += `<li class="mb-1"><strong>Pangkal Paha:</strong> ${size.pangkal_paha ?? "-"} cm</li>`;
        }

        htmlContent += "</ul>";
        htmlContent += "</div>";
    });

    contentEl.innerHTML = htmlContent;
    displayEl.classList.remove("d-none");
}

/**
 * Show error message
 * @param {string} message - Error message to display
 */
function showErrorMessage(message) {
    const errorEl = document.getElementById("errorSizeExisting");
    const messageEl = document.getElementById("errorMessage");
    const displayEl = document.getElementById("displaySizeExisting");

    messageEl.textContent = message;
    errorEl.classList.remove("d-none");
    displayEl.classList.add("d-none");
}

/**
 * Reset size display when no customer is selected
 */
function resetSizeDisplay() {
    document.getElementById("displaySizeExisting").classList.add("d-none");
    document.getElementById("errorSizeExisting").classList.add("d-none");
    document.getElementById("loadingSizeExisting").classList.add("d-none");
}

/**
 * Toggle between existing and new customer sections
 */
function toggleCustomerType() {
    const isExisting = document.getElementById("typeExisting").checked;
    const secExisting = document.getElementById("sectionExisting");
    const secNew = document.getElementById("sectionNew");

    if (isExisting) {
        secExisting.classList.remove("d-none");
        secNew.classList.add("d-none");
        resetSizeDisplay();
    } else {
        secExisting.classList.add("d-none");
        secNew.classList.remove("d-none");
    }
}

/**
 * Toggle between atasan and bawahan measurement inputs
 */
function toggleMeasurementInputs() {
    const isAtasan = document.getElementById("catAtasan").checked;
    const divAtasan = document.getElementById("inputAtasan");
    const divBawahan = document.getElementById("inputBawahan");

    if (isAtasan) {
        divAtasan.classList.remove("d-none");
        divBawahan.classList.add("d-none");
    } else {
        divAtasan.classList.add("d-none");
        divBawahan.classList.remove("d-none");
    }
}
