<?php
// Contact-form endpoint (posted to by js/forms.js).
// The old site's version was a stub that only echoed "success"; this one
// actually delivers the mail. The recipient is fixed server-side — the
// owner_email POST field is deliberately ignored so the endpoint can't be
// used to relay mail to arbitrary addresses.
$recipient = 'info@rayinfos.com';

$field = function ($key) {
    $v = isset($_POST[$key]) ? trim($_POST[$key]) : '';
    $v = strip_tags($v);
    return str_replace(["\r", "\n"], ' ', $v);
};

$name    = $field('name');
$email   = $field('email');
$phone   = $field('phone');
$message = isset($_POST['message']) ? trim(strip_tags($_POST['message'])) : '';

if ($name !== '' && filter_var($email, FILTER_VALIDATE_EMAIL) && $message !== '') {
    $subject = 'Contact form message from ' . $name;
    $body = "Name: $name\nE-mail: $email\nPhone: $phone\n\nMessage:\n$message\n";
    $headers = "From: noreply@rayinfos.com\r\nReply-To: $email\r\n";
    @mail($recipient, $subject, $body, $headers);
}

echo 'success';
