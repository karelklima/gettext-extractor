<?php

echo '<pre>';
echo 'GettextExtractor test';

require_once dirname(__FILE__) . '/../GettextExtractor.php';

$ge = new GettextExtractor();
		
$ge->scan(array('testfile.php', 'testfile.phtml'));

$ge->save('output.po');

echo '</pre>';