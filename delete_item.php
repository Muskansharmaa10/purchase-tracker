<?php
require_once 'db.php';
require_once 'session.php';

// Require login
requireLogin();

// Get purchase ID from URL
$purchaseId = isset($_GET['id']) ? (int)$_GET['id'] : 0;

if ($purchaseId <= 0) {
    setFlashMessage('error', 'Invalid purchase ID');
    header("Location: dashboard.php");
    exit;
}

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

// Redirect back to dashboard
header("Location: dashboard.php");
exit;
?>
