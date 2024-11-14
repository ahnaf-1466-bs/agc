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
 * Method to get langauge list
 *
 */
function theme_mb2nl_language_list( $footer = false )
{

	global $PAGE, $OUTPUT, $CFG;

	$langpos = theme_mb2nl_theme_setting( $PAGE,'langpos' );

	if ( ! $langpos || ( ! $footer && theme_mb2nl_theme_setting( $PAGE,'langpos' ) == 2 ) || ( $footer && theme_mb2nl_theme_setting( $PAGE,'langpos' ) == 1 ) )
	{
		return;
	}

	$moodle33 = 2017051500;
	$output = '';
	$langs = get_string_manager()->get_list_of_translations();
	$strlang =  get_string('language');
	$currentlang = current_language();
	$listcls = '';
	$linkcls = '';
	$linkcls2 = '';

	$customFlagFile = $CFG->dirroot . theme_mb2nl_themedir() . '/mb2nl/pix/flags/custom/' . strtoupper($currentlang) . '.png';
	$flagFile = $CFG->dirroot . theme_mb2nl_themedir() . '/mb2nl/pix/flags/48x32/' . strtoupper($currentlang) . '.png';
	$noFlagFile = $CFG->dirroot . theme_mb2nl_themedir() . '/mb2nl/pix/flags/48x32/noflag.png';
	$isCustomFlag = file_exists($customFlagFile) ? true : false;
	$isFlag = file_exists($flagFile) ? true : false;

	if ( ! count( $langs ) )
	{
		return;
	}

	if( $isCustomFlag )
	{
		$currentFlagUrl = $CFG->version >= 	$moodle33 ? $OUTPUT->image_url('flags/custom/' . strtoupper($currentlang),'theme') : $OUTPUT->pix_url('flags/custom/' . strtoupper($currentlang),'theme');
	}
	elseif ($isFlag)
	{
		$currentFlagUrl = $CFG->version >= 	$moodle33 ? $OUTPUT->image_url('flags/48x32/' . strtoupper($currentlang),'theme') : $OUTPUT->pix_url('flags/48x32/' . strtoupper($currentlang),'theme');
	}
	else
	{
		$currentFlagUrl = $CFG->version >= 	$moodle33 ? $OUTPUT->image_url('flags/48x32/noflag','theme') : $OUTPUT->pix_url('flags/48x32/noflag','theme');
	}

	$currentFlagImg = '<img class="lang-flag" src="' . $currentFlagUrl . '" alt="" />';
	$lanText = isset($langs[$currentlang]) ? $langs[$currentlang] : $strlang;
	$lanText = theme_mb2nl_get_langname($lanText);

	if ( ! $footer )
	{
		$output .= '<li class="lang-item level-1 isparent onhover">';
		$output .= '<button type="button" class="themereset mb2mm-action" aria-label="' . $lanText . '">';
		//$output .= '<span class="mb2mm-item-content">';	
		$output .= $currentFlagImg;
		$output .= '<span class="lang-shortname mb2mm-label" aria-hidden="true">' . str_replace('_',' ', $currentlang). '</span>';
		$output .= '<span class="lang-fullname mb2mm-label">' . $lanText . '</span>';
		//$output .= '</span>';
		$output .= '<span class="mb2mm-arrow"></span>';
		$output .= '</button>';
		$output .= '<button type="button" class="mb2mm-toggle themereset" aria-label="' . get_string('togglemenuitem', 'theme_mb2nl', array('menuitem' =>  get_string('language'))) . '"></button>';
		$output .= '<div class="mb2mm-ddarrow"></div>';

		$listcls = ' mb2mm-dd';
		$linkcls = 'mb2mm-action';
		$linkcls2 = ' mb2mm-label';
	}

	$output .= '<ul class="lang-list' . $listcls . '">';

	foreach ( $langs as $langtype => $langname )
	{
		if ( $langtype !== $currentlang )
		{
			$langname = theme_mb2nl_get_langname($langname);
			$flagFile = $CFG->dirroot . theme_mb2nl_themedir() . '/mb2nl/pix/flags/48x32/' . strtoupper($langtype) . '.png';
			$flagUrl = file_exists( $flagFile ) ? $OUTPUT->image_url('flags/48x32/' . strtoupper($langtype),'theme') : $OUTPUT->image_url('flags/48x32/noflag','theme');
			
			$flafImg = '<img class="lang-flag lazy" data-src="' . $flagUrl . '" alt="' . $langname . '">';

			$output .= '<li class="level-2">';
			$output .= '<a class="' . $linkcls . '" href="' . new moodle_url($PAGE->url, array('lang' => $langtype)) . '" aria-label="' . $langname . '">';
			//$output .= '<span class="mb2mm-item-content">';	
			$output .= $flafImg;
			$output .= '<span class="lang-shortname' . $linkcls2 . '" aria-hidden="true">' . str_replace( '_',' ', $langtype ) . '</span>';
			$output .= '<span class="lang-fullname' . $linkcls2 . '" aria-hidden="true">' . $langname . '</span>';
			//$output .= '</span>';
			$output .= '</a>';
			$output .= '</li>';
		}
	}

	$output .= '</ul>';
	$output .= ! $footer ? '</li>' : '';

	return $output;

}





