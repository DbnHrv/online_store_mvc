<?php $pageTitle = 'ShopPH – Order Confirmed'; include __DIR__ . '/../partials/header.php'; ?>

<div class="container">
    <div class="success-wrap">
        <div class="success-icon">
            <i class="fas fa-check-circle"></i>
        </div>
        <h1>Order Confirmed!</h1>
        <p class="success-sub">Thank you for your purchase. Your order has been received.</p>

        <div class="order-card">
            <div class="order-meta">
                <div class="meta-item">
                    <span class="meta-label">Order ID</span>
                    <span class="meta-val">#<?= $order['id'] ?></span>
                </div>
                <div class="meta-item">
                    <span class="meta-label">Status</span>
                    <span class="status-badge status-<?= $order['payment_status'] ?>">
                        <?= ucfirst($order['payment_status']) ?>
                    </span>
                </div>
                <div class="meta-item">
                    <span class="meta-label">Date</span>
                    <span class="meta-val"><?= date('M d, Y', strtotime($order['created_at'])) ?></span>
                </div>
                <div class="meta-item">
                    <span class="meta-label">Total</span>
                    <span class="meta-val total">₱<?= number_format($order['total_amount'], 2) ?></span>
                </div>
            </div>

            <div class="order-items-list">
                <h3>Items Ordered</h3>
                <?php foreach ($order_items as $item): ?>
                <div class="oi-row">
                    <div class="oi-img">
                        <img src="<?= BASE_URL ?>/assets/images/<?= htmlspecialchars($item['image']) ?>"
                             alt="<?= htmlspecialchars($item['name']) ?>"
                             onerror="this.src='<?= BASE_URL ?>/assets/images/placeholder.svg'">
                    </div>
                    <div class="oi-info">
                        <strong><?= htmlspecialchars($item['name']) ?></strong>
                        <span>Qty: <?= $item['quantity'] ?> × ₱<?= number_format($item['price'], 2) ?></span>
                    </div>
                    <div class="oi-total">₱<?= number_format($item['price'] * $item['quantity'], 2) ?></div>
                </div>
                <?php endforeach; ?>
            </div>
        </div>

        <a href="<?= BASE_URL ?>/" class="btn btn-primary btn-lg" style="margin-top:28px;">
            <i class="fas fa-store"></i> Continue Shopping
        </a>
    </div>
</div>

<style>
.success-wrap { max-width: 680px; margin: 0 auto; text-align: center; }
.success-icon { font-size: 5rem; color: var(--accent); margin-bottom: 20px; animation: pop .4s ease; }
@keyframes pop { 0%{transform:scale(0)} 80%{transform:scale(1.1)} 100%{transform:scale(1)} }
.success-wrap h1 { font-size: 2rem; font-weight: 700; margin-bottom: 8px; }
.success-sub { color: var(--muted); margin-bottom: 32px; }

.order-card { background: var(--white); border-radius: var(--radius); box-shadow: var(--shadow); overflow: hidden; text-align: left; }
.order-meta { display: grid; grid-template-columns: repeat(4, 1fr); gap: 0; border-bottom: 1px solid var(--border); }
@media(max-width:600px){ .order-meta { grid-template-columns: 1fr 1fr; } }
.meta-item { padding: 20px; border-right: 1px solid var(--border); }
.meta-item:last-child { border-right: none; }
.meta-label { display: block; font-size: .75rem; color: var(--muted); text-transform: uppercase; letter-spacing: .05em; margin-bottom: 6px; }
.meta-val { font-weight: 600; font-size: .95rem; }
.meta-val.total { color: var(--primary); font-size: 1.1rem; }

.status-badge { display: inline-block; padding: 4px 12px; border-radius: 20px; font-size: .8rem; font-weight: 600; }
.status-paid { background: #dcfce7; color: #166534; }
.status-pending { background: #fef9c3; color: #854d0e; }
.status-failed { background: #fee2e2; color: #991b1b; }

.order-items-list { padding: 24px; }
.order-items-list h3 { font-size: .9rem; font-weight: 600; color: var(--muted); text-transform: uppercase; letter-spacing: .05em; margin-bottom: 16px; }
.oi-row { display: flex; align-items: center; gap: 14px; padding: 12px 0; border-bottom: 1px solid var(--border); }
.oi-row:last-child { border-bottom: none; }
.oi-img { width: 52px; height: 52px; border-radius: 8px; overflow: hidden; background: var(--secondary); flex-shrink: 0; }
.oi-img img { width: 100%; height: 100%; object-fit: cover; }
.oi-info { flex: 1; font-size: .88rem; display: flex; flex-direction: column; gap: 3px; }
.oi-info strong { font-weight: 600; }
.oi-info span { color: var(--muted); }
.oi-total { font-weight: 700; }
</style>

<?php include __DIR__ . '/../partials/footer.php'; ?>
