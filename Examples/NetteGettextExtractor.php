<?php

echo '<pre>';
echo 'NetteGettextExtractor test';

require_once dirname(__FILE__) . '/../NetteGettextExtractor.php';

$ge = new NetteGettextExtractor();

$ge->setupForms();
$ge->setupDataGrid();
		
// $ge->scan(APP_DIR);
$ge->scan(array('testfile.php', 'testfile.phtml'));

// $ge->save(APP_DIR . '/locale/application.po');
$ge->save('output_nette.po');

echo '</pre>';