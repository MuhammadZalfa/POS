<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>KASIR - POS Cilok</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <style>
        * { box-sizing: border-box; }
        html, body {
            margin: 0;
            padding: 0;
            width: 100%;
            height: 100%;
            font-family: 'Inter', sans-serif;
            background: #ececec;
            overflow: hidden;
        }

        :root {
            --orange: #ff6a00;
            --orange-soft: #fff7ef;
            --border: #d9dde3;
            --text: #111827;
            --muted: #7d8897;
            --panel: #f1f1f1;
            --card: #f4f4f4;
            --danger: #dc2626;
            --success: #0f9d58;
        }

        .app {
            width: 100vw;
            height: 100vh;
            background: #ececec;
            display: flex;
            flex-direction: column;
        }

        .topbar {
            height: 77px;
            background: var(--orange);
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 0 22px;
            flex-shrink: 0;
        }

        .brand {
            display: flex;
            align-items: center;
            gap: 12px;
            color: #fff;
        }

        .brand-square,
        .topbar-action {
            width: 40px;
            height: 36px;
            border-radius: 10px;
            background: rgba(255,255,255,0.92);
            flex-shrink: 0;
        }

        .brand-title {
            margin: 0;
            font-size: 16px;
            line-height: 1.1;
            font-weight: 800;
            letter-spacing: 0.2px;
        }

        .brand-subtitle {
            margin: 3px 0 0;
            font-size: 12px;
            line-height: 1;
            font-weight: 500;
            color: rgba(255,255,255,0.95);
        }

        .content {
            flex: 1;
            min-height: 0;
            display: grid;
            grid-template-columns: 1fr 382px;
            overflow: hidden;
        }

        .menu-area {
            padding: 22px 24px 18px 22px;
            overflow-y: auto;
            background: #ececec;
            min-height: 0;
        }

        .menu-grid {
            display: grid;
            grid-template-columns: repeat(4, minmax(0, 1fr));
            gap: 16px;
        }

        .menu-card {
            min-height: 127px;
            background: var(--card);
            border: 2px solid var(--border);
            border-radius: 18px;
            padding: 20px 21px;
            cursor: pointer;
            transition: 0.15s ease;
            display: flex;
            flex-direction: column;
            justify-content: flex-start;
        }

        .menu-card:hover {
            border-color: #c8ced6;
            transform: translateY(-1px);
        }

        .menu-category {
            font-size: 12px;
            font-weight: 700;
            letter-spacing: 0.6px;
            color: #6c7a8a;
            margin: 0 0 8px;
            text-transform: uppercase;
        }

        .menu-name {
            margin: 0;
            font-size: 17px;
            line-height: 1.35;
            font-weight: 600;
            color: #111827;
        }

        .menu-price {
            margin-top: 18px;
            font-size: 17px;
            line-height: 1;
            font-weight: 500;
            color: #ff5a00;
        }

        .order-panel {
            border-left: 2px solid var(--border);
            background: #ececec;
            display: flex;
            flex-direction: column;
            min-width: 0;
            min-height: 0;
            height: 100%;
            overflow: hidden;
        }

        .order-header {
            padding: 16px 24px 14px;
            border-bottom: 2px solid var(--border);
        }

        .order-title {
            margin: 0;
            font-size: 16px;
            font-weight: 700;
            color: #111827;
        }

        .order-count {
            margin-top: 6px;
            font-size: 12px;
            color: #718096;
        }

        .order-body {
            flex: 1;
            min-height: 0;
            border-bottom: 2px solid var(--border);
            overflow: hidden;
        }

        .order-scroll {
            height: 100%;
            min-height: 0;
            overflow-y: auto;
            overscroll-behavior: contain;
            -webkit-overflow-scrolling: touch;
            padding: 16px;
            text-align: center;
            color: #9aa5b3;
            font-size: 15px;
        }

        .empty-order {
            min-height: 100%;
            display: flex;
            align-items: center;
            justify-content: center;
            transform: translateY(-14px);
        }

        .order-list {
            width: 100%;
            text-align: left;
            padding: 0;
        }

        .order-item {
            background: #f8f8f8;
            border: 2px solid var(--border);
            border-radius: 14px;
            padding: 12px 14px;
            margin-bottom: 10px;
        }

        .order-item-top {
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
            gap: 12px;
        }

        .order-item-name {
            margin: 0;
            font-size: 14px;
            font-weight: 700;
            color: #111827;
        }

        .order-item-meta {
            margin: 5px 0 0;
            font-size: 12px;
            color: #6b7280;
        }

        .order-item-price {
            font-size: 14px;
            font-weight: 800;
            color: #111827;
            white-space: nowrap;
        }

        .order-item-controls {
            margin-top: 12px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 10px;
            flex-wrap: wrap;
        }

        .qty-inline {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            background: #efefef;
            border: 2px solid var(--border);
            border-radius: 12px;
            padding: 4px;
        }

        .qty-inline button {
            width: 30px;
            height: 30px;
            border: 0;
            border-radius: 8px;
            background: #fff;
            color: #374151;
            font-size: 20px;
            line-height: 1;
            cursor: pointer;
            font-weight: 700;
        }

        .qty-inline span {
            min-width: 18px;
            text-align: center;
            font-size: 13px;
            font-weight: 800;
            color: #111827;
        }

        .order-item-buttons {
            display: flex;
            align-items: center;
            gap: 8px;
            flex-wrap: wrap;
        }

        .small-action-btn {
            border: 0;
            border-radius: 10px;
            padding: 8px 10px;
            font-size: 12px;
            font-weight: 700;
            cursor: pointer;
            transition: 0.15s ease;
        }

        .edit-btn {
            background: #fff0e5;
            color: #e85d04;
            border: 1px solid #f0c191;
        }

        .remove-btn {
            background: #fff0f0;
            color: var(--danger);
            border: 1px solid #f2b8b8;
        }

        .payment-section {
            padding: 20px 24px 18px;
            flex-shrink: 0;
        }

        .total-box {
            border: 2px solid #f0c191;
            border-radius: 16px;
            padding: 20px 20px 18px;
            background: #f6f6f6;
        }

        .total-label {
            margin: 0 0 10px;
            color: #4b5563;
            font-size: 14px;
            font-weight: 500;
        }

        .total-price {
            margin: 0;
            color: #ff5a00;
            font-size: 28px;
            font-weight: 800;
            line-height: 1;
        }

        .cash-box,
        .change-box {
            margin-top: 12px;
            border: 2px solid var(--border);
            border-radius: 14px;
            padding: 12px 14px;
            background: #f8f8f8;
            display: none;
        }

        .cash-box.show,
        .change-box.show {
            display: block;
        }

        .field-label {
            display: block;
            font-size: 12px;
            font-weight: 700;
            color: #6b7280;
            margin-bottom: 8px;
            text-transform: uppercase;
            letter-spacing: 0.4px;
        }

        .cash-input {
            width: 100%;
            height: 42px;
            border: 2px solid var(--border);
            border-radius: 10px;
            padding: 0 12px;
            font: inherit;
            font-size: 15px;
            font-weight: 600;
            background: #fff;
            outline: none;
        }

        .cash-input:focus {
            border-color: #f0c191;
        }

        .change-value {
            margin: 0;
            font-size: 20px;
            font-weight: 800;
            color: var(--success);
        }

        .change-note {
            margin-top: 6px;
            font-size: 12px;
            color: #6b7280;
        }

        .secondary-actions {
            display: grid;
            grid-template-columns: 1fr;
            gap: 10px;
            margin-top: 12px;
        }

        .reset-btn {
            width: 100%;
            height: 46px;
            border: 1px solid #f0c191;
            border-radius: 14px;
            background: #fff7ef;
            color: #d97706;
            font-size: 14px;
            font-weight: 800;
            cursor: pointer;
        }

        .payment-methods {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 12px;
            margin-top: 18px;
        }

        .payment-btn {
            border: 2px solid var(--border);
            border-radius: 16px;
            background: #efefef;
            height: 102px;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            gap: 10px;
            color: #7a7f87;
            cursor: pointer;
            transition: 0.15s ease;
            font: inherit;
        }

        .payment-btn:hover {
            border-color: #c7ccd3;
        }

        .payment-btn.active {
            border-color: #f0c191;
            background: #fff7ef;
            color: #ff6a00;
        }

        .payment-btn svg {
            width: 28px;
            height: 28px;
            opacity: 0.65;
        }

        .payment-btn span {
            font-size: 16px;
            font-weight: 500;
        }

        .pay-now {
            width: 100%;
            margin-top: 16px;
            height: 66px;
            border: 0;
            border-radius: 16px;
            background: #f1b889;
            color: #fff;
            font-size: 17px;
            font-weight: 800;
            cursor: pointer;
            transition: 0.15s ease;
        }

        .pay-now:hover {
            filter: brightness(0.98);
        }

        .pay-now:disabled {
            cursor: not-allowed;
            opacity: 0.85;
        }

        .modal-overlay {
            position: fixed;
            inset: 0;
            background: rgba(17, 24, 39, 0.35);
            display: none;
            align-items: center;
            justify-content: center;
            padding: 20px;
            z-index: 1000;
        }

        .modal-overlay.show {
            display: flex;
        }

        .modal-card {
            width: 100%;
            max-width: 420px;
            background: #f7f7f7;
            border: 2px solid var(--border);
            border-radius: 24px;
            padding: 22px;
            box-shadow: 0 20px 50px rgba(0,0,0,0.18);
        }

        .modal-head {
            display: flex;
            align-items: flex-start;
            justify-content: space-between;
            gap: 12px;
            margin-bottom: 14px;
        }

        .modal-title {
            margin: 0;
            font-size: 24px;
            font-weight: 800;
            color: #111827;
        }

        .modal-base-price {
            margin: 4px 0 0;
            font-size: 14px;
            color: #6b7280;
        }

        .modal-close {
            width: 36px;
            height: 36px;
            border: 0;
            border-radius: 999px;
            background: #ececec;
            font-size: 22px;
            line-height: 1;
            cursor: pointer;
            color: #6b7280;
        }

        .modal-section {
            margin-top: 18px;
        }

        .modal-label {
            display: block;
            font-size: 14px;
            font-weight: 800;
            color: #374151;
            margin-bottom: 10px;
        }

        .portion-options {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 10px;
        }

        .portion-btn {
            height: 48px;
            border-radius: 14px;
            border: 2px solid var(--border);
            background: #fff;
            color: #374151;
            font-size: 14px;
            font-weight: 700;
            cursor: pointer;
            transition: 0.15s ease;
        }

        .portion-btn.active {
            background: var(--orange);
            border-color: var(--orange);
            color: #fff;
        }

        .modal-note {
            margin: 8px 0 0;
            font-size: 13px;
            color: #6b7280;
        }

        .qty-box {
            display: flex;
            align-items: center;
            justify-content: space-between;
            border: 2px solid var(--border);
            border-radius: 18px;
            background: #f1f1f1;
            padding: 4px;
        }

        .qty-btn {
            width: 48px;
            height: 48px;
            border: 0;
            border-radius: 14px;
            background: transparent;
            font-size: 26px;
            line-height: 1;
            color: #374151;
            cursor: pointer;
        }

        .qty-value {
            min-width: 64px;
            text-align: center;
            font-size: 28px;
            font-weight: 800;
            color: #111827;
        }

        .subtotal-box {
            margin-top: 20px;
            border: 2px solid #f0c191;
            border-radius: 16px;
            background: #fff7ef;
            padding: 14px 16px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 12px;
        }

        .subtotal-label {
            margin: 0;
            font-size: 14px;
            font-weight: 700;
            color: #4b5563;
        }

        .subtotal-price {
            margin: 0;
            font-size: 24px;
            font-weight: 800;
            color: #ff5a00;
        }

        .modal-submit {
            width: 100%;
            margin-top: 16px;
            height: 56px;
            border: 0;
            border-radius: 16px;
            background: var(--orange);
            color: #fff;
            font-size: 16px;
            font-weight: 800;
            cursor: pointer;
        }

        @media (max-width: 1280px) {
            .menu-grid {
                grid-template-columns: repeat(3, minmax(0, 1fr));
            }
        }

        @media (max-width: 992px) {
            html, body {
                overflow: auto;
            }

            .app {
                height: auto;
                min-height: 100vh;
            }

            .content {
                grid-template-columns: 1fr;
            }

            .order-panel {
                border-left: 0;
                border-top: 2px solid var(--border);
            }

            .menu-grid {
                grid-template-columns: repeat(2, minmax(0, 1fr));
            }
        }

        @media (max-width: 640px) {
            .menu-grid {
                grid-template-columns: 1fr;
            }
        }
    </style>
