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
 * @package    local_mb2reviews
 * @copyright  2021 Mariusz Boloz (mb2themes.com)
 * @license    Commercial https://themeforest.net/licenses
 */

//defined('MOODLE_INTERNAL') || die();

require_once( __DIR__ . '/../../config.php' );
require_once( __DIR__ . '/classes/api.php' );
require_once( __DIR__ . '/classes/helper.php' );
require_once( __DIR__ . '/lib.php' );
require_once( $CFG->libdir . '/adminlib.php' );
require_once( $CFG->libdir . '/tablelib.php' );

// Optional parameters
$courseid = optional_param('course', 0, PARAM_INT );
$hideshowid = optional_param( 'hideshowid', 0, PARAM_INT );
$featuredid = optional_param( 'featuredid', 0, PARAM_INT );
$deleteid = optional_param( 'deleteid', 0, PARAM_INT );
$page = optional_param( 'page', 0, PARAM_INT );
$perpage = 20;
$deleteitem = '';
$actions = '';

// Links
$editreview = '/local/mb2reviews/edit.php';
$managereviews = '/local/mb2reviews/index.php';
$deletereview = '/local/mb2reviews/delete.php';
$urlparameters = array( 'course' => $courseid );
$baseurl = new moodle_url( $managereviews, $urlparameters );
$systemcontext = context_system::instance();

// Configure the context of the page
admin_externalpage_setup( 'local_mb2reviews_managereviews', '', null, $baseurl );

if ( $courseid )
{
    $coursecontext = context_course::instance( $courseid );
    require_capability( 'local/mb2reviews:managecourseitems', $coursecontext );
    $PAGE->set_context( $coursecontext );
    $can_manage = has_capability( 'local/mb2reviews:managecourseitems', $coursecontext );
    $course = Mb2reviewsApi::get_course( $courseid );
    $heading = get_string( 'managecoursereviewstitle', 'local_mb2reviews', array( 'course' => $course->fullname ) );
}
else
{
    require_capability('local/mb2reviews:manageitems', $systemcontext );
    $PAGE->set_context( $systemcontext );
    $can_manage = has_capability('local/mb2reviews:manageitems', $systemcontext );
    $heading = get_string( 'pluginname', 'local_mb2reviews' );
}

$can_delete = has_capability('local/mb2reviews:deleteitems', $systemcontext );
$PAGE->set_url( $baseurl );

// Delete the review
if ( $can_delete && $deleteid )
{
    Mb2reviewsApi::delete( $deleteid );
    $message = get_string('reviewdeleted', 'local_mb2reviews');
}

// Switching the status of the review
if ( $can_manage && $hideshowid )
{
    Mb2reviewsApi::switch_status( $hideshowid );
    $message = get_string( 'reviewupdated', 'local_mb2reviews', array( 'title' => Mb2reviewsApi::get_record($hideshowid)->id ) );
    redirect( $baseurl, $message );
}

// Switch featured status
if ( $can_manage && $featuredid )
{
    Mb2reviewsApi::switch_featured( $featuredid );
    $message = get_string( 'reviewupdated', 'local_mb2reviews', array( 'title' => Mb2reviewsApi::get_record($featuredid)->id ) );
    redirect( $baseurl, $message );
}


$items = Mb2reviewsApi::get_list_records( $courseid, false, false, false, $page, $perpage );
$itemscount = Mb2reviewsApi::get_list_records( $courseid, false, false, true );

// Page title
$PAGE->set_heading( get_string( 'pluginname', 'local_mb2reviews' )  );
$PAGE->set_title( get_string( 'pluginname', 'local_mb2reviews' ) );
echo $OUTPUT->header();
echo $OUTPUT->heading( $heading );

// Table declaration
$table = new flexible_table('mb2reviews-reviews-table');
$columns = array( 'rating', 'createdby', 'timecreated', 'content', 'helpful', 'actions' );
$headers = array( get_string('rating', 'local_mb2reviews'), get_string('user'), get_string('timecreated', 'local_mb2reviews'), get_string('content'), get_string('feedback', 'local_mb2reviews'), get_string('actions') );

