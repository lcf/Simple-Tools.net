<?php
/*
 * Pastie.org support
 */
namespace PastieOrg;

const PARSER_XML = 11;
const PARSER_SQL = 14;

function create_private_pastie($parserId, $content) {
    $connection = fopen(
        'http://pastie.org/pastes',
        'rb',
        false,
        stream_context_create(array('http' => array(
            'method' => 'POST',
            'header' => "Content-Type: application/x-www-form-urlencoded\r\n",
            'content' => http_build_query(array('paste' => array(
                'parser_id' => $parserId,
                'body' => $content,
                'restricted' => 1,
                'authorization' => 'burger'
            )))
        )))
    );
    $meta = stream_get_meta_data($connection);
    fclose($connection);
    foreach ($meta['wrapper_data'] as $header) {
        if (strpos($header, 'Location: ') === 0) {
            return substr($header, 10);
        }
    }
    return null;
}

function create_private_pastie_xml($content) {
    return create_private_pastie(PARSER_XML, $content);
}

function create_private_pastie_sql($content) {
    return create_private_pastie(PARSER_SQL, $content);
}