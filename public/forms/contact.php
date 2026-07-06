<?php
// Contact-form endpoint for the home page (posted to by
// assets/vendor/php-email-form/validate.js, which requires the literal
// response "OK" on success). The recipient is fixed server-side so the
// endpoint can't be used to relay mail to arbitrary addresses.
$recipient = 'info@rayinfos.com';

$field = function ($key) {
    $v = isset($_POST[$key]) ? trim($_POST[$key]) : '';
    $v = strip_tags($v);
    return str_replace(["\r", "\n"], ' ', $v);
};

$name    = $field('name');
$email   = $field('email');
$subject = $field('subject');
$message = isset($_POST['message']) ? trim(strip_tags($_POST['message'])) : '';

if ($name === '' || !filter_var($email, FILTER_VALIDATE_EMAIL) || $message === '') {
    http_response_code(400);
    echo 'Please fill in your name, a valid e-mail address and a message.';
    exit;
}

if ($subject === '') {
    $subject = 'Contact form message from ' . $name;
}

$body = "Name: $name\nE-mail: $email\n\nMessage:\n$message\n";
$headers = "From: noreply@rayinfos.com\r\nReply-To: $email\r\n";

if (@mail($recipient, $subject, $body, $headers)) {
    echo 'OK';
} else {
    http_response_code(500);
    echo 'Unable to send the message right now. Please try again later.';
}
