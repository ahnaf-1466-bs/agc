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

//defined('MOODLE_INTERNAL') || die();

require_once( __DIR__ . '/../../config.php' );
require_once( __DIR__ . '/lib.php' );
require_once( __DIR__ . '/classes/pages_api.php' );
require_once( __DIR__ . '/classes/pages_helper.php' );
require_once( $CFG->libdir . '/adminlib.php' );
require_once( $CFG->libdir . '/tablelib.php' );

// Optional parameters
$deleteid = optional_param('deleteid', 0, PARAM_INT);
$moveup = optional_param('moveup', 0, PARAM_INT);
$movedown = optional_param('movedown', 0, PARAM_INT);
$returnurl = optional_param('returnurl', '/local/mb2builder/index.php', PARAM_LOCALURL);

// Links
$editpage = '/local/mb2builder/edit-page.php';
$managepages = '/local/mb2builder/index.php';
$deletepage = '/local/mb2builder/delete-page.php';
$baseurl = new moodle_url($managepages);
$returnurl = new moodle_url($returnurl);

// Configure the context of the page
$context = context_system::instance();
$PAGE->set_context( $context );
$PAGE->set_url( '/local/mb2builder/index.php' );
$PAGE->set_pagelayout('admin'); // This is require for page navigation

require_capability( 'local/mb2builder:managepages', context_system::instance() );
$can_manage = has_capability( 'local/mb2builder:managepages', context_system::instance() );

// Get sorted pages
$sortorder_items = Mb2builderPagesApi::get_sortorder_items();

// Delete the page
if ($can_manage && $deleteid)
{
    Mb2builderPagesApi::delete($deleteid);
    $message = get_string('pagedeleted', 'local_mb2builder');
}

// Move up
if ($can_manage && $moveup)
{
    Mb2builderPagesApi::move_up($moveup);
    $message = get_string('pageupdated', 'local_mb2builder', array('title' => Mb2builderPagesApi::get_record($moveup)->title));
}

// Move down
if ($can_manage && $movedown)
{
    Mb2builderPagesApi::move_down($movedown);
    $message = get_string('pageupdated', 'local_mb2builder', array('title' => Mb2builderPagesApi::get_record($movedown)->title));
}

if (isset($message))
{
    redirect($returnurl, $message);
}

// Page title
$titlepage = get_string('pluginname', 'local_mb2builder');
$PAGE->set_heading($titlepage);
$PAGE->set_title($titlepage);
echo $OUTPUT->header();
echo $OUTPUT->heading(get_string('managepages', 'local_mb2builder'));
//echo $OUTPUT->single_button(new moodle_url($editpage, array( 'pageid' => uniqid( 'page_' ), 'pagename' => urlencode( 'Page ' . time() ) ) ), get_string('addpage', 'local_mb2builder'), 'get');

// Table declaration
$table = new flexible_table('mb2builder-pages-table');

// Customize the table
$table->define_columns(
    array(
        'name',
        'shortcode',
        'moodlepage',
        'actions',
    )
);

$table->define_headers(
    array(
        get_string('name', 'moodle'),
        get_string('shortcode', 'local_mb2builder'),
        get_string('moodlepage', 'local_mb2builder'),
        get_string('actions', 'moodle'),
    )
);

$table->define_baseurl($baseurl);
$table->set_attribute( 'class', 'generaltable' );
$table->column_class( 'actions', 'text-right align-middle' );
$table->column_class( 'name', 'align-middle' );
$table->column_class( 'shortcode', 'align-middle' );
$table->setup();

foreach ($sortorder_items as $item)
{

    $callback = Mb2builderPagesApi::get_record($item);

	// Filling of information columns
    $titlecallback = html_writer::div(html_writer::link(new moodle_url($editpage, array('itemid' => $callback->id)), '<strong>' . $callback->title . '</strong>'));

    // Created and modified by
    $shortcodeitem = '<div><input style="width:auto;min-width:148px;min-height:0;padding:.12rem .2rem;border-color:#dee2e6;line-height:1;color:green!important;font-weight:bold;" type="text" value=\'[mb2page pageid="' . $callback->id . '"]\' readonly="readonly" onfocus="this.select()" /></div>';

    // Used in
    $checkforpage = Mb2builderPagesApi::check_for_page( $callback->id );
    $moodlepageitem = $checkforpage ? $checkforpage : get_string( 'nopage', 'local_mb2builder' );

	// Defining page status
    $moveupicon = 't/up';
    $movedownicon = 't/down';
    $moveupstring = get_string('moveup', 'moodle');
    $strmovedown = get_string('movedown', 'moodle');
    $previtem = Mb2builderPagesApi::get_record_near($callback->id, 'prev');
    $nextitem = Mb2builderPagesApi::get_record_near($callback->id, 'next');

    // Link to move up
    $moveuplink = new moodle_url($managepages, array('moveup' => $callback->id));
    $moveupitem = $previtem ? $OUTPUT->action_icon($moveuplink, new pix_icon($moveupicon, $moveupstring)) : '';

    // Link to move down
    $movedownlink = new moodle_url($managepages, array('movedown' => $callback->id));
    $movedownitem = $nextitem ? $OUTPUT->action_icon($movedownlink, new pix_icon($movedownicon, $strmovedown)) : '';

    // Link for editing
    $editlink = new moodle_url($editpage, array('itemid' => $callback->id));
    $edititem = $OUTPUT->action_icon($editlink, new pix_icon('t/edit', get_string('edit', 'moodle')));

    // Link to remove
    $deletelink = new moodle_url($deletepage, array('deleteid' => $callback->id));
    $deleteitem = $OUTPUT->action_icon($deletelink, new pix_icon('t/delete', get_string('delete', 'moodle')));

    // Check if user can manage items
    $actions = $can_manage ? $moveupitem . $movedownitem . $edititem . $deleteitem : '';

	$table->add_data( array( $titlecallback, $shortcodeitem, $moodlepageitem, $actions ) );
    //$table->add_data( array( $titlecallback, $moodlepageitem, $actions ) );

}

// Display the table
$table->print_html();

echo $OUTPUT->footer();
?>
