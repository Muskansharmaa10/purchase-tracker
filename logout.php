<?php
require_once 'session.php';

// Destroy the session
session_destroy();

// Redirect to login page
header("Location: login.php");
exit;
?>
