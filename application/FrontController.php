<?php
/*
 * Routes the current request, passes control to one of the
 * handlers
 */
namespace FrontController;

require_once 'HttpFoundation.php';
require_once 'Controller.php';
require_once 'Mailer.php';
use HttpFoundation, Controller, Mailer;

function error_handler($type, $message, $file, $line) {
    if ($type == E_USER_NOTICE) {
        $response = HttpFoundation\build_response(\View\error($message));
    } else {
        $message .= ' on line ' . $line . ' in file ' . $file;
        error_log($message);
        Mailer\mail_application_error($message);
        $response = HttpFoundation\build_response(\View\error('Application error'));
    }
    HttpFoundation\send_response($response);
    die;
}

function dispatch(&$request) {
    set_error_handler('FrontController\error_handler');
    $controller = route($request);
    if (!$controller) {
        trigger_error('Requested page is not found');
    }
    return $controller($request);
}

function route(&$request) {
    $path = HttpFoundation\request_path($request);
    if (!$path) {
        return 'Controller\index';
    } elseif (function_exists($controller = 'Controller\\' . HttpFoundation\request_path($request))) {
        return $controller;
    } else {
        return null;
    }
}