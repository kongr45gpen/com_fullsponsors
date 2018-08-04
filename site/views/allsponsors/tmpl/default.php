<?php
/*----------------------------------------------------------------------------------|  www.vdm.io  |----/
				Electroservices Team 
/-------------------------------------------------------------------------------------------------------/

	@version		0.0.3
	@build			4th August, 2018
	@created		3rd August, 2018
	@package		Managed Sponsors
	@subpackage		default.php
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

?>
<?php echo $this->toolbar->render(); ?> Content view
<div class="managedsponsors_sponsor_category">
<?php foreach ($this->items as $category): ?>

    <h2><?php echo $category[0]->categories_title ?></h2>
<div class="managedsponsors_sponsors">
    <?php foreach($category as $item): ?>
    
    	<a class="managedsponsors_sponsor" href="<?php echo $item->website ?>" title="<?php echo $item->name; ?>">
                <div class="managedsponsors_overlay"><span><?php echo $item->name; ?></div>
        	<img src="<?php echo $item->image ?>" alt="<?php echo $item->name; ?>">
        </a>

    <?php endforeach; ?>
    </div>
<?php endforeach; ?>
</div>

<?php if (isset($this->items) && isset($this->pagination) && isset($this->pagination->pagesTotal) && $this->pagination->pagesTotal > 1): ?>
<form name="adminForm" method="post">
	<div class="pagination">
		<?php if ($this->params->def('show_pagination_results', 1)) : ?>
			<p class="counter pull-right"> <?php echo $this->pagination->getPagesCounter(); ?> <?php echo $this->pagination->getLimitBox(); ?></p>
		<?php endif; ?>
		<?php echo $this->pagination->getPagesLinks(); ?>
	</div>
</form>
<?php endif; ?> 
