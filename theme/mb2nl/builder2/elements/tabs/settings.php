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
	'id' => 'tabs',
	'subid' => 'tab_item',
	'title' => get_string('tabs', 'local_mb2builder'),
	'icon' => 'fa fa-th-large',
	'tabs' => array(
		'general' => get_string('generaltab', 'local_mb2builder'),
		'style' => get_string('styletab', 'local_mb2builder')
	),
	'attr' => array(
		'tabpos' => array(
			'type' => 'buttons',
			'section' => 'general',
			'title'=> get_string('tabpos', 'local_mb2builder'),
			'options' => array(
				'top' => get_string('top', 'local_mb2builder'),
				'left' => get_string('left', 'local_mb2builder'),
				'right' => get_string('right', 'local_mb2builder')
			),
			'default' => 'top',
			'action' => 'class',
			'class_remove' => 'top left right'
		),
		'isicon' => array(
			'type' => 'yesno',
			'section' => 'general',
			'title'=> get_string('icon', 'local_mb2builder'),
			'options' => array(
				1 => get_string('yes', 'local_mb2builder'),
				0 => get_string('no', 'local_mb2builder')
			),
			'default' => 0,
			'action' => 'class',
			'class_prefix' => 'isicon',
			'class_remove' => 'isicon0 isicon1',
			'globalparent' => 1
		),
		'icon'=>array(
			'type'=>'icon',
			'section' => 'general',
			'showon' => 'isicon:1',
			'title'=> get_string('icon', 'local_mb2builder'),
			'action' => 'icon',
			'default' => 'fa fa-trophy',
			'selector' => '.nav-link i',
			'globalparent' => 1
		),
		'height'=> array(
			'type'=>'range',
			'section' => 'general',
			'title'=> get_string('height', 'local_mb2builder'),
			'min' => 30,
			'max' => 1000,
			'default'=> 100,
			'action' => 'style',
			'changemode' => 'input',
			'selector' => '.tab-content',
			'style_properity' => 'min-height'
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
			'title' => array(
				'type' => 'text',
				'section' => 'general',
				'title'=> get_string('title', 'local_mb2builder'),
				'action' => 'text',
				'selector' => '.tab-text',
				'default' => 'Tab'
			),
			'icon'=>array(
				'type'=>'icon',
				'section' => 'general',
				'title'=> get_string('icon', 'local_mb2builder'),
				'action' => 'icon',
				'default' => '',
				'selector' => '.nav-link i',
				'globalchild' => 1
			),
			'text' => array(
				'type' => 'editor',
				'section' => 'general',
				'title'=> get_string('content', 'local_mb2builder'),
				'selector' => '.tab-pane.active',
				'default' => 'Tab content here'
			)
		)
	)
);


define('LOCAL_MB2BUILDER_SETTINGS_TABS', base64_encode( serialize( $mb2_settings ) ));
