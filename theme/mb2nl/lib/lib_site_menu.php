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


/*
 *
 * Method to display site menu links
 *
 */
function theme_mb2nl_site_menu($mobile = false)
{

	global $PAGE, $COURSE, $USER, $OUTPUT;

	if ( ! isloggedin() || isguestuser() )
	{
		return;
	}

	$output = '';
	$isCourse = (isset($COURSE->id) && $COURSE->id > 1);
	$context = context_course::instance($COURSE->id);
	$enrolled = is_enrolled($context, $USER->id,'',true);
	$excludedlinks = explode(',',theme_mb2nl_theme_setting($PAGE,'excludedlinks'));
	$menuitems = theme_mb2nl_site_menu_items();
	$svg = theme_mb2nl_svg();

	$course_access = theme_mb2nl_site_access();
	$can_manage = array('admin','manager','editingteacher','teacher');

	if ( ! $mobile )
	{
		$output .= '<div id="quicklinks" class="quicklinks">';
		$output .= '<button id="quicklinks-toggle" type="button" class="themereset" aria-label="' . get_string('quicklinks', 'theme_mb2nl') . '">';
		$output .= $svg['dots'];
		$output .= '</button>';
	}

	$output .= '<ul class="quicklinks-list">';

	foreach ( $menuitems as $k => $el )
	{
		$shown = isset( $el['shown'] ) ? $el['shown'] : true;
		$access = isset( $el['cap'] ) ? $el['cap'] : in_array( $course_access, $el['access'] );

		if ( in_array( $k, $excludedlinks ) || ! $access || ! $el['course'] || ! $shown )
		{
			continue;
		}

		$output .= '<li class="item-' . $k . '">';
		$output .= '<a href="' . $el['link'] . '" class="item-link">';
		$output .= '<span class="static-icon" aria-hidden="true"><i class="' . $el['icon'] . '"></i></span>';
		$output .= '<span class="text">' . $el['text'] . '</span>';
		$output .= '</a>';
		$output .= '</li>';

	}

	if ( theme_mb2nl_theme_setting( $PAGE, 'customsitemnuitems' ) )
	{
		$output .= theme_mb2nl_static_content( theme_mb2nl_theme_setting( $PAGE, 'customsitemnuitems' ), false, true);
	}

	$output .= '</ul>';

	if ( ! $mobile )
	{
		$output .= '</div>';
		$PAGE->requires->js_call_amd( 'theme_mb2nl/quicklinks', 'quickLinksInit' );
	}

	return $output;

}




/*
 *
 * Method to display site menu item
 *
 *
 */