</head>
<body>
    @php
        $menu = [
            ['id' => 'c1', 'category' => 'CILOK', 'name' => 'Cilok Original', 'price' => 5000],
            ['id' => 'c2', 'category' => 'CILOK', 'name' => 'Cilok Pedas', 'price' => 5000],
            ['id' => 'c3', 'category' => 'CILOK', 'name' => 'Cilok Keju', 'price' => 7000],
            ['id' => 'c4', 'category' => 'CILOK', 'name' => 'Cilok Bakso', 'price' => 8000],
            ['id' => 'm1', 'category' => 'MINUMAN', 'name' => 'Teh Manis', 'price' => 3000],
            ['id' => 'm2', 'category' => 'MINUMAN', 'name' => 'Es Jeruk', 'price' => 5000],
            ['id' => 'm3', 'category' => 'MINUMAN', 'name' => 'Teh Tawar', 'price' => 2000],
            ['id' => 'l1', 'category' => 'LAINNYA', 'name' => 'Gorengan', 'price' => 2000],
        ];
    @endphp

    <div class="app" id="posApp" data-menu='@json($menu)'>
        <div class="bg-gradient-to-r from-slate-800 to-slate-900 border-b border-white/10 px-5 py-3 flex items-center justify-between">
    {{-- Brand area --}}
    <div class="flex items-center gap-3">
        <div class="w-9 h-9 bg-gradient-to-br from-orange-500 to-orange-600 rounded-xl rotate-6 shadow-md"></div>
        <div>
            <p class="text-white text-xl font-extrabold tracking-tight leading-tight">KASIR</p>
            <p class="text-orange-500 text-xs font-semibold tracking-wide">POS Cilok</p>
        </div>
    </div>
    @auth
        @if(auth()->user()->role == 'admin')
            <form action="{{ route('admin.auth.logoutAdmin') }}" method="POST">
        @else
            <form action="{{ route('logout') }}" method="POST">
        @endif
        @csrf
            <button type="submit"
                    class="flex items-center gap-2 bg-white/5 hover:bg-red-600 border border-white/15 hover:border-red-600 px-4 py-2 rounded-full text-sm font-semibold text-slate-200 hover:text-white transition-all duration-200 hover:shadow-lg hover:shadow-red-500/30 group">
                {{-- Ikon Power (logout) --}}
                <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 transition-transform duration-200 group-hover:rotate-90" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M5.636 5.636a9 9 0 1012.728 0M12 3v9" />
                    <path stroke-linecap="round" stroke-linejoin="round" d="M16.5 8.5L19 6m-7 5v6" />
                </svg>
                <span>Keluar</span>
                {{-- Ikon panah kecil --}}
                <svg xmlns="http://www.w3.org/2000/svg" class="w-3.5 h-3.5 opacity-60 group-hover:opacity-100 group-hover:translate-x-0.5 transition-all" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M17 8l4 4m0 0l-4 4m4-4H3" />
                </svg>
            </button>
        </form>
    @endauth
