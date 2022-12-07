<?php

/**
 * Send an email using PHP's built-in mail function
 */
$status = mail(
    "matthew@matthewsetter.com",
    "The subject of the email",
    "Here is my message",
    [
        'Cc' => 'matthew.setter@gmail.com',
        'Reply-To' => 'matthew.setter@gmail.com',
        'X-Mailer' => sprintf("PHP %s", phpversion()),
    ]
);

var_dump("Status is " . (bool)$status);