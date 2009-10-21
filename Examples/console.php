<?php

require_once dirname(__FILE__) . '/../GettextExtractor.php';

$outputFile = $argv[1];
//$outputFile = 'output.po';
$inputResource = array_slice($argv, 2);
//$inputFiles = array('Tests/testfile.php', 'Tests/testfile.phtml');

$ge = new GettextExtractor();

$ge->scan($inputResource);

$ge->save($outputFile);

echo 'OK!';

//var_dump($data);