<?php
header("Content-Type: application/json");
header("Access-Control-Allow-Origin: *");


function sendEmail($name, $email, $phone, $message)
{
    $to = "your email";
    $subject = "New Form Submission";
    $headers = "From: $email\r\n";
    $headers .= "Reply-To: $email\r\n";

    $mailBody = "Name: $name\n";
    $mailBody .= "Email: $email\n";
    $mailBody .= "Phone: $phone\n";
    $mailBody .= "Message: \n$message\n";

    return mail($to, $subject, $mailBody, $headers);
}

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $name = $_POST["name"] ?? "";
    $email = $_POST["email"] ?? "";
    $phone = $_POST["phone"] ?? "";
    $message = $_POST["message"] ?? "";

    if (empty($name) || empty($email) || empty($phone) || empty($message)) {
        http_response_code(400);
        echo json_encode(["error" => "Incomplete data"]);
        exit;
    }

    $emailSent = sendEmail($name, $email, $phone, $message);

    if ($emailSent) {
        echo json_encode(["success" => "Email sent successfully"]);
    } else {
        http_response_code(500);
        echo json_encode(["error" => "Failed to send email"]);
    }
} else {
    http_response_code(405);
    echo json_encode(["error" => "Method Not Allowed"]);
}
