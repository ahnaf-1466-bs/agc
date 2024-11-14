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
 * Method to set events layout template
 *
 */
function theme_mb2nl_events_template($events, $opts)
{
	$output = '';
	$cls = '';
	$carouselcls = '';

	$cls .= $opts['layout'] == 2 ? ' theme-box' : '';
	$cls .= $opts['layout'] == 3 ? ' swiper-slide' : '';

	foreach ( $events as $event )
	{
		$eventimage = theme_mb2nl_get_event_image( $event->id, $event->courseid );

		$output .= '<div class="theme-event-item event-' . $event->id . $cls . '" data-id="' . $event->id . '">';
		$output .= '<div class="theme-event-item-inner">';
		$output .= $opts['image'] ? '<img class="event-image" src="' . $eventimage . '" alt="' . $event->name . '">' : '';
		$output .= '<div class="event-date">' . theme_mb2nl_events_date($event->timestart) . '</div>';
		$output .= '<h4 class="event-name">';
		$output .= '<a href="#mb2-pb-events-modal" class="event-show">';
		$output .= $event->name;
		$output .= '</a>';
		$output .= '</h4>';
		$output .= '<div class="event-duration">';
		$output .= theme_mb2nl_events_duration($event->timestart, $event->timeduration);
		$output .= '</div>'; // event-duration
		$output .= '</div>'; // theme-event-item
		$output .= '</div>'; // theme-event-item-inner
	}

	return $output;

}




/*
 *
 * Method to get date format
 *
 */
function theme_mb2nl_events_date($time)
{

	return userdate( $time, get_string('eventdateshort', 'theme_mb2nl') );
}





/*
 *
 * Method to get get event duration
 *
 */
function theme_mb2nl_events_duration($time, $duration)
{

	$formatto = get_string('eventhourdate', 'theme_mb2nl');
	$formatfrom = get_string('eventdaydate', 'theme_mb2nl');
	$to = '';
	$days = theme_mb2nl_events_nextdays($time, $duration);

	if ( $days )
	{
		$to = ' - ' . userdate($time + $duration, get_string('eventdaydate', 'theme_mb2nl') );
	}
	elseif ( $duration > 0 && ! $days )
	{
		$to = ' - ' . userdate($time + $duration, get_string('eventhourdate', 'theme_mb2nl') );
	}

	return userdate( $time, $formatfrom ) . $to;

}




/*
 *
 * Method to get check if event duration is more tha one day
 *
 */
function theme_mb2nl_events_nextdays($time, $duration)
{

	$daystart = userdate($time, '%d');
	$dayend = userdate($time+$duration, '%d');

	if ( $daystart < $dayend )
	{
		return true;
	}

	return false;

}



/*
 *
 * Method to get event list
 *
 */
function theme_mb2nl_get_events( $opt = array() )
{

	global $DB;

	$params = array( 'visible' => 1 );
	$sqlwhere = ' WHERE 1=1';
	$sqlorder = '';
	$sql = '';
	$sort = 'e.timestart ASC';
	$sqlorder .= ' ORDER BY ' . $sort;

	$sql .= 'SELECT DISTINCT e.* FROM {event} e';

	// Get only visible events
	$sqlwhere .= ' AND e.visible=:visible';

	// Get only upcoming events
	if ( $opt['upcoming'] )
	{
		$params['timestart'] = theme_mb2nl_get_user_date();
		$sqlwhere .= ' AND (e.timestart>:timestart)';
	}

	// Get only site type events
	if ( $opt['type'] == 1 )
	{
		$params['eventtype'] = 'site';
		$sqlwhere .= ' AND ' . $DB->sql_like('e.eventtype', ':eventtype');
	}

	return $DB->get_records_sql( $sql . $sqlwhere . $sqlorder, $params, 0 , $opt['limit'] );

}





/*
 *
 * Method to get event list
 *
 */
function theme_mb2nl_get_event( $eventid )
{

	global $DB;

	return $DB->get_record( 'event', array( 'id' => $eventid ), '*', MUST_EXIST );

}






