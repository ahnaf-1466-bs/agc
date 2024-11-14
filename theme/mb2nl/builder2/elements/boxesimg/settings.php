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
	'id' => 'boxesimg',
	'subid' => 'boxesimg_item',
	'title' => get_string('elboxesimg', 'local_mb2builder'),
	'icon' => 'fa fa-object-group',
	'type'=> 'general',
	'tabs' => array(
		'general' => get_string('generaltab', 'local_mb2builder'),
		'button' => get_string('button', 'local_mb2builder'),
		'style' => get_string('styletab', 'local_mb2builder')
	),
	'attr' => array(
		'type'=>array(
			'type'=>'list',
			'section' => 'general',
			'title'=> get_string('type', 'local_mb2builder'),
			'options' => array(
				0 => get_string( 'none', 'local_mb2builder' ),
				1 => get_string( 'typen', 'local_mb2builder', array( 'type' => 1 ) ),
				2 => get_string( 'typen', 'local_mb2builder', array( 'type' => 2 ) ),
				3 => get_string( 'typen', 'local_mb2builder', array( 'type' => 3 ) ),
				4 => get_string( 'typen', 'local_mb2builder', array( 'type' => 4 ) ),
				5 => get_string( 'typen', 'local_mb2builder', array( 'type' => 5 ) ),
				6 => get_string( 'typen', 'local_mb2builder', array( 'type' => 6 ) )
			),
			'default' => 1,
			'action' => 'class',
			'selector' => '.mb2-pb-element-inner',
			'class_remove' => 'type-0 type-1 type-2 type-3 type-4 type-5 type-6',
			'class_prefix' => 'type-',
		),
		'columns'=>array(
			'type'=>'range',
			'min' => 1,
			'max' => 5,
			'section' => 'general',
			'title'=> get_string('columns', 'local_mb2builder'),
			'default' => 4,
			'action' => 'class',
			'changemode' => 'input',
			'selector' => '.mb2-pb-element-inner',
			'class_remove' => 'theme-col-1 theme-col-2 theme-col-3 theme-col-4 theme-col-5',
			'class_prefix' => 'theme-col-',
		),
		'gutter'=>array(
			'type'=>'buttons',
			'section' => 'general',
			'title'=> get_string('grdwidth', 'local_mb2builder'),
			'options' => array(
				'normal' => get_string( 'normal', 'local_mb2builder' ),
				'thin' => get_string( 'thin', 'local_mb2builder' ),
				'none' => get_string( 'none', 'local_mb2builder' ),
			),
			'default' => 'normal',
			'action' => 'class',
			'selector' => '.mb2-pb-element-inner',
			'class_remove' => 'gutter-thin gutter-normal gutter-none',
			'class_prefix' => 'gutter-',
		),
		'imgwidth'=>array(
			'type'=>'range',
			'section' => 'general',
			'title'=> get_string('imgwidth', 'local_mb2builder'),
			'min'=> 20,
			'max' => 1200,
			'default'=> 800,
			'action' => 'style',
			'selector' => '.theme-boximg-img',
			'changemode' => 'input',
			'style_properity' => 'max-width'
		),
		'tfs'=>array(
			'type' => 'range',
			'section' => 'general',
			'title'=> get_string('titlefs', 'local_mb2builder'),
			'min'=> 1,
			'max' => 10,
			'step' => 0.01,
			'default'=> 1.4,
			'action' => 'style',
			'style_suffix' => 'none',
			'changemode' => 'input',
			'selector' => '.box-title',
			'style_properity' => 'font-size',
			'style_suffix' => 'rem',
			'numclass' => 1,
			'sizepref' => 'hsize'
		),
		'desc'=>array(
			'type'=>'yesno',
			'section' => 'general',
			'title'=> get_string('content', 'local_mb2builder'),
			'options' => array(
				1 => get_string('yes', 'local_mb2builder'),
				0 => get_string('no', 'local_mb2builder')
			),
			'action' => 'class',
			'selector' => '.mb2-pb-element-inner',
			'class_remove' => 'desc0 desc1',
			'class_prefix' => 'desc',
			'default' => 0
		),
		'rounded'=>array(
			'type'=>'yesno',
			'section' => 'general',
			'title'=> get_string('rounded', 'local_mb2builder'),
			'options' => array(
				1 => get_string('yes', 'local_mb2builder'),
				0 => get_string('no', 'local_mb2builder')
			),
			'action' => 'class',
			'selector' => '.mb2-pb-element-inner',
			'class_remove' => 'rounded0 rounded1',
			'class_prefix' => 'rounded',
			'default' => 0
		),
		'linkbtn'=>array(
			'type'=>'buttons',
			'section' => 'button',
			'title'=> get_string('readmorebtn', 'local_mb2builder'),
			'options' => array(
				0 => get_string('none', 'local_mb2builder'),
				1 => get_string('arrowbtn', 'local_mb2builder'),
				2 => get_string('button', 'local_mb2builder')
			),
			'action' => 'class',
			'selector' => '.mb2-pb-element-inner',
			'class_remove' => 'linkbtn0 linkbtn1 linkbtn2',
			'class_prefix' => 'linkbtn',
			'default' => 0
		),
		'btntype'=>array(
			'type'=>'list',
			'section' => 'button',
			'showon' => 'linkbtn:2',
			'title'=> get_string('type', 'local_mb2builder'),
			'options' => array(
				'default' => get_string('default', 'local_mb2builder'),
				'primary' => get_string('primary', 'local_mb2builder'),
				'secondary' => get_string('secondary', 'local_mb2builder'),
				'success' => get_string('success', 'local_mb2builder'),
				'warning' => get_string('warning', 'local_mb2builder'),
				'info' => get_string('info', 'local_mb2builder'),
				'danger' => get_string('danger', 'local_mb2builder'),
				'inverse' => get_string('inverse', 'local_mb2builder')
				//'link' => get_string('link', 'local_mb2builder')
			),
			'default' => 'primary',
			'action' => 'class',
			'selector' => '.box-readmore .mb2-pb-btn',
			'class_remove' => 'typeprimary typesecondary typesuccess typewarning typeinfo typedanger typeinverse',
			'class_prefix' => 'type',
		),
		'btnsize'=>array(
			'type' => 'buttons',
			'section' => 'button',
			'showon' => 'linkbtn:2',
			'title'=> get_string('sizelabel', 'local_mb2builder'),
			'options' => array(
				//'xs' => get_string('xsmall', 'local_mb2builder'),
				'sm' => get_string('small', 'local_mb2builder'),
				'normal' => get_string('medium', 'local_mb2builder'),
				'lg' => get_string('large', 'local_mb2builder'),
				'xlg' => get_string('xlarge', 'local_mb2builder')
			),
			'default' => 'normal',
			'action' => 'class',
			'selector' => '.box-readmore .mb2-pb-btn',
			'class_remove' => 'sizesm sizelg sizexlg sizenormal',
			'class_prefix' => 'size',
		),
		'btnfwcls'=>array(
			'type' => 'buttons',
			'showon' => 'linkbtn:2',
			'section' => 'button',
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
			'selector' => '.mb2-pb-btn',
			'class_remove' => 'fwglobal fwlight fwnormal fwmedium fwbold',
			'class_prefix' => 'fw'
		),
		'btnrounded' => array(
			'type' => 'yesno',
			'section' => 'button',
			'showon' => 'linkbtn:2',
			'title'=> get_string('rounded', 'local_mb2builder'),
			'options' => array(
				1 => get_string('yes', 'local_mb2builder'),
				0 => get_string('no', 'local_mb2builder')
			),
			'default' => 0,
			'action' => 'class',
			'selector' => '.box-readmore .mb2-pb-btn',
			'class_remove' => 'rounded0 rounded1',
			'class_prefix' => 'rounded',
		),
		'btnborder' => array(
			'type' => 'yesno',
			'section' => 'button',
			'showon' => 'linkbtn:2',
			'title'=> get_string('border', 'local_mb2builder'),
			'options' => array(
				1 => get_string('yes', 'local_mb2builder'),
				0 => get_string('no', 'local_mb2builder')
			),
			'default' => 0,
			'action' => 'class',
			'selector' => '.box-readmore .mb2-pb-btn',
			'class_remove' => 'btnborder0 btnborder1',
			'class_prefix' => 'btnborder',
		),
		'btntext'=>array(
			'type'=>'text',
			'section' => 'button',
			'showon' => 'linkbtn:1|2',
			'title'=> get_string('btntext', 'local_mb2builder'),
			'action' => 'text',
			'selector' => '.box-readmore a',
			'default' => get_string( 'readmorefp', 'local_mb2builder' )
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
			'default'=> 0,
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

	),
	'subelement' => array(
		'tabs' => array(
			'general' => get_string('generaltab', 'local_mb2builder'),
			'style' => get_string('styletab', 'local_mb2builder')
		),
		'attr' => array(
			'image'=>array(
				'type'=>'image',
				'section' => 'general',
				'title'=> get_string('image', 'local_mb2builder'),
				'action' => 'image',
				'selectorbg' => '.theme-boximg-imgel',
				'selector' => '.theme-boximg-img'
			),
			'text'=>array(
				'type'=>'text',
				'section' => 'general',
				'title'=> get_string('title', 'local_mb2builder'),
				'action' => 'text',
				'selector' => '.box-title-text'
			),
			'description'=>array(
				'type'=>'textarea',
				'section' => 'general',
				'title'=> get_string('text', 'local_mb2builder'),
				'action' => 'text',
				'selector' => '.box-desc',
				'default' => 'Box content here.'
			),
			'scheme' => array(
				'type' => 'buttons',
				'section' => 'style',
				'title'=> get_string('scheme', 'local_mb2builder'),
				'options' => array(
					'light' => get_string('light', 'local_mb2builder'),
					'dark' => get_string('dark', 'local_mb2builder')
				),
				'default' => 'dark',
				'action' => 'class',
				'selector' => '.theme-boximg',
				'class_remove' => 'light dark'
			),
			'el_onmobile' => array(
				'type' => 'yesno',
				'section' => 'style',
				'title'=> get_string('onmobile', 'local_mb2builder'),
				'options' => array(
					1 => get_string('yes', 'local_mb2builder'),
					0 => get_string('no', 'local_mb2builder')
				),
				'default' => 1,
				'action' => 'class',
				'class_remove' => 'el_onmobile0 el_onmobile1',
				'class_prefix' => 'el_onmobile'
			),
			'color'=>array(
				'type'=>'color',
				'section' => 'style',
				'title' => get_string('color', 'local_mb2builder'),
				'action' => 'color',
				'changemode' => 'input',
				'selector' => '.theme-boximg-color',
				'style_properity' => 'background-color'
			),
			'link'=>array(
				'type'=>'text',
				'section' => 'general',
				'title'=> get_string('link', 'local_mb2builder')
			),
			'link_target'=>array(
				'type'=>'yesno',
				'section' => 'general',
				'title'=> get_string('linknewwindow', 'local_mb2builder'),
				'options' => array(
					1 => get_string('yes', 'local_mb2builder'),
					0 => get_string('no', 'local_mb2builder')
				),
				'action' => 'none',
				'default' => 0
			)
		)
	)
);


define('LOCAL_MB2BUILDER_SETTINGS_BOXESIMG', base64_encode( serialize( $mb2_settings ) ));
