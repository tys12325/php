<?php
//Name: FOONG SIANG HOONG ID:22WMR13703

// Load XML file
$xml = new DOMDocument;
$xml->load('users.xml');

// Load XSLT file
$xsl = new DOMDocument;
$xsl->load('users.xsl');

// Configure the transformer
$proc = new XSLTProcessor;
$proc->importStyleSheet($xsl); // Attach the XSLT rules

// Transform and output the XML
echo $proc->transformToXML($xml);
