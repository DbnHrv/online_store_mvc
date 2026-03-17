<?php
class Order {
    private $conn;

    public function __construct($conn) {
        $this->conn = $conn;
    }

    public function create($user_id, $total, $cart) {
        $status = 'pending';
        $stmt = $this->conn->prepare("INSERT INTO orders (user_id, total_amount, payment_status) VALUES (?,?,?)");
        $stmt->bind_param("ids", $user_id, $total, $status);
        $stmt->execute();
        $order_id = $stmt->insert_id;

        foreach ($cart as $id => $qty) {
            $id = (int)$id;
            $product = $this->conn->query("SELECT price FROM products WHERE id=$id")->fetch_assoc();
            $price = $product['price'];
            $stmt2 = $this->conn->prepare("INSERT INTO order_items (order_id, product_id, quantity, price) VALUES (?,?,?,?)");
            $stmt2->bind_param("iiid", $order_id, $id, $qty, $price);
            $stmt2->execute();
        }
        return $order_id;
    }

    public function updatePaymentStatus($order_id, $status, $reference = '') {
        $stmt = $this->conn->prepare("UPDATE orders SET payment_status=?, payment_reference=? WHERE id=?");
        $stmt->bind_param("ssi", $status, $reference, $order_id);
        $stmt->execute();
    }

    public function getOrderById($order_id) {
        $stmt = $this->conn->prepare("SELECT * FROM orders WHERE id=?");
        $stmt->bind_param("i", $order_id);
        $stmt->execute();
        return $stmt->get_result()->fetch_assoc();
    }

    public function getOrderItems($order_id) {
        $stmt = $this->conn->prepare(
            "SELECT oi.*, p.name, p.image FROM order_items oi 
             JOIN products p ON oi.product_id = p.id 
             WHERE oi.order_id=?"
        );
        $stmt->bind_param("i", $order_id);
        $stmt->execute();
        return $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
    }
}
