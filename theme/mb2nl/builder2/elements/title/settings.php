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



$mb2_settings = array(
	'id' => 'title',
	'subid' => '',
	'title' => get_string('title', 'local_mb2builder'),
	'icon' => 'fa fa-bullhorn',
	'tabs' => array(
		'general' => get_string('generaltab', 'local_mb2builder'),
		'typo' => get_string('typotab', 'local_mb2builder'),
		'style' => get_string('styletab', 'local_mb2builder')
	),
	'attr' => array(
		'content'=>array(
			'type'=>'text',
			'section' => 'general',
			'title'=> get_string('text', 'local_mb2builder'),
			'action' => 'text',
			'selector' => '.title-text',
			'default' => 'Heading text here'
		),
		'tag'=>array(
			'type'=>'list',
			'section' => 'general',
			'title'=> get_string('htmltag', 'local_mb2builder'),
			'options' => array(
				'h1' => 'h1',
				'h2' => 'h2',
				'h3' => 'h3',
				'h4' => 'h4',
				'h5' => 'h5',
				'h6' => 'h6'
			),
			'default' => 'h4',
			'action' => 'class',
			'selector' => '.title',
			'class_remove' => 'h1 h2 h3 h4 h5 h6'
		),
		'issubtext' => array(
			'type' => 'yesno',
			'section' => 'general',
			'title'=> get_string('subtext', 'local_mb2builder'),
			'options' => array(
				1 => get_string('yes', 'local_mb2builder'),
				0 => get_string('no', 'local_mb2builder')
			),
			'default' => 1,
			'action' => 'class',
			'selector' => '.theme-title',
			'class_remove' => 'issubtext0 issubtext1',
			'class_prefix' => 'issubtext',
		),
		'subtext'=>array(
			'type'=>'text',
			'section' => 'general',
			'showon' => 'issubtext:1',
			'title'=> get_string('subtext', 'local_mb2builder'),
			'action' => 'text',
			'selector' => '.title-subtext',
			'default' => 'Subtext here'
		),
		'style'=>array(
			'type' => 'buttons',
			'section' => 'style',
			'title'=> get_string('styletab', 'local_mb2builder'),
			'options' => array(
				1 => get_string('default', 'local_mb2builder'),
				2 => get_string('line', 'local_mb2builder')
			),
			'default' => 1,
			'action' => 'class',
			'selector' => '.theme-title',
			'class_remove' => 'style-1 style-2',
			'class_prefix' => 'style-'
		),
		'sizerem'=>array(
			'type' => 'range',
			'section' => 'typo',
			'title'=> get_string('sizelabel', 'local_mb2builder'),
			'min'=> 1,
			'max' => 10,
			'step' => 0.01,
			'default'=> 2,
			'action' => 'style',
			'style_suffix' => 'none',
			'changemode' => 'input',
			'selector' => '.title',
			'style_properity' => 'font-size',
			'style_suffix' => 'rem',
			'numclass' => 1,
			'sizepref' => 'hsize'
		),
		// 'fweight'=>array(
		// 	'type'=>'range',
		// 	'section' => 'typo',
		// 	'title'=> get_string('fweight', 'local_mb2builder'),
		// 	'min'=> 100,
		// 	'max' => 900,
		// 	'step' => 100,
		// 	'default'=> 600,
		// 	'action' => 'style',
		// 	'style_suffix' => 'none',
		// 	'changemode' => 'input',
		// 	'selector' => '.title',
		// 	'style_properity' => 'font-weight'
		// ),
		'fwcls'=>array(
			'type' => 'buttons',
			'section' => 'typo',
			'title'=> get_string('fweight', 'local_mb2builder'),
			'options' => array(
				'global' => get_string('global', 'local_mb2builder'),
				'light' => get_string('fwlight', 'local_mb2builder'),
				'normal' => get_string('normal', 'local_mb2builder'),
				'medium' => get_string('wmedium', 'local_mb2builder'),
				'bold' => get_string('fwbold', 'local_mb2builder')
			),
			'default' => 'global',
			'action' => 'class',
			'selector' => '.title',
			'class_remove' => 'fwglobal fwlight fwnormal fwmedium fwbold',
			'class_prefix' => 'fw'
		),
		'lhcls'=>array(
			'type' => 'buttons',
			'section' => 'typo',
			'title'=> get_string('lh', 'local_mb2builder'),
			'options' => array(
				'global' => get_string('global', 'local_mb2builder'),
				'small' => get_string('wsmall', 'local_mb2builder'),
				//'medium' => get_string('wmedium', 'local_mb2builder'),
				'normal' => get_string('normal', 'local_mb2builder')
			),
			'default' => 'global',
			'action' => 'class',
			'selector' => '.title',
			'class_remove' => 'lhglobal lhsmall lhmedium lhnormal',
			'class_prefix' => 'lh'
		),
		'lspacing'=>array(
			'type'=>'range',
			'section' => 'typo',
			'title'=> get_string('lspacing', 'local_mb2builder'),
			'min'=> -10,
			'max' => 30,
			'step' => 1,
			'default'=> 0,
			'action' => 'style',
			'changemode' => 'input',
			'selector' => '.title',
			'style_properity' => 'letter-spacing'
		),
		'wspacing'=>array(
			'type'=>'range',
			'section' => 'typo',
			'title'=> get_string('wspacing', 'local_mb2builder'),
			'min'=> -10,
			'max' => 30,
			'step' => 1,
			'default'=> 0,
			'action' => 'style',
			'changemode' => 'input',
			'selector' => '.title',
			'style_properity' => 'word-spacing'
		),
		'align'=>array(
			'type' => 'buttons',
			'section' => 'typo',
			'title'=> get_string('alignlabel', 'local_mb2builder'),
			'options' => array(
				'none' => get_string('none', 'local_mb2builder'),
				'left' => get_string('left', 'local_mb2builder'),
				'center' => get_string('center', 'local_mb2builder'),
				'right' => get_string('right', 'local_mb2builder')
			),
			'default' => 'none',
			'action' => 'class',
			'selector' => '.theme-title',
			'class_remove' => 'title-none title-left title-right title-center',
			'class_prefix' => 'title-'
		),
		'upper' => array(
			'type' => 'yesno',
			'section' => 'typo',
			'title'=> get_string('uppercase', 'local_mb2builder'),
			'options' => array(
				1 => get_string('yes', 'local_mb2builder'),
				0 => get_string('no', 'local_mb2builder')
			),
			'default' => 0,
			'action' => 'class',
			'selector' => '.title',
			'class_remove' => 'upper0 upper1',
			'class_prefix' => 'upper',
		),
		'color' => array(
			'type' => 'color',
			'section' => 'style',
			'title'=> get_string('color', 'local_mb2builder'),
			'action' => 'color',
			'selector' => '.title',
			'style_properity' => 'color'
		),
		'mt'=>array(
			'type'=>'range',
			'section' => 'style',
			'title'=> get_string('mt', 'local_mb2builder'),
			'min'=> 0,
			'max' => 300,
			'default'=> 0,
			'action' => 'style',
			'changemode' => 'input',
			'style_properity' => 'margin-top'
		),
		'mb'=>array(
			'type'=>'range',
			'section' => 'style',
			'title'=> get_string('mb', 'local_mb2builder'),
			'min'=> 0,
			'max' => 300,
			'default'=> 30,
			'action' => 'style',
			'changemode' => 'input',
			'style_properity' => 'margin-bottom'
		),
		'custom_class'=>array(
			'type'=>'text',
			'section' => 'style',
			'title'=> get_string('customclasslabel', 'local_mb2builder'),
			'desc'=> get_string('customclassdesc', 'local_mb2builder')
		)
	)
);


define('LOCAL_MB2BUILDER_SETTINGS_TITLE', base64_encode( serialize( $mb2_settings ) ));
