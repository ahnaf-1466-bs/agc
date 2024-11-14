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
 * @package    local_mb2builder
 * @copyright  2018 - 2020 Mariusz Boloz (mb2moodle.com/)
 * @license   Commercial https://themeforest.net/licenses
 */

defined('MOODLE_INTERNAL') || die();



$mb2_settings_row = array(
	'tabs' => array(
		'general' => get_string('generaltab', 'local_mb2builder'),
		'style' => get_string('styletab', 'local_mb2builder'),
		'heroimg' => get_string('heroimg', 'local_mb2builder'),
		'bgtext' => get_string('bgtext', 'local_mb2builder'),
		'wave' => get_string('wavetab', 'local_mb2builder')
	),
	'attr'=>array(
		'rowlang' => array(
			'type'=>'text',
			'section' => 'general',
			'title'=> get_string('language', 'core'),
			'desc'=> get_string('languagedesc', 'local_mb2builder'),
			'action' => 'text',
			'selector' => '.mb2-pb-actions .languages'
		),
		'rowaccess' => array(
			'type' => 'list',
			'section' => 'general',
			'title'=> get_string('elaccess', 'local_mb2builder'),
			'options' => array(
				0 => get_string('elaccessall', 'local_mb2builder'),
				1 => get_string('elaccessusers', 'local_mb2builder'),
				2 => get_string('elaccesguests', 'local_mb2builder')
			),
			'default' => 0,
			'action' => 'class',
			'class_prefix' => 'access',
			'class_remove' => 'access0 access1 access2'
		),
		'rowhidden' => array(
			'type' => 'yesno',
			'section' => 'general',
			'title'=> get_string('hidden', 'local_mb2builder'),
			'options' => array(
				1 => get_string('yes', 'local_mb2builder'),
				0 => get_string('no', 'local_mb2builder')
			),
			'default' => 0,
			'action' => 'class',
			'class_prefix' => 'hidden',
			'class_remove' => 'hidden0 hidden1'
		),
		'fw' => array(
			'type' => 'yesno',
			'section' => 'general',
			'title'=> get_string('fullwidth', 'local_mb2builder'),
			'options' => array(
				1 => get_string('yes', 'local_mb2builder'),
				0 => get_string('no', 'local_mb2builder')
			),
			'default' => 0,
			'action' => 'class',
			'class_prefix' => 'isfw',
			'class_remove' => 'isfw0 isfw1'
		),
		'va' => array(
			'type' => 'yesno',
			'section' => 'general',
			'title'=> get_string('rowvalign', 'local_mb2builder'),
			'options' => array(
				1 => get_string('yes', 'local_mb2builder'),
				0 => get_string('no', 'local_mb2builder')
			),
			'default' => 0,
			'action' => 'class',
			'class_prefix' => 'va',
			'class_remove' => 'va0 va1'
		),
		'colgutter'=>array(
			'type' => 'buttons',
			'section' => 'general',
			'title'=> get_string('colspace', 'local_mb2builder'),
			'options' => array(
				'none' => get_string('none', 'local_mb2builder'),
				's' => get_string('small', 'local_mb2builder'),
				'm' => get_string('medium', 'local_mb2builder'),
				'l' => get_string('large', 'local_mb2builder'),
				'xl' => get_string('xlarge', 'local_mb2builder')
			),
			'default' => 's',
			'action' => 'class',
			'class_remove' => 'colgutter-none colgutter-m colgutter-s colgutter-l colgutter-xl',
			'class_prefix' => 'colgutter-',
		),
		'pt' => array(
			'type'=>'range',
			'section' => 'general',
			'title'=> get_string('ptlabel', 'local_mb2builder'),
			'min'=> 0,
			'max' => 300,
			'default'=> 60,
			'action' => 'style',
			'changemode' => 'input',
			'selector' => '.section-inner',
			'numclass' => 1,
			'sizepref' => 'rowpt',
			'style_properity' => 'padding-top',
		),
		'pb' => array(
			'type'=>'range',
			'section' => 'general',
			'title'=> get_string('pblabel', 'local_mb2builder'),
			'min'=> 0,
			'max' => 300,
			'default'=> 0,
			'action' => 'style',
			'changemode' => 'input',
			'numclass' => 1,
			'sizepref' => 'rowpb',
			'selector' => '.section-inner',
			'style_properity' => 'padding-bottom'
		),
		'mt' => array(
			'type'=>'range',
			'section' => 'general',
			'title'=> get_string('mtlabel', 'local_mb2builder'),
			'min'=> -300,
			'max' => 300,
			'default'=> 0,
			'action' => 'style',
			'changemode' => 'input',
			'style_properity' => 'margin-top',
		),
		'scheme' => array(
			'type' => 'buttons',
			'section' => 'style',
			'title'=> get_string('scheme', 'local_mb2builder'),
			'options' => array(
				'light' => get_string('light', 'local_mb2builder'),
				'dark' => get_string('dark', 'local_mb2builder')
			),
			'default' => 'light',
			'action' => 'class',
			'class_remove' => 'light dark'
		),
		'bgcolor' => array(
			'type' => 'color',
			'section' => 'style',
			'title'=> get_string('bgcolor', 'local_mb2builder'),
			'action' => 'color',
			'selector' => '.section-inner',
			'style_properity' => 'background-color'
		),
		'prbg' => array(
			'type' => 'list',
			'section' => 'style',
			'title'=> get_string('prestyle', 'local_mb2builder'),
			'options' => array(
				0 => get_string('none', 'local_mb2builder'),
				'gradient20' => get_string('gradient20', 'local_mb2builder'),
				'gradient40' => get_string('gradient40', 'local_mb2builder'),
				'strip1' => get_string('strip1', 'local_mb2builder'),
				'strip2' => get_string('strip2', 'local_mb2builder'),
				'strip3' => get_string('strip3', 'local_mb2builder'),
				'strip4' => get_string('strip4', 'local_mb2builder')
			),
			'default' => 0,
			'action' => 'class',
			'class_prefix' => 'pre-bg',
			'class_remove' => 'pre-bggradient20 pre-bggradient40 pre-bgstrip1 pre-bgstrip2 pre-bgstrip3 pre-bgstrip4'
		),
		'group_row_start_1' => array('type'=>'group_start', 'section' => 'style', 'title'=> get_string('bgimage', 'local_mb2builder')), // ============ GROUP START ============ //
		'bgimage' => array(
			'type' => 'image',
			'section' => 'style',
			'title'=> get_string('bgimage', 'local_mb2builder'),
			'action' => 'image',
			'style_properity' => 'background-image'
		),
		'bgfixed' => array(
			'type' => 'yesno',
			'section' => 'style',
			'title'=> get_string('bgfixed', 'local_mb2builder'),
			'options' => array(
				1 => get_string('yes', 'local_mb2builder'),
				0 => get_string('no', 'local_mb2builder')
			),
			'default' => 0,
			'action' => 'class',
			'class_prefix' => 'bgfixed',
			'class_remove' => 'bgfixed0 bgfixed1'
		),
		'parallax' => array(
			'type' => 'yesno',
			'section' => 'style',
			'title'=> get_string('parallax', 'local_mb2builder'),
			'options' => array(
				1 => get_string('yes', 'local_mb2builder'),
				0 => get_string('no', 'local_mb2builder')
			),
			'default' => 0,
			'action' => 'class',
			'class_prefix' => 'parallax',
			'class_remove' => 'parallax0 parallax1'
		),
		'group_row_end_1' => array('type'=>'group_end', 'section' => 'style'), // ============ GROUP END ============ //
		'group_row_start_3' => array('type'=>'group_start', 'section' => 'style', 'title'=> get_string('bgvideo', 'local_mb2builder')), // ============ GROUP START ============ //
		'bgvideo' => array(
			'type' => 'image',
			'section' => 'style',
			'title'=> get_string('bgvideo', 'local_mb2builder'),
			'action' => 'image',
			'selector' => '.section-video',
			//'style_properity' => 'src'
		),
		'group_row_end_3' => array('type'=>'group_end', 'section' => 'style'), // ============ GROUP END ============ //
		'group_row_start_2' => array('type'=>'group_start', 'section' => 'style', 'title'=> get_string('gradient', 'local_mb2builder')), // ============ GROUP START ============ //
		'gradient' => array(
			'type' => 'yesno',
			'section' => 'style',
			'title'=> get_string('gradient', 'local_mb2builder'),
			'options' => array(
				1 => get_string('yes', 'local_mb2builder'),
				0 => get_string('no', 'local_mb2builder')
			),
			'default' => 0,
			'action' => 'class',
			'class_prefix' => 'rowgrad',
			'class_remove' => 'rowgrad0 rowgrad1'
		),
		'graddeg' => array(
			'type'=>'range',
			'section' => 'style',
			'title'=> get_string('angle', 'local_mb2builder'),
			'min'=> 0,
			'max' => 360,
			'default'=> 45,
			'action' => 'gradient'
		),
		'gradcolor1' => array(
			'type' => 'color',
			'showon' => 'gradient:1',
			'section' => 'style',
			'title'=> get_string('gradcolorn', 'local_mb2builder', array('n' => 1)),
			'action' => 'color',
			'selector' => '.rowgrad',
			'style_properity' => 'background-color',
			'default' => '#37E2D5'
		),
		'gradloc1' => array(
			'type'=>'range',
			'section' => 'style',
			'title'=> get_string('gradloc1', 'local_mb2builder'),
			'min'=> 0,
			'max' => 100,
			'default'=> 0,
			'action' => 'gradient'
		),
		'gradcolor2' => array(
			'type' => 'color',
			'showon' => 'gradient:1',
			'section' => 'style',
			'title'=> get_string('gradcolorn', 'local_mb2builder', array('n' => 2)),
			'action' => 'color',
			'selector' => '.rowgrad',
			'style_properity' => 'background-color',
			'default' => '#590696'
		),
		'gradloc2' => array(
			'type'=>'range',
			'section' => 'style',
			'title'=> get_string('gradloc2', 'local_mb2builder'),
			'min'=> 0,
			'max' => 100,
			'default'=> 100,
			'action' => 'gradient'
		),
		'group_row_end_2' => array('type'=>'group_end', 'section' => 'style'), // ============ GROUP END ============ //
		'group_row_start_7' => array('type'=>'group_start', 'section' => 'style', 'title'=> get_string('border', 'local_mb2builder')), // ============ GROUP START ============ //
		'bordert' => array(
			'type' => 'yesno',
			'section' => 'style',
			'title'=> get_string('bordert', 'local_mb2builder'),
			'options' => array(
				1 => get_string('yes', 'local_mb2builder'),
				0 => get_string('no', 'local_mb2builder')
			),
			'default' => 0,
			'action' => 'class',
			'class_prefix' => 'bordert',
			'class_remove' => 'bordert0 bordert1'
		),
		'bordertcolor' => array(
			'type' => 'color',
			'showon' => 'bordert:1',
			'section' => 'style',
			'title'=> get_string('color', 'local_mb2builder'),
			'action' => 'color',
			'selector' => '.section-inner',
			'style_properity' => 'border-top-color',
			'default' => '#dddddd'
		),
		'borderb' => array(
			'type' => 'yesno',
			'section' => 'style',
			'title'=> get_string('borderb', 'local_mb2builder'),
			'options' => array(
				1 => get_string('yes', 'local_mb2builder'),
				0 => get_string('no', 'local_mb2builder')
			),
			'default' => 0,
			'action' => 'class',
			'class_prefix' => 'borderb',
			'class_remove' => 'borderb0 borderb1'
		),
		'borderbcolor' => array(
			'type' => 'color',
			'showon' => 'borderb:1',
			'section' => 'style',
			'title'=> get_string('color', 'local_mb2builder'),
			'action' => 'color',
			'selector' => '.section-inner',
			'style_properity' => 'border-bottom-color',
			'default' => '#dddddd'
		),
		'group_row_end_7' => array('type'=>'group_end', 'section' => 'style'), // ============ GROUP END ============ //
		'heroimg' => array(
			'type' => 'yesno',
			'section' => 'heroimg',
			'title'=> get_string('heroimg', 'local_mb2builder'),
			'options' => array(
				1 => get_string('yes', 'local_mb2builder'),
				0 => get_string('no', 'local_mb2builder')
			),
			'default' => 0,
			'action' => 'class',
			'class_prefix' => 'heroimg',
			'class_remove' => 'heroimg0 heroimg1'
		),
		'heroimgurl' => array(
			'type' => 'image',
			'showon' => 'heroimg:1',
			'section' => 'heroimg',
			'title'=> get_string('image', 'local_mb2builder'),
			'action' => 'image',
			'selector' => '.hero-img'
		),
		// 'heroh'=>array(
		// 	'type' => 'buttons',
		// 	'section' => 'heroimg',
		// 	'showon' => 'heroimg:1',
		// 	'title'=> get_string('alignh', 'local_mb2builder'),
		// 	'options' => array(
		// 		'left' => get_string('left', 'local_mb2builder'),
		// 		'center' => get_string('center', 'local_mb2builder'),
		// 		'right' => get_string('right', 'local_mb2builder')
		// 	),
		// 	'default' => 'none',
		// 	'action' => 'class',
		// 	'class_remove' => 'herohleft herohcenter herohright',
		// 	'class_prefix' => 'heroh'
		// ),
		'herov'=>array(
			'type' => 'buttons',
			'section' => 'heroimg',
			'showon' => 'heroimg:1',
			'title'=> get_string('alignv', 'local_mb2builder'),
			'options' => array(
				'top' => get_string('top', 'local_mb2builder'),
				'center' => get_string('center', 'local_mb2builder'),
				'bottom' => get_string('bottom', 'local_mb2builder')
			),
			'default' => 'center',
			'action' => 'class',
			'class_remove' => 'herovtop herovcenter herovbottom',
			'class_prefix' => 'herov'
		),
		'heroonsmall' => array(
			'type' => 'yesno',
			'section' => 'heroimg',
			'showon' => 'heroimg:1',
			'title'=> get_string('smallscreen', 'local_mb2builder'),
			'options' => array(
				1 => get_string('yes', 'local_mb2builder'),
				0 => get_string('no', 'local_mb2builder')
			),
			'default' => 1,
			'action' => 'class',
			'class_prefix' => 'heroonsmall',
			'class_remove' => 'heroonsmall0 heroonsmall1'
		),
		'herow' => array(
			'type'=>'range',
			'section' => 'heroimg',
			'showon' => 'heroimg:1',
			'title'=> get_string('widthlabel', 'local_mb2builder'),
			'min'=> 50,
			'max' => 2000,
			'default'=> 1200,
			'action' => 'style',
			'changemode' => 'input',
			'selector' => '.hero-img-wrap3',
			'style_properity' => 'width'
		),
		'herohpos' => array(
			'type' => 'buttons',
			'section' => 'heroimg',
			'showon' => 'heroimg:1',
			'title'=> get_string('hpos', 'local_mb2builder'),
			'options' => array(
				'left' => get_string('left', 'local_mb2builder'),
				'right' => get_string('right', 'local_mb2builder')
			),
			'default' => 'left',
			'action' => 'setting',
			'setting' => 'heroml'
		),
		'heroml' => array(
			'type'=>'range',
			'section' => 'heroimg',
			'showon' => 'heroimg:1',
			'title'=> get_string('hpospercentage', 'local_mb2builder'),
			'min'=> -99,
			'max' => 99,
			'default'=> 0,
			'action' => 'style',
			'changemode' => 'input',
			'selector' => '.hero-img-wrap3',
			'style_properity' => 'left',
			'style_suffix' => '%'
		),
		'heromt' => array(
			'type'=>'range',
			'section' => 'heroimg',
			'showon' => 'heroimg:1',
			'title'=> get_string('toppixel', 'local_mb2builder'),
			'min'=> -500,
			'max' => 500,
			'default'=> 0,
			'action' => 'style',
			'changemode' => 'input',
			'selector' => '.hero-img-wrap3',
			'style_properity' => 'margin-top'
		),
		'herogradl' => array(
			'type' => 'yesno',
			'section' => 'heroimg',
			'showon' => 'heroimg:1',
			'title'=> get_string('herogradl', 'local_mb2builder'),
			'options' => array(
				1 => get_string('yes', 'local_mb2builder'),
				0 => get_string('no', 'local_mb2builder')
			),
			'default' => 0,
			'action' => 'class',
			'class_prefix' => 'herogradl',
			'class_remove' => 'herogradl0 herogradl1'
		),
		'herogradr' => array(
			'type' => 'yesno',
			'section' => 'heroimg',
			'showon' => 'heroimg:1',
			'title'=> get_string('herogradr', 'local_mb2builder'),
			'options' => array(
				1 => get_string('yes', 'local_mb2builder'),
				0 => get_string('no', 'local_mb2builder')
			),
			'default' => 0,
			'action' => 'class',
			'class_prefix' => 'herogradr',
			'class_remove' => 'herogradr0 herogradr1'
		),
		'wave'=>array(
			'type' => 'buttons',
			'section' => 'wave',
			'title'=> get_string('wave', 'local_mb2builder'),
			'options' => array(
				'none' => get_string('none', 'local_mb2builder'),
				'1' => get_string('waven', 'local_mb2builder', array('n' => 1)),
				'2' => get_string('waven', 'local_mb2builder', array('n' => 2)),
				'3' => get_string('waven', 'local_mb2builder', array('n' => 3)),
				'4' => get_string('waven', 'local_mb2builder', array('n' => 4))
			),
			'default' => 'none',
			'action' => 'class',
			'class_remove' => 'wave-none wave-1 wave-2 wave-3 wave-4',
			'class_prefix' => 'wave-'
		),
		'wavepos'=>array(
			'type' => 'buttons',
			'section' => 'wave',
			'showon' => 'wave:1|2|3|4',
			'title'=> get_string('position', 'local_mb2builder'),
			'options' => array(
				'0' => get_string('bottom', 'local_mb2builder'),
				'1' => get_string('top', 'local_mb2builder' ),
			),
			'default' => '0',
			'action' => 'class',
			'class_prefix' => 'wavepos',
			'class_remove' => 'wavepos0 wavepos1',
		),
		'wavefliph' => array(
			'type' => 'yesno',
			'section' => 'wave',
			'showon' => 'wave:1|2|3|4',
			'title'=> get_string('fliph', 'local_mb2builder'),
			'options' => array(
				1 => get_string('yes', 'local_mb2builder'),
				0 => get_string('no', 'local_mb2builder')
			),
			'default' => 0,
			'action' => 'class',
			'class_prefix' => 'wavefliph',
			'class_remove' => 'wavefliph0 wavefliph1'
		),
		'waveover' => array(
			'type' => 'yesno',
			'section' => 'wave',
			'showon' => 'wave:1|2|3|4',
			'title'=> get_string('overcontent', 'local_mb2builder'),
			'options' => array(
				1 => get_string('yes', 'local_mb2builder'),
				0 => get_string('no', 'local_mb2builder')
			),
			'default' => 1,
			'action' => 'class',
			'class_prefix' => 'waveover',
			'class_remove' => 'waveover0 waveover1'
		),
		'wavecolor' => array(
			'type' => 'color',
			'section' => 'wave',
			'showon' => 'wave:1|2|3|4',
			'title'=> get_string('wavecolor', 'local_mb2builder'),
			'action' => 'color',
			'selector' => '.mb2-pb-row-wave path',
			'style_properity' => 'fill',
			'default' => '#ffffff',
		),
		'wavewidth' => array(
			'type'=>'range',
			'section' => 'wave',
			'showon' => 'wave:1|2|3|4',
			'title'=> get_string('widthpercentage', 'local_mb2builder'),
			'min'=> 100,
			'max' => 1000,
			'default'=> 100,
			'action' => 'style',
			'changemode' => 'input',
			'selector' => '.mb2-pb-row-wave svg',
			'style_properity' => 'width',
			'style_suffix' => '%'
		),
		'waveheight' => array(
			'type'=>'range',
			'section' => 'wave',
			'showon' => 'wave:1|2|3|4',
			'title'=> get_string('height', 'local_mb2builder'),
			'min'=> 10,
			'max' => 500,
			'default'=> 55,
			'action' => 'style',
			'changemode' => 'input',
			'selector' => '.mb2-pb-row-wave svg',
			'style_properity' => 'height'
		),
		'bgtext' => array(
			'type' => 'yesno',
			'section' => 'bgtext',
			'title'=> get_string('bgtext', 'local_mb2builder'),
			'options' => array(
				1 => get_string('yes', 'local_mb2builder'),
				0 => get_string('no', 'local_mb2builder')
			),
			'default' => 0,
			'action' => 'class',
			'class_prefix' => 'bgtext',
			'class_remove' => 'bgtext0 bgtext1'
		),
		'bgtextmob' => array(
			'type' => 'yesno',
			'section' => 'bgtext',
			'showon' => 'bgtext:1',
			'title'=> get_string('onmobile', 'local_mb2builder'),
			'options' => array(
				1 => get_string('yes', 'local_mb2builder'),
				0 => get_string('no', 'local_mb2builder')
			),
			'default' => 0,
			'action' => 'class',
			'class_prefix' => 'bgtextmob',
			'class_remove' => 'bgtextmob0 bgtextmob1'
		),
		'bgtexttext' => array(
			'type'=>'range',
			'section' => 'bgtext',
			'showon' => 'bgtext:1',
			'type'=>'text',
			'title' => get_string('text', 'local_mb2builder'),
			'action' => 'text',
			'selector' => '.bgtext-text',
			'default' => 'Sample text'
		),
		'btcolor' => array(
			'type' => 'color',
			'showon' => 'bgtext:1',
			'section' => 'bgtext',
			'title'=> get_string('color', 'local_mb2builder'),
			'action' => 'color',
			'default' => 'rgba(0,0,0,.05)',
			'selector' => '.bgtext-text',
			'style_properity' => 'color'
		),
		'bth'=>array(
			'type' => 'buttons',
			'section' => 'bgtext',
			'showon' => 'bgtext:1',
			'title'=> get_string('alignh', 'local_mb2builder'),
			'options' => array(
				'left' => get_string('left', 'local_mb2builder'),
				'center' => get_string('center', 'local_mb2builder'),
				'right' => get_string('right', 'local_mb2builder')
			),
			'default' => 'none',
			'action' => 'class',
			'selector' => '.bgtext',
			'class_remove' => 'bthleft bthright bthcenter',
			'class_prefix' => 'bth'
		),
		'btv'=>array(
			'type' => 'buttons',
			'section' => 'bgtext',
			'showon' => 'bgtext:1',
			'title'=> get_string('alignv', 'local_mb2builder'),
			'options' => array(
				'top' => get_string('top', 'local_mb2builder'),
				'center' => get_string('center', 'local_mb2builder'),
				'bottom' => get_string('bottom', 'local_mb2builder')
			),
			'default' => 'none',
			'action' => 'class',
			'selector' => '.bgtext',
			'class_remove' => 'btvtop btvcenter btvbottom',
			'class_prefix' => 'btv'
		),
		'btsize'=>array(
			'type' => 'range',
			'section' => 'bgtext',
			'showon' => 'bgtext:1',
			'title'=> get_string('sizelabel', 'local_mb2builder'),
			'min'=> 1,
			'max' => 1000,
			'step' => 1,
			'default'=> 290,
			'action' => 'style',
			'style_suffix' => 'none',
			'changemode' => 'input',
			'selector' => '.bgtext-text',
			'style_properity' => 'font-size',
			'style_suffix' => 'px'
		),
		'btfweight'=>array(
			'type'=>'range',
			'section' => 'bgtext',
			'showon' => 'bgtext:1',
			'title'=> get_string('fweight', 'local_mb2builder'),
			'min'=> 100,
			'max' => 900,
			'step' => 100,
			'default'=> 600,
			'action' => 'style',
			'style_suffix' => 'none',
			'changemode' => 'input',
			'selector' => '.bgtext-text',
			'style_properity' => 'font-weight'
		),
		'btlh'=>array(
			'type'=>'range',
			'section' => 'bgtext',
			'showon' => 'bgtext:1',
			'title'=> get_string('lh', 'local_mb2builder'),
			'min'=> 0.5,
			'max' => 3,
			'step' => .01,
			'default'=> 1,
			'action' => 'style',
			'changemode' => 'input',
			'selector' => '.bgtext-text',
			'style_suffix' => 'none',
			'style_properity' => 'line-height'
		),
		'btlspacing'=>array(
			'type'=>'range',
			'section' => 'bgtext',
			'showon' => 'bgtext:1',
			'title'=> get_string('lspacing', 'local_mb2builder'),
			'min'=> -10,
			'max' => 30,
			'step' => 1,
			'default'=> 0,
			'action' => 'style',
			'changemode' => 'input',
			'selector' => '.bgtext-text',
			'style_properity' => 'letter-spacing'
		),
		'btwspacing'=>array(
			'type'=>'range',
			'section' => 'bgtext',
			'showon' => 'bgtext:1',
			'title'=> get_string('wspacing', 'local_mb2builder'),
			'min'=> -10,
			'max' => 30,
			'step' => 1,
			'default'=> 0,
			'action' => 'style',
			'changemode' => 'input',
			'selector' => '.bgtext-text',
			'style_properity' => 'word-spacing'
		),
		'btupper' => array(
			'type' => 'yesno',
			'section' => 'bgtext',
			'showon' => 'bgtext:1',
			'title'=> get_string('uppercase', 'local_mb2builder'),
			'options' => array(
				1 => get_string('yes', 'local_mb2builder'),
				0 => get_string('no', 'local_mb2builder')
			),
			'default' => 0,
			'action' => 'class',
			'selector' => '.bgtext-text',
			'class_remove' => 'upper0 upper1',
			'class_prefix' => 'upper',
		),
		'custom_class' => array(
			'type'=>'text',
			'section' => 'style',
			'title'=> get_string('customclasslabel', 'local_mb2builder'),
			'desc'=> get_string('customclassdesc', 'local_mb2builder'),
			'default'=> ''
		)

	)
);

define('LOCAL_MB2BUILDER_SETTINGS_ROW', base64_encode( serialize( $mb2_settings_row ) ) );
