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

defined('MOODLE_INTERNAL') || die();

global $CFG, $PAGE;

// Define basic paths
if ( ! defined( 'LOCAL_MB2BUILDER_PATH_FIELDS' ) )
{
    define( 'LOCAL_MB2BUILDER_PATH_FIELDS', $CFG->dirroot . '/local/mb2builder/builder/fields' );
}

if ( ! defined( 'LOCAL_MB2BUILDER_PATH_THEME' ) )
{
    define( 'LOCAL_MB2BUILDER_PATH_THEME', local_mb2builder_get_theme_path() );
}

if ( ! defined( 'LOCAL_MB2BUILDER_THEME_DIR' ) )
{
    define( 'LOCAL_MB2BUILDER_THEME_DIR', local_mb2builder_themedir() );
}

if ( ! defined( 'LOCAL_MB2BUILDER_PATH_THEME_ASSETS' ) )
{
    define( 'LOCAL_MB2BUILDER_PATH_THEME_ASSETS', LOCAL_MB2BUILDER_PATH_THEME . '/assets' );
}

if ( ! defined( 'LOCAL_MB2BUILDER_PATH_ELEMENTS' ) )
{
    define( 'LOCAL_MB2BUILDER_PATH_ELEMENTS', $CFG->dirroot . '/local/mb2builder/builder/elements' );
}

if ( ! defined( 'LOCAL_MB2BUILDER_PATH_THEME_ELEMENTS' ) )
{
    define( 'LOCAL_MB2BUILDER_PATH_THEME_ELEMENTS', LOCAL_MB2BUILDER_PATH_THEME . '/builder2/elements/' );
}

if ( ! defined( 'LOCAL_MB2BUILDER_PATH_THEME_SETTINGS' ) )
{
    define( 'LOCAL_MB2BUILDER_PATH_THEME_SETTINGS', LOCAL_MB2BUILDER_PATH_THEME . '/builder2/settings/' );
}

if ( ! defined( 'LOCAL_MB2BUILDER_PATH_THEME_IMPORT_BLOCKS' ) )
{
    define( 'LOCAL_MB2BUILDER_PATH_THEME_IMPORT_BLOCKS', LOCAL_MB2BUILDER_PATH_THEME . '/builder2/import/blocks/' );
}

if ( ! defined( 'LOCAL_MB2BUILDER_PATH_THEME_IMPORT_LAYOUTS' ) )
{
    define( 'LOCAL_MB2BUILDER_PATH_THEME_IMPORT_LAYOUTS', LOCAL_MB2BUILDER_PATH_THEME . '/builder2/import/layouts/' );
}

// Scripts for all builder pages
if ( is_object( $PAGE ) && preg_match( '@-mb2builder@', $PAGE->pagetype ) )
{
    $PAGE->requires->js( '/local/mb2builder/builder/js/selectors.js' );
    $PAGE->requires->js( '/local/mb2builder/builder/js/helper.js' );
    $PAGE->requires->js( '/local/mb2builder/builder/js/layoutdata.js' );
}

// Load styles and script on editing page only
if ( is_object( $PAGE ) && ( $PAGE->pagetype === 'local-mb2builder-edit-page' || $PAGE->pagetype === 'local-mb2builder-edit-footer' ) )
{
    $PAGE->requires->css( '/local/mb2builder/builder/css/styles_edit_page.css' );
    $PAGE->requires->js( '/local/mb2builder/builder/js/builder_edit.js' );
}

// Load styles and script on customizing page only
if ( is_object( $PAGE ) && $PAGE->pagetype === 'local-mb2builder-customize' )
{
    $PAGE->requires->jquery();
    $PAGE->requires->jquery_plugin( 'ui' );
    $PAGE->requires->css( '/local/mb2builder/builder/css/styles_customize.css' );
    $PAGE->requires->js( '/local/mb2builder/builder/js/builder.js' );
}

function local_mb2builder_get_theme_path()
{
    global $CFG;

    return $CFG->dirroot . '/' . local_mb2builder_themedir() . '/' . local_mb2builder_get_theme_name();
}

function local_mb2builder_get_theme_name()
{
    global $CFG;

    if ( isset( get_config( 'local_mb2builder' )->theme ) && get_config( 'local_mb2builder' )->theme )
    {
        return get_config( 'local_mb2builder' )->theme;
    }

    return $CFG->theme;
}



