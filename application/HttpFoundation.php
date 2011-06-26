<?php
/**
 * HTTP protocol related data types and functions
 */
namespace HttpFoundation;

function create_request_from_globals() {
    list($path) = explode('?', $_SERVER['REQUEST_URI']);
    return array(
        'scheme' => empty($_SERVER['HTTPS']) ? 'http' : 'https',
        'host' => $_SERVER['SERVER_NAME'],
        'path' => trim($path, '/'),
        'params' => array_merge($_GET, $_POST),
        'method' => $_SERVER['REQUEST_METHOD']
    );
}

function request_path(&$request) {
    return $request['path'];
}

function request_param(&$request, $name, $default = '') {
    return isset($request['params'][$name]) ? $request['params'][$name] : $default;
}

function is_post(&$request) {
    return $request['method'] == 'POST';
}

function build_response($body = '', $code = 200, $headers = array()) {
    return array(
        'body' => $body,
        'code' => $code,
        'headers' => $headers
    );
}

function redirect(&$response, $location) {
    array_push($response['headers'], 'Location: ' . $location);
    $response['code'] = 302;
}

function send_response(&$response) {
    header('HTTP/1.1 ' . $response['code']);
    foreach ($response['headers'] as $header) {
        header($header);
    }
    echo $response['body'];
}