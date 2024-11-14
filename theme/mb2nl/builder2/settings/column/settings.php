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




$mb2_settings_col = array(
	'type'=>'general',
	'title'=>'',
	'tabs' => array(
		'general' => get_string('generaltab', 'local_mb2builder'),
		'style' => get_string('styletab', 'local_mb2builder')
	),
	'attr'=>array(

		'align' => array(
			'type' => 'buttons',
			'section' => 'general',
			'title'=> get_string('aligntext', 'local_mb2builder'),
			'options' => array(
				'none' => get_string('none', 'local_mb2builder'),
				'left' => get_string('left', 'local_mb2builder'),
				'center' => get_string('center', 'local_mb2builder'),
				'right' => get_string('right', 'local_mb2builder')
			),
			'default' => 'none',
			'action' => 'class',
			'class_remove' => 'align-none align-left align-right align-center',
			'class_prefix' => 'align-',
		),
		'alignc' => array(
			'type' => 'buttons',
			'section' => 'general',
			'title'=> get_string('aligncolumn', 'local_mb2builder'),
			'options' => array(
				'none' => get_string('none', 'local_mb2builder'),
				'left' => get_string('left', 'local_mb2builder'),
				'center' => get_string('center', 'local_mb2builder'),
				'right' => get_string('right', 'local_mb2builder')
			),
			'default' => 'none',
			'action' => 'class',
			'class_remove' => 'aligncnone aligncleft aligncright alignccenter',
			'class_prefix' => 'alignc',
		),

		// 'aos'=>array(
		// 	'type'=>'list',
		// 	'section' => 'general',
		// 	'title'=> get_string('type', 'local_mb2builder'),
		// 	'options' => array(
		// 		0 => get_string( 'none', 'local_mb2builder' ),
		// 		'fade-up' => 'fade-up',
		// 		'fade-right' => 'fade-right',
		// 		'flip-left' => 'flip-left'
		// 	),
		// 	'default' => 0,
		// 	'action' => 'animation'
		// ),

		'spacer_col1'=>array( 'type'=> 'spacer', 'section' => 'general' ),

		'mobcenter' => array(
			'type' => 'yesno',
			'section' => 'general',
			'title'=> get_string('mobcenter', 'local_mb2builder'),
			'options' => array(
				1 => get_string('yes', 'local_mb2builder'),
				0 => get_string('no', 'local_mb2builder')
			),
			'default' => 0,
			'action' => 'class',
			'class_remove' => 'mobcenter0 mobcenter1',
			'class_prefix' => 'mobcenter',
		),
		'moborder'=>array(
			'type'=>'range',
			'section' => 'general',
			'title'=> get_string('moborder', 'local_mb2builder'),
			'min'=> 0,
			'max' => 4,
			'default'=> 0,
			'action' => 'class',
			'changemode' => 'input',
			'class_remove' => 'moborder0 moborder1 moborder2 moborder3 moborder4',
			'class_prefix' => 'moborder',
		),
		'spacer_col2'=>array( 'type'=> 'spacer', 'section' => 'general' ),
		'height'=>array(
			'type'=>'range',
			'section' => 'general',
			'title'=> get_string('height', 'local_mb2builder'),
			'min'=> 0,
			'max' => 900,
			'default'=> 0,
			'action' => 'style',
			'changemode' => 'input',
			'style_properity' => 'min-height'
		),
		'width'=>array(
			'type'=>'range',
			'section' => 'general',
			'title'=> get_string('widthlabel', 'local_mb2builder'),
			'min'=> 50,
			'max' => 2000,
			'default'=> 2000,
			'action' => 'style',
			'changemode' => 'input',
			'selector' => '.column-inner',
			'style_properity' => 'max-width'
		),
		'pt'=>array(
			'type'=>'range',
			'section' => 'general',
			'title'=> get_string('ptlabel', 'local_mb2builder'),
			'min'=> 0,
			'max' => 300,
			'default'=> 0,
			'action' => 'style',
			'changemode' => 'input',
			'selector' => '.column-inner',
			'style_properity' => 'padding-top'
		),
		'pb'=>array(
			'type'=>'range',
			'section' => 'general',
			'title'=> get_string('pblabel', 'local_mb2builder'),
			'min'=> 0,
			'max' => 300,
			'default'=> 30,
			'action' => 'style',
			'changemode' => 'input',
			'selector' => '.column-inner',
			'style_properity' => 'padding-bottom'
		),
		// 'ph'=>array(
		// 	'type'=>'range',
		// 	'section' => 'general',
		// 	'title'=> get_string('phlabel', 'local_mb2builder'),
		// 	'min'=> 0,
		// 	'max' => 300,
		// 	'default'=> 0,
		// 	'action' => 'style',
		// 	'changemode' => 'input',
		// 	'selector' => '.column-inner',
		// 	'style_properity' => 'padding-left',
		// 	'style_properity2' => 'padding-right',
		// 	'numclass' => 1,
		// 	'numclassattr' => 'phcls',
		// 	'numclasselector' => 'column',
		// 	'sizepref' => 'phcls',
		// 	'setval' => 'phcls'
		// ),
		// 'phcls'=>array(
		// 	'type'=>'hidden',
		// 	'section' => 'general',
		// 	'default'=> 0,
		// ),
		'scheme' => array(
			'type' => 'buttons',
			'section' => 'style',
			'title'=> get_string('scheme', 'local_mb2builder'),
			'options' => array(
				'light' => get_string('light', 'local_mb2builder'),
				'dark' => get_string('dark', 'local_mb2builder')
			),
			'default' => 'light',
			'action' => 'class',
			'class_remove' => 'light dark'
		),
		'bgcolor' => array(
			'type' => 'color',
			'section' => 'style',
			'title'=> get_string('bgcolor', 'local_mb2builder'),
			'action' => 'color',
			'selector' => '.column-inner-bg',
			'style_properity' => 'background-color'
		),
		'bgimage' => array(
			'type' => 'image',
			'section' => 'style',
			'title'=> get_string('bgimage', 'local_mb2builder'),
			'action' => 'image',
			'style_properity' => 'background-image'
		),
		'custom_class'=>array(
			'type'=>'text',
			'section' => 'style',
			'title'=> get_string('customclasslabel', 'local_mb2builder'),
			'desc'=> get_string('customclassdesc', 'local_mb2builder'),
			'default'=> ''
		)

	)
);

define('LOCAL_MB2BUILDER_SETTINGS_COL', base64_encode( serialize( $mb2_settings_col ) ) );
