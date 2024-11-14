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
 * Method to set body class
 *
 */
function theme_mb2nl_body_cls()
{
	global $CFG, $PAGE, $USER, $COURSE;
	$output = array();

	user_preference_allow_ajax_update('theme-usersidebar', PARAM_TEXT);
	$sidebardefault = theme_mb2nl_theme_setting($PAGE,'sidebarbtn') == 2 ? 'false' : 'true';
	$usersidebar = get_user_preferences('theme-usersidebar', $sidebardefault);

	// Page layout
	$output[] = 'theme-l' . theme_mb2nl_theme_setting($PAGE, 'layout');

	// Header style
	//$output[] = 'header-' . theme_mb2nl_theme_setting($PAGE, 'headerstyle', 'light');

	if ( ! $PAGE->user_is_editing() )
	{
		$output[] = 'noediting';
	}

	$output[] = theme_mb2nl_full_screen_module() ? 'fsmod1' : 'fsmod0';

	// Add front page builder class
	if ( theme_mb2nl_has_builderpage() )
	{
		$output[] = 'builderpage';
		$output[] = 'builderheading' . theme_mb2nl_builderpage_heading();
	}
	else
	{
		$output[] = 'nobuilderpage';
	}

	if ( theme_mb2nl_theme_setting($PAGE, 'pbgimagescroll' ) )
	{
		$output[] = 'bgscroll';
	}

	// Icon nav menu class
	if ( theme_mb2nl_theme_setting( $PAGE, 'navicons') )
	{
		$output[] = 'isiconmenu';
	}

	// Custom login page
	if ( theme_mb2nl_is_login(true) )
	{
		$output[] = 'custom-login';
	}
	elseif ( theme_mb2nl_is_login(false) )
	{
		$output[] = 'default-login';
	}

	// User logged in or logged out (not guest)
	if ( isloggedin() && ! isguestuser() )
	{
		$output[] = 'loggedin';
		$user_roles = theme_mb2nl_get_role();

		if ($user_roles)
		{
			foreach ($user_roles as $role)
			{
				$output[] = $role;
			}
		}
	}

	// Check if is guest user
	if ( isguestuser() )
	{
		$output[] = 'isguestuser';
	}

	if ( ! isloggedin() )
	{
		$output[] = 'not_loggedin';
	}

	if ( theme_mb2nl_is_custom_enrolment_page() )
	{
		$output[] = 'enrollment-page enrollment-layout-' . theme_mb2nl_enrol_layout();
	}

	$output[] = theme_mb2nl_is_course_list() ? 'coursegrid1' : 'coursegrid0';

	
	// Custom course class
	if (theme_mb2nl_course_cls($PAGE))
	{
		$output[] = theme_mb2nl_course_cls($PAGE);
	}

	$output[] = 'sticky-nav' . theme_mb2nl_is_stycky();

	// Course category theme
	if (theme_mb2nl_courselist_cls($PAGE))
	{
		$output[] = theme_mb2nl_courselist_cls($PAGE);
	}

	// Theme hidden region mode
	if ( isloggedin() && ! is_siteadmin() )
	{
		$output[] = 'theme-hidden-region-mode';
	}

	// Site administrator
	if ( is_siteadmin() )
	{
		$output[] = 'isadmin';
	}

	// Page predefined background
	if (!theme_mb2nl_is_login(true) && theme_mb2nl_theme_setting($PAGE, 'pbgpre') !='')
	{
		$output[] = 'pre-bg' . theme_mb2nl_theme_setting($PAGE, 'pbgpre');
	}

	// Login page predefined background
	if (theme_mb2nl_is_login(true) && theme_mb2nl_theme_setting($PAGE, 'loginbgpre') !='')
	{
		$output[] = 'pre-bg' . theme_mb2nl_theme_setting($PAGE, 'loginbgpre');
	}

	if ( $usersidebar === 'false' )
	{
		$output[] = 'hide-sidebars';
	}

	if (theme_mb2nl_is_frontpage_empty())
	{
		$output[] = 'fpempty';
	}

	if (theme_mb2nl_is_sidebars() > 0)
	{
		$output[] = 'sidebar-case';

		if (theme_mb2nl_is_sidebars() == 1)
		{
			$output[] = 'sidebar-one';
		}
		elseif (theme_mb2nl_is_sidebars() == 2)
		{
			$output[] = 'sidebar-two';
		}
	}
	else
	{
		$output[] = 'nosidebar-case';
	}

	foreach ( theme_mb2nl_midentify() as $class )
	{
		$output[] = $class;
	}

	if (theme_mb2nl_theme_setting($PAGE,'editingfw2'))
	{
		$output[] = 'editing-fw';
	}

	if ( isset( $USER->gradeediting[$COURSE->id] ) && $PAGE->pagetype === 'grade-report-grader-index' && $USER->gradeediting[$COURSE->id] )
	{
		$output[] = 'grading';
	}

	if ( theme_mb2nl_toc_class() )
	{
		$output[] = 'toc1';
	}

	// Block styles
	$output[] = 'blockstyle-' . theme_mb2nl_theme_setting($PAGE, 'blockstyle2');

	// Header style
	$output[] = theme_mb2nl_header_style_cls();

	// Navigation alignment
	$output[] = 'navalign' . theme_mb2nl_theme_setting($PAGE,'navalign');

	// Blog single post
	if ( theme_mb2nl_is_blogsingle() )
	{	
		$blogsinglesidebar = theme_mb2nl_theme_setting($PAGE, 'blogsinglesidebar') ? 1 : 0;
		$output[] = 'blog_single';
		$output[] = 'blog_single_sidebar' . $blogsinglesidebar;
	}

	// Blog page
	if ( theme_mb2nl_is_blog() )
	{
		$output[] = 'blog_index';
	}

	if ( theme_mb2nl_course_layout() )
	{
		$output[] = 'clayout_custom';
		$output[] = 'clayout_' . theme_mb2nl_course_layout();
	}

	return $output;


}




/*
 *
 * Method to check if front page is empty
 *
 */
function theme_mb2nl_is_frontpage_empty()
{

	global $CFG, $PAGE;

	if ($PAGE->user_is_editing())
	{
		return false;
	}

	if ( ! theme_mb2nl_check_builder() != 1 )
	{
		return false;
	}

	if (theme_mb2nl_isblock($PAGE, 'content-top')
	|| theme_mb2nl_isblock($PAGE, 'content-bottom')
	|| theme_mb2nl_isblock($PAGE, 'side-pre')
	|| theme_mb2nl_isblock($PAGE, 'side-post'))
	{
		return false;
	}

	if ( ( isloggedin() && ! isguestuser() ) )
	{
		if (($CFG->frontpageloggedin === 'none' || $CFG->frontpageloggedin === ''))
		{
			return true;
		}
	}
	else
	{
		if (($CFG->frontpage === 'none' || $CFG->frontpage === ''))
		{
			return true;
		}
	}

	return false;

}



/*
 *
 * Method to check if is login page
 *
 */
function theme_mb2nl_is_login( $custom = false )
{

	global $PAGE;

	$loginpath = $PAGE->pagetype === 'login-index';

	if ( $custom && theme_mb2nl_theme_setting($PAGE, 'cloginpage') && $PAGE->pagetype === 'login-index' )
	{
		return true;
	}
	elseif ( ! $custom && $PAGE->pagetype === 'login-index' )
	{
		return true;
	}

	return false;

}




/*
 *
 * Method to get reference to $CFG->themedir variable
 *
 */
function theme_mb2nl_themedir()
{
	global $CFG;

	$teme_dir = '/theme';

	if ( isset( $CFG->themedir ) )
	{
		$teme_dir = $CFG->themedir;
		$teme_dir = str_replace($CFG->dirroot, '', $CFG->themedir);
	}

	return $teme_dir;
}







/*
 *
 * Method to get theme name
 *
 */
function theme_mb2nl_themename ()
{
	global $CFG,$PAGE,$COURSE;

	$name = $CFG->theme;

	if (isset($PAGE->theme->name) && $PAGE->theme->name)
	{
		$name = $PAGE->theme->name;
	}
	elseif (isset($COURSE->theme) && $COURSE->theme)
	{
		$name = $COURSE->theme;
	}

	return $name;

}







/*
 *
 * Method to get social icons list
 *
 *
 */
function theme_mb2nl_social_icons($page, $attribs = array())
{
	global $PAGE;

	$x = 0;
	$output = '';
	$linkTarget = theme_mb2nl_theme_setting($PAGE, 'sociallinknw') == 1 ? ' target="_balnk"' : '';

	// Define margin
	$marginStyle = '';

	if ($attribs['pos'] === 'header')
	{
		$marginStyle = ' style="margin-top:' . theme_mb2nl_theme_setting( $PAGE, 'socialmargin' ) . 'px;"';
	}

	$output .= '<ul class="social-list"' . $marginStyle . '>';

	for ($i=1; $i<=10; $i++)
	{
		$socialName = explode(',', theme_mb2nl_theme_setting($PAGE, 'socialname' . $i));
		$socialLink = theme_mb2nl_theme_setting($PAGE, 'sociallink' . $i);

		if (isset($socialName[0]) && $socialName[0] !== '')
		{
			$x++;
			$isTt = (isset($attribs['tt']) && $attribs['tt']!=='') ? ' data-toggle="tooltip" data-placement="' . $attribs['tt'] . '"' : '';

			$output .= '<li class="li-' . $socialName[0] . '"><a class="social-link" href="' . $socialLink . '" title="' . $socialName[1] . '"' . $linkTarget . $isTt . '><i class="fa fa-brands fa-' . $socialName[0] . '"></i></a></li>';
		}
	}

	if ( ! $x )
	{
		$output .= '<li>No icons. To add social icons go to: <strong>Theme settings &rarr; Social</strong>.</li>';
	}

	$output .= '</ul>';

	return $output;


}



/*
 *
 * Method to get files array from directory
 *
 *
 */
function theme_mb2nl_file_arr($dir, $filter = array('jpg','jpeg','png','gif'))
{


	$output = '';
	$filesArray = array();

	if (!is_dir($dir))
	{

		$output = get_string('foldernoexists','theme_mb2nl');

	}
	else
	{


		$dirContents = scandir($dir);


		foreach ($dirContents as $file)
		{

			$file_type = pathinfo($file, PATHINFO_EXTENSION);

			if (in_array($file_type, $filter))
			{
				$filesArray[] = basename($file, '.' . $file_type);
			}

		}

		$output = $filesArray;

	}


	return $output;


}








/*
 *
 * Method to get random image from array
 *
 *
 */
function theme_mb2nl_random_image($dir, $pixDirName, $attribs = array('jpg','jpeg','png','gif'))
{

	global $OUTPUT, $CFG;

	$moodle33 = 2017051500;
	$output = '';

	$imgtype = theme_mb2nl_imgtype();
	$arr = theme_mb2nl_file_arr($dir, $attribs);

	if (is_array($arr) && !empty($arr))
	{
		$randomImg = array_rand($arr,1);
		$output = $CFG->version >= $moodle33 ? $OUTPUT->image_url($pixDirName . '/' . $arr[$randomImg],'theme') : $OUTPUT->pix_url($pixDirName . '/' . $arr[$randomImg],'theme');
	}

	return $output;

}





/*
 *
 * Method to set body class
 *
 *
 */
function theme_mb2nl_settings_arr()
{

	global $CFG;
	$themename = theme_mb2nl_themename();

	$output = array(
		'all' => array('name'=> get_string('allsettings','theme_mb2nl'), 'icon'=>'fa fa-cogs', 'url'=> new moodle_url( $CFG->wwwroot . '/admin/category.php', array('category' => 'theme_' . $themename ) ) ),
		'general' => array('name'=>get_string('settingsgeneral','theme_mb2nl'), 'icon'=>'fa fa-dashboard', 'url'=>''),
		'courses' => array('name'=>get_string('settingscourses','theme_mb2nl'), 'icon'=>'fa fa-dashboard', 'url'=>''),
		'features' => array('name'=>get_string('settingsfeatures','theme_mb2nl'), 'icon'=>'fa fa-dashboard', 'url'=>''),
		'fonts' => array('name'=>get_string('settingsfonts','theme_mb2nl'), 'icon'=>'fa fa-font', 'url'=>''),
		'nav' => array('name'=>get_string('settingsnav','theme_mb2nl'), 'icon'=>'fa fa-navicon', 'url'=>''),
		'social' => array('name'=>get_string('settingssocial','theme_mb2nl'), 'icon'=>'fa fa-share-alt', 'url'=>''),
		'style' => array('name'=>get_string('settingsstyle','theme_mb2nl'), 'icon'=>'fa fa-paint-brush', 'url'=>''),
		'typography' => array('name'=>get_string('settingstypography','theme_mb2nl'), 'icon'=>'fa fa-text-height', 'url'=>''),
		'sep' => array(),
	);


	return $output;

}







