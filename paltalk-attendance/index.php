<?php

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

include 'lib.php';

header('Content-Type: text/html; charset=utf-8');

$title_text = 'PalTalk Attendance Parser';

//  All of this is bootstrapping the initial DOM object for creating an X/HTML page

$doctype = DOMImplementation::createDocumentType('html', '-//W3C//DTD XHTML 1.0 Strict//EN', 'http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd');

$doc = DOMImplementation::createDocument(null, 'html', $doctype);

$doc->formatOutput = true;
$doc->encoding = 'utf-8';

$html = $doc->documentElement;

$html->appendChild($head = new DOMElement('head'));

$head->appendChild($title = new DOMElement('title', $title_text));
$head->appendChild($link = new DOMElement('link'));
$link->setAttribute('rel', 'stylesheet');
$link->setAttribute('type', 'text/css');
$link->setAttribute('href', 'paltalk-attendance.css');

$html->appendChild($body = new DOMElement('body'));

$body->appendChild($h1 = new DOMElement('h1', $title_text));

$body->appendChild($form = new DOMElement('form'));

$form->setAttribute('action', 'process.php');
$form->setAttribute('method', 'post');
$form->setAttribute('enctype', 'multipart/form-data');

/*
$form->appendChild($fileinput = new DOMElement('input'));

$fileinput->setAttribute('type', 'file');
$fileinput->setAttribute('name', 'attendance_file');
*/

$form->appendChild($label = new DOMElement('label', 'PalTalk Attendance Log'));
$form->appendChild($textarea = new DOMElement('textarea', 'Paste attendance log here'));

$textarea->setAttribute('onfocus', 'if (this.defaultValue == this.value) this.value = ""');
$textarea->setAttribute('name', 'logtext');

$form->appendChild($button = new DOMElement('button', 'Submit'));
$button->setAttribute('type', 'submit');

echo $doc->saveXML();
