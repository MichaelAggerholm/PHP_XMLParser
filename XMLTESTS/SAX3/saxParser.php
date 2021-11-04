<?php
$GLOBALS['currentIndex'] = 0;
$GLOBALS['currentField'] = '';
$GLOBALS['members'] = array();

$parser = xml_parser_create();
xml_set_element_handler($parser, 'startIt', 'endIt');
xml_set_character_data_handler($parser, 'cdata');
xml_parse($parser, file_get_contents('SAX.xml'), true);
xml_parser_free($parser);

// Display results
$members = $GLOBALS['members'];
if (count($members) > 0) {
	foreach ($members as $member) {
		echo 'First Name: ' . $member['firstName'] . '<br/>';
		echo 'Last Name: ' . $member['lastName'] . '<br/>';
		echo 'Score: ' . $member['score'] . '<br/>';
		echo '<hr/>';
	}
}

function startIt($parser, $name, $attributes) {
	switch ($name) {
		case 'MEMBER':
			$member = array('firstName'=>'', 'lastName'=>'', 'score'=>'');
			$GLOBALS['members'][] = $member;
			break;
		case 'FIRSTNAME':
			$GLOBALS['currentField'] = 'firstName';
			break;
		case 'LASTNAME':
			$GLOBALS['currentField'] = 'lastName';
			break;
		case 'SCORE':
			$GLOBALS['currentField'] = 'score';
			break;
	}
}

function endIt($parser, $name) {
	switch ($name) {
		case 'MEMBER':
			$GLOBALS['currentIndex']++;
			break;
	}
}

function cdata($parser, $data) {
	$currentIndex = $GLOBALS['currentIndex'];
	$currentField = $GLOBALS['currentField'];
	if (trim($data) != '') {
		$GLOBALS['members'][$currentIndex][$currentField] = $data;
	}
}