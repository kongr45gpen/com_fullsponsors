<?php
/*----------------------------------------------------------------------------------|  www.vdm.io  |----/
				Electroservices Team 
/-------------------------------------------------------------------------------------------------------/

	@version		0.0.5
	@build			9th August, 2018
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
<?php echo $this->toolbar->render(); ?> 
<?php
$param = $this->params->get('base_height');
$BASE_HEIGHT = ($param && trim($param) != '') ? $param : '150px';

/**
 * Applies a percentage value to a CSS size
 * @example apply_percentage("100px", 200) == "200px"
 */
function apply_percentage($css_size, $percentage) {
	if (trim($css_size) == '') return null;

	preg_match('/^([^0-9\-\.\,]*)([\d\-\.\,]+)([^0-9]*)$/', $css_size, $matches);
	if (!isset($matches[2])) {
		throw new InvalidArgumentException("Invalid size provided: " . $css_size);
	}

	$matches[2] *= (float) $percentage / 100.0;

	return $matches[1] . $matches[2] . $matches[3];
}
?>

<?php if($this->params->get('show_page_heading')): ?>
<div class="page-header">
	<h1><?php echo $this->params->get('page_title'); ?></h1>
</div>
<?php endif; ?>


<?php foreach ($this->items as $category): ?>
<div class="managedsponsors_sponsor_category">

    <?php
        $params = json_decode($category[0]->categories_params);
        $category_size_percentage = isset($params->sponsor_category_size) ? $params->sponsor_category_size : 100;
        $category_randomize = isset($params->sponsor_category_randomize) ? $params->sponsor_category_randomize : false;
        $category_display_type = isset($params->sponsor_category_display_type) ? $params->sponsor_category_display_type : 1;
    ?>

    <h2><?php echo $category[0]->categories_title ?></h2>

    <?php if ($category_display_type == 2): // Slider ?>
        <div class="managedsponsors_sponsors_slider slider">
            <?php foreach($category as $item): ?>
            <?php 
                $has_site = $item->website && trim($item->website) != '';
                $href = ($has_site) ? $item->website : '#';
                $tag = ($has_site) ? 'a' : 'div';

                $item_size_percentage = (trim($item->size) != '') ? $item->size : 100;
                $item_margin = (trim($item->margin) != '') ? $item->margin : null;
                $item_padding = (trim($item->padding) != '') ? $item->padding : null;

                $item_height = apply_percentage(apply_percentage($BASE_HEIGHT, $category_size_percentage), $item_size_percentage);
            ?>

            <<?php echo $tag; ?> 
                class="managedsponsors_sponsor_slide slide"
                href="<?php echo $href ?>"
                title="<?php echo $item->name; ?>"
                style="<?php if ($item_margin !== null): ?>margin:<?php echo $item_margin; ?>;<?php endif; ?>"
            >
                <?php if (trim($item->image) != ''): ?>
                <img 
                    src="<?php echo $item->image ?>"
                    alt="<?php echo $item->name; ?>"
                    style="
                        width: <?php echo $item_height; ?>;
                        <?php if ($item_padding !== null): ?>padding:<?php echo $item_padding; ?>;<?php endif; ?>
                    "
                >
                <?php else: ?>
                <strong class="managedsponsors_textual"><?php echo $item->name; ?></strong>
                <?php endif; ?>
            </<?php echo $tag; ?>>

            <?php endforeach; ?>
        </div>
    <?php else: ?>
    <div class="managedsponsors_sponsors">
        <?php foreach($category as $item): ?>
            <?php 
                $has_site = $item->website && trim($item->website) != '';
                $href = ($has_site) ? $item->website : '#';
                $tag = ($has_site) ? 'a' : 'div';

                $item_size_percentage = (trim($item->size) != '') ? $item->size : 100;
                $item_margin = (trim($item->margin) != '') ? $item->margin : null;
                $item_padding = (trim($item->padding) != '') ? $item->padding : null;

                $item_height = apply_percentage(apply_percentage($BASE_HEIGHT, $category_size_percentage), $item_size_percentage);
            ?>
        
            <<?php echo $tag; ?> 
                class="managedsponsors_sponsor"
                href="<?php echo $href ?>"
                title="<?php echo $item->name; ?>"
                style="
                    <?php if ($item_margin !== null): ?>margin:<?php echo $item_margin; ?>;<?php endif; ?>
                "
            >
                    <?php if ($has_site): ?><div class="managedsponsors_overlay" aria-hidden="true">
                        <span>Read More&hellip;</span>
                    </div><?php endif ?>
                
                <?php if (trim($item->image) != ''): ?>
                <img 
                    src="<?php echo $item->image ?>"
                    alt="<?php echo $item->name; ?>"
                    style="
                        height: <?php echo $item_height; ?>;
                        <?php if ($item_padding !== null): ?>padding:<?php echo $item_padding; ?>;<?php endif; ?>
                    "
                >
                <?php else: ?>
                <strong class="managedsponsors_textual"><?php echo $item->name; ?></strong>
                <?php endif; ?>
            </<?php echo $tag; ?>>

        <?php endforeach; ?>
        </div>
    </div>
    <?php endif; ?>

<?php endforeach; ?>
  
