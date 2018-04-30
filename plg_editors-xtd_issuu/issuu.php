<?php
/**
 * @package     Joomla.Plugin
 * @subpackage  Editors-xtd.Issuu
 *
 * @copyright   Copyright (C) 2018 José A. Cidre Bardelás. All rights reserved.
 * @license     GNU General Public License version 3 or later; see LICENSE.txt
 */

defined('_JEXEC') or die;

class PlgButtonIssuu extends JPlugin
{
	protected $autoloadLanguage = true;

	public function onDisplay($name)
	{
		$input = JFactory::getApplication()->input;
		$user  = JFactory::getUser();

		// Can create in any category (component permission) or at least in one category
		$canCreateRecords = $user->authorise('core.create', 'com_content')
			|| count($user->getAuthorisedCategories('com_content', 'core.create')) > 0;

		// Instead of checking edit on all records, we can use **same** check as the form editing view
		$values = (array) JFactory::getApplication()->getUserState('com_content.edit.article.id');
		$isEditingRecords = count($values);

		// This ACL check is probably a double-check (form view already performed checks)
		$hasAccess = $canCreateRecords || $isEditingRecords;

		if (!$hasAccess)
		{
			return;
		}

		$js =  "function insertIssuu() {
					docID = prompt('" . JText::_('PLG_EDITORSXTD_ISSUU_PROMPT_ID') . "','');
					if (!docID) return;
					width = prompt('" . JText::_('PLG_EDITORSXTD_ISSUU_PROMPT_WIDTH') . ")','');
					if (!width) return;
					height = prompt('" . JText::_('PLG_EDITORSXTD_ISSUU_PROMPT_HEIGHT') . "','');
					if (!height) return;
					jInsertEditorText('[issuu '+docID+' '+width+' '+height+']', editor);
				}";

		$doc = JFactory::getDocument();
		$doc->addScriptDeclaration($js);
    
		$button          = new JObject;
		$button->modal   = false;
		$button->class   = 'btn';
		$button->link    = '#';
		$button->text    = JText::_('PLG_EDITORS-XTD_ISSUU');
		$button->name    = 'file-add';
		$button->onclick = 'insertIssuu(\''.$name.'\'); return false;';

		return $button;
	}
}