/*
 *
 * Method to get image url
 *
 *
 */
function theme_mb2nl_pluginfile($course, $cm, $context, $filearea, $args, $forcedownload, array $options = array())
{


	if ($context->contextlevel == CONTEXT_SYSTEM)
	{

	    $theme = theme_config::load('mb2nl');

		switch ($filearea)
		{

			case 'logo' :
			return $theme->setting_file_serve('logo', $args, $forcedownload, $options);
			break;

			// case 'logosm' :
			// return $theme->setting_file_serve('logosm', $args, $forcedownload, $options);
			// break;

			case 'logodark' :
			return $theme->setting_file_serve('logodark', $args, $forcedownload, $options);
			break;

			// case 'logodarksm' :
			// return $theme->setting_file_serve('logodarksm', $args, $forcedownload, $options);
			// break;

			case 'headerimg' :
			return $theme->setting_file_serve('headerimg', $args, $forcedownload, $options);
			break;

			case 'partnerlogos' :
			return $theme->setting_file_serve('partnerlogos', $args, $forcedownload, $options);
			break;

			case 'pbgimage' :
			return $theme->setting_file_serve('pbgimage', $args, $forcedownload, $options);
			break;

			case 'bcbgimage' :
			return $theme->setting_file_serve('bcbgimage', $args, $forcedownload, $options);
			break;

			case 'acbgimage' :
			return $theme->setting_file_serve('acbgimage', $args, $forcedownload, $options);
			break;

			case 'asbgimage' :
			return $theme->setting_file_serve('asbgimage', $args, $forcedownload, $options);
			break;

			case 'loginbgimage' :
			return $theme->setting_file_serve('loginbgimage', $args, $forcedownload, $options);
			break;

			case 'loadinglogo' :
			return $theme->setting_file_serve('loadinglogo', $args, $forcedownload, $options);
			break;

			case 'favicon' :
			return $theme->setting_file_serve('favicon', $args, $forcedownload, $options);
			break;

			case 'cfontfiles1' :
			return $theme->setting_file_serve('cfontfiles1', $args, $forcedownload, $options);
			break;

			case 'cfontfiles2' :
			return $theme->setting_file_serve('cfontfiles2', $args, $forcedownload, $options);
			break;

			case 'cfontfiles3' :
			return $theme->setting_file_serve('cfontfiles3', $args, $forcedownload, $options);
			break;

			case 'courseplaceholder' :
			return $theme->setting_file_serve('courseplaceholder', $args, $forcedownload, $options);
			break;

			case 'blogplaceholder' :
			return $theme->setting_file_serve('blogplaceholder', $args, $forcedownload, $options);
			break;

			case 'eventsplaceholder' :
			return $theme->setting_file_serve('eventsplaceholder', $args, $forcedownload, $options);
			break;

			default :
			send_file_not_found();

		}

	}
	else
	{
        send_file_not_found();
    }

}







/*
 *
 * Method to set page class
 *
 *
 */
// function theme_mb2nl_page_cls($page, $course = false)
// {
//
// 	$output = '';
//
// 	$isPage = $page->pagetype === 'mod-page-view';
//
// 	if ( $course )
// 	{
// 		$pageId = $isPage ? $page->course->id : 0;
// 		$output .= theme_mb2nl_line_classes(theme_mb2nl_theme_setting($page, 'coursecls'), $pageId);
// 	}
// 	elseif ( isset( $page->cm->id ) )
// 	{
// 		$pageId = $isPage ? $page->cm->id : 0;
// 		$output .= theme_mb2nl_line_classes(theme_mb2nl_theme_setting($page, 'pagecls'), $pageId);
// 	}
//
//
// 	return $output;
//
// }







/*
 *
 * Method to set block class
 *
 *
 */
function theme_mb2nl_course_cls ($page)
{

	$output = '';


	$output .= theme_mb2nl_line_classes(theme_mb2nl_theme_setting($page, 'coursescls'), $page->course->id);


	return $output;

}





/*
 *
 * Method to set body class for course category theme
 *
 */
function theme_mb2nl_courselist_cls($page)
{

	$output = '';

	$isCourse = $page->pagetype === 'course-index';
	$isCourseCat = $page->pagetype === 'course-index-category';
	$catId = ($isCourseCat && isset($page->category->id)) ? $page->category->id : 0;
	$clsPreff = 'coursetheme-';

	if ($catId > 0)
	{
		$output .= $clsPreff . theme_mb2nl_line_classes(theme_mb2nl_theme_setting($page, 'coursecattheme'), $catId);
	}
	else
	{
		$output .= $clsPreff . theme_mb2nl_theme_setting($page, 'coursetheme');
	}

	return $output;

}







/*
 *
 * Method to get array of css classess
 *
 *
 */
function theme_mb2nl_line_classes ($string, $id, $pref = '', $suff = '')
{



	$output = '';


	$blockStylesArr =  preg_split('/\r\n|\n|\r/', $string);



	if ($string !='')
	{

		foreach ($blockStylesArr as $line)
		{

			$lineArr = explode(':', $line);
			$prefArr = explode(',', $pref);

			if (trim($id) == trim($lineArr[0]))
			{
				$isPref1 = isset($prefArr[0]) ? $prefArr[0] : '';
				$output .= $prefArr[0] . $lineArr[1] . $suff;
			}

			if (isset($lineArr[2]))
			{
				if (trim($id) == trim($lineArr[0]))
				{
					$isPref2 = isset($prefArr[1]) ? $prefArr[1] : '';
					$output .= $isPref2 . $lineArr[2] . $suff;
				}
			}

		}

	}


	return $output;

}











/*
 *
 * Method to to get theme setting
 *
 *
 */
function theme_mb2nl_theme_setting ($page, $name, $default = '', $image = false, $theme = false)
{
	//global $PAGE;

	// if ( is_null( $PAGE->context->id ) )
	// {
	// 	require_login();
	// 	$context = context_system::instance();
	// 	$PAGE->set_context( $context );
	// }

	if ( $theme )
	{
		if ( ! empty( $theme->settings->$name ) )
		{
			if ($image)
			{
				$output = $theme->setting_file_url( $name, $name );
			}
			else
			{
				$output = $theme->settings->$name;
			}
		}
		else
		{
			$output = $default;
		}
	}
	else
	{
		if ( ! empty( $page->theme->settings->$name ) )
		{
			if ( $image )
			{
				$output = $page->theme->setting_file_url( $name, $name );
			}
			else
			{
				$output = $page->theme->settings->$name;
			}
		}
		else
		{
			$output = $default;
		}
	}



	return $output;

}







/*
 *
 * Method to theme links
 *
 *
 */
function theme_mb2nl_theme_links( $modal = false )
{
	global $CFG, $USER, $PAGE;

	$output = '';
	$settings = theme_mb2nl_settings_arr();
	$themename = theme_mb2nl_themename();
	$purgelink = new moodle_url($CFG->wwwroot . '/admin/purgecaches.php', array('confirm'=>1, 'sesskey'=>$USER->sesskey, 'returnurl'=>$PAGE->url->out_as_local_url()));

	if ( is_siteadmin() )
	{
		$output .= '<div class="theme-links">';

		$output .= $modal ? '<h4>' . get_string( 'themesettings', 'admin' ) . '</h4>' : '';

		$output .= '<ul>';

		foreach ($settings as $id => $v)
		{
			if ( $id === 'sep' )
			{
				$output .= '<li class="sep">&nbsp;</li>';
				continue;
			}

			$url = $v['url'] ? $v['url'] :
			new moodle_url( '/admin/settings.php', array( 'section' => 'theme_' . $themename . '_settings' . $id ) );

			$output .= '<li>';
			$output .= '<a href="' . $url . '">';
			$output .= '<i class="' . $v['icon'] . '"></i> ';
			$output .= $v['name'];
			$output .= '</a>';
			$output .= '</li>';
		}

		$docUrl = get_string('urldoc','theme_mb2nl');
		$moreUrl = get_string('urlmore','theme_mb2nl');

		$output .= '<li class="siteadmin-link"><a href="' . new moodle_url( '/admin/search.php' ) . '"><i class="fa fa-sitemap"></i> ' . get_string( 'administrationsite' ) . '</a></li>';
		$output .= '<li class="purgecaches-link"><a href="' . $purgelink . '"><i class="fa fa-cog"></i> ' . get_string('purgecaches','admin') . '</a></li>';
		//$output .= '<li class="custom-link"><a href="' . $docUrl . '"  target="_blank" class="link-doc"><i class="fa fa-info-circle"></i> ' . get_string('documentation','theme_mb2nl') . '</a></li>';
		//$output .= '<li class="custom-link"><a href="' . $moreUrl . '" target="_blank" class="link-more"><i class="fa fa-shopping-basket"></i> ' . get_string('morethemes','theme_mb2nl') . '</a></li>';

		$output .= '</ul>';
		$output .= '</div>';
	}


	return $output;

}














/*
 *
 * Method to get safe url string
 *
 *
 */
function theme_mb2nl_string_url_safe($string, $lower = false)
{

	// remove any html tags
	$output = strip_tags( $string );

	// Remove any '-' from the string since they will be used as concatenaters
	$output = str_replace( '-', ' ', $string );

	// Trim white spaces at beginning and end of alias and make lowercase
	// $output = trim( mb_strtolower( $output ) );

	// Remove any duplicate whitespace, and ensure all characters are alphanumeric
	// $output = preg_replace('/(\s|[^A-Za-z0-9\-])+/', '-', $output);
   	// $output = preg_replace( '#[^\w\d_\-\.]#iu', '-', $output );
	$output = preg_replace( '#[^a-z0-9]#iu', '_', $output ); // This is compatible with js TOC script

	if ( $lower )
	{
		$output = strtolower($output);
	}

	// Trim dashes at beginning and end of alias
	$output = trim( $output );

	return $output;

}






/*
 *
 * Method to get safe url string
 *
 *
 */
function theme_mb2nl_empty_text($text)
{

	$string = strip_tags($text);
	$string = preg_replace('/\s+/', '', $string);
	
	return $string;

}








/*
 *
 * Method to get logo url
 *
 */
function theme_mb2nl_logo_url( $custom = false, $logoname = 'logo-default' )
{

	global $PAGE, $OUTPUT, $CFG;
	$moodle33 = 2017051500;
	$logourl = '';
	$iscustom = '';

	$logo = theme_mb2nl_theme_setting($PAGE,'logo','', true);
	$logodark = theme_mb2nl_theme_setting($PAGE,'logodark','', true);
	//$logosmall = theme_mb2nl_theme_setting($PAGE,'logosm','', true);
	//$logodarksm = theme_mb2nl_theme_setting($PAGE,'logodarksm','', true);

	// Url to default logo image
	$logourl = $OUTPUT->image_url( $logoname,'theme');

	if ( $custom )
	{
		$logourl = $custom;
	}
	elseif ( $logo && $logoname === 'logo-default' )
	{
		$logourl = $logo;
	}
	elseif ( $logodark && $logoname === 'logo-dark' )
	{
		$logourl = $logodark;
	}
	// elseif ( $logosmall && $logoname === 'logo-small' )
	// {
	// 	$logourl = $logosmall;
	// }
	// elseif ( $logodarksm && $logoname === 'logo-dark-small' )
	// {
	// 	$logourl = $logodarksm;
	// }

	return $logourl;

}




/*
 *
 * Method to get files from filearea
 *
 */
