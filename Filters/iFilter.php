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

/**
 * Gettext parser filters interface
 * @author Karel Klíma
 */
interface iFilter
{
	/**
	 * Extracts gettext phrases from a file
	 * @param string $file
	 */
    public function extract($file);
}