<?php

$statusMsg = '';
if (isset($_FILES["cvResume"]["name"])) {
    $name = $_POST['name'];
    $email = $_POST['email'];
    $contactNum = $_POST['contactNum'];
    $jobVacancy = $_POST['jobVacancy'];
    $jobLocation = $_POST['jobLocation'];

    $fromemail =  $email;
    $subject = "Submitted CV";
    $email_message = '<h2>CV Submitted</h2>
                    <p><b>Name:</b> ' . $name . '</p>
                    <p><b>Email:</b> ' . $email . '</p>
                    <p><b>Contact #:</b> ' . $contactNum . '</p>
                    <p><b>Job Vacancy:</b> ' . $jobVacancy . '</p>
                    <p><b>Job Location:</b> ' . $jobLocation . '</p>';

    $email_message .= "Please find the attachment";
    $semi_rand = md5(uniqid(time()));
    $headers = "From: " . $fromemail;
    $mime_boundary = "==Multipart_Boundary_x{$semi_rand}x";

    $headers .= "\nMIME-Version: 1.0\n" .
        "Content-Type: multipart/mixed;\n" .
        " boundary=\"{$mime_boundary}\"";

    if ($_FILES["cvResume"]["name"] != "") {
        $strFilesName = $_FILES["cvResume"]["name"];
        $strContent = chunk_split(base64_encode(file_get_contents($_FILES["cvResume"]["tmp_name"])));

        $email_message .= "This is a multi-part message in MIME format.\n\n" .
            "--{$mime_boundary}\n" .
            "Content-Type:text/html; charset=\"iso-8859-1\"\n" .
            "Content-Transfer-Encoding: 7bit\n\n" .
            $email_message .= "\n\n";

        $email_message .= "--{$mime_boundary}\n" .
            "Content-Type: application/octet-stream;\n" .
            " name=\"{$strFilesName}\"\n" .
            "Content-Transfer-Encoding: base64\n\n" .
            $strContent  .= "\n\n" .
            "--{$mime_boundary}--\n";
    }

    $toemail = "info@craftsols.com";

    if (mail($toemail, $subject, $email_message, $headers)) {
        $statusMsg = "Email send successfully with attachment";
    } else {
        $statusMsg = "Not sent";
    }
}
echo '<script type="text/javascript">
            window.location.href = "https://craftsols.com/careers.html";
            alert("' . $statusMsg . '"); </script>';
