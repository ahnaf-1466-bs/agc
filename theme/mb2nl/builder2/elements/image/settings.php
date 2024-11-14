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
	'id' => 'image',
	'subid' => '',
	'title' => get_string('image', 'local_mb2builder'),
	'icon' => 'fa fa-picture-o',
	'tabs' => array(
		'general' => get_string('generaltab', 'local_mb2builder'),
		'style' => get_string('styletab', 'local_mb2builder')
	),
	'attr' => array(
		'text'=>array(
			'type' => 'image',
			'section' => 'general',
			'title'=> get_string('image', 'local_mb2builder'),
			'action' => 'image',
			'selector' => '.mb2-image-src'
		),
		'alt'=>array(
			'type'=>'text',
			'section' => 'general',
			'title' => get_string('alttext', 'local_mb2builder')
		),
		'caption' => array(
			'type' => 'yesno',
			'section' => 'general',
			'title'=> get_string('caption', 'local_mb2builder'),
			'options' => array(
				1 => get_string('yes', 'local_mb2builder'),
				0 => get_string('no', 'local_mb2builder')
			),
			'default' => 0,
			'action' => 'class',
			'class_remove' => 'caption0 caption1',
			'class_prefix' => 'caption'
		),
		'captiontext' => array(
			'type' => 'text',
			'section' => 'general',
			'showon' => 'caption:1',
			'title'=> get_string('caption', 'local_mb2builder'),
			'action' => 'text',
			'selector' => '.caption',
			'default' => 'Caption text here'
		),
		'width'=>array(
			'type'=>'range',
			'section' => 'general',
			'title'=> get_string('widthlabel', 'local_mb2builder'),
			'min'=> 20,
			'max' => 2000,
			'default'=> 450,
			'action' => 'style',
			'changemode' => 'input',
			'style_properity' => 'width'
		),
		'center'=>array(
			'type' => 'yesno',
			'section' => 'general',
			'title'=> get_string('center', 'local_mb2builder'),
			'options' => array(
				1 => get_string('yes', 'local_mb2builder'),
				0 => get_string('no', 'local_mb2builder')
			),
			'default' => 1,
			'action' => 'class',
			'class_remove' => 'center0 center1',
			'class_prefix' => 'center'
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
			'default' => 0,
			'action' => 'none'
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


define( 'LOCAL_MB2BUILDER_SETTINGS_IMAGE', base64_encode( serialize( $mb2_settings ) ) );
