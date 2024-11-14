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
	'id' => 'videolocal',
	'subid' => '',
	'title' => get_string('videolocal', 'local_mb2builder'),
	'icon' => 'fa fa-film',
	'type'=> 'general',
	'tabs' => array(
		'general' => get_string('generaltab', 'local_mb2builder')
	),
	'attr' => array(
		'videofile'=>array(
			'type'=>'image',
			'section' => 'general',
			'title'=> get_string('videofile', 'local_mb2builder'),
			'action' => 'image',
			'selector' => '.theme-videolocal-inner'
		),
		'width'=>array(
			'type'=>'range',
			'section' => 'general',
			'title'=> get_string('widthlabel', 'local_mb2builder'),
			'min'=> 20,
			'max' => 2000,
			'default'=> 800,
			'action' => 'style',
			'changemode' => 'input',
			'style_properity' => 'max-width'
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
			'default'=> 0,
			'action' => 'style',
			'changemode' => 'input',
			'style_properity' => 'margin-bottom'
		),
		'custom_class'=>array(
			'type'=>'text',
			'section' => 'general',
			'title'=> get_string('customclasslabel', 'local_mb2builder'),
			'desc'=> get_string('customclassdesc', 'local_mb2builder')
		)
	)
);


define( 'LOCAL_MB2BUILDER_SETTINGS_VIDEOLOCAL', base64_encode( serialize( $mb2_settings ) ) );
