<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $pageTitle ?? 'ShopPH' ?></title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <style>
        *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }
        :root {
            --primary: #fa7900;
            --primary-dark: #4f46e5;
            --secondary: #f1f5f9;
            --accent: #10b981;
            --danger: #ef4444;
            --text: #1e293b;
            --muted: #64748b;
            --border: #e2e8f0;
            --white: #ffffff;
            --shadow: 0 1px 3px rgba(0,0,0,.08), 0 4px 16px rgba(0,0,0,.06);
            --radius: 12px;
        }
        body { font-family: 'Inter', sans-serif; background: #f8fafc; color: var(--text); min-height: 100vh; }
        a { text-decoration: none; color: inherit; }
        img { max-width: 100%; display: block; }

        /* NAV */
        nav {
            background: var(--white);
            border-bottom: 1px solid var(--border);
            position: sticky; top: 0; z-index: 100;
            box-shadow: 0 1px 8px rgba(0,0,0,.06);
        }
        .nav-inner {
            max-width: 1200px; margin: 0 auto;
            display: flex; align-items: center; justify-content: space-between;
            padding: 0 24px; height: 64px;
        }
        .nav-brand { font-size: 1.4rem; font-weight: 700; color: var(--primary); display: flex; align-items: center; gap: 8px; }
        .nav-brand i { font-size: 1.2rem; }
        .nav-links { display: flex; align-items: center; gap: 8px; }
        .nav-links a {
            padding: 8px 16px; border-radius: 8px; font-size: .9rem; font-weight: 500;
            color: var(--muted); transition: all .2s;
        }
        .nav-links a:hover, .nav-links a.active { background: var(--secondary); color: var(--primary); }
        .cart-badge {
            background: var(--primary); color: white; border-radius: 20px;
            padding: 6px 14px; font-size: .85rem; font-weight: 600;
            display: flex; align-items: center; gap: 6px; transition: all .2s;
        }
        .cart-badge:hover { background: var(--primary-dark); transform: translateY(-1px); }
        .cart-badge .count {
            background: white; color: var(--primary); border-radius: 50%;
            width: 20px; height: 20px; display: flex; align-items: center; justify-content: center;
            font-size: .75rem; font-weight: 700;
        }

        /* CONTAINER */
        .container { max-width: 1200px; margin: 0 auto; padding: 40px 24px; }

        /* BUTTONS */
        .btn {
            display: inline-flex; align-items: center; gap: 8px;
            padding: 10px 20px; border-radius: 8px; font-size: .9rem;
            font-weight: 600; cursor: pointer; border: none; transition: all .2s;
        }
        .btn-primary { background: var(--primary); color: white; }
        .btn-primary:hover { background: var(--primary-dark); transform: translateY(-1px); box-shadow: 0 4px 12px rgba(99,102,241,.3); }
        .btn-success { background: var(--accent); color: white; }
        .btn-success:hover { background: #059669; transform: translateY(-1px); }
        .btn-danger { background: var(--danger); color: white; }
        .btn-danger:hover { background: #dc2626; }
        .btn-outline { background: transparent; color: var(--primary); border: 2px solid var(--primary); }
        .btn-outline:hover { background: var(--primary); color: white; }
        .btn-sm { padding: 6px 14px; font-size: .82rem; }
        .btn-lg { padding: 14px 28px; font-size: 1rem; }
        .btn-block { width: 100%; justify-content: center; }

        /* ALERTS */
        .alert { padding: 14px 18px; border-radius: 8px; margin-bottom: 20px; font-size: .9rem; display: flex; align-items: center; gap: 10px; }
        .alert-danger { background: #fef2f2; color: #991b1b; border: 1px solid #fecaca; }
        .alert-success { background: #f0fdf4; color: #166534; border: 1px solid #bbf7d0; }

        /* FOOTER */
        footer { background: var(--text); color: #94a3b8; text-align: center; padding: 24px; margin-top: 60px; font-size: .85rem; }
        footer span { color: var(--primary); }
    </style>
</head>
<body>
<nav>
    <div class="nav-inner">
        <a href="<?= BASE_URL ?>/" class="nav-brand"><i class="fas fa-store"></i> ShopPH</a>
        <div class="nav-links">
            <a href="<?= BASE_URL ?>/" class="<?= (strpos($_SERVER['REQUEST_URI'], '/cart') === false && strpos($_SERVER['REQUEST_URI'], '/checkout') === false && strpos($_SERVER['REQUEST_URI'], '/orders') === false) ? 'active' : '' ?>">
                <i class="fas fa-th-large"></i> Products
            </a>
            <a href="<?= BASE_URL ?>/cart" class="cart-badge">
                <i class="fas fa-shopping-cart"></i> Cart
                <span class="count"><?= array_sum($_SESSION['cart'] ?? []) ?></span>
            </a>
        </div>
    </div>
</nav>
