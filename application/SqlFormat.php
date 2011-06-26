<?php
/*
 * Does SQL indentation, currently only supports remote service
 * sqlformat.appspot.com
 */
namespace SqlFormat;

function format_sql($source) {
    return format_with_remote_service(trim($source));
}

function format_with_remote_service($source) {
    $connection = fopen(
        'http://sqlformat.appspot.com/format/',
        'rb',
        false,
        stream_context_create(array('http' => array(
            'method' => 'POST',
            'header' => "Content-Type: application/x-www-form-urlencoded\r\n",
            'content' => http_build_query(array(
                'data' => $source,
                'output_format' => 'sql',
                'keyword_case' => 'upper',
                'reindent' => 1,
                'n_indents' => 2
            ))
        )))
    );
    return stream_get_contents($connection);
}