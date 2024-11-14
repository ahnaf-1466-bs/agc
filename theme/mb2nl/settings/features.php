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


$temp = new admin_settingpage('theme_mb2nl_settingsfeatures',  get_string('settingsfeatures', 'theme_mb2nl'));
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

$setting = new admin_setting_configmb2start('theme_mb2nl/startaccessibility', get_string('accessibility','theme_mb2nl'));
$temp->add($setting);

	$name = 'theme_mb2nl/acsboptions';
	$title = get_string('acsboptions','theme_mb2nl');
	$setting = new admin_setting_configcheckbox($name,$title,'',0);
	$setting->set_updatedcallback('theme_reset_all_caches');
	$temp->add($setting);	

$setting = new admin_setting_configmb2end('theme_mb2nl/endaccessibility');
$temp->add($setting);

$setting = new admin_setting_configmb2start('theme_mb2nl/startblog', get_string('blogsettings','theme_mb2nl'));
$temp->add($setting);

		

	$name = 'theme_mb2nl/blogplaceholder';
	$title = get_string('blogplaceholder','theme_mb2nl');
	$setting = new admin_setting_configstoredfile($name, $title, '', 'blogplaceholder');
	$temp->add($setting);	
	

	$temp->add(new admin_setting_configmb2spacer('theme_mb2nl/blogspacer1'));
	$temp->add(new admin_setting_configmb2heading('theme_mb2nl/blogheading1', get_string('blogpage','theme_mb2nl') ));	

	$name = 'theme_mb2nl/bloglayout';
	$title = get_string('layout','theme_mb2nl');
	$setting = new admin_setting_configselect($name, $title, '', 'col3', array(
			'list'=> get_string('layoutlist', 'theme_mb2nl'),
			'col2'=> get_string('xcolumns', 'theme_mb2nl', 2),
			'col3'=> get_string('xcolumns', 'theme_mb2nl', 3)
		) 
	);
	$temp->add($setting);

	$name = 'theme_mb2nl/blogsidebar';
	$title = get_string('sidebar','theme_mb2nl');
	$setting = new admin_setting_configcheckbox($name,$title,'',0);
	$temp->add($setting);

	$name = 'theme_mb2nl/blogdateformat';
	$title = get_string('dateformat','theme_mb2nl');
	$setting = new admin_setting_configtext($name, $title, '', 'M d, Y');
	$temp->add($setting);

	$name = 'theme_mb2nl/blogpageintro';
	$title = get_string('blogintro','theme_mb2nl');
	$setting = new admin_setting_configcheckbox($name,$title,'',1);
	$temp->add($setting);

	$name = 'theme_mb2nl/blogmore';
	$title = get_string('blogmore','theme_mb2nl');
	$setting = new admin_setting_configcheckbox($name, $title, '', 1);
	$temp->add($setting);	


	$temp->add(new admin_setting_configmb2spacer('theme_mb2nl/blogspacer2'));
	$temp->add(new admin_setting_configmb2heading('theme_mb2nl/blogheading2', get_string('blogsinglepage','theme_mb2nl') ));
	
	$name = 'theme_mb2nl/blogsinglesidebar';
	$title = get_string('sidebar','theme_mb2nl');
	$setting = new admin_setting_configcheckbox($name,$title,'',0);
	$temp->add($setting);

	$name = 'theme_mb2nl/blogsingledateformat';
	$title = get_string('dateformat','theme_mb2nl');
	$setting = new admin_setting_configtext($name, $title, '', 'M d, Y, H:i A');
	$temp->add($setting);
	
	$name = 'theme_mb2nl/blogfeaturedmedia';
	$title = get_string('blogfeaturedmedia','theme_mb2nl');
	$setting = new admin_setting_configcheckbox($name,$title,'',1);
	$temp->add($setting);
	
	$name = 'theme_mb2nl/blogsingleintro';
	$title = get_string('blogintro','theme_mb2nl');
	$setting = new admin_setting_configcheckbox($name,$title,'',1);
	$temp->add($setting);

	$name = 'theme_mb2nl/blogmodify';
	$title = get_string('blogmodify','theme_mb2nl');
	$setting = new admin_setting_configcheckbox($name,$title,'',0);
	$temp->add($setting);

	$name = 'theme_mb2nl/blogshareicons';
	$title = get_string('shareicons','theme_mb2nl');
	$setting = new admin_setting_configcheckbox($name, $title, '', 1);
	$temp->add($setting);


