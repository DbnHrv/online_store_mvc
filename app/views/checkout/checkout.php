<?php $pageTitle = 'ShopPH – Checkout'; include __DIR__ . '/../partials/header.php'; ?>

<div class="container">
    <div class="page-header">
        <h1><i class="fas fa-lock"></i> Secure Checkout</h1>
        <p>Complete your order via PayMongo</p>
    </div>

    <?php if (isset($_SESSION['checkout_error'])): ?>
        <div class="alert alert-danger"><i class="fas fa-exclamation-circle"></i> <?= htmlspecialchars($_SESSION['checkout_error']) ?></div>
        <?php unset($_SESSION['checkout_error']); ?>
    <?php endif; ?>

    <div class="checkout-layout">
        <div class="order-review">
            <h2>Order Review</h2>
            <?php foreach ($items as $item): $p = $item['product']; ?>
            <div class="review-row">
                <div class="review-img">
                    <img src="<?= BASE_URL ?>/assets/images/<?= htmlspecialchars($p['image']) ?>"
                         alt="<?= htmlspecialchars($p['name']) ?>"
                         onerror="this.src='<?= BASE_URL ?>/assets/images/placeholder.svg'">
                    <span class="review-qty"><?= $item['qty'] ?></span>
                </div>
                <div class="review-info">
                    <strong><?= htmlspecialchars($p['name']) ?></strong>
                    <span>₱<?= number_format($p['price'], 2) ?> × <?= $item['qty'] ?></span>
                </div>
                <div class="review-price">₱<?= number_format($item['subtotal'], 2) ?></div>
            </div>
            <?php endforeach; ?>
            <div class="review-total">
                <span>Total</span>
                <span>₱<?= number_format($total, 2) ?></span>
            </div>
        </div>

        <div class="payment-panel">
            <h2>Payment</h2>
            <div class="payment-methods">
                <div class="pm-badge"><i class="fas fa-mobile-alt"></i> GCash</div>
                <div class="pm-badge"><i class="fas fa-credit-card"></i> Credit / Debit Card</div>
            </div>
            <div class="secure-note">
                <i class="fas fa-shield-alt"></i>
                <span>Your payment is secured by <strong>PayMongo</strong>. You'll be redirected to complete payment.</span>
            </div>
            <form action="<?= BASE_URL ?>/checkout/process" method="POST">
                <button type="submit" class="btn btn-success btn-lg btn-block pay-btn">
                    <i class="fas fa-lock"></i> Pay ₱<?= number_format($total, 2) ?> Now
                </button>
            </form>
            <a href="<?= BASE_URL ?>/cart" class="btn btn-outline btn-block" style="margin-top:10px;">
                <i class="fas fa-arrow-left"></i> Back to Cart
            </a>
            <div class="pm-logo">
                <img src="https://assets.paymongo.com/paymongo-logo.svg" alt="PayMongo" onerror="this.style.display='none'">
            </div>
        </div>
    </div>
</div>

<style>
.checkout-layout { display: grid; grid-template-columns: 1fr 380px; gap: 32px; align-items: start; }
@media(max-width:768px){ .checkout-layout { grid-template-columns: 1fr; } }

.order-review, .payment-panel {
    background: var(--white); border-radius: var(--radius); padding: 28px; box-shadow: var(--shadow);
}
.order-review h2, .payment-panel h2 { font-size: 1.1rem; font-weight: 700; margin-bottom: 20px; }

.review-row { display: flex; align-items: center; gap: 14px; padding: 14px 0; border-bottom: 1px solid var(--border); }
.review-img { position: relative; width: 60px; height: 60px; border-radius: 8px; overflow: hidden; background: var(--secondary); flex-shrink: 0; }
.review-img img { width: 100%; height: 100%; object-fit: cover; }
.review-qty {
    position: absolute; top: -6px; right: -6px;
    background: var(--primary); color: white; border-radius: 50%;
    width: 20px; height: 20px; font-size: .7rem; font-weight: 700;
    display: flex; align-items: center; justify-content: center;
}
.review-info { flex: 1; font-size: .88rem; display: flex; flex-direction: column; gap: 4px; }
.review-info strong { font-weight: 600; }
.review-info span { color: var(--muted); }
.review-price { font-weight: 700; color: var(--text); }
.review-total { display: flex; justify-content: space-between; padding-top: 16px; font-size: 1.1rem; font-weight: 700; }

.payment-methods { display: flex; gap: 10px; margin-bottom: 20px; flex-wrap: wrap; }
.pm-badge {
    display: flex; align-items: center; gap: 8px;
    padding: 10px 16px; border: 2px solid var(--border); border-radius: 8px;
    font-size: .85rem; font-weight: 500; color: var(--text);
    background: var(--secondary);
}
.pm-badge i { color: var(--primary); }

.secure-note {
    display: flex; align-items: flex-start; gap: 10px;
    background: #f0fdf4; border: 1px solid #bbf7d0; border-radius: 8px;
    padding: 14px; margin-bottom: 20px; font-size: .83rem; color: #166534; line-height: 1.5;
}
.secure-note i { color: var(--accent); margin-top: 2px; flex-shrink: 0; }

.pay-btn { font-size: 1rem; padding: 16px; }
.pm-logo { text-align: center; margin-top: 20px; opacity: .5; }
.pm-logo img { height: 24px; margin: 0 auto; }
</style>

<?php include __DIR__ . '/../partials/footer.php'; ?>
