<?php
include 'xmlValidator.php';

$validator = new DomValidator;
$validated = $validator->validateFeeds('files/suppliers/bookSupplier1.xml');
if ($validated) {
	echo "Feed successfully validated";

    // Load the XML source
	$xml = new DOMDocument;
	$xml->load('files/suppliers/bookSupplier1.xml');

	$xsl = new DOMDocument;
	$xsl->load('files/parser.xslt');

	// Configure the transformer
	$proc = new XSLTProcessor;
	$proc->importStyleSheet($xsl); // attach the xsl rules

	$result = $proc->transformToXML($xml);

	// Way to parse XML string and save to a file
	$convertedXML = simplexml_load_string($result);
	$convertedXML->saveXML('files/parsedResult.xml');
} else {
	print_r($validator->displayErrors());
}

// new stuff here:

$xml = file_get_contents('files/parsedResult.xml');
$xml_parse = simplexml_load_string($xml);


//echo "<pre>";print_r($xml_parse);echo"</pre>"
foreach ($xml_parse as $k=>$v)
{
//	echo "<pre>";print_r($v);echo"</pre>";
    echo '<br />' . $v->title;
}
?>

