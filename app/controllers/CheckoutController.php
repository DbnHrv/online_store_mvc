<?php
class CheckoutController {
    private $cart;
    private $order;
    private $conn;

    public function __construct($conn) {
        $this->conn = $conn;
        $this->cart = new Cart();
        $this->order = new Order($conn);
    }

    public function index() {
        $cart = new Cart();
        $cart_items = $cart->getCart();
        if (empty($cart_items)) {
            header("Location: " . BASE_URL . "/cart");
            exit;
        }
        $total = 0;
        $items = [];
        foreach ($cart_items as $id => $qty) {
            $id = (int)$id;
            $product = $this->conn->query("SELECT * FROM products WHERE id=$id")->fetch_assoc();
            $subtotal = $product['price'] * $qty;
            $total += $subtotal;
            $items[] = ['product' => $product, 'qty' => $qty, 'subtotal' => $subtotal];
        }
        include __DIR__ . '/../views/checkout/checkout.php';
    }

    public function process() {
        $cart_items = $this->cart->getCart();
        if (empty($cart_items)) {
            header("Location: " . BASE_URL . "/cart");
            exit;
        }

        $total = 0;
        $line_items = [];
        foreach ($cart_items as $id => $qty) {
            $id = (int)$id;
            $product = $this->conn->query("SELECT * FROM products WHERE id=$id")->fetch_assoc();
            $subtotal = $product['price'] * $qty;
            $total += $subtotal;
            $line_items[] = [
                "name" => $product['name'],
                "amount" => (int)round($product['price'] * 100),
                "currency" => "PHP",
                "quantity" => (int)$qty
            ];
        }

        $user_id = $_SESSION['user_id'] ?? 1;
        $order_id = $this->order->create($user_id, $total, $cart_items);

        $data = [
            "data" => [
                "attributes" => [
                    "line_items" => $line_items,
                    "payment_method_types" => ["gcash", "card"],
                    "success_url" => BASE_URL . "/orders/success?order_id=$order_id",
                    "cancel_url" => BASE_URL . "/orders/cancel?order_id=$order_id",
                    "description" => "Order #$order_id from Online Store"
                ]
            ]
        ];

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, "https://api.paymongo.com/v1/checkout_sessions");
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_USERPWD, PAYMONGO_SECRET . ":");
        curl_setopt($ch, CURLOPT_HTTPHEADER, ["Content-Type: application/json", "Accept: application/json"]);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, true);
        $response = curl_exec($ch);
        $http_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        curl_close($ch);

        $result = json_decode($response, true);

        if ($http_code === 200 && isset($result['data']['attributes']['checkout_url'])) {
            // Store session ID for webhook verification
            $_SESSION['paymongo_session_id'] = $result['data']['id'];
            $_SESSION['pending_order_id'] = $order_id;
            $this->cart->clear();
            header("Location: " . $result['data']['attributes']['checkout_url']);
            exit;
        } else {
            $error = $result['errors'][0]['detail'] ?? 'Payment initialization failed.';
            $_SESSION['checkout_error'] = $error;
            // Rollback order on failure
            $this->order->updatePaymentStatus($order_id, 'failed');
            header("Location: " . BASE_URL . "/checkout");
            exit;
        }
    }
}