function local_mb2builder_showon_field( $data )
{

    $output = '';

    if ($data == '')
    {
        return;
    }

    $data_arr = explode(':', $data);

    $output .= ' data-showon_field="' . $data_arr[0] . '"';
    $output .= ' data-showon_value="' . $data_arr[1] . '"';

    return $output;

}



function local_mb2builder_showon_field2( $data )
{

    $output = '';

    if ($data == '')
    {
        return;
    }

    $data_arr = explode(':', $data);

    $output .= ' data-showon_field2="' . $data_arr[0] . '"';
    $output .= ' data-showon_value2="' . $data_arr[1] . '"';

    return $output;

}

function local_mb2builder_themedir()
{
    global $CFG;

    $themedir = 'theme';

    if ( isset( $CFG->themedir ) && $CFG->themedir !== '' )
    {
        $themedir = explode('/', $CFG->themedir);
        $themedir = end($themedir);
    }

    return $themedir;

}



function local_mb2builder_field_actions( $atts )
{

    $output = '';
    $actions = array(
        'action',
        'selector',
        'selectorbg',
        'selector2',
        'style_properity',
        'style_properity2',
        'cssvariable',
        'class_prefix',
        'class_remove',
        'changemode',
        'callback',
        'reset',
        'parent',
        'html',
        'demoimg',
        'default',
        'globalchild',
        'globalparent',
        'style_suffix',
        'ignorecarousel',
        'attribute',
        'colorclass',
        'numclass',
        'sizepref',
        'numclassattr',
        'numclasselector',
        'advlayout',
        'setting'
    );

    foreach( $actions as $a )
    {
        if ( ! isset( $atts[$a]) )
        {
            $atts[$a] = '';
        }

        $output .= ' data-' . $a . '="' . $atts[$a] . '"';
    }

    return $output;

}



/**
 * Serve the files from the MYPLUGIN file areas
 *
 * @param stdClass $course the course object
 * @param stdClass $cm the course module object
 * @param stdClass $context the context
 * @param string $filearea the name of the file area
 * @param array $args extra arguments (itemid, path)
 * @param bool $forcedownload whether or not force download
 * @param array $options additional options affecting the file serving
 * @return bool false if the file not found, just send the file otherwise and do not return anything
 */
function local_mb2builder_pluginfile($course, $cm, $context, $filearea, $args, $forcedownload, array $options=array()) {

    // Check the contextlevel is as expected - if your plugin is a block, this becomes CONTEXT_BLOCK, etc.
    if ( $context->contextlevel != CONTEXT_SYSTEM )
    {
        return false;
    }

    // Make sure the filearea is one of those used by the plugin.
    if ( $filearea !== 'images' )
    {
        return false;
    }

    // Make sure the user is logged in and has access to the module (plugins that are not course modules should leave out the 'cm' part).
    //require_login($course, false, $cm);

    // Check the relevant capabilities - these may vary depending on the filearea being accessed.
    //if ( ! has_capability( 'local/mb2builder:view', $context ) )
    //{
        //return false;
    //}

    // Leave this line out if you set the itemid to null in make_pluginfile_url (set $itemid to 0 instead).
    //$itemid = array_shift($args); // The first item in the $args array.

    // Use the itemid to retrieve any relevant data records and perform any security checks to see if the
    // user really does have access to the file in question.

    // Extract the filename / filepath from the $args array.
    $filename = array_pop( $args ); // The last item in the $args array.
    //if (!$args) {
    $filepath = '/'; // $args is empty => the path is '/'
    //} else {
    //    $filepath = '/'.implode('/', $args).'/'; // $args contains elements of the filepath
    //}

    // Retrieve the file from the Files API.
    $fs = get_file_storage();
    $file = $fs->get_file( $context->id, 'local_mb2builder', $filearea, 0, $filepath, $filename );
    if ( ! $file )
    {
        return false; // The file does not exist.
    }

    // We can now send the file back to the browser - in this case with a cache lifetime of 1 day and no filtering.
    // From Moodle 2.3, use send_stored_file instead.
    send_stored_file( $file, 86400, 0, $forcedownload, $options );
}