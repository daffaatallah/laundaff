
// ===================================
// SISTEM INFORMASI MANAJEMEN LAUNDRY
// ===================================

// DATA AWAL
let services = JSON.parse(localStorage.getItem("services")) || [
    { id: 1, name: "Reguler", time: "3 Hari", price: 5000 },
    { id: 2, name: "Ekspress", time: "1 Hari", price: 8000 },
    { id: 3, name: "Superkilat", time: "6 Jam", price: 12000 }
];

let transactions = JSON.parse(localStorage.getItem("transactions")) || [];

// SIMPAN DATA
function saveData() {
    localStorage.setItem("services", JSON.stringify(services));
    localStorage.setItem("transactions", JSON.stringify(transactions));
}

// ===================================
// LOGIN
// ===================================

const loginForm = document.getElementById("loginForm");

loginForm.addEventListener("submit", function(e) {
    e.preventDefault();

    const username = document.getElementById("username").value;
    const password = document.getElementById("password").value;
    const role = document.getElementById("role").value;

    if (
        (username === "admin" && password === "admin123" && role === "Admin") ||
        (username === "kasir" && password === "kasir123" && role === "Kasir")
    ) {
        document.getElementById("loginPage").hidden = true;
        document.getElementById("appPage").hidden = false;
        document.getElementById("sidebarUser").textContent = username + " (" + role + ")";

        showPage("dashboard");
        renderAll();
    } else {
        document.getElementById("loginError").textContent =
            "Username, password, atau role salah!";
    }
});

// LOGOUT
document.getElementById("logoutBtn").addEventListener("click", function() {
    document.getElementById("appPage").hidden = true;
    document.getElementById("loginPage").hidden = false;
    document.getElementById("loginForm").reset();
});

// ===================================
// NAVIGASI HALAMAN
// ===================================

document.querySelectorAll(".nav-link").forEach(function(link) {
    link.addEventListener("click", function(e) {
        e.preventDefault();

        const page = this.dataset.page;
        showPage(page);
    });
});

function showPage(page) {
    document.querySelectorAll(".page-content").forEach(function(section) {
        section.hidden = true;
    });

    const selectedPage = document.getElementById(page + "Page");

    if (selectedPage) {
        selectedPage.hidden = false;
    }

    document.querySelectorAll(".nav-link").forEach(function(link) {
        link.classList.remove("active");

        if (link.dataset.page === page) {
            link.classList.add("active");
        }
    });
}

// ===================================
// CRUD LAYANAN
// ===================================

const serviceModal = document.getElementById("serviceModal");
const serviceForm = document.getElementById("serviceForm");

document.getElementById("addServiceBtn").addEventListener("click", function() {
    serviceForm.reset();
    document.getElementById("editServiceId").value = "";
    document.getElementById("serviceModalTitle").textContent = "Tambah Layanan";
    serviceModal.hidden = false;
});

document.getElementById("cancelService").addEventListener("click", function() {
    serviceModal.hidden = true;
});

serviceForm.addEventListener("submit", function(e) {
    e.preventDefault();

    const id = document.getElementById("editServiceId").value;
    const name = document.getElementById("serviceName").value;
    const time = document.getElementById("serviceTime").value;
    const price = Number(document.getElementById("servicePrice").value);

    if (id) {
        const service = services.find(item => item.id === Number(id));

        if (service) {
            service.name = name;
            service.time = time;
            service.price = price;
        }
    } else {
        services.push({
            id: Date.now(),
            name: name,
            time: time,
            price: price
        });
    }

    saveData();
    serviceModal.hidden = true;
    renderAll();
});

function editService(id) {
    const service = services.find(item => item.id === id);

    if (!service) return;

    document.getElementById("editServiceId").value = service.id;
    document.getElementById("serviceName").value = service.name;
    document.getElementById("serviceTime").value = service.time;
    document.getElementById("servicePrice").value = service.price;

    document.getElementById("serviceModalTitle").textContent = "Edit Layanan";
    serviceModal.hidden = false;
}

function deleteService(id) {
    const used = transactions.some(item => item.serviceId === id);

    if (used) {
        alert("Layanan tidak bisa dihapus karena sudah digunakan dalam transaksi.");
        return;
    }

    if (confirm("Yakin ingin menghapus layanan ini?")) {
        services = services.filter(item => item.id !== id);
        saveData();
        renderAll();
    }
}

// TAMPILKAN LAYANAN
function renderServices() {
    const table = document.getElementById("serviceTable");

    table.innerHTML = "";

    if (services.length === 0) {
        table.innerHTML = `<tr><td colspan="5">Belum ada data layanan.</td></tr>`;
        return;
    }

    services.forEach(function(service, index) {
        table.innerHTML += `
            <tr>
                <td>${index + 1}</td>
                <td>${service.name}</td>
                <td>${service.time}</td>
                <td>Rp ${service.price.toLocaleString("id-ID")}</td>
                <td>
                    <button class="action-btn" onclick="editService(${service.id})">Edit</button>
                    <button class="action-btn" onclick="deleteService(${service.id})">Hapus</button>
                </td>
            </tr>
        `;
    });

    updateServiceOptions();
}

