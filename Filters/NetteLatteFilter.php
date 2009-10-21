<?php

/**
 * GettextExtractor
 * 
 * Cool tool for automatic extracting gettext strings for translation
 *
 * Works best with Nette Framework
 * 
 * This source file is subject to the New BSD License.
 *
 * @copyright  Copyright (c) 2009 Karel Klíma
 * @license    New BSD License
 * @package    Nette Extras
 */

require_once dirname(__FILE__) . '/iFilter.php';

/**
 * Filter to parse curly brackets syntax in Nette Framework templates
 * @author Karel Klíma
 * @copyright  Copyright (c) 2009 Karel Klíma
 */
class NetteLatteFilter implements iFilter
{
	/** regex to match the curly brackets syntax */
	const LATTE_REGEX = '#{(__PREFIXES__)("[^"\\\\]*(?:\\\\.[^"\\\\]*)*"|\'[^\'\\\\]*(?:\\\\.[^\'\\\\]*)*\')+(\|[a-z]+(:[a-z0-9]+)*)*}#u';
	/** @var array */
	protected $prefixes = array('!_', '_');
	
	/**
	 * Mandatory work...
	 */
	public function __construct()
	{
		// Flips the array so we can use it more effectively
		$this->prefixes = array_flip($this->prefixes);
	}
	
	/**
	 * Includes a prefix to match in { }
	 * @param string $prefix
	 * @return NetteLatteFilter
	 */
	public function addPrefix($prefix) {
		$this->prefixes[$prefix] = TRUE;
		return $this;
	}
	
	/**
	 * Excludes a prefix from { }
	 * @param string $prefix
	 * @return NetteLatteFilter
	 */
	public function removePrefix($prefix) {
		unset($this->prefixes[$prefix]);
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
        if (!count($this->prefixes)) return;
        $data = array();
        // parse file by lines
        foreach (file($file) as $line => $contents) {
            $prefixes = join('|', array_keys($this->prefixes));
            // match all {!_ ... } or {_ ... } tags if prefixes are "!_" and "_"
            preg_match_all(str_replace('__PREFIXES__', $prefixes, self::LATTE_REGEX), $contents, $matches);
            
            if (empty($matches)) continue;
            if (empty($matches[2])) continue;
            
            foreach ($matches[2] as $m) {
            	// strips trailing apostrophes or double quotes
            	$data[substr($m, 1, -1)][] = $pInfo['basename'] . ':' . $line;
            }
        }
        return $data;
    }
}