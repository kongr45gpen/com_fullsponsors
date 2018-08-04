<?php
/*----------------------------------------------------------------------------------|  www.vdm.io  |----/
				Electroservices Team 
/-------------------------------------------------------------------------------------------------------/

	@version		0.0.3
	@build			4th August, 2018
	@created		3rd August, 2018
	@package		Managed Sponsors
	@subpackage		managedsponsors.php
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

// Access check.
if (!JFactory::getUser()->authorise('core.manage', 'com_managedsponsors'))
{
	return JError::raiseWaring(404, JText::_('JERROR_ALERTNOAUTHOR'));
};

// Load cms libraries
JLoader::registerPrefix('J', JPATH_PLATFORM . '/cms');
// Load joomla libraries without overwrite
JLoader::registerPrefix('J', JPATH_PLATFORM . '/joomla',false);

// Add CSS file for all pages
$document = JFactory::getDocument();
$document->addStyleSheet('components/com_managedsponsors/assets/css/admin.css');
$document->addScript('components/com_managedsponsors/assets/js/admin.js');

// require helper files
JLoader::register('ManagedsponsorsHelper', dirname(__FILE__) . '/helpers/managedsponsors.php'); 
JLoader::register('JHtmlBatch_', dirname(__FILE__) . '/helpers/html/batch_.php'); 

// import joomla controller library
jimport('joomla.application.component.controller');

// Get an instance of the controller prefixed by Managedsponsors
$controller = JControllerLegacy::getInstance('Managedsponsors');

// Perform the Request task
$controller->execute(JFactory::getApplication()->input->get('task'));

// Redirect if set by the controller
$controller->redirect();
