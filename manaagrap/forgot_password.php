<?php
require 'db.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST['email'];

    // For demonstration purposes, we just show a success message.
    echo "If this email is registered, a password reset link will be sent.
    *For demonstration purpuses only, this instance isn't designed to handle password recovery*";
}
?>