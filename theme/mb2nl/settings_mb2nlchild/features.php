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


$temp = new admin_settingpage('theme_mb2nlchild_settingsfeatures',  get_string('settingsfeatures', 'theme_mb2nl'));
$yesNoOptions = array('1'=>get_string('yes','theme_mb2nl'), '0'=>get_string('no','theme_mb2nl'));


$bgPositionOpt = array(
	'center center'=>'center center',
	'left top'=>'left top',
	'left center'=>'left center',
	'left bottom'=>'left bottom',
	'right top'=>'right top',
	'right center'=>'right center',
	'right bottom'=>'right bottom',
	'center top'=>'center top',
	'center bottom'=>'center bottom'
);


$bgRepearOpt = array(
	'no-repeat'=>'no-repeat',
	'repeat'=>'repeat',
	'repeat-x'=>'repeat-x',
	'repeat-y'=>'repeat-y'
);


$bgSizeOpt = array(
	'cover'=>'cover',
	'auto'=>'auto',
	'contain'=>'contain'
);


$bgAttOpt = array(
	'scroll'=>'scroll',
	'fixed'=>'fixed',
	'local'=>'local'
);


$bgPredefinedOpt = array(
	''=>get_string('none','theme_mb2nl'),
	'strip1'=>get_string('strip1','theme_mb2nl'),
	'strip2'=>get_string('strip2','theme_mb2nl')
);


$langPosOpt = array(
	0 => get_string('none','theme_mb2nl'),
	1 => get_string('lang1','theme_mb2nl'),
	2 => get_string('lang2','theme_mb2nl')
);

// Leave this array for old child themes
$coursepanelposOpt = array();

$setting = new admin_setting_configmb2start('theme_mb2nlchild/startaccessibility', get_string('accessibility','theme_mb2nl'));
$temp->add($setting);

	$name = 'theme_mb2nlchild/acsboptions';
	$title = get_string('acsboptions','theme_mb2nl');
	$setting = new admin_setting_configcheckbox($name,$title,'',0);
	$setting->set_updatedcallback('theme_reset_all_caches');
	$temp->add($setting);	

$setting = new admin_setting_configmb2end('theme_mb2nlchild/endaccessibility');
$temp->add($setting);

