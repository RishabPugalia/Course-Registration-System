<?php
// Process payment (this is just a placeholder for now)

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $payment_method = $_POST['payment_method'];

    // You would integrate your payment gateway here
    echo "<script>alert('Payment Successful!'); window.location.href='homepage.html';</script>";
} else {
    echo "<script>alert('Payment failed. Please try again.'); window.location.href='payment.html';</script>";
}
?>