$setting = new admin_setting_configmb2end('theme_mb2nl/endblog');
$temp->add($setting);


$setting = new admin_setting_configmb2start('theme_mb2nl/startbookmarks', get_string('bookmarks','theme_mb2nl'));
//$setting->set_updatedcallback('theme_reset_all_caches');
$temp->add($setting);

	$name = 'theme_mb2nl/bookmarks';
	$title = get_string('bookmarks','theme_mb2nl');
	$setting = new admin_setting_configcheckbox($name,$title,'',0);
	//$setting->set_updatedcallback('theme_reset_all_caches');
	$temp->add($setting);

	$name = 'theme_mb2nl/bookmarkslimit';
	$title = get_string('bookmarkslimit','theme_mb2nl');
	$setting = new admin_setting_configtext($name, $title, '', 15);
	//$setting->set_updatedcallback('theme_reset_all_caches');
	$temp->add($setting);

$setting = new admin_setting_configmb2end('theme_mb2nl/endbookmarks');
//$setting->set_updatedcallback('theme_reset_all_caches');
$temp->add($setting);

$setting = new admin_setting_configmb2start('theme_mb2nl/startcoursepanel', get_string('coursepanel','theme_mb2nl'));
//$setting->set_updatedcallback('theme_reset_all_caches');
$temp->add($setting);


	$name = 'theme_mb2nl/coursepanel';
	$title = get_string('coursepanel','theme_mb2nl');
	$setting = new admin_setting_configcheckbox($name,$title,'', 1);
	$temp->add($setting);

	$name = 'theme_mb2nl/coursepanelspacer1';
	$setting = new admin_setting_configmb2spacer($name);
	$temp->add($setting);

	$name = 'theme_mb2nl/teacheremail';
	$title = get_string('teacheremail','theme_mb2nl');
	$setting = new admin_setting_configcheckbox($name,$title,'',1);
	$temp->add($setting);

	$name = 'theme_mb2nl/teachermessage';
	$title = get_string('teachermessage','theme_mb2nl');
	$setting = new admin_setting_configcheckbox($name,$title,'',0);
	$temp->add($setting);

	$name = 'theme_mb2nl/cpaneldesclimit';
	$title = get_string('cpaneldesclimit','theme_mb2nl');
	$setting = new admin_setting_configtext($name,$title,'',24);
	$temp->add($setting);

	$name = 'theme_mb2nl/coursepanelspacer2';
	$setting = new admin_setting_configmb2spacer($name);
	$temp->add($setting);

	$name = 'theme_mb2nl/certificatestr';
	$title = get_string('certificatestr','theme_mb2nl');
	$setting = new admin_setting_configcheckbox($name,$title,'',0);
	$temp->add($setting);

	$name = 'theme_mb2nl/certificatelinks';
	$title = get_string('certificatelinks','theme_mb2nl');
	$setting = new admin_setting_configtextarea($name, $title, get_string('certificatelinksdesc','theme_mb2nl'), '');
	$temp->add($setting);

$setting = new admin_setting_configmb2end('theme_mb2nl/endcoursepanel');
$temp->add($setting);


$setting = new admin_setting_configmb2start('theme_mb2nl/startevents', get_string('events', 'calendar'));
$temp->add($setting);


	$name = 'theme_mb2nl/eventsplaceholder';
	$title = get_string('eventsplaceholder','theme_mb2nl');
	$setting = new admin_setting_configstoredfile($name, $title, '', 'eventsplaceholder');
	$temp->add($setting);


$setting = new admin_setting_configmb2end('theme_mb2nl/endevent');
$temp->add($setting);




// $setting = new admin_setting_configmb2start('theme_mb2nl/startdashboard', get_string('myhome'));
// $temp->add($setting);

// 	$name = 'theme_mb2nl/dashboard';
// 	$title = get_string('myhome');
// 	$setting = new admin_setting_configcheckbox($name, $title, '', 1);
// 	$temp->add($setting);

// 	$name = 'theme_mb2nl/activeuserstime';
// 	$title = get_string('activeuserstime','theme_mb2nl');
// 	$setting = new admin_setting_configtext($name, $title, '', 6);
// 	$temp->add($setting);

// 	$name = 'theme_mb2nl/newuserstime';
// 	$title = get_string('newuserstime','theme_mb2nl');
// 	$setting = new admin_setting_configtext($name, $title, '', 30);
// 	$temp->add($setting);

// $setting = new admin_setting_configmb2end('theme_mb2nl/enddashboard');
// $temp->add($setting);


