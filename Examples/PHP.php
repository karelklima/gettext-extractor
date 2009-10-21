<?php

require_once dirname(__FILE__) . '/../Filters/PHPFilter.php';

$pf = new PHPFilter();

$data = $pf->extract(dirname(__FILE__) . '/testfile.php');

echo "<pre>PHPFilter test";
var_dump($data);
echo "</pre>";