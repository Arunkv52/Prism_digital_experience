<?php

if (isset($_POST['submit'])) {

    // Retrieve form data
    $name = $_POST["name"];
    $companyname = $_POST["companyname"];
    $email = $_POST["email"];
    $tel_num = $_POST["tel_num"];
    $checkbox = $_POST["checkbox"];

    $to = 'digital@prismadverto.net';
    $subject = 'Enquiry From Digital Experience';
    $message = "Name: $name\nEmail: $email\nCompany Name: $companyname\nMobile Number: $tel_num\nServices Need: $checkbox";

    // Add CC email here
    $cc = 'digital@prismadverto.net'; // Replace 'ccemail@example.com' with the actual CC email address

    $headers = "From: $to\r\n";
    $headers .= "Reply-To: $to\r\n";
    // Append CC to headers
    $headers .= "Cc: $cc\r\n";

    if ($name == "" || $companyname == "" || $email == "" || $tel_num == "" || $checkbox == "") {
        echo "<script type=\"text/javascript\">alert('Error1.');window.location='index.html'</script>";
    } else {

        // Verify reCAPTCHA
        $recaptchaSecretKey = "6Lf-2nMpAAAAADjz-Hs-iHafToXDCifTJViptTOf"; // Replace with your Secret Key

        $recaptchaResponse = $_POST["g-recaptcha-response"];

        // Send a POST request to Google reCAPTCHA API for verification
        $recaptchaVerificationUrl = "https://www.google.com/recaptcha/api/siteverify";
        $recaptchaData = [
            'secret' => $recaptchaSecretKey,
            'response' => $recaptchaResponse,
        ];

        $recaptchaOptions = [
            'http' => [
                'method' => 'POST',
                'content' => http_build_query($recaptchaData),
            ],
        ];

        $recaptchaContext = stream_context_create($recaptchaOptions);
        $recaptchaResult = file_get_contents($recaptchaVerificationUrl, false, $recaptchaContext);
        $recaptchaResultJson = json_decode($recaptchaResult);

        if ($recaptchaResultJson && $recaptchaResultJson->success) {
            if (mail($to, $subject, $message, $headers)) {
                // Success message with redirection
                echo "<div class='success_message'>Thank you for submitting form</div>";
                echo '<script>
                setTimeout(function() {
                    window.location = "index.html"; //redirect page
                }, 4000); // 3000 milliseconds (3 seconds) delay before redirecting
              </script>';
            } else {
                // Failure message with redirection
                echo "<div class='text-danger'>Failed to sending mail</div>";
                echo '<script>
                setTimeout(function() {
                    window.location = "index.html"; //redirect page
                }, 4000); // 3000 milliseconds (3 seconds) delay before redirecting
              </script>';
            }
        } else {
            // reCAPTCHA verification failed message with redirection
            echo "<div class='text-danger'>reCAPTCHA verification failed. Please try again.</div>";
            echo '<script>
                setTimeout(function() {
                    window.location = "index.html"; //redirect pathge
                }, 4000); // 3000 milliseconds (3 seconds) delay before redirecting
              </script>';
        }
    }
} else {
    // Error message for direct script access without POST submission
    echo "<script type=\"text/javascript\">alert('Error 3.');window.location='index.html'</script>";
}
?>

