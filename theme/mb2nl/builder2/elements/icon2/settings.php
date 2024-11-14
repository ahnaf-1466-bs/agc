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
	'id' => 'icon2',
	'subid' => '',
	'title' => get_string('icon', 'local_mb2builder'),
	'icon' => 'fa fa-heart',
	'tabs' => array(
		'general' => get_string('generaltab', 'local_mb2builder'),
		'style' => get_string('styletab', 'local_mb2builder')
	),
	'attr' => array(
		'name'=>array(
			'type'=>'icon',
			'section' => 'general',
			'title'=> get_string('icon', 'local_mb2builder'),
			'default' => 'fa fa-star',
			'action' => 'icon',
			'selector' => '.icon-bg i'
		),
		'desc'=>array(
			'type'=>'yesno',
			'section' => 'general',
			'title'=> get_string('text', 'local_mb2builder'),
			'options' => array(
				1 => get_string('yes', 'local_mb2builder'),
				0 => get_string('no', 'local_mb2builder')
			),
			'action' => 'class',
			'default' => 0,
			'class_prefix' => 'desc',
			'class_remove' => 'desc0 desc1'
		),
		'text' => array(
			'type' => 'text',
			'showon' => 'desc:1',
			'section' => 'general',
			'title'=> get_string('text', 'local_mb2builder'),
			'default' => 'Icon text here.',
			'action' => 'text',
			'selector' => '.icon-desc'
		),
		'size' => array(
			'type' => 'buttons',
			'section' => 'general',
			'title'=> get_string('sizelabel', 'local_mb2builder'),
			'options' => array(
				'n' => get_string('normal', 'local_mb2builder'),
				'l' => get_string('large', 'local_mb2builder'),
				'xl' => get_string('xlarge', 'local_mb2builder'),
				'xxl' => get_string('xxlarge', 'local_mb2builder')
			),
			'default' => 'default',
			'action' => 'class',
			'class_prefix' => 'size',
			'class_remove' => 'sizen sizel sizexl sizexxl'
		),
		'circle'=>array(
			'type'=>'yesno',
			'section' => 'general',
			'title'=> get_string('circle', 'local_mb2builder'),
			'options' => array(
				1 => get_string('yes', 'local_mb2builder'),
				0 => get_string('no', 'local_mb2builder')
			),
			'action' => 'class',
			'default' => 1,
			'class_prefix' => 'circle',
			'class_remove' => 'circle0 circle1'
		),

		/*


		'size'=>array(
			'type' => 'buttons',
			'section' => 'general',
			'title'=> get_string('sizelabel', 'local_mb2builder'),
			'options' => array(
				'default' => get_string('default', 'local_mb2builder'),
				'l' => get_string('large', 'local_mb2builder'),
				'xl' => get_string('xlarge', 'local_mb2builder'),
				'xxl' => get_string('xlarge', 'local_mb2builder')
			),
			'default' => 'default',
			'action' => 'class',
			'selector' => '.heading',
			'class_remove' => 'hsize-default hsize-l hsize-xl hsize-xxl',
			'class_prefix' => 'hsize-'
		),

		*/


		'color'=>array(
			'type'=>'color',
			'section' => 'general',
			'title'=> get_string('color', 'local_mb2builder'),
			'action' => 'color',
			'selector' => '.icon-bg',
			'style_properity' => 'color'
		),
		'bgcolor'=>array(
			'type'=>'color',
			'section' => 'general',
			'title'=> get_string('bgcolor', 'local_mb2builder'),
			'action' => 'color',
			'selector' => '.icon-bg',
			'style_properity' => 'background-color'
		),
		// 'spin' => array(
		// 	'type' => 'list',
		// 	'section' => 'general',
		// 	'title'=> get_string('spin', 'local_mb2builder'),
		// 	'options' => array(
		// 		1 => get_string('yes', 'local_mb2builder'),
		// 		0 => get_string('no', 'local_mb2builder')
		// 	),
		// 	'default' => 0
		// ),
		// 'rotate'=>array(
		// 	'type'=>'list',
		// 	'section' => 'general',
		// 	'title'=> get_string('rotate', 'local_mb2builder', array('rotate' => '')),
		// 	'options' => array(
		// 		0 => get_string('none', 'local_mb2builder'),
		// 		'rotate-90' => get_string('rotate', 'local_mb2builder', array('rotate' => 90)),
		// 		'rotate-180' => get_string('rotate', 'local_mb2builder', array('rotate' => 180)),
		// 		'rotate-270' => get_string('rotate', 'local_mb2builder', array('rotate' => 270)),
		// 		'flip-horizontal' => get_string('flip_hor', 'local_mb2builder'),
		// 		'flip-vertical' => get_string('flip_ver', 'local_mb2builder')
		// 	),
		// 	'default' => 0
		// ),
		// 'admin_label'=>array(
		// 	'type'=>'text',
		// 	'section' => 'general',
		// 	'title'=> get_string('adminlabellabel', 'local_mb2builder'),
		// 	'desc'=> get_string('adminlabeldesc', 'local_mb2builder'),
		// 	'default'=> get_string('icon', 'local_mb2builder')
		// ),
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


define( 'LOCAL_MB2BUILDER_SETTINGS_ICON2', base64_encode( serialize( $mb2_settings ) ) );
