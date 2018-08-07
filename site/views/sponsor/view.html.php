<?php
/*----------------------------------------------------------------------------------|  www.vdm.io  |----/
				Electroservices Team 
/-------------------------------------------------------------------------------------------------------/

	@version		0.0.4
	@build			7th August, 2018
	@created		3rd August, 2018
	@package		Managed Sponsors
	@subpackage		view.html.php
	@author			kongr45gpen <http://helit.org/>	
	@copyright		Copyright (C) 2018. All Rights Reserved
	@license		GNU/GPL Version 2 or later - http://www.gnu.org/licenses/gpl-2.0.html
  ____  _____  _____  __  __  __      __       ___  _____  __  __  ____  _____  _  _  ____  _  _  ____ 
 (_  _)(  _  )(  _  )(  \/  )(  )    /__\     / __)(  _  )(  \/  )(  _ \(  _  )( \( )( ___)( \( )(_  _)
.-_)(   )(_)(  )(_)(  )    (  )(__  /(__)\   ( (__  )(_)(  )    (  )___/ )(_)(  )  (  )__)  )  (   )(  
\____) (_____)(_____)(_/\/\_)(____)(__)(__)   \___)(_____)(_/\/\_)(__)  (_____)(_)\_)(____)(_)\_) (__) 

/------------------------------------------------------------------------------------------------------*/

// No direct access to this file
defined('_JEXEC') or die('Restricted access');

// import Joomla view library
jimport('joomla.application.component.view');

/**
 * Sponsor View class
 */
class ManagedsponsorsViewSponsor extends JViewLegacy
{
	/**
	 * display method of View
	 * @return void
	 */
	public function display($tpl = null)
	{
		// Assign the variables
		$this->form 		= $this->get('Form');
		$this->item 		= $this->get('Item');
		$this->script 		= $this->get('Script');
		$this->state		= $this->get('State');
		// get action permissions
		$this->canDo		= ManagedsponsorsHelper::getActions('sponsor',$this->item);
		// get input
		$jinput = JFactory::getApplication()->input;
		$this->ref 		= $jinput->get('ref', 0, 'word');
		$this->refid            = $jinput->get('refid', 0, 'int');
		$this->referral         = '';
		if ($this->refid)
		{
				// return to the item that refered to this item
				$this->referral = '&ref='.(string)$this->ref.'&refid='.(int)$this->refid;
		}
		elseif($this->ref)
		{
				// return to the list view that refered to this item
				$this->referral = '&ref='.(string)$this->ref;
		}

		// Set the toolbar
		$this->addToolBar();
		
		// Check for errors.
		if (count($errors = $this->get('Errors')))
		{
			throw new Exception(implode("\n", $errors), 500);
		}

		// Display the template
		parent::display($tpl);

		// Set the document
		$this->setDocument();
	}