$setting = new admin_setting_configmb2start('theme_mb2nlchild/startblog', get_string('blogsettings','theme_mb2nl'));
$temp->add($setting);

		

	$name = 'theme_mb2nlchild/blogplaceholder';
	$title = get_string('blogplaceholder','theme_mb2nl');
	$setting = new admin_setting_configstoredfile($name, $title, '', 'blogplaceholder');
	$temp->add($setting);	
	

	$temp->add(new admin_setting_configmb2spacer('theme_mb2nlchild/blogspacer1'));
	$temp->add(new admin_setting_configmb2heading('theme_mb2nlchild/blogheading1', get_string('blogpage','theme_mb2nl') ));	

	$name = 'theme_mb2nlchild/bloglayout';
	$title = get_string('layout','theme_mb2nl');
	$setting = new admin_setting_configselect($name, $title, '', 'col3', array(
			'list'=> get_string('layoutlist', 'theme_mb2nl'),
			'col2'=> get_string('xcolumns', 'theme_mb2nl', 2),
			'col3'=> get_string('xcolumns', 'theme_mb2nl', 3)
		) 
	);
	$temp->add($setting);

	$name = 'theme_mb2nlchild/blogsidebar';
	$title = get_string('sidebar','theme_mb2nl');
	$setting = new admin_setting_configcheckbox($name,$title,'',0);
	$temp->add($setting);

	$name = 'theme_mb2nlchild/blogdateformat';
	$title = get_string('dateformat','theme_mb2nl');
	$setting = new admin_setting_configtext($name, $title, '', 'M d, Y');
	$temp->add($setting);

	$name = 'theme_mb2nlchild/blogpageintro';
	$title = get_string('blogintro','theme_mb2nl');
	$setting = new admin_setting_configcheckbox($name,$title,'',1);
	$temp->add($setting);

	$name = 'theme_mb2nlchild/blogmore';
	$title = get_string('blogmore','theme_mb2nl');
	$setting = new admin_setting_configcheckbox($name, $title, '', 1);
	$temp->add($setting);	


	$temp->add(new admin_setting_configmb2spacer('theme_mb2nlchild/blogspacer2'));
	$temp->add(new admin_setting_configmb2heading('theme_mb2nlchild/blogheading2', get_string('blogsinglepage','theme_mb2nl') ));
	
	$name = 'theme_mb2nlchild/blogsinglesidebar';
	$title = get_string('sidebar','theme_mb2nl');
	$setting = new admin_setting_configcheckbox($name,$title,'',0);
	$temp->add($setting);

	$name = 'theme_mb2nlchild/blogsingledateformat';
	$title = get_string('dateformat','theme_mb2nl');
	$setting = new admin_setting_configtext($name, $title, '', 'M d, Y, H:i A');
	$temp->add($setting);
	
	$name = 'theme_mb2nlchild/blogfeaturedmedia';
	$title = get_string('blogfeaturedmedia','theme_mb2nl');
	$setting = new admin_setting_configcheckbox($name,$title,'',1);
	$temp->add($setting);
	
	$name = 'theme_mb2nlchild/blogsingleintro';
	$title = get_string('blogintro','theme_mb2nl');
	$setting = new admin_setting_configcheckbox($name,$title,'',1);
	$temp->add($setting);

	$name = 'theme_mb2nlchild/blogmodify';
	$title = get_string('blogmodify','theme_mb2nl');
	$setting = new admin_setting_configcheckbox($name,$title,'',0);
	$temp->add($setting);

	$name = 'theme_mb2nlchild/blogshareicons';
	$title = get_string('shareicons','theme_mb2nl');
	$setting = new admin_setting_configcheckbox($name, $title, '', 1);
	$temp->add($setting);


$setting = new admin_setting_configmb2end('theme_mb2nlchild/endblog');
$temp->add($setting);


$setting = new admin_setting_configmb2start('theme_mb2nlchild/startbookmarks', get_string('bookmarks','theme_mb2nl'));
//$setting->set_updatedcallback('theme_reset_all_caches');
$temp->add($setting);

	$name = 'theme_mb2nlchild/bookmarks';
	$title = get_string('bookmarks','theme_mb2nl');
	$setting = new admin_setting_configcheckbox($name,$title,'',0);
	//$setting->set_updatedcallback('theme_reset_all_caches');
	$temp->add($setting);

	$name = 'theme_mb2nlchild/bookmarkslimit';
	$title = get_string('bookmarkslimit','theme_mb2nl');
	$setting = new admin_setting_configtext($name, $title, '', 15);
	//$setting->set_updatedcallback('theme_reset_all_caches');
	$temp->add($setting);

$setting = new admin_setting_configmb2end('theme_mb2nlchild/endbookmarks');
//$setting->set_updatedcallback('theme_reset_all_caches');
$temp->add($setting);

$setting = new admin_setting_configmb2start('theme_mb2nlchild/startcoursepanel', get_string('coursepanel','theme_mb2nl'));
//$setting->set_updatedcallback('theme_reset_all_caches');
$temp->add($setting);


	$name = 'theme_mb2nlchild/coursepanel';
	$title = get_string('coursepanel','theme_mb2nl');
	$setting = new admin_setting_configcheckbox($name,$title,'', 1);
	$temp->add($setting);

	$name = 'theme_mb2nlchild/coursepanelspacer1';
	$setting = new admin_setting_configmb2spacer($name);
	$temp->add($setting);

	$name = 'theme_mb2nlchild/teacheremail';
	$title = get_string('teacheremail','theme_mb2nl');
	$setting = new admin_setting_configcheckbox($name,$title,'',1);
	$temp->add($setting);

	$name = 'theme_mb2nlchild/teachermessage';
	$title = get_string('teachermessage','theme_mb2nl');
	$setting = new admin_setting_configcheckbox($name,$title,'',0);
	$temp->add($setting);

	$name = 'theme_mb2nlchild/cpaneldesclimit';
	$title = get_string('cpaneldesclimit','theme_mb2nl');
	$setting = new admin_setting_configtext($name,$title,'',24);
	$temp->add($setting);

	$name = 'theme_mb2nlchild/coursepanelspacer2';
	$setting = new admin_setting_configmb2spacer($name);
	$temp->add($setting);

	$name = 'theme_mb2nlchild/certificatestr';
	$title = get_string('certificatestr','theme_mb2nl');
	$setting = new admin_setting_configcheckbox($name,$title,'',0);
	$temp->add($setting);

	$name = 'theme_mb2nlchild/certificatelinks';
	$title = get_string('certificatelinks','theme_mb2nl');
	$setting = new admin_setting_configtextarea($name, $title, get_string('certificatelinksdesc','theme_mb2nl'), '');
	$temp->add($setting);

