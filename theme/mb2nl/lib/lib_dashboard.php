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
 * Method to get dashboard
 *
 */
function theme_mb2nl_dashboard()
{
	global $PAGE;
	$output = '';
	$tabs = theme_mb2nl_dashboard_get_tabs();
	$blocks = theme_mb2nl_dashboard_blocks();

	// User preferences
	user_preference_allow_ajax_update('dashboard-active', PARAM_ALPHA);
	$activetab = get_user_preferences('dashboard-active', 'courses');

	$output .= '<div class="theme-dashboard">';

	$output .= '<div class="dashboard-tabs">';
	$output .= '<ul class="tabs-list">';

	foreach ( $tabs as $tab )
	{
		$cls = $activetab === $tab['id'] ? ' active' : '';
		$output .= '<li class="tab-item item-' . $tab['id'] . '">';
		$output .= '<button class="themereset' . $cls . '" type="button" data-id="' . $tab['id'] . '">' . $tab['name'] . '</button>';
		$output .= '</li>';
	}

	$output .= '</ul>';
	$output .= '</div>'; // dashboard-tabs

	$output .= '<div class="dashboard-bocks">';

	foreach ( $tabs as $tab )
	{
		$cls = $activetab === $tab['id'] ? ' active' : '';

		$output .= '<div id="theme-dashboard-tab-content-' . $tab['id'] . '" class="tab-content' . $cls . '">';

		$output .= '<div class="tab-col col1">';
		$output .= '<div class="tab-col-inner">';

		foreach ( $blocks as $block )
		{
			if ( $tab['id'] !== $block['tab'] || $block['col'] == 2 )
			{
				continue;
			}

			$output .= theme_mb2nl_dashboard_block($tab, $block);
		}

		$output .= '</div>'; // tab-col-inner
		$output .= '</div>'; // tab-col col1

		$output .= '<div class="tab-col col2">';
		$output .= '<div class="tab-col-inner">';

		foreach ( $blocks as $block )
		{
			if ( $tab['id'] !== $block['tab'] || $block['col'] == 1 )
			{
				continue;
			}

			$output .= theme_mb2nl_dashboard_block($tab, $block);
		}

		$output .= '</div>'; // tab-col-inner
		$output .= '</div>'; // tab-col col1

		$output .= '</div>'; // tab-content
	}

	$output .= '</div>'; // dashboard-bocks

	$output .= '</div>'; // theme-dashboard

	return $output;

}





/*
 *
 * Method to get dashboard block
 *
 */
