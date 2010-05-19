<?php

function extract_tags($tags, $apiDoc) {
	$return = array();
	foreach ($tags as $tag => $value) {
		if (!is_array($value)) {
			$return[$tag] = $apiDoc->parse($value);
		} else {
			$return[$tag] = '';
			foreach ($value as $val) {
				$return[$tag] .= $apiDoc->parse($val);
			}
		}
	}
	return $return;
}

$apiDoc->setClassIndex($classIndex);

// Generate the output array which is a datastructure of all the values to be returned.
$output = array();

$output['classInfo'] = array(
	'classDescription' => $doc->classInfo['classDescription'],
	'filename' => $doc->classInfo['fileName'],
	'description' => $apiDoc->parse($doc->classInfo['comment']['description']),
	'parents' => $doc->classInfo['parents'],
	'interfaces' => array(),
	'tags' => array()
);

if (!empty($doc->classInfo['interfaces'])) {
	foreach ($doc->classInfo['interfaces'] as $interface) {
		$output['classInfo']['interfaces'][] = $apiDoc->classUrl($interface);
	}
}

if (!empty($doc->classInfo['comment']['tags'])) {
	$output['classInfo']['tags'] = extract_tags($doc->classInfo['comment']['tags'], $apiDoc);
}

//properties
$properties = array();

foreach ($doc->properties as $prop) {
	if ($apiDoc->excluded($prop['access'], 'property')) {
		continue;
	}
	$definedInThis = ($prop['declaredInClass'] == $doc->classInfo['name']);
	$properties[] = array(
		'name' => $prop['name'],
		'access' => $prop['access'],
		'parentMethod' => !$definedInThis,
		'description' => $apiDoc->parse($prop['comment']['description'])
	);
}
$output['properties'] = $properties;

//methods
$methods = array();

foreach ($doc->methods as $method) {
	if ($apiDoc->excluded($method['access'], 'method')) {
		continue;
	}
	$definedInThis = ($method['declaredInClass'] == $doc->classInfo['name']);

	$parameters = array();
	foreach ($method['args'] as $name => $paramInfo) {
		$parameters[] = array(
			'name' => $name,
			'type' => $paramInfo['type'],
			'comment' => $paramInfo['comment'],
			'optional' => $paramInfo['optional'],
			'default' => ($paramInfo['hasDefault']) ? var_export($paramInfo['default'], true) : __d('api_generator', '(no default)', true)
		);
	}

	$methods[] = array(
		'name' => $method['name'],
		'access' => $method['access'],
		'description' => $apiDoc->parse($method['comment']['description']),
		'parameters' => $parameters,
		'declaredIn' => array(
			'name' => $method['declaredInClass'],
			'url' => $apiDoc->classUrl($method['declaredInClass'])
		),
		'line' => $method['startLine'],
		'tags' => extract_tags($method['comment']['tags'], $apiDoc)
	);
}

$output['methods'] = $methods;

echo json_encode($output);