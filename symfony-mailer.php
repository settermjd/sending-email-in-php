<?php

use Symfony\Bridge\Twig\Mime\TemplatedEmail;
use Symfony\Component\Mailer\Exception\TransportExceptionInterface;
use Symfony\Component\Mailer\Mailer;
use Symfony\Component\Mailer\Transport;
use Symfony\Component\Mime\Address;
use Symfony\Component\Mime\Email;
use Symfony\Component\Mime\Part\DataPart;
use Symfony\Component\Mime\Part\File;

require_once('vendor/autoload.php');

$dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
$dotenv->load();

$file_encoded = file_get_contents(__DIR__ . '/data/text.txt');

$email = (new TemplatedEmail())
    ->replyTo('matthew@matthewsetter.com')
    ->from(new Address('matthew@matthewsetter.com', 'Matthew Setter'))
    ->to(new Address('matthew@matthewsetter.com', 'Matthew Setter'))
    ->priority(Email::PRIORITY_HIGHEST)
    ->subject('My first mail using Symfony Mailer')
    ->text('This is an important message!')
    ->attach($file_encoded, 'text-file.txt', 'application/text')
    ->addPart(new DataPart(new File(__DIR__ . '/data/text.pdf')))
    ->htmlTemplate(__DIR__ . '/templates/emails/signup.html.twig')
    ->context(
        [
            'expiration_date' => new \DateTime('+7 days'),
            'username' => 'foo',
        ]
    )
;

$transport = Transport::fromDsn($_SERVER['MAILER_DSN']);
$mailer = new Mailer($transport);
try {
    $mailer->send($email);
} catch (TransportExceptionInterface $e) {
    sprintf("Email could not be sent. Reason: %s", $e->getMessage());
}