<?php
class OrderController {
    private $order;
    private $conn;

    public function __construct($conn) {
        $this->conn = $conn;
        $this->order = new Order($conn);
    }

    public function success() {
        $order_id = (int)($_GET['order_id'] ?? 0);
        if (!$order_id) {
            header("Location: " . BASE_URL . "/");
            exit;
        }

        // Verify payment with PayMongo
        $session_id = $_SESSION['paymongo_session_id'] ?? null;
        if ($session_id) {
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, "https://api.paymongo.com/v1/checkout_sessions/$session_id");
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_USERPWD, PAYMONGO_SECRET . ":");
            curl_setopt($ch, CURLOPT_HTTPHEADER, ["Accept: application/json"]);
            $response = curl_exec($ch);
            curl_close($ch);
            $result = json_decode($response, true);
            $pm_status = $result['data']['attributes']['payment_status'] ?? 'unpaid';
            if ($pm_status === 'paid') {
                $ref = $result['data']['id'];
                $this->order->updatePaymentStatus($order_id, 'paid', $ref);
            }
            unset($_SESSION['paymongo_session_id']);
            unset($_SESSION['pending_order_id']);
        }

        $order = $this->order->getOrderById($order_id);
        $order_items = $this->order->getOrderItems($order_id);
        include __DIR__ . '/../views/orders/success.php';
    }

    public function cancel() {
        $order_id = (int)($_GET['order_id'] ?? 0);
        if ($order_id) {
            $this->order->updatePaymentStatus($order_id, 'failed');
        }
        include __DIR__ . '/../views/orders/cancel.php';
    }
}
