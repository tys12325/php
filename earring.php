<?php
//Name: SIA YAO QING ID:22WMR13745

// Load the XML file
$xml = new DOMDocument;
$xml->load('exports/products.xml'); // Make sure the path to your XML file is correct

// Load the XSL file
$xsl = new DOMDocument;
$xsl->load('xslt/Product_Earrings.xsl'); // Ensure this is the correct path to your XSL file

// Configure the XSLT processor
$proc = new XSLTProcessor;
$proc->importStyleSheet($xsl); // Attach the XSL rules

// Transform the XML to HTML
echo $proc->transformToXML($xml);
?>
