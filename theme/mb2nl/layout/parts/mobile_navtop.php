<?php
// This file is part of Moodle - http://moodle.org/
//
// Moodle is free software: you can redistribute it and/or modify
// it under the terms of the GNU General Public License as published by
// the Free Software Foundation, either version 3 of the License, or
// (at your option) any later version.
//
// Moodle is distributed in the hope that it will be useful,
// but WITHOUT ANY WARRANTY; without even the implied warranty of
// MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
// GNU General Public License for more details.
//
// You should have received a copy of the GNU General Public License
// along with Moodle.  If not, see <http://www.gnu.org/licenses/>.

/**
 *
 * @package   theme_mb2nl
 * @copyright 2017 - 2022 Mariusz Boloz (mb2moodle.com)
 * @license   Commercial https://themeforest.net/licenses
 *
 */

defined('MOODLE_INTERNAL') || die();

$svg = theme_mb2nl_svg();
$headercontent = theme_mb2nl_theme_setting($PAGE, 'headercontent') && theme_mb2nl_static_content( theme_mb2nl_theme_setting($PAGE, 'headercontent'), false );

?>
<div class="mobile-navtop menu-extracontent">
	<div class="menu-extracontent-controls">
		<?php if ( theme_mb2nl_site_menu() ) : ?>
			<button class="themereset menu-extra-controls-btn menu-extra-controls-quicklinks" aria-label="<?php echo get_string('quicklinks', 'theme_mb2nl'); ?>" aria-controls="menu-quicklinkscontainer"><?php echo $svg['dots']; ?></button>
		<?php endif; ?>
		<button class="themereset menu-extra-controls-btn menu-extra-controls-search" aria-label="<?php echo get_string('togglesearch', 'theme_mb2nl'); ?>" aria-controls="menu-searchcontainer"><?php echo $svg['magnifying-glass']; ?></button>
		<?php if ( $headercontent ) : ?>
			<button class="themereset menu-extra-controls-btn menu-extra-controls-content" aria-label="<?php echo get_string('toggleheadercontent', 'theme_mb2nl'); ?>" aria-controls="menu-staticontentcontainer"><?php echo $svg['circle-question']; ?></button>
		<?php endif; ?>
	</div>
	<?php if ( theme_mb2nl_site_menu() ) : ?>
		<div id="menu-quicklinkscontainer" class="menu-extracontent-content">
			<?php echo theme_mb2nl_site_menu(true); ?>
		</div>
	<?php endif; ?>
	<?php echo theme_mb2nl_search_form( true ); ?>
	<?php if ( $headercontent ) : ?>
		<div id="menu-staticontentcontainer" class="menu-extracontent-content">
			<?php echo theme_mb2nl_static_content( theme_mb2nl_theme_setting($PAGE, 'headercontent'), true, true, array( 'listcls' => 'mobile-header-list' ) ); ?>
		</div>
	<?php endif; ?>
</div>