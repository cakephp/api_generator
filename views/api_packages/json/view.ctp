<?php
$apiDoc->setClassIndex($classIndex);

$children = array();
foreach ($apiPackage['ChildPackage'] as $child) {
	$children[] = array(
		'name' => $child['name'],
		'url' => $apiDoc->packageUrl($child['name'])
	);
}

$classes = array();
foreach ($apiPackage['ApiClass'] as $packageClass) {
	$classes[] = array(
		'name' => $packageClass['name'],
		'url' => $apiDoc->classUrl($packageClass['name'])
	);
}

$output = array(
	'name' => $apiPackage['ApiPackage']['name'],
	'parent' => $apiPackage['ParentPackage']['name'],
	'children' => $children,
	'classes' => $classes
);
echo json_encode($output);
