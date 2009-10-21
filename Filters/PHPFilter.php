<?php

/**
 * GettextExtractor
 * 
 * This source file is subject to the New BSD License.
 *
 * @copyright  Copyright (c) 2009 Karel Klíma
 * @license    New BSD License
 * @package    Nette Extras
 */

require_once dirname(__FILE__) . '/iFilter.php';

/**
 * Filter to fetch gettext phrases from PHP functions
 * @author Karel Klíma
 * @copyright  Copyright (c) 2009 Karel Klíma
 */
class PHPFilter implements iFilter
{
	/** @var array */
    protected $functions = array(
    	'translate' => 1,
    	'_'	=> 1
    );
    
    /**
     * Includes a function to parse gettext phrases from
     * @param $functionName
     * @param $argumentPosition
     * @return PHPFilter
     */
    public function addFunction($functionName, $argumentPosition = 1)
    {
    	$this->functions[$functionName] = ceil((int) $argumentPosition);
    	return $this;
    }
    
    /**
     * Excludes a function from the function list
     * @param $functionName
     * @return PHPFilter
     */
    public function removeFunction($functionName)
    {
    	unset($this->functions[$functionName]);
    	return $this;
    }
    
    /**
     * Excludes all functions from the function list
     * @return PHPFilter
     */
    public function removeAllFunctions()
    {
    	$this->functions = array();
    	return $this;
    }
    
    /**
	 * Parses given file and returns found gettext phrases
	 * @param string $file
	 * @return array
	 */
    public function extract($file)
    {
        $pInfo = pathinfo($file);
        $data = array();
        $tokens = token_get_all(file_get_contents($file));
        $next = false;
        foreach ($tokens as $c)
        {
            if(is_array($c)) {
                if ($c[0] != T_STRING && $c[0] != T_CONSTANT_ENCAPSED_STRING) continue;
                if ($c[0] == T_STRING && isset($this->functions[$c[1]])) {
                    $next = $this->functions[$c[1]];
                    continue;
                }
                if ($c[0] == T_CONSTANT_ENCAPSED_STRING && $next == 1) {
                    $data[substr($c[1], 1, -1)][] = $pInfo['basename'] . ':' . $c[2];
                    $next = false; 
                }
            } else {
                if ($c == ')') $next = false;
                if ($c == ',' && $next != false) $next -= 1;
            }
        }
        return $data;
    }
}