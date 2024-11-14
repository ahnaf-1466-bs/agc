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
 * Method to get courses
 *
 */
function theme_mb2nl_get_courses( $opt = array(), $count = false )
{
	global $DB, $CFG, $PAGE;

	$page = isset( $opt['page'] ) ? $opt['page'] : 1;
	$perpage = $CFG->coursesperpage;
	$limitfrom = ( $page -1 ) * $perpage;

	if (  isset( $opt['limit'] ) )
	{
		$perpage = $opt['limit'];
		$limitfrom = 0;
	}

	$teacherroleid = theme_mb2nl_get_user_role_id( true );

	$opt['excludecat'] = theme_mb2nl_course_excats();
	$opt['excludetag'] = theme_mb2nl_course_extags();

	$params = array();
	$sqlwhere = ' WHERE 1=1';
	$sqlorder = '';
	$sql = '';

	if ( $count )
	{
		// Select courses count
		$sql .= 'SELECT COUNT(DISTINCT c.id) FROM {course} c';
	}
	else
	{
		// Select courses
		$sql .= 'SELECT DISTINCT c.* FROM {course} c';
	}

	// Check for frontpage course
	// and for hidden courses
	$sqlwhere .= ' AND c.id > 1';

	$sqlwhere .= ' AND c.visible = 1';

	// Check expired courses
	if ( ! theme_mb2nl_theme_setting( $PAGE, 'expiredcourses' ) )
	{
		$sqlwhere .= ' AND (c.enddate=0 OR c.enddate>' . theme_mb2nl_get_user_date() . ')';
	}

	// Filter exclude categories
	if ( $opt['excludecat'][0] )
	{
		$isnot = count( $opt['excludecat'] ) > 1 ? 'NOT ' : '!';
		list( $excatinsql, $excatparams ) = $DB->get_in_or_equal( $opt['excludecat'] );
		$params = array_merge( $params, $excatparams );
		$sqlwhere .= ' AND c.category ' . $isnot . $excatinsql;
	}

	// Filter exclude courses (OLD)
	if ( isset( $opt['courseids'] ) &&  $opt['courseids'] && $opt['excourses'] )
	{
		$isnot = '';
		$opt['courseids'] = explode( ',', $opt['courseids'] );

		if ( $opt['excourses'] === 'exclude' )
		{
			$isnot = count( $opt['courseids'] ) > 1 ? 'NOT ' : '!';
		}

		list( $coursesnsql, $coursesparams ) = $DB->get_in_or_equal( $opt['courseids'] );
		$params = array_merge( $params, $coursesparams );
		$sqlwhere .= ' AND c.id ' . $isnot . $coursesnsql;
	}

	// Filter exclude categories (OLD)
	if ( isset( $opt['catids'] ) &&  $opt['catids'] && $opt['excats'] )
	{
		$isnot = '';
		$opt['catids'] = explode( ',', $opt['catids'] );

		if ( $opt['excats'] === 'exclude' )
		{
			$isnot = count( $opt['catids'] ) > 1 ? 'NOT ' : '!';
		}

		list( $excatinsql, $excatparams ) = $DB->get_in_or_equal( $opt['catids'] );
		$params = array_merge( $params, $excatparams );
		$sqlwhere .= ' AND c.category ' . $isnot . $excatinsql;
	}

	// Filter categories
	if ( ! empty( $opt['categories'] ) )
	{
		list( $catinsql, $catparams ) = $DB->get_in_or_equal( $opt['categories'] );
		$params = array_merge( $params, $catparams );
		$sqlwhere .= ' AND c.category ' . $catinsql;
	}

	// Filter hidden categories
	$sqlwhere .= ' AND EXISTS( SELECT ca.id, ca.visible FROM {course_categories} ca WHERE ca.id=c.category AND ca.visible=1 )';

	// Filter instructors
	if ( ! empty( $opt['instructors'] ) )
	{
		list( $instructorsinsql, $instructorsparams ) = $DB->get_in_or_equal( $opt['instructors'] );
		$params = array_merge( $params, $instructorsparams );
		$sqlwhere .= ' AND EXISTS( SELECT ra.id FROM {role_assignments} ra JOIN {context} cx ON ra.contextid = cx.id AND cx.contextlevel = ' . CONTEXT_COURSE . ' WHERE cx.instanceid = c.id AND ra.roleid = ' . $teacherroleid . ' AND ra.userid ' . $instructorsinsql . ')';
	}

	// Filter price
	if (  isset( $opt['price'] ) && ( $opt['price'] == 0 ||  $opt['price'] == 1 ) )
	{
		$params[] = ENROL_INSTANCE_ENABLED;
		list( $priceinsql, $priceparams ) = $DB->get_in_or_equal( theme_mb2nl_pay_enrolements() );
		$params = array_merge( $params, $priceparams );
		$isnot = '';

		if ( $opt['price'] == 0 )
		{
			$isnot = 'NOT ';
		}

		$sqlwhere .= ' AND ' . $isnot . 'EXISTS( SELECT er.id FROM {enrol} er WHERE er.courseid = c.id AND er.status = ? AND er.enrol ' . $priceinsql . ')';
	}

	// Exlude tags
	if ( $opt['excludetag'][0] )
	{
		list( $extaginsql, $extagparams ) = $DB->get_in_or_equal( $opt['excludetag'] );
		$params = array_merge( $params, $extagparams );

		$sqlwhere .= ' AND NOT EXISTS( SELECT t.id FROM {tag} t JOIN {tag_instance} ti ON ti.tagid=t.id JOIN {context} cx ON cx.id=ti.contextid';
		$sqlwhere .= ' WHERE c.id=cx.instanceid';
		$sqlwhere .= ' AND cx.contextlevel = ' . CONTEXT_COURSE;
		$sqlwhere .= ' AND t.id ' . $extaginsql;
		$sqlwhere .= ')';
	}

	// Filter tags
	if ( ! empty( $opt['tags'] ) )
	{
		list( $extaginsql, $extagparams ) = $DB->get_in_or_equal( $opt['tags'] );
		$params = array_merge( $params, $extagparams );

		$sqlwhere .= ' AND EXISTS( SELECT t.id FROM {tag} t JOIN {tag_instance} ti ON ti.tagid=t.id JOIN {context} cx ON cx.id=ti.contextid';
		$sqlwhere .= ' WHERE c.id=cx.instanceid';
		$sqlwhere .= ' AND cx.contextlevel = ' . CONTEXT_COURSE;
		$sqlwhere .= ' AND t.id ' . $extaginsql;
		$sqlwhere .= ')';
	}

	// Filter tags for shortcodes
	if ( isset( $opt['tagids'] ) &&  $opt['tagids'] && $opt['extags'] )
	{
		$isnot = '';

		$tagsarr = explode( ',', $opt['tagids'] );

		if ( $opt['extags'] === 'exclude' )
		{
			$isnot = 'NOT ';
		}

		list( $extaginsql, $extagparams ) = $DB->get_in_or_equal( $tagsarr );
		$params = array_merge( $params, $extagparams );

		$sqlwhere .= ' AND ' . $isnot  . 'EXISTS( SELECT t.id FROM {tag} t JOIN {tag_instance} ti ON ti.tagid=t.id JOIN {context} cx ON cx.id=ti.contextid';
		$sqlwhere .= ' WHERE c.id=cx.instanceid';
		$sqlwhere .= ' AND cx.contextlevel = ' . CONTEXT_COURSE;
		$sqlwhere .= ' AND t.id ' . $extaginsql;
		$sqlwhere .= ')';
	}

	// Filter search
	// Based on get_courses_search
	if ( isset( $opt['searchstr'] )  && $opt['searchstr'] !== '' )
	{
		$searchstr = strip_tags( $opt['searchstr'] );
		$searchstr = trim( $searchstr );
		$params[] = '%' . $searchstr . '%';
		$concat = $DB->sql_concat("COALESCE(c.summary, '')", "' '", 'c.fullname', "' '", 'c.idnumber', "' '", 'c.shortname');
		$sqlwhere .= ' AND ' . $DB->sql_like( $concat, '?', false, true, false );
	}

	$sqlorder .= ' ORDER BY c.sortorder';

	if ( $count )
	{
		$sqlorder = '';
		return $DB->count_records_sql( $sql . $sqlwhere . $sqlorder, $params, $limitfrom , $perpage );
	}

	return $DB->get_records_sql( $sql . $sqlwhere . $sqlorder, $params, $limitfrom, $perpage );

}




