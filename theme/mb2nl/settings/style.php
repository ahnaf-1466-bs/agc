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


$temp = new admin_settingpage('theme_mb2nl_settingsstyle',  get_string('settingsstyle', 'theme_mb2nl'));



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
	'strip2'=>get_string('strip2','theme_mb2nl'),
);


$bgPredefinedPageOpt = array(
	'' => get_string('none','theme_mb2nl'),
	'default' => get_string('imgdefault','theme_mb2nl'),
	'strip1'=>get_string('strip1','theme_mb2nl'),
	'strip2'=>get_string('strip2','theme_mb2nl'),
);


$colorSchemeOpt = array(
	'light' => get_string('light','theme_mb2nl'),
	'dark' => get_string('dark','theme_mb2nl'),
);


$setting = new admin_setting_configmb2start('theme_mb2nl/startcolors', get_string('colors','theme_mb2nl'));
//$setting->set_updatedcallback('theme_reset_all_caches');
$temp->add($setting);


	$name = 'theme_mb2nl/accent1';
	$title = get_string('accentcolor','theme_mb2nl') . ' 1';
	$setting = new admin_setting_configmb2color($name, $title, $desc, '#b8001c');
	$setting->set_updatedcallback('theme_reset_all_caches');
	$temp->add($setting);


	$name = 'theme_mb2nl/accent2';
	$title = get_string('accentcolor','theme_mb2nl') . ' 2';
	$setting = new admin_setting_configmb2color($name, $title, '', '#27323a');
	$setting->set_updatedcallback('theme_reset_all_caches');
	$temp->add($setting);


	$name = 'theme_mb2nl/accent3';
	$title = get_string('accentcolor','theme_mb2nl') . ' 3';
	$setting = new admin_setting_configmb2color($name, $title, '', '#ffb400');
	$setting->set_updatedcallback('theme_reset_all_caches');
	$temp->add($setting);

	$setting = new admin_setting_configmb2spacer('theme_mb2nl/colorspacer1');
	$setting->set_updatedcallback('theme_reset_all_caches');
	$temp->add($setting);

	$name = 'theme_mb2nl/textcolor';
	$title = get_string('textcolor','theme_mb2nl');
	$setting = new admin_setting_configmb2color($name, $title, '', '#403D42');
	$setting->set_updatedcallback('theme_reset_all_caches');
	$temp->add($setting);

	$name = 'theme_mb2nl/textcolor_lighten';
	$title = get_string('textcolor_lighten','theme_mb2nl');
	$setting = new admin_setting_configmb2color($name, $title, '', '#b5b5b5');
	$setting->set_updatedcallback('theme_reset_all_caches');
	$temp->add($setting);

	$name = 'theme_mb2nl/textcolorondark';
	$title = get_string('textcolorondark','theme_mb2nl');
	$setting = new admin_setting_configmb2color($name, $title, '', '#909699');
	$setting->set_updatedcallback('theme_reset_all_caches');
	$temp->add($setting);

	$name = 'theme_mb2nl/linkcolor';
	$title = get_string('linkcolor','theme_mb2nl');
	$setting = new admin_setting_configmb2color($name, $title, $desc, '#0083fa');
	$setting->set_updatedcallback('theme_reset_all_caches');
	$temp->add($setting);


	$name = 'theme_mb2nl/linkhcolor';
	$title = get_string('linkhcolor','theme_mb2nl');
	$setting = new admin_setting_configmb2color($name, $title, $desc, '#00529e');
	$setting->set_updatedcallback('theme_reset_all_caches');
	$temp->add($setting);


	$name = 'theme_mb2nl/headingscolor';
	$title = get_string('headingscolor','theme_mb2nl');
	$setting = new admin_setting_configmb2color($name, $title, $desc, '#242027');
	$setting->set_updatedcallback('theme_reset_all_caches');
	$temp->add($setting);

	$setting = new admin_setting_configmb2spacer('theme_mb2nl/colorspacer2');
	$temp->add($setting);

	$name = 'theme_mb2nl/btncolor';
	$title = get_string('btncolor','theme_mb2nl');
	$setting = new admin_setting_configmb2color($name, $title, $desc, '#64748c');
	$setting->set_updatedcallback('theme_reset_all_caches');
	$temp->add($setting);

	$name = 'theme_mb2nl/btnprimarycolor';
	$title = get_string('btnprimarycolor','theme_mb2nl');
	$setting = new admin_setting_configmb2color($name, $title, $desc, '#b8001c');
	$setting->set_updatedcallback('theme_reset_all_caches');
	$temp->add($setting);


	$setting = new admin_setting_configmb2spacer('theme_mb2nl/colorspacer4');
	$temp->add($setting);


	$name = 'theme_mb2nl/color_success';
	$title = get_string('color_success','theme_mb2nl');
	$setting = new admin_setting_configmb2color($name, $title, $desc, '#00C897');
	$setting->set_updatedcallback('theme_reset_all_caches');
	$temp->add($setting);

	$name = 'theme_mb2nl/color_warning';
	$title = get_string('color_warning','theme_mb2nl');
	$setting = new admin_setting_configmb2color($name, $title, $desc, '#FF7000');
	$setting->set_updatedcallback('theme_reset_all_caches');
	$temp->add($setting);

	$name = 'theme_mb2nl/color_danger';
	$title = get_string('color_danger','theme_mb2nl');
	$setting = new admin_setting_configmb2color($name, $title, $desc, '#EB455F');
	$setting->set_updatedcallback('theme_reset_all_caches');
	$temp->add($setting);

	$name = 'theme_mb2nl/color_info';
	$title = get_string('color_info','theme_mb2nl');
	$setting = new admin_setting_configmb2color($name, $title, $desc, '#332FD0');
	$setting->set_updatedcallback('theme_reset_all_caches');
	$temp->add($setting);


