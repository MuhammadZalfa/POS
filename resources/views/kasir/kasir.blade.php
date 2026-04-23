<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>KASIR - POS Cilok</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <style>
        * { box-sizing: border-box; }
        body {
            margin: 0;
            font-family: 'Inter', sans-serif;
            background: #f3f4f6;
            color: #111827;
        }
        .topbar {
            background: linear-gradient(90deg, #111827, #0f172a);
            color: #fff;
            padding: 16px 20px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 16px;
            position: sticky;
            top: 0;
            z-index: 20;
        }
        .brand {
            display: flex;
            align-items: center;
            gap: 12px;
        }
        .brand-icon {
            width: 42px;
            height: 42px;
            border-radius: 14px;
            background: linear-gradient(135deg, #f97316, #ea580c);
            transform: rotate(6deg);
            box-shadow: 0 10px 18px rgba(249, 115, 22, 0.35);
        }
        .brand-title {
            font-size: 20px;
            line-height: 1;
            font-weight: 800;
            margin: 0;
        }
        .brand-subtitle {
            margin: 5px 0 0;
            font-size: 12px;
            color: #fb923c;
            font-weight: 700;
            letter-spacing: .04em;
        }
        .logout-btn {
            display: inline-flex;
            align-items: center;
            gap: 10px;
            background: rgba(255,255,255,0.06);
            border: 1px solid rgba(255,255,255,0.1);
            color: #e5e7eb;
            padding: 10px 16px;
            border-radius: 999px;
            font-weight: 700;
            cursor: pointer;
        }
        .app {
            display: grid;
            grid-template-columns: 1fr 380px;
            min-height: calc(100vh - 74px);
        }
        .menu-area {
            padding: 22px;
        }
        .menu-head {
            display: flex;
            justify-content: space-between;
            align-items: start;
            gap: 16px;
            margin-bottom: 18px;
        }
        .menu-title {
            margin: 0;
            font-size: 28px;
            font-weight: 800;
        }
        .menu-subtitle {
            margin: 6px 0 0;
            color: #6b7280;
            font-size: 14px;
        }
        .search-box {
            width: 320px;
            max-width: 100%;
        }
        .search-input {
            width: 100%;
            height: 46px;
            border-radius: 14px;
            border: 1px solid #e5e7eb;
            background: #fff;
            padding: 0 14px;
            font: inherit;
            outline: none;
        }
        .search-input:focus {
            border-color: #fb923c;
            box-shadow: 0 0 0 4px rgba(251, 146, 60, 0.12);
        }
        .menu-grid {
            display: grid;
            grid-template-columns: repeat(3, minmax(0, 1fr));
            gap: 16px;
        }
        .menu-card {
            background: #fff;
            border: 1px solid #e5e7eb;
            border-radius: 20px;
            padding: 18px;
            cursor: pointer;
            transition: .15s ease;
            display: flex;
            flex-direction: column;
            min-height: 166px;
        }
        .menu-card:hover {
            transform: translateY(-2px);
            border-color: #fdba74;
            box-shadow: 0 14px 26px rgba(0,0,0,0.06);
        }
        .menu-card.disabled {
            opacity: .55;
            cursor: not-allowed;
            background: #f9fafb;
        }
        .menu-category {
            font-size: 11px;
            text-transform: uppercase;
            letter-spacing: .08em;
            color: #6b7280;
            font-weight: 800;
            margin-bottom: 8px;
        }
        .menu-name {
            font-size: 18px;
            font-weight: 700;
            line-height: 1.35;
            margin: 0;
        }
        .menu-description {
            margin: 8px 0 0;
            font-size: 13px;
            color: #6b7280;
            line-height: 1.45;
        }
        .menu-footer {
            margin-top: auto;
            display: flex;
            align-items: end;
            justify-content: space-between;
            gap: 12px;
            padding-top: 18px;
        }
        .menu-price {
            font-size: 20px;
            color: #ea580c;
            font-weight: 800;
        }
        .menu-stock {
            font-size: 12px;
            font-weight: 700;
            color: #6b7280;
        }
        .menu-stock.low { color: #d97706; }
        .menu-stock.empty { color: #dc2626; }
        .cart {
            background: #ffffff;
            border-left: 1px solid #e5e7eb;
            display: flex;
            flex-direction: column;
        }
        .cart-head {
            padding: 18px 20px;
            border-bottom: 1px solid #e5e7eb;
        }
        .cart-title { margin: 0; font-size: 20px; font-weight: 800; }
        .cart-subtitle { margin: 6px 0 0; font-size: 13px; color: #6b7280; }
        .cart-body {
            flex: 1;
            overflow-y: auto;
            padding: 18px 16px;
        }
        .cart-empty {
            border: 1px dashed #d1d5db;
            border-radius: 20px;
            padding: 32px 20px;
            text-align: center;
            color: #6b7280;
            background: #f9fafb;
        }
        .cart-item {
            border: 1px solid #e5e7eb;
            border-radius: 18px;
            padding: 14px;
            margin-bottom: 12px;
            background: #fff;
        }
        .cart-item-top {
            display: flex;
            justify-content: space-between;
            gap: 10px;
            align-items: start;
        }
        .cart-item-name {
            margin: 0;
            font-size: 14px;
            font-weight: 700;
        }
        .cart-item-meta {
            margin: 4px 0 0;
            font-size: 12px;
            color: #6b7280;
        }
        .cart-item-subtotal {
            font-size: 14px;
            font-weight: 800;
            white-space: nowrap;
        }
        .cart-actions {
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-top: 12px;
            gap: 12px;
        }
        .qty-box {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            background: #f3f4f6;
            border-radius: 12px;
            padding: 4px;
        }
        .qty-box button {
            width: 30px;
            height: 30px;
            border: 0;
            border-radius: 9px;
            background: #fff;
            cursor: pointer;
            font-size: 18px;
            font-weight: 800;
        }
        .qty-box span {
            min-width: 20px;
            text-align: center;
            font-size: 13px;
            font-weight: 800;
        }
        .remove-btn {
            border: 0;
            background: #fff1f2;
            color: #e11d48;
            font-weight: 700;
            border-radius: 10px;
            padding: 8px 10px;
            cursor: pointer;
            font-size: 12px;
        }
        .cart-footer {
            border-top: 1px solid #e5e7eb;
            padding: 18px 20px 20px;
            background: #fff;
        }
        .summary-box {
            border: 1px solid #fed7aa;
            border-radius: 18px;
            background: #fff7ed;
            padding: 16px;
        }
        .summary-label { margin: 0 0 8px; color: #6b7280; font-size: 13px; }
        .summary-total { margin: 0; font-size: 30px; font-weight: 800; color: #ea580c; }
        .payment-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 12px;
            margin-top: 16px;
        }
        .payment-btn {
            height: 56px;
            border-radius: 16px;
            border: 1px solid #e5e7eb;
            background: #fff;
            cursor: pointer;
            font-weight: 800;
            color: #4b5563;
        }
        .payment-btn.active {
            background: #fff7ed;
            border-color: #fb923c;
            color: #ea580c;
        }
        .field-label {
            display: block;
            font-size: 12px;
            font-weight: 700;
            color: #6b7280;
            margin: 14px 0 8px;
            text-transform: uppercase;
        }
        .field-input {
            width: 100%;
            height: 46px;
            border-radius: 14px;
            border: 1px solid #e5e7eb;
            padding: 0 14px;
            font: inherit;
            outline: none;
            background: #fff;
        }
        .field-input:focus {
            border-color: #fb923c;
            box-shadow: 0 0 0 4px rgba(251, 146, 60, 0.12);
        }
        .change-box {
            margin-top: 12px;
            border-radius: 16px;
            border: 1px solid #d1fae5;
            background: #ecfdf5;
            padding: 14px;
        }
        .change-title { margin: 0; font-size: 12px; color: #047857; font-weight: 700; text-transform: uppercase; }
        .change-value { margin: 8px 0 0; font-size: 24px; font-weight: 800; color: #059669; }
        .change-note { margin: 4px 0 0; font-size: 12px; color: #065f46; }
        .action-btn {
            width: 100%;
            height: 56px;
            border: 0;
            border-radius: 16px;
            font-size: 15px;
            font-weight: 800;
            cursor: pointer;
            margin-top: 14px;
        }
        .btn-primary { background: linear-gradient(90deg, #f97316, #ea580c); color: #fff; }
        .btn-secondary { background: #fff7ed; color: #d97706; border: 1px solid #fed7aa; }
        .message-box {
            margin-top: 14px;
            border-radius: 16px;
            padding: 14px;
            font-size: 13px;
            display: none;
        }
        .message-box.show { display: block; }
        .message-success { background: #ecfdf5; border: 1px solid #a7f3d0; color: #065f46; }
        .message-error { background: #fef2f2; border: 1px solid #fecaca; color: #991b1b; }
        @media (max-width: 1200px) {
            .menu-grid { grid-template-columns: repeat(2, minmax(0, 1fr)); }
        }
        @media (max-width: 900px) {
            .app { grid-template-columns: 1fr; }
            .cart { border-left: 0; border-top: 1px solid #e5e7eb; }
        }
        @media (max-width: 640px) {
            .menu-grid { grid-template-columns: 1fr; }
            .menu-head { flex-direction: column; }
            .search-box { width: 100%; }
        }
        .modal-backdrop {
        position: fixed;
        inset: 0;
        background: rgba(15, 23, 42, 0.55);
        display: none;
        align-items: center;
        justify-content: center;
        z-index: 999;
        padding: 20px;
    }
    .modal-backdrop.show {
        display: flex;
    }
    .modal-card {
        width: 100%;
        max-width: 560px;
        background: #fff;
        border-radius: 24px;
        box-shadow: 0 24px 60px rgba(0,0,0,0.22);
        overflow: hidden;
    }
    .modal-header {
        padding: 18px 22px;
        border-bottom: 1px solid #e5e7eb;
    }
    .modal-title {
        margin: 0;
        font-size: 22px;
        font-weight: 800;
        color: #111827;
    }
    .modal-subtitle {
        margin: 6px 0 0;
        font-size: 13px;
        color: #6b7280;
    }
    .modal-body {
        padding: 20px 22px;
        max-height: 60vh;
        overflow-y: auto;
    }
    .confirm-list {
        display: flex;
        flex-direction: column;
        gap: 12px;
        margin-bottom: 18px;
    }
    .confirm-item {
        border: 1px solid #e5e7eb;
        border-radius: 16px;
        padding: 14px;
        background: #f9fafb;
    }
    .confirm-item-top {
        display: flex;
        justify-content: space-between;
        gap: 12px;
        margin-bottom: 6px;
    }
    .confirm-item-name {
        margin: 0;
        font-size: 14px;
        font-weight: 700;
        color: #111827;
    }
    .confirm-item-meta {
        margin: 0;
        font-size: 12px;
        color: #6b7280;
    }
    .confirm-item-subtotal {
        font-size: 14px;
        font-weight: 800;
        color: #ea580c;
        white-space: nowrap;
    }
    .confirm-summary {
        border: 1px solid #fed7aa;
        background: #fff7ed;
        border-radius: 18px;
        padding: 16px;
    }
    .confirm-row {
        display: flex;
        justify-content: space-between;
        gap: 12px;
        font-size: 14px;
        margin-bottom: 10px;
        color: #374151;
    }
    .confirm-row:last-child {
        margin-bottom: 0;
    }
    .confirm-row.total {
        font-size: 16px;
        font-weight: 800;
        color: #111827;
        padding-top: 10px;
        border-top: 1px solid #fdba74;
    }
    .modal-footer {
        padding: 18px 22px;
        border-top: 1px solid #e5e7eb;
        display: flex;
        justify-content: end;
        gap: 12px;
    }
    .modal-btn {
        min-width: 130px;
        height: 48px;
        border-radius: 14px;
        border: 0;
        font-weight: 800;
        cursor: pointer;
        font-size: 14px;
    }
    .modal-btn-cancel {
        background: #f3f4f6;
        color: #374151;
    }
    .modal-btn-confirm {
        background: linear-gradient(90deg, #f97316, #ea580c);
        color: #fff;
    }
    .toast-notification {
        position: fixed;
        top: 20px;
        right: 20px;
        min-width: 320px;
        max-width: 420px;
        background: #ecfdf5;
        border: 1px solid #a7f3d0;
        color: #065f46;
        padding: 16px 18px;
        border-radius: 18px;
        box-shadow: 0 18px 40px rgba(0,0,0,0.16);
        z-index: 1000;
        display: none;
    }
    .toast-notification.show {
        display: block;
        animation: fadeInUp .2s ease;
    }
    .toast-title {
        margin: 0 0 6px;
        font-size: 15px;
        font-weight: 800;
    }
    .toast-text {
        margin: 0;
        font-size: 13px;
        line-height: 1.5;
    }
    @keyframes fadeInUp {
        from {
            opacity: 0;
            transform: translateY(8px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }
    </style>
</head>
<body>
@php
    $menuJson = $menu->values();
@endphp
<div class="topbar">
    <div class="brand">
        <div class="brand-icon"></div>
        <div>
            <p class="brand-title">KASIR</p>
            <p class="brand-subtitle">POS Cilok</p>
        </div>
    </div>

    @auth
        @if(auth()->user()->role == 'admin')
            <form action="{{ route('admin.auth.logoutAdmin') }}" method="POST">
        @else
            <form action="{{ route('logout') }}" method="POST">
        @endif
            @csrf
            <button type="submit" class="logout-btn">Keluar</button>
        </form>
    @endauth
</div>

<div class="app" id="kasirApp" data-menu='@json($menuJson)'>
    <section class="menu-area">
        <div class="menu-head">
            <div>
                <h1 class="menu-title">Menu Penjualan</h1>
                <p class="menu-subtitle">Menu berasal dari tabel produk. Stok dihitung dari resep dan inventori.</p>
            </div>
            <div class="search-box">
                <input type="text" id="searchInput" class="search-input" placeholder="Cari menu...">
            </div>
        </div>

        <div class="menu-grid" id="menuGrid"></div>
    </section>

    <aside class="cart">
        <div class="cart-head">
            <h2 class="cart-title">Pesanan</h2>
            <p class="cart-subtitle"><span id="orderCount">0</span> item di keranjang</p>
        </div>

        <div class="cart-body" id="cartBody"></div>

        <div class="cart-footer">
            <div class="summary-box">
                <p class="summary-label">Total Pembayaran</p>
                <p class="summary-total" id="grandTotal">Rp 0</p>
            </div>

            <div class="payment-grid">
                <button type="button" class="payment-btn" data-method="tunai">Tunai</button>
                <button type="button" class="payment-btn" data-method="qris">QRIS</button>
            </div>

            <div id="tunaiFields" style="display:none;">
                <label class="field-label" for="cashInput">Uang Tunai</label>
                <input type="text" id="cashInput" class="field-input" inputmode="numeric" placeholder="Masukkan uang yang dibayar">
                <div class="change-box">
                    <p class="change-title">Kembalian</p>
                    <p class="change-value" id="changeValue">Rp 0</p>
                    <p class="change-note" id="changeNote">Masukkan nominal tunai terlebih dulu.</p>
                </div>
            </div>

            <button type="button" class="action-btn btn-secondary" id="resetBtn">Reset Pesanan</button>
            <button type="button" class="action-btn btn-primary" id="payBtn">Bayar Sekarang</button>

            <div id="messageBox" class="message-box"></div>
        </div>
    </aside>
</div>
<div id="confirmModal" class="modal-backdrop">
    <div class="modal-card">
        <div class="modal-header">
            <h3 class="modal-title">Konfirmasi Transaksi</h3>
            <p class="modal-subtitle">Periksa detail transaksi sebelum diproses.</p>
        </div>

        <div class="modal-body">
            <div id="confirmItems" class="confirm-list"></div>

            <div class="confirm-summary">
                <div class="confirm-row">
                    <span>Metode Pembayaran</span>
                    <strong id="confirmMethod">-</strong>
                </div>
                <div class="confirm-row">
                    <span>Total Item</span>
                    <strong id="confirmQty">0</strong>
                </div>
                <div class="confirm-row">
                    <span>Total Bayar</span>
                    <strong id="confirmTotal">Rp 0</strong>
                </div>
                <div class="confirm-row">
                    <span>Uang Diterima</span>
                    <strong id="confirmPaid">Rp 0</strong>
                </div>
                <div class="confirm-row total">
                    <span>Kembalian</span>
                    <strong id="confirmChange">Rp 0</strong>
                </div>
            </div>
        </div>

        <div class="modal-footer">
            <button type="button" class="modal-btn modal-btn-cancel" id="cancelConfirmBtn">Batal</button>
            <button type="button" class="modal-btn modal-btn-confirm" id="confirmPayBtn">Ya, Proses</button>
        </div>
    </div>
</div>

<div id="toastNotification" class="toast-notification">
    <p class="toast-title" id="toastTitle">Berhasil</p>
    <p class="toast-text" id="toastText"></p>
</div>
<script>
(function () {
    const root = document.getElementById('kasirApp');
    const allMenu = JSON.parse(root.dataset.menu || '[]');
    const menuGrid = document.getElementById('menuGrid');
    const cartBody = document.getElementById('cartBody');
    const orderCount = document.getElementById('orderCount');
    const grandTotal = document.getElementById('grandTotal');
    const paymentButtons = document.querySelectorAll('.payment-btn');
    const tunaiFields = document.getElementById('tunaiFields');
    const cashInput = document.getElementById('cashInput');
    const changeValue = document.getElementById('changeValue');
    const changeNote = document.getElementById('changeNote');
    const searchInput = document.getElementById('searchInput');
    const payBtn = document.getElementById('payBtn');
    const resetBtn = document.getElementById('resetBtn');
    const messageBox = document.getElementById('messageBox');
    const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
    const confirmModal = document.getElementById('confirmModal');
    const confirmItems = document.getElementById('confirmItems');
    const confirmMethod = document.getElementById('confirmMethod');
    const confirmQty = document.getElementById('confirmQty');
    const confirmTotal = document.getElementById('confirmTotal');
    const confirmPaid = document.getElementById('confirmPaid');
    const confirmChange = document.getElementById('confirmChange');
    const cancelConfirmBtn = document.getElementById('cancelConfirmBtn');
    const confirmPayBtn = document.getElementById('confirmPayBtn');

    const toastNotification = document.getElementById('toastNotification');
    const toastTitle = document.getElementById('toastTitle');
    const toastText = document.getElementById('toastText');

    let filteredMenu = [...allMenu];
    let cart = [];
    let paymentMethod = null;
    let isSubmitting = false;

    function formatRupiah(value) {
        return 'Rp ' + Number(value || 0).toLocaleString('id-ID');
    }

    function parseNumber(value) {
        const numeric = String(value || '').replace(/[^0-9]/g, '');
        return numeric ? Number(numeric) : 0;
    }

    function showMessage(type, text) {
        messageBox.className = 'message-box show ' + (type === 'success' ? 'message-success' : 'message-error');
        messageBox.textContent = text;
    }

    function clearMessage() {
        messageBox.className = 'message-box';
        messageBox.textContent = '';
    }

    function renderMenu() {
        if (filteredMenu.length === 0) {
            menuGrid.innerHTML = '<div style="grid-column:1/-1;" class="cart-empty">Menu tidak ditemukan.</div>';
            return;
        }

        menuGrid.innerHTML = filteredMenu.map(item => {
            const stockClass = item.available_qty <= 0 ? 'empty' : (item.available_qty <= 3 ? 'low' : '');
            const stockText = item.available_qty > 0 ? `Tersedia ${item.available_qty}` : 'Stok habis';

            return `
                <button type="button" class="menu-card ${item.available ? '' : 'disabled'}" data-id="${item.id}" ${item.available ? '' : 'disabled'}>
                    <div class="menu-category">${item.category}</div>
                    <p class="menu-name">${item.name}</p>
                    <p class="menu-description">${item.description ? item.description : 'Tidak ada deskripsi.'}</p>
                    <div class="menu-footer">
                        <div class="menu-price">${formatRupiah(item.price)}</div>
                        <div class="menu-stock ${stockClass}">${stockText}</div>
                    </div>
                </button>
            `;
        }).join('');

        menuGrid.querySelectorAll('.menu-card').forEach(button => {
            button.addEventListener('click', () => addToCart(Number(button.dataset.id)));
        });
    }

    function renderCart() {
        const totalQty = cart.reduce((sum, row) => sum + row.qty, 0);
        const total = cart.reduce((sum, row) => sum + (row.qty * row.price), 0);

        orderCount.textContent = totalQty;
        grandTotal.textContent = formatRupiah(total);

        if (cart.length === 0) {
            cartBody.innerHTML = '<div class="cart-empty">Belum ada pesanan.</div>';
        } else {
            cartBody.innerHTML = cart.map((row, index) => `
                <div class="cart-item">
                    <div class="cart-item-top">
                        <div>
                            <p class="cart-item-name">${row.name}</p>
                            <p class="cart-item-meta">${formatRupiah(row.price)} × ${row.qty}</p>
                        </div>
                        <div class="cart-item-subtotal">${formatRupiah(row.qty * row.price)}</div>
                    </div>
                    <div class="cart-actions">
                        <div class="qty-box">
                            <button type="button" data-action="minus" data-index="${index}">−</button>
                            <span>${row.qty}</span>
                            <button type="button" data-action="plus" data-index="${index}">+</button>
                        </div>
                        <button type="button" class="remove-btn" data-action="remove" data-index="${index}">Hapus</button>
                    </div>
                </div>
            `).join('');

            cartBody.querySelectorAll('[data-action]').forEach(button => {
                button.addEventListener('click', () => {
                    const index = Number(button.dataset.index);
                    const action = button.dataset.action;
                    const row = cart[index];
                    if (!row) return;

                    const menuItem = allMenu.find(item => item.id === row.id);
                    const maxQty = menuItem ? Number(menuItem.available_qty || 0) : 0;

                    if (action === 'plus') {
                        if (row.qty >= maxQty) {
                            showMessage('error', 'Jumlah pesanan melebihi stok yang tersedia.');
                            return;
                        }
                        row.qty += 1;
                    }

                    if (action === 'minus') {
                        if (row.qty > 1) {
                            row.qty -= 1;
                        } else {
                            cart.splice(index, 1);
                        }
                    }

                    if (action === 'remove') {
                        cart.splice(index, 1);
                    }

                    clearMessage();
                    renderCart();
                    updateChange();
                });
            });
        }

        updateChange();
    }

    function addToCart(productId) {
        clearMessage();
        const menuItem = allMenu.find(item => item.id === productId);
        if (!menuItem || !menuItem.available) {
            showMessage('error', 'Menu sedang tidak tersedia.');
            return;
        }

        const existing = cart.find(row => row.id === productId);
        if (existing) {
            if (existing.qty >= Number(menuItem.available_qty || 0)) {
                showMessage('error', 'Jumlah pesanan melebihi stok yang tersedia.');
                return;
            }
            existing.qty += 1;
        } else {
            cart.push({
                id: menuItem.id,
                name: menuItem.name,
                price: Number(menuItem.price),
                qty: 1,
            });
        }

        renderCart();
    }

    function updateChange() {
        if (paymentMethod !== 'tunai') {
            changeValue.textContent = formatRupiah(0);
            changeNote.textContent = 'Kembalian hanya muncul untuk pembayaran tunai.';
            return;
        }

        const total = cart.reduce((sum, row) => sum + (row.qty * row.price), 0);
        const paid = parseNumber(cashInput.value);

        if (!paid) {
            changeValue.textContent = formatRupiah(0);
            changeNote.textContent = 'Masukkan nominal tunai terlebih dulu.';
            return;
        }

        const change = paid - total;
        changeValue.textContent = formatRupiah(Math.max(change, 0));
        changeNote.textContent = change < 0
            ? 'Uang kurang ' + formatRupiah(Math.abs(change)) + '.'
            : 'Kembalian siap diberikan.';
    }

    function resetCart() {
        cart = [];
        paymentMethod = null;
        cashInput.value = '';
        paymentButtons.forEach(btn => btn.classList.remove('active'));
        tunaiFields.style.display = 'none';
        clearMessage();
        renderCart();
    }

    paymentButtons.forEach(button => {
        button.addEventListener('click', () => {
            paymentMethod = button.dataset.method;
            paymentButtons.forEach(btn => btn.classList.remove('active'));
            button.classList.add('active');
            tunaiFields.style.display = paymentMethod === 'tunai' ? 'block' : 'none';
            clearMessage();
            updateChange();
        });
    });

    cashInput.addEventListener('input', () => {
        const parsed = parseNumber(cashInput.value);
        cashInput.value = parsed ? parsed.toLocaleString('id-ID') : '';
        updateChange();
    });

    searchInput.addEventListener('input', () => {
        const keyword = searchInput.value.toLowerCase().trim();
        filteredMenu = allMenu.filter(item => {
            return item.name.toLowerCase().includes(keyword) || item.category.toLowerCase().includes(keyword);
        });
        renderMenu();
    });

    resetBtn.addEventListener('click', () => {
        if (cart.length === 0) {
            showMessage('error', 'Pesanan sudah kosong.');
            return;
        }

        if (!confirm('Yakin reset semua pesanan?')) {
            return;
        }

        resetCart();
    });

    function getCartTotal() {
    return cart.reduce((sum, row) => sum + (row.qty * row.price), 0);
    }

    function getCartQty() {
        return cart.reduce((sum, row) => sum + row.qty, 0);
    }

    function closeConfirmModal() {
        confirmModal.classList.remove('show');
    }

    function openConfirmModal() {
        const total = getCartTotal();
        const totalQty = getCartQty();
        const paid = paymentMethod === 'tunai' ? parseNumber(cashInput.value) : total;
        const change = Math.max(paid - total, 0);

        confirmItems.innerHTML = cart.map(row => `
            <div class="confirm-item">
                <div class="confirm-item-top">
                    <div>
                        <p class="confirm-item-name">${row.name}</p>
                        <p class="confirm-item-meta">${formatRupiah(row.price)} × ${row.qty}</p>
                    </div>
                    <div class="confirm-item-subtotal">${formatRupiah(row.qty * row.price)}</div>
                </div>
            </div>
        `).join('');

        confirmMethod.textContent = paymentMethod === 'tunai' ? 'Tunai' : 'QRIS';
        confirmQty.textContent = totalQty + ' item';
        confirmTotal.textContent = formatRupiah(total);
        confirmPaid.textContent = formatRupiah(paid);
        confirmChange.textContent = formatRupiah(change);

        confirmModal.classList.add('show');
    }

    function showToast(title, text) {
        toastTitle.textContent = title;
        toastText.textContent = text;
        toastNotification.classList.add('show');

        setTimeout(() => {
            toastNotification.classList.remove('show');
        }, 2500);
    }

    async function submitTransaction() {
        const total = getCartTotal();
        const paid = paymentMethod === 'tunai' ? parseNumber(cashInput.value) : total;

        isSubmitting = true;
        payBtn.textContent = 'Memproses...';
        confirmPayBtn.textContent = 'Memproses...';
        confirmPayBtn.disabled = true;
        cancelConfirmBtn.disabled = true;

        try {
            const response = await fetch("{{ route('kasir.transaksi.store') }}", {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'Accept': 'application/json',
                    'X-CSRF-TOKEN': csrfToken,
                },
                body: JSON.stringify({
                    metode_pembayaran: paymentMethod,
                    bayar: paid,
                    items: cart.map(row => ({
                        id_produk: row.id,
                        qty: row.qty,
                    })),
                }),
            });

            const data = await response.json();

            if (!response.ok) {
                const firstError = data.errors
                    ? Object.values(data.errors).flat()[0]
                    : (data.message || 'Transaksi gagal diproses.');
                throw new Error(firstError);
            }

            closeConfirmModal();
            showMessage('success', `Transaksi ${data.kode_transaksi} berhasil diproses.`);
            showToast(
                'Transaksi Berhasil',
                `${data.kode_transaksi} | Total ${formatRupiah(data.total)} | Kembalian ${formatRupiah(data.kembalian)}`
            );

            resetCart();

            setTimeout(() => {
                window.location.reload();
            }, 1500);
        } catch (error) {
            closeConfirmModal();
            showMessage('error', error.message || 'Terjadi kesalahan saat memproses transaksi.');
        } finally {
            isSubmitting = false;
            payBtn.textContent = 'Bayar Sekarang';
            confirmPayBtn.textContent = 'Ya, Proses';
            confirmPayBtn.disabled = false;
            cancelConfirmBtn.disabled = false;
        }
    }

    payBtn.addEventListener('click', () => {
        if (isSubmitting) return;
        clearMessage();

        if (cart.length === 0) {
            showMessage('error', 'Pesanan masih kosong.');
            return;
        }

        if (!paymentMethod) {
            showMessage('error', 'Pilih metode pembayaran dulu.');
            return;
        }

        const total = getCartTotal();
        const paid = paymentMethod === 'tunai' ? parseNumber(cashInput.value) : total;

        if (paymentMethod === 'tunai' && paid < total) {
            showMessage('error', 'Uang tunai tidak cukup.');
            return;
        }

        openConfirmModal();
    });
    cancelConfirmBtn.addEventListener('click', closeConfirmModal);

    confirmModal.addEventListener('click', (e) => {
        if (e.target === confirmModal) {
            closeConfirmModal();
        }
    });

    confirmPayBtn.addEventListener('click', () => {
        if (isSubmitting) return;
        submitTransaction();
    });

    renderMenu();
    renderCart();
})();
</script>
</body>
</html>