function theme_mb2nl_filearea( $filearea = '', $image = true )
{

	if ( ! $filearea )
	{
		return;
	}

	$context = context_system::instance();
	$url = '';
	$urls = array();
	$i = 0;
	$fs = get_file_storage();
	$files = $fs->get_area_files($context->id, 'theme_mb2nl', $filearea );

	foreach ($files as $f)
	{
		$checkimage = $image ? $f->is_valid_image() : $f->get_filename() !== '.';

		if ( $checkimage )
		{
			$i++;
			$sep = $i > 1 ? ',' : '';
			$url .= $sep . moodle_url::make_pluginfile_url($f->get_contextid(), $f->get_component(), $f->get_filearea(), $f->get_itemid(), $f->get_filepath(), $f->get_filename());
		}
	 }

	 $urls = explode( ',', $url );
	 $urls = array_filter($urls);

	 return $urls;

}




/*
 *
 * Method to get page background image
 *
 */
function theme_mb2nl_pagebg_image($page)
{

	global $OUTPUT, $CFG;
	$moodle33 = 2017051500;
	$pageBgUrl = '';


	// Url to page background image
	$pageBgDef = $CFG->version >= $moodle33 ? $OUTPUT->image_url('pagebg/default','theme') : $OUTPUT->pix_url('pagebg/default','theme');
	$pageBg = theme_mb2nl_theme_setting($page, 'pbgimage', '', true);
	$pageBgPre = theme_mb2nl_theme_setting($page, 'pbgpre', '');
	$pageBgLogin = theme_mb2nl_theme_setting($page, 'loginbgimage', '', true);


	// Check if is custom login page
	$customLoginPage = theme_mb2nl_is_login(true);


	if ($customLoginPage && $pageBgLogin !='')
	{
		$pageBgUrl = $pageBgLogin;
	}
	elseif ($pageBg !='')
	{
		$pageBgUrl = $pageBg;
	}
	elseif ($pageBgPre === 'default')
	{
		$pageBgUrl = $pageBgDef;
	}


	return $pageBgUrl !='' ? ' style="background-image:url(\'' . $pageBgUrl . '\');"' : '';


}






/*
 *
 * Method to get loading screen
 *
 *
 */
function theme_mb2nl_loading_screen()
{

	global $OUTPUT, $SITE, $PAGE;

	$output = '';

	if ( is_siteadmin() )
	{
		return;
	}

	$isBgColor = theme_mb2nl_theme_setting($PAGE,'lbgcolor','') !='' ? ' style="background-color:' . theme_mb2nl_theme_setting($PAGE,'lbgcolor','') . ';"' : '';
	$loadinglogo = theme_mb2nl_theme_setting( $PAGE,'loadinglogo','', true);

	$output .= '<div class="loading-scr" data-hideafter="' . theme_mb2nl_theme_setting( $PAGE, 'loadinghide' ) . '"' . $isBgColor . '>';
	$output .= '<div class="loading-scr-inner">';
	$output .= '<img class="loading-scr-logo" src="' . theme_mb2nl_logo_url( $loadinglogo, false ) . '" alt="">';
	$output .= '<div class="loading-scr-spinner"><img src="' . theme_mb2nl_loading_spinner() . '" alt="' . get_string('loading','theme_mb2nl') . '" style="width:' . theme_mb2nl_theme_setting( $PAGE, 'spinnerw' ) . 'px;"></div>';
	$output .= '</div>';
	$output .= '</div>';

	return $output;


}





/*
 *
 * Method to get spinner svg image
 *
 *
 */
function theme_mb2nl_loading_spinner ()
{

	global $CFG;
	$output = '';


	$spinnerDir = $CFG->dirroot . theme_mb2nl_themedir() . '/mb2nl/pix/spinners/';
	$spinnerCustomDir = $CFG->dirroot . theme_mb2nl_themedir() . '/mb2nl/pix/spinners/custom';


	$spinner = theme_mb2nl_random_image($spinnerDir, 'spinners', array('gif','svg'));
	$spinnerCustom = theme_mb2nl_random_image($spinnerCustomDir, 'spinners/custom', array('gif','svg'));


	$output = $spinnerCustom ? $spinnerCustom : $spinner;


	return $output;

}






/*
 *
 * Method to get loading screen
 *
 *
 */
function theme_mb2nl_scrolltt($page)
{

	global $OUTPUT, $SITE;

	$output = '';

	$output .= '<button type="button" class="themereset theme-scrolltt">';
	$output .= '<i class="pe-7s-angle-up" data-scrollspeed="' . theme_mb2nl_theme_setting($page, 'scrollspeed',400) . '"></i>';
	$output .= '</button>';

	return $output;


}













/*
 *
 * Method to get Gogole Analytics code
 *
 *
 */
function theme_mb2nl_ganalytics($page, $type = 1)
{

	$output = '';
	$codeId = theme_mb2nl_theme_setting($page, 'ganaid');
	$codeAsync = theme_mb2nl_theme_setting($page, 'ganaasync', 0);


	if ( $codeId )
	{
		//Alternative async tracking snippet
		if($codeAsync == 1)
		{
			$output .= '<script>';
			$output .= 'window.ga=window.ga||function(){(ga.q=ga.q||[]).push(arguments)};ga.l=+new Date;';
			$output .= 'ga(\'create\', \'' . $codeId . '\', \'auto\');';
			$output .= 'ga(\'send\', \'pageview\');';
			$output .= '</script>';
			$output .= '<script async src=\'https://www.google-analytics.com/analytics.js\'></script>';
		}
		else
		{
			$output .= '<script>';
			$output .= '(function(i,s,o,g,r,a,m){i[\'GoogleAnalyticsObject\']=r;i[r]=i[r]||function(){';
			$output .= '(i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),';
			$output .= 'm=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)';
			$output .= '})(window,document,\'script\',\'https://www.google-analytics.com/analytics.js\',\'ga\');';
			$output .= 'ga(\'create\', \'' . $codeId . '\', \'auto\');';
			$output .= 'ga(\'send\', \'pageview\');';
			$output .= '</script>';
			$output .= '';
		}
	}


	return $output;


}






/*
 *
 * Method to get favicon
 *
 *
 */
function theme_mb2nl_favicon()
{
	global $OUTPUT, $PAGE;

	$output = '';

	$favicon = theme_mb2nl_theme_setting($PAGE, 'favicon','', true);
	$favicon = $favicon ? $favicon : $OUTPUT->image_url( 'favicon', 'theme');

	$output .= '<link rel="shortcut icon" type="image/x-icon" href="' . $favicon . '">';

	return $output;

}






/*
 *
 * Method to get image url from course 'overviewfiles' file area
 *
 */
function theme_mb2nl_course_image_url( $courseid, $placeholder = false )
{
	global $CFG, $COURSE, $OUTPUT, $PAGE;

	$url = '';

	if ( ! $courseid )
	{
		return;
	}

	require_once( $CFG->libdir . '/filelib.php' );

	if ( $placeholder )
	{
		$courseplaceholder = theme_mb2nl_theme_setting( $PAGE, 'courseplaceholder', '', true );
		$url = $courseplaceholder ? $courseplaceholder : $OUTPUT->image_url('course-default','theme');
	}

	$context = context_course::instance( $courseid );
	$fs = get_file_storage();
	$files = $fs->get_area_files( $context->id, 'course', 'overviewfiles', 0 );

	foreach ( $files as $f )
	{
		if ( $f->is_valid_image() )
		{
			$url = moodle_url::make_pluginfile_url(
				$f->get_contextid(), $f->get_component(), $f->get_filearea(), null, $f->get_filepath(), $f->get_filename(), false );
		}
	}

	return $url;

}






/*
 *
 * Method to display sho/hide sidebar button
 *
 */
function theme_mb2nl_show_hide_sidebars($page, $vars = array())
{
	global $PAGE;
	$output = '';
	$cls = '';
	$sidebarBtn = theme_mb2nl_theme_setting($PAGE,'sidebarbtn');
	$sidebarbtntext = theme_mb2nl_theme_setting($PAGE,'sidebarbtntext');
	$icon = theme_mb2nl_svg()['align-left'];
	$cls .= ' mode' . $sidebarBtn;
	$cls .= $sidebarbtntext == 1 ? ' textbutton' : ' iconbutton';

	$showSdebar = ($sidebarBtn == 1 || $sidebarBtn == 2);

	if ( ! isset( $vars['sidebar'] ) || ! $vars['sidebar'] || ! $showSdebar )
	{
		return;
	}

	$output .= '<button class="theme-hide-sidebar' . $cls . '" data-showtext="' . get_string('showsidebar','theme_mb2nl') . '" data-hidetext="' .
	get_string('hidesidebar','theme_mb2nl') . '" aria-hidden="true">';

	if ($sidebarbtntext == 1)
	{
		$output .= '<span class="svgicon">' . $icon . '</span>';
		$output .= '<span class="text1">' . get_string('hidesidebar','theme_mb2nl') . '</span>';
		$output .= '<span class="text2">' . get_string('showsidebar','theme_mb2nl') . '</span>';
	}
	else
	{
		$output .= '<span class="svgicon">' . $icon . '</span>';
	}

	$output .= '</button>';

	return $output;

}








/*
 *
 * Method to add body class to idetntify moodle version in js files
 *
 *
 */
function theme_mb2nl_midentify($vars = array())
{

	global $CFG;
	$classess = array();

	// Moodle 3.8+ class
	if ( $CFG->version >= 2019111800 )
	{
		$classess[] = 'css_rbxt';
	}

	// Moodle 4.0+ class
	if ( $CFG->version >= 2022041900 )
	{
		$classess[] = 'css_6wum';
	}

	// Class for all moodle before 4.0
	if ( $CFG->version < 2022041900 )
	{
		$classess[] = 'css_f8a4';
	}

	// Moodle 4.2 + class
	if ( $CFG->version >= 2023042400 )
	{
		$classess[] = 'css_hy9f';
	}

	return $classess;

}



/*
 *
 * Method to get shot text from string
 *
 *
 */
function theme_mb2nl_wordlimit($string, $limit = 999, $end = '...')
{

	if ( $limit >= 999 )
	{
		return $string;
	}

	if ( $limit == 0 )
	{
		return;
	}

	$content_limit = strip_tags( $string );
	$words = explode( ' ', $content_limit );
	$words_count = count( $words );
	$new_string = implode( ' ', array_splice( $words, 0, $limit ) );
	$end_char = ( $end !== '' && $words_count > $limit ) ? $end : '';
	$output = $new_string . $end_char;

	return $output;

}





/*
 *
 * Method to check moodle version
 *
 *
 */
function theme_mb2nl_moodle_from ($version)
{

	global $CFG;

	if ($CFG->version >= $version)
	{
		return true;
	}

	return false;

}








/*
 *
 * Method to check if plugins are installed
 *
 */
 function theme_mb2nl_check_plugins()
 {

	 $output = '';

	 if ( ! is_siteadmin() )
	 {
		 return;
	 }

	 $warnings = array();

	 if (  ! theme_mb2nl_check_shortcodes_filter( true ) )
	 {
		 $warnings[] = 'mb2shortcodes_filter_plugin_installed';
	 }

	 if (  ! theme_mb2nl_check_shortcodes_filter() )
	 {
		 $warnings[] = 'mb2shortcodes_filter_plugin';
	 }

	 if (  ! theme_mb2nl_check_urltolink_filter() )
	 {
		 $warnings[] = 'urltolink_filter_plugin';
	 }

	 if ( count( $warnings ) )
	 {
		 $output .= '<div class="theme-checkplugins">';
		 $output .= '<h2 class="h6">' . get_string('checkplugins', 'theme_mb2nl') . '</h2>';
		 $output .= '<ol>';

		 foreach( $warnings as $w )
		 {
			 $output .= '<li>';
			 $output .= get_string($w, 'theme_mb2nl');
			 $output .= '';
			 $output .= '</li>';
		 }

		 $output .= '</ol>';
		 $output .= '</div>';
	 }

	 return $output;

 }





/*
 *
 * Method to check if shortcodes filter is activated
 *
 */
function theme_mb2nl_check_shortcodes_filter($installed = false)
{
	global $DB, $CFG;

	if ( $installed )
	{
		if ( is_file( $CFG->dirroot . '/filter/mb2shortcodes/filter.php' ) )
		{
			return true;
		}

		return false;
	}

	$sql = 'SELECT * FROM {filter_active} WHERE ' . $DB->sql_like('filter', '?') . ' AND active=?';
	return $DB->record_exists_sql( $sql, array( 'mb2shortcodes', 1 ) );

}





/*
 *
 * Method to check if urltolink filter is enabled and below shortcodes filter
 *
 */