$setting = new admin_setting_configmb2end('theme_mb2nl/endcolors');
//$setting->set_updatedcallback('theme_reset_all_caches');
$temp->add($setting);

$setting = new admin_setting_configmb2start('theme_mb2nl/startheaderstyle', get_string('headerstyleheading','theme_mb2nl'));
$temp->add($setting);

	$name = 'theme_mb2nl/headerstyle';
	$title = get_string('headerstyle','theme_mb2nl');
	$setting = new admin_setting_configselect($name, $title, '', 'light', $headerStyleOpt);
	$temp->add($setting);

	$name = 'theme_mb2nl/mhbgcolor';
	$title = get_string('dbgcolor','theme_mb2nl');
	$setting = new admin_setting_configmb2color($name, $title, '', '#0d1b2a');
	$setting->set_updatedcallback('theme_reset_all_caches');
	$temp->add($setting);


	$name = 'theme_mb2nl/tbbgcolor';
	$title = get_string('tbdbgcolor','theme_mb2nl');
	$setting = new admin_setting_configmb2color($name, $title, '', '#384d68');
	$setting->set_updatedcallback('theme_reset_all_caches');
	$temp->add($setting);


$setting = new admin_setting_configmb2end('theme_mb2nl/endheaderstyle');
$temp->add($setting);


$setting = new admin_setting_configmb2start('theme_mb2nl/startptitlestyle', get_string('h_pagetitle','theme_mb2nl'));
$temp->add($setting);

	$name = 'theme_mb2nl/headercolorscheme';
	$title = get_string('colorscheme','theme_mb2nl');
	$setting = new admin_setting_configselect($name, $title, '', 'dark', array('dark' => get_string('dark','theme_mb2nl'), 'light' => get_string('light','theme_mb2nl')));
	$temp->add($setting);

	$name = 'theme_mb2nl/headerbgcolor';
	$title = get_string('dbgcolor','theme_mb2nl');
	$setting = new admin_setting_configmb2color($name, $title, '', '#0100a4');
	$setting->set_updatedcallback('theme_reset_all_caches');
	$temp->add($setting);

	$name = 'theme_mb2nl/headerbgcolor2';
	$title = get_string('dbgcolor','theme_mb2nl') . ' 2';
	$setting = new admin_setting_configmb2color($name, $title, '', '#f44708');
	$setting->set_updatedcallback('theme_reset_all_caches');
	$temp->add($setting);

	$name = 'theme_mb2nl/headerlbgcolor';
	$title = get_string('lbgcolor','theme_mb2nl');
	$setting = new admin_setting_configmb2color($name, $title, '', '#f4f7f8');
	$setting->set_updatedcallback('theme_reset_all_caches');
	$temp->add($setting);

	$name = 'theme_mb2nl/headerlbgcolor2';
	$title = get_string('lbgcolor','theme_mb2nl') . ' 2';
	$setting = new admin_setting_configmb2color($name, $title, '', '#d6e4e5');
	$setting->set_updatedcallback('theme_reset_all_caches');
	$temp->add($setting);

	$name = 'theme_mb2nl/headerimg';
	$title = get_string('bgimage','theme_mb2nl');
	$setting = new admin_setting_configstoredfile($name, $title, '', 'headerimg');
	$temp->add($setting);