function theme_mb2nl_dashboard_block($tab, $block)
{
	global $PAGE;
	$output = '';

	$clscontnt = $block['content'] ? ' iscontent' : '';
	$clsvalue = $block['value2'] !== '' && $block['value3'] === '' ? ' is2values' : '';
	$clsvalue3 = $block['value3'] !== '' ? ' is3values' : '';

	$output .= '<div class="block-item block-item-' . $block['id'] . $clscontnt . $clsvalue . $clsvalue3 . '">';
	$output .= '<div class="block-item-inner">';
	if ( $block['type'] === 'chart' )
	{
		$data = array_slice($block['data'], 0, 5);
		$lables = array();
		$dataval = array();

		foreach ( $data as $k=>$d )
		{
			$lables[] = $k;
			$dataval[] = $d;
		}

		$fname = theme_mb2nl_theme_setting($PAGE, 'ffgeneral');


		$output .= '<canvas id="mycustombar" width="600" height="276"></canvas>';

		//$PAGE->requires->js_call_amd('theme_mb2nl/dashboardchart','chartInit', array( 'mycustombar', implode(',', $lables),  implode(',', $dataval)  ), theme_mb2nl_theme_setting($PAGE, $fname )  );

	}
	$output .= '<div class="block-icon"><i class="' . $block['icon'] . '"></i></div>';
	$output .= '<div class="block-content">';
	$output .= '<div class="block-value">';

	$output .= '<div class="block-value1">';
	$output .= '<span class="value">' . $block['value'] . '</span>';
	$output .= $block['suffix'] ? '<span class="suffix">' . $block['suffix'] . '</span>' : '';
	$output .= '</div>'; // block-value1

	if ( $block['value2'] !== '' )
	{
		$output .= '<div class="block-value2">';
		$output .= '<span class="value value2">' . $block['value2'] . '</span>';
		$output .= '<span class="suffix">' . $block['suffix2'] . '</span>';
		$output .= '</div>'; // block-value2
	}

	if ( $block['value3'] !== '' )
	{
		$output .= '<div class="block-value2">';
		$output .= '<span class="value value2">' . $block['value3'] . '</span>';
		$output .= '<span class="suffix">' . $block['suffix3'] . '</span>';
		$output .= '</div>'; // block-value2
	}

	$output .= $block['more'] ? '<a href="' . $block['more'] . '" class="more"><i class="pe-7s-edit"></i></a>' : '';
	$output .= '<div class="block-name">' . $block['name'] . '</div>';
	$output .= '</div>'; // block-value
	$output .= '</div>'; // block-content

	if ( $block['content'] )
	{
		$output .= '<div class="block-content2">';
		$output .= $block['content'];
		$output .= '</div>'; // block-content2
	}

	$output .= '</div>'; // block-item-inner
	$output .= '</div>'; // block-item

	return $output;

}





/*
 *
 * Method to get dashboard
 *
 */
