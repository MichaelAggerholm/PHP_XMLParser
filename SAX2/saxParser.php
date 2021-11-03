<?php
$start = time();

//we open a handle to the file
$stream = fopen('SAX.xml', 'r');

//create the actual parser
$parser = xml_parser_create();

/* like mentioned: we operate from top to bottom and consider
each incoming data as a potential state changer, therefore we
need some variables to store the actual states */

//will be set when we hit `room` starting tag from attributes
$lastObjectId = null;

//will be set when SAX reads the contents between the nodes
$lastContents = null;

//will be set when we hit the `vacancy` start tag
$lastDate = null;

/*
 ! end tag of vacancy is the moment when we have all the required data for
 each entry in such configuration
*/

/* like mentioned: SAX Parser works in quite an unusual way as its origin
dates to PHP4. We need to pass methods (as in methods' names) which will
handle occurences of: start tag, end tag and literal contents (texts
between start and end tags) */
xml_set_element_handler($parser, "startTag", "endTag");
xml_set_character_data_handler($parser, "contents");

//now the nice part of sax parser: we load the chunks of data into the parser and it does the trick of joining and parsing whenever needed
while (($data = fread($stream, 16384))) {
	xml_parse($parser, $data); // parse the current chunk
}
xml_parse($parser, '', true); // finalize parsing
//free any memory used by the parser
xml_parser_free($parser);
//close the stream
fclose($stream);

/**
 * function which handles the start tag and therefore
 * can access the xml attributes
 *
 * in our case we want object id and date from attributes
 */
function startTag($parser, $name, $attrs) {
	/* in this prototype we use globals,
	but it is possible to use object context
	by informing SAX that it reside in an
	entity with `xml_set_object` */
	global $lastDate, $lastObjectId;
	switch($name) {
		case 'ROOM':
			$lastObjectId = $attrs['ID'];
			break;
		case 'VACANCY':
			$lastDate = $attrs['DATE'];
			break;
	}
}

/**
 * function which is executed when an end tag is hit
 * in our case the moment when we have all data of
 * a particular vacancy (as required: object id, vacancy
 * date) is the moment when we read the contents of the
 * vacancy node, but for a bit of clarity in the code
 * we shall actually handle it when we hit the end tag
 */
function endTag($parser, $name) {
	global $lastObjectId, $lastContents, $lastDate;
	switch ($name) {
		case 'ROOM':
			//here we would finalise room's data...
			break;
		case 'VACANCY':
			$objectId = $lastObjectId;
			$date = $lastDate;
			$value = $lastContents;
			//here we would process the data
			break;
	}
}

/**
 * function which handles the literal (string) contents of
 * a node
 */
function contents($parser, $data) {
	global $lastContents;
	$lastContents = $data;
}

//var_dump("Mem in MiB: " . round((processPeakMemUsage() / 1024)));
var_dump("Time in seconds:  " . (time() - $start));