$setting = new admin_setting_configmb2end('theme_mb2nlchild/endcoursepanel');
$temp->add($setting);


$setting = new admin_setting_configmb2start('theme_mb2nlchild/startevents', get_string('events', 'calendar'));
$temp->add($setting);


	$name = 'theme_mb2nlchild/eventsplaceholder';
	$title = get_string('eventsplaceholder','theme_mb2nl');
	$setting = new admin_setting_configstoredfile($name, $title, '', 'eventsplaceholder');
	$temp->add($setting);


$setting = new admin_setting_configmb2end('theme_mb2nlchild/endevent');
$temp->add($setting);




// $setting = new admin_setting_configmb2start('theme_mb2nlchild/startdashboard', get_string('myhome'));
// $temp->add($setting);

// 	$name = 'theme_mb2nlchild/dashboard';
// 	$title = get_string('myhome');
// 	$setting = new admin_setting_configcheckbox($name, $title, '', 1);
// 	$temp->add($setting);

// 	$name = 'theme_mb2nlchild/activeuserstime';
// 	$title = get_string('activeuserstime','theme_mb2nl');
// 	$setting = new admin_setting_configtext($name, $title, '', 6);
// 	$temp->add($setting);

// 	$name = 'theme_mb2nlchild/newuserstime';
// 	$title = get_string('newuserstime','theme_mb2nl');
// 	$setting = new admin_setting_configtext($name, $title, '', 30);
// 	$temp->add($setting);

// $setting = new admin_setting_configmb2end('theme_mb2nlchild/enddashboard');
// $temp->add($setting);


$setting = new admin_setting_configmb2start('theme_mb2nlchild/startlang', get_string('language','theme_mb2nl'));
$temp->add($setting);


	$name = 'theme_mb2nlchild/langpos';
	$title = get_string('langpos','theme_mb2nl');
	$setting = new admin_setting_configselect($name, $title, '', 2, $langPosOpt);
	$temp->add($setting);


$setting = new admin_setting_configmb2end('theme_mb2nlchild/endlang');
$temp->add($setting);


