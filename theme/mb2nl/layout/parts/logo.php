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

$customlogin = theme_mb2nl_is_login( true );
$logos = array('logo-light', 'logo-dark');

?>
<div class="logo-wrap">
	<div class="main-logo">
		<a href="<?php echo new moodle_url('/'); ?>" title="<?php echo get_site()->fullname; ?>">
			<?php
				foreach ($logos as $l)
				{
					$src = $l === 'logo-light' ? theme_mb2nl_logo_url() : theme_mb2nl_logo_url( false, $l );
					$svgcls = theme_mb2nl_is_svg($src) ? ' is_svg' : ' no_svg';
					echo '<img class="' . $l . $svgcls . '" src="' . $src . '" alt="' . get_site()->fullname . '">';
				}
			?>
		</a>
	</div>
</div>
