<?php
require_once __DIR__ . '/../config/config.php';

// Load models
require_once __DIR__ . '/../app/models/Product.php';
require_once __DIR__ . '/../app/models/Cart.php';
require_once __DIR__ . '/../app/models/Order.php';

// Strip query string and normalize URI
$request = strtok($_SERVER['REQUEST_URI'], '?');
$request = rtrim($request, '/') ?: '/';

// Strip the subdirectory base path so routes are relative (e.g. /cart, /checkout)
$base_path = rtrim(parse_url(BASE_URL, PHP_URL_PATH), '/'); // /online_store_mvc/public
if ($base_path && strpos($request, $base_path) === 0) {
    $request = substr($request, strlen($base_path));
}
if (empty($request)) $request = '/';

switch ($request) {
    case '/':
    case '':
        require_once __DIR__ . '/../app/controllers/ProductController.php';
        (new ProductController($conn))->index();
        break;

    case '/cart':
        require_once __DIR__ . '/../app/controllers/CartController.php';
        (new CartController($conn))->view();
        break;

    case '/cart/add':
        require_once __DIR__ . '/../app/controllers/CartController.php';
        (new CartController($conn))->add();
        break;

    case '/cart/update':
        require_once __DIR__ . '/../app/controllers/CartController.php';
        (new CartController($conn))->update();
        break;

    case '/cart/remove':
        require_once __DIR__ . '/../app/controllers/CartController.php';
        (new CartController($conn))->remove();
        break;

    case '/checkout':
        require_once __DIR__ . '/../app/controllers/CheckoutController.php';
        (new CheckoutController($conn))->index();
        break;

    case '/checkout/process':
        require_once __DIR__ . '/../app/controllers/CheckoutController.php';
        (new CheckoutController($conn))->process();
        break;

    case '/orders/success':
        require_once __DIR__ . '/../app/controllers/OrderController.php';
        (new OrderController($conn))->success();
        break;

    case '/orders/cancel':
        require_once __DIR__ . '/../app/controllers/OrderController.php';
        (new OrderController($conn))->cancel();
        break;

    default:
        http_response_code(404);
        echo '<div style="font-family:sans-serif;text-align:center;padding:80px"><h1>404</h1><p>Page not found</p><a href="' . BASE_URL . '/">Go Home</a></div>';
        break;
}