$setting = new admin_setting_configmb2start('theme_mb2nlchild/startlogin', get_string('cloginpage','theme_mb2nl'));
$temp->add($setting);


	//$setting = new admin_setting_configmb2start('theme_mb2nlchild/startlogingeneral', get_string('general','theme_mb2nl'));
	//$temp->add($setting);


		$name = 'theme_mb2nlchild/cloginpage';
		$title = get_string('cloginpage','theme_mb2nl');
		$setting = new admin_setting_configcheckbox($name, $title, '', 0);
		$temp->add($setting);


		// $name = 'theme_mb2nlchild/loginlogo';
		// $title = get_string('logoimg','theme_mb2nl');
		// $desc = get_string('loginlogodesc','theme_mb2nl');
		// $setting = new admin_setting_configstoredfile($name, $title, $desc, 'loginlogo');
		// $temp->add($setting);


		// $name = 'theme_mb2nlchild/loginlogow';
		// $title = get_string('logow','theme_mb2nl');
		// $desc = get_string('logowdesc', 'theme_mb2nl');
		// $setting = new admin_setting_configtext($name, $title, $desc, '');
		// $temp->add($setting);


	//$setting = new admin_setting_configmb2end('theme_mb2nlchild/endlogingeneral');
	//$temp->add($setting);


	//$setting = new admin_setting_configmb2start('theme_mb2nlchild/startloginstyle', get_string('style','theme_mb2nl'));
	//$temp->add($setting);

		$name = 'theme_mb2nlchild/loginbgcolor';
		$title = get_string('bgcolor','theme_mb2nl');
		$setting = new admin_setting_configmb2color($name, $title, get_string('pbgdesc','theme_mb2nl'), '');
		$setting->set_updatedcallback('theme_reset_all_caches');
		$temp->add($setting);


		$name = 'theme_mb2nlchild/loginbgpre';
		$title = get_string('pbgpre','theme_mb2nl');
		$setting = new admin_setting_configselect($name, $title, '', '', $bgPredefinedOpt);
		$setting->set_updatedcallback('theme_reset_all_caches');
		$temp->add($setting);


		$name = 'theme_mb2nlchild/loginbgimage';
		$title = get_string('bgimage','theme_mb2nl');
		$setting = new admin_setting_configstoredfile($name, $title, get_string('pbgdesc','theme_mb2nl'), 'loginbgimage');
		$setting->set_updatedcallback('theme_reset_all_caches');
		$temp->add($setting);


		// $name = 'theme_mb2nlchild/loginbgrepeat';
		// $title = get_string('bgrepeat','theme_mb2nl');
		// $setting = new admin_setting_configselect($name, $title, '', 'no-repeat', $bgRepearOpt);
		// $setting->set_updatedcallback('theme_reset_all_caches');
		// $temp->add($setting);


		// $name = 'theme_mb2nlchild/loginbgpos';
		// $title = get_string('bgpos','theme_mb2nl');
		// $setting = new admin_setting_configselect($name, $title, '', 'center center', $bgPositionOpt);
		// $setting->set_updatedcallback('theme_reset_all_caches');
		// $temp->add($setting);


		// $name = 'theme_mb2nlchild/loginbgattach';
		// $title = get_string('bgattachment','theme_mb2nl');
		// $setting = new admin_setting_configselect($name, $title, '', 'fixed', $bgAttOpt);
		// $setting->set_updatedcallback('theme_reset_all_caches');
		// $temp->add($setting);


		// $name = 'theme_mb2nlchild/loginbgsize';
		// $title = get_string('bgsize','theme_mb2nl');
		// $setting = new admin_setting_configselect($name, $title, '', 'cover', $bgSizeOpt);
		// $setting->set_updatedcallback('theme_reset_all_caches');
		// $temp->add($setting);

	//$setting = new admin_setting_configmb2end('theme_mb2nlchild/endloginstyle');
	//$setting->set_updatedcallback('theme_reset_all_caches');
	//$temp->add($setting);


$setting = new admin_setting_configmb2end('theme_mb2nlchild/endlogin');
$setting->set_updatedcallback('theme_reset_all_caches');
$temp->add($setting);


