<?php
/*
 *      Issuu Plugins Package
 *      @package Issuu Plugins Package
 *      @subpackage Content
 *      @author José A. Cidre Bardelás
 *      @copyright Copyright (C) 2018 José A. Cidre Bardelás. All rights reserved
 *      @license GNU/GPL v3 or later
 *      
 *      This file is part of Issuu Plugins Package.
 *      
 *          Issuu Plugins Package is free software: you can redistribute it and/or modify
 *          it under the terms of the GNU General Public License as published by
 *          the Free Software Foundation, either version 3 of the License, or
 *          (at your option) any later version.
 *      
 *          Issuu Plugins Package is distributed in the hope that it will be useful,
 *          but WITHOUT ANY WARRANTY; without even the implied warranty of
 *          MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 *          GNU General Public License for more details.
 *      
 *          You should have received a copy of the GNU General Public License
 *          along with Issuu Plugins Package.  If not, see <http://www.gnu.org/licenses/>.
 */

defined('_JEXEC') or die();

class Pkg_IssuuInstallerScript
{
	public function install($parent)
	{
		$db = JFactory::getDbo();

		$query = $db->getQuery(true)
					->update('#__extensions')
					->set($db->qn('enabled') . ' = ' . $db->q(1))
					->where($db->qn('type') . ' = ' . $db->q('plugin'))
					->where($db->qn('element') . ' = ' . $db->q('issuu'))
					->where('(' . $db->qn('folder') . ' = ' . $db->q('content') . ' OR ' . $db->qn('folder') . ' = ' . $db->q('editors-xtd') . ')');

		$db->setQuery($query);

		try
		{
			$db->execute();
		}
		catch (\Exception $e)
		{
		}

		return true;
	}

	public function postflight($type, $parent)
	{
		$lang = JFactory::getLanguage();
		$lang->load('plg_editors-xtd_issuu', JPATH_ADMINISTRATOR, null, true);

		?>
		<h1><?php echo JText::_('PLG_EDITORS-XTD_ISSUU'); ?></h1>
		<div><?php echo JText::_('PLG_EDITORSXTD_ISSUU_XML_DESCRIPTION'); ?></div>
		<?php
	}
}