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
 * @copyright  2018 Mariusz Boloz, marbol2 <mariuszboloz@gmail.com>
 * @license   Commercial https://themeforest.net/licenses
 */

defined('MOODLE_INTERNAL') || die();


$mb2_settings = array(
	'id' => 'testimonials',
	'subid' => 'testimonials_item',
	'title' => get_string('testimonials', 'local_mb2builder'),
	'icon' => 'fa fa-commenting',
	'tabs' => array(
		'general' => get_string('generaltab', 'local_mb2builder'),
		'carousel' => get_string('carouseltab', 'local_mb2builder'),
		'style' => get_string('styletab', 'local_mb2builder')
	),
	'attr' => array(
		'clayout' => array(
			'type'=>'buttons',
			'section' => 'general',
			'title'=> get_string('type', 'local_mb2builder'),
			'options' => array(
				1 => get_string( 'columns', 'local_mb2builder' ),
				2 => get_string( 'creative', 'local_mb2builder' ),
			),
			'default' => 2,
			'action' => 'callback',
			'callback' => 'carousel'
		),
		'columns'=>array(
			'type'=>'range',
			'section' => 'general',
			'showon' => 'clayout:1',
			'min' => 1,
			'max' => 5,
			'title'=> get_string('columns', 'local_mb2builder'),
			'default' => 4,
			'action' => 'callback',
			'callback' => 'carousel',
			'changemode' => 'input'
		),
		'mobcolumns' => array(
			'type' => 'yesno',
			'section' => 'general',
			'showon' => 'clayout:1',
			'title'=> get_string('mobcolumns', 'local_mb2builder'),
			'options' => array(
				1 => get_string('yes', 'local_mb2builder'),
				0 => get_string('no', 'local_mb2builder')
			),
			'default' => 1,
			'action' => 'callback',
			'callback' => 'carousel'
		),
		'gutter' => array(
			'type'=>'buttons',
			'section' => 'general',
			'showon' => 'clayout:1',
			'title'=> get_string('type', 'local_mb2builder'),
			'options' => array(
				'normal' => get_string( 'normal', 'local_mb2builder' ),
				'thin' => get_string( 'thin', 'local_mb2builder' ),
				'none' => get_string( 'none', 'local_mb2builder' ),
			),
			'default' => 'normal',
			'action' => 'callback',
			'callback' => 'carousel'
		),
		'isimage' => array(
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
		'isjob' => array(
			'type' => 'yesno',
			'section' => 'general',
			'title'=> get_string('job', 'local_mb2builder'),
			'options' => array(
				1 => get_string('yes', 'local_mb2builder'),
				0 => get_string('no', 'local_mb2builder')
			),
			'default' => 1,
			'action' => 'class',
			'class_remove' => 'isjob0 isjob1',
			'class_prefix' => 'isjob',
		),
		'iscompany' => array(
			'type' => 'yesno',
			'section' => 'general',
			'title'=> get_string('companyname', 'local_mb2builder'),
			'options' => array(
				1 => get_string('yes', 'local_mb2builder'),
				0 => get_string('no', 'local_mb2builder')
			),
			'default' => 1,
			'action' => 'class',
			'class_remove' => 'iscompany0 iscompany1',
			'class_prefix' => 'iscompany',
		),
		'animtime'=>array(
			'type'=>'number',
			'showon' => 'clayout:1',
			'section' => 'carousel',
			'min' => 300,
			'max' => 2000,
			'title'=> get_string('sanimate', 'local_mb2builder'),
			'default' => 600,
			'action' => 'callback',
			'callback' => 'carousel'
		),
		'pausetime'=>array(
			'type'=>'number',
			'section' => 'carousel',
			'showon' => 'clayout:1',
			'min' => 1000,
			'max' => 20000,
			'title'=> get_string('spausetime', 'local_mb2builder'),
			'default' => 7000,
			'action' => 'callback',
			'callback' => 'carousel'
		),
		'sloop' => array(
			'type' => 'yesno',
			'section' => 'carousel',
			'showon' => 'clayout:1',
			'title'=> get_string('loop', 'local_mb2builder'),
			'options' => array(
				1 => get_string('yes', 'local_mb2builder'),
				0 => get_string('no', 'local_mb2builder')
			),
			'default' => 0,
			'action' => 'callback',
			'callback' => 'carousel'
		),
		'autoplay' => array(
			'type' => 'yesno',
			'showon' => 'sloop:1',
			'section' => 'carousel',
			'title'=> get_string('autoplay', 'local_mb2builder'),
			'options' => array(
				1 => get_string('yes', 'local_mb2builder'),
				0 => get_string('no', 'local_mb2builder')
			),
			'default' => 0,
			'action' => 'callback',
			'callback' => 'carousel'
		),
		'sdots' => array(
			'type' => 'yesno',
			'section' => 'carousel',
			'title'=> get_string('pagernav', 'local_mb2builder'),
			'options' => array(
				1 => get_string('yes', 'local_mb2builder'),
				0 => get_string('no', 'local_mb2builder')
			),
			'default' => 1,
			'action' => 'class',
			'class_remove' => 'sdots0 sdots1',
			'class_prefix' => 'sdots',
		),
		'snav' => array(
			'type' => 'yesno',
			'section' => 'carousel',
			'title'=> get_string('dirnav', 'local_mb2builder'),
			'options' => array(
				1 => get_string('yes', 'local_mb2builder'),
				0 => get_string('no', 'local_mb2builder')
			),
			'default' => 0,
			'action' => 'class',
			'class_remove' => 'snav0 snav1',
			'class_prefix' => 'snav',
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
	),
	'subelement' => array(
		'tabs' => array(
			'general' => get_string('generaltab', 'local_mb2builder')
		),
		'attr' => array(
			'image' => array(
				'type' => 'image',
				'section' => 'general',
				'title'=> get_string('image', 'local_mb2builder'),
				'action' => 'image',
				'selector' => '.testimonial-image-src',
				'parent' => 1
			),
			'name' => array(
				'type' => 'text',
				'section' => 'general',
				'title'=> get_string('name', 'local_mb2builder'),
				'default' => 'Full Name',
				'action' => 'text',
				'selector' => '.testimonial-name',
				'parent' => 1
			),
			'job' => array(
				'type' => 'text',
				'section' => 'general',
				'title'=> get_string('job', 'local_mb2builder'),
				'default' => 'Moodle Dev',
				'action' => 'text',
				'selector' => '.testimonial-job',
				'parent' => 1
			),
			'companyname' => array(
				'type' => 'text',
				'section' => 'general',
				'title'=> get_string('companyname', 'local_mb2builder'),
				'default' => 'Company name',
				'action' => 'text',
				'selector' => '.testimonial-companyname',
				'parent' => 1
			),
			'rating' => array(
				'type'=>'buttons',
				'section' => 'general',
				'title'=> get_string('rating', 'local_mb2builder'),
				'options' => array(
					0 => get_string( 'none', 'local_mb2builder'),
					1 => get_string( 'star', 'local_mb2builder', 1 ),
					2 => get_string( 'star', 'local_mb2builder', 2 ),
					3 => get_string( 'star', 'local_mb2builder', 3 ),
					4 => get_string( 'star', 'local_mb2builder', 4 ),
					5 => get_string( 'star', 'local_mb2builder', 5 ),
				),
				'default' => 0,
				'action' => 'class',
				'selector' => '.rating-stars',
				'class_remove' => 'rating-0 rating-1 rating-2 rating-3 rating-4 rating-5',
				'class_prefix' => 'rating-',
				'parent' => 1
			),
			'text' => array(
				'type' => 'textarea',
				'section' => 'general',
				'title'=> get_string('content', 'local_mb2builder'),
				'action' => 'text',
				'defaut' => 'Testimonial content here.',
				'selector' => '.testimonial-text',
				'parent' => 1
			)
		)
	)
);


define('LOCAL_MB2BUILDER_SETTINGS_TESTIMONIALS', base64_encode( serialize( $mb2_settings ) ));
