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

$isPageBg = theme_mb2nl_pagebg_image($PAGE);

?>
<body <?php echo $OUTPUT->body_attributes( theme_mb2nl_body_cls() ) . $isPageBg; ?>>
<?php echo $OUTPUT->standard_top_of_body_html(); ?>
<?php echo theme_mb2nl_acsb_block(); ?>
<?php if ( theme_mb2nl_theme_setting( $PAGE,'loadingscr' ) ) : ?>
	<?php echo theme_mb2nl_loading_screen(); ?>
<?php endif; ?>
<div id="page-outer">
<div id="page">
<div id="page-a">
	<div class="container-fluid">
		<div class="row">
			<div class="col-md-12">
				<?php echo $OUTPUT->theme_part('logo'); ?>
			</div>
		</div>
	</div>
</div><!-- //end #page-a -->
<div id="page-b">