function theme_mb2nl_check_urltolink_filter()
{
	// global $DB;
	//
	// // Chect if urltolink filter plugin is active
	// $sql = 'SELECT * FROM {filter_active} WHERE ' . $DB->sql_like('filter', '?') . ' AND active = ?';
	//
	// // Make sure that urltolink filter is enabled
	// // If not it's ok, so return true
	// if ( ! $DB->record_exists_sql( $sql, array( 'urltolink', 1 ) ) )
	// {
	// 	return true;
	// }
	//
	// // Urltolink filter is enabled, so we have to check oreding of the filters
	// $mb2shortcodes = $DB->get_record( 'filter_active', array( 'filter' => 'mb2shortcodes' ), 'sortorder', MUST_EXIST );
	// $urltolink = $DB->get_record( 'filter_active', array( 'filter' => 'urltolink' ), 'sortorder', MUST_EXIST );
	//
	// // In this case shortcodes filter is above urltolink filter
	// // This is ok, so we returns true
	// if ( $mb2shortcodes->sortorder < $urltolink->sortorder )
	// {
	// 	return true;
	// }

	return true;

}







/*
 *
 * Method to check if user has role
 *
 */
function theme_mb2nl_is_user_role($courseid, $roleid, $userid = 0)
{

	 $roles = get_user_roles(context_course::instance($courseid), $userid, false);

	 foreach ($roles as $role)
	 {
		  if ($role->roleid == $roleid)
		  {
			  return true;
		  }
	 }

    return false;
}







/*
 *
 * Method to set page title
 *
 */
function theme_mb2nl_page_title( $coursename = true, $onlycourse = false )
{

	global $PAGE, $COURSE;

	$title = '';
	$page_title = strip_tags( format_text( $PAGE->title , FORMAT_HTML) );
	$itle_arr = explode( ':', $page_title );

	// Courses list
	if ( $PAGE->pagetype === 'course-index-category' )
	{
		$urlparams = theme_mb2nl_get_url_params();

		if ( array_key_exists( 'categoryid', $urlparams ) )
		{
			if ( theme_mb2nl_get_category_record( $urlparams['categoryid'] ) )
			{
				return format_text( theme_mb2nl_get_category_record( $urlparams['categoryid'] )->name, FORMAT_HTML );
			}
		}

		return get_string('fulllistofcourses');
	}

	if ( $COURSE->id > 1 && theme_mb2nl_is_cmainpage() )
	{
		return format_text( $COURSE->fullname, FORMAT_HTML );
	}

	// Standard title
	if ( $coursename && $COURSE->id > 1 && ! theme_mb2nl_is_cmainpage() )
	{
		if ( $onlycourse )
		{
			return format_text( $COURSE->fullname, FORMAT_HTML );
		}

		$title .= strip_tags( format_text( $COURSE->fullname, FORMAT_HTML ) ) . ': ';
	}

	// Blog index page
	if ( theme_mb2nl_is_blog() || theme_mb2nl_is_blogsingle() )
	{
		return get_string('siteblogheading', 'blog');
	}

	$title .= end( $itle_arr );

	return $title;

}



/*
 *
 * Method to fix problem in lesson layout in M36
 *
 */
function theme_mb2nl_fix_html_lesson()
{

	global $PAGE, $DB;


	$output = '';

	if ($PAGE->pagetype !== 'mod-lesson-view')
	{
		return;
	}

	$id = required_param('id', PARAM_INT);
	$context = context_module::instance($PAGE->cm->id);
	$cm = get_coursemodule_from_id('lesson', $id, 0, false, MUST_EXIST);
	$pageid = optional_param('pageid', null, PARAM_INT);
	$course = $DB->get_record('course', array('id' => $cm->course), '*', MUST_EXIST);
	$lesson = new lesson($DB->get_record('lesson', array('id' => $cm->instance), '*', MUST_EXIST), $cm, $course);
	$can_edit = has_capability('mod/lesson:manage', $context);

	if (theme_mb2nl_moodle_from(2018120300) && !$can_edit && preg_match('@pageid@',$PAGE->url->get_query_string()) && $lesson->progressbar)
	{
		$output = '</div>';
	}

	return $output;

}






/*
 *
 * Method to check if sidebar exists
 *
 */
function theme_mb2nl_is_sidebars()
{

	global $PAGE;
	$sidePre = theme_mb2nl_isblock($PAGE, 'side-pre');
	$sidePost = theme_mb2nl_isblock($PAGE, 'side-post');

	if ($PAGE->user_is_editing())
	{
		return  2;
	}

	if ($sidePre && $sidePost)
	{
		return 2;
	}
	elseif ($sidePre || $sidePre)
	{
		return 1;
	}

	return 0;

}




/*
 *
 * Method to check for front page courses
 *
 */
function theme_mb2nl_frontpage_courses()
{

	global $CFG;

	$loggedin_arr = explode(',', $CFG->frontpageloggedin);
	$noneloggedin_arr = explode(',', $CFG->frontpage);

	if (isloggedin() && !isguestuser())
	{
		if (in_array(6, $loggedin_arr))
		{
			return true;
		}
	}
	else
	{
		if (in_array(6, $noneloggedin_arr))
		{
			return true;
		}
	}

	return false;

}




/*
 *
 * Method to get content from lines
 *
 */
function theme_mb2nl_line_content($text)
{

	$output = '';
	$line = array();
	$content = array();
	$i = 0;

	// Explode new line
	if ( is_array( $text ) )
	{
		$line_arr = $text;
	}
	else
	{
		$line_arr = preg_split('/\r\n|\n|\r/', trim($text));
	}

	foreach ($line_arr as $line)
	{

		$i++;
		$line_arr = explode('|', trim($line));
		$line1 = $line_arr[0]; // Name and icon
		$line2 = isset($line_arr[1]) ? $line_arr[1] : ''; // Link and target attribute
		$line3 = isset($line_arr[2]) ? $line_arr[2] : ''; // Language codes
		$line4 = isset($line_arr[3]) ? $line_arr[3] : ''; // Logged in or none logged in users
		$line5 = isset($line_arr[4]) ? $line_arr[4] : ''; // Custom class

		// Get sub array from line
		$text_arr = explode('::', trim($line1));
		$url_arr = explode('::', trim($line2));
		$lang_arr = $line3 ? explode(',', trim($line3)) : array();


		$content[$i]['text'] = trim($text_arr[0]);
		$content[$i]['icon'] = isset($text_arr[1]) ? trim($text_arr[1]) : '';
		$content[$i]['url'] = isset($url_arr[0]) ? trim($url_arr[0]) : '';
		$content[$i]['url_target'] = isset($url_arr[1]) ? trim($url_arr[1]) : 0;
		$content[$i]['lang'] = $lang_arr;
		$content[$i]['logged'] = trim($line4);
		$content[$i]['cls'] = trim($line5);

	}

	return $content;

}



/*
 *
 * Method to get content from lines
 *
 */
function theme_mb2nl_paragraph_content($text)
{
	$line_arr = array();

	if ( $text !== '' )
	{
		$line_arr = preg_split('/<\/\s*p\s*>/', trim($text));
		$line_arr = array_map('strip_tags', $line_arr);
	}

	return $line_arr;
}






/*
 *
 * Method to get static content top and bottom
 *
 */
function theme_mb2nl_static_content($text, $list = true, $listitem = true, $options = array())
{

	$output = '';
	$i = 0;
	$content = theme_mb2nl_line_content($text);
	$style = '';
	$listcls = '';
	$linkcls = '';

	if (isset($options['mt']))
	{
		$style = ' style="margin-top:' . trim($options['mt']) . 'px;"';
	}

	if (isset($options['listcls']))
	{
		$listcls = ' ' . $options['listcls'];
	}

	if ( isset( $options['linkcls'] ) )
	{
		$linkcls = ' ' . $options['linkcls'];
	}

	$output .= $list ? '<ul class="theme-static-content' . $listcls . '"' . $style . '>' : '';

	foreach ($content as $item)
	{

		$target = '';
		$icon_pref = '';

		// Check language
		if ( count($item['lang'] ) > 0 && ! in_array( current_language(), $item['lang'] ) )
		{
			continue;
		}

		// Check logged
		if ($item['logged'] == 1 || $item['logged'] == 2)
		{
			// Content for logged in users only
			if ($item['logged'] == 1 && (!isloggedin() || isguestuser()))
			{
				continue;
			}
			// Content for none logged in users and gusets only
			elseif ($item['logged'] == 2 && (isloggedin() && !isguestuser()))
			{
				continue;
			}
		}

		if ( $item['text'] === '' )
		{
			continue;
		}

		$i++;

		if ( isset( $options['limit']) && $options['limit'] < $i )
		{
			continue;
		}

		$output .= $listitem ? '<li class="theme-static-item' . $i . '">' : '';

		if ($item['url'] && $item['url_target'])
		{
			$target = ' target="_blank"';
		}

		if ($item['icon'])
		{
			$icon_pref = theme_mb2nl_font_icon_prefix($item['icon']);
		}

		$islinkcls =  $item['cls'] !== '' ? ' ' . $item['cls'] : $linkcls;

		$output .= $item['url'] ? '<a class="link-replace' . $islinkcls . '" href="' . $item['url'] . '"' . $target . '>' : '<span class="link-replace">';
		$output .= $item['icon'] ? '<span class="static-icon" aria-hidden="true"><i class="' . $icon_pref . $item['icon'] . '"></i></span>' : '';
		$output .= '<span class="text">' . $item['text'] . '</span>';
		$output .= $item['url'] ? '</a>' : '</span>';
		$output .= $listitem ? '</li>' : '';

	}

	$output .= $list ? '</ul>' : '';

	return $output;

}





/*
 *
 * Method to add font icon class prefix
 *
 */
function theme_mb2nl_font_icon_prefix($icon)
{

	$output = '';

	$isfa = (preg_match('@fa-@', $icon) && ! preg_match('@fa fa-@', $icon));
	$isglyph = (preg_match('@glyphicon-@', $icon) && ! preg_match('@glyphicon glyphicon-@', $icon));

	if ($isfa)
	{
	   $output = 'fa ';
	}
	elseif ($isglyph)
	{
	   $output = 'glyphicon ';
	}

    return $output;

}


/*
 *
 * Method to check if string contains tag
 *
 */
function theme_mb2nl_check_for_tags($string, $tags = 'p|span|b|strong|i|u')
{

	$pattern = "/<($tags) ?.*>(.*)<\/($tags)>/";
	preg_match($pattern, $string, $matches);

	if (!empty($matches))
	{
	    return true;
	}

	return false;
}





/*
 *
 * Method to get param value from url
 *
 */
function theme_mb2nl_get_url_param($url, $param = 'id')
{
	$parts = parse_url($url);
	parse_str($parts['query'], $query);

	if (isset($query[$param]))
	{
		return $query[$param];
	}

	return null;

}



/*
 *
 * Method to get user details by user id
 *
 */
function theme_mb2nl_get_user_details($id, $detail = 1, $options = array('size'=>148))
{
	global $OUTPUT, $DB, $USER;

	if (!$id)
	{
		$id = $USER->id;
	}

	$user = $DB->get_record('user', array('id'=>$id));

	if ($detail == 1)
	{
		return $OUTPUT->user_picture($user, $options);
	}
	elseif ($detail == 2)
	{
		return $user->firstname . ' ' . $user->lastname;
	}

}




/*
 *
 * Method to check if is course module context
 *
 */
function theme_mb2nl_is_module_context()
{

	global $PAGE;

	$context = $PAGE->context;

	if ( $context->contextlevel == CONTEXT_MODULE )
	{
		return true;
	}

	return false;

}





/*
 *
 * Method to check if in text is {mlang xx} code
 *
 */
function theme_mb2nl_is_mlang( $text = '' )
{

	if ( $text === '')
	{
		return false;
	}

	if (preg_match('@{mlang@', $text))
	{
		return true;
	}

	return false;

}





/*
 *
 * Method to get user role name
 *
 */
function theme_mb2nl_get_role()
{
	global $DB, $USER;
	$user_roles = array();
	$pref = 'roleshortname-';
	$roles = $DB->get_records('role', array(), '', 'id,shortname');

	if ( ! $roles)
	{
		return ;
	}

	foreach ($roles as $role)
	{
		if ( user_has_role_assignment( $USER->id, $role->id ) )
		{
			$user_roles[] = $pref . $role->shortname;
		}
	}

	if (count($user_roles) == 0)
	{
		return ;
	}

	return $user_roles;

}






