<?php

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $mail_to = "m.saleem.mourad@gmail.com";
    
    $name = str_replace(array("\r", "\n"), array(" ", " "), strip_tags(trim($_POST["name"])));
    $email = filter_var(trim($_POST["email"]), FILTER_SANITIZE_EMAIL);
    $message = trim($_POST["message"]);
    
    if (empty($name) OR !filter_var($email, FILTER_VALIDATE_EMAIL) OR empty($message)) {
        http_response_code(400);
        echo "Please complete the form and try again.";
        exit;
    }
    
    $content = "Name: $name\n";
    $content .= "Email: $email\n\n";
    $content .= "Message:\n$message\n";

    $headers = "From: $name <$email>\r\n";
    $headers .= "Reply-To: $email\r\n";
    $headers .= "Content-Type: text/plain; charset=UTF-8\r\n";

    $success = mail($mail_to, "Contact Form Submission", $content, $headers);
    if ($success) {
        http_response_code(200);
        echo "Thank You! Your message has been sent.";
    } else {
        http_response_code(500);
        echo "Oops! Something went wrong, we couldn't send your message.";
    }

} else {
    http_response_code(403);
    echo "There was a problem with your submission, please try again.";
}

?>
