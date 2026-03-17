<?php
class CartController {
    private $cart;
    private $productModel;

    public function __construct($conn) {
        $this->cart = new Cart();
        $this->productModel = new Product($conn);
    }

    public function add() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $this->cart->add($_POST['product_id'], $_POST['quantity'] ?? 1);
        }
        header("Location: " . BASE_URL . "/cart");
        exit;
    }

    public function update() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $this->cart->update($_POST['product_id'], $_POST['quantity']);
        }
        header("Location: " . BASE_URL . "/cart");
        exit;
    }

    public function remove() {
        $this->cart->remove($_GET['product_id'] ?? 0);
        header("Location: " . BASE_URL . "/cart");
        exit;
    }

    public function view() {
        $cart = new Cart();
        $cart_items = $cart->getCart();
        $productModel = $this->productModel;
        include __DIR__ . '/../views/cart/cart.php';
    }
}
