<?php
require_once 'db.php';
require_once 'session.php';

// Require login
requireLogin();

$error = '';
$success = '';

// Process form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $product = $_POST['product'] ?? '';
    $amount = $_POST['amount'] ?? '';
    $value = $_POST['value'] ?? '';
    $purchaseDate = $_POST['purchase_date'] ?? '';
    
    // Validate inputs
    if (empty($product) || empty($amount) || empty($value) || empty($purchaseDate)) {
        $error = "Please fill in all required fields";
    } elseif (!is_numeric($amount) || $amount <= 0) {
        $error = "Amount must be a positive number";
    } elseif (!is_numeric($value) || $value <= 0) {
        $error = "Value must be a positive number";
    } else {
        // Handle file upload
        $receiptPath = null;
        if (isset($_FILES['receipt']) && $_FILES['receipt']['error'] === UPLOAD_ERR_OK) {
            $uploadDir = 'uploads/';
            
            // Create uploads directory if it doesn't exist
            if (!is_dir($uploadDir)) {
                mkdir($uploadDir, 0755, true);
            }
            
            // Generate unique filename
            $fileName = uniqid() . '_' . basename($_FILES['receipt']['name']);
            $uploadFile = $uploadDir . $fileName;
            
            // Check file type
            $allowedTypes = ['image/jpeg', 'image/png', 'image/gif', 'application/pdf'];
            $fileType = $_FILES['receipt']['type'];
            
            if (!in_array($fileType, $allowedTypes)) {
                $error = "Invalid file type. Only JPG, PNG, GIF, and PDF files are allowed.";
            } elseif ($_FILES['receipt']['size'] > 5000000) { // 5MB limit
                $error = "File is too large. Maximum size is 5MB.";
            } elseif (move_uploaded_file($_FILES['receipt']['tmp_name'], $uploadFile)) {
                $receiptPath = $uploadFile;
            } else {
                $error = "Failed to upload file.";
            }
        }
        
        if (empty($error)) {
            try {
                // Insert purchase into database
                $stmt = $pdo->prepare("
                    INSERT INTO purchases (user_id, product, amount, value, receipt_path, purchase_date) 
                    VALUES (?, ?, ?, ?, ?, ?)
                ");
                $stmt->execute([
                    getCurrentUserId(),
                    $product,
                    $amount,
                    $value,
                    $receiptPath,
                    $purchaseDate
                ]);
                
                setFlashMessage('success', 'Purchase added successfully!');
                header("Location: dashboard.php");
                exit;
            } catch (PDOException $e) {
                $error = "Database error: " . $e->getMessage();
                
                // Delete uploaded file if there was an error
                if ($receiptPath && file_exists($receiptPath)) {
                    unlink($receiptPath);
                }
            }
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Purchase - Purchase Tracker</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
    <div class="dashboard-container">
        <header class="dashboard-header">
            <div class="logo">
                <h1>Purchase Tracker</h1>
            </div>
            <div class="user-info">
                <span>Welcome, <?php echo htmlspecialchars(getCurrentUsername()); ?></span>
                <a href="logout.php" class="btn btn-outline">Logout</a>
            </div>
        </header>
        
        <main class="dashboard-content">
            <div class="page-header">
                <h2>Add New Purchase</h2>
                <a href="dashboard.php" class="btn btn-outline">Back to Dashboard</a>
            </div>
            
            <?php if (!empty($error)): ?>
                <div class="alert alert-danger"><?php echo $error; ?></div>
            <?php endif; ?>
            
            <div class="form-container">
                <form method="post" enctype="multipart/form-data" class="purchase-form">
                    <div class="form-group">
                        <label for="product">Product Name*</label>
                        <input type="text" id="product" name="product" required value="<?php echo isset($_POST['product']) ? htmlspecialchars($_POST['product']) : ''; ?>">
                    </div>
                    
                    <div class="form-row">
                        <div class="form-group">
                            <label for="amount">Amount*</label>
                            <input type="number" id="amount" name="amount" step="0.01" min="0.01" required value="<?php echo isset($_POST['amount']) ? htmlspecialchars($_POST['amount']) : ''; ?>">
                        </div>
                        
                        <div class="form-group">
                            <label for="value">Value ($)*</label>
                            <input type="number" id="value" name="value" step="0.01" min="0.01" required value="<?php echo isset($_POST['value']) ? htmlspecialchars($_POST['value']) : ''; ?>">
                        </div>
                    </div>
                    
                    <div class="form-group">
                        <label for="purchase_date">Purchase Date*</label>
                        <input type="date" id="purchase_date" name="purchase_date" required value="<?php echo isset($_POST['purchase_date']) ? htmlspecialchars($_POST['purchase_date']) : date('Y-m-d'); ?>">
                    </div>
                    
                    <div class="form-group">
                        <label for="receipt">Receipt (Optional)</label>
                        <input type="file" id="receipt" name="receipt" accept=".jpg,.jpeg,.png,.gif,.pdf">
                        <small class="form-text">Upload a receipt image or PDF (max 5MB)</small>
                    </div>
                    
                    <div class="form-actions">
                        <button type="submit" class="btn btn-primary">Add Purchase</button>
                        <a href="dashboard.php" class="btn btn-outline">Cancel</a>
                    </div>
                </form>
            </div>
        </main>
        
        <footer class="dashboard-footer">
            <p>&copy; <?php echo date('Y'); ?> Purchase Tracker. All rights reserved.</p>
        </footer>
    </div>
</body>
</html>
