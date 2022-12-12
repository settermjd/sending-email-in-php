<?php

/**
 * Send an email using PHP's built-in mail function
 *
 * There are a number of issues with using PHP's mail function, both directly
 * and more globally. Mail servers may not accept the emails if they're from
 * servers that are not properly configured, or if emails are not formatted
 * correctly. You have to be familiar with a number of RFCs, so that the
 * information entered is correctly formatted.
 */
$status = mail(
    "Matthew Setter <matthew@matthewsetter.com>",
    "The subject of the email",
    wordwrap("Here is my message", 70, "\r\n"),
    [
        'Bcc' => 'Matthew Setter <matthew@protonmail.com>',
        'Cc' => 'Matthew Setter <matthew.setter@gmail.com>',
        'Reply-To' => 'Matthew Setter <matthew@matthewsetter.com>',
        'X-Mailer' => sprintf("PHP %s", phpversion()),
    ]
);

echo (bool)$status
    ? "Email was successfully sent"
    : "Email was NOT successfully sent";