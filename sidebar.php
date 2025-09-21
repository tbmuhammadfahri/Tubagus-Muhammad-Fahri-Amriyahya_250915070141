<div class="sidebar">
    <h2>KOPERASI FAHRI</h2>
    <a href="dashboard_petugas.php">Dashboard</a>

    <!-- Master Data Dropdown -->
    <button class="dropdown-btn">Master Data ▼</button>
    <div class="dropdown-container">
        <a href="user_index.php">User Account</a>
        <a href="identitas_index.php">Identitas</a>
        <a href="customer_index.php">Customer</a>
        <a href="item_index.php">Item</a>
    </div>

    <!-- Transaksi Dropdown -->
    <button class="dropdown-btn">Transaksi ▼</button>
    <div class="dropdown-container">
        <a href="sales_index.php">Sales</a>
        <a href="transaction_index.php">Transaksi</a>
    </div>

    <!-- Laporan -->
    <button class="dropdown-btn">Laporan ▼</button>
    <div class="dropdown-container">
        <a href="laporan_transaksi.php">Laporan Sales</a>
        <a href="laporan_customer.php">Laporan Customer</a>
        <a href="laporan_item.php">Laporan Item</a>
    </div>

    <!-- Logout -->
    <a href="logout.php" style="background:#dc3545;">Logout</a>
</div>

<style>
    .sidebar {
        width: 220px;
        background: #343a40;
        height: 100vh;
        color: white;
        padding-top: 20px;
        position: fixed;
        left: 0;
        top: 0;
        overflow-y: auto;
    }
    .sidebar h2 {
        text-align: center;
        font-size: 18px;
        margin-bottom: 20px;
        border-bottom: 1px solid #555;
        padding-bottom: 10px;
    }
    .sidebar a, .dropdown-btn {
        padding: 12px 20px;
        text-decoration: none;
        color: white;
        display: block;
        border: none;
        background: none;
        width: 100%;
        text-align: left;
        cursor: pointer;
        outline: none;
        transition: background 0.3s;
    }
    .sidebar a:hover, .dropdown-btn:hover {
        background: #495057;
    }
    .dropdown-container {
        display: none;
        background: #495057;
        padding-left: 15px;
    }
    .dropdown-container a {
        font-size: 14px;
        padding: 10px 20px;
    }
    .active {
        background: #007bff !important;
    }
</style>

<script>
    // Script untuk toggle dropdown
    var dropdown = document.getElementsByClassName("dropdown-btn");
    for (var i = 0; i < dropdown.length; i++) {
        dropdown[i].addEventListener("click", function() {
            this.classList.toggle("active");
            var container = this.nextElementSibling;
            if (container.style.display === "block") {
                container.style.display = "none";
            } else {
                container.style.display = "block";
            }
        });
    }
</script>