/*
 *
 * Method to get user roles
 *
 */
function theme_mb2nl_get_user_roles( $userid = null )
{
	global $DB;
	$roles = array();

	if ( ! $userid )
	{
		return $roles;
	}

	$roles = $DB->get_records_list('role_assignments', 'userid', array('userid' => $userid ), '', 'id,contextid,roleid');

	return $roles;

}





/*
 *
 * Method to get user roles
 *
 */
function theme_mb2nl_get_user_course_roles( $courseid = null, $userid = null )
{
	global $DB;
	$courseroles = array();

	if ( ! $userid || ! $courseid )
	{
		return array();
	}

	$context = context_course::instance( $courseid );
	$userroles = theme_mb2nl_get_user_roles( $userid );

	foreach ( $userroles as $userrole )
	{
		if ( $context->id == $userrole->contextid )
		{
			$courseroles[] = theme_mb2nl_get_role_shortname( $userrole->roleid );
		}
	}

	return $courseroles;

}





/*
 *
 * Method to get user role shortname
 *
 */
function theme_mb2nl_get_role_shortname( $roleid = null )
{

	if ( ! $roleid )
	{
		return ;
	}

	$roles = get_all_roles();

	foreach ( $roles as $role )
	{
		if ( $roleid == $role->id )
		{
			return $role->shortname;
		}
	}

}


/*
 *
 * Method to check which version of page builder user using
 *
 */
function theme_mb2nl_check_builder()
{
	global $CFG;

	// In this case user doesn't install page builder
	if ( ! is_dir( $CFG->dirroot . '/local/mb2builder' ) )
	{
		return false;
	}

	// In this case user use old version of page builder
	if ( ! is_file( $CFG->dirroot . '/local/mb2builder/customize.php' ) )
	{
		return 1;
	}

	return 2;

}





/*
 *
 * Method to check which version of page builder user using
 *
 */
function theme_mb2nl_is_review_plugin()
{
	global $CFG;

	// In this case user use old version of page builder
	if ( is_file( $CFG->dirroot . '/local/mb2reviews/index.php' ) )
	{
		$options = get_config('local_mb2reviews');

		if ( ! $options->disablereview )
		{
			return true;
		}
	}

	return false;

}








/*
 *
 * Method to get header actions
 *
 */
function theme_mb2nl_header_actions()
{
	global $PAGE;

	$output = '';

	if ( ! theme_mb2nl_moodle_from( 2020110900 ) )
	{
		return;
	}

	foreach ( $PAGE->get_header_actions() as $a )
	{
		$output .= $a;
	}

	return $output;

}





/*
 *
 * Method to get header actions
 *
 */
function theme_mb2nl_course_fields( $courseid, $divs = true )
{
	$output = '';
	$fields = theme_mb2nl_get_course_fields( $courseid );

	if ( ! count( $fields ) )
	{
		return;
	}

	$output .= $divs ? '<div class="coursecustomfields">' : '';
	$output .= '<ul class="course-custom-fileds">';

	foreach ( $fields as $f )
	{
		// Hide mb2 fileds
		if ( in_array( $f['shortname'], theme_mb2nl_mb2fields() ) )
		{
			continue;
		}

		// It's required for local video
		// Or for course banner image
		$editortext = theme_mb2nl_get_content_field_textarea($f['value'], $courseid, $f['id']);

		if ( strip_tags( $editortext ) === '' )
		{
			continue;
		}

		$output .= '<li class="fieldname-' . $f['shortname'] . '">';
		$output .= '<span class="name">'. format_text( $f['name'], FORMAT_HTML ) . ':</span>';
		$output .= '<span class="value">' . $editortext . '</span>';
		$output .= '</li>';
	}

	$output .= '</ul>';
	$output .= $divs ? '</div>' : '';

	return $output;

}



/*
 *
 * Method to get custom filed link
 *
 */
function theme_mb2nl_course_fields_link( $data )
{

	$output = '';
	$link = $data->get_field()->get_configdata_property('link');

	if ( $link )
	{
		$url = str_replace('$$', urlencode($data->get_value()), $link);
		$linktarget = $data->get_field()->get_configdata_property('linktarget');
		$output .= '<a href="' . $url . '" target="' . $linktarget . '">'. $data->get_value() . '</a>';
	}
	else
	{
		$output .= $data->get_value();
	}

	return $output;

}







/*
 *
 * Method to get course custom fields array
 *
 */
function theme_mb2nl_get_course_fields( $courseid = 0, $all = false )
{
	global $COURSE;

	$fields = array();

	if ( ! theme_mb2nl_moodle_from( 2019052000 ) )
	{
		return array();
	}

	$iscourseid = $courseid ? $courseid : $COURSE->id;
	$handler = \core_customfield\handler::get_handler('core_course', 'course');
	$datas = $handler->get_instance_data( $iscourseid, $all);

	foreach ( $datas as $data )
	{
		$fields[] = array(
			'id' => $data->get('id'),
			'name' => $data->get_field()->get('name'),
			'shortname' => $data->get_field()->get('shortname'),
			'value' => theme_mb2nl_course_fields_value($data)
		);
	}

	return $fields;

}




/*
 *
 * Method to get course custommfield value
 *
 */
function theme_mb2nl_course_fields_value($data)
{

	switch( $data->get_field()->get('type') )
	{
		case 'checkbox':
		$value = $data->get_value() == 1 ? get_string('yes') : get_string('no');
		break;
		case 'date':
		$value = userdate( $data->get_value(), get_string( 'strftimedatemonthabbr', 'theme_mb2nl' ) );
		break;
		case 'select':
		$value = $data->get_field()->get_options()[$data->get_value()];
		break;
		case 'text':
		$value = theme_mb2nl_course_fields_link($data);
		break;
		default:
		$value = $data->get_value();
	}

	return $value;

}




/*
 *
 * Method to set transparent header background image
 *
 */
function theme_header_bgimage()
{

	global $CFG, $COURSE, $PAGE, $OUTPUT;

	$headerstyle = theme_mb2nl_theme_setting( $PAGE, 'headerstyle' );
	$headerimg = theme_mb2nl_theme_setting( $PAGE, 'headerimg', '', true);
	$bannerUrl = theme_mb2nl_get_enroll_hero_url();
	$cbanner = theme_mb2nl_theme_setting( $PAGE, 'cbanner' );

	if ( $COURSE->id && $bannerUrl && $cbanner )
	{
		return $bannerUrl;
	}

	return $headerimg;

}




/*
 *
 * Method to check if header tools use modal
 *
 */
function theme_mb2nl_is_header_tools_modal()
{
	global $PAGE;

	$headerstyle = theme_mb2nl_headerstyle();
	$modaltools = theme_mb2nl_theme_setting( $PAGE, 'modaltools' );
	$headernav = theme_mb2nl_theme_setting( $PAGE, 'headernav' );
	$stickynav = theme_mb2nl_is_stycky();

	if ( preg_match('@transparent@', $headerstyle) || ( $headernav && $stickynav ) )
	{
		return 1;
	}

	return $modaltools;

}





/*
 *
 * Method to check check header tools position
 *
 */
function theme_mb2nl_header_tools_pos()
{
	global $PAGE;

	// 1 - classic absolute position in header
	// 2 - position in header

	$headernav = theme_mb2nl_theme_setting( $PAGE, 'headernav' );
	$headerstyle = theme_mb2nl_headerstyle();

	if ( ! $headernav )
	{
		return 1;
	}
	elseif ( $headernav || preg_match('@transparent@', $headerstyle) )
	{
		return 2;
	}

	return 1;

}





/*
 *
 * Method to check if there is stycky header or nav
 *
 */
function theme_mb2nl_is_stycky()
{
	global $PAGE;

	// 1 - sticky navigation bar
	// 2 - sticky transparent header
	// 3 - sticky no-transparent header
	// 4 - sticky navigation bar in transparent header

	$stickynav = theme_mb2nl_theme_setting( $PAGE, 'stickynav' );
	$headernav = theme_mb2nl_theme_setting( $PAGE, 'headernav' );
	$theader = preg_match( '@transparent@', theme_mb2nl_headerstyle() );

	if ( ! $stickynav || theme_mb2nl_is_login(true) )
	{
		return 0;
	}

	if ( $theader && $headernav )
	{
		return 2;
	}
	elseif ( ! $theader && $headernav )
	{
		return 3;
	}
	elseif ( ! $theader && ! $headernav )
	{
		return 1;
	}
	elseif ( $theader && ! $headernav )
	{
		return 4;
	}

	return 0;

}





/*
 *
 * Method to check if top bar is visible
 *
 */
function theme_mb2nl_header_content_pos()
{
	global $PAGE;

	// 1 - header content is in the header
	// 2 - header content is in the top bar

	$headernav = theme_mb2nl_theme_setting( $PAGE, 'headernav' );
	$socialheader = theme_mb2nl_theme_setting( $PAGE, 'socialheader' );
	$headercontent = theme_mb2nl_theme_setting( $PAGE, 'headercontent');
	$toolspos = theme_mb2nl_header_tools_pos();

	if ( ! $socialheader && ! $headercontent && $toolspos != 1 )
	{
		return 0;
	}

	if ( $headernav )
	{
		return 2;
	}

	return 1;

}




/*
 *
 * Method to get student role id
 *
 */
function theme_mb2nl_get_user_role_id( $teacher = false )
{

	global $DB, $PAGE;

	$usershortname = $teacher ? theme_mb2nl_theme_setting( $PAGE,'teacherroleshortname' ) : theme_mb2nl_theme_setting( $PAGE, 'studentroleshortname' );
	$query = 'SELECT id FROM {role} WHERE shortname = ?';

	if (  ! $DB->record_exists_sql( $query, array( $usershortname ) ) )
	{
		return 0;
	}

	$roleid = $DB->get_record( 'role', array( 'shortname' => $usershortname ), 'id', MUST_EXIST );

	return $roleid->id;

}





/*
 *
 * Method to get course turn editing button
 *
 */
function theme_mb2nl_turnediting_button()
{
	global $PAGE, $COURSE;

	$output = '';
	$cls = '';
	$isfp = ( $PAGE->pagetype === 'mod-page-view' && $COURSE->id == 1 );
	$iscourse = ( isset( $COURSE->id ) && $COURSE->id > 1 );
	$course_access = theme_mb2nl_site_access();
	$can_manage = array( 'admin', 'manager', 'editingteacher' );
	$cbtntext = theme_mb2nl_theme_setting( $PAGE, 'cbtntext' );
	$ttipattr = ! $cbtntext ? ' data-toggle="tooltip"' : '';

	if ( ! in_array( $course_access,  $can_manage ) )
	{
		return;
	}

	if ( ! $isfp && ! $iscourse )
	{
		return;
	}

	$btnlink = theme_mb2nl_turnediting_button_link();
	$btntext = theme_mb2nl_turnediting_button_atts();
	$btnicon = theme_mb2nl_turnediting_button_atts( true );

	if ( $PAGE->user_is_editing() )
	{
		$cls .= ' isediting';
	}

	$output .= '<a class="manage-link theme-turnediting' . $cls . '" href="' . $btnlink . '" title="' . $btntext . '"' . $ttipattr . '>';
	$output .= $cbtntext ? '<span class="text">' . $btntext . '</span>' : '';
	$output .= '<i class="' . $btnicon . '"></i>';
	$output .= '</a>';

	return $output;

}




/*
 *
 * Method to get params from the url
 *
 */
function theme_mb2nl_get_url_params()
{
	global $PAGE;

	$parts = array();
	$urlparts = parse_url( $PAGE->url );

	if ( isset( $urlparts['query'] ) )
	{
		parse_str( str_replace( '&amp;', '&', $urlparts['query'] ), $parts );
	}

	return $parts;

}






/*
 *
 * Method to check if is iomad
 *
 */
function theme_mb2nl_is_iomad()
{

	if ( ! class_exists( 'iomad' ) )
	{
		return false;
	}

	if ( ! iomad::is_company_user() )
	{
		return false;
	}

	return true;

}





/*
 *
 * Method to check get iomag company
 *
 */
function theme_mb2nl_get_iomad_company()
{

	global $DB;

	if ( ! theme_mb2nl_is_iomad() )
	{
		return;
	}

	$sqlquery = 'SELECT * FROM {company} WHERE id = ?';

	if (  ! $DB->record_exists_sql( $sqlquery, array( iomad::is_company_user() ) ) )
	{
		return;
	}

	return $DB->get_record_sql( $sqlquery, array( iomad::is_company_user() ) );

}