if ( ! $courseid )
{
    $columns = array_merge( array( 'course' ), $columns );
    $headers = array_merge( array( get_string('course') ), $headers );
}

$table->define_baseurl($baseurl);
$table->define_columns( $columns );
$table->define_headers( $headers );
$table->set_attribute('class', 'generaltable');
$table->column_class('actions', 'text-right align-middle');
$table->setup();

foreach ( $items as $item )
{

    $course = Mb2reviewsApi::get_course( $item->course );
    $coursename = '<div class="table-review-course" title="' . strip_tags( $course->fullname ) . '">' . $course->fullname . '</div>';
    $userrating = '';

    $userrating .= '<div class="table-review-rating">';
    for ( $i = 1; $i <= 5; $i++ )
    {
        $starcls = $i > $item->rating ? ' inactive' : '';
        $userrating .= '<i class="fa fa-star' .$starcls . '"></i>';
    }
    $userrating .= '</div>';

    $user = Mb2reviewsApi::get_user( $item->createdby );
    $usertext = '<div class="table-review-user" title="' . strip_tags( $user->firstname . ' ' . $user->lastname ) . '">' . $user->firstname . ' ' . $user->lastname . '</div>';

    // timecreated
    $timecreateddate = userdate( $item->timecreated, get_string( 'strftimedatemonthabbr', 'local_mb2reviews' ) );
    $timecreated = '<div class="mb2reviews-admin-time">' . $timecreateddate . '</div>';

    // Feedback
    $isfeedback = $item->helpful;

    // Defining review status
    $hideshowicon = 't/show';
    $hideshowstring = get_string('enablereview', 'local_mb2reviews');

    if ( (bool) $item->enable )
    {
        $hideshowicon = 't/hide';
        $hideshowstring = get_string('disablereview', 'local_mb2reviews');
    }

    // Link to enable / disable the review
    $hideshowlink = new moodle_url( $managereviews, array( 'hideshowid' => $item->id, 'course' => $courseid ) );
    $hideshowitem = $OUTPUT->action_icon( $hideshowlink, new pix_icon( $hideshowicon, $hideshowstring ) );

    // Link for editing
    $editlink = new moodle_url($editreview, array('itemid' => $item->id, 'course' => $course->id ));
    $edititem = $OUTPUT->action_icon($editlink, new pix_icon('t/edit', get_string('edit', 'moodle')));

    // Link for fetured
    $featuredicon = 'i/star-o';
    $featuredstring = get_string('featured', 'local_mb2reviews');

    if ( (bool) $item->featured )
    {
        $featuredicon = 'i/star';
    }

    $featuredlink = new moodle_url($managereviews, array('featuredid' => $item->id, 'course' => $courseid ));
    $featureditem = strip_tags( $item->content ) !== '' ? $OUTPUT->action_icon( $featuredlink, new pix_icon( $featuredicon, $featuredstring ) ) : '';

    // Content
    $iscontent = '<div class="table-review-content featured' . $item->featured . '"><a href="' . $editlink . '" title="' . strip_tags( $item->content ) . '">' . $item->content . '</a></div>';

    // Link to remove
    if ( $can_delete )
    {
        $deletelink = new moodle_url($deletereview, array( 'deleteid' => $item->id ) );
        $deleteitem = $OUTPUT->action_icon($deletelink, new pix_icon('t/delete', get_string('delete', 'moodle')));
    }

    // Check if user can manage items
    if ( $can_manage && $can_delete )
    {
        $actions = $featureditem . $hideshowitem . $edititem . $deleteitem;
    }
    elseif ( $can_manage && ! $can_delete )
    {
        $actions = $featureditem . $hideshowitem . $edititem;
    }

    if ( $courseid )
    {
        $table->add_data( array( $userrating, $usertext, $timecreated, $iscontent, $isfeedback, $actions ) );
    }
    else
    {
        $table->add_data( array( $coursename, $userrating, $usertext, $timecreated, $iscontent, $isfeedback, $actions ) );
    }

}

$table->pageable(true);
$table->currpage = $page;
$table->pagesize = 5;
// Display the table
$table->print_html();

echo $OUTPUT->paging_bar( $itemscount, $page, $perpage, $baseurl );

echo $OUTPUT->footer();
?>
