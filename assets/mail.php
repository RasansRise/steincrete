<?php

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    // Sanitize and get the form fields
    $name = strip_tags(trim($_POST["name"]));
    $name = str_replace(array("\r", "\n"), array(" ", " "), $name);

    $phone = trim($_POST["phone"]);
    $address = trim($_POST["address"]);
    $quantity = trim($_POST["quantity"]);
    $product = trim($_POST["product"]);

    // Check required fields
    if (empty($name) || empty($phone) || empty($address) || empty($product)) {
        http_response_code(400);
        echo "Please fill in all the required fields and try again.";
        exit;
    }

    // Email recipient
    $recipient = "gebraielmalak63@gmail.com";

    // Email subject
    $subject = "New Order from $name";

    // Email content
    $email_content  = "/// New Order Received ///\n\n";
    $email_content .= "Name: $name\n";
    $email_content .= "Phone: $phone\n";
    $email_content .= "Address: $address\n";
    $email_content .= "Product: $product\n";
    $email_content .= "Quantity: $quantity\n";

    // Email headers
    $email_headers = "From: Website Order <no-reply@example.com>";

    // Send the email
    if (mail($recipient, $subject, $email_content, $email_headers)) {
        http_response_code(200);
        echo "Thank you! Your order has been sent successfully.";
    } else {
        http_response_code(500);
        echo "Oops! Something went wrong and we couldn't send your order.";
    }

} else {
    http_response_code(403);
    echo "There was a problem with your submission. Please try again.";
}
?>
