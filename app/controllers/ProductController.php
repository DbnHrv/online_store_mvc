<?php
class ProductController {
    private $productModel;

    public function __construct($conn) {
        $this->productModel = new Product($conn);
    }

    public function index() {
        $products = $this->productModel->getAllProducts();
        include __DIR__ . '/../views/products/index.php';
    }
}