/*
 *
 * Method to get course filter form
 *
 */
function theme_mb2nl_courses_filter_form()
{
	global $PAGE;

	$output = '';
	$coursegrid = theme_mb2nl_is_course_list();
	$coursepage = ( $PAGE->pagetype === 'course-index' || $PAGE->pagetype === 'course-index-category' );

	if ( ! $coursepage || ! $coursegrid )
	{
		return;
	}

	$output .= '<form name="theme-course-filter" class="theme-course-filter" action="" method="POST">';
	$output .= theme_mb2nl_courses_filter_categories();
	$output .= theme_mb2nl_courses_filter_tags();
	$output .= theme_mb2nl_courses_filter_instructors();
	$output .= theme_mb2nl_courses_filter_price();
	$output .= '<div class="submit-filter">';
	$output .= '<input type="submit" value="' . get_string('filter') . '">';
	$output .= '</div>';
	$output .= '</form>';

	return $output;

}



/*
 *
 * Method to get course filter form
 *
 */
function theme_mb2nl_courses_filter_price()
{
	global $PAGE;

	$output = '';
	$courseprice = theme_mb2nl_theme_setting( $PAGE, 'courseprice' );

	if ( ! $courseprice || ! theme_mb2nl_get_paidfree_courses_count() ||  ! theme_mb2nl_get_paidfree_courses_count(true) )
	{
		return;
	}

	$output .= '<div class="filter-block">';
	$output .= '<h4 class="filter-title">' . get_string( 'price', 'theme_mb2nl' ) . '</h4>';
	$output .= '<ul class="filter-price">';

	$output .= '<li class="filter-form-field">';
	$output .= '<div class="field-container">';
	$output .= '<label for="price_all">';
	$output .= '<input type="radio" id="price_all" name="filter_price" value="-1" checked>';
	$output .= '<i></i>';
	$output .= get_string('all') . ' <span class="info">(' . theme_mb2nl_get_courses(array(), true) . ')</span></label>';
	$output .= '</div>';
	$output .= '</li>';

	$output .= '<li class="filter-form-field">';
	$output .= '<div class="field-container">';
	$output .= '<label for="price_free">';
	$output .= '<input type="radio" id="price_free" name="filter_price" value="0">';
	$output .= '<i></i>';
	$output .= get_string( 'noprice', 'theme_mb2nl' ) . ' <span class="info">(' . theme_mb2nl_get_paidfree_courses_count(true) . ')</span></label>';
	$output .= '</div>';
	$output .= '</li>';

	$output .= '<li class="filter-form-field">';
	$output .= '<div class="field-container">';
	$output .= '<label for="price_paid">';
	$output .= '<input type="radio" id="price_paid" name="filter_price" value="1">';
	$output .= '<i></i>';
	$output .= get_string( 'paid', 'theme_mb2nl' ) . ' <span class="info">(' . theme_mb2nl_get_paidfree_courses_count(false) . ')</span></label>';
	$output .= '</div>';
	$output .= '</li>';

	$output .= '</ul>';
	$output .= '</div>';

	return $output;

}


/*
 *
 * Method to get course filter form
 *
 */
function theme_mb2nl_courses_filter_instructors()
{
	global $PAGE;

	$output = '';
	//$moreinstructor = theme_mb2nl_theme_setting( $PAGE, 'moreinstructor' );
	$instructors = theme_mb2nl_get_all_teachers();
	$coursinstructor = theme_mb2nl_theme_setting( $PAGE, 'coursinstructor' );
	$cls = '';
	$cls_list = '';

	if ( ! $coursinstructor )
	{
		return;
	}

	if ( ! count( $instructors ) )
	{
		return;
	}

	// if ( $moreinstructor  )
	// {
	// 	$cls = ' toggle-content';
	// 	$cls_list = ' content';
	// }

	$output .= '<div class="filter-block">';
	$output .= '<input type="hidden" name="filter_instructors" value="">';
	$output .= '<h4 class="filter-title">' . get_string( 'instructors', 'theme_mb2nl' ) . '</h4>';

	$output .= '<div class="filter-instructors' . $cls . '">';
	$output .= '<ul class="filter-instructors-lis' . $cls_list . '">';

	foreach ( $instructors as $instructor )
	{
		$courses = theme_mb2nl_get_instructor_courses_count( $instructor->id, true );
		$coursescount = ' <span class="info">(' . $courses . ')</span>';

		if ( ! $courses )
		{
			continue;
		}

		$output .= '<li class="filter-form-field">';
		$output .= '<div class="field-container">';
		$output .= '<label for="instructorid_' . $instructor->id . '">';
		$output .= '<input type="checkbox" id="instructorid_' . $instructor->id . '" name="filter_instructors[]" value="' . $instructor->id . '">';
		$output .= '<i></i>';
		$output .= $instructor->firstname . ' ' . $instructor->lastname . $coursescount .'</label>';
		$output .= '</div>'; // field-container
		$output .= '</li>';
	}

	$output .= '</ul>';

	// if ( $moreinstructor )
	// {
	// 	$output .= '<span class="toggle-content-button" data-moretext="' . get_string('showmore', 'form') . '" data-lesstext="' . get_string('showless', 'form') . '">' . get_string('showmore', 'form') . '</span>';
	// }

	$output .= '</div>'; // filter-instructors
	$output .= '</div>';

	return $output;

}



/*
 *
 * Method to get course filter tags form
 *
 */