$setting = new admin_setting_configmb2end('theme_mb2nl/endptitlestyle');
$temp->add($setting);


$setting = new admin_setting_configmb2start('theme_mb2nl/startblockstyle', get_string('blockstyleheading','theme_mb2nl'));
$temp->add($setting);


	$layoutArr = array(
		'classic' => get_string('classic','theme_mb2nl'),
		'minimal' => get_string('minimal','theme_mb2nl')
	);
	$name = 'theme_mb2nl/blockstyle2';
	$title = get_string('blockstyle','theme_mb2nl');
	$setting = new admin_setting_configselect($name, $title, '', 'minimal', $layoutArr);
	$temp->add($setting);


$setting = new admin_setting_configmb2end('theme_mb2nl/endblockstyle');
$temp->add($setting);



$setting = new admin_setting_configmb2start('theme_mb2nl/startpagestyle', get_string('pagestyle','theme_mb2nl'));
$setting->set_updatedcallback('theme_reset_all_caches');
$temp->add($setting);


	$name = 'theme_mb2nl/pbgpre';
	$title = get_string('pbgpre','theme_mb2nl');
	$setting = new admin_setting_configselect($name, $title, '', '', $bgPredefinedPageOpt);
	$setting->set_updatedcallback('theme_reset_all_caches');
	$temp->add($setting);


	$name = 'theme_mb2nl/pbgcolor';
	$title = get_string('bgcolor','theme_mb2nl');
	$setting = new admin_setting_configmb2color($name, $title, get_string('pbgdesc','theme_mb2nl'), '');
	$setting->set_updatedcallback('theme_reset_all_caches');
	$temp->add($setting);


	$name = 'theme_mb2nl/pbgimage';
	$title = get_string('bgimage','theme_mb2nl');
	$setting = new admin_setting_configstoredfile($name, $title, get_string('pbgdesc','theme_mb2nl'), 'pbgimage');
	$setting->set_updatedcallback('theme_reset_all_caches');
	$temp->add($setting);

	$name = 'theme_mb2nl/pbgimagescroll';
	$title = get_string('pbgimagescroll','theme_mb2nl');
	$setting = new admin_setting_configcheckbox($name,$title,'',0);
	$temp->add($setting);

	// $name = 'theme_mb2nl/pbgrepeat';
	// $title = get_string('bgrepeat','theme_mb2nl');
	// $setting = new admin_setting_configselect($name, $title, '', 'no-repeat', $bgRepearOpt);
	// $setting->set_updatedcallback('theme_reset_all_caches');
	// $temp->add($setting);


	// $name = 'theme_mb2nl/pbgpos';
	// $title = get_string('bgpos','theme_mb2nl');
	// $setting = new admin_setting_configselect($name, $title, '', 'center center', $bgPositionOpt);
	// $setting->set_updatedcallback('theme_reset_all_caches');
	// $temp->add($setting);


	// $name = 'theme_mb2nl/pbgattach';
	// $title = get_string('bgattachment','theme_mb2nl');
	// $setting = new admin_setting_configselect($name, $title, '', 'scroll', $bgAttOpt);
	// $setting->set_updatedcallback('theme_reset_all_caches');
	// $temp->add($setting);


	// $name = 'theme_mb2nl/pbgsize';
	// $title = get_string('bgsize','theme_mb2nl');
	// $setting = new admin_setting_configselect($name, $title, '', 'cover', $bgSizeOpt);
	// $setting->set_updatedcallback('theme_reset_all_caches');
	// $temp->add($setting);


$setting = new admin_setting_configmb2end('theme_mb2nl/endpagestyle');
$setting->set_updatedcallback('theme_reset_all_caches');
$temp->add($setting);


