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
 * @package    local_mb2builder
 * @copyright  2018 - 2022 Mariusz Boloz (mb2moodle.com)
 * @license    Commercial https://themeforest.net/licenses
 */

define('AJAX_SCRIPT', true);

require_once( __DIR__ . '/../../../config.php' );
require_once( $CFG->libdir . '/adminlib.php' );
require_once( $CFG->libdir . '/filelib.php' );

// Get builder files
require_once( __DIR__ . '/../lib.php' );
require_once( __DIR__ . '/../classes/builder_content.php' );

// Require theme lib files
require_once( LOCAL_MB2BUILDER_PATH_THEME . '/lib.php' );

// Get url params from ajax call
$urlparts = parse_url( $PAGE->url );
$urloptions = array();

if ( isset( $urlparts['query'] ) )
{
    parse_str( str_replace( '&amp;', '&', $urlparts['query'] ), $urloptions );
}

$context = context_system::instance();
$PAGE->set_url( '/local/mb2builder/ajax/coursetabs.php' );
$PAGE->set_context( $context );

require_login();
require_sesskey();

$atts = array();

// Get default settings
$options = array(
    'id' => 'coursetabs',
    'limit' => 12,
    'filtertype' => 'category',
    'catids' => '',
    'excats' => 0,
    'tagids' => '',
    'extags' => 0,
    'columns' => 4,
    'gutter' => 'normal',
    'custom_class' => '',
    'mt' => 0,
    'mb' => 30,
    'catdesc' => 0,
    'coursecount' => 0,
    // carousel options
    'carousel' => 0,
    'sloop' => 0,
    'snav' => 1,
    'sdots' => 0,
    'autoplay' => 0,
    'pausetime' => 5000,
    'animtime' => 450,
    //
    'template' => ''
);

$options = mb2builderBuilderContent::get_options( $options, $urloptions );
$options['lazy'] = 0;

if ( local_mb2builder_get_theme_name() === 'mb2nl' )
{
    if ( function_exists( 'theme_mb2nl_coursetabs_tabs' ) && function_exists( 'theme_mb2nl_coursetabs_courses' ) )
    {
        echo theme_mb2nl_coursetabs_tabs( $options );
        echo theme_mb2nl_coursetabs_courses( $options );
    }
    else
    {
        echo 'Function doesn’t exist (theme_mb2nl_coursetabs_tabs, theme_mb2nl_coursetabs_courses). Update theme and page builder plugin.';
    }
}
