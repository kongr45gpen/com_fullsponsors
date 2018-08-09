<?php
/*----------------------------------------------------------------------------------|  www.vdm.io  |----/
				Electroservices Team 
/-------------------------------------------------------------------------------------------------------/

	@version		0.0.5
	@build			9th August, 2018
	@created		3rd August, 2018
	@package		Managed Sponsors
	@subpackage		categorysponsors.php
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

/**
 * Managedsponsors Sponsor Component Category Tree
 */
class ManagedsponsorsSponsorsCategories extends JCategories
{
	/**
	 * Class constructor
	 *
	 * @param   array  $options  Array of options
	 *
	 */
	public function __construct($options = array())
	{
		$options['table'] = '#__managedsponsors_sponsor';
		$options['extension'] = 'com_managedsponsors.sponsors';

		parent::__construct($options);
	}
}
