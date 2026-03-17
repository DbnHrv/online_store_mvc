<?php $pageTitle = 'ShopPH – Products'; include __DIR__ . '/../partials/header.php'; ?>

<div class="container">
    <div class="page-header">
        <h1>Our Products</h1>
        <p>Discover our curated collection of tech essentials</p>
    </div>

    <?php if (isset($_SESSION['cart_message'])): ?>
        <div class="alert alert-success"><i class="fas fa-check-circle"></i> <?= htmlspecialchars($_SESSION['cart_message']) ?></div>
        <?php unset($_SESSION['cart_message']); ?>
    <?php endif; ?>

    <div class="products-grid">
        <?php foreach ($products as $p): ?>
        <div class="product-card">
            <div class="product-img-wrap">
                <img src="<?= BASE_URL ?>/assets/images/<?= htmlspecialchars($p['image']) ?>"
                     alt="<?= htmlspecialchars($p['name']) ?>"
                     onerror="this.src='<?= BASE_URL ?>/assets/images/placeholder.svg'">
                <div class="product-badge">In Stock</div>
            </div>
            <div class="product-body">
                <h3 class="product-name"><?= htmlspecialchars($p['name']) ?></h3>
                <p class="product-desc"><?= htmlspecialchars($p['description']) ?></p>
                <div class="product-footer">
                    <span class="product-price">₱<?= number_format($p['price'], 2) ?></span>
                    <form action="<?= BASE_URL ?>/cart/add" method="POST" class="add-form">
                        <input type="hidden" name="product_id" value="<?= $p['id'] ?>">
                        <div class="qty-row">
                            <input type="number" name="quantity" value="1" min="1" max="<?= $p['stock'] ?>" class="qty-input">
                            <button type="submit" class="btn btn-primary btn-sm">
                                <i class="fas fa-cart-plus"></i> Add
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <?php endforeach; ?>
    </div>
</div>

<style>
.page-header { margin-bottom: 36px; }
.page-header h1 { font-size: 2rem; font-weight: 700; color: var(--text); }
.page-header p { color: var(--muted); margin-top: 6px; }

.products-grid {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(280px, 1fr));
    gap: 24px;
}
.product-card {
    background: var(--white); border-radius: var(--radius);
    box-shadow: var(--shadow); overflow: hidden;
    transition: transform .2s, box-shadow .2s;
}
.product-card:hover { transform: translateY(-4px); box-shadow: 0 8px 30px rgba(0,0,0,.1); }
.product-img-wrap { position: relative; background: var(--secondary); height: 200px; overflow: hidden; }
.product-img-wrap img { width: 100%; height: 100%; object-fit: cover; transition: transform .3s; }
.product-card:hover .product-img-wrap img { transform: scale(1.05); }
.product-badge {
    position: absolute; top: 12px; right: 12px;
    background: var(--accent); color: white;
    font-size: .72rem; font-weight: 600; padding: 4px 10px; border-radius: 20px;
}
.product-body { padding: 20px; }
.product-name { font-size: 1rem; font-weight: 600; margin-bottom: 8px; }
.product-desc { font-size: .85rem; color: var(--muted); line-height: 1.5; margin-bottom: 16px; min-height: 40px; }
.product-footer { display: flex; align-items: center; justify-content: space-between; gap: 12px; flex-wrap: wrap; }
.product-price { font-size: 1.2rem; font-weight: 700; color: var(--primary); }
.qty-row { display: flex; align-items: center; gap: 8px; }
.qty-input {
    width: 56px; padding: 6px 8px; border: 1px solid var(--border);
    border-radius: 6px; font-size: .85rem; text-align: center;
}
.qty-input:focus { outline: none; border-color: var(--primary); }
</style>

<?php include __DIR__ . '/../partials/footer.php'; ?>
