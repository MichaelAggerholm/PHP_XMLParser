<?php
require 'CompactHandler.php';
    $handler = new CompactHandler();

    $parser = xml_parser_create("UTF-8");
    xml_parser_set_option($parser, XML_OPTION_TARGET_ENCODING, "UTF-8");
    xml_parser_set_option($parser, XML_OPTION_CASE_FOLDING, 0);
    xml_parser_set_option($parser, XML_OPTION_SKIP_WHITE, 1);

    xml_set_object($parser,$handler);
    xml_set_element_handler($parser, "startElement", "endElement");
    xml_set_character_data_handler($parser,"characters");

    $fp = fopen("result.xml","r");
    while ($data = fread($fp, 4096)) {
		if (!xml_parse($parser, $data, feof($fp))) {
			die(sprintf("XML error: %s at line %d",
				xml_error_string(xml_get_error_code($parser)),
				xml_get_current_line_number($parser)));
		}
	}

    print "\n";
    xml_parser_free($parser);
?>