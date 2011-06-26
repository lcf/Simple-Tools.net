<?php
/*
 * Request handlers
 */
namespace Controller;

require_once 'HttpFoundation.php';
require_once 'View.php';
require_once 'XmlFormat.php';
require_once 'SqlFormat.php';
require_once 'PastieOrg.php';
require_once 'Mailer.php';
use HttpFoundation, View, XmlFormat, SqlFormat, PastieOrg, Mailer;

function index(&$request) {
    return xml($request);
}

function xml(&$request) {
    if (HttpFoundation\is_post($request)) {
        $result = XmlFormat\format_xml(HttpFoundation\request_param($request, 'data'));
        if (HttpFoundation\request_param($request, 'show_result')) {
            return HttpFoundation\build_response(
                View\xml_result($result));
        } else {
            $pastieLocation = PastieOrg\create_private_pastie_xml($result);
            $response = HttpFoundation\build_response();
            HttpFoundation\redirect($response, $pastieLocation);
            return $response;
        }
    } else {
        return HttpFoundation\build_response(
            View\xml_form());
    }
}

function sql(&$request) {
    if (HttpFoundation\is_post($request)) {
        $result = SqlFormat\format_sql(HttpFoundation\request_param($request, 'data'));
        if (HttpFoundation\request_param($request, 'show_result')) {
            return HttpFoundation\build_response(
                View\sql_result($result));
        } else {
            $pastieLocation = PastieOrg\create_private_pastie_sql($result);
            $response = HttpFoundation\build_response();
            HttpFoundation\redirect($response, $pastieLocation);
            return $response;
        }
    } else {
        return HttpFoundation\build_response(
            View\sql_form());
    }
}

function suggest(&$request) {
    if (HttpFoundation\is_post($request)) {
        Mailer\mail_suggestion(
            HttpFoundation\request_param($request, 'data'));
        return HttpFoundation\build_response(
            View\suggest_result());
    } else {
        return HttpFoundation\build_response(
            View\suggest_form());
    }
}