function theme_mb2nl_courses_filter_tags()
{
	global $PAGE;

	//$moretags = theme_mb2nl_theme_setting( $PAGE, 'moretags' );
	$coursetagsset = theme_mb2nl_theme_setting( $PAGE, 'coursetags' );
	$coursetags = theme_mb2nl_course_tags();
	$cls = '';
	$cls_list = '';
	$output = '';

	if ( ! $coursetagsset ||  ! count( $coursetags ) )
	{
		return;
	}

	// if ( $moretags  )
	// {
	// 	$cls = ' toggle-content';
	// 	$cls_list = ' content';
	// }

	$output .= '<div class="filter-block">';
	$output .= '<input type="hidden" name="filter_tags" value="">';
	$output .= '<h4 class="filter-title">' . get_string( 'tags' ) . '</h4>';

	$output .= '<div class="filter-tags' . $cls . '">';
	$output .= '<ul class="filter-tags-list' . $cls_list . '">';

	foreach ( $coursetags as $tag )
	{
		$courses = theme_mb2nl_get_tags_courses_count( $tag->id );
		$coursescount = ' <span class="info">(' . $courses . ')</span>';

		if ( ! $courses )
		{
			continue;
		}

		$output .= '<li class="filter-form-field">';
		$output .= '<div class="field-container">';
		$output .= '<label for="tagid_' . $tag->id . '">';
		$output .= '<input type="checkbox" id="tagid_' . $tag->id . '" name="filter_tags[]" value="' . $tag->id . '">';
		$output .= '<i></i>';
		$output .= $tag->rawname . $coursescount .'</label>';
		$output .= '</div>'; // field-container
		$output .= '</li>';
	}

	$output .= '</ul>';

	// if ( $moretags )
	// {
	// 	$output .= '<span class="toggle-content-button" data-moretext="' . get_string('showmore', 'form') . '" data-lesstext="' . get_string('showless', 'form') . '">' . get_string('showmore', 'form') . '</span>';
	// }

	$output .= '</div>';
	$output .= '</div>';

	return $output;

}









/*
 *
 * Method to get category record
 *
 */
function theme_mb2nl_get_category_record( $categoryid, $fields = 'id, name, parent, visible, depth' )
{

	global $DB;

	$recordsql = 'SELECT ' . $fields . ' FROM {course_categories} WHERE id = ?';

	if ( ! $DB->record_exists_sql( $recordsql, array( $categoryid ) ) )
	{
		return;
	}

	return $DB->get_record_sql( $recordsql, array( $categoryid ) );

}






/*
 *
 * Method to get categories tree
 *
 */
function theme_mb2nl_get_categories_tree( $catid )
{

	$cats = array();
	$category = theme_mb2nl_get_category_record( $catid, 'id, name, path' );
	$path = substr( $category->path, 1 );
	$categories = explode( '/', $path );

	foreach( $categories as $c )
	{
		$cats[] = theme_mb2nl_get_category_record( $c, 'id, name' );
	}

	return $cats;

}






/*
 *
 * Method to get categories tree
 *
 */
function theme_mb2nl_categories_tree( $catid )
{
	$output = '';
	$categories = theme_mb2nl_get_categories_tree( $catid );

	$output .= '<ul class="course-categories-tree">';

	foreach ( $categories as $category )
	{
		$catlink = new moodle_url( '/course/index.php', array( 'categoryid' => $category->id ) );
		$output .= '<li>';
		$output .= '<a href="' . $catlink . '">' . format_text( $category->name, FORMAT_HTML ) . '</a>';
		$output .= '</li>';
	}

	$output .= '</ul>';

	return $output;

}







/*
 *
 * Method to get categories list
 *
 */
function theme_mb2nl_get_categories( $notempty = false, $opts = array() )
{

	global $DB, $PAGE;

	$params = array();
	$sqlwhere = ' WHERE 1=1';

	$excludecat = theme_mb2nl_course_excats();

	if ( $excludecat[0] )
	{
		$isnot = count( $excludecat ) > 1 ? 'NOT ' : '!';

		list( $excatinsql, $excatparams ) = $DB->get_in_or_equal( $excludecat );
		$params = array_merge( $params, $excatparams );
		$sqlwhere .= ' AND ca.id ' . $isnot . $excatinsql;
	}

	// Custom exclude categories
	// Require for coursetabs shortcode
	if ( ( isset( $opts['excats'] ) && isset( $opts['catids'] ) ) && $opts['excats'] && $opts['catids'] )
	{
		$isnot = '';
		$excludecat2 = explode( ',', $opts['catids'] );
		$excludecat2 = array_map( 'trim', $excludecat2 );

		if ( $opts['excats'] === 'exclude' )
		{
			$isnot = count( $excludecat2 ) > 1 ? 'NOT ' : '!';
		}

		list( $excatinsql2, $excatparams2 ) = $DB->get_in_or_equal( $excludecat2 );
		$params = array_merge( $params, $excatparams2 );
		$sqlwhere .= ' AND ca.id ' . $isnot . $excatinsql2;
	}

	if ( $notempty )
	{
		$sqlwhere .= ' AND EXISTS(SELECT c.id FROM {course} c WHERE c.category=ca.id AND c.visible=1)';
	}

	$sqlwhere .= ' AND ca.visible=1';

	$recordsql = 'SELECT ca.id, ca.name, ca.parent, ca.visible, ca.depth FROM {course_categories} ca';

	$orderby = ' ORDER BY sortorder';

	return $DB->get_records_sql( $recordsql . $sqlwhere . $orderby, $params );

}







/*
 *
 * Method to check if user can see category
 *
 */
function theme_mb2nl_category_canview( $category )
{
	global $USER;

	$context = context_coursecat::instance( $category->id );
	if ( ! $category->visible && ! has_capability( 'moodle/category:viewhiddencategories', $context, $USER ) )
	{
		return false;
	}

	return true;

}





/*
 *
 * Method to get categories list
 *
 */
function theme_mb2nl_courses_filter_categories()
{
	global $PAGE;

	$output = '';
	$categorise = theme_mb2nl_get_categories();
	$last_course_depth = 0;
	$level = 0;
	$cls = '';
	$cls_list = '';

	$output .= '<div class="filter-block">';
	$output .= '<input type="hidden" name="filter_categories" value="">';
	$output .= '<h4 class="filter-title">' . get_string('categories') . '</h4>';	

	$output .= '<div class="filter-categories' . $cls . '">';
	$output .= '<ul class="filter-categories-list' . $cls_list . '">';

	foreach ( $categorise as $category )
	{
		$level++;
		$children = theme_mb2nl_get_children($category->id);
		$output .= theme_mb2nl_category_level( $category, $children);
	}

	$output .= '</ul>';
	$output .= '</div>'; // filter-categories
	$output .= '</div>';

	if ( theme_mb2nl_theme_setting($PAGE, 'togglecat') )
	{
		$PAGE->requires->js_call_amd('theme_mb2nl/course','toggleCategory');
	}

	return $output;

}






/*
 *
 * Method to get course tags
 *
 */