$setting = new admin_setting_configmb2start('theme_mb2nlchild/startloading', get_string('loadingscreen','theme_mb2nl'));
$setting->set_updatedcallback('theme_reset_all_caches');
$temp->add($setting);


	$name = 'theme_mb2nlchild/loadingscr';
	$title = get_string('loadingscreen','theme_mb2nl');
	$setting = new admin_setting_configcheckbox($name, $title, get_string('loadingscrdesc', 'theme_mb2nl'), 0);
	//$setting->set_updatedcallback('theme_reset_all_caches');
	$temp->add($setting);


	$name = 'theme_mb2nlchild/loadinghide';
	$title = get_string('loadinghide','theme_mb2nl');
	$setting = new admin_setting_configtext($name, $title, '', 1000);
	//$setting->set_updatedcallback('theme_reset_all_caches');
	$temp->add($setting);


	$name = 'theme_mb2nlchild/spinnerw';
	$title = get_string('spinnerw','theme_mb2nl');
	$setting = new admin_setting_configtext($name, $title, '', 50);
	//$setting->set_updatedcallback('theme_reset_all_caches');
	$temp->add($setting);


	$name = 'theme_mb2nlchild/lbgcolor';
	$title = get_string('bgcolor','theme_mb2nl');
	$setting = new admin_setting_configmb2color($name, $title, '', '');
	$setting->set_updatedcallback('theme_reset_all_caches');
	$temp->add($setting);


	$name = 'theme_mb2nlchild/loadinglogo';
	$title = get_string('logoimg','theme_mb2nl');
	$setting = new admin_setting_configstoredfile($name, $title, get_string('loadinglogodesc','theme_mb2nl'), 'loadinglogo');
	//$setting->set_updatedcallback('theme_reset_all_caches');
	$temp->add($setting);


	// $name = 'theme_mb2nlchild/loadinglogow';
	// $title = get_string('logow','theme_mb2nl');
	// $setting = new admin_setting_configtext($name, $title, '', 50);
	// //$setting->set_updatedcallback('theme_reset_all_caches');
	// $temp->add($setting);


$setting = new admin_setting_configmb2end('theme_mb2nlchild/endloading');
$setting->set_updatedcallback('theme_reset_all_caches');
$temp->add($setting);


$setting = new admin_setting_configmb2start('theme_mb2nlchild/startloginform', get_string('loginsearchform','theme_mb2nl'));
$temp->add($setting);

	$name = 'theme_mb2nlchild/modaltools';
	$title = get_string('modaltools','theme_mb2nl');
	$setting = new admin_setting_configcheckbox($name, $title, '', 1);
	$temp->add($setting);

	$name = 'theme_mb2nlchild/loginlinktopage';
	$title = get_string('loginlinktopage','theme_mb2nl');
	$setting = new admin_setting_configcheckbox($name, $title, '', 0);
	$temp->add($setting);

	$layoutArr = array(
		'1' => get_string('loginpage','theme_mb2nl'),
		'2' => get_string('forgotpage','theme_mb2nl')
	);
	// $name = 'theme_mb2nlchild/loginlink';
	// $title = get_string('loginlink','theme_mb2nl');
	// $setting = new admin_setting_configselect($name, $title, '', 'fw', $layoutArr);
	// $temp->add($setting);

	// $name = 'theme_mb2nlchild/logintext';
	// $title = get_string('logintext','theme_mb2nl');
	// $setting = new admin_setting_configtextarea($name, $title, '', '');
	// $temp->add($setting);

	$name = 'theme_mb2nlchild/autologinguestsanypage';
	$title = get_string('autologinguestsanypage','theme_mb2nl');
	$setting = new admin_setting_configcheckbox($name, $title, '', 1);
	$temp->add($setting);

	$name = 'theme_mb2nlchild/loginsearchspacer1';
	$setting = new admin_setting_configmb2spacer($name);
	$temp->add($setting);

	$name = 'theme_mb2nlchild/signuplink';
	$title = get_string('signuplink','theme_mb2nl');
	$setting = new admin_setting_configcheckbox($name, $title, '', 0);
	$temp->add($setting);

	$name = 'theme_mb2nlchild/signuppage';
	$title = get_string('signuppage','theme_mb2nl');
	$setting = new admin_setting_configtext($name, $title, '', '');
	$temp->add($setting);

	$name = 'theme_mb2nlchild/loginsearchspacer2';
	$setting = new admin_setting_configmb2spacer($name);
	$temp->add($setting);

	$name = 'theme_mb2nlchild/searchlinks';
	$title = get_string('searchlinks','theme_mb2nl');
	$setting = new admin_setting_configtextarea($name, $title, get_string('searchlinksdesc','theme_mb2nl'), '');
	$temp->add($setting);



$setting = new admin_setting_configmb2end('theme_mb2nlchild/endloginform');
$setting->set_updatedcallback('theme_reset_all_caches');
$temp->add($setting);


