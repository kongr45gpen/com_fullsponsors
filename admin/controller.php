<?php
/*----------------------------------------------------------------------------------|  www.vdm.io  |----/
				Electroservices Team 
/-------------------------------------------------------------------------------------------------------/

	@version		0.0.3
	@build			4th August, 2018
	@created		3rd August, 2018
	@package		Managed Sponsors
	@subpackage		controller.php
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

// import Joomla controller library
jimport('joomla.application.component.controller');

/**
 * General Controller of Managedsponsors component
 */
class ManagedsponsorsController extends JControllerLegacy
{
	/**
	 * Constructor.
	 *
	 * @param   array  $config  An optional associative array of configuration settings.
	 * Recognized key values include 'name', 'default_task', 'model_path', and
	 * 'view_path' (this list is not meant to be comprehensive).
	 *
	 * @since   3.0
	 */
	public function __construct($config = array())
	{
		// set the default view
		$config['default_view'] = 'sponsors';

		parent::__construct($config);
	}

	/**
	 * display task
	 *
	 * @return void
	 */
	function display($cachable = false, $urlparams = false)
	{
		// set default view if not set
		$view   = $this->input->getCmd('view', 'sponsors');
		$data	= $this->getViewRelation($view);
		$layout	= $this->input->get('layout', null, 'WORD');
		$id    	= $this->input->getInt('id');

		// Check for edit form.
		if(ManagedsponsorsHelper::checkArray($data))
		{
			if ($data['edit'] && $layout == 'edit' && !$this->checkEditId('com_managedsponsors.edit.'.$data['view'], $id))
			{
				// Somehow the person just went to the form - we don't allow that.
				$this->setError(JText::sprintf('JLIB_APPLICATION_ERROR_UNHELD_ID', $id));
				$this->setMessage($this->getError(), 'error');
				// check if item was opend from other then its own list view
				$ref 	= $this->input->getCmd('ref', 0);
				$refid 	= $this->input->getInt('refid', 0);
				// set redirect
				if ($refid > 0 && ManagedsponsorsHelper::checkString($ref))
				{
					// redirect to item of ref
					$this->setRedirect(JRoute::_('index.php?option=com_managedsponsors&view='.(string)$ref.'&layout=edit&id='.(int)$refid, false));
				}
				elseif (ManagedsponsorsHelper::checkString($ref))
				{

					// redirect to ref
					$this->setRedirect(JRoute::_('index.php?option=com_managedsponsors&view='.(string)$ref, false));
				}
				else
				{
					// normal redirect back to the list view
					$this->setRedirect(JRoute::_('index.php?option=com_managedsponsors&view='.$data['views'], false));
				}

				return false;
			}
		}

		return parent::display($cachable, $urlparams);
	}

	protected function getViewRelation($view)
	{
		// check the we have a value
		if (ManagedsponsorsHelper::checkString($view))
		{
			// the view relationships
			$views = array(
				'sponsor' => 'sponsors'
					);
			// check if this is a list view
			if (in_array($view, $views))
			{
				// this is a list view
				return array('edit' => false, 'view' => array_search($view,$views), 'views' => $view);
			}
			// check if it is an edit view
			elseif (array_key_exists($view, $views))
			{
				// this is a edit view
				return array('edit' => true, 'view' => $view, 'views' => $views[$view]);
			}
		}
		return false;
	}
}
