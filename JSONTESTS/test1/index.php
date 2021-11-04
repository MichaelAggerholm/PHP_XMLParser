<?php
require_once 'vendor/autoload.php';

use JsonSchema\Validator;
use JsonSchema\Constraints\Constraint;

$config = json_decode(file_get_contents('config.json'));
$validator = new Validator; $validator->validate(
	$config,
	(object)['$ref' => 'file://' . realpath('schema.json')],
	Constraint::CHECK_MODE_APPLY_DEFAULTS
);

if ($validator->isValid()) {
	echo "JSON validates OK<br/>";
} else {
	echo "JSON validation errors:<br/>";
	foreach ($validator->getErrors() as $error) {
		print_r($error);
	}
}

print "\nResulting config:<br/>";
print_r($config);