// ===================================
// TRANSAKSI LAUNDRY
// ===================================

const transactionModal = document.getElementById("transactionModal");
const transactionForm = document.getElementById("transactionForm");

document.getElementById("addTransactionBtn").addEventListener("click", function() {
    if (services.length === 0) {
        alert("Tambahkan layanan terlebih dahulu!");
        return;
    }

    transactionForm.reset();
    updateServiceOptions();
    transactionModal.hidden = false;
});

document.getElementById("cancelTransaction").addEventListener("click", function() {
    transactionModal.hidden = true;
});

function updateServiceOptions() {
    const select = document.getElementById("transactionService");

    select.innerHTML = `<option value="">Pilih Layanan</option>`;

    services.forEach(function(service) {
        select.innerHTML += `
            <option value="${service.id}">
                ${service.name} - Rp ${service.price.toLocaleString("id-ID")}
            </option>
        `;
    });
}

// SIMPAN TRANSAKSI
transactionForm.addEventListener("submit", function(e) {
    e.preventDefault();

    const customerName = document.getElementById("customerName").value;
    const customerPhone = document.getElementById("customerPhone").value;
    const serviceId = Number(document.getElementById("transactionService").value);
    const weight = Number(document.getElementById("weight").value);

    const service = services.find(item => item.id === serviceId);

    if (!service) {
        alert("Silakan pilih layanan!");
        return;
    }

    if (weight <= 0) {
        alert("Berat laundry harus lebih dari 0 kg!");
        return;
    }

    transactions.push({
        id: Date.now(),
        customerName: customerName,
        customerPhone: customerPhone,
        serviceId: serviceId,
        serviceName: service.name,
        weight: weight,
        total: service.price * weight,
        status: "Proses",
        date: new Date().toLocaleDateString("id-ID")
    });

    saveData();
    transactionModal.hidden = true;
    renderAll();
});

// ===================================
// STATUS TRANSAKSI
// ===================================

function finishTransaction(id) {
    const transaction = transactions.find(item => item.id === id);

    if (transaction) {
        transaction.status = "Selesai";
        saveData();
        renderAll();
    }
}

// ===================================
// TAMPILKAN TRANSAKSI
// ===================================

function renderTransactions() {
    const table = document.getElementById("transactionTable");

    const search = document.getElementById("searchTransaction").value.toLowerCase();
    const filter = document.getElementById("filterStatus").value;

    table.innerHTML = "";

    const filtered = transactions.filter(function(item) {
        const matchSearch =
            item.customerName.toLowerCase().includes(search) ||
            item.customerPhone.includes(search);

        const matchStatus = filter === "" || item.status === filter;

        return matchSearch && matchStatus;
    });

    if (filtered.length === 0) {
        table.innerHTML = `<tr><td colspan="8">Belum ada transaksi.</td></tr>`;
        return;
    }

    filtered.forEach(function(item, index) {
        table.innerHTML += `
            <tr>
                <td>${index + 1}</td>
                <td>${item.customerName}</td>
                <td>${item.customerPhone}</td>
                <td>${item.serviceName}</td>
                <td>${item.weight} kg</td>
                <td>Rp ${item.total.toLocaleString("id-ID")}</td>
                <td>
                    <span class="status ${item.status.toLowerCase()}">
                        ${item.status}
                    </span>
                </td>
                <td>
                    ${
                        item.status === "Proses"
                        ? `<button class="action-btn" onclick="finishTransaction(${item.id})">Selesai</button>`
                        : "Selesai"
                    }
                </td>
            </tr>
        `;
    });
}

// PENCARIAN DAN FILTER
document.getElementById("searchTransaction").addEventListener("input", renderTransactions);
document.getElementById("filterStatus").addEventListener("change", renderTransactions);

// ===================================
// DASHBOARD
// ===================================

function renderDashboard() {
    document.getElementById("totalTransaksi").textContent = transactions.length;
    document.getElementById("totalLayanan").textContent = services.length;

    document.getElementById("totalProses").textContent =
        transactions.filter(item => item.status === "Proses").length;

    document.getElementById("totalSelesai").textContent =
        transactions.filter(item => item.status === "Selesai").length;

    const table = document.getElementById("dashboardTable");

    table.innerHTML = "";

    const latest = [...transactions].reverse().slice(0, 5);

    if (latest.length === 0) {
        table.innerHTML = `<tr><td colspan="5">Belum ada transaksi.</td></tr>`;
        return;
    }

    latest.forEach(function(item, index) {
        table.innerHTML += `
            <tr>
                <td>${index + 1}</td>
                <td>${item.customerName}</td>
                <td>${item.serviceName}</td>
                <td>Rp ${item.total.toLocaleString("id-ID")}</td>
                <td>${item.status}</td>
            </tr>
        `;
    });
}

// ===================================
// JALANKAN SEMUA TAMPILAN
// ===================================

function renderAll() {
    renderServices();
    renderTransactions();
    renderDashboard();
}
