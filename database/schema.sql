CREATE DATABASE IF NOT EXISTS online_store;
USE online_store;

CREATE TABLE IF NOT EXISTS users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100),
    email VARCHAR(100) UNIQUE,
    password VARCHAR(255),
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE IF NOT EXISTS products (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100),
    description TEXT,
    price DECIMAL(10,2),
    image VARCHAR(255),
    stock INT DEFAULT 100
);

CREATE TABLE IF NOT EXISTS orders (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT,
    total_amount DECIMAL(10,2),
    payment_status ENUM('pending','paid','failed') DEFAULT 'pending',
    payment_reference VARCHAR(255),
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY(user_id) REFERENCES users(id)
);

CREATE TABLE IF NOT EXISTS order_items (
    id INT AUTO_INCREMENT PRIMARY KEY,
    order_id INT,
    product_id INT,
    quantity INT,
    price DECIMAL(10,2),
    FOREIGN KEY(order_id) REFERENCES orders(id),
    FOREIGN KEY(product_id) REFERENCES products(id)
);

-- Demo user (password: password123)
INSERT IGNORE INTO users (id, name, email, password) VALUES
(1, 'Demo User', 'demo@example.com', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi');

-- Sample products
INSERT IGNORE INTO products (id, name, description, price, image, stock) VALUES
(1, 'Acoustic Guitar', 'Full-size acoustic guitar with spruce top and mahogany body.', 4500.00, 'acoustic_guitar.jpg', 20),
(2, 'Electric Guitar', 'Solid body electric guitar suitable for rock and blues.', 6500.00, 'electric_guitar.jpg', 15),
(3, 'Guitar Strings Set', 'Light gauge steel guitar strings for acoustic and electric guitars.', 350.00, 'guitar_strings.jpg', 100),
(4, 'Guitar Capo', 'Adjustable aluminum capo compatible with most guitars.', 250.00, 'guitar_capo.jpg', 80),
(5, 'Digital Guitar Tuner', 'Clip-on digital tuner with LCD display for accurate tuning.', 450.00, 'guitar_tuner.jpg', 60),
(6, 'Guitar Strap', 'Adjustable guitar strap with leather ends for durability.', 300.00, 'guitar_strap.jpg', 70),
(7, 'Keyboard Piano 61 Keys', 'Portable electronic keyboard with 61 keys and built-in speakers.', 5500.00, 'keyboard_piano.jpg', 10),
(8, 'Drum Sticks Pair', 'High-quality wooden drum sticks suitable for beginners and professionals.', 200.00, 'drumsticks.jpg', 120),
(9, 'Guitar Picks Pack', 'Pack of 10 assorted thickness guitar picks.', 150.00, 'guitar_picks.jpg', 150),
(10, 'Instrument Cable', '6-meter durable instrument cable for guitars and amplifiers.', 500.00, 'instrument_cable.jpg', 50);