// $setting = new admin_setting_configmb2start('theme_mb2nlchild/startpages', get_string('pagecls','theme_mb2nl'));
// $setting->set_updatedcallback('theme_reset_all_caches');
// $temp->add($setting);
//
//
// 	$name = 'theme_mb2nlchild/pagecls';
// 	$title = get_string('pagecls','theme_mb2nl');
// 	$desc = get_string('pageclsdesc','theme_mb2nl');
// 	$setting = new admin_setting_configtextarea($name, $title, $desc, '');
// 	$setting->set_updatedcallback('theme_reset_all_caches');
// 	$temp->add($setting);
//
//
// 	$name = 'theme_mb2nlchild/coursecls';
// 	$title = get_string('coursecls','theme_mb2nl');
// 	$desc = get_string('courseclsdesc','theme_mb2nl');
// 	$setting = new admin_setting_configtextarea($name, $title, $desc, '');
// 	$setting->set_updatedcallback('theme_reset_all_caches');
// 	$temp->add($setting);
//
//
// $setting = new admin_setting_configmb2end('theme_mb2nlchild/endpages');
// $setting->set_updatedcallback('theme_reset_all_caches');
// $temp->add($setting);


$setting = new admin_setting_configmb2start('theme_mb2nlchild/startscrolltt', get_string('scrolltt','theme_mb2nl'));
$temp->add($setting);


	$name = 'theme_mb2nlchild/scrolltt';
	$title = get_string('scrolltt','theme_mb2nl');
	$setting = new admin_setting_configcheckbox($name, $title,'', 0);
	$temp->add($setting);


	$name = 'theme_mb2nlchild/scrollspeed';
	$title = get_string('scrollspeed','theme_mb2nl');
	$setting = new admin_setting_configtext($name, $title, '', 400);
	$temp->add($setting);


$setting = new admin_setting_configmb2end('theme_mb2nlchild/endscrolltt');
$temp->add($setting);



$setting = new admin_setting_configmb2start('theme_mb2nlchild/startsitemenu', get_string('quicklinks','theme_mb2nl'));
$temp->add($setting);

	// $name = 'theme_mb2nlchild/quicklinks';
	// $title = get_string('quicklinks','theme_mb2nl');
	// $setting = new admin_setting_configcheckbox( $name, $title, '', 1);
	// $temp->add($setting);

	$name = 'theme_mb2nlchild/excludedlinks';
	$title = get_string('excludedlinks','theme_mb2nl');
	$setting = new admin_setting_configtextarea($name, $title,get_string('excludedlinksdesc','theme_mb2nl'), 'badges,addcourse,addcategory,editcategory');
	$temp->add($setting);

	$name = 'theme_mb2nlchild/customsitemnuitems';
	$title = get_string('customquicklinkitems','theme_mb2nl');
	$setting = new admin_setting_configtextarea($name, $title, get_string('customquicklinkitemsdesc','theme_mb2nl'), '');
	$temp->add($setting);

$setting = new admin_setting_configmb2end('theme_mb2nlchild/endsitemenu');
$temp->add($setting);



$setting = new admin_setting_configmb2start('theme_mb2nlchild/startganalitycs', get_string('ganatitle','theme_mb2nl'));
$setting->set_updatedcallback('theme_reset_all_caches');
$temp->add($setting);


	$name = 'theme_mb2nlchild/ganaid';
	$title = get_string('ganaid','theme_mb2nl');
	$setting = new admin_setting_configtext($name, $title,$title = get_string('ganaiddesc','theme_mb2nl'), '');
	$setting->set_updatedcallback('theme_reset_all_caches');
	$temp->add($setting);


	$name = 'theme_mb2nlchild/ganaasync';
	$title = get_string('ganaasync','theme_mb2nl');
	$setting = new admin_setting_configcheckbox($name, $title,'', 0);
	$setting->set_updatedcallback('theme_reset_all_caches');
	$temp->add($setting);


$setting = new admin_setting_configmb2end('theme_mb2nlchild/endganalitycs');
$setting->set_updatedcallback('theme_reset_all_caches');
$temp->add($setting);


$ADMIN->add('theme_mb2nlchild', $temp);
