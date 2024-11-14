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
	'id' => 'select',
	'subid' => 'select_item',
	'title' => get_string('select', 'local_mb2builder'),
	'icon' => 'fa fa-ellipsis-v',
	'type'=> 'general',
	'tabs' => array(
		'general' => get_string('generaltab', 'local_mb2builder'),
		'button' =>  get_string('button', 'local_mb2builder'),
		'style' => get_string('styletab', 'local_mb2builder')
	),
	'attr' => array(
		'layout'=>array(
			'type'=>'buttons',
			'section' => 'general',
			'title'=> get_string('layouttab', 'local_mb2builder'),
			'options' => array(
				'h' => get_string( 'horizontal', 'local_mb2builder' ),
				'v' => get_string( 'vertical', 'local_mb2builder' ),
			),
			'default' => 'normal',
			'action' => 'class',
			'class_remove' => 'layouth layoutv',
			'class_prefix' => 'layout',
		),
		'size'=>array(
			'type' => 'buttons',
			'section' => 'general',
			'title'=> get_string('sizelabel', 'local_mb2builder'),
			'options' => array(
				's' => get_string('small', 'local_mb2builder'),
				'l' => get_string('large', 'local_mb2builder')
			),
			'default' => 'l',
			'action' => 'class',
			'class_remove' => 'sizel sizes',
			'class_prefix' => 'size'
		),
		'label' => array(
			'type' => 'yesno',
			'section' => 'general',
			'title'=> get_string('label', 'local_mb2builder'),
			'options' => array(
				1 => get_string('yes', 'local_mb2builder'),
				0 => get_string('no', 'local_mb2builder')
			),
			'default' => 1,
			'action' => 'class',
			'class_remove' => 'label0 label1',
			'class_prefix' => 'label',
		),
		'labeltext'=>array(
			'type'=>'text',
			'showon' => 'label:1',
			'section' => 'general',
			'title'=> get_string('text', 'local_mb2builder'),
			'action' => 'text',
			'selector' => '.labeltext',
			'default' => 'Choose an option:'
		),
		'image' => array(
			'type' => 'yesno',
			'section' => 'general',
			'title'=> get_string('image', 'local_mb2builder'),
			'options' => array(
				1 => get_string('yes', 'local_mb2builder'),
				0 => get_string('no', 'local_mb2builder')
			),
			'default' => 1,
			'action' => 'class',
			'class_remove' => 'isimage0 isimage1',
			'class_prefix' => 'isimage',
		),
		'target'=>array(
			'type'=>'yesno',
			'section' => 'general',
			'title'=> get_string('linknewwindow', 'local_mb2builder'),
			'options' => array(
				1 => get_string('yes', 'local_mb2builder'),
				0 => get_string('no', 'local_mb2builder')
			),
			'action' => 'none',
			'default' => 0
		),
		'btntext'=>array(
			'type'=>'text',
			'section' => 'button',
			'title'=> get_string('text', 'local_mb2builder'),
			'action' => 'text',
			'selector' => '.mb2-pb-btn',
			'default' => 'Submit'
		),
		'btntype'=>array(
			'type'=>'list',
			'section' => 'button',
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
			),
			'default' => 'primary',
			'action' => 'class',
			'selector' => '.mb2-pb-btn',
			'class_remove' => 'typeprimary typesecondary typesuccess typewarning typeinfo typedanger typeinverse',
			'class_prefix' => 'type',
		),
		'btnrounded' => array(
			'type' => 'yesno',
			'section' => 'button',
			'title'=> get_string('rounded', 'local_mb2builder'),
			'options' => array(
				1 => get_string('yes', 'local_mb2builder'),
				0 => get_string('no', 'local_mb2builder')
			),
			'default' => 0,
			'action' => 'class',
			'selector' => '.mb2-pb-btn',
			'class_remove' => 'rounded0 rounded1',
			'class_prefix' => 'rounded',
		),
		'btnborder' => array(
			'type' => 'yesno',
			'section' => 'button',
			'title'=> get_string('border', 'local_mb2builder'),
			'options' => array(
				1 => get_string('yes', 'local_mb2builder'),
				0 => get_string('no', 'local_mb2builder')
			),
			'default' => 0,
			'action' => 'class',
			'selector' => '.mb2-pb-btn',
			'class_remove' => 'btnborder0 btnborder1',
			'class_prefix' => 'btnborder',
		),
		'btnfwcls'=>array(
			'type' => 'buttons',
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
		'width'=>array(
			'type'=>'range',
			'section' => 'style',
			'title'=> get_string('widthlabel', 'local_mb2builder'),
			'min'=> 20,
			'max' => 2000,
			'default'=> 800,
			'action' => 'style',
			'changemode' => 'input',
			'style_properity' => 'max-width'
		),
		'elcenter' => array(
			'type' => 'yesno',
			'section' => 'style',
			'title'=> get_string('center', 'local_mb2builder'),
			'options' => array(
				1 => get_string('yes', 'local_mb2builder'),
				0 => get_string('no', 'local_mb2builder')
			),
			'default' => 0,
			'action' => 'class',
			'class_remove' => 'elcenter0 elcenter1',
			'class_prefix' => 'elcenter',
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
			'desc'=> get_string('customclassdesc', 'local_mb2builder'),
			'default'=> ''
		),
	),
	'subelement' => array(
		'tabs' => array(
			'general' => get_string('generaltab', 'local_mb2builder')
		),
		'attr' => array(
			'itemtext'=>array(
				'type'=>'textarea',
				'section' => 'general',
				'title'=> get_string('text', 'local_mb2builder'),
				'action' => 'text',
				'default' => 'Select content',
				'selector' => '.select-text'
			),
			'image'=>array(
				'type'=>'image',
				'section' => 'general',
				'title'=> get_string('image', 'local_mb2builder'),
				'action' => 'image',
				'selector' => '.select-image'
			),
			'link'=>array(
				'type'=>'text',
				'section' => 'general',
				'title'=> get_string('link', 'local_mb2builder')
			)
		)
	)
);


define('LOCAL_MB2BUILDER_SETTINGS_SELECT', base64_encode( serialize( $mb2_settings ) ));