function theme_mb2nl_course_tags($opts = array(), $fields = 't.id,t.name,t.rawname')
{

	global $DB, $PAGE;

	$params = array();
	$sqlwhere = ' WHERE 1=1';
	$sqlorder = '';

	$recordsql = 'SELECT DISTINCT ' . $fields . ' FROM {tag} t JOIN {tag_instance} ti ON ti.tagid=t.id JOIN {context} cx ON cx.id=ti.contextid JOIN {course} c ON c.id=cx.instanceid';

	$sqlwhere .= ' AND ti.itemtype=?';
	$params[] = 'course';

	$sqlwhere .= ' AND cx.contextlevel=?';
	$params[] = CONTEXT_COURSE;

	$sqlwhere .= ' AND c.visible=?';
	$params[] = 1;

	// Exclude tags filter
	$extags = theme_mb2nl_course_extags();

	if ( $extags[0] )
	{
		$isnotags = count( $extags ) > 1 ? 'NOT ' : '!';
		list( $extagnsql, $extagparams ) = $DB->get_in_or_equal( $extags );
		$params = array_merge( $params, $extagparams );

		$sqlwhere .= ' AND t.id ' . $isnotags . $extagnsql;
	}

	// Custom exclude categories
	// Require for coursetabs shortcode
	if ( ( isset( $opts['extags'] ) && isset( $opts['tagids'] ) ) && $opts['extags'] && $opts['tagids'] )
	{
		$isnot = '';
		$excludetag2 = explode( ',', $opts['tagids'] );
		$excludetag2 = array_map( 'trim', $excludetag2 );

		if ( $opts['extags'] === 'exclude' )
		{
			$isnot = count( $excludetag2 ) > 1 ? 'NOT ' : '!';
		}

		list( $extaginsql2, $extagparams2 ) = $DB->get_in_or_equal( $excludetag2 );
		$params = array_merge( $params, $extagparams2 );
		$sqlwhere .= ' AND t.id ' . $isnot . $extaginsql2;
	}

	// Tgas of expired courses
	if ( ! theme_mb2nl_theme_setting( $PAGE, 'expiredcourses' ) )
	{
		$sqlwhere .= ' AND (c.enddate=? OR c.enddate>?)';
		$params[] = 0;
		$params[] = theme_mb2nl_get_user_date();
	}

	$sqlorder .= ' ORDER BY t.name ASC';

	return $DB->get_records_sql( $recordsql . $sqlwhere . $sqlorder, $params );

}





/*
 *
 * Method to get course tags
 *
 */
function theme_mb2nl_course_languages()
{

	global $DB;

	$recordsql = 'SELECT DISTINCT c.lang FROM {course} c';

	return $DB->get_records_sql( $recordsql, array() );

}




/*
 *
 * Method to get courses count by tag
 *
 */
function theme_mb2nl_get_tags_courses_count($tagid)
{

	global $DB, $PAGE;

	$params = array();
	$excats = theme_mb2nl_course_excats();
	$extags = theme_mb2nl_course_extags();

	$sqlquery = 'SELECT COUNT(c.id) FROM {course} c JOIN {context} cx ON cx.instanceid=c.id JOIN {tag_instance} ti ON ti.contextid=cx.id WHERE cx.contextlevel=' . CONTEXT_COURSE;
	$sqlquery .= ' AND ti.tagid=' . $tagid;

	// Count onlu visible courses
	$sqlquery .= ' AND c.visible=1';

	// Exclude expired courses
	if ( ! theme_mb2nl_theme_setting( $PAGE, 'expiredcourses' ) )
	{
		$params[] = theme_mb2nl_get_user_date();
		$sqlquery .= ' AND (c.enddate=0 OR c.enddate>?)';
	}

	// Exclude tags
	if ( $extags[0] )
	{
		$isnotags = count( $extags ) > 1 ? 'NOT ' : '!';
		list( $extaginsql, $extagparams ) = $DB->get_in_or_equal( $extags );
		$params = array_merge( $params, $extagparams );

		$sqlquery .= ' AND NOT EXISTS( SELECT t.id FROM {tag} t JOIN {tag_instance} ti ON ti.tagid=t.id JOIN {context} cx ON cx.id=ti.contextid';
		$sqlquery .= ' WHERE c.id=cx.instanceid';
		$sqlquery .= ' AND cx.contextlevel = ' . CONTEXT_COURSE;
		$sqlquery .= ' AND t.id ' . $extaginsql;
		$sqlquery .= ')';
	}

	// Exclude categories
	if ( $excats[0] )
	{
		$isnotexcat = count( $excats ) > 1 ? 'NOT ' : '!';
		list( $excatnsql, $excatparams ) = $DB->get_in_or_equal( $excats );
		$params = array_merge( $params, $excatparams );

		$sqlquery .= ' AND c.category ' . $isnotexcat . $excatnsql;
	}

	return $DB->count_records_sql( $sqlquery, $params);


}












/**
 *
 * Method to get courses exlude tags
 *
 */
function theme_mb2nl_course_extags()
{
	global $PAGE;

	$exctags = theme_mb2nl_theme_setting( $PAGE, 'exctags' );
	return explode( ',', $exctags );

}







/*
 *
 * Method to get categories list
 *
 */
function theme_mb2nl_get_children( $parentid, $fields = 'id', $visible = false )
{

	global $DB;

	$recordsql = 'SELECT ' . $fields . ' FROM {course_categories} WHERE parent=' . $parentid;
	$recordsql .= $visible ? ' AND visible=1' : '';
	$recordsql .= ' ORDER BY sortorder';

	return $DB->get_records_sql( $recordsql, array() );

}









/*
 *
 * Method to get categories list
 *
 */
function theme_mb2nl_category_level( $category, $children, $level = 1 )
{
	global $PAGE;

	$output = '';
	$excludecat = theme_mb2nl_course_excats();
	$parts = theme_mb2nl_get_url_params();
	$togglecat = theme_mb2nl_theme_setting($PAGE, 'togglecat');
	$curentcat = 0;

	if ( array_key_exists( 'categoryid', $parts ) )
	{
		$curentcat = $parts['categoryid'];
	}

	if ( $category->depth  == $level && $category->visible == 1 )
	{
		$ccount = theme_mb2nl_get_category_courses_count( $category->id, true );
		$coursescount = ' <span class="info">(' . $ccount . ')</span>';
		$disabled = ! $ccount ? ' disabled' : '';
		$disabledcls = $disabled;

		$checked = ( $curentcat > 0 && $curentcat == $category->id ) ? ' checked' : '';

		if ( count( $children ) && ! $ccount )
		{
			$coursescount = '';
			$disabledcls = ' disabled1';
		}

		$output .= '<li class="filter-form-field">';
		$output .= '<div class="field-container' . $disabledcls . '">';
		$output .= '<label for="catid_' . $category->id . '">';
		$output .= '<input type="checkbox" id="catid_' . $category->id . '" name="filter_categories[]" value="' . $category->id . '"' . $disabled . $checked . '>';
		$output .= '<i></i>';
		$output .= format_text($category->name, FORMAT_HTML) . $coursescount . '</label>';
		$output .= count( $children ) && $togglecat ? '<button type="button" class="toggle-list-btn themereset" aria-label="' . 
		get_string('togglecategory', 'theme_mb2nl', format_text($category->name, FORMAT_HTML) ) . '"></button>' : '';
		$output .= '</div>'; // field-container
		$level++;

		if ( count( $children ) )
		{
			$togglecls = $togglecat ? ' toggle-list' : '';
			$output .= '<ul class="child-list' . $togglecls . '">';

			foreach ( $children as $child )
			{
				if ( in_array( $child->id, $excludecat ) )
				{
					continue;
				}

				$children = theme_mb2nl_get_children($child->id);
				$category = theme_mb2nl_get_category_record($child->id);
				$output .= theme_mb2nl_category_level( $category, $children, $level);
			}

			$output .= '</ul>';
		}

		$output .= '</li>';
	}

	return $output;


}



