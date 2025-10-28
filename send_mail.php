<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Sanitize form inputs
    $name    = htmlspecialchars(trim($_POST["name"]));
    $email   = htmlspecialchars(trim($_POST["email"]));
    $subject = htmlspecialchars(trim($_POST["subject"]));
    $message = htmlspecialchars(trim($_POST["message"]));

    // Recipient email
    $to = "office@fenamp.org";

    // Email subject
    $email_subject = "New Contact Form Submission: $subject";

    // Email body
    $email_body = "
    You have received a new message from your website contact form.

    Name: $name
    Email: $email
    Subject: $subject

    Message:
    $message
    ";

    // Email headers
    $headers  = "From: $name <$email>\r\n";
    $headers .= "Reply-To: $email\r\n";
    $headers .= "Content-Type: text/plain; charset=UTF-8\r\n";

    // Function to display a styled message
    function displayMessage($type, $text) {
        $color = $type === 'success' ? '#4CAF50' : '#f44336';
        echo "
        <!DOCTYPE html>
        <html lang='en'>
        <head>
            <meta charset='UTF-8'>
            <meta name='viewport' content='width=device-width, initial-scale=1.0'>
            <title>Contact Form Status</title>
            <style>
                body {
                    background: #f4f7fa;
                    font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
                    display: flex;
                    align-items: center;
                    justify-content: center;
                    height: 100vh;
                    margin: 0;
                }
                .message-box {
                    background: white;
                    border-radius: 10px;
                    box-shadow: 0 4px 15px rgba(0,0,0,0.1);
                    padding: 40px;
                    text-align: center;
                    width: 90%;
                    max-width: 400px;
                }
                h2 {
                    color: $color;
                    margin-bottom: 15px;
                }
                p {
                    color: #555;
                    margin-bottom: 25px;
                }
                a.button {
                    display: inline-block;
                    background: $color;
                    color: white;
                    text-decoration: none;
                    padding: 10px 20px;
                    border-radius: 5px;
                    transition: background 0.3s ease;
                }
                a.button:hover {
                    background: " . ($type === 'success' ? '#45a049' : '#d32f2f') . ";
                }
            </style>
        </head>
        <body>
            <div class='message-box'>
                <h2>" . ucfirst($type) . "!</h2>
                <p>$text</p>
                <a href='contact.html' class='button'>Back to Contact Page</a>
            </div>
        </body>
        </html>
        ";
    }

    // Send the email
    if (mail($to, $email_subject, $email_body, $headers)) {
        displayMessage('success', 'Your message has been sent successfully. We’ll get back to you soon!');
    } else {
        displayMessage('error', 'Oops! Something went wrong. Please try again later.');
    }
} else {
    echo "Invalid request.";
}
?>
