<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = htmlspecialchars($_POST['name']);
    $visitor_email = htmlspecialchars($_POST['email']);
    $subject = htmlspecialchars($_POST['subject']);
    $message = htmlspecialchars($_POST['message']);
    $captcha = $_POST['g-recaptcha-response'];

    $secretKey = "YOUR_SECRET_KEY";
    $ip = $_SERVER['REMOTE_ADDR'];
    $url = "https://www.google.com/recaptcha/api/siteverify?secret=$secretKey&response=$captcha&remoteip=$ip";
    $response = file_get_contents($url);
    $responseKeys = json_decode($response, true);

    if (intval($responseKeys["success"]) !== 1) {
        echo "Please complete the CAPTCHA.";
    } else {
        $email_from = 'manasluedu8@gmail.com';
        $email_subject = 'New Form Submission';
        $email_body = "User Name: $name\n".
                      "User Email: $visitor_email\n".
                      "Subject: $subject\n".
                      "User Message: $message\n";

        $to = 'manasluedu8@gmail.com';
        $headers = "From: $email_from\r\n";
        $headers .= "Reply-To: $visitor_email\r\n";

        if (mail($to, $email_subject, $email_body, $headers)) {
            header("Location: contacts.html");
        } else {
            echo "Email sending failed.";
        }
    }
} else {
    echo "Invalid request method.";
}
?>
