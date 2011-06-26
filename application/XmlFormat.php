<?php
/*
 * Xml formatter
 */
namespace XmlFormat;

function format_xml($source) {
    libxml_use_internal_errors(true);
    $sourceXml = simplexml_load_string(trim($source));
    if (!$sourceXml) {
        $error = libxml_get_last_error();
        trigger_error($error->{'message'});
    }
    $doc = new \DOMDocument();
    $doc->preserveWhiteSpace = false;
    $doc->loadXML($sourceXml->asXML());
    $doc->formatOutput = true;
    return trim($doc->saveXML());
}