/*
 *
 * Method to auto-login guest on any page
 *
 */
function theme_mb2nl_quest_login()
{
	global $CFG, $PAGE;

	if ( isloggedin() || $CFG->forcelogin || ! $CFG->autologinguests || ! $CFG->guestloginbutton || ! theme_mb2nl_theme_setting( $PAGE, 'autologinguestsanypage' ) )
	{
		return;
	}

	require_login();
}






/*
 *
 * Method to define svg waves
 *
 */
function theme_mb2nl_get_waves()
{

	$waves = array(
		'wave-1' => array(
			'box' => '0 0 1440 320',
			'd' => 'M0,32L48,69.3C96,107,192,181,288,197.3C384,213,480,171,576,138.7C672,107,768,85,864,101.3C960,117,1056,171,1152,197.3C1248,224,1344,224,1392,224L1440,224L1440,320L1392,320C1344,320,1248,320,1152,320C1056,320,960,320,864,320C768,320,672,320,576,320C480,320,384,320,288,320C192,320,96,320,48,320L0,320Z'
		),
		'wave-2' => array(
			'box' => '0 0 1440 700',
			'd' => 'M 0,700 C 0,700 0,350 0,350 C 24.554512217565453,283.46803459487387 49.109024435130905,216.93606918974774 78,254 C 106.8909755648691,291.06393081025226 140.11841447704185,431.72375783588285 165,440 C 189.88158552295815,448.27624216411715 206.41731765670164,324.16889946672075 230,321 C 253.58268234329836,317.83110053327925 284.21231489615167,435.6006442972341 315,473 C 345.78768510384833,510.3993557027659 376.7334227586915,467.4285233443429 400,421 C 423.2665772413085,374.5714766556571 438.8539940690824,324.68526232539426 467,333 C 495.1460059309176,341.31473767460574 535.8506009649792,407.83042735408 568,454 C 600.1493990350208,500.16957264592 623.7436020710007,525.993028258286 644,455 C 664.2563979289993,384.006971741714 681.1749907510175,216.19745961277593 708,226 C 734.8250092489825,235.80254038722407 771.5564349249296,423.21713329061026 802,474 C 832.4435650750704,524.7828667093897 856.5992695492641,438.9340072247831 878,376 C 899.4007304507359,313.0659927752169 918.0464868780136,273.04683781025744 946,255 C 973.9535131219864,236.95316218974256 1011.2147829386818,240.87864153418718 1040,282 C 1068.7852170613182,323.1213584658128 1089.0943813672593,401.43859605299406 1114,397 C 1138.9056186327407,392.56140394700594 1168.407691592281,305.3669742538367 1199,306 C 1229.592308407719,306.6330257461633 1261.2748522636166,395.0935069316593 1284,414 C 1306.7251477363834,432.9064930683407 1320.4928993532524,382.2589980195259 1345,360 C 1369.5071006467476,337.7410019804741 1404.753550323374,343.870500990237 1440,350 C 1440,350 1440,700 1440,700 Z'
		),
		'wave-3' => array(
			'box' => '0 0 1440 320',
			'd' => 'M0,256L37.9,160L75.8,160L113.7,96L151.6,320L189.5,64L227.4,128L265.3,64L303.2,256L341.1,128L378.9,288L416.8,256L454.7,160L492.6,128L530.5,288L568.4,192L606.3,224L644.2,32L682.1,256L720,128L757.9,160L795.8,192L833.7,288L871.6,224L909.5,0L947.4,128L985.3,224L1023.2,64L1061.1,0L1098.9,64L1136.8,192L1174.7,160L1212.6,288L1250.5,224L1288.4,288L1326.3,128L1364.2,288L1402.1,96L1440,160L1440,320L1402.1,320L1364.2,320L1326.3,320L1288.4,320L1250.5,320L1212.6,320L1174.7,320L1136.8,320L1098.9,320L1061.1,320L1023.2,320L985.3,320L947.4,320L909.5,320L871.6,320L833.7,320L795.8,320L757.9,320L720,320L682.1,320L644.2,320L606.3,320L568.4,320L530.5,320L492.6,320L454.7,320L416.8,320L378.9,320L341.1,320L303.2,320L265.3,320L227.4,320L189.5,320L151.6,320L113.7,320L75.8,320L37.9,320L0,320Z'
		),
		'wave-4' => array(
			'box' => '0 0 1230 125',
			'd' => 'M-12.386,-27.038c0,75.231 280.936,136.308 626.969,136.308c346.034,0 626.97,-61.077 626.97,-136.308l-0,152.116l-1253.94,0l0,-152.116Zm0,-0.045l0,0.045l0,-0.045l0,-0Zm1253.94,0.045l-0.001,-0.045l0.001,-0l-0,0.045Z'
		)
	);

	return $waves;

}






/*
 *
 * Method to get footer images
 *
 */
function theme_mb2nl_get_footer_images()
{
	global $CFG, $COURSE;

	require_once($CFG->libdir . '/filelib.php');
	$context = context_system::instance();
	$themename = theme_mb2nl_themename();
	$url = array();
	$fs = get_file_storage();
	$files = $fs->get_area_files( $context->id, 'theme_' . $themename, 'partnerlogos', 0 );

	foreach ( $files as $f )
	{
		if ( $f->is_valid_image() )
		{
			$url[] = moodle_url::make_pluginfile_url(
				$f->get_contextid(), $f->get_component(), $f->get_filearea(), $f->get_itemid(), $f->get_filepath(), $f->get_filename(), false);
		}
	}

	return $url;

}





/*
 *
 * Method to check image
 *
 */
function theme_mb2nl_is_image($url)
{

	if ( ! $url )
	{
		return;
	}

	$path_parts = pathinfo($url);

	// If extension is empty, return image
	// This is required for imported image url in page builder
	if ( ! isset( $path_parts['extension'] ) )
	{
		return true;
	}

	$formats = theme_mb2nl_imgtype();
	$filetype = strtolower($path_parts['extension']);

	if ( in_array( $filetype, $formats ) )
	{
		return true;
	}

	return false;

}



/**
 *
 * Method to get image url and name from text
 *
 */
function theme_mb2nl_image_from_text( $text, $name = false )
{

	$imgtype = theme_mb2nl_imgtype();
	$imgtype = implode('|\.', $imgtype);

	preg_match_all('/(http|https):\/\/[^ ]+(\.' . $imgtype . ')/', $text, $out);

	if ( ! isset( $out[0][0] ) )
	{
		return;
	}

	if ( $name )
	{
		$file_parts = pathinfo($out[0][0]);
		return $file_parts['basename'];
	}
	else
	{
		return $out[0][0];
	}

}


/**
 *
 * Method to get local video url and name from text
 *
 */
function theme_mb2nl_video_from_text( $text, $name = false )
{

	$videotype = theme_mb2nl_videotype();
	$videotype = implode('|\.', $videotype);

	preg_match_all('/(http|https):\/\/[^ ]+(\.' . $videotype . ')/', $text, $out);

	if ( ! isset( $out[0][0] ) )
	{
		return;
	}

	if ( $name )
	{
		$file_parts = pathinfo($out[0][0]);
		return $file_parts['basename'];
	}
	else
	{
		return $out[0][0];
	}

}





/*
 *
 * Method to set header css classess fro body tag
 *
 */
function theme_mb2nl_header_style_cls()
{
	global $PAGE;

	$cls = '';

	$headerstyle = theme_mb2nl_headerstyle();
	$enrolpage = theme_mb2nl_is_custom_enrolment_page();
	$pheader = theme_mb2nl_theme_setting( $PAGE,'headercolorscheme' );

	if ( $enrolpage && theme_mb2nl_mb2fields_filed('mb2scheme') )
	{
		$pheader = theme_mb2nl_mb2fields_filed('mb2scheme');
	}

	if ( $headerstyle === 'transparent_light' )
	{
		$pheader = 'light';
	}
	elseif ( $headerstyle === 'transparent' )
	{
		$pheader = 'dark';
	}

	// Header style class
	$cls .= 'theader_' . $headerstyle;
	$cls .= ' tpheader_' . $pheader;

	// Navigation bar style
	if ( theme_mb2nl_theme_setting( $PAGE, 'headernav') )
	{
		$cls .= ' tnavheader tnavheader_' . $headerstyle;
	}
	else
	{
		$cls .= ' tnavbar tnavbar_' . $headerstyle;
	}

	return $cls;

}




/*
 *
 * Method to get header style
 *
 */
function theme_mb2nl_headerstyle()
{
	global $PAGE;

	$pref = '';
	$builderstyle = theme_mb2nl_builder_header();
	$enrolpage = theme_mb2nl_is_custom_enrolment_page();

	if ( $builderstyle )
	{
		return $builderstyle;
	}
	elseif ( $enrolpage && theme_mb2nl_mb2fields_filed('mb2header') )
	{
		return theme_mb2nl_mb2fields_filed('mb2header');
	}
	else
	{
		return theme_mb2nl_theme_setting( $PAGE, 'headerstyle' );
	}

}



/*
 *
 * Method to check if image is svg
 *
 */
function theme_mb2nl_is_svg($url)
{

	$file_parts = pathinfo($url);

	if ( ! isset( $file_parts['extension'] ) || strtolower( $file_parts['extension'] ) === 'svg' )
	{
		return true;
	}

	return false;

}






/*
 *
 * Method to check if file is img
 *
 */
function theme_mb2nl_is_img($url)
{

	if ( ! $url )
	{
		return false;
	}

	$imgtype = theme_mb2nl_imgtype();
	$file_parts = pathinfo($url);

	if ( isset( $file_parts['extension'] ) && in_array( strtolower( $file_parts['extension'] ), $imgtype ) )
	{
		return true;
	}

	return false;

}




/*
 *
 * Method to check if file is video
 *
 */
function theme_mb2nl_is_video($url)
{

	if ( ! $url )
	{
		return false;
	}

	$videotype = theme_mb2nl_videotype();
	$file_parts = pathinfo($url);

	if ( isset( $file_parts['extension'] ) && in_array( strtolower( $file_parts['extension'] ), $videotype ) )
	{
		return true;
	}

	return false;

}





/*
 *
 * Method to get image type array
 *
 */
function theme_mb2nl_imgtype()
{

	return array(
		'apng',
		'avif',
		'gif',
		'jpg',
		'jpeg',
		'jfif',
		'pjpeg',
		'pjp',
		'png',
		'svg',
		'webp'
	);

}




/*
 *
 * Method to get image video array
 *
 */
function theme_mb2nl_videotype()
{

	return array(
		'webm',
		'mpg',
		'mp2',
		'mpeg',
		'mpe',
		'mpv',
		'ogg',
		'mp4',
		'm4p',
		'm4v',
		'avi',
		'wmv',
		'mov',
		'qt',
		'avchd'
	);

}


/*
 *
 * Method to get image video array
 *
 */
function theme_mb2nl_get_footertools()
{
	global $OUTPUT, $CFG;

	$output = '';
	$tools = $OUTPUT->standard_footer_html();
	$tools2 = '';

	if ( $CFG->version >= 2022041900 )
	{
		$tools2 = $OUTPUT->debug_footer_html();
	}

	$output .= '<div class="footer-tools">';

	if ( $OUTPUT->course_footer() )
	{
		$output .= '<p id="course-footer">' . $OUTPUT->course_footer() . '</p>';
	}

	if ( $OUTPUT->page_doc_link() )
	{
		$output .= '<p class="helplink">' . $OUTPUT->page_doc_link() . '</p>';
	}

	$output .= $tools;

	$output .= $tools2;

	$output .= '</div>';

	return $output;

}


/*
 *
 * Method to get sidebar position
 *
 */
function theme_mb2nl_sidebarpos()
{
	global $PAGE, $SITE, $COURSE;

	if ( $PAGE->pagetype === 'course-index' || $PAGE->pagetype === 'course-index-category' )
	{
		return theme_mb2nl_theme_setting($PAGE, 'sidebarposcindex');
	}
	elseif ( theme_mb2nl_is_cmainpage() )
	{
		return theme_mb2nl_theme_setting($PAGE, 'sidebarposcpage');
	}

	return theme_mb2nl_theme_setting($PAGE, 'sidebarpos');

}