/*
 *
 * Method to get categories list
 *
 */
function theme_mb2nl_get_all_teachers( $opts = array(), $fields = 'u.id, u.firstname, u.lastname' )
{

	global $DB;

	$teacherroleid = theme_mb2nl_get_user_role_id( true );
	$andexcats = '';
	$sqlwhere = '';
	$params = array();
	$perpage = isset( $opts['limit'] ) ? $opts['limit'] : 0;

	//$params[] = CONTEXT_COURSE;
	//$params[] = $teacherroleid;

	if ( isset( $opts['teacherids'] ) &&  $opts['teacherids'] && $opts['exteachers'] )
	{
		$isnot = '';
		$opts['teacherids'] = explode( ',', $opts['teacherids'] );

		if ( $opts['exteachers'] === 'exclude' )
		{
			$isnot = count( $opts['teacherids'] ) > 1 ? 'NOT ' : '!';
		}

		list( $teachersnsql, $teachersparams ) = $DB->get_in_or_equal( $opts['teacherids'] );
		$params = array_merge( $params, $teachersparams );
		$sqlwhere .= ' AND u.id ' . $isnot . $teachersnsql;
	}

	// Exclude categories filter
	$excat = theme_mb2nl_course_excats();
	if ( $excat[0] )
	{
		$isnotexcat = count( $excat ) > 1 ? 'NOT ' : '!';
		list( $excatnsql, $excatparams ) = $DB->get_in_or_equal( $excat );
		$params = array_merge( $params, $excatparams );

		$andexcats = ' AND c.category ' . $isnotexcat . $excatnsql;
	}

	$sqlorederby = ' ORDER BY u.lastname';

	$recordsql = 'SELECT DISTINCT ' . $fields . ' FROM {user} u JOIN {role_assignments} ra ON u.id = ra.userid JOIN {context} cx ON ra.contextid = cx.id JOIN {course} c ON cx.instanceid = c.id' . $andexcats . ' AND cx.contextlevel=' . CONTEXT_COURSE . ' WHERE 1=1 AND ra.roleid=' . $teacherroleid;

	return $DB->get_records_sql( $recordsql . $sqlwhere . $sqlorederby, $params, 0, $perpage );

}






/**
 *
 * Method to courses array.
 *
 */
function theme_mb2nl_get_courses2( $opt = array(), $count = false )
{
	global $CFG, $PAGE;

	require_once( $CFG->dirroot . '/course/lib.php' );

	$perpage = $CFG->coursesperpage;
	$list = get_courses();

	foreach ( $list as $course )
	{

		$coursecontext = context_course::instance( $course->id );
		$catcontext = $course->category > 0 ? context_coursecat::instance( $course->category ) : 0;
		$category = core_course_category::get( $course->category, IGNORE_MISSING );

		if ( $course->category == 0 )
		{
			unset( $list[$course->id] );
		}

		// Filter categories
		if ( ! empty( $opt['categories'] ) && ! in_array( $course->category,  $opt['categories'] ) )
		{
			unset( $list[$course->id] );
		}

		// Filter instructors
		if ( ! empty( $opt['instructors'] ) &&  ! theme_mb2nl_course_check_course_teachers( $course->id, $opt['instructors'] ) )
		{
			unset( $list[$course->id] );
		}

		// Filter course price
		if ( isset( $opt['price'] ) && $opt['price'] == 0 )
		{
			if ( theme_mb2nl_is_course_price( $course->id ) && theme_mb2nl_get_course_price( $course->id )->cost > 0 )
			{
				unset( $list[$course->id] );
			}
		}
		elseif ( isset( $opt['price'] ) && $opt['price'] == 1 )
		{
			if ( ! theme_mb2nl_is_course_price( $course->id ) || theme_mb2nl_get_course_price( $course->id )->cost == 0 )
			{
				unset( $list[$course->id] );
			}
		}

		// Filter search
		if ( isset( $opt['searchstr'] )  && $opt['searchstr'] !== '' )
		{
			$coursename = strtolower( $course->fullname );
			$searchterm = $opt['searchstr'];

			if ( strpos( $coursename, $searchterm ) === false )
			{
				unset( $list[$course->id] );
			}
		}

		if ( ! $course->visible && ! has_capability( 'moodle/course:viewhiddenactivities', $coursecontext ) )
		{
			unset( $list[$course->id] );
		}

		if ( ( ! isset( $category->visible ) || ! $category->visible ) && ! has_capability( 'moodle/category:manage', $catcontext  ) )
		{
			unset( $list[$course->id] );
		}

	}

	if ( $count )
	{
		return count( $list );
	}

	$ispage = ( $opt['page'] - 1 );
	$list = array_slice( $list, $ispage * $perpage, $perpage );

	return $list;

}





/**
 *
 * Method to course list.
 *
 */
function theme_mb2nl_course_list( $opt = array(), $wrap = true )
{
	global $CFG, $OUTPUT, $PAGE;

	$output = '';
	$courses = theme_mb2nl_get_courses( $opt );
	$coursesnum = theme_mb2nl_get_courses( $opt, true );

	$output .= '<div class="theme-courses-list"' . theme_mb2nl_course_get_pagin_atts( $opt ) . '>';

	if ( ! count( $courses ) )
	{
		$output .= '<div class="theme-course-item nothingtodisplay">' . get_string( 'nothingtodisplay' ) . '</div>';
	}
	else
	{
		$output .= theme_mb2nl_course_list_courses( $courses, false, false, $opt );
	}

	$output .= '</div>'; // theme-courses-list

	$output .= theme_mb2nl_course_list_pagin( $coursesnum, $CFG->coursesperpage, $opt );

	return $output;
}





/**
 *
 * Method to course list.
 *
 */
