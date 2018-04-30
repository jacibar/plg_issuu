<?php
/**
 * @package     Joomla.Plugin
 * @subpackage  Content.Issuu
 *
 * @copyright   Copyright (C) 2018 José A. Cidre Bardelás. All rights reserved.
 * @license     GNU General Public License version 3 or later; see LICENSE.txt
 */

defined('_JEXEC') or die;

class PlgContentIssuu extends JPlugin
{
	function onContentPrepare($context, &$article, &$params, $limitstart)
	{
		$regex = '/\[issuu (.*?) (\d+.{1,2}?) (\d+.{1,2}?)\]/i';
		preg_match_all($regex, $article->text, $matches);
		for ($x = 0; $x < count($matches[0]); $x++) {
			$replace = '<div data-configid="' . $matches[1][$x] . '" style="width: ' . $matches[2][$x] . '; height: ' . $matches[3][$x] . ';" class="issuuembed"></div><script type="text/javascript" src="//e.issuu.com/embed.js" async="true"></script>';
			$article->text = str_replace($matches[0][$x], $replace, $article->text);
		}
	}

}
