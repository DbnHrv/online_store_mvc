<?php
class Cart {
    public function add($product_id, $qty) {
        $product_id = (int)$product_id;
        $qty = max(1, (int)$qty);
        if (isset($_SESSION['cart'][$product_id]))
            $_SESSION['cart'][$product_id] += $qty;
        else
            $_SESSION['cart'][$product_id] = $qty;
    }

    public function update($product_id, $qty) {
        $product_id = (int)$product_id;
        $qty = (int)$qty;
        if ($qty <= 0) $this->remove($product_id);
        else $_SESSION['cart'][$product_id] = $qty;
    }

    public function remove($product_id) {
        unset($_SESSION['cart'][(int)$product_id]);
    }

    public function getCart() {
        return $_SESSION['cart'] ?? [];
    }

    public function count() {
        return array_sum($_SESSION['cart'] ?? []);
    }

    public function clear() {
        unset($_SESSION['cart']);
    }
}
