<?php
session_start();
echo "<h1>Test Session</h1>";
echo "<pre>";
echo "Session ID: " . session_id() . "\n";
echo "User ID: " . (isset($_SESSION['userid']) ? $_SESSION['userid'] : "NON CONNECTÉ") . "\n";
echo "Panier: " . json_encode($_SESSION['cart'] ?? []) . "\n";
echo "\nToute la session:\n";
print_r($_SESSION);
echo "</pre>";
?>