function theme_mb2nl_dashboard_blocks()
{

	$blocks = array(
		array(
			'id' => 'moodledata',
			'type' => 'block',
			'name' => 'Moodledata',
			'tab' => 'system',
			'col' => 1,
			'icon' => 'pe-7s-folder',
			'user' => 'admin',
			'value' => theme_mb2nl_dashboard_moodledata(),
			'value2' => '',
			'value3' => '',
			'suffix' => 'GB',
			'suffix2' => '',
			'suffix3' => '',
			'more' => '',
			'content' => '',
			'data' => ''
		),
		array(
			'id' => 'performance',
			'type' => 'block',
			'name' => get_string('performance', 'admin'),
			'tab' => 'system',
			'col' => 1,
			'icon' => 'pe-7s-rocket',
			'user' => 'admin',
			'value' => theme_mb2nl_dashboard_performance(),
			'value2' => '',
			'value3' => '',
			'suffix' => get_string('preformanceproblems', 'theme_mb2nl'),
			'suffix2' => '',
			'suffix3' => '',
			'more' => new moodle_url( '/report/performance/index.php', array() ),
			'content' => '',
			'data' => ''
		),
		array(
			'id' => 'filespace',
			'type' => 'block',
			'name' => get_string('diskusage', 'theme_mb2nl'),
			'tab' => 'system',
			'col' => 2,
			'icon' => 'pe-7s-server',
			'user' => 'admin',
			'value' => theme_mb2nl_dashboard_filespace(),
			'value2' => '',
			'value3' => '',
			'suffix' => 'GB',
			'suffix2' => '',
			'suffix2' => '',
			'suffix3' => '',
			'more' => '',
			'content' => '',
			'data' => ''
		),
		array(
			'id' => 'users',
			'type' => 'block',
			'name' => get_string('users'),
			'tab' => 'users',
			'col' => 1,
			'icon' => 'pe-7s-users',
			'user' => 'admin',
			'value' => theme_mb2nl_dashboard_users(),
			'value2' => '',
			'value3' => '',
			'suffix' => get_string('allusers', 'search'),
			'suffix2' => '',
			'suffix3' => '',
			'more' => new moodle_url( '/admin/user.php', array() ),
			'content' => theme_mb2nl_dashboard_chart(
				array(
					'mainval' => theme_mb2nl_dashboard_users(),
					'val1' => theme_mb2nl_dashboard_activeusers(),
					'val2' => theme_mb2nl_dashboard_suspendedusers(),
					'str1' => get_string('activeusers'),
					'str2' => get_string('suspendedusers')
				)
			),
			'data' => ''
		),
		array(
			'id' => 'newusers',
			'type' => 'block',
			'name' => get_string('newusers'),
			'tab' => 'users',
			'col' => 2,
			'icon' => 'pe-7s-add-user',
			'user' => 'admin',
			'value' => theme_mb2nl_dashboard_newusers(),
			'value2' => '',
			'value3' => '',
			'suffix' => get_string('users'),
			'suffix2' => '',
			'suffix3' => '',
			'more' => '',
			'content' => '',
			'data' => ''
		),
		array(
			'id' => 'onlineusers',
			'type' => 'block',
			'name' => get_string('onlineusers', 'theme_mb2nl'),
			'tab' => 'users',
			'col' => 2,
			'icon' => 'pe-7s-signal',
			'user' => 'admin',
			'value' => theme_mb2nl_dashboard_onlineusers(),
			'value2' => theme_mb2nl_dashboard_onlineusers(60),
			'value3' => '',
			'suffix' => get_string('online', 'message'),
			'suffix2' => get_string('lasthour', 'theme_mb2nl'),
			'suffix3' => '',
			'more' => '',
			'content' => '',
			'data' => ''
		),
		array(
			'id' => 'courses',
			'type' => 'block',
			'name' => get_string('courses'),
			'tab' => 'courses',
			'col' => 1,
			'icon' => 'pe-7s-bookmarks',
			'user' => 'admin',
			'value' => theme_mb2nl_dashboard_courses(),
			'value2' => '',
			'value3' => '',
			'suffix' => get_string('fulllistofcourses'),
			'suffix2' => '',
			'suffix3' => '',
			'more' => new moodle_url( '/course/management.php', array('categoryid'=>0) ),
			'content' => theme_mb2nl_dashboard_chart(
				array(
					'mainval' => theme_mb2nl_dashboard_courses(),
					'val1' => theme_mb2nl_dashboard_courses(true),
					'val2' => theme_mb2nl_dashboard_courses(false, true),
					'str1' => get_string('hiddenfromstudents'),
					'str2' => get_string('expiredcourses', 'theme_mb2nl')
				)
			),
			'data' => ''
		),


		array(
			'id' => 'categories',
			'type' => 'block',
			'name' => get_string('categories'),
			'tab' => 'courses',
			'col' => 1,
			'icon' => 'pe-7s-folder',
			'user' => 'admin',
			'value' => theme_mb2nl_dashboard_categories(),
			'value2' => theme_mb2nl_dashboard_categories(true),
			'value3' => theme_mb2nl_dashboard_categories() - theme_mb2nl_dashboard_categories(false, true),
			'suffix' => get_string('categories', 'grades'),
			'suffix2' => get_string('hidden', 'badges'),
			'suffix3' => get_string('emptycategories', 'theme_mb2nl'),
			'more' => '',
			'content' => '',
			'data' => ''
		),
		array(
			'id' => 'courseusers',
			'type' => 'block',
			'name' => get_string('users'),
			'tab' => 'courses',
			'col' => 1,
			'icon' => 'pe-7s-study',
			'user' => 'admin',
			'value' => theme_mb2nl_dashboard_students(),
			'value2' => theme_mb2nl_dashboard_students(true),
			'value3' => '',
			'suffix' => get_string('students'),
			'suffix2' => get_string('teachers'),
			'suffix3' => '',
			'more' => '',
			'content' => '',
			'data' => ''
		),
		array(
			'id' => 'courseactiveusers',
			'type' => 'block',
			'name' => get_string('activeusers'),
			'tab' => 'courses',
			'col' => 1,
			'icon' => 'pe-7s-glasses',
			'user' => 'admin',
			'value' => theme_mb2nl_dashboard_students(false, true),
			'value2' => theme_mb2nl_dashboard_students(true, true),
			'value3' => '',
			'suffix' => get_string('students'),
			'suffix2' => get_string('teachers'),
			'suffix3' => '',
			'more' => '',
			'content' => '',
			'data' => ''
		),
		array(
			'id' => 'coursemodules',
			'type' => 'block',
			'name' => get_string('modulesused'),
			'tab' => 'courses',
			'col' => 1,
			'icon' => 'pe-7s-plugin',
			'user' => 'admin',
			'value' => theme_mb2nl_dashboard_modules(),
			'value2' => theme_mb2nl_dashboard_modules(true),
			'value3' => theme_mb2nl_dashboard_modules(true, 'quiz'),
			'suffix' => get_string('managemodules'),
			'suffix2' => get_string('activemodules', 'theme_mb2nl'),
			'suffix3' => get_string('activequizzes', 'theme_mb2nl'),
			'more' => new moodle_url( '/admin/modules.php', array() ),
			'content' => '',
			'data' => ''
		),
		// array(
		// 	'id' => 'moduleschart',
		// 	'type' => 'chart',
		// 	'name' => get_string('modulesused'),
		// 	'tab' => 'courses',
		// 	'col' => 2,
		// 	'icon' => 'pe-7s-plugin',
		// 	'user' => 'admin',
		// 	'value' => theme_mb2nl_dashboard_modules(),
		// 	'value2' => theme_mb2nl_dashboard_modules(true),
		// 	'value3' => '',
		// 	'suffix' => get_string('managemodules'),
		// 	'suffix2' => get_string('activemodules', 'theme_mb2nl'),
		// 	'suffix3' => '',
		// 	'more' => '',
		// 	'content' => '',
		// 	'data' => theme_mb2nl_dashboard_modules_count()
		// ),


	);




	return $blocks;


}





