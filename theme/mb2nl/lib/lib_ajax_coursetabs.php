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

 define('AJAX_SCRIPT', true);

 require_once( __DIR__ . '/../../../config.php' );
 require_once( $CFG->libdir . '/adminlib.php' );

 require_sesskey();

 if ( ! confirm_sesskey() )
 {
     die;
 }

 $teme_dir = '/theme';

 if ( isset( $CFG->themedir ) )
 {
     $teme_dir = $CFG->themedir;
     $teme_dir = str_replace($CFG->dirroot, '', $CFG->themedir);
 }

 // Require theme lib files
 require_once($CFG->dirroot . $teme_dir . '/mb2nl/lib.php');

// Get url params from ajax call
$urlparts = parse_url( $PAGE->url );
$urloptions = array();

if ( isset( $urlparts['query'] ) )
{
     parse_str( str_replace( '&amp;', '&', $urlparts['query'] ), $urloptions );
}

$context = context_system::instance();
$PAGE->set_url( '/theme/mb2nl/lib/lib_ajax_coursetabs.php' );
$PAGE->set_context( $context );

$urloptions['categories'] = $urloptions['filtertype'] === 'tag' ? array() : array( $urloptions['categories'] );
$urloptions['tags'] = $urloptions['filtertype'] === 'category' ? array() : array( $urloptions['categories'] );
$urloptions['lazy'] = 0;

$courses = theme_mb2nl_coursetabs_tabcontent( $urloptions );

echo $courses;
