<?php

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    // Get and sanitize form inputs
    $name     = strip_tags(trim($_POST["name"] ?? ""));
    $name     = str_replace(["\r", "\n"], [" ", " "], $name);
    $phone    = trim($_POST["phone"] ?? "");
    $address  = trim($_POST["address"] ?? "");
    $quantity = trim($_POST["quantity"] ?? "");
    $product  = trim($_POST["product"] ?? "");
    $language = $_POST["language"] ?? "en"; // default language

    // Validate required fields
    if (empty($name) || empty($phone) || empty($address) ) {
        http_response_code(400);
        echo ($language === "ar") 
            ? "من فضلك أكمل البيانات بشكل صحيح وحاول مرة أخرى." 
            : "Please complete the form correctly and try again.";
        exit;
    }

    // Set recipient email
    $recipient = "gebraielmalak63@gmail.com";

    // Build the email subject and content based on language
    if ($language === "ar") {
        $subject = "رسالة جديدة من $name";
        $email_content = "/// Johanspond \\\\\n\n";
        $email_content .= "الاسم: $name\n";
        $email_content .= "البريد الإلكتروني: $email\n";
        $email_content .= "رقم الهاتف: $phone\n";
        $email_content .= "العنوان: $address\n";
        if (!empty($quantity)) {
            $email_content .= "الكمية: $quantity\n";
        }
        if (!empty($product)) {
            $email_content .= "المنتج: $product\n";
        }
    } else {
        $subject = "New message from $name";
        $email_content = "/// Johanspond \\\\\n\n";
        $email_content .= "Name: $name\n";
        $email_content .= "Email: $email\n";
        $email_content .= "Phone: $phone\n";
        $email_content .= "Address: $address\n";
        if (!empty($quantity)) {
            $email_content .= "Quantity: $quantity\n";
        }
        if (!empty($product)) {
            $email_content .= "Product: $product\n";
        }
    }

    // Build the email headers
    $email_headers = "From: $name <$email>";

    // Send the email
    if (mail($recipient, $subject, $email_content, $email_headers)) {
        http_response_code(200);
        echo ($language === "ar") 
            ? "✅ تم إرسال الرسالة بنجاح!" 
            : "✅ Your message has been sent successfully!";
    } else {
        http_response_code(500);
        echo ($language === "ar") 
            ? "❌ حدث خطأ أثناء الإرسال. حاول مرة أخرى لاحقًا." 
            : "❌ Something went wrong. Please try again later.";
    }

} else {
    // Not a POST request
    http_response_code(403);
    echo "Forbidden.";
}
