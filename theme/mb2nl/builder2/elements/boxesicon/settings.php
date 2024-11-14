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
	'id' => 'boxesicon',
	'subid' => 'boxesicon_item',
	'title' => get_string('elboxesicon', 'local_mb2builder'),
	'icon' => 'fa fa-rocket',
	'type'=> 'general',
	'tabs' => array(
		'general' => get_string('generaltab', 'local_mb2builder'),
		'tabtitle' => get_string('title', 'local_mb2builder'),
		'style' => get_string('styletab', 'local_mb2builder')
	),
	'attr' => array(
		'type'=>array(
			'type'=>'list',
			'section' => 'general',
			'title'=> get_string('type', 'local_mb2builder'),
			'options' => array(
				1 => get_string( 'typen', 'local_mb2builder', array( 'type' => 1 ) ),
				2 => get_string( 'typen', 'local_mb2builder', array( 'type' => 2 ) ),
				3 => get_string( 'typen', 'local_mb2builder', array( 'type' => 3 ) ),
				4 => get_string( 'typen', 'local_mb2builder', array( 'type' => 4 ) ),
				5 => get_string( 'typen', 'local_mb2builder', array( 'type' => 5 ) ),
				6 => get_string( 'typen', 'local_mb2builder', array( 'type' => 6 ) ),
				7 => get_string( 'typen', 'local_mb2builder', array( 'type' => 7 ) ),
				8 => get_string( 'typen', 'local_mb2builder', array( 'type' => 8 ) )
			),
			'default' => 1,
			'action' => 'class',
			'selector' => '.theme-boxicon',
			'class_remove' => 'type-1 type-2 type-3 type-4 type-5 type-6 type-7 type-8',
			'class_prefix' => 'type-',
			'globalparent' => 1
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
			'default' => 1
		),
		'tfs'=>array(
			'type' => 'range',
			'section' => 'tabtitle',
			'title'=> get_string('rowtextsize', 'local_mb2builder'),
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
		'tfw'=>array(
			'type' => 'buttons',
			'section' => 'tabtitle',
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
			'selector' => '.box-title',
			'class_remove' => 'fwglobal fwlight fwnormal fwmedium fwbold',
			'class_prefix' => 'fw'
		),
		'linkbtn'=>array(
			'type'=>'yesno',
			'section' => 'general',
			'title'=> get_string('readmorebtn', 'local_mb2builder'),
			'options' => array(
				1 => get_string('yes', 'local_mb2builder'),
				0 => get_string('no', 'local_mb2builder')
			),
			'action' => 'class',
			'selector' => '.mb2-pb-element-inner',
			'class_remove' => 'linkbtn0 linkbtn1',
			'class_prefix' => 'linkbtn',
			'default' => 0
		),
		'btntext'=>array(
			'type'=>'text',
			'section' => 'general',
			'showon' => 'linkbtn:1',
			'title'=> get_string('btntext', 'local_mb2builder'),
			'action' => 'text',
			'selector' => '.theme-boxicon-readmore a',
			'default' => get_string( 'readmorefp', 'local_mb2builder' )
		),
		'color'=>array(
			'type'=>'list',
			'section' => 'style',
			'title'=> get_string('color', 'local_mb2builder'),
			'options' => array(
				'primary' => get_string('primary', 'local_mb2builder'),
				'secondary' => get_string('secondary', 'local_mb2builder'),
				'success' => get_string('success', 'local_mb2builder'),
				'warning' => get_string('warning', 'local_mb2builder'),
				'info' => get_string('info', 'local_mb2builder'),
				'danger' => get_string('danger', 'local_mb2builder'),
				'inverse' => get_string('inverse', 'local_mb2builder')
			),
			'default' => 'primary',
			'action' => 'class',
			'selector' => '.theme-boxicon',
			'class_remove' => 'boxcolor-primary boxcolor-secondary boxcolor-success boxcolor-warning boxcolor-info boxcolor-danger boxcolor-inverse',
			'class_prefix' => 'boxcolor-',
		),
		'ccolor'=>array(
			'type'=>'color',
			'section' => 'style',
			'title' => get_string('color', 'local_mb2builder'),
			'action' => 'color',
			'changemode' => 'input',
			'selector' => '.theme-boxicon-icon',
			'style_properity' => 'color'
		),
		// 'smtitle'=>array(
		// 	'type'=>'yesno',
		// 	'section' => 'style',
		// 	'showon' => 'type:4',
		// 	'title'=> get_string('smtitle', 'local_mb2builder'),
		// 	'options' => array(
		// 		1 => get_string('yes', 'local_mb2builder'),
		// 		0 => get_string('no', 'local_mb2builder')
		// 	),
		// 	'action' => 'class',
		// 	'selector' => '.mb2-pb-element-inner',
		// 	'class_remove' => 'smtitle0 smtitle1',
		// 	'class_prefix' => 'smtitle',
		// 	'default' => 1
		// ),
		'wave'=>array(
			'type'=>'yesno',
			'section' => 'style',
			'title'=> get_string('wave', 'local_mb2builder'),
			'options' => array(
				1 => get_string('yes', 'local_mb2builder'),
				0 => get_string('no', 'local_mb2builder')
			),
			'action' => 'class',
			'selector' => '.mb2-pb-element-inner',
			'class_remove' => 'wave0 wave1',
			'class_prefix' => 'wave',
			'default' => 0
		),
		'rounded'=>array(
			'type'=>'yesno',
			'section' => 'style',
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
		'height'=>array(
			'type'=>'range',
			'section' => 'style',
			'title'=> get_string('height', 'local_mb2builder'),
			'min'=> 0,
			'max' => 500,
			'default'=> 0,
			'action' => 'style',
			'changemode' => 'input',
			'selector' => '.theme-boxicon',
			'style_properity' => 'min-height'
		),
		'boxmb'=>array(
			'type'=>'range',
			'section' => 'style',
			'title'=> get_string('boxmb', 'local_mb2builder'),
			'min'=> 0,
			'max' => 300,
			'default'=> 0,
			'action' => 'style',
			'changemode' => 'input',
			'selector' => '.theme-boxicon',
			'style_properity' => 'margin-bottom'
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
			'general' => get_string('generaltab', 'local_mb2builder')
		),
		'attr' => array(
			'icon'=>array(
				'type'=>'icon',
				'section' => 'general',
				'title'=> get_string('icon', 'local_mb2builder'),
				'action' => 'icon',
				'selector' => '.theme-boxicon-icon i,.bigicon i',
				'default' => 'fa fa-rocket'
			),
			'title'=>array(
				'type'=>'text',
				'section' => 'general',
				'title' => get_string('title', 'local_mb2builder'),
				'action' => 'text',
				'selector' => '.box-title',
				'default' => 'Box title here'
			),
			'content'=>array(
				'type'=>'textarea',
				'section' => 'general',
				'title'=> get_string('text', 'local_mb2builder'),
				'action' => 'text',
				'selector' => '.box-desc',
				'default' => 'Box content here.'
			),
			'ccolor'=>array(
				'type'=>'color',
				'showon2' => 'type:5',
				'section' => 'general',
				'title' => get_string('color', 'local_mb2builder'),
				'action' => 'color',
				'changemode' => 'input',
				'selector' => '.box-color',
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


define('LOCAL_MB2BUILDER_SETTINGS_BOXESICON', base64_encode( serialize( $mb2_settings ) ));
