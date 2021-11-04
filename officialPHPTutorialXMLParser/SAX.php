<?php
//Reading XML using the SAX(Simple API for XML) parser

$tutors   = array();
$elements   = null;

// Called to this function when tags are opened
function startElements($parser, $name, $attrs) {
	global $tutors, $elements;

	if(!empty($name)) {
		if ($name == 'COURSE') {
			// creating an array to store information
			$tutors []= array();
		}
		$elements = $name;
	}
}

// Called to this function when tags are closed
function endElements($parser, $name) {
	global $elements;

	if(!empty($name)) {
		$elements = null;
	}
}

// Called on the text between the start and end of the tags
function characterData($parser, $data) {
	global $tutors, $elements;

	if(!empty($data)) {
		if ($elements == 'NAME' || $elements == 'COUNTRY' ||  $elements == 'EMAIL' ||  $elements == 'PHONE') {
			$tutors[count($tutors)-1][$elements] = trim($data);
		}
	}
}

// Creates a new XML parser and returns a resource handle referencing it to be used by the other XML functions.
$parser = xml_parser_create();

xml_set_element_handler($parser, "startElements", "endElements");
xml_set_character_data_handler($parser, "characterData");

// open xml file
if (!($handle = fopen('sax.xml', "r"))) {
	die("could not open XML input");
}

while($data = fread($handle, 4096)) { // read xml file
	xml_parse($parser, $data);  // start parsing an xml document
}

xml_parser_free($parser); // deletes the parser
$i = 1;

foreach($tutors as $course) {
	echo "course No - ".$i.'<br/>';
	echo "course Name - ".$course['NAME'].'<br/>';
	echo "Country - ".$course['COUNTRY'].'<br/>';
	echo "Email - ".$course['EMAIL'].'<br/>';
	echo "Phone - ".$course['PHONE'].'<hr/>';
	$i++;
}





// Just me testing..
echo "<br/><br/>";

foreach($tutors as $course) {
	print_r($course);
	echo "<br/><br/>";
//	$i++;
}
?>