function theme_mb2nl_course_list_courses( $courses, $box = false, $builder = false, $options = array() )
{
	global $CFG, $PAGE;
	$output = '';
	$reviews = theme_mb2nl_is_review_plugin();
	$quickview = theme_mb2nl_theme_setting( $PAGE, 'quickview' );
	$rating = '';
	$carousel = ( isset( $options['carousel'] ) && $options['carousel'] );
	$carouselcls = $carousel ? ' swiper-slide' : '';

	$lazycls = $options['lazy'] ? ' class="lazy"' : '';
	$lazysrc = $options['lazy'] ? 'src="' . theme_mb2nl_lazy_plc() . '" data-src' : 'src';

	if ( $reviews )
	{
		if ( ! class_exists( 'Mb2reviewsHelper' ) )
		{
			require_once( $CFG->dirroot . '/local/mb2reviews/classes/helper.php' );
		}
	}

	$cls = $box ? ' theme-box' : '';
	$cls .= $quickview ? ' quickview' : ' noquickview';

	if ( ! count( $courses ) )
	{
		$output .= '<div class="theme-box">';
		$output .= get_string( 'nothingtodisplay' );
		$output .= '</div>';
		return $output;
	}

	foreach ( $courses as $course )
	{
		$courselink = $builder ? '#' : new moodle_url( '/course/view.php', array( 'id' => $course->id ) );
		$price = theme_mb2nl_course_list_price( $course->id );

		$catcls = ' cat-' . $course->category;
		$pricecls = $price ? ' isprice' : ' noprice';

		$coursecontext = context_course::instance( $course->id );
		$bestseller = theme_mb2nl_is_bestseller( $coursecontext->id, $course->category );
		$bestcls = $bestseller ?  ' bestseller' : '';

		$output .= '<div class="theme-course-item course-' . $course->id . $cls . $catcls . $bestcls . $pricecls . $carouselcls . '" data-course="' . $course->id . '" role="presentation">';
		$output .= '<div class="theme-course-item-inner">';

		$output .= '<div class="image-wrap">';

		$output .= '<div class="image">';
		$output .= $bestseller ? '<span class="bestseller-flag">' . get_string( 'bestseller', 'local_mb2builder' ) . '</span>': '';
		$output .= '<img' . $lazycls . ' ' . $lazysrc . '="' . theme_mb2nl_course_image_url( $course->id, true ) . '" alt="' . format_text($course->fullname, FORMAT_HTML) . '">';
		$output .= '</div>'; // image

		if ( ! $quickview )
		{
			$output .= '<div class="image-content">';
			$output .= '<a href="' . $courselink . '" class="linkbtn" tabindex="-1">' . get_string('view') . '</a>';
			$output .= '</div>'; // image-content
		}

		$output .= '</div>'; // image-wrap

		$output .= '<h4 class="title">';
		$output .= '<a href="' . $courselink . '" tabindex="-1">' . format_text($course->fullname, FORMAT_HTML) . '</a>';
		$output .= '</h4>';

		$output .= '<div class="course-content">';

		$output .= theme_mb2nl_course_list_teachers( $course->id );

		if ( $reviews )
		{
			$rating = Mb2reviewsHelper::course_rating( $course->id );

			if ( $rating )
			{
				$output .= '<div class="course-rating">';
				$output .= '<span class="ratingnum">' . $rating . '</span>';
				$output .= Mb2reviewsHelper::rating_stars( $course->id, false, 'sm' );
				$output .= '<span class="ratingcount">(' . Mb2reviewsHelper::course_rating_count( $course->id ) . ')</span>';
				$output .= '</div>'; // course-rating
			}
		}

		$output .= '</div>'; // course-content

		$output .= '<div class="course-footer">';
		$output .= $price;
		$output .= theme_mb2nl_course_list_students( $course->id );
		$output .= theme_mb2nl_course_list_date( $course );
		$output .= '</div>'; // course-content
		$output .= $courselink ? '<a class="themekeynavlink" href="' . $courselink . '" tabindex="0" aria-label="' . format_text($course->fullname, FORMAT_HTML) . '"></a>' : '';
		$output .= '</div>'; // theme-course-item-inner
		$output .= '</div>'; // theme-course-item
	}

	return $output;

}







/**
 *
 * Method to set course list pagination.
 *
 */
function theme_mb2nl_course_list_pagin( $items, $limit, $opt )
{
	$output = '';

	$numpagesround = round( $items / $limit, 1 );
	$numpages = ceil( $numpagesround );
	$ends_count = 1;
	$middle_count = 2;
	$dots = false;

	if ( $numpages < 2 )
	{
		return;
	}

	$output .= '<div class="theme-courses-pagin">';
	$output .= '<ul class="theme-courses-pagin-list">';

	// Set previous button
	if ( $opt['page'] > 1 )
	{
		$output .= '<li class="theme-courses-paginitem prev" data-page="' .  ($opt['page'] - 1) . '"><span><i class="fa fa-angle-left"></i></span></li>';
	}

	for ( $i = 1; $i <= $numpages; $i++ )
	{
		if ( $i == $opt['page'] )
		{
			$output .= '<li class="theme-courses-paginitem active" data-page="' . $i . '"><span>' . $i . '</span></li>';
			$dots = true;
		}
		else
		{
			if ( $i <= $ends_count || ( $opt['page'] && $i >= ($opt['page'] - $middle_count) && $i <= ( $opt['page'] + $middle_count ) ) || $i > $numpages - $ends_count )
			{
				$output .= '<li class="theme-courses-paginitem" data-page="' .  $i . '"><span>' . $i . '</span></li>';
				$dots = true;
			}
			elseif ( $dots )
			{
				$output .= '<li class="dots"><span>...</span></li>';
				$dots = false;
			}
		}
	}

	// Set next button
	if ( $opt['page'] < $numpages )
	{
		$output .= '<li class="theme-courses-paginitem next" data-page="' .  ($opt['page'] + 1) . '"><span><i class="fa fa-angle-right"></i></span></li>';
	}

	$output .= '</ul>';
	$output .= '</div>';

	return $output;

}





/**
 *
 * Method to set course top bar.
 *
 */
function theme_mb2nl_course_top_bar()
{
	$output = '';

	$output .= '<div class="theme-courses-topbar">';
	$output .= theme_mb2nl_course_searchform();
	//$output .= theme_mb2nl_course_layout_switcher();
	$output .= '</div>';

	return $output;

}





/**
 *
 * Method to set course search form.
 *
 */
function theme_mb2nl_course_searchform()
{
	$output = '';

	$output .= '<form name="theme-course-search" class="theme-course-search" action="" method="GET">';
	$output .= '<div class="search-field">';
	$output .= '<input id="theme-course-search" name="theme-course-search" type="search" value="" placeholder="' . get_string('searchcourses') . '">';
	$output .= '<button type="submit"><i class="fa fa-search"></i></button>';
	$output .= '</div>';
	$output .= '</form>';

	return $output;

}






/**
 *
 * Method to set course layout switcher.
 *
 */
function theme_mb2nl_course_layout_switcher()
{
	global $PAGE;

	$output = '';

	$coursegrid = theme_mb2nl_theme_setting( $PAGE, 'coursegrid' );

	if ( ! $coursegrid )
	{
		return;
	}

	if ( ! theme_mb2nl_theme_setting( $PAGE, 'courseswitchlayout' ) )
	{
		return;
	}

	$actice_cls_grid = '';
	$actice_cls_list = ' active';

	if ( $coursegrid )
	{
		$actice_cls_grid = ' active';
		$actice_cls_list = '';
	}

	$output .= '<div class="course-layout-switcher">';
	$output .= '<a href="#" class="grid-layout' . $actice_cls_grid . '" title="' .
	get_string('layoutgrid', 'theme_mb2nl') . '" data-toggle="tooltip" data-trigger="hover"><i class="fa fa-th-large"></i></a>';
	$output .= '<a href="#" class="list-layout' . $actice_cls_list . '" title="' .
	get_string('layoutlist', 'theme_mb2nl') . '" data-toggle="tooltip" data-trigger="hover"><i class="fa fa-th-list"></i></a>';
	$output .= '</div>';

	return $output;

}





