<?php

require_once dirname(__FILE__) . '/../Filters/NetteLatteFilter.php';

$pf = new NetteLatteFilter();

$data = $pf->extract(dirname(__FILE__) . '/testfile.phtml');

echo "<pre>NetteLatteFilter test\n";
var_dump($data);
echo "</pre>";