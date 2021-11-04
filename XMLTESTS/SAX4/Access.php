<?php
function start_element($parser, $element_name, $element_attrs) {
	switch ($element_name) {
		case 'KEYWORDS':
			echo '<h1>Keywords</h1><ul>';
			break;
		case 'KEYWORD':
			echo '<li>';
			break;
	}
}

function end_element($parser, $element_name) {
	switch ($element_name) {
		case 'KEYWORDS':
			echo '</ul>';
			break;
		case 'KEYWORD':
			echo '</li>';
			break;
	}
}


function character_data($parser, $data) {
	echo htmlentities($data);
}

$parser = xml_parser_create();
xml_set_element_handler($parser, 'start_element', 'end_element');
xml_set_character_data_handler($parser, 'character_data');

$fp = fopen('keyword-data.xml', 'r')
or die ("Cannot open keyword-data.xml!");


while ($data = fread($fp, 4096)) {
	xml_parse($parser, $data, feof($fp)) or
	die(sprintf('XML ERROR: %s at line %d',
		xml_error_string(xml_get_error_code($parser)),
		xml_get_current_line_number($parser)));
}


xml_parser_free($parser);