/*
 *
 * Method to redirect to the course page
 *
 */
function theme_mb2nl_fpredirect()
{
	global $CFG, $PAGE;

	$fp2course_setting = theme_mb2nl_theme_setting($PAGE, 'fp2course');
	$fp2course = optional_param( 'fp2course', 0, PARAM_INT );

	if ( ! $fp2course_setting || $fp2course || $PAGE->pagetype !== 'site-index' || $CFG->forcelogin || ( isloggedin() && ! isguestuser() ) )
	{
		return;
	}

	redirect( new moodle_url( '/course', array( 'fp2course' => 1 ) ) );

}




/*
 *
 * Method to set header buttons
 *
 */
function theme_mb2nl_header_buttons( $pos = 2, $mobile = false )
{
	global $PAGE;

	$output = '';
	$cls =  $mobile ? 'mobile-buttons' : 'header-buttons';
	$headerbtn = theme_mb2nl_theme_setting($PAGE, 'headerbtn');

	if ( $headerbtn === '' )
	{
		return;
	}

	$output .= '<div class="' . $cls . ' pos-' . $pos . '">';
	$output .= theme_mb2nl_static_content( $headerbtn, false, false, array( 'linkcls' => 'mb2-pb-btn typeprimary' ) );
	$output .= '</div>';

	return $output;

}




/*
 *
 * Method to set header buttons
 *
 */
function theme_mb2nl_stars( $rating = 5 )
{

	$output = '';

	$output .= '<div class="rating-stars rating-' . $rating . '">';

	$output .= '<div class="stars-empty">';
	$output .= '<i class="glyphicon glyphicon-star-empty"></i>';
	$output .= '<i class="glyphicon glyphicon-star-empty"></i>';
	$output .= '<i class="glyphicon glyphicon-star-empty"></i>';
	$output .= '<i class="glyphicon glyphicon-star-empty"></i>';
	$output .= '<i class="glyphicon glyphicon-star-empty"></i>';
	$output .= '</div>';

	$output .= '<div class="stars-full">';
	$output .= '<i class="glyphicon glyphicon-star"></i>';
	$output .= '<i class="glyphicon glyphicon-star"></i>';
	$output .= '<i class="glyphicon glyphicon-star"></i>';
	$output .= '<i class="glyphicon glyphicon-star"></i>';
	$output .= '<i class="glyphicon glyphicon-star"></i>';
	$output .= '</div>';

	$output .= '</div>';

	return $output;


}


/*
 *
 * Method to set header buttons
 *
 */
function theme_mb2nl_isrtl()
{
	$languages = array(
		'ar',
		'ar_wp',
		'dv',
		'he',
		'he_kids',
		'he_wp',
		'ckb',
		'fa',
		'ur',
		'dv'
	);

	if ( in_array( current_language(), $languages ) )
	{
		return true;
	}

	return false;

}


/*
 *
 * Method to set header buttons
 *
 */
function theme_mb2nl_lazy_plc()
{
	global $OUTPUT;

	return $OUTPUT->image_url('lazy_placeholder','theme');

}


/*
 *
 * Method to set header buttons
 *
 */
function theme_mb2nl_moreless($height = 150)
{
	global $PAGE;

	$output = '';

	if ( ! theme_mb2nl_theme_setting($PAGE, 'showmorebtn') )
	{
		return;
	}

	$output .= '<button class="toggle-content-button themereset"';
	$output .= ' data-height="' . $height . '"';
	$output .= ' data-moretext="' . get_string('showmore', 'form') . '"';
	$output .= ' data-lesstext="' . get_string('showless', 'form') . '">';
	$output .= get_string('showmore', 'form');
	$output .= '</button>';

	return $output;

}




/*
 *
 * Method to set header buttons
 *
 */
