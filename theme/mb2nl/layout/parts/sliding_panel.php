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

$loginicon = ( ! isloggedin() or isguestuser() ) ? 'lock' : 'user';
$logintitle = ( ! isloggedin() or isguestuser() ) ? get_string('login','core') : get_string('profile','core');

?>
<?php if ( ! theme_mb2nl_is_header_tools_modal() ) : ?>
<div class="sliding-panel dark1 closed">
	<div class="container-fluid">
		<div class="row">
			<div class="col-md-12 clearfix">
				<?php echo theme_mb2nl_search_form(); ?>
               	<?php echo theme_mb2nl_login_form(); ?>
				<?php echo theme_mb2nl_theme_links(); ?>
				<?php //if ( theme_mb2nl_header_tools_pos() == 1 ) : ?>
					<?php //echo theme_mb2nl_header_tools(); ?>
				<?php //endif; ?>
			</div>
		</div>
	</div>
</div>
<?php endif; ?>