// $sectionsArr = array('as'=>get_string('asstyle','theme_mb2nl'),'bc'=>get_string('bcstyle','theme_mb2nl'),'ac'=>get_string('acstyle','theme_mb2nl'));
//
// foreach ($sectionsArr as $k=>$section)
// {
//
// 	$setting = new admin_setting_configmb2start('theme_mb2nl/start' . $k . 'style', $section);
// 	$setting->set_updatedcallback('theme_reset_all_caches');
// 	$temp->add($setting);
//
//
// 		$name = 'theme_mb2nl/' . $k . 'padding';
// 		$title = get_string('sectionpadding','theme_mb2nl');
// 		$setting = new admin_setting_configtext($name, $title, get_string('sectionpaddingdesc','theme_mb2nl'), '40,10');
// 		$setting->set_updatedcallback('theme_reset_all_caches');
// 		$temp->add($setting);
//
//
// 		$setting = new admin_setting_configmb2spacer('theme_mb2nl/bcspacer');
// 		$setting->set_updatedcallback('theme_reset_all_caches');
// 		$temp->add($setting);
//
//
// 		$name = 'theme_mb2nl/' . $k . 'scheme';
// 		$title = get_string('colorscheme','theme_mb2nl');
// 		$setting = new admin_setting_configselect($name, $title, '', 'light', $colorSchemeOpt);
// 		$setting->set_updatedcallback('theme_reset_all_caches');
// 		$temp->add($setting);
//
//
// 		$name = 'theme_mb2nl/' . $k . 'bgpre';
// 		$title = get_string('pbgpre','theme_mb2nl');
// 		$setting = new admin_setting_configselect($name, $title, '', '', $bgPredefinedOpt);
// 		$setting->set_updatedcallback('theme_reset_all_caches');
// 		$temp->add($setting);
//
//
// 		$name = 'theme_mb2nl/' . $k . 'bgcolor';
// 		$title = get_string('bgcolor','theme_mb2nl');
// 		$setting = new admin_setting_configmb2color($name, $title, get_string('pbgdesc','theme_mb2nl'), '');
// 		$setting->set_updatedcallback('theme_reset_all_caches');
// 		$temp->add($setting);
//
//
// 		$name = 'theme_mb2nl/' . $k . 'bgimage';
// 		$title = get_string('bgimage','theme_mb2nl');
// 		$setting = new admin_setting_configstoredfile($name, $title, get_string('pbgdesc','theme_mb2nl'), $k . 'bgimage');
// 		$setting->set_updatedcallback('theme_reset_all_caches');
// 		$temp->add($setting);
//
//
// 		$name = 'theme_mb2nl/' . $k . 'bgrepeat';
// 		$title = get_string('bgrepeat','theme_mb2nl');
// 		$setting = new admin_setting_configselect($name, $title, '', 'no-repeat', $bgRepearOpt);
// 		$setting->set_updatedcallback('theme_reset_all_caches');
// 		$temp->add($setting);
//
//
// 		$name = 'theme_mb2nl/' . $k . 'bgpos';
// 		$title = get_string('bgpos','theme_mb2nl');
// 		$setting = new admin_setting_configselect($name, $title, '', 'center center', $bgPositionOpt);
// 		$setting->set_updatedcallback('theme_reset_all_caches');
// 		$temp->add($setting);
//
//
// 		$name = 'theme_mb2nl/' . $k . 'bgattach';
// 		$title = get_string('bgattachment','theme_mb2nl');
// 		$setting = new admin_setting_configselect($name, $title, '', 'scroll', $bgAttOpt);
// 		$setting->set_updatedcallback('theme_reset_all_caches');
// 		$temp->add($setting);
//
//
// 		$name = 'theme_mb2nl/' . $k . 'bgsize';
// 		$title = get_string('bgsize','theme_mb2nl');
// 		$setting = new admin_setting_configselect($name, $title, '', 'cover', $bgSizeOpt);
// 		$setting->set_updatedcallback('theme_reset_all_caches');
// 		$temp->add($setting);
//
//
// 	$setting = new admin_setting_configmb2end('theme_mb2nl/end' . $k . 'style');
// 	$setting->set_updatedcallback('theme_reset_all_caches');
// 	$temp->add($setting);
//
//
// }







$setting = new admin_setting_configmb2start('theme_mb2nl/startplugincss', get_string('plugincss','theme_mb2nl'));
$temp->add($setting);

	$name = 'theme_mb2nl/plugincss';
	$title = get_string('plugincss','theme_mb2nl');
	$setting = new admin_setting_configtextarea($name, $title, get_string('plugincssdesc','theme_mb2nl'), '');
	$setting->set_updatedcallback('theme_reset_all_caches');
	$temp->add($setting);

$setting = new admin_setting_configmb2end('theme_mb2nl/endplugincss');
$temp->add($setting);



$setting = new admin_setting_configmb2start('theme_mb2nl/startcustomcssstyle', get_string('scustomcssstyleheading','theme_mb2nl'));
$temp->add($setting);


	$name = 'theme_mb2nl/customcss';
	$title = get_string('customcss','theme_mb2nl');
	$setting = new admin_setting_configtextarea($name, $title, '', '');
	$setting->set_updatedcallback('theme_reset_all_caches');
	$temp->add($setting);


$setting = new admin_setting_configmb2end('theme_mb2nl/endcustomcssstyle');
$temp->add($setting);



$ADMIN->add('theme_mb2nl', $temp);
