<?php
/**
 * Everything that relates to the application in general.
 */
namespace Application;

require_once 'FrontController.php';
require_once 'HttpFoundation.php';
use FrontController, HttpFoundation;

function run() {
    $request = HttpFoundation\create_request_from_globals();
    $response = FrontController\dispatch($request);
    HttpFoundation\send_response($response);
}
