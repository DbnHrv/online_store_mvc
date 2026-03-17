<?php $pageTitle = 'ShopPH – Payment Cancelled'; include __DIR__ . '/../partials/header.php'; ?>

<div class="container">
    <div class="cancel-wrap">
        <div class="cancel-icon"><i class="fas fa-times-circle"></i></div>
        <h1>Payment Cancelled</h1>
        <p>Your payment was not completed. Your order has been marked as failed.</p>
        <div class="cancel-actions">
            <a href="<?= BASE_URL ?>/cart" class="btn btn-primary btn-lg">
                <i class="fas fa-shopping-cart"></i> Return to Cart
            </a>
            <a href="<?= BASE_URL ?>/" class="btn btn-outline btn-lg">
                <i class="fas fa-store"></i> Continue Shopping
            </a>
        </div>
    </div>
</div>

<style>
.cancel-wrap { max-width: 480px; margin: 60px auto; text-align: center; }
.cancel-icon { font-size: 5rem; color: var(--danger); margin-bottom: 20px; }
.cancel-wrap h1 { font-size: 1.8rem; font-weight: 700; margin-bottom: 12px; }
.cancel-wrap p { color: var(--muted); margin-bottom: 32px; line-height: 1.6; }
.cancel-actions { display: flex; gap: 12px; justify-content: center; flex-wrap: wrap; }
</style>

<?php include __DIR__ . '/../partials/footer.php'; ?>
