<?php
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Process the form data and handle the file upload
    $uploadSuccess = false;

    // Save uploaded file
    if (isset($_FILES['payment_screenshot']) && $_FILES['payment_screenshot']['error'] == 0) {
        $uploadDir = 'uploads/';
        if (!file_exists($uploadDir)) {
            mkdir($uploadDir, 0777, true);
        }
        $uploadFile = $uploadDir . basename($_FILES['payment_screenshot']['name']);
        if (move_uploaded_file($_FILES['payment_screenshot']['tmp_name'], $uploadFile)) {
            // File is uploaded successfully
            $uploadSuccess = true;
        } else {
            // Handle error
            echo "Possible file upload attack!\n";
        }
    }

    // Process other form data
    $name = htmlspecialchars($_POST['name']);
    $address = htmlspecialchars($_POST['address']);
    $email = htmlspecialchars($_POST['email']);
    $phone = htmlspecialchars($_POST['phone']);
    $pickleTypes = $_POST['pickle_type'];
    $quantities = $_POST['quantity'];

    // Save order details to database or send email (example purposes)
    // For example, save order details to a file
    $orderDetails = "Name: $name\nAddress: $address\nEmail: $email\nPhone: $phone\n";
    foreach ($pickleTypes as $index => $pickleType) {
        $orderDetails .= "Pickle: $pickleType, Quantity: " . $quantities[$index] . "\n";
    }
    file_put_contents('orders.txt', $orderDetails, FILE_APPEND);

    // Display the thank-you message
    echo '<html><head><script>function showThankYouMessage() { document.getElementById("thank-you-message").style.display = "block"; }</script></head><body onload="showThankYouMessage()">';
    echo '<div id="thank-you-message" class="thank-you-message" style="display: block;">';
    echo '<h2>Thank you for your order!</h2>';
    echo '<p>You will receive it in 3 business days.</p>';
    echo '</div>';
    echo '</body></html>';
}
?>