$setting = new admin_setting_configmb2start('theme_mb2nl/startlang', get_string('language','theme_mb2nl'));
$temp->add($setting);


	$name = 'theme_mb2nl/langpos';
	$title = get_string('langpos','theme_mb2nl');
	$setting = new admin_setting_configselect($name, $title, '', 2, $langPosOpt);
	$temp->add($setting);


$setting = new admin_setting_configmb2end('theme_mb2nl/endlang');
$temp->add($setting);


$setting = new admin_setting_configmb2start('theme_mb2nl/startlogin', get_string('cloginpage','theme_mb2nl'));
$temp->add($setting);


	//$setting = new admin_setting_configmb2start('theme_mb2nl/startlogingeneral', get_string('general','theme_mb2nl'));
	//$temp->add($setting);


		$name = 'theme_mb2nl/cloginpage';
		$title = get_string('cloginpage','theme_mb2nl');
		$setting = new admin_setting_configcheckbox($name, $title, '', 0);
		$temp->add($setting);


		// $name = 'theme_mb2nl/loginlogo';
		// $title = get_string('logoimg','theme_mb2nl');
		// $desc = get_string('loginlogodesc','theme_mb2nl');
		// $setting = new admin_setting_configstoredfile($name, $title, $desc, 'loginlogo');
		// $temp->add($setting);


		// $name = 'theme_mb2nl/loginlogow';
		// $title = get_string('logow','theme_mb2nl');
		// $desc = get_string('logowdesc', 'theme_mb2nl');
		// $setting = new admin_setting_configtext($name, $title, $desc, '');
		// $temp->add($setting);


	//$setting = new admin_setting_configmb2end('theme_mb2nl/endlogingeneral');
	//$temp->add($setting);


	//$setting = new admin_setting_configmb2start('theme_mb2nl/startloginstyle', get_string('style','theme_mb2nl'));
	//$temp->add($setting);

		$name = 'theme_mb2nl/loginbgcolor';
		$title = get_string('bgcolor','theme_mb2nl');
		$setting = new admin_setting_configmb2color($name, $title, get_string('pbgdesc','theme_mb2nl'), '');
		$setting->set_updatedcallback('theme_reset_all_caches');
		$temp->add($setting);


		$name = 'theme_mb2nl/loginbgpre';
		$title = get_string('pbgpre','theme_mb2nl');
		$setting = new admin_setting_configselect($name, $title, '', '', $bgPredefinedOpt);
		$setting->set_updatedcallback('theme_reset_all_caches');
		$temp->add($setting);


		$name = 'theme_mb2nl/loginbgimage';
		$title = get_string('bgimage','theme_mb2nl');
		$setting = new admin_setting_configstoredfile($name, $title, get_string('pbgdesc','theme_mb2nl'), 'loginbgimage');
		$setting->set_updatedcallback('theme_reset_all_caches');
		$temp->add($setting);


		// $name = 'theme_mb2nl/loginbgrepeat';
		// $title = get_string('bgrepeat','theme_mb2nl');
		// $setting = new admin_setting_configselect($name, $title, '', 'no-repeat', $bgRepearOpt);
		// $setting->set_updatedcallback('theme_reset_all_caches');
		// $temp->add($setting);


		// $name = 'theme_mb2nl/loginbgpos';
		// $title = get_string('bgpos','theme_mb2nl');
		// $setting = new admin_setting_configselect($name, $title, '', 'center center', $bgPositionOpt);
		// $setting->set_updatedcallback('theme_reset_all_caches');
		// $temp->add($setting);


		// $name = 'theme_mb2nl/loginbgattach';
		// $title = get_string('bgattachment','theme_mb2nl');
		// $setting = new admin_setting_configselect($name, $title, '', 'fixed', $bgAttOpt);
		// $setting->set_updatedcallback('theme_reset_all_caches');
		// $temp->add($setting);


		// $name = 'theme_mb2nl/loginbgsize';
		// $title = get_string('bgsize','theme_mb2nl');
		// $setting = new admin_setting_configselect($name, $title, '', 'cover', $bgSizeOpt);
		// $setting->set_updatedcallback('theme_reset_all_caches');
		// $temp->add($setting);

	//$setting = new admin_setting_configmb2end('theme_mb2nl/endloginstyle');
	//$setting->set_updatedcallback('theme_reset_all_caches');
	//$temp->add($setting);


$setting = new admin_setting_configmb2end('theme_mb2nl/endlogin');
$setting->set_updatedcallback('theme_reset_all_caches');
$temp->add($setting);


