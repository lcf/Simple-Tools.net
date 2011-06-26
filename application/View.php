<?php
/*
 * All presentation related functions
 */
namespace View;

function textarea_form($legend, $action) {
    return layout(<<<HTML
        <form action="/{$action}" method="post" id="contact">
            <fieldset>
                <legend>{$legend}</legend>
                <div>
                    <textarea name="data" rows="30" cols="100" id="x_wpc_message"></textarea>
                </div>
                <div class="submit">
                    <input type="submit" name="show_result" value="show result" class="button" />
                    <input type="submit" name="to_pastie" value="open result in pastie.org" class="button" />
                </div>
            </fieldset>
        </form>
HTML
    );
}

function xml_form() {
    return textarea_form('Paste your Xml', 'xml');
}

function sql_form() {
    return textarea_form('Paste your SQL', 'sql');
}

function suggest_form() {
    return layout(<<<HTML
        <h2>Suggest new tool</h2>
        <p>
            It should be something
            simple. Something that looks simple, at least. The underlying algorithm may be of
            any complexity. Something quick-to-use so to speak. It may be something that's been
            already implemented by many - if it's good, simple and often needed, I'll add it.
        </p><p>
            I will review all suggestions though. Please, fill the form in your own words,
            just so I can get the idea. I understand English and Russian and capable of using
            Google Dictionary ;) You may want to include some contact information e.g. your email address.
        </p>
        <form action="/suggest" method="post" id="contact">
            <fieldset>
                <legend>You think something is missing on this site? Please let me know!</legend>
                <div>
                    <textarea name="data" rows="30" cols="100" id="x_wpc_message"></textarea>
                </div>
                <div class="submit">
                    <input type="submit" name="show_result" value="suggest" class="button" />
                </div>
            </fieldset>
        </form>
HTML
    );
}

function suggest_result() {
    return layout(<<<HTML
    <h2>Thanks! :)</h2>
HTML
    );
}

function textarea_result($legend, $result) {
    return layout(<<<HTML
        <fieldset>
            <legend>{$legend}</legend>
            <div>
                <textarea name="data" rows="30" cols="100" id="x_wpc_message">{$result}</textarea>
            </div>
        </fieldset>
HTML
    );
}

function xml_result($result) {
    return textarea_result('Formatted Xml', $result);
}

function sql_result($result) {
    return textarea_result('Formatted Sql', $result);
}

function menu() {
    return <<<HTML
        <ul>
            <li class="widget widget_pages" id="pages">
                <h2>Tools</h2>
                <ul>
                    <li class="page_item"><a title="Format Xml" href="/xml">Format Xml</a></li>
                    <li class="page_item"><a title="Format Xml" href="/sql">Format SQL</a></li>
                </ul>
            </li>
            <li class="widget widget_pages" id="external-pages">
                <h2>External Links</h2>
                <ul>
                    <li class="page_item"><a title="Pastie.Org" href="http://pastie.org">Pastie.Org</a></li>
                    <li class="page_item"><a title="Gist Github" href="http://gist.github.com">gist.github.com</a></li>
                </ul>
            </li>
            <li class="widget widget_pages" id="contacts">
                <h2>Contacts</h2>
                <ul>
                    <li class="page_item"><a title="Suggest a tool" href="/suggest">Suggest a tool</a></li>
                    <li class="page_item"><a title="LCF.NAME" href="http://lcf.name">LCF.NAME</a></li>
                </ul>
            </li>
        </ul>
HTML;
}

function error($message) {
    return layout(<<<HTML
    <h2>Error!</h2>
    <p>{$message}</p>
HTML
    );
}

function layout($content) {
    $menu = menu();
    return <<<HTML
        <!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
        <html xmlns="http://www.w3.org/1999/xhtml" dir="ltr">
            <head profile="http://www.webdevout.net/profile/1.5/">
                <title>Simple-Tools.net</title>
                <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
                <meta name="author" content="Alexander Steshenko" />
                <meta name="keywords" content="xml,sql,formatter,web,developers,tools" />
                <meta name="description" content="Little tools for developers online" />

                <link href="/favicon.ico" rel="shortcut icon" />
                <link href="/favicon.ico" rel="shortcut icon" />
                <link rel="stylesheet" href="/style/minimalist.css" type="text/css" media="screen" />
                <link rel="stylesheet" href="/style/content-left.css" type="text/css" media="screen" />
                <link rel="stylesheet" href="/style/blue.css" type="text/css" media="screen" />
                <link rel="stylesheet" href="/style/bg_blue.css" type="text/css" media="screen" />
            </head>
            <body>
                <div id="header">
                    <h1><a href="/">Simple-Tools.net</a></h1>
                </div>
                <div id="page">
                    <div id="content">{$content}</div>
                    <div id="sidebar" class="bg_color">$menu</div>
                </div>
                <div id="footer">
                    <p>
                        Copyright &copy; <a href="http://lcf.name">Alexander Steshenko</a> 2011
                        | Design by <a href="http://xavisys.com" title="Freelance Web Programming and Design">Xavisys</a>
                        | <a href="http://www.opendesigns.org/" title="Download Free Web Design Templates">Open Designs</a>
                        | Valid <a href="http://jigsaw.w3.org/css-validator/">CSS</a> &amp; <a href="http://validator.w3.org/">XHTML</a>
                    </p>
                </div>
            </body>
        </html>
HTML;
}