/*
 *
 * Method to get dashboard tabs
 *
 */
function theme_mb2nl_dashboard_get_tabs()
{
	$tabs = array();

	if ( is_siteadmin() )
	{
		$tabs[] = array('id'=>'system', 'name'=>get_string('coresystem'));
		$tabs[] = array('id'=>'users', 'name'=>get_string('users'));
		$tabs[] = array('id'=>'courses', 'name'=>get_string('courses'));
	}

	return $tabs;
}



/*
 *
 * Method to get dashboard
 *
 */
function theme_mb2nl_dashboard_moodledata()
{

	global $CFG;

	$kb = 1024;
	$mb = $kb * 1024;
	$gb = $mb * 1024;
	$tb = $gb * 1024;

	$totalusage = get_directory_size( $CFG->dataroot );
	$totalusagereadable = round( $totalusage/$gb, 2 );

	return $totalusagereadable;

}



/*
 *
 * Method to get dashboard performance
 *
 */
function theme_mb2nl_dashboard_performance()
{
	global $CFG;

	$output = '';
	$issues = 0;
	$preformances = array(
		'themedesignermode' => $CFG->themedesignermode ? 1 : 0,
		'debugdev' => debugging('', DEBUG_DEVELOPER) ? 1 : 0,
		'cachejs' => $CFG->cachejs ? 0 : 1,
		'enablestats' => $CFG->enablestats ? 1 : 0,
		'automatedbackups' => get_config('backup', 'backup_auto_active') == 1 ? 1 : 0
	);

	foreach ( $preformances as $p )
	{
		if ( $p )
		{
			$issues++;
		}
	}

	return $issues;

}




/*
 *
 * Method to get file space
 *
 */
function theme_mb2nl_dashboard_filespace()
{
	global $DB;

	$kb = 1024;
	$mb = $kb * 1024;
	$gb = $mb * 1024;
	$tb = $gb * 1024;

	$count = $DB->get_record_sql('SELECT SUM(filesize) as space FROM {files}');

	return round( $count->space/$gb, 2 );

}





