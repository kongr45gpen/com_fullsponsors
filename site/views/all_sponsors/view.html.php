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
 * Managedsponsors View class for the All_sponsors
 */
class ManagedsponsorsViewAll_sponsors extends JViewLegacy
{
	// Overwriting JView display method
	function display($tpl = null)
	{		
		// get combined params of both component and menu
		$this->app = JFactory::getApplication();
		$this->params = $this->app->getParams();
		$this->menu = $this->app->getMenu()->getActive();
		// get the user object
		$this->user = JFactory::getUser();
		// [Interpretation 3129] Initialise variables.
		$this->items = $this->get('Items');

		// [Interpretation 3169] Set the toolbar
		$this->addToolBar();

		// [Interpretation 3171] set the document
		$this->_prepareDocument();

		// [Interpretation 3186] Check for errors.
		if (count($errors = $this->get('Errors')))
		{
			throw new Exception(implode("\n", $errors), 500);
		}

		parent::display($tpl);
	}

	/**
	 * Prepares the document
	 */
	protected function _prepareDocument()
	{

		// [Interpretation 3743] always make sure jquery is loaded.
		JHtml::_('jquery.framework');
		// [Interpretation 3745] Load the header checker class.
		require_once( JPATH_COMPONENT_SITE.'/helpers/headercheck.php' );
		// [Interpretation 3754] Initialize the header checker.
		$HeaderCheck = new managedsponsorsHeaderCheck;    
		// [Interpretation 3703] load the meta description
		if ($this->params->get('menu-meta_description'))
		{
			$this->document->setDescription($this->params->get('menu-meta_description'));
		}
		// [Interpretation 3708] load the key words if set
		if ($this->params->get('menu-meta_keywords'))
		{
			$this->document->setMetadata('keywords', $this->params->get('menu-meta_keywords'));
		}
		// [Interpretation 3713] check the robot params
		if ($this->params->get('robots'))
		{
			$this->document->setMetadata('robots', $this->params->get('robots'));
		} 
		// add the document default css file
		$this->document->addStyleSheet(JURI::root(true) .'/components/com_managedsponsors/assets/css/all_sponsors.css', (ManagedsponsorsHelper::jVersion()->isCompatible('3.8.0')) ? array('version' => 'auto') : 'text/css');
		// [Interpretation 3548] Set the Custom CSS script to view
		$this->document->addStyleDeclaration("
			.managedsponsors_sponsor_category h2 {
			        text-align: center;
			}
			
			.managedsponsors_sponsors {
				display: flex;
				justify-content: space-around;
				align-items: center;
				flex-wrap: wrap;
			}
			
			.managedsponsors_sponsor {
				margin: 1rem;
				position: relative;
			}
			
			.managedsponsors_sponsor img {
				height: 100px;
			}
			
			.managedsponsors_overlay {
				background-color: rgba(0,0,0,0.6);
				font-size: 12pt;
				color: white;
				text-align: center;
				display: flex;
				align-items: center;
				justify-content: center;
				
				position: absolute;
				width: 100%;
				height: 100%;
			
				transition: all 0.3s;
				opacity: 0;
			}
			
			.managedsponsors_sponsor:hover .managedsponsors_overlay {
				opacity: 1;
			}
		"); 
	}

	/**
	 * Setting the toolbar
	 */
	protected function addToolBar()
	{
		// adding the joomla toolbar to the front
		JLoader::register('JToolbarHelper', JPATH_ADMINISTRATOR.'/includes/toolbar.php');
		
		// set help url for this view if found
		$help_url = ManagedsponsorsHelper::getHelpUrl('all_sponsors');
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
	public function escape($var, $sorten = false, $length = 40)
	{
		// use the helper htmlEscape method instead.
		return ManagedsponsorsHelper::htmlEscape($var, $this->_charset, $sorten, $length);
	}
}
