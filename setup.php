<?php
// Database setup script
$host = 'localhost';
$username = 'root';
$password = '';

try {
    // Connect to MySQL server
    $pdo = new PDO("mysql:host=$host", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
    // Create database if it doesn't exist
    $pdo->exec("CREATE DATABASE IF NOT EXISTS purchase_tracker");
    echo "Database 'purchase_tracker' created or already exists.<br>";
    
    // Connect to the database
    $pdo = new PDO("mysql:host=$host;dbname=purchase_tracker", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
    // Create users table
    $pdo->exec("CREATE TABLE IF NOT EXISTS users (
        id INT AUTO_INCREMENT PRIMARY KEY,
        username VARCHAR(50) NOT NULL UNIQUE,
        password VARCHAR(255) NOT NULL,
        created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
    )");
    echo "Table 'users' created or already exists.<br>";
    
    // Create purchases table
    $pdo->exec("CREATE TABLE IF NOT EXISTS purchases (
        id INT AUTO_INCREMENT PRIMARY KEY,
        user_id INT NOT NULL,
        product VARCHAR(255) NOT NULL,
        amount DECIMAL(10,2) NOT NULL,
        value DECIMAL(10,2) NOT NULL,
        receipt_path VARCHAR(255),
        purchase_date DATE NOT NULL,
        created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
        FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE
    )");
    echo "Table 'purchases' created or already exists.<br>";
    
    // Check if admin user exists, if not create one
    $stmt = $pdo->prepare("SELECT COUNT(*) FROM users WHERE username = 'admin'");
    $stmt->execute();
    if ($stmt->fetchColumn() == 0) {
        $hashedPassword = password_hash('admin123', PASSWORD_DEFAULT);
        $stmt = $pdo->prepare("INSERT INTO users (username, password) VALUES ('admin', ?)");
        $stmt->execute([$hashedPassword]);
        echo "Admin user created with username 'admin' and password 'admin123'.<br>";
    } else {
        echo "Admin user already exists.<br>";
    }
    
    // Create uploads directory if it doesn't exist
    if (!is_dir('uploads')) {
        mkdir('uploads', 0755, true);
        echo "Uploads directory created.<br>";
    } else {
        echo "Uploads directory already exists.<br>";
    }
    
    echo "<br>Setup completed successfully!<br>";
    echo "<a href='login.php'>Go to Login Page</a>";
    
} catch(PDOException $e) {
    die("Error: " . $e->getMessage());
}
?>