/**
 *
 * Method to get pagination data attributes.
 *
 */
function theme_mb2nl_course_get_pagin_atts( $opt )
{
	$output = '';

	foreach ( $opt as $k=>$o )
	{
		$isv = is_array( $o ) ? urlencode( serialize( $o ) ) : $o;

		if ( $k === 'price' &&  $o === '' )
		{
			$isv = -1;
		}

		$output .= ' data-' . $k . '="' . $isv . '"';
	}

	return $output;
}





/**
 *
 * Method to check teachres for teachers filter.
 *
 */
function theme_mb2nl_course_check_course_teachers( $courseid, $teachers = array() )
{

	$courseteachers = theme_mb2nl_get_course_teachers( $courseid );

	foreach ( $courseteachers as $courseteacher )
	{
		if ( in_array( $courseteacher['id'], $teachers ) )
		{
			return true;
		}
	}

	return false;

}




/**
 *
 * Method to get count courses (paid and free).
 *
 */
function theme_mb2nl_get_paidfree_courses_count( $free = false, $hidden = false )
{
	global $DB, $PAGE;

	$params = array();
	$not = $free ? 'NOT ' : '';
	$andcourses = $hidden ? '' : ' AND c.visible = 1';
	$andexcats = '';
	$anddate = '';

	// Payment filter
	list( $priceinsql, $priceparams ) = $DB->get_in_or_equal( theme_mb2nl_pay_enrolements() );
	$params = array_merge( $params, $priceparams );

	// Check expired courses
	if ( ! theme_mb2nl_theme_setting( $PAGE, 'expiredcourses' ) )
	{
		$anddate = ' AND (c.enddate=0 OR c.enddate>' . theme_mb2nl_get_user_date() . ')';
	}

	// Exclude categories filter
	$excat = theme_mb2nl_course_excats();

	if ( $excat[0] )
	{
		$isnotexcat = count( $excat ) > 1 ? 'NOT ' : '!';
		list( $excatnsql, $excatparams ) = $DB->get_in_or_equal( $excat );
		$params = array_merge( $params, $excatparams );

		$andexcats = ' AND c.category ' . $isnotexcat . $excatnsql;
	}

	$sqlquery = 'SELECT COUNT(c.id) FROM {course} c WHERE ' . $not . 'EXISTS( SELECT er.id FROM {enrol} er WHERE er.courseid = c.id AND er.status = ' . ENROL_INSTANCE_ENABLED . ' AND er.enrol ' . $priceinsql .') AND c.id > 1' . $andexcats . $andcourses . $anddate;

	return $DB->count_records_sql( $sqlquery, $params);

}



/**
 *
 * Method to get courses exlude categories
 *
 */
function theme_mb2nl_course_excats()
{
	global $PAGE;

	$excludecat = theme_mb2nl_theme_setting( $PAGE, 'excludecat' );
	return explode( ',', $excludecat );

}





/**
 *
 * Method to get courses list layout.
 *
 */
function theme_mb2nl_course_list_layout()
{
	global $PAGE;

	$output = '';
	$inline_js = '';

	$inline_js .= 'require([\'theme_mb2nl/subscribe\'], function(GradingPanel) {';
	$inline_js .= 'new GradingPanel(\'#main-content\');';
	$inline_js .= '});';

	$PAGE->requires->js_amd_inline( $inline_js );

	$opt = array(
		'page'=> 1,
		'categories' => array(),
		'tags' => array(),
		'instructors' => array(),
		'price' => -1,
		'searchstr' => ''
	);

	$opt['lazy'] = 1;

	// Check if there is a category ID in the URL
	$parts = theme_mb2nl_get_url_params();

	if ( array_key_exists( 'categoryid', $parts ) )
	{
		$opt['categories'][] = $parts['categoryid'];
		$output .= theme_mb2nl_children_categories( $parts['categoryid'] );
	}

	$output .= '<div class="courses-container">';
	$output .= theme_mb2nl_course_top_bar();
	$output .= '<div class="courses-container-inner">';
	$output .= theme_mb2nl_course_list( $opt );
	$output .= '</div>'; // courses-container
	$output .= '</div>'; // courses-container-inner

	return $output;
}



/**
 *
 * Method to get children categories list layout.
 *
 */
function theme_mb2nl_children_categories( $parent )
{

	$output = '';

	$categories = theme_mb2nl_get_children( $parent, 'id,name', true );

	if ( ! count( $categories ) )
	{
		return;
	}

	$output .= '<div class="children-categories">';

	foreach( $categories as $category )
	{
		$catlink = new moodle_url( '/course/index.php', array( 'categoryid' => $category->id ) );

		$output .= '<div class="children-category cat-' . $category->id . '">';
		$output .= '<a href="' . $catlink . '">';
		$output .= '<h4 class="children-cat-title">' . format_text($category->name, FORMAT_HTML) . '</h4>';
		$output .= '<div class="children-category-details">';
		$output .= get_string('teachercourses', 'theme_mb2nl', array('courses' => theme_mb2nl_get_category_courses_count( $category->id, true ) ) );
		$output .= '</div>';
		$output .= '</a>';
		$output .= '</div>';
	}

	$output .= '</div>';

	return $output;

}







/**
 *
 * Method to check if ajax grid course is enabled
 *
 */
function theme_mb2nl_is_course_list()
{
	global $PAGE;

	$ccparam = optional_param('ccparam', 0, PARAM_INT);
	$ccparamgrid = optional_param('ccparamgrid', 0, PARAM_INT);
	$coursegrid = theme_mb2nl_theme_setting( $PAGE, 'coursegrid' );

	if ( $PAGE->pagetype !== 'course-index-category')
	{
		return;
	}

	if ( $ccparam )
	{
		return $ccparamgrid;
	}

	return $coursegrid;

}



/**
 *
 * Method to get categories tabs
 *
 */
