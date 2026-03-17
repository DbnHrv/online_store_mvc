<?php $pageTitle = 'ShopPH – Cart'; include __DIR__ . '/../partials/header.php'; ?>

<div class="container">
    <div class="page-header">
        <h1><i class="fas fa-shopping-cart"></i> Your Cart</h1>
    </div>

    <?php if (!empty($cart_items)): ?>
    <?php
        $total = 0;
        $enriched = [];
        foreach ($cart_items as $id => $qty) {
            $product = $productModel->getProductById((int)$id);
            if ($product) {
                $subtotal = $product['price'] * $qty;
                $total += $subtotal;
                $enriched[] = ['product' => $product, 'qty' => $qty, 'subtotal' => $subtotal];
            }
        }
    ?>
    <div class="cart-layout">
        <div class="cart-items">
            <?php foreach ($enriched as $item): $p = $item['product']; ?>
            <div class="cart-row">
                <div class="cart-img">
                    <img src="<?= BASE_URL ?>/assets/images/<?= htmlspecialchars($p['image']) ?>"
                         alt="<?= htmlspecialchars($p['name']) ?>"
                         onerror="this.src='<?= BASE_URL ?>/assets/images/placeholder.svg'">
                </div>
                <div class="cart-info">
                    <h3><?= htmlspecialchars($p['name']) ?></h3>
                    <p class="unit-price">₱<?= number_format($p['price'], 2) ?> each</p>
                </div>
                <div class="cart-qty">
                    <form action="<?= BASE_URL ?>/cart/update" method="POST" class="qty-form">
                        <input type="hidden" name="product_id" value="<?= $p['id'] ?>">
                        <div class="qty-ctrl">
                            <button type="button" class="qty-btn" onclick="changeQty(this, -1)">−</button>
                            <input type="number" name="quantity" value="<?= $item['qty'] ?>" min="1" max="99" class="qty-num" onchange="this.form.submit()">
                            <button type="button" class="qty-btn" onclick="changeQty(this, 1)">+</button>
                        </div>
                    </form>
                </div>
                <div class="cart-subtotal">₱<?= number_format($item['subtotal'], 2) ?></div>
                <a href="<?= BASE_URL ?>/cart/remove?product_id=<?= $p['id'] ?>" class="cart-remove" title="Remove">
                    <i class="fas fa-trash-alt"></i>
                </a>
            </div>
            <?php endforeach; ?>
        </div>

        <div class="cart-summary">
            <h2>Order Summary</h2>
            <div class="summary-row"><span>Subtotal</span><span>₱<?= number_format($total, 2) ?></span></div>
            <div class="summary-row"><span>Shipping</span><span class="free">Free</span></div>
            <div class="summary-divider"></div>
            <div class="summary-row total"><span>Total</span><span>₱<?= number_format($total, 2) ?></span></div>
            <a href="<?= BASE_URL ?>/checkout" class="btn btn-success btn-lg btn-block" style="margin-top:20px;">
                <i class="fas fa-lock"></i> Proceed to Checkout
            </a>
            <a href="<?= BASE_URL ?>/" class="btn btn-outline btn-block" style="margin-top:10px;">
                <i class="fas fa-arrow-left"></i> Continue Shopping
            </a>
        </div>
    </div>

    <?php else: ?>
    <div class="empty-cart">
        <i class="fas fa-shopping-cart"></i>
        <h2>Your cart is empty</h2>
        <p>Looks like you haven't added anything yet.</p>
        <a href="<?= BASE_URL ?>/" class="btn btn-primary btn-lg">Start Shopping</a>
    </div>
    <?php endif; ?>
</div>

<style>
.cart-layout { display: grid; grid-template-columns: 1fr 340px; gap: 32px; align-items: start; }
@media(max-width:768px){ .cart-layout { grid-template-columns: 1fr; } }

.cart-items { display: flex; flex-direction: column; gap: 16px; }
.cart-row {
    background: var(--white); border-radius: var(--radius); padding: 20px;
    display: flex; align-items: center; gap: 16px; box-shadow: var(--shadow);
}
.cart-img { width: 80px; height: 80px; border-radius: 8px; overflow: hidden; flex-shrink: 0; background: var(--secondary); }
.cart-img img { width: 100%; height: 100%; object-fit: cover; }
.cart-info { flex: 1; }
.cart-info h3 { font-size: .95rem; font-weight: 600; margin-bottom: 4px; }
.unit-price { font-size: .82rem; color: var(--muted); }
.cart-subtotal { font-weight: 700; color: var(--primary); font-size: 1rem; min-width: 90px; text-align: right; }
.cart-remove { color: var(--muted); padding: 8px; border-radius: 6px; transition: all .2s; }
.cart-remove:hover { color: var(--danger); background: #fef2f2; }

.qty-ctrl { display: flex; align-items: center; border: 1px solid var(--border); border-radius: 8px; overflow: hidden; }
.qty-btn { background: var(--secondary); border: none; width: 32px; height: 36px; cursor: pointer; font-size: 1rem; font-weight: 600; color: var(--text); transition: background .2s; }
.qty-btn:hover { background: var(--border); }
.qty-num { width: 44px; height: 36px; border: none; text-align: center; font-size: .9rem; font-weight: 600; outline: none; }

.cart-summary {
    background: var(--white); border-radius: var(--radius); padding: 28px;
    box-shadow: var(--shadow); position: sticky; top: 80px;
}
.cart-summary h2 { font-size: 1.1rem; font-weight: 700; margin-bottom: 20px; }
.summary-row { display: flex; justify-content: space-between; margin-bottom: 12px; font-size: .9rem; color: var(--muted); }
.summary-row.total { font-size: 1.1rem; font-weight: 700; color: var(--text); }
.summary-divider { border-top: 1px solid var(--border); margin: 16px 0; }
.free { color: var(--accent); font-weight: 600; }

.empty-cart { text-align: center; padding: 80px 20px; }
.empty-cart i { font-size: 4rem; color: var(--border); margin-bottom: 20px; }
.empty-cart h2 { font-size: 1.5rem; margin-bottom: 8px; }
.empty-cart p { color: var(--muted); margin-bottom: 24px; }
</style>

<script>
function changeQty(btn, delta) {
    const form = btn.closest('form');
    const input = form.querySelector('.qty-num');
    const newVal = Math.max(1, parseInt(input.value) + delta);
    input.value = newVal;
    form.submit();
}
</script>

<?php include __DIR__ . '/../partials/footer.php'; ?>
