<?php
/*
 * All mailing tasks
 */
namespace Mailer;

function mail_suggestion($suggestion) {
    return mail_admin('New suggestion', $suggestion);
}

function mail_application_error($message) {
    return mail_admin('Application error!', $message);
}

function mail_admin($subject, $body) {
    return smtp_tls_mail(
        $subject,
        $body,
        CONFIG_MAILER_SMTP_HOST,
        CONFIG_MAILER_SMTP_PORT,
        CONFIG_MAILER_SMTP_USERNAME,
        CONFIG_MAILER_SMTP_PASSWORD,
        'no-reply@simple-tools.net',
        CONFIG_ADMIN_EMAIL
    );
}

function skip($smtp) {
    do {
        $result = preg_split('/([\s-]+)/', fgets($smtp, 1024), 2, PREG_SPLIT_DELIM_CAPTURE);
    } while (isset($result[1]) && $result[1] === '-');
}

function send($smtp, $command) {
    fwrite($smtp, $command . "\r\n");
}

function send_skip($smtp, $command) {
    send($smtp, $command);
    skip($smtp);
}

function smtp_tls_mail($subject, $body, $host, $port, $smtpUser, $smtpPassword, $from, $to) {
    $smtp = stream_socket_client('tcp://' . $host . ':' . $port);
    skip($smtp);
    send_skip($smtp, 'EHLO localhost');
    send_skip($smtp, 'STARTTLS');
    stream_socket_enable_crypto($smtp, true, STREAM_CRYPTO_METHOD_TLS_CLIENT);
    send_skip($smtp, 'EHLO localhost');
    send_skip($smtp, 'AUTH LOGIN');
    send_skip($smtp, base64_encode($smtpUser));
    send_skip($smtp, base64_encode($smtpPassword));
    send_skip($smtp, "MAIL FROM: <$from>");
    send_skip($smtp, "RCPT TO: <$to>");
    send_skip($smtp, "DATA");
    send($smtp, "To: <$to>");
    send($smtp, "From: <$from>");
    send($smtp, "Subject:$subject");
    send($smtp, "");
    send($smtp, $body);
    send_skip($smtp, ".");
    send_skip($smtp, "QUIT");
    fclose($smtp);
}