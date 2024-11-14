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

defined( 'MOODLE_INTERNAL' ) || die();

$mb2_settings = array(
	'id' => 'search',
	'subid' => '',
	'title' => get_string('search', 'local_mb2builder'),
	'icon' => 'fa fa-search',
	'tabs' => array(
		'general' => get_string('generaltab', 'local_mb2builder'),
		'style' => get_string('styletab', 'local_mb2builder')
	),
	'attr' => array(

		'global'=>array(
			'type'=>'yesno',
			'section' => 'general',
			'title'=> get_string('globalsearch', 'local_mb2builder'),
			'options' => array(
				1 => get_string('yes', 'local_mb2builder'),
				0 => get_string('no', 'local_mb2builder')
			),
			'default' => 0,
			'action' => 'none'
		),
		'size'=>array(
			'type' => 'buttons',
			'section' => 'general',
			'title'=> get_string('sizelabel', 'local_mb2builder'),
			'options' => array(
				's' => get_string('small', 'local_mb2builder'),
				'n' => get_string('medium', 'local_mb2builder'),
				'l' => get_string('large', 'local_mb2builder')
			),
			'default' => 'n',
			'action' => 'class',
			'class_remove' => 'sizen sizel sizexl sizes',
			'class_prefix' => 'size'
		),
		'placeholder'=>array(
			'type'=> 'text',
			'section' => 'general',
			'title'=> get_string('placeholder', 'local_mb2builder'),
			'default' => get_string( 'searchcourses' ),
			'action' => 'attribute',
			'attribute' => 'placeholder',
			'selector' => 'input'
		),
		'rounded' => array(
			'type' => 'yesno',
			'section' => 'style',
			'title'=> get_string('rounded', 'local_mb2builder'),
			'options' => array(
				1 => get_string('yes', 'local_mb2builder'),
				0 => get_string('no', 'local_mb2builder')
			),
			'default' => 0,
			'action' => 'class',
			'class_remove' => 'rounded0 rounded1',
			'class_prefix' => 'rounded',
		),
		'border' => array(
			'type' => 'yesno',
			'section' => 'style',
			'title'=> get_string('border', 'local_mb2builder'),
			'options' => array(
				1 => get_string('yes', 'local_mb2builder'),
				0 => get_string('no', 'local_mb2builder')
			),
			'default' => 0,
			'action' => 'class',
			'class_remove' => 'border0 border1',
			'class_prefix' => 'border',
		),
		'width'=>array(
			'type'=>'range',
			'section' => 'style',
			'title'=> get_string('widthlabel', 'local_mb2builder'),
			'min'=> 200,
			'max' => 1500,
			'default'=> 750,
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


define( 'LOCAL_MB2BUILDER_SETTINGS_SEARCH', base64_encode( serialize( $mb2_settings ) ) );