function theme_mb2nl_site_menu_items()
{

	global $COURSE,$CFG,$PAGE,$DB,$USER, $SITE;

	$isCourse = ( isset( $COURSE->id ) && $COURSE->id != $SITE->id );
	$m27 = 2014051220; // Last formal release of Moodle 2.7
	$coursecontext = context_course::instance($COURSE->id);

	// Check if is frontpage
	$isfp = $PAGE->pagetype === 'site-index';
	$isds = $PAGE->pagelayout === 'mycourses' ? true : $PAGE->pagetype !== 'my-index';

	// Check if is page added to the front page
	$isFpPage = ( $PAGE->pagetype === 'mod-page-view' && $COURSE->id == 1);

	// Get page builder link params
	$checkbuilder = theme_mb2nl_check_builder();
	$builderlink = theme_mb2nl_page_builder_pagelink();
	$itemid = theme_mb2nl_page_builder_pagelink(true);
	$isbuilderlink = count($builderlink) ? true : false;

	// Check is is course page or admin pages
    $showmanage = (
 	   $PAGE->pagetype === 'site-index' ||
 	   $PAGE->pagetype === 'course-index' ||
 	   $PAGE->pagetype === 'course-index-category' ||
 	   $PAGE->pagetype === 'my-index');

   // Create course url
   $add_course_url = new moodle_url('/course/edit.php',array('category'=>theme_mb2nl_get_category()->id));
   if (file_exists($CFG->dirroot . '/local/course_templates/index.php'))
   {
	   $add_course_url = new moodle_url('/local/course_templates/index.php');
   }
   

	$items = array(
		'buildpage' => array(
			'access' => array('admin'),
			'course' => $isbuilderlink,
			'cap' => $checkbuilder == 2 && has_capability('local/mb2builder:managepages', context_system::instance()),
			'icon' => 'fa fa-magic',
			'text' => $checkbuilder == 2 ? $itemid ? get_string( 'editpage', 'local_mb2builder' ) : get_string( 'buildepage', 'local_mb2builder' ) : '',
			'link' => new moodle_url( '/local/mb2builder/edit-page.php', $builderlink )
		),
		'turneditingcourse' => array(
			'access' => array('admin','manager','editingteacher'),
			'course' => ($isCourse || $isfp),
			'icon' => theme_mb2nl_turnediting_button_atts(true),
			'text' => theme_mb2nl_turnediting_button_atts(),
			'link' => theme_mb2nl_turnediting_button_link()
		),
		'editcourse' => array(
			'access' => array('admin','manager','editingteacher'),
			'course' => $isCourse,
			'icon' => 'fa fa-cog',
			'text' => get_string('editcoursesettings'),
			'link' => new moodle_url('/course/edit.php',array('id'=>$COURSE->id))
		),
		'editpage' => array(
			'access' => array('admin','manager','editingteacher'),
			'course' => $isFpPage,
			'icon' => 'fa fa-cog',
			'text' => get_string('editsettings'),
			'link' => isset( $PAGE->cm->id ) ? new moodle_url( '/course/modedit.php',array( 'update' => $PAGE->cm->id, 'return' => 1 )) : ''
		),				
		'enroleasy' => array(
			'access' => array('admin','manager','editingteacher'),
			'course' => true,
			'shown' => theme_mb2nl_enrol_easy($COURSE->id),
			'icon' => 'fa fa-qrcode',
			'text' => get_string('enrolform_course_code', 'theme_mb2nl'),
			'link' => new moodle_url( '/enrol/editinstance.php', array('courseid'=>$COURSE->id, 'id'=>theme_mb2nl_enrol_easy($COURSE->id), 'type'=>'easy') )
		),
		'mycourses' => array(
			'access' => array('admin','manager','editingteacher','teacher','coursecreator','student','user'),
			'course' => true,
			'shown' => ( $CFG->version >= 2022041900 && theme_mb2nl_get_mycourses() && $PAGE->pagelayout !== 'mycourses' ),
			'icon' => 'fa fa-graduation-cap',
			'text' => get_string('mycourses'),
			'link' =>  new moodle_url('/my/courses.php')
		),
		'dashboard' => array(
			'access' => array('admin','manager','editingteacher','teacher','coursecreator','student','user'),
			'course' => true,
			'shown' => $isds,
			'icon' => 'fa fa-tachometer',
			'text' => get_string('myhome'),
			'link' => new moodle_url('/my/')
		),
		'frontpage' => array(
			'access' => array('admin','manager','editingteacher','teacher','coursecreator','student','user'),
			'course' => true,
			'shown' => !$isfp,
			'icon' => 'fa fa-home',
			'text' => get_string('sitehome'),
			'link' => new moodle_url( '/', array( 'redirect' => 0 ) )
		),
		'courses' => array(
			'access' => array('admin','manager','editingteacher','teacher','coursecreator','student','user'),
			'course' => true,
			'icon' => 'fa fa-book',
			'text' => get_string('fulllistofcourses'),
			'link' =>  new moodle_url('/course/')
		),
		'calendar' => array(
			'access' => array('admin','manager','editingteacher','teacher','coursecreator','student','user'),
			'course' => true,
			'icon' => 'fa fa-calendar',
			'text' => get_string('calendar','calendar'),
			'link' => new moodle_url('/calendar/view.php',array('view'=>'month'))
		),
		'badges' => array(
			'access' => array('admin','manager','editingteacher','teacher','coursecreator','student','user'),
			'course' => true,
			'shown' => $CFG->badges_allowcoursebadges,
			'icon' => 'fa fa-bookmark',
			'text' => ($CFG->version > $m27) ? get_string('badges') : get_string('mybadges','badges'),
			'link' => new moodle_url('/badges/mybadges.php')
		),
		'contentbank' => array(
			'access' => array('admin','manager','editingteacher'),
			'course' => true,
			'shown' => ( $CFG->version >= 2020110900  && $PAGE->pagetype !== 'contentbank'), // Moodle 10
			'icon' => 'fa fa-paint-brush',
			'text' => ( $CFG->version >= 2020110900 ) ? get_string('contentbank') : '',
			'link' => $COURSE->id > 1 ? new moodle_url( '/contentbank/index.php', array('contextid'=>$coursecontext->id) ) : new moodle_url( '/contentbank/index.php' )
		),
		'addcourse' => array(
			'access' => array('admin','manager','coursecreator'),
			'course' => true,
			'icon' => 'fa fa-plus',
			'text' => get_string('createnewcourse'),
			'link' => $add_course_url
		),
		'addcategory' => array(
			'access' => array('admin','manager'),
			'course' => true,
			'icon' => 'fa fa-plus',
			'text' => get_string('createnewcategory'),
			'link' => new moodle_url('/course/editcategory.php',array('parent'=>1))
		),
		'editcategory' => array(
			'access' => array('admin','manager'),
			'course' => $isCourse,
			'icon' => 'fa fa-edit',
			'text' => get_string('editcategorysettings'),
			'link' => new moodle_url('/course/editcategory.php',array('id'=>$COURSE->category))
		),
		'managecoursesandcats' => array(
			'access' => array('admin','manager'),
         	'course' => true,
			'shown' => $showmanage,
			'icon' => 'fa fa-cogs',
			'text' => get_string('managecourses'),
			'link' => new moodle_url('/course/management.php',array())
		),
		'addpage' => array(
			'access' => array('admin','manager','editingteacher'),
			'course' => true,
			'cap' => has_capability('moodle/course:manageactivities', context_course::instance($SITE->id)),
			'icon' => 'fa fa-plus-square',
			'text' => get_string('addpage','my'),
			'link' => new moodle_url( '/course/modedit.php',array('add'=>'page','type'=>'','course'=>$SITE->id,'section'=>0,'return'=>0,'sr'=>0 ))
		),
		'admin' => array(
			'access' => array('admin'),
			'course' => true,
			'icon' => 'fa fa-sitemap',
			'text' => get_string( 'administrationsite' ),
			'link' => new moodle_url( '/admin/search.php',array() )
		),

	);



	return $items;


}





/*
 *
 * Method to set course editing link
 *
 */
function theme_mb2nl_turnediting_button_link()
{

	global $CFG, $COURSE, $USER, $PAGE;

	if ( isset( $USER->gradeediting[$COURSE->id] ) && $PAGE->pagetype === 'grade-report-grader-index' )
	{
		return new moodle_url( 'index.php', array('id' => $COURSE->id, 'sesskey'=> sesskey(), 'plugin' => 'grader',
		'edit'=> $USER->gradeediting[$COURSE->id] ? 0 : 1 ) );
	}
	else
	{
		return new moodle_url( '/course/view.php', array('id'=>$COURSE->id, 'sesskey'=> sesskey(),
		'edit'=> $PAGE->user_is_editing() ? 'off' : 'on', 'return'=> $PAGE->url->out_as_local_url() ) );
	}

}




/*
 *
 * Method to set course editing text
 *
 */
function theme_mb2nl_turnediting_button_atts( $icon = false )
{

	global $USER, $PAGE, $COURSE;

	$texton = get_string('turneditingon');
	$textoff = get_string('turneditingoff');
	$iconon = 'fa fa-pencil';
	$iconoff = 'fa fa-power-off';
	$ifvar = isset( $USER->gradeediting[$COURSE->id] ) && $PAGE->pagetype === 'grade-report-grader-index' ? $USER->gradeediting[$COURSE->id] : $PAGE->user_is_editing();

	if ( $icon )
	{
		return $ifvar ? $iconoff : $iconon;
	}
	else
	{
		return $ifvar ? $textoff : $texton;
	}

}








/*
 *
 * Method to display site menu item
 *
 *
 */
function theme_mb2nl_get_category()
{

	global $CFG;

	if (!theme_mb2nl_moodle_from(2018120300))
    {
        require_once($CFG->libdir. '/coursecatlib.php');
    }

	$category = 0;

	if (!has_capability('moodle/course:changecategory', context_system::instance()))
	{
		if (theme_mb2nl_moodle_from(2018120300))
		{
			$category = core_course_category::get($CFG->defaultrequestcategory, IGNORE_MISSING, true);
		}
		else
		{
			$category = coursecat::get($CFG->defaultrequestcategory, IGNORE_MISSING, true);
		}
	}

	if (!$category)
	{

		if (theme_mb2nl_moodle_from(2018120300))
		{
			$category = core_course_category::get_default();
		}
		else
		{
			$category = coursecat::get_default();
		}
	}

	return $category;

}
