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

$iconnav = theme_mb2nl_iconnav(true);
$socialtt = theme_mb2nl_theme_setting($PAGE, 'socialtt') == 1 ? 'top' : '';
?>
<?php if ( theme_mb2nl_theme_setting( $PAGE, 'socialheader' ) || $iconnav || theme_mb2nl_header_buttons() ) : ?>
<div class="mobile-navbottom extra-content" id="mobilemenu_extra-content">
	<?php echo theme_mb2nl_header_buttons(3, true); ?>
	<?php echo $iconnav; ?>
	<?php if (theme_mb2nl_theme_setting( $PAGE, 'socialheader' ) ) : ?>
		<?php echo theme_mb2nl_social_icons($PAGE, array('tt'=>$socialtt,'pos'=>'header')); ?>
	<?php endif; ?>
</div>
<?php endif; ?>