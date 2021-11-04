<?php
$dom = new DOMDocument('1.0','UTF-8');
$dom->formatOutput = true;

$root = $dom->createElement('student');
$dom->appendChild($root);

$result = $dom->createElement('result');
$root->appendChild($result);

$result->setAttribute('id', 1);
for ($i = 1; $i <= 80; ++$i) {
	$result->appendChild( $dom->createElement('name', 'Handsome boy'));
	$result->appendChild( $dom->createElement('sgpa', random_int(0,500)));
	$result->appendChild( $dom->createElement('cgpa', random_int(0,10)));
}

//echo '<xmp>'. $dom->saveXML() .'</xmp>';
$dom->save('result.xml') or die('XML Create Error');
?>