/*
 *
 * Method to get evant hrml template
 *
 */
function theme_mb2nl_event_details( $eventid )
{

	$event = theme_mb2nl_get_event($eventid);
	$cansee = theme_mb2nl_event_cansee($event);


}




/*
 *
 * Method to check if user can see event details
 *
 */
function theme_mb2nl_event_cansee( $event )
{
	global $USER;

	// Admin/manager users
	$hassystemcap = has_capability('moodle/calendar:manageentries', context_system::instance());

	// Course events
	$courseobjs = enrol_get_my_courses();
	$mycourses = array_keys($courseobjs);

	// Group events
	$mygroups = groups_get_my_groups();
	$mygroups = array_keys($mygroups);

	// Category events
	$categories = theme_mb2nl_user_categories();

	if ( $hassystemcap || $event->eventtype === 'site' ) // Site event type or user can manage events
	{
		return true;
	}
	elseif ( $event->eventtype === 'user' && $usertype && $USER->id == $event->userid ) // User type event
	{
		return true;
	}
	elseif ( $event->eventtype === 'course' && in_array( $event->courseid, $mycourses ) ) // Course type event
	{
		return true;
	}
	elseif ( $event->eventtype === 'group' && in_array( $event->groupid, $mygroups ) ) // Group event type
	{
		return true;
	}
	elseif ( $event->eventtype === 'category' && in_array( $event->categoryid, $categories ) ) // Category even type
	{
		return true;
	}
	else
	{
		return false;
	}

}





/*
 *
 * Method to get user categries
 *
 */
function theme_mb2nl_user_categories()
{
	$categories = array();
	$parents = array();
	$courseobjs = enrol_get_my_courses();

	if ( ! count( $courseobjs ) )
	{
		return $categories;
	}

	foreach( $courseobjs as $course )
	{
		$categories[] = $course->category;
	}

	foreach( $categories as $cat )
	{
		$categoryobj = theme_mb2nl_get_category_record($cat, 'path');
		$parentscats = theme_mb2nl_path_categories($categoryobj->path);

		if ( ! count( $parentscats ) )
		{
			continue;
		}

		foreach( $parentscats as $parent )
		{
			$parents[] = $parent;
		}
	}

	// Merge arrays
	$categories = array_merge( $categories, $parents );

	// Make categories array uniq
	// We don't want duplicate category ID's
	$categories = array_unique($categories);

	return $categories;

}





/*
 *
 * Method to get user parent categries
 *
 */
function theme_mb2nl_path_categories($path)
{

	$path = explode('/', $path);

	array_shift( $path );	// Remove first array item, it's empty .../1/2/3
	array_pop( $path ); 	// Remove last array item, it's requested category

	return $path;

}





/*
 *
 * Method to get image event description
 *
 */
function theme_mb2nl_get_event_image($eventid, $courseid)
{
	global $CFG, $PAGE, $OUTPUT, $USER;

	$courseplaceholder = theme_mb2nl_theme_setting( $PAGE, 'eventsplaceholder', '', true );
	$url = $courseplaceholder ? $courseplaceholder : $OUTPUT->image_url('events-default','theme');

	// Check if is course event
	// If not, return placeholder image
	if ( ! $courseid )
	{
		return $url;
	}

	require_once($CFG->libdir . '/filelib.php');
	$context = context_course::instance($courseid);

	// Check if user is enrolled in course (other than front page)
	// If not return placeholder image
	if ( $courseid != SITEID && ! is_enrolled( $context, $USER->id, '', true ) )
	{
		return $url;
	}

	$fs = get_file_storage();
	$files = $fs->get_area_files( $context->id, 'calendar', 'event_description', $eventid );

	foreach ( $files as $f )
	{
		if ( $f->is_valid_image() )
		{
			$url = moodle_url::make_pluginfile_url(
				$f->get_contextid(), $f->get_component(), $f->get_filearea(), $f->get_itemid(), $f->get_filepath(), $f->get_filename(), false);
		}
	}

	return $url;

}
