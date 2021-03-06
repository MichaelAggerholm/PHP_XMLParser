<?php
class DOMValidator
{
	/**
	 * @var string
	 */
	protected $feedSchema = 'files/validator.xsd';
	/**
	 * Validation Class constructor Instantiating DOMDocument
	 *
	 * @param \DOMDocument $handler [description]
	 */
	public function __construct()
	{
		$this->handler = new \DOMDocument('1.0', 'utf-8');
	}
	/**
	 * @param \libXMLError object $error
	 *
	 * @return string
	 */
	private function libxmlDisplayError($error)
	{
		$return = "<br/>\n";
		switch ($error->level) {
			case LIBXML_ERR_WARNING:
				$return .= "<b>Warning $error->code</b>: ";
				break;
			case LIBXML_ERR_ERROR:
				$return .= "<b>Error $error->code</b>: ";
				break;
			case LIBXML_ERR_FATAL:
				$return .= "<b>Fatal Error $error->code</b>: ";
				break;
		}
		$return .= trim($error->message);
		if ($error->file) {
			$return .=    " in <b>$error->file</b>";
		}
		$return .= " on line <b>$error->line</b>\n";

		return $return;
	}
	/**
	 * @return array
	 */
	private function libxmlDisplayErrors()
	{
		$errors = libxml_get_errors();
		$result = [];
		foreach ($errors as $error) {
			$result[] = $this->libxmlDisplayError($error);
		}
		libxml_clear_errors();
		return $result;
	}
	/**
	 * Validate Incoming Feeds against Listing Schema
	 *
	 * @param resource $feeds
	 *
	 * @return bool
	 *
	 * @throws \Exception
	 */
	public function validateFeeds($feeds)
	{
		if (!class_exists('DOMDocument')) {
			throw new \DOMException("'DOMDocument' class not found!");
			return false;
		}
		if (!file_exists($this->feedSchema)) {
			throw new \Exception('Schema is Missing, Please add schema to feedSchema property');
			return false;
		}
		libxml_use_internal_errors(true);
		if (!($fp = fopen($feeds, "r"))) {
			die("could not open XML input");
		}

		$contents = fread($fp, filesize($feeds));
		fclose($fp);

		$this->handler->loadXML($contents, LIBXML_NOBLANKS);
		if (!$this->handler->schemaValidate($this->feedSchema)) {
			$this->errorDetails = $this->libxmlDisplayErrors();
			$this->feedErrors   = 1;
		} else {
			//The file is valid
			return true;
		}
	}
	/**
	 * Display Error if Resource is not validated
	 *
	 * @return array
	 */
	public function displayErrors()
	{
		return $this->errorDetails;
	}
}
































//// Enable user error handling
//libxml_use_internal_errors(true);
//
//function libxml_display_error($error)
//{
//	$return = "<br/>\n";
//	switch ($error->level) {
//		case LIBXML_ERR_WARNING:
//			$return .= "<b>Warning $error->code</b>: ";
//			break;
//		case LIBXML_ERR_ERROR:
//			$return .= "<b>Error $error->code</b>: ";
//			break;
//		case LIBXML_ERR_FATAL:
//			$return .= "<b>Fatal Error $error->code</b>: ";
//			break;
//	}
//	$return .= trim($error->message);
//	if ($error->file) {
//		$return .=    " in <b>$error->file</b>";
//	}
//	$return .= " on line <b>$error->line</b>\n";
//
//	return $return;
//}
//
//function libxml_display_errors() {
//	$errors = libxml_get_errors();
//	foreach ($errors as $error) {
//		print libxml_display_error($error);
//	}
////	libxml_clear_errors();
//}
//
//$file_base_path = __DIR__  . '/files';
//
//$xml = new DOMDocument();
//$xml->load($file_base_path.'\sample.xml');
//
//if (!$xml->schemaValidate($file_base_path.'\sample.xsd')) {
//	print '<b>DOMDocument::schemaValidate() Generated Errors!</b>';
//	libxml_display_errors();
//} else {
//	// Load the XML source
//	$xml = new DOMDocument;
//	$xml->load($file_base_path.'\sample.xml');
//
//	$xsl = new DOMDocument;
//	$xsl->load($file_base_path.'\sample.xslt');
//
//	// Configure the transformer
//	$proc = new XSLTProcessor;
//	$proc->importStyleSheet($xsl); // attach the xsl rules
//
//	$result = $proc->transformToXML($xml);
////	echo $result;
//
//	// Way to parse XML string and save to a file
//	$convertedXML = simplexml_load_string($result);
//	$convertedXML->saveXML($file_base_path.'\result.xml');
//}