$setting = new admin_setting_configmb2start('theme_mb2nl/startloading', get_string('loadingscreen','theme_mb2nl'));
$setting->set_updatedcallback('theme_reset_all_caches');
$temp->add($setting);


	$name = 'theme_mb2nl/loadingscr';
	$title = get_string('loadingscreen','theme_mb2nl');
	$setting = new admin_setting_configcheckbox($name, $title, get_string('loadingscrdesc', 'theme_mb2nl'), 0);
	//$setting->set_updatedcallback('theme_reset_all_caches');
	$temp->add($setting);


	$name = 'theme_mb2nl/loadinghide';
	$title = get_string('loadinghide','theme_mb2nl');
	$setting = new admin_setting_configtext($name, $title, '', 1000);
	//$setting->set_updatedcallback('theme_reset_all_caches');
	$temp->add($setting);


	$name = 'theme_mb2nl/spinnerw';
	$title = get_string('spinnerw','theme_mb2nl');
	$setting = new admin_setting_configtext($name, $title, '', 50);
	//$setting->set_updatedcallback('theme_reset_all_caches');
	$temp->add($setting);


	$name = 'theme_mb2nl/lbgcolor';
	$title = get_string('bgcolor','theme_mb2nl');
	$setting = new admin_setting_configmb2color($name, $title, '', '');
	$setting->set_updatedcallback('theme_reset_all_caches');
	$temp->add($setting);


	$name = 'theme_mb2nl/loadinglogo';
	$title = get_string('logoimg','theme_mb2nl');
	$setting = new admin_setting_configstoredfile($name, $title, get_string('loadinglogodesc','theme_mb2nl'), 'loadinglogo');
	//$setting->set_updatedcallback('theme_reset_all_caches');
	$temp->add($setting);


	// $name = 'theme_mb2nl/loadinglogow';
	// $title = get_string('logow','theme_mb2nl');
	// $setting = new admin_setting_configtext($name, $title, '', 50);
	// //$setting->set_updatedcallback('theme_reset_all_caches');
	// $temp->add($setting);


$setting = new admin_setting_configmb2end('theme_mb2nl/endloading');
$setting->set_updatedcallback('theme_reset_all_caches');
$temp->add($setting);


$setting = new admin_setting_configmb2start('theme_mb2nl/startloginform', get_string('loginsearchform','theme_mb2nl'));
$temp->add($setting);

	$name = 'theme_mb2nl/modaltools';
	$title = get_string('modaltools','theme_mb2nl');
	$setting = new admin_setting_configcheckbox($name, $title, '', 1);
	$temp->add($setting);

	$name = 'theme_mb2nl/loginlinktopage';
	$title = get_string('loginlinktopage','theme_mb2nl');
	$setting = new admin_setting_configcheckbox($name, $title, '', 0);
	$temp->add($setting);

	$layoutArr = array(
		'1' => get_string('loginpage','theme_mb2nl'),
		'2' => get_string('forgotpage','theme_mb2nl')
	);
	// $name = 'theme_mb2nl/loginlink';
	// $title = get_string('loginlink','theme_mb2nl');
	// $setting = new admin_setting_configselect($name, $title, '', 'fw', $layoutArr);
	// $temp->add($setting);

	// $name = 'theme_mb2nl/logintext';
	// $title = get_string('logintext','theme_mb2nl');
	// $setting = new admin_setting_configtextarea($name, $title, '', '');
	// $temp->add($setting);

	$name = 'theme_mb2nl/autologinguestsanypage';
	$title = get_string('autologinguestsanypage','theme_mb2nl');
	$setting = new admin_setting_configcheckbox($name, $title, '', 1);
	$temp->add($setting);

	$name = 'theme_mb2nl/loginsearchspacer1';
	$setting = new admin_setting_configmb2spacer($name);
	$temp->add($setting);

	$name = 'theme_mb2nl/signuplink';
	$title = get_string('signuplink','theme_mb2nl');
	$setting = new admin_setting_configcheckbox($name, $title, '', 0);
	$temp->add($setting);

	$name = 'theme_mb2nl/signuppage';
	$title = get_string('signuppage','theme_mb2nl');
	$setting = new admin_setting_configtext($name, $title, '', '');
	$temp->add($setting);

	$name = 'theme_mb2nl/loginsearchspacer2';
	$setting = new admin_setting_configmb2spacer($name);
	$temp->add($setting);

	$name = 'theme_mb2nl/searchlinks';
	$title = get_string('searchlinks','theme_mb2nl');
	$setting = new admin_setting_configtextarea($name, $title, get_string('searchlinksdesc','theme_mb2nl'), '');
	$temp->add($setting);