	/**
	 * Setting the toolbar
	 */
	protected function addToolBar()
	{
		// adding the joomla edit toolbar to the front
		JLoader::register('JToolbarHelper', JPATH_ADMINISTRATOR.'/includes/toolbar.php');
		JFactory::getApplication()->input->set('hidemainmenu', true);
		$user = JFactory::getUser();
		$userId	= $user->id;
		$isNew = $this->item->id == 0;

		JToolbarHelper::title( JText::_($isNew ? 'COM_MANAGEDSPONSORS_SPONSOR_NEW' : 'COM_MANAGEDSPONSORS_SPONSOR_EDIT'), 'pencil-2 article-add');
		// [Interpretation 11558] Built the actions for new and existing records.
		if ($this->refid || $this->ref)
		{
			if ($this->canDo->get('sponsor.create') && $isNew)
			{
				// [Interpretation 11570] We can create the record.
				JToolBarHelper::save('sponsor.save', 'JTOOLBAR_SAVE');
			}
			elseif ($this->canDo->get('sponsor.edit'))
			{
				// [Interpretation 11582] We can save the record.
				JToolBarHelper::save('sponsor.save', 'JTOOLBAR_SAVE');
			}
			if ($isNew)
			{
				// [Interpretation 11587] Do not creat but cancel.
				JToolBarHelper::cancel('sponsor.cancel', 'JTOOLBAR_CANCEL');
			}
			else
			{
				// [Interpretation 11592] We can close it.
				JToolBarHelper::cancel('sponsor.cancel', 'JTOOLBAR_CLOSE');
			}
		}
		else
		{
			if ($isNew)
			{
				// [Interpretation 11600] For new records, check the create permission.
				if ($this->canDo->get('sponsor.create'))
				{
					JToolBarHelper::apply('sponsor.apply', 'JTOOLBAR_APPLY');
					JToolBarHelper::save('sponsor.save', 'JTOOLBAR_SAVE');
					JToolBarHelper::custom('sponsor.save2new', 'save-new.png', 'save-new_f2.png', 'JTOOLBAR_SAVE_AND_NEW', false);
				};
				JToolBarHelper::cancel('sponsor.cancel', 'JTOOLBAR_CANCEL');
			}
			else
			{
				if ($this->canDo->get('sponsor.edit'))
				{
					// [Interpretation 11627] We can save the new record
					JToolBarHelper::apply('sponsor.apply', 'JTOOLBAR_APPLY');
					JToolBarHelper::save('sponsor.save', 'JTOOLBAR_SAVE');
					// [Interpretation 11630] We can save this record, but check the create permission to see
					// [Interpretation 11631] if we can return to make a new one.
					if ($this->canDo->get('sponsor.create'))
					{
						JToolBarHelper::custom('sponsor.save2new', 'save-new.png', 'save-new_f2.png', 'JTOOLBAR_SAVE_AND_NEW', false);
					}
				}
				if ($this->canDo->get('sponsor.create'))
				{
					JToolBarHelper::custom('sponsor.save2copy', 'save-copy.png', 'save-copy_f2.png', 'JTOOLBAR_SAVE_AS_COPY', false);
				}
				JToolBarHelper::cancel('sponsor.cancel', 'JTOOLBAR_CLOSE');
			}
		}
		JToolbarHelper::divider();
		// [Interpretation 11683] set help url for this view if found
		$help_url = ManagedsponsorsHelper::getHelpUrl('sponsor');
		if (ManagedsponsorsHelper::checkString($help_url))
		{
			JToolbarHelper::help('COM_MANAGEDSPONSORS_HELP_MANAGER', false, $help_url);
		}
		// now initiate the toolbar
		$this->toolbar = JToolbar::getInstance();
	}

	/**
	 * Escapes a value for output in a view script.
	 *
	 * @param   mixed  $var  The output to escape.
	 *
	 * @return  mixed  The escaped value.
	 */
	public function escape($var)
	{
		if(strlen($var) > 30)
		{
    		// use the helper htmlEscape method instead and shorten the string
			return ManagedsponsorsHelper::htmlEscape($var, $this->_charset, true, 30);
		}
		// use the helper htmlEscape method instead.
		return ManagedsponsorsHelper::htmlEscape($var, $this->_charset);
	}

	/**
	 * Method to set up the document properties
	 *
	 * @return void
	 */
	protected function setDocument()
	{
		$isNew = ($this->item->id < 1);
		if (!isset($this->document))
		{
			$this->document = JFactory::getDocument();
		}
		$this->document->setTitle(JText::_($isNew ? 'COM_MANAGEDSPONSORS_SPONSOR_NEW' : 'COM_MANAGEDSPONSORS_SPONSOR_EDIT'));
		// we need this to fix the form display
		$this->document->addStyleSheet(JURI::root()."administrator/templates/isis/css/template.css", (ManagedsponsorsHelper::jVersion()->isCompatible('3.8.0')) ? array('version' => 'auto') : 'text/css');
		$this->document->addScript(JURI::root()."administrator/templates/isis/js/template.js", (ManagedsponsorsHelper::jVersion()->isCompatible('3.8.0')) ? array('version' => 'auto') : 'text/javascript');
		// the default style of this view
		$this->document->addStyleSheet(JURI::root()."components/com_managedsponsors/assets/css/sponsor.css", (ManagedsponsorsHelper::jVersion()->isCompatible('3.8.0')) ? array('version' => 'auto') : 'text/css'); 
		// default javascript of this view
		$this->document->addScript(JURI::root().$this->script, (ManagedsponsorsHelper::jVersion()->isCompatible('3.8.0')) ? array('version' => 'auto') : 'text/javascript');
		$this->document->addScript(JURI::root(). "components/com_managedsponsors/views/sponsor/submitbutton.js", (ManagedsponsorsHelper::jVersion()->isCompatible('3.8.0')) ? array('version' => 'auto') : 'text/javascript'); 
		JText::script('view not acceptable. Error');
	}
}