</div>

        <div class="content">
            <div class="menu-area">
                <div class="menu-grid" id="menuGrid"></div>
            </div>

            <aside class="order-panel">
                <div class="order-header">
                    <p class="order-title">Pesanan</p>
                    <div class="order-count"><span id="orderCount">0</span> item</div>
                </div>

                <div class="order-body" id="orderBody">
                    <div class="order-scroll" id="orderScroll">
                        <div class="empty-order" id="emptyOrder">Belum ada pesanan</div>
                        <div class="order-list" id="orderList" style="display:none;"></div>
                    </div>
                </div>

                <div class="payment-section">
                    <div class="total-box">
                        <p class="total-label">Total Pembayaran</p>
                        <p class="total-price" id="totalPrice">Rp 0</p>
                    </div>

                    <div class="cash-box" id="cashBox">
                        <label class="field-label" for="cashInput">Uang Tunai</label>
                        <input type="text" id="cashInput" class="cash-input" inputmode="numeric" placeholder="Masukkan uang yang dibayar">
                    </div>

                    <div class="change-box" id="changeBox">
                        <span class="field-label">Kembalian</span>
                        <p class="change-value" id="changeValue">Rp 0</p>
                        <div class="change-note" id="changeNote">Masukkan nominal tunai terlebih dulu.</div>
                    </div>

                    <div class="payment-methods">
                        <button type="button" class="payment-btn" data-method="tunai">
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
                                <rect x="3" y="7" width="18" height="10" rx="2"></rect>
                                <circle cx="12" cy="12" r="1.5"></circle>
                                <path d="M7 10h.01M17 14h.01"></path>
                            </svg>
                            <span>Tunai</span>
                        </button>

                        <button type="button" class="payment-btn" data-method="qris">
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
                                <path d="M4 4h5v5H4zM15 4h5v5h-5zM4 15h5v5H4z"></path>
                                <path d="M16 15v2M20 15v5M15 20h2M18 18h2"></path>
                            </svg>
                            <span>QRIS</span>
                        </button>
                    </div>

                    <div class="secondary-actions">
                        <button type="button" class="reset-btn" id="resetOrderBtn">RESET PESANAN</button>
                    </div>

                    <button type="button" class="pay-now" id="payNowBtn">BAYAR SEKARANG</button>
                </div>
            </aside>
        </div>
    </div>

    <div class="modal-overlay" id="productModal">
        <div class="modal-card">
            <div class="modal-head">
                <div>
                    <p class="modal-title" id="modalProductName">Produk</p>
                    <p class="modal-base-price">Harga dasar: <span id="modalBasePrice">Rp 0</span></p>
                </div>
                <button type="button" class="modal-close" id="closeModalBtn">×</button>
            </div>

            <div class="modal-section">
                <label class="modal-label">Pilih porsi</label>
                <div class="portion-options">
                    <button type="button" class="portion-btn active" data-portion="full">1 Porsi</button>
                    <button type="button" class="portion-btn" data-portion="half">1/2 Porsi</button>
                </div>
                <p class="modal-note">Harga per porsi: <span id="modalUnitPrice">Rp 0</span></p>
            </div>

            <div class="modal-section">
                <label class="modal-label">Jumlah porsi</label>
                <div class="qty-box">
                    <button type="button" class="qty-btn" id="qtyMinusBtn">−</button>
                    <div class="qty-value" id="qtyValue">1</div>
                    <button type="button" class="qty-btn" id="qtyPlusBtn">+</button>
                </div>
            </div>

            <div class="subtotal-box">
                <p class="subtotal-label">Subtotal item</p>
                <p class="subtotal-price" id="modalSubtotal">Rp 0</p>
            </div>

            <button type="button" class="modal-submit" id="addToOrderBtn">Tambah ke Pesanan</button>
        </div>
    </div>

    <script>
        (function () {
            const root = document.getElementById('posApp');
            const menu = JSON.parse(root.dataset.menu || '[]');
            const menuGrid = document.getElementById('menuGrid');
            const orderList = document.getElementById('orderList');
            const emptyOrder = document.getElementById('emptyOrder');
            const orderCount = document.getElementById('orderCount');
            const totalPrice = document.getElementById('totalPrice');
            const paymentButtons = document.querySelectorAll('.payment-btn');
            const payNowBtn = document.getElementById('payNowBtn');
            const resetOrderBtn = document.getElementById('resetOrderBtn');
            const cashBox = document.getElementById('cashBox');
            const changeBox = document.getElementById('changeBox');
            const cashInput = document.getElementById('cashInput');
            const changeValue = document.getElementById('changeValue');
            const changeNote = document.getElementById('changeNote');

            const productModal = document.getElementById('productModal');
            const closeModalBtn = document.getElementById('closeModalBtn');
            const modalProductName = document.getElementById('modalProductName');
            const modalBasePrice = document.getElementById('modalBasePrice');
            const modalUnitPrice = document.getElementById('modalUnitPrice');
            const modalSubtotal = document.getElementById('modalSubtotal');
            const qtyValue = document.getElementById('qtyValue');
            const qtyMinusBtn = document.getElementById('qtyMinusBtn');
            const qtyPlusBtn = document.getElementById('qtyPlusBtn');
            const addToOrderBtn = document.getElementById('addToOrderBtn');
            const portionButtons = document.querySelectorAll('.portion-btn');

            let orders = [];
            let selectedPayment = null;
            let selectedProduct = null;
            let selectedPortion = 'full';
            let selectedQty = 1;
            let editIndex = null;

            function formatRupiah(value) {
                return 'Rp ' + Number(value || 0).toLocaleString('id-ID');
            }

            function parseCurrency(value) {
                const numeric = String(value || '').replace(/[^0-9]/g, '');
                return numeric ? Number(numeric) : 0;
            }

            function formatInputCurrency(input) {
                const numeric = parseCurrency(input.value);
                input.value = numeric ? Number(numeric).toLocaleString('id-ID') : '';
            }

            function getUnitPrice(product, portion) {
                if (!product) return 0;
                return portion === 'half' ? Math.round(product.price / 2) : product.price;
            }

            function getPortionLabel(portion) {
                return portion === 'half' ? '1/2 porsi' : '1 porsi';
            }

            function getGrandTotal() {
                return orders.reduce((sum, item) => sum + (item.unitPrice * item.qty), 0);
            }

            function refreshCashSection() {
                if (selectedPayment === 'tunai') {
                    cashBox.classList.add('show');
                    changeBox.classList.add('show');
                } else {
                    cashBox.classList.remove('show');
                    changeBox.classList.remove('show');
                }
                updateChange();
            }

            function updateChange() {
                const grandTotal = getGrandTotal();
                const paid = parseCurrency(cashInput.value);

                if (selectedPayment !== 'tunai') {
                    changeValue.textContent = formatRupiah(0);
                    changeNote.textContent = 'Kembalian hanya muncul untuk pembayaran tunai.';
                    return;
                }

                if (!paid) {
                    changeValue.textContent = formatRupiah(0);
                    changeNote.textContent = 'Masukkan nominal tunai terlebih dulu.';
                    return;
                }

                const change = paid - grandTotal;
                changeValue.textContent = formatRupiah(Math.max(change, 0));

                if (change < 0) {
                    changeNote.textContent = 'Uang tunai kurang ' + formatRupiah(Math.abs(change)) + '.';
                } else {
                    changeNote.textContent = 'Kembalian siap diberikan.';
                }
            }

            function updateModalTotals() {
                const unitPrice = getUnitPrice(selectedProduct, selectedPortion);
                modalUnitPrice.textContent = formatRupiah(unitPrice);
                modalSubtotal.textContent = formatRupiah(unitPrice * selectedQty);
                qtyValue.textContent = selectedQty;
            }

            function openProductModal(product, existingOrderIndex = null) {
                selectedProduct = product;
                editIndex = existingOrderIndex;

                if (existingOrderIndex !== null && orders[existingOrderIndex]) {
                    selectedPortion = orders[existingOrderIndex].portion;
                    selectedQty = orders[existingOrderIndex].qty;
                    addToOrderBtn.textContent = 'Simpan Perubahan';
                } else {
                    selectedPortion = 'full';
                    selectedQty = 1;
                    addToOrderBtn.textContent = 'Tambah ke Pesanan';
                }

                modalProductName.textContent = product.name;
                modalBasePrice.textContent = formatRupiah(product.price);
                portionButtons.forEach(btn => {
                    btn.classList.toggle('active', btn.dataset.portion === selectedPortion);
                });
                updateModalTotals();
                productModal.classList.add('show');
            }

            function closeProductModal() {
                productModal.classList.remove('show');
                selectedProduct = null;
                editIndex = null;
                selectedPortion = 'full';
                selectedQty = 1;
                addToOrderBtn.textContent = 'Tambah ke Pesanan';
            }

            function renderMenu() {
                menuGrid.innerHTML = menu.map(item => `
                    <button type="button" class="menu-card" data-id="${item.id}">
                        <p class="menu-category">${item.category}</p>
                        <p class="menu-name">${item.name}</p>
                        <p class="menu-price">${formatRupiah(item.price)}</p>
                    </button>
                `).join('');

                menuGrid.querySelectorAll('.menu-card').forEach(card => {
                    card.addEventListener('click', function () {
                        const item = menu.find(row => row.id === this.dataset.id);
                        if (item) openProductModal(item);
                    });
                });
            }

            function renderOrders() {
                const totalItem = orders.reduce((sum, item) => sum + item.qty, 0);
                const grandTotal = getGrandTotal();

                orderCount.textContent = totalItem;
                totalPrice.textContent = formatRupiah(grandTotal);

                if (orders.length === 0) {
                    emptyOrder.style.display = 'block';
                    orderList.style.display = 'none';
                    orderList.innerHTML = '';
                } else {
                    emptyOrder.style.display = 'none';
                    orderList.style.display = 'block';
                    orderList.innerHTML = orders.map((item, index) => `
                        <div class="order-item">
                            <div class="order-item-top">
                                <div>
                                    <p class="order-item-name">${item.name}</p>
                                    <p class="order-item-meta">${getPortionLabel(item.portion)} · ${item.qty} x ${formatRupiah(item.unitPrice)}</p>
                                </div>
                                <div class="order-item-price">${formatRupiah(item.qty * item.unitPrice)}</div>
                            </div>
                            <div class="order-item-controls">
                                <div class="qty-inline">
                                    <button type="button" class="qty-inline-btn" data-action="decrease" data-index="${index}">−</button>
                                    <span>${item.qty}</span>
                                    <button type="button" class="qty-inline-btn" data-action="increase" data-index="${index}">+</button>
                                </div>
                                <div class="order-item-buttons">
                                    <button type="button" class="small-action-btn edit-btn" data-action="edit" data-index="${index}">Edit Porsi</button>
                                    <button type="button" class="small-action-btn remove-btn" data-action="remove" data-index="${index}">Hapus</button>
                                </div>
                            </div>
                        </div>
                    `).join('');

                    orderList.querySelectorAll('[data-action]').forEach(btn => {
                        btn.addEventListener('click', function () {
                            const index = Number(this.dataset.index);
                            const action = this.dataset.action;
                            const item = orders[index];
                            if (!item) return;

                            if (action === 'increase') {
                                item.qty += 1;
                            }

                            if (action === 'decrease') {
                                if (item.qty > 1) {
                                    item.qty -= 1;
                                } else {
                                    orders.splice(index, 1);
                                }
                            }

                            if (action === 'remove') {
                                orders.splice(index, 1);
                            }

                            if (action === 'edit') {
                                const product = menu.find(row => row.id === item.id);
                                if (product) openProductModal(product, index);
                                return;
                            }

                            renderOrders();
                        });
                    });
                }

                updateChange();
            }

            portionButtons.forEach(btn => {
                btn.addEventListener('click', function () {
                    selectedPortion = this.dataset.portion;
                    portionButtons.forEach(x => x.classList.remove('active'));
                    this.classList.add('active');
                    updateModalTotals();
                });
            });

            qtyMinusBtn.addEventListener('click', function () {
                if (selectedQty > 1) {
                    selectedQty -= 1;
                    updateModalTotals();
                }
            });

            qtyPlusBtn.addEventListener('click', function () {
                selectedQty += 1;
                updateModalTotals();
            });

            addToOrderBtn.addEventListener('click', function () {
                if (!selectedProduct) return;

                const unitPrice = getUnitPrice(selectedProduct, selectedPortion);
                const payload = {
                    id: selectedProduct.id,
                    category: selectedProduct.category,
                    name: selectedProduct.name,
                    basePrice: selectedProduct.price,
                    portion: selectedPortion,
                    unitPrice: unitPrice,
                    qty: selectedQty
                };

                if (editIndex !== null && orders[editIndex]) {
                    orders[editIndex] = payload;
                } else {
                    const existing = orders.find(row => row.id === selectedProduct.id && row.portion === selectedPortion && row.unitPrice === unitPrice);
                    if (existing) {
                        existing.qty += selectedQty;
                    } else {
                        orders.push(payload);
                    }
                }

                closeProductModal();
                renderOrders();
            });

            closeModalBtn.addEventListener('click', closeProductModal);
            productModal.addEventListener('click', function (e) {
                if (e.target === productModal) {
                    closeProductModal();
                }
            });

            document.addEventListener('keydown', function (e) {
                if (e.key === 'Escape' && productModal.classList.contains('show')) {
                    closeProductModal();
                }
            });

            paymentButtons.forEach(btn => {
                btn.addEventListener('click', function () {
                    selectedPayment = this.dataset.method;
                    paymentButtons.forEach(x => x.classList.remove('active'));
                    this.classList.add('active');
                    refreshCashSection();
                });
            });

            cashInput.addEventListener('input', function () {
                formatInputCurrency(this);
                updateChange();
            });

            resetOrderBtn.addEventListener('click', function () {
                if (orders.length === 0) {
                    alert('Pesanan sudah kosong.');
                    return;
                }

                if (!confirm('Yakin reset semua pesanan?')) {
                    return;
                }

                orders = [];
                selectedPayment = null;
                cashInput.value = '';
                paymentButtons.forEach(x => x.classList.remove('active'));
                refreshCashSection();
                renderOrders();
            });

            payNowBtn.addEventListener('click', function () {
                if (orders.length === 0) {
                    alert('Pesanan masih kosong.');
                    return;
                }

                if (!selectedPayment) {
                    alert('Pilih metode pembayaran dulu.');
                    return;
                }

                if (selectedPayment === 'tunai') {
                    const paid = parseCurrency(cashInput.value);
                    const grandTotal = getGrandTotal();

                    if (!paid) {
                        alert('Masukkan nominal uang tunai.');
                        return;
                    }

                    if (paid < grandTotal) {
                        alert('Uang tunai tidak cukup. Kurang ' + formatRupiah(grandTotal - paid) + '.');
                        return;
                    }

                    alert('Pembayaran tunai diproses. Kembalian: ' + formatRupiah(paid - grandTotal) + '.');
                    return;
                }

                alert('Pembayaran QRIS diproses.');
            });

            renderMenu();
            renderOrders();
            refreshCashSection();
        })();
    </script>
</body>
</html>
