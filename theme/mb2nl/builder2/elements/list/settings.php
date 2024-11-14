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
	'id' => 'list',
	'subid' => 'list_item',
	'title' => get_string('list', 'local_mb2builder'),
	'icon' => 'fa fa-list',
	'type'=> 'general',
	'tabs' => array(
		'general' => get_string('generaltab', 'local_mb2builder'),
		'typo' => get_string('typotab', 'local_mb2builder')
	),
	'attr' => array(
		'style'=>array(
			'type'=>'list',
			'section' => 'general',
			'title'=> get_string('type', 'local_mb2builder'),
			'options' => array(
				'none' => get_string('none', 'local_mb2builder'),
				'square' => get_string('square', 'local_mb2builder'),
				'circle' => get_string('circle', 'local_mb2builder'),
				'disc' => get_string('disc', 'local_mb2builder'),
				'number' => get_string('number', 'local_mb2builder')
			),
			'default' => 'disc',
			'action' => 'class',
			'selector' => '.theme-list',
			'class_remove' => 'list-square list-circle list-disc list-number',
			'class_prefix' => 'list-'
		),
		'horizontal' => array(
			'type' => 'yesno',
			'section' => 'general',
			'title'=> get_string('horizontal', 'local_mb2builder'),
			'options' => array(
				1 => get_string('yes', 'local_mb2builder'),
				0 => get_string('no', 'local_mb2builder')
			),
			'default' => 0,
			'action' => 'class',
			'selector' => '.theme-list',
			'class_remove' => 'horizontal0 horizontal1',
			'class_prefix' => 'horizontal'
		),
		'mt'=>array(
			'type'=>'range',
			'section' => 'general',
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
			'section' => 'general',
			'title'=> get_string('mb', 'local_mb2builder'),
			'min'=> 0,
			'max' => 300,
			'default'=> 30,
			'action' => 'style',
			'changemode' => 'input',
			'style_properity' => 'margin-bottom'
		),
		'color' => array(
			'type' => 'color',
			'section' => 'general',
			'title'=> get_string('color', 'local_mb2builder'),
			'action' => 'color',
			'style_properity' => 'color'
		),
		'custom_class'=>array(
			'type'=>'text',
			'section' => 'general',
			'title'=> get_string('customclasslabel', 'local_mb2builder'),
			'desc'=> get_string('customclassdesc', 'local_mb2builder'),
			'default'=> ''
		),
		'align'=>array(
			'type' => 'buttons',
			'section' => 'typo',
			'title'=> get_string('alignlabel', 'local_mb2builder'),
			'options' => array(
				'none' => get_string('none', 'local_mb2builder'),
				'left' => get_string('left', 'local_mb2builder'),
				'right' => get_string('right', 'local_mb2builder'),
				'center' => get_string('center', 'local_mb2builder')
			),
			'default' => 'none',
			'action' => 'class',
			'selector' => '.theme-list',
			'class_remove' => 'list-none list-left list-right list-center',
			'class_prefix' => 'list-'
		),
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
			'class_remove' => 'fwglobal fwlight fwnormal fwmedium fwbold',
			'class_prefix' => 'fw'
		),
	),
	'subelement' => array(
		'tabs' => array(
			'general' => get_string('generaltab', 'local_mb2builder')
		),
		'attr' => array(
			'text'=>array(
				'type'=>'textarea',
				'section' => 'general',
				'title'=> get_string('text', 'local_mb2builder'),
				'action' => 'text',
				'default' => 'List content here.',
				'selector' => '.list-text'
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


define('LOCAL_MB2BUILDER_SETTINGS_LIST', base64_encode( serialize( $mb2_settings ) ));