function theme_mb2nl_coursetabs_tabs( $opts )
{
	$i = 0;
	$output = '';
	$categories = theme_mb2nl_get_categories( true, $opts ); // True means without emepty categories
	$coursetags = theme_mb2nl_course_tags($opts);

	$output .= '<div class="coursetabs-tablist">';

	if (  $opts['filtertype'] === 'tag'  )
	{
		foreach( $coursetags as $tag )
		{
			$coursecount = theme_mb2nl_get_tags_courses_count( $tag->id );

			if ( ! $coursecount )
			{
				continue;
			}

			$i++;
			$isactive = $i == 1 ? ' active' : '';

			$output .= '<button class="coursetabs-catitem themereset' . $isactive . '" data-category="' .
			$tag->id . '" aria-controls="' . $opts['uniqid'] . '_category-content-' . $tag->id . '" data-uniqid="' . $opts['uniqid'] . '">';
			$output .= '<span class="catname">' . $tag->rawname . '</span>';
			$output .= '<span class="coursecount">(' . $coursecount . ')</span>';
			$output .= '</button>'; // coursetabs-catitem
		}
	}
	else
	{
		foreach( $categories as $category )
		{
			$coursecount = theme_mb2nl_get_category_courses_count( $category->id, true );

			if ( ! $coursecount )
			{
				continue;
			}

			$i++;
			$isactive = $i == 1 ? ' active' : '';

			$output .= '<button class="coursetabs-catitem themereset' . $isactive . '" data-category="' .
			$category->id . '" aria-controls="' . $opts['uniqid'] . '_category-content-' . $category->id . '" data-uniqid="' . $opts['uniqid'] . '">';
			$output .= '<span class="catname">' . $category->name . '</span>';
			$output .= '<span class="coursecount">(' . $coursecount . ')</span>';
			$output .= '</button>'; // coursetabs-catitem
		}
	}

	$output .= '</div>'; // coursetabs-tablist

	return $output;

}



/**
 *
 * Method to get courses in category tabs
 *
 */
function theme_mb2nl_coursetabs_courses( $opts )
{

	$output = '';
	$i = 0;
	$categories = theme_mb2nl_get_categories( true, $opts ); // True means without emepty categories
	$coursetags = theme_mb2nl_course_tags($opts);

	if ( $opts['filtertype'] === 'tag' )
	{
		foreach( $coursetags as $tag )
		{
			if ( ! theme_mb2nl_get_tags_courses_count( $tag->id ) )
			{
				continue;
			}

			$i++;
			$opts['tags'] = array( $tag->id );
			$opts['categories'] = array();
			$opts['catdesc'] = ''; // We don't have a tag description in function: theme_mb2nl_coursetabs_tabcontent
			$fillcls = $i==1 ? ' active fillin' : '';
			$output .= '<div class="coursetabs-content' . $fillcls . '" id="' . $opts['uniqid'] . '_category-content-' . $tag->id  . '">';

			if ( $i == 1 )
			{
				$output .= theme_mb2nl_coursetabs_tabcontent( $opts );
			}

			$output .= '</div>'; // coursetabs-content
		}
	}
	else
	{
		foreach( $categories as $category )
		{
			if ( ! theme_mb2nl_get_category_courses_count( $category->id, true ) )
			{
				continue;
			}

			$i++;
			$opts['categories'] = array( $category->id );
			$opts['tags'] = array();
			$fillcls = $i==1 ? ' active fillin' : '';
			$output .= '<div class="coursetabs-content' . $fillcls . '" id="' . $opts['uniqid'] . '_category-content-' . $category->id  . '">';

			if ( $i == 1 )
			{
				$output .= theme_mb2nl_coursetabs_tabcontent( $opts );
			}

			$output .= '</div>'; // coursetabs-content
		}
	}


	return $output;

}




/**
 *
 * Method to get category element in course tab
 *
 */
function theme_mb2nl_coursetabs_tabcontent( $opts )
{
	global $PAGE;

	$output = '';
	$courses = theme_mb2nl_get_courses( $opts );
	$sliderid = uniqid('swiper_');

	$list_cls = '';
	$list_cls .= $opts['carousel'] ? ' swiper-wrapper' : '';
	$list_cls .= ! $opts['carousel'] ? ' theme-boxes theme-col-' . $opts['columns'] : '';
	$list_cls .= ! $opts['carousel'] ? ' gutter-' . $opts['gutter'] : '';

	$container_cls = $opts['carousel'] ? ' swiper' : '';

	$output .= $opts['catdesc'] ? theme_mb2nl_coursetabs_category( $opts['categories'][0] ) : '';
	$output .= '<div id="' . $sliderid . '" class="mb2-pb-content' . $container_cls . '">';
	$output .= theme_mb2nl_shortcodes_swiper_nav();
	$output .= '<div class="mb2-pb-content-list' . $list_cls . '">';
	$output .= theme_mb2nl_shortcodes_course_template( $courses, $opts );
	$output .= '</div>'; // mb2-pb-content-list
	$output .= theme_mb2nl_shortcodes_swiper_pagenavnav();
	$output .= '</div>'; // mb2-pb-content

	return $output;

}


/**
 *
 * Method to get category element in course tab
 *
 */
function theme_mb2nl_coursetabs_category( $catid )
{
	global $PAGE, $OUTPUT, $CFG;
	require_once( $CFG->libdir . '/filelib.php' );

	$output = '';
	$category = theme_mb2nl_get_category_record( $catid, 'id, name, description' );
	$context = context_coursecat::instance( $category->id );

	// Get category description
	$description = file_rewrite_pluginfile_urls( $category->description, 'pluginfile.php', $context->id, 'coursecat', 'description', NULL );
	$description = format_text( $description );

	// Category image
	$catimage = theme_mb2nl_category_image( $category->id );
	$courseplaceholder = theme_mb2nl_theme_setting( $PAGE, 'courseplaceholder', '', true );
	$plchimage = $courseplaceholder ? $courseplaceholder : $OUTPUT->image_url('course-default','theme');
	$imgurl = $catimage ? $catimage : $plchimage;

	$catlink = new moodle_url( '/course/index.php', array( 'categoryid' => $category->id ) );

	$output .= '<div class="coursetabs-category">';
	$output .= '<div class="category-desc">';
	$output .= '<h4 class="category-title">' . get_string('categorydesc', 'theme_mb2nl') . '</h4>';
	$output .= $description ? $description : '<p>To add category description and image you have to edit category: <b>' . $category->name . '</b>. To set category image just insert an image into category description.</p>';
	$output .= '<div class="category-readmore">';
	$output .= '<a href="' . $catlink . '" class="btn btn-primary">' . get_string('explorecategory', 'theme_mb2nl', array('category'=>$category->name)) . '</a>';
	$output .= '</div>'; // category-readmore
	$output .= '</div>'; // category-desc
	$output .= '<div class="category-image">';
	$output .= '<div class="catimage" style="background-image:url(\'' . $imgurl . '\');"></div>';
	$output .= '</div>'; // category-image
	$output .= '</div>'; // coursetabs-category

	return $output;

}



/**
 *
 * Method to get category description
 *
 */
function theme_mb2nl_category_desc($catid)
{
	global $COURSE, $CFG;
	require_once( $CFG->libdir . '/filelib.php' );

	$category = theme_mb2nl_get_category_record($catid, 'description');

	if ( ! $category )
	{
		return;
	}

	$context = context_coursecat::instance( $catid );
	$desc = file_rewrite_pluginfile_urls( $category->description, 'pluginfile.php', $context->id, 'coursecat', 'description', NULL );
	$desc = format_text( $desc, FORMAT_HTML );

	return $desc;

}






/**
 *
 * Method to get category element in course tab
 *
 */
function theme_mb2nl_category_image( $catid, $name = false )
{

	$desc = theme_mb2nl_category_desc($catid);
	return theme_mb2nl_image_from_text($desc, $name);

}
