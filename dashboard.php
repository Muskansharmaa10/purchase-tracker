<?php
require_once 'db.php';
require_once 'session.php';

// Require login
requireLogin();

// Get user's purchases
try {
    $stmt = $pdo->prepare("
        SELECT * FROM purchases 
        WHERE user_id = ? 
        ORDER BY purchase_date DESC
    ");
    $stmt->execute([getCurrentUserId()]);
    $purchases = $stmt->fetchAll();
    
    // Calculate totals
    $totalAmount = 0;
    $totalValue = 0;
    foreach ($purchases as $purchase) {
        $totalAmount += $purchase['amount'];
        $totalValue += $purchase['value'];
    }
} catch (PDOException $e) {
    setFlashMessage('error', 'Error fetching purchases: ' . $e->getMessage());
    $purchases = [];
    $totalAmount = 0;
    $totalValue = 0;
}

// Handle delete request via GET (for simplicity)
if (isset($_GET['delete']) && is_numeric($_GET['delete'])) {
    $purchaseId = $_GET['delete'];
    
    try {
        // Get the receipt path before deleting
        $stmt = $pdo->prepare("SELECT receipt_path FROM purchases WHERE id = ? AND user_id = ?");
        $stmt->execute([$purchaseId, getCurrentUserId()]);
        $purchase = $stmt->fetch();
        
        if ($purchase) {
            // Delete the purchase
            $stmt = $pdo->prepare("DELETE FROM purchases WHERE id = ? AND user_id = ?");
            $stmt->execute([$purchaseId, getCurrentUserId()]);
            
            // Delete the receipt file if it exists
            if (!empty($purchase['receipt_path']) && file_exists($purchase['receipt_path'])) {
                unlink($purchase['receipt_path']);
            }
            
            setFlashMessage('success', 'Purchase deleted successfully!');
        } else {
            setFlashMessage('error', 'Purchase not found or you do not have permission to delete it.');
        }
    } catch (PDOException $e) {
        setFlashMessage('error', 'Error deleting purchase: ' . $e->getMessage());
    }
    
    // Redirect to refresh the page
    header("Location: dashboard.php");
    exit;
}

// Get flash message
$flash = getFlashMessage();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard - Purchase Tracker</title>
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
            <?php if ($flash): ?>
                <div class="alert alert-<?php echo $flash['type']; ?>">
                    <?php echo $flash['message']; ?>
                </div>
            <?php endif; ?>
            
            <div class="dashboard-summary">
                <div class="summary-card">
                    <h3>Total Purchases</h3>
                    <p class="summary-value"><?php echo count($purchases); ?></p>
                </div>
                <div class="summary-card">
                    <h3>Total Amount</h3>
                    <p class="summary-value"><?php echo number_format($totalAmount, 2); ?></p>
                </div>
                <div class="summary-card">
                    <h3>Total Value</h3>
                    <p class="summary-value">$<?php echo number_format($totalValue, 2); ?></p>
                </div>
            </div>
            
            <div class="dashboard-actions">
                <h2>Your Purchases</h2>
                <a href="add_item.php" class="btn btn-primary">Add New Purchase</a>
            </div>
            
            <?php if (empty($purchases)): ?>
                <div class="empty-state">
                    <p>You haven't added any purchases yet.</p>
                    <a href="add_item.php" class="btn btn-primary">Add Your First Purchase</a>
                </div>
            <?php else: ?>
                <div class="table-responsive">
                    <table class="purchases-table">
                        <thead>
                            <tr>
                                <th>Product</th>
                                <th>Amount</th>
                                <th>Value</th>
                                <th>Date</th>
                                <th>Receipt</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($purchases as $purchase): ?>
                                <tr>
                                    <td><?php echo htmlspecialchars($purchase['product']); ?></td>
                                    <td><?php echo number_format($purchase['amount'], 2); ?></td>
                                    <td>$<?php echo number_format($purchase['value'], 2); ?></td>
                                    <td><?php echo date('M d, Y', strtotime($purchase['purchase_date'])); ?></td>
                                    <td>
                                        <?php if (!empty($purchase['receipt_path'])): ?>
                                            <a href="<?php echo htmlspecialchars($purchase['receipt_path']); ?>" target="_blank" class="btn btn-sm btn-outline">View Receipt</a>
                                        <?php else: ?>
                                            <span class="text-muted">No receipt</span>
                                        <?php endif; ?>
                                    </td>
                                    <td class="actions">
                                        <a href="edit_item.php?id=<?php echo $purchase['id']; ?>" class="btn btn-sm btn-outline">Edit</a>
                                        <a href="dashboard.php?delete=<?php echo $purchase['id']; ?>" class="btn btn-sm btn-danger" onclick="return confirm('Are you sure you want to delete this purchase?')">Delete</a>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            <?php endif; ?>
        </main>
        
        <footer class="dashboard-footer">
            <p>&copy; <?php echo date('Y'); ?> Purchase Tracker. All rights reserved.</p>
        </footer>
    </div>
</body>
</html>
