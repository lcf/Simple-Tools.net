<?php
/**
 * Application entry point
 */
define('APPLICATION_PATH', realpath(dirname(__FILE__) . '/../application'));

// Application configuration
const CONFIG_ADMIN_EMAIL = 'lcfsoft@gmail.com';
const CONFIG_MAILER_SMTP_HOST = 'smtp.gmail.com';
const CONFIG_MAILER_SMTP_PORT = 587;
const CONFIG_MAILER_SMTP_USERNAME = 'sender@lcf.name';
const CONFIG_MAILER_SMTP_PASSWORD = 'secret-pass';


set_include_path(implode(PATH_SEPARATOR, array(
    APPLICATION_PATH,
    get_include_path()))
);
require_once 'Application.php';
\Application\run();