/*
 *
 * Method to get mycourses list
 *
 */
function theme_mb2nl_mycourses_list( $single = false)
{

	global $PAGE, $CFG;
	$output = '';
	$courses = theme_mb2nl_get_mycourses();
	$limit = theme_mb2nl_theme_setting($PAGE, 'myclimit', 6);
	$alllink = $CFG->version >= 2022041900; // Since Moodle 4
	
	if ( ! count( $courses ) || ! isloggedin() || isguestuser() || ! theme_mb2nl_theme_setting( $PAGE,'mycinmenu2' ) )
	{
		return;
	}

	$output .= $single ? '<div class="mycourses">' : '<li class="mycourses level-1 isparent onhover">';

	$output .= $alllink ? '<a class="mb2mm-action" href="' . new moodle_url( '/my/courses.php', array() ) . '">': '<button type="button" class="themereset mb2mm-action">';
	$output .= '<span class="mb2mm-label">';
	$output .= get_string('mycourses');
	$output .= '</span>';
	$output .= '<span class="mb2mm-hlabel" aria-hidden="true">' . count( $courses ) . '</span>';
	$output .= '<span class="mb2mm-arrow"></span>';
	$output .= $alllink ? '</a>' : '</button>';
	$output .= '<button type="button" class="mb2mm-toggle themereset" aria-label="' . 
	get_string('togglemenuitem', 'theme_mb2nl', array('menuitem' =>  get_string('mycourses'))) . '"></button>';

	$output .= '<div class="mb2mm-ddarrow"></div>';

	$output .= '<ul class="mb2mm-dd">';

	foreach ( $courses as $c )
	{
		$course_url = new moodle_url( '/course/view.php', array( 'id' => $c['id'] ) );
		$coursename = strip_tags( format_text( $c['fullname'] ) );

		$output .= '<li class="level-2 visible' . $c['visible'] . ' ' . $c['roles'] . '">';
		$output .= '<a class="mb2mm-action" href="' . $course_url . '" aria-label="' . $coursename . '">';
		//$output .= '<span class="mb2mm-item-content">';
		$output .= '<span class="mb2mm-label">';
		$output .= theme_mb2nl_wordlimit($coursename, $limit);
		$output .= '</span>';
		//$output .= '</span>';
		$output .= '</a>';
		$output .= '</li>';
	}

	$output .= '</ul>';
	$output .= $single ? '</div>' : '</li>';

	return $output;


}




/*
 *
 * Method to check if is my course list
 *
 */
function theme_mb2nl_get_mycourses()
{
	global $USER, $PAGE;
	$my_courses = enrol_get_my_courses();
	$courses = array();

	foreach ( $my_courses as $c )
	{
		$course_access = theme_mb2nl_site_access( $c->id );

		// This is required: isset( $PAGE->theme->settings->mycexpierd )
		// becuse some user use child theme withiut 'mycexpierd' setting
		if ( theme_mb2nl_course_passed( $c->id ) && isset( $PAGE->theme->settings->mycexpierd ) && ! theme_mb2nl_theme_setting( $PAGE, 'mycexpierd' ) )
		{
			continue;
		}

		// Hide hidden courses for students
		if ( ! $c->visible )
		{
			if ( isset( $PAGE->theme->settings->mychidden ) && ! theme_mb2nl_theme_setting( $PAGE, 'mychidden' ) )
			{
				continue;
			}

			if ( ! in_array( $course_access, array( 'admin', 'manager', 'editingteacher' ) ) )
			{
				continue;
			}
		}

		$courses[] = array( 'id' => $c->id, 'fullname' => $c->fullname, 'visible' => $c->visible,
		'roles' => implode(' ', theme_mb2nl_get_user_course_roles( $c->id, $USER->id ) ) );
	}

	return $courses;

}



/*
 *
 * Method to check if course is passed
 *
 */
function theme_mb2nl_course_passed( $id )
{
	global $DB;

	if ( ! $id )
	{
		return false;
	}

	// Get end date from database
	$csql = 'SELECT * FROM {course} WHERE id=?';
	if ( ! $DB->record_exists_sql( $csql, array( $id ) ) )
	{
		return false;
	}

	$course = $DB->get_record( 'course', array( 'id' => $id ), 'enddate', MUST_EXIST );

	// Now we have to check date
	if ( $course->enddate > 0 && $course->enddate < theme_mb2nl_get_user_date() )
	{
		return true;
	}

	return false;

}






/**
 *
 * Method to get user date and time
 *
 */
function theme_mb2nl_get_user_date()
{
	$date = new DateTime( 'now', core_date::get_user_timezone_object() );
	$time = $date->getTimestamp();
	return $time;
}






/*
 *
 * Method to get icon navigation
 *
 */
function theme_mb2nl_iconnav( $mobile = false )
{
	global $PAGE;

    $iconnavs = theme_mb2nl_theme_setting($PAGE, 'navicons');

	if ( $iconnavs === '' )
	{
		return;
	}

	$cls = $mobile ? 'theme-iconnav-mobile' : 'theme-iconnav';

    return theme_mb2nl_static_content($iconnavs, true, true, array('listcls'=>$cls));

}




/*
 *
 * Method to get language full name without brackets
 *
 */
function theme_mb2nl_get_langname( $langname )
{
	$newlangname = array();
	$langname = explode(' ', $langname);

	foreach ( $langname as $l )
	{
		if ( preg_match('@\(@', $l) )
		{
			continue;
		}

		$newlangname[] = $l;
	}

	return implode(' ', $newlangname);

}




/*
 *
 * Method to get theme main menu
 *
 */
function theme_mb2nl_main_menu($id = 0, $pos = 1 )
{
	global $OUTPUT, $PAGE;

	$html = '';

	$buildermenu = theme_mb2nl_builder_menu();
	$megamenu = theme_mb2nl_megamenu($id, $pos);

	if ( $buildermenu )
	{
		$html .= theme_mb2nl_megamenu($buildermenu, $pos);
	}
	elseif ( $megamenu )
	{		
		$html .= $megamenu;
	}
	else
	{
		$html .= $OUTPUT->custom_menu();
	}

	return $html;

}





/*
 *
 * Method to check if megamenu plugin is installed and enabled
 *
 */
function theme_mb2nl_is_megamenu_plugin()
{
	global $CFG;

	// In this case user use old version of page builder
	if ( is_file( $CFG->dirroot . '/local/mb2megamenu/index.php' ) )
	{
		$options = get_config('local_mb2megamenu');

		if ( $options->enablemenu )
		{
			return true;
		}
	}

	return false;

}





/*
 *
 * Method to get megamenu items from plugin
 *
 */
function theme_mb2nl_megamenu($id, $pos)
{
	global $CFG;

	if ( ! theme_mb2nl_is_megamenu_plugin() )
	{
		return;
	}

	if ( ! class_exists( 'Mb2megamenuHelper' ) )
	{
		require_once( $CFG->dirroot . '/local/mb2megamenu/classes/helper.php' );
	}

	$mmHlpr = new Mb2megamenuHelper;

	return $mmHlpr->menu_template($id, $pos);

}




/*
 *
 * Method to get megamenu items from plugin
 *
 */
function theme_mb2nl_main_menu_style($extra = '')
{
	global $PAGE;

	$style = '';

	$settings = array(
		'navbarbgcolor',
		// Normal state
		'navcolor',
		'navhcolor',
		// Hover state
		'navsubcolor',
		'navsubhcolor',
		'navhbgcolor'
	);

	foreach ( $settings as $setting )
	{
		$val = theme_mb2nl_theme_setting($PAGE, $setting);

		$style .= $val ? '--mb2-pb-' . $setting . ':' . $val . ';' : '';		
	}

	return $style . $extra;

}