<?php

require_once('vendor/autoload.php');

use SendGrid\Mail\Mail;
use SendGrid\Mail\To;

$dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
$dotenv->load();

$email = new Mail();
$email->setFrom('matthew@matthewsetter.com', 'Matthew Setter');
$email->setSubject('Sending with Twilio SendGrid is Fun');
$email->addTo('matthew.setter@gmail.com', 'Matthew Setter');
$email->addBcc('matthew@protonmail.com');
$email->addContent(
    'text/plain',
    'and easy to do anywhere – even with PHP'
);
$email->setReplyTo(new To('matthew@matthewsetter.com', 'Matthew Setter'));
$email->addContent(
    'text/html',
    '<strong>and easy to do anywhere, even with PHP</strong>'
);

$file_encoded = base64_encode(
    file_get_contents(__DIR__ . '/data/text-file.txt')
);
$email->addAttachment(
    $file_encoded,
    'application/text',
    'text-file.txt',
    'attachment'
);

$sendgrid = new SendGrid($_SERVER['SENDGRID_API_KEY']);
try {
    $response = $sendgrid->send($email);
    print $response->statusCode() . "\n";
    print_r($response->headers());
    print $response->body() . "\n";
} catch (Exception $e) {
    echo 'Caught exception: '.  $e->getMessage(). "\n";
}
