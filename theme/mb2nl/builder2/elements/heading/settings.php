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
	'id' => 'heading',
	'subid' => '',
	'title' => get_string('elheading', 'local_mb2builder'),
	'icon' => 'fa fa-text-height',
	'tabs' => array(
		'general' => get_string('generaltab', 'local_mb2builder'),
		'typo' => get_string('typotab', 'local_mb2builder'),
		'typed' => get_string('typed', 'local_mb2builder'),
		'style' => get_string('styletab', 'local_mb2builder')
	),
	'attr' => array(
		'btext'=>array(
			'type'=>'text',
			'section' => 'general',
			'title'=> get_string('btext', 'local_mb2builder'),
			'action' => 'text',
			'selector' => '.btext'
		),
		'content'=>array(
			'type'=>'textarea',
			'section' => 'general',
			'title'=> get_string('text', 'local_mb2builder'),
			'action' => 'text',
			'selector' => '.headingtext',
			'default' => 'Heading text here'
		),
		'atext'=>array(
			'type'=>'text',
			'section' => 'general',
			'title'=> get_string('atext', 'local_mb2builder'),
			'action' => 'text',
			'selector' => '.atext'
		),
		'nline' => array(
			'type' => 'yesno',
			'section' => 'general',
			'title'=> get_string('nline', 'local_mb2builder'),
			'options' => array(
				1 => get_string('yes', 'local_mb2builder'),
				0 => get_string('no', 'local_mb2builder')
			),
			'default' => 0,
			'action' => 'class',
			'selector' => '.headingtext',
			'class_remove' => 'nline0 nline1',
			'class_prefix' => 'nline',
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
			'selector' => '.heading',
			'class_remove' => 'h1 h2 h3 h4 h5 h6'
		),
		'size'=>array(
			'type' => 'range',
			'section' => 'typo',
			'title'=> get_string('sizelabel', 'local_mb2builder'),
			'min'=> 1,
			'max' => 10,
			'step' => 0.01,
			'default'=> 2.4,
			'action' => 'style',
			'style_suffix' => 'none',
			'changemode' => 'input',
			'selector' => '.heading',
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
		// 	'selector' => '.heading',
		// 	'style_properity' => 'font-weight'
		// ),
		// 'lh'=>array(
		// 	'type'=>'range',
		// 	'section' => 'typo',
		// 	'title'=> get_string('lh', 'local_mb2builder'),
		// 	'min'=> 0.5,
		// 	'max' => 3,
		// 	'step' => .01,
		// 	'default'=> 1,
		// 	'action' => 'style',
		// 	'changemode' => 'input',
		// 	'selector' => '.heading',
		// 	'style_suffix' => 'none',
		// 	'style_properity' => 'line-height'
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
			'selector' => '.headingtext',
			'class_remove' => 'fwglobal fwlight fwnormal fwmedium fwbold',
			'class_prefix' => 'fw'
		),
		'bfwcls'=>array(
			'type' => 'buttons',
			'section' => 'typo',
			'title'=> get_string('bfwcls', 'local_mb2builder'),
			'options' => array(
				'global' => get_string('global', 'local_mb2builder'),
				'light' => get_string('fwlight', 'local_mb2builder'),
				'normal' => get_string('normal', 'local_mb2builder'),
				'medium' => get_string('wmedium', 'local_mb2builder'),
				'bold' => get_string('fwbold', 'local_mb2builder')
			),
			'default' => 'global',
			'action' => 'class',
			'selector' => '.btext',
			'class_remove' => 'fwglobal fwlight fwnormal fwmedium fwbold',
			'class_prefix' => 'fw'
		),
		'afwcls'=>array(
			'type' => 'buttons',
			'section' => 'typo',
			'title'=> get_string('afwcls', 'local_mb2builder'),
			'options' => array(
				'global' => get_string('global', 'local_mb2builder'),
				'light' => get_string('fwlight', 'local_mb2builder'),
				'normal' => get_string('normal', 'local_mb2builder'),
				'medium' => get_string('wmedium', 'local_mb2builder'),
				'bold' => get_string('fwbold', 'local_mb2builder')
			),
			'default' => 'global',
			'action' => 'class',
			'selector' => '.atext',
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
			'selector' => '.heading',
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
			'selector' => '.heading',
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
			'selector' => '.heading',
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
			'selector' => '.heading',
			'class_remove' => 'heading-none heading-left heading-right heading-center',
			'class_prefix' => 'heading-'
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
			'selector' => '.heading',
			'class_remove' => 'upper0 upper1',
			'class_prefix' => 'upper',
		),
		'typed' => array(
			'type' => 'yesno',
			'section' => 'typed',
			'title'=> get_string('typed', 'local_mb2builder'),
			'options' => array(
				1 => get_string('yes', 'local_mb2builder'),
				0 => get_string('no', 'local_mb2builder')
			),
			'default' => 0,
			'action' => 'callback',
			'callback' => 'typed'
		),
		'typedtext'=>array(
			'type'=>'textarea',
			'showon' => 'typed:1',
			'section' => 'typed',
			'title'=> get_string('typedtext', 'local_mb2builder'),
			'action' => 'attribute',
			'default' => 'first word|second word|third word'
		),
		'typespeed'=>array(
			'type'=>'number',
			'showon' => 'typed:1',
			'section' => 'typed',
			'min' => 0,
			'max' => 1000,
			'title'=> get_string('typespeed', 'local_mb2builder'),
			'default' => 50,
			'action' => 'attribute'
		),
		'backspeed'=>array(
			'type'=>'number',
			'showon' => 'typed:1',
			'section' => 'typed',
			'min' => 0,
			'max' => 1000,
			'title'=> get_string('backspeed', 'local_mb2builder'),
			'default' => 50,
			'action' => 'attribute'
		),
		'backdelay'=>array(
			'type'=>'number',
			'showon' => 'typed:1',
			'section' => 'typed',
			'min' => 100,
			'max' => 7000,
			'title'=> get_string('backdelay', 'local_mb2builder'),
			'default' => 1500,
			'action' => 'attribute'
		),
		'refreshtype'=>array(
			'type'=>'html',
			'showon' => 'typed:1',
			'section' => 'typed',
			'html'=> '<button class="mb2-pb-btn typesuccess fw1 mb2-pb-type-refresh" style="margin-top:18px;">' .
			get_string( 'refreshtype', 'local_mb2builder' ) . '</button>'
		),
		'color' => array(
			'type' => 'color',
			'section' => 'style',
			'title'=> get_string('color', 'local_mb2builder'),
			'action' => 'color',
			'selector' => '.headingtext',
			'style_properity' => 'color'
		),
		'bcolor' => array(
			'type' => 'color',
			'section' => 'style',
			'title'=> get_string('bcolor', 'local_mb2builder'),
			'action' => 'color',
			'selector' => '.btext',
			'style_properity' => 'color'
		),
		'acolor' => array(
			'type' => 'color',
			'section' => 'style',
			'title'=> get_string('acolor', 'local_mb2builder'),
			'action' => 'color',
			'selector' => '.atext',
			'style_properity' => 'color'
		),
		'width'=>array(
			'type'=>'range',
			'section' => 'style',
			'title'=> get_string('widthlabel', 'local_mb2builder'),
			'min'=> 0,
			'max' => 2000,
			'default'=> 2000,
			'action' => 'style',
			'changemode' => 'input',
			'style_properity' => 'max-width'
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


define( 'LOCAL_MB2BUILDER_SETTINGS_HEADING', base64_encode( serialize( $mb2_settings ) ) );