$setting = new admin_setting_configmb2end('theme_mb2nl/endloginform');
$setting->set_updatedcallback('theme_reset_all_caches');
$temp->add($setting);


// $setting = new admin_setting_configmb2start('theme_mb2nl/startpages', get_string('pagecls','theme_mb2nl'));
// $setting->set_updatedcallback('theme_reset_all_caches');
// $temp->add($setting);
//
//
// 	$name = 'theme_mb2nl/pagecls';
// 	$title = get_string('pagecls','theme_mb2nl');
// 	$desc = get_string('pageclsdesc','theme_mb2nl');
// 	$setting = new admin_setting_configtextarea($name, $title, $desc, '');
// 	$setting->set_updatedcallback('theme_reset_all_caches');
// 	$temp->add($setting);
//
//
// 	$name = 'theme_mb2nl/coursecls';
// 	$title = get_string('coursecls','theme_mb2nl');
// 	$desc = get_string('courseclsdesc','theme_mb2nl');
// 	$setting = new admin_setting_configtextarea($name, $title, $desc, '');
// 	$setting->set_updatedcallback('theme_reset_all_caches');
// 	$temp->add($setting);
//
//
// $setting = new admin_setting_configmb2end('theme_mb2nl/endpages');
// $setting->set_updatedcallback('theme_reset_all_caches');
// $temp->add($setting);


$setting = new admin_setting_configmb2start('theme_mb2nl/startscrolltt', get_string('scrolltt','theme_mb2nl'));
$temp->add($setting);


	$name = 'theme_mb2nl/scrolltt';
	$title = get_string('scrolltt','theme_mb2nl');
	$setting = new admin_setting_configcheckbox($name, $title,'', 0);
	$temp->add($setting);


	$name = 'theme_mb2nl/scrollspeed';
	$title = get_string('scrollspeed','theme_mb2nl');
	$setting = new admin_setting_configtext($name, $title, '', 400);
	$temp->add($setting);


$setting = new admin_setting_configmb2end('theme_mb2nl/endscrolltt');
$temp->add($setting);



$setting = new admin_setting_configmb2start('theme_mb2nl/startsitemenu', get_string('quicklinks','theme_mb2nl'));
$temp->add($setting);

	// $name = 'theme_mb2nl/quicklinks';
	// $title = get_string('quicklinks','theme_mb2nl');
	// $setting = new admin_setting_configcheckbox( $name, $title, '', 1);
	// $temp->add($setting);

	$name = 'theme_mb2nl/excludedlinks';
	$title = get_string('excludedlinks','theme_mb2nl');
	$setting = new admin_setting_configtextarea($name, $title,get_string('excludedlinksdesc','theme_mb2nl'), 'badges,addcourse,addcategory,editcategory');
	$temp->add($setting);

	$name = 'theme_mb2nl/customsitemnuitems';
	$title = get_string('customquicklinkitems','theme_mb2nl');
	$setting = new admin_setting_configtextarea($name, $title, get_string('customquicklinkitemsdesc','theme_mb2nl'), '');
	$temp->add($setting);

$setting = new admin_setting_configmb2end('theme_mb2nl/endsitemenu');
$temp->add($setting);



$setting = new admin_setting_configmb2start('theme_mb2nl/startganalitycs', get_string('ganatitle','theme_mb2nl'));
$setting->set_updatedcallback('theme_reset_all_caches');
$temp->add($setting);


	$name = 'theme_mb2nl/ganaid';
	$title = get_string('ganaid','theme_mb2nl');
	$setting = new admin_setting_configtext($name, $title,$title = get_string('ganaiddesc','theme_mb2nl'), '');
	$setting->set_updatedcallback('theme_reset_all_caches');
	$temp->add($setting);


	$name = 'theme_mb2nl/ganaasync';
	$title = get_string('ganaasync','theme_mb2nl');
	$setting = new admin_setting_configcheckbox($name, $title,'', 0);
	$setting->set_updatedcallback('theme_reset_all_caches');
	$temp->add($setting);


$setting = new admin_setting_configmb2end('theme_mb2nl/endganalitycs');
$setting->set_updatedcallback('theme_reset_all_caches');
$temp->add($setting);


$ADMIN->add('theme_mb2nl', $temp);