function theme_mb2nl_svg()
{

	return array(
		'circle-play' => '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><!--! Font Awesome Free 6.2.1 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license/free (Icons: CC BY 4.0, Fonts: SIL OFL 1.1, Code: MIT License) Copyright 2022 Fonticons, Inc. --><path d="M512 256c0 141.4-114.6 256-256 256S0 397.4 0 256S114.6 0 256 0S512 114.6 512 256zM188.3 147.1c-7.6 4.2-12.3 12.3-12.3 20.9V344c0 8.7 4.7 16.7 12.3 20.9s16.8 4.1 24.3-.5l144-88c7.1-4.4 11.5-12.1 11.5-20.5s-4.4-16.1-11.5-20.5l-144-88c-7.4-4.5-16.7-4.7-24.3-.5z"/></svg>',
		'graduation-cap' => '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 640 512"><!--! Font Awesome Free 6.2.1 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license/free (Icons: CC BY 4.0, Fonts: SIL OFL 1.1, Code: MIT License) Copyright 2022 Fonticons, Inc. --><path d="M320 32c-8.1 0-16.1 1.4-23.7 4.1L15.8 137.4C6.3 140.9 0 149.9 0 160s6.3 19.1 15.8 22.6l57.9 20.9C57.3 229.3 48 259.8 48 291.9v28.1c0 28.4-10.8 57.7-22.3 80.8c-6.5 13-13.9 25.8-22.5 37.6C0 442.7-.9 448.3 .9 453.4s6 8.9 11.2 10.2l64 16c4.2 1.1 8.7 .3 12.4-2s6.3-6.1 7.1-10.4c8.6-42.8 4.3-81.2-2.1-108.7C90.3 344.3 86 329.8 80 316.5V291.9c0-30.2 10.2-58.7 27.9-81.5c12.9-15.5 29.6-28 49.2-35.7l157-61.7c8.2-3.2 17.5 .8 20.7 9s-.8 17.5-9 20.7l-157 61.7c-12.4 4.9-23.3 12.4-32.2 21.6l159.6 57.6c7.6 2.7 15.6 4.1 23.7 4.1s16.1-1.4 23.7-4.1L624.2 182.6c9.5-3.4 15.8-12.5 15.8-22.6s-6.3-19.1-15.8-22.6L343.7 36.1C336.1 33.4 328.1 32 320 32zM128 408c0 35.3 86 72 192 72s192-36.7 192-72L496.7 262.6 354.5 314c-11.1 4-22.8 6-34.5 6s-23.5-2-34.5-6L143.3 262.6 128 408z"/></svg>',
		'comments' => '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 640 512"><!--! Font Awesome Free 6.2.1 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license/free (Icons: CC BY 4.0, Fonts: SIL OFL 1.1, Code: MIT License) Copyright 2022 Fonticons, Inc. --><path d="M208 352c114.9 0 208-78.8 208-176S322.9 0 208 0S0 78.8 0 176c0 38.6 14.7 74.3 39.6 103.4c-3.5 9.4-8.7 17.7-14.2 24.7c-4.8 6.2-9.7 11-13.3 14.3c-1.8 1.6-3.3 2.9-4.3 3.7c-.5 .4-.9 .7-1.1 .8l-.2 .2 0 0 0 0C1 327.2-1.4 334.4 .8 340.9S9.1 352 16 352c21.8 0 43.8-5.6 62.1-12.5c9.2-3.5 17.8-7.4 25.3-11.4C134.1 343.3 169.8 352 208 352zM448 176c0 112.3-99.1 196.9-216.5 207C255.8 457.4 336.4 512 432 512c38.2 0 73.9-8.7 104.7-23.9c7.5 4 16 7.9 25.2 11.4c18.3 6.9 40.3 12.5 62.1 12.5c6.9 0 13.1-4.5 15.2-11.1c2.1-6.6-.2-13.8-5.8-17.9l0 0 0 0-.2-.2c-.2-.2-.6-.4-1.1-.8c-1-.8-2.5-2-4.3-3.7c-3.6-3.3-8.5-8.1-13.3-14.3c-5.5-7-10.7-15.4-14.2-24.7c24.9-29 39.6-64.7 39.6-103.4c0-92.8-84.9-168.9-192.6-175.5c.4 5.1 .6 10.3 .6 15.5z"/></svg>',
		'cubes' => '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 576 512"><!--! Font Awesome Free 6.2.1 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license/free (Icons: CC BY 4.0, Fonts: SIL OFL 1.1, Code: MIT License) Copyright 2022 Fonticons, Inc. --><path d="M290.8 48.6l78.4 29.7L288 109.5 206.8 78.3l78.4-29.7c1.8-.7 3.8-.7 5.7 0zM136 92.5V204.7c-1.3 .4-2.6 .8-3.9 1.3l-96 36.4C14.4 250.6 0 271.5 0 294.7V413.9c0 22.2 13.1 42.3 33.5 51.3l96 42.2c14.4 6.3 30.7 6.3 45.1 0L288 457.5l113.5 49.9c14.4 6.3 30.7 6.3 45.1 0l96-42.2c20.3-8.9 33.5-29.1 33.5-51.3V294.7c0-23.3-14.4-44.1-36.1-52.4l-96-36.4c-1.3-.5-2.6-.9-3.9-1.3V92.5c0-23.3-14.4-44.1-36.1-52.4l-96-36.4c-12.8-4.8-26.9-4.8-39.7 0l-96 36.4C150.4 48.4 136 69.3 136 92.5zM392 210.6l-82.4 31.2V152.6L392 121v89.6zM154.8 250.9l78.4 29.7L152 311.7 70.8 280.6l78.4-29.7c1.8-.7 3.8-.7 5.7 0zm18.8 204.4V354.8L256 323.2v95.9l-82.4 36.2zM421.2 250.9c1.8-.7 3.8-.7 5.7 0l78.4 29.7L424 311.7l-81.2-31.1 78.4-29.7zM523.2 421.2l-77.6 34.1V354.8L528 323.2v90.7c0 3.2-1.9 6-4.8 7.3z"/></svg>',
		'file-pen' => '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 576 512"><!--! Font Awesome Free 6.2.1 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license/free (Icons: CC BY 4.0, Fonts: SIL OFL 1.1, Code: MIT License) Copyright 2022 Fonticons, Inc. --><path d="M0 64C0 28.7 28.7 0 64 0H224V128c0 17.7 14.3 32 32 32H384V285.7l-86.8 86.8c-10.3 10.3-17.5 23.1-21 37.2l-18.7 74.9c-2.3 9.2-1.8 18.8 1.3 27.5H64c-35.3 0-64-28.7-64-64V64zm384 64H256V0L384 128zM549.8 235.7l14.4 14.4c15.6 15.6 15.6 40.9 0 56.6l-29.4 29.4-71-71 29.4-29.4c15.6-15.6 40.9-15.6 56.6 0zM311.9 417L441.1 287.8l71 71L382.9 487.9c-4.1 4.1-9.2 7-14.9 8.4l-60.1 15c-5.5 1.4-11.2-.2-15.2-4.2s-5.6-9.7-4.2-15.2l15-60.1c1.4-5.6 4.3-10.8 8.4-14.9z"/></svg>',
		'file-circle-check' => '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 576 512"><!--! Font Awesome Free 6.2.1 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license/free (Icons: CC BY 4.0, Fonts: SIL OFL 1.1, Code: MIT License) Copyright 2022 Fonticons, Inc. --><path d="M0 64C0 28.7 28.7 0 64 0H224V128c0 17.7 14.3 32 32 32H384v38.6C310.1 219.5 256 287.4 256 368c0 59.1 29.1 111.3 73.7 143.3c-3.2 .5-6.4 .7-9.7 .7H64c-35.3 0-64-28.7-64-64V64zm384 64H256V0L384 128zM576 368c0 79.5-64.5 144-144 144s-144-64.5-144-144s64.5-144 144-144s144 64.5 144 144zm-76.7-43.3c-6.2-6.2-16.4-6.2-22.6 0L416 385.4l-28.7-28.7c-6.2-6.2-16.4-6.2-22.6 0s-6.2 16.4 0 22.6l40 40c6.2 6.2 16.4 6.2 22.6 0l72-72c6.2-6.2 6.2-16.4 0-22.6z"/></svg>',
		'highlighter' => '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 576 512"><!--! Font Awesome Pro 6.2.1 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2022 Fonticons, Inc. --><path d="M331 315l158.4-215L460.1 70.6 245 229 331 315zm-187 5l0 0V248.3c0-15.3 7.2-29.6 19.5-38.6L436.6 8.4C444 2.9 453 0 462.2 0c11.4 0 22.4 4.5 30.5 12.6l54.8 54.8c8.1 8.1 12.6 19 12.6 30.5c0 9.2-2.9 18.2-8.4 25.6L350.4 396.5c-9 12.3-23.4 19.5-38.6 19.5H240l-25.4 25.4c-12.5 12.5-32.8 12.5-45.3 0l-50.7-50.7c-12.5-12.5-12.5-32.8 0-45.3L144 320zM23 466.3l63-63 70.6 70.6-31 31c-4.5 4.5-10.6 7-17 7H40c-13.3 0-24-10.7-24-24v-4.7c0-6.4 2.5-12.5 7-17z"/></svg>',
		'eye-slash' => '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 640 512"><!--! Font Awesome Free 6.2.1 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license/free (Icons: CC BY 4.0, Fonts: SIL OFL 1.1, Code: MIT License) Copyright 2022 Fonticons, Inc. --><path d="M150.7 92.77C195 58.27 251.8 32 320 32C400.8 32 465.5 68.84 512.6 112.6C559.4 156 590.7 207.1 605.5 243.7C608.8 251.6 608.8 260.4 605.5 268.3C592.1 300.6 565.2 346.1 525.6 386.7L630.8 469.1C641.2 477.3 643.1 492.4 634.9 502.8C626.7 513.2 611.6 515.1 601.2 506.9L9.196 42.89C-1.236 34.71-3.065 19.63 5.112 9.196C13.29-1.236 28.37-3.065 38.81 5.112L150.7 92.77zM189.8 123.5L235.8 159.5C258.3 139.9 287.8 128 320 128C390.7 128 448 185.3 448 256C448 277.2 442.9 297.1 433.8 314.7L487.6 356.9C521.1 322.8 545.9 283.1 558.6 256C544.1 225.1 518.4 183.5 479.9 147.7C438.8 109.6 385.2 79.1 320 79.1C269.5 79.1 225.1 97.73 189.8 123.5L189.8 123.5zM394.9 284.2C398.2 275.4 400 265.9 400 255.1C400 211.8 364.2 175.1 320 175.1C319.3 175.1 318.7 176 317.1 176C319.3 181.1 320 186.5 320 191.1C320 202.2 317.6 211.8 313.4 220.3L394.9 284.2zM404.3 414.5L446.2 447.5C409.9 467.1 367.8 480 320 480C239.2 480 174.5 443.2 127.4 399.4C80.62 355.1 49.34 304 34.46 268.3C31.18 260.4 31.18 251.6 34.46 243.7C44 220.8 60.29 191.2 83.09 161.5L120.8 191.2C102.1 214.5 89.76 237.6 81.45 255.1C95.02 286 121.6 328.5 160.1 364.3C201.2 402.4 254.8 432 320 432C350.7 432 378.8 425.4 404.3 414.5H404.3zM192 255.1C192 253.1 192.1 250.3 192.3 247.5L248.4 291.7C258.9 312.8 278.5 328.6 302 333.1L358.2 378.2C346.1 381.1 333.3 384 319.1 384C249.3 384 191.1 326.7 191.1 255.1H192z"/></svg>',
		'ban' => '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><!--! Font Awesome Free 6.2.1 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license/free (Icons: CC BY 4.0, Fonts: SIL OFL 1.1, Code: MIT License) Copyright 2022 Fonticons, Inc. --><path d="M367.2 412.5L99.5 144.8C77.1 176.1 64 214.5 64 256c0 106 86 192 192 192c41.5 0 79.9-13.1 111.2-35.5zm45.3-45.3C434.9 335.9 448 297.5 448 256c0-106-86-192-192-192c-41.5 0-79.9 13.1-111.2 35.5L412.5 367.2zM512 256c0 141.4-114.6 256-256 256S0 397.4 0 256S114.6 0 256 0S512 114.6 512 256z"/></svg>',
		'dots' => '<svg viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path d="M6,8c1.1,0 2,-0.9 2,-2s-0.9,-2 -2,-2 -2,0.9 -2,2 0.9,2 2,2zM12,20c1.1,0 2,-0.9 2,-2s-0.9,-2 -2,-2 -2,0.9 -2,2 0.9,2 2,2zM6,20c1.1,0 2,-0.9 2,-2s-0.9,-2 -2,-2 -2,0.9 -2,2 0.9,2 2,2zM6,14c1.1,0 2,-0.9 2,-2s-0.9,-2 -2,-2 -2,0.9 -2,2 0.9,2 2,2zM12,14c1.1,0 2,-0.9 2,-2s-0.9,-2 -2,-2 -2,0.9 -2,2 0.9,2 2,2zM16,6c0,1.1 0.9,2 2,2s2,-0.9 2,-2 -0.9,-2 -2,-2 -2,0.9 -2,2zM12,8c1.1,0 2,-0.9 2,-2s-0.9,-2 -2,-2 -2,0.9 -2,2 0.9,2 2,2zM18,14c1.1,0 2,-0.9 2,-2s-0.9,-2 -2,-2 -2,0.9 -2,2 0.9,2 2,2zM18,20c1.1,0 2,-0.9 2,-2s-0.9,-2 -2,-2 -2,0.9 -2,2 0.9,2 2,2z"></path></svg>',
		'magnifying-glass' => '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><!--! Font Awesome Free 6.2.1 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license/free (Icons: CC BY 4.0, Fonts: SIL OFL 1.1, Code: MIT License) Copyright 2022 Fonticons, Inc. --><path d="M416 208c0 45.9-14.9 88.3-40 122.7L502.6 457.4c12.5 12.5 12.5 32.8 0 45.3s-32.8 12.5-45.3 0L330.7 376c-34.4 25.2-76.8 40-122.7 40C93.1 416 0 322.9 0 208S93.1 0 208 0S416 93.1 416 208zM208 352c79.5 0 144-64.5 144-144s-64.5-144-144-144S64 128.5 64 208s64.5 144 144 144z"/></svg>',
		'circle-question' => '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><!--! Font Awesome Free 6.2.1 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license/free (Icons: CC BY 4.0, Fonts: SIL OFL 1.1, Code: MIT License) Copyright 2022 Fonticons, Inc. --><path d="M256 0C114.6 0 0 114.6 0 256s114.6 256 256 256s256-114.6 256-256S397.4 0 256 0zM256 464c-114.7 0-208-93.31-208-208S141.3 48 256 48s208 93.31 208 208S370.7 464 256 464zM256 336c-18 0-32 14-32 32s13.1 32 32 32c17.1 0 32-14 32-32S273.1 336 256 336zM289.1 128h-51.1C199 128 168 159 168 198c0 13 11 24 24 24s24-11 24-24C216 186 225.1 176 237.1 176h51.1C301.1 176 312 186 312 198c0 8-4 14.1-11 18.1L244 251C236 256 232 264 232 272V288c0 13 11 24 24 24S280 301 280 288V286l45.1-28c21-13 34-36 34-60C360 159 329 128 289.1 128z"/></svg>',
		'expand' => '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512"><!--! Font Awesome Free 6.2.1 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license/free (Icons: CC BY 4.0, Fonts: SIL OFL 1.1, Code: MIT License) Copyright 2022 Fonticons, Inc. --><path d="M32 32C14.3 32 0 46.3 0 64v96c0 17.7 14.3 32 32 32s32-14.3 32-32V96h64c17.7 0 32-14.3 32-32s-14.3-32-32-32H32zM64 352c0-17.7-14.3-32-32-32s-32 14.3-32 32v96c0 17.7 14.3 32 32 32h96c17.7 0 32-14.3 32-32s-14.3-32-32-32H64V352zM320 32c-17.7 0-32 14.3-32 32s14.3 32 32 32h64v64c0 17.7 14.3 32 32 32s32-14.3 32-32V64c0-17.7-14.3-32-32-32H320zM448 352c0-17.7-14.3-32-32-32s-32 14.3-32 32v64H320c-17.7 0-32 14.3-32 32s14.3 32 32 32h96c17.7 0 32-14.3 32-32V352z"/></svg>',
		'compress' => '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512"><!--! Font Awesome Free 6.2.1 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license/free (Icons: CC BY 4.0, Fonts: SIL OFL 1.1, Code: MIT License) Copyright 2022 Fonticons, Inc. --><path d="M160 64c0-17.7-14.3-32-32-32s-32 14.3-32 32v64H32c-17.7 0-32 14.3-32 32s14.3 32 32 32h96c17.7 0 32-14.3 32-32V64zM32 320c-17.7 0-32 14.3-32 32s14.3 32 32 32H96v64c0 17.7 14.3 32 32 32s32-14.3 32-32V352c0-17.7-14.3-32-32-32H32zM352 64c0-17.7-14.3-32-32-32s-32 14.3-32 32v96c0 17.7 14.3 32 32 32h96c17.7 0 32-14.3 32-32s-14.3-32-32-32H352V64zM320 320c-17.7 0-32 14.3-32 32v96c0 17.7 14.3 32 32 32s32-14.3 32-32V384h64c17.7 0 32-14.3 32-32s-14.3-32-32-32H320z"/></svg>',
		'align-left' => '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512"><!--! Font Awesome Free 6.2.1 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license/free (Icons: CC BY 4.0, Fonts: SIL OFL 1.1, Code: MIT License) Copyright 2022 Fonticons, Inc. --><path d="M288 64c0 17.7-14.3 32-32 32H32C14.3 96 0 81.7 0 64S14.3 32 32 32H256c17.7 0 32 14.3 32 32zm0 256c0 17.7-14.3 32-32 32H32c-17.7 0-32-14.3-32-32s14.3-32 32-32H256c17.7 0 32 14.3 32 32zM0 192c0-17.7 14.3-32 32-32H416c17.7 0 32 14.3 32 32s-14.3 32-32 32H32c-17.7 0-32-14.3-32-32zM448 448c0 17.7-14.3 32-32 32H32c-17.7 0-32-14.3-32-32s14.3-32 32-32H416c17.7 0 32 14.3 32 32z"/></svg>',
		'universal-access' => '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><!--! Font Awesome Free 6.2.1 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license/free (Icons: CC BY 4.0, Fonts: SIL OFL 1.1, Code: MIT License) Copyright 2022 Fonticons, Inc. --><path d="M0 256a256 256 0 1 1 512 0A256 256 0 1 1 0 256zm161.5-86.1c-12.2-5.2-26.3 .4-31.5 12.6s.4 26.3 12.6 31.5l11.9 5.1c17.3 7.4 35.2 12.9 53.6 16.3v50.1c0 4.3-.7 8.6-2.1 12.6l-28.7 86.1c-4.2 12.6 2.6 26.2 15.2 30.4s26.2-2.6 30.4-15.2l24.4-73.2c1.3-3.8 4.8-6.4 8.8-6.4s7.6 2.6 8.8 6.4l24.4 73.2c4.2 12.6 17.8 19.4 30.4 15.2s19.4-17.8 15.2-30.4l-28.7-86.1c-1.4-4.1-2.1-8.3-2.1-12.6V235.5c18.4-3.5 36.3-8.9 53.6-16.3l11.9-5.1c12.2-5.2 17.8-19.3 12.6-31.5s-19.3-17.8-31.5-12.6L338.7 175c-26.1 11.2-54.2 17-82.7 17s-56.5-5.8-82.7-17l-11.9-5.1zM256 160a40 40 0 1 0 0-80 40 40 0 1 0 0 80z"/></svg>',
		'circle-check' => '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><!--! Font Awesome Free 6.2.1 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license/free (Icons: CC BY 4.0, Fonts: SIL OFL 1.1, Code: MIT License) Copyright 2022 Fonticons, Inc. --><path d="M256 512c141.4 0 256-114.6 256-256S397.4 0 256 0S0 114.6 0 256S114.6 512 256 512zM369 209L241 337c-9.4 9.4-24.6 9.4-33.9 0l-64-64c-9.4-9.4-9.4-24.6 0-33.9s24.6-9.4 33.9 0l47 47L335 175c9.4-9.4 24.6-9.4 33.9 0s9.4 24.6 0 33.9z"/></svg>',
		'close' => '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="24" height="24"><path d="M12 10.586l4.95-4.95 1.414 1.414-4.95 4.95 4.95 4.95-1.414 1.414-4.95-4.95-4.95 4.95-1.414-1.414 4.95-4.95-4.95-4.95L7.05 5.636z"/></svg>'
	);

}
