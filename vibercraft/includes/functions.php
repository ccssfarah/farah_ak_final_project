<?php
// Sanitize raw inputs
function sanitize($conn, $data) {
    return mysqli_real_escape_string($conn, trim(htmlspecialchars($data)));
}

// Generate pre-filled WhatsApp link
function get_whatsapp_link($phone, $message) {
    $encoded_msg = urlencode($message);
    return "https://wa.me/" . preg_replace('/[^0-9]/', '', $phone) . "?text=" . $encoded_msg;
}

// Format prices nicely
function format_price($amount) {
    return "$" . number_format($amount, 2);
}
?>