<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {

    // Determine which form is being submitted
    $form_type = isset($_POST['form_type']) ? $_POST['form_type'] : 'contact';

    // Recipient email
    $to = "office@fenamp.org";

    // Function to display a styled message
    function displayMessage($type, $text, $back_url) {
        $color = $type === 'success' ? '#4CAF50' : '#f44336';
        echo "
        <!DOCTYPE html>
        <html lang='en'>
        <head>
            <meta charset='UTF-8'>
            <meta name='viewport' content='width=device-width, initial-scale=1.0'>
            <title>Form Status</title>
            <style>
                body { background: #f4f7fa; font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
                       display: flex; align-items: center; justify-content: center; height: 100vh; margin: 0; }
                .message-box { background: white; border-radius: 10px; box-shadow: 0 4px 15px rgba(0,0,0,0.1);
                               padding: 40px; text-align: center; width: 90%; max-width: 400px; }
                h2 { color: $color; margin-bottom: 15px; }
                p { color: #555; margin-bottom: 25px; }
                a.button { display: inline-block; background: $color; color: white; text-decoration: none;
                           padding: 10px 20px; border-radius: 5px; transition: background 0.3s ease; }
                a.button:hover { background: " . ($type === 'success' ? '#45a049' : '#d32f2f') . "; }
            </style>
        </head>
        <body>
            <div class='message-box'>
                <h2>" . ucfirst($type) . "!</h2>
                <p>$text</p>
                <a href='$back_url' class='button'>Back</a>
            </div>
        </body>
        </html>
        ";
        exit;
    }

    if ($form_type == 'contact') {
        // Contact form fields
        $name    = htmlspecialchars(trim($_POST["name"]));
        $email   = htmlspecialchars(trim($_POST["email"]));
        $subject = htmlspecialchars(trim($_POST["subject"]));
        $message = htmlspecialchars(trim($_POST["message"]));

        $email_subject = "New Contact Form Submission: $subject";
        $email_body = "You have received a new message from your website contact form.\n\n".
                      "Name: $name\n".
                      "Email: $email\n".
                      "Subject: $subject\n\n".
                      "Message:\n$message";

        $headers  = "From: $name <$email>\r\n";
        $headers .= "Reply-To: $email\r\n";
        $headers .= "Content-Type: text/plain; charset=UTF-8\r\n";

        if(mail($to, $email_subject, $email_body, $headers)) {
            displayMessage('success', 'Your message has been sent successfully. We’ll get back to you soon!', 'contact.html');
        } else {
            displayMessage('error', 'Oops! Something went wrong. Please try again later.', 'contact.html');
        }

    } elseif ($form_type == 'membership') {
        // Membership form fields
        $fullName = htmlspecialchars(trim($_POST["fullName"]));
        $email    = htmlspecialchars(trim($_POST["email"]));
        $phone    = htmlspecialchars(trim($_POST["phone"]));
        $address  = htmlspecialchars(trim($_POST["address"]));

        $email_subject = "New Membership Registration";
        $email_body = "You have received a new membership registration.\n\n".
                      "Full Name: $fullName\n".
                      "Email: $email\n".
                      "Phone: $phone\n".
                      "Address: $address";

        $headers  = "From: $fullName <$email>\r\n";
        $headers .= "Reply-To: $email\r\n";
        $headers .= "Content-Type: text/plain; charset=UTF-8\r\n";

        if(mail($to, $email_subject, $email_body, $headers)) {
            displayMessage('success', 'Your membership registration has been sent successfully!', 'membership-form.html');
        } else {
            displayMessage('error', 'Oops! Something went wrong. Please try again later.', 'membership-form.html');
        }
    } else {
        displayMessage('error', 'Invalid form submission.', 'index.html');
    }

} else {
    echo "Invalid request.";
}
?>
