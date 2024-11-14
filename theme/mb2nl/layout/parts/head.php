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

echo $OUTPUT->doctype();

// Disable secondary navigation in Moodle 4
// New Learning provide custom navigation
if ( $CFG->version >= 2022041900 )
{
    $PAGE->set_secondary_navigation(false);
}

// Get boost theme amd files 2021051700
$inline_js = 'require([\'theme_boost/loader\']);';

if ( $CFG->version >= 2020061500 && $CFG->version < 2021051700 ) // Moodle 3.9 - 3.10
{
    $inline_js .= 'require([\'jquery\',\'theme_boost/bootstrap/index\'], function($){$(\'[data-toggle="tooltip"]\').tooltip();$(\'[data-toggle="popover"]\').popover()});';
}
elseif ( $CFG->version < 2020061500 ) // Moodle 3.6 - 3.8
{
    $inline_js .= 'require([\'jquery\',\'theme_boost/tooltip\'], function($){$(\'[data-toggle="tooltip"]\').tooltip()});';
}

$PAGE->requires->js_amd_inline( $inline_js );
$PAGE->requires->js_call_amd('theme_mb2nl/actions','Init');
$PAGE->requires->js_call_amd('theme_mb2nl/access', 'focusClass');
$PAGE->requires->js_call_amd('theme_mb2nl/sidebars','sidebarToggle');
$PAGE->requires->js_call_amd('theme_mb2nl/scrollpos','panelLink');

// Mega menu scripts
//if ( theme_mb2nl_is_megamenu_plugin() )
//{
    $PAGE->requires->js_call_amd('theme_mb2nl/megamenu','setWrapPos');
    $PAGE->requires->js_call_amd('theme_mb2nl/megamenu','toggleSubmenus');
//}

// if ( count( theme_mb2nl_acsb_buttons() ) )
// {
//     $PAGE->requires->js_call_amd('theme_mb2nl/access','accessibilityTools');
// }

theme_mb2nl_skiplinks();
theme_mb2nl_fpredirect();

?>
<html <?php echo $OUTPUT->htmlattributes(); ?> class="html<?php echo theme_mb2nl_acsb_cls(); ?>">
<head>
    <title><?php echo $OUTPUT->page_title(); ?></title>
    <?php echo theme_mb2nl_favicon(); ?>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <?php echo theme_mb2nl_google_fonts($PAGE); ?>
    <?php theme_mb2nl_scripts(); ?>
    <?php echo $OUTPUT->standard_head_html(); ?>
	<?php echo theme_mb2nl_ganalytics($PAGE); ?>
    <?php echo theme_mb2nl_builder_style(); ?>
</head>