/*
 *
 * Method to get all users
 *
 */
function theme_mb2nl_dashboard_users()
{
    global $DB;

    $sql = 'SELECT count(id) AS num FROM {user} WHERE id > 1 AND deleted = 0';

    return $DB->count_records_sql($sql);
}





/*
 *
 * Method to get all users
 *
 */
function theme_mb2nl_dashboard_activeusers()
{
    global $DB;

	$accessactive = theme_mb2nl_dashboard_user_active_time();
    $sql = 'SELECT count(id) AS num FROM {user} WHERE id > 1 AND deleted = 0 AND suspended = 0 AND lastaccess >=' . $accessactive;

    return $DB->count_records_sql($sql);
}



/*
 *
 * Method to get new users
 *
 */
function theme_mb2nl_dashboard_newusers()
{
    global $DB;

	$newcreated = theme_mb2nl_dashboard_user_new_time();
    $sql = 'SELECT count(id) AS num FROM {user} WHERE id > 1 AND deleted = 0 AND suspended = 0 AND timecreated >=' . $newcreated;

    return $DB->count_records_sql($sql);
}






/*
 *
 * Method to get suspended users
 *
 */
function theme_mb2nl_dashboard_suspendedusers()
{
    global $DB;

    $sql = 'SELECT count(id) AS num FROM {user} WHERE id > 1 AND deleted = 0 AND suspended = 1';

    return $DB->count_records_sql($sql);
}




/*
 *
 * Method to get courses count
 *
 */
function theme_mb2nl_dashboard_courses($hidden = false, $expired = false)
{
    global $DB;

	$userdate = theme_mb2nl_get_user_date();
    $sql = 'SELECT count(id) AS num FROM {course} WHERE id > 1';

	if ( $hidden )
	{
		$sql .= ' AND visible = 0';
	}

	if ( $expired )
	{
		$sql .= ' AND visible = 1 AND enddate > 0 AND enddate < ' . $userdate;
	}

    return $DB->count_records_sql($sql);
}




/*
 *
 * Method to get suspended users
 *
 */
function theme_mb2nl_dashboard_chart($options)
{
    $output = '';

	$output .= '<div class="dashboard-chart">';
	$output .= '<div class="dashboard-progress">';
	$output .= '<div class="progress-part part1" style="width:' . round(($options['val1']/$options['mainval']) * 100, 2) . '%;"></div>';
	$output .= '<div class="progress-part part2" style="width:' . round(($options['val2']/$options['mainval']) * 100, 2) . '%;"></div>';
	$output .= '</div>'; // dashboard-progress
	$output .= '<div class="dashboard-progress-legend">';
	$output .= '<div class="part1">' . $options['str1'] . '<span class="chart-value">(' . $options['val1'] . ')</span></div>';
	$output .= '<div class="part2">' . $options['str2'] . '<span class="chart-value">(' . $options['val2'] . ')</span></div>';
	$output .= '</div>'; // dashboard-progress-legend
	$output .= '</div>'; // dashboard-chart

	return $output;
}






/*
 *
 * Method to get users active time
 *
 */
function theme_mb2nl_dashboard_user_active_time()
{
	global $PAGE;

	$activeuserstime = theme_mb2nl_theme_setting( $PAGE, 'activeuserstime' );
	$userdate = theme_mb2nl_get_user_date();
	$month = (60*60*24*30*$activeuserstime);
	$activedate = ($userdate - $month);

	return $activedate;

}



/*
 *
 * Method to get user new time
 *
 */
function theme_mb2nl_dashboard_user_new_time()
{
	global $PAGE;

	$newuserstime = theme_mb2nl_theme_setting( $PAGE, 'newuserstime' );
	$userdate = theme_mb2nl_get_user_date();
	$days = (60*60*24*$newuserstime);
	$newdate = ($userdate - $days);

	return $newdate;

}






/*
 *
 * Method to get onlineusers
 *
 */
