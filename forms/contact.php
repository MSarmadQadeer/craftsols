<?php

$statusMsg = '';

$name = $_POST['name'];
$organizationName = $_POST['organizationName'];
$email = $_POST['email'];
$contactNum = $_POST['contactNum'];
$subject = $_POST['subject'];
$message = $_POST['message'];

$fromemail =  $email;

$email_message = '<h3>' . $name . ' Filled Contact Us Form</h3>
                <p><b>Name:</b> ' . $name . '</p>
                <p><b>Organization Name:</b> ' . $organizationName . '</p>
                <p><b>Email:</b> ' . $email . '</p>
                <p><b>Contact #:</b> ' . $contactNum . '</p>
                <p><b>Subject:</b> ' . $subject . '</p>
                <p><b>Message:</b><br/>' . $message . '</p>';

$semi_rand = md5(uniqid(time()));
$headers = "From: " . $fromemail;
$mime_boundary = "==Multipart_Boundary_x{$semi_rand}x";

$headers .= "\nMIME-Version: 1.0\n" .
    "Content-Type: multipart/mixed;\n" .
    " boundary=\"{$mime_boundary}\"";

$email_message .= "This is a multi-part message in MIME format.\n\n" .
    "--{$mime_boundary}\n" .
    "Content-Type:text/html; charset=\"iso-8859-1\"\n" .
    "Content-Transfer-Encoding: 7bit\n\n" .
    $email_message .= "\n\n";

$toemail = "info@craftsols.com";

if (mail($toemail, $subject, $email_message, $headers)) {
    $statusMsg = "Email Sent successfully! We Will Contact You Shortly";
} else {
    $statusMsg = "Error in Sending! Please try again";
}

echo '<script type="text/javascript">
            window.location.href = "https://craftsols.com/contact.html";
            alert("' . $statusMsg . '"); </script>';