function theme_mb2nl_dashboard_onlineusers($time = 10)
{
    global $DB;

    $onlinestart = strtotime('-' . $time . ' minutes');
    $timefinish = time();

	$sql = 'SELECT COUNT(id) FROM {user} WHERE lastaccess BETWEEN';
	$sql .= ' ' . $onlinestart;
	$sql .= ' AND ' .  $timefinish;

	return $DB->count_records_sql($sql);

}





/*
 *
 * Method to get course users
 *
 */
function theme_mb2nl_dashboard_students($teacher = false, $active = false)
{
	global $DB;

	$userdate = theme_mb2nl_get_user_date();
	$sqlwhere = ' WHERE 1=1';
	$userrole = $teacher ? theme_mb2nl_get_user_role_id(true) : theme_mb2nl_get_user_role_id();

	$sql = 'SELECT count(DISTINCT u.id) AS num FROM {user} u JOIN {role_assignments} ra ON ra.userid = u.id JOIN {context} cx ON cx.id = ra.contextid JOIN {course} c ON c.id = cx.instanceid';

	$sqlwhere .= ' AND u.deleted = 0 AND u.suspended = 0 AND ra.roleid = ' . $userrole;
	$sqlwhere .= ' AND cx.contextlevel = ' . CONTEXT_COURSE;

	if ( $active )
	{
		$sqlwhere .=  " AND visible = 1 AND ( enddate = 0 || enddate > $userdate )";
		$sqlwhere .= ' AND u.lastaccess >=' . theme_mb2nl_dashboard_user_active_time();
	}

	return $DB->count_records_sql($sql . $sqlwhere);

}




/*
 *
 * Method to get new users
 *
 */
function theme_mb2nl_dashboard_categories($hidden = false, $noempty = false)
{
    global $DB;

	$sqlwhere = ' WHERE 1=1';
    $sql = 'SELECT count(DISTINCT ca.id) AS num FROM {course_categories} ca';

	if ( $noempty )
	{
		$sql .= ' JOIN {course} c ON c.category = ca.id';
	}

	if ( $hidden )
	{
		$sqlwhere .= ' AND ca.visible = 0';
	}

    return $DB->count_records_sql($sql . $sqlwhere);
}






/*
 *
 * Method to get course users
 *
 */
function theme_mb2nl_dashboard_modules($active = false, $module = '')
{
	global $DB;

	$userdate = theme_mb2nl_get_user_date();
	$modid = theme_mb2nl_get_moduleid( $module );
	$sqlwhere = ' WHERE 1=1';

	$sql = 'SELECT count(DISTINCT cm.id) AS num FROM {course_modules} cm JOIN {course} c ON c.id = cm.course JOIN {modules} m ON m.id = cm.module';

	if ( $active )
	{
		$sqlwhere .= ' AND cm.visible = 1';
		$sqlwhere .=  " AND c.visible = 1 AND ( c.enddate = 0 || c.enddate > $userdate )";
	}

	if ( $modid )
	{
		$sqlwhere .= ' AND m.id = ' . $modid;
	}

	return $DB->count_records_sql($sql . $sqlwhere);

}



/*
 *
 * Method to get course users
 *
 */
function theme_mb2nl_dashboard_modules_count()
{


	$modules = array();
	$sqlmodules = theme_mb2nl_dashboard_get_modules();

	foreach ( $sqlmodules as $mod )
	{
		if ( $mod->name === 'label' || $mod->name === 'url' || $mod->name === 'resource' )
		{
			continue;
		}

		$modules[$mod->name] =  theme_mb2nl_dashboard_modules(true, $mod->name);
	}

	arsort($modules);

	return $modules;

}




/*
 *
 * Method to get course users
 *
 */
function theme_mb2nl_dashboard_get_modules()
{

	global $DB;

	$sql = 'SELECT id, name FROM {modules} WHERE visible = 1';

	return $DB->get_records_sql($sql);

}
