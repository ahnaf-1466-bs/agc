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
	'id' => 'blog',
	'subid' => '',
	'title' => get_string('blog', 'local_mb2builder'),
	'icon' => 'fa fa-newspaper-o',
	'tabs' => array(
		'general' => get_string('generaltab', 'local_mb2builder'),
		'layouttab' => get_string('layouttab', 'local_mb2builder'),
		'carousel' => get_string('carouseltab', 'local_mb2builder'),
		'style' => get_string('styletab', 'local_mb2builder')
	),
	'attr' => array(

		'extags'=>array(
			'type'=>'list',
			'section' => 'general',
			'title'=> get_string('tags', 'local_mb2builder'),
			'options' => array(
				0 => get_string('showall', 'local_mb2builder'),
				'exclude' => get_string('exclude', 'local_mb2builder'),
				'include' => get_string('include', 'local_mb2builder')
			),
			'default' => 0,
			'action' => 'ajax'
		),
		'tagids'=>array(
			'type'=>'text',
			'section' => 'general',
			'showon' => 'extags:exclude|include',
			'title'=> get_string('tagids', 'local_mb2builder'),
			'desc'=> get_string('tagidsdesc', 'local_mb2builder'),
			'action' => 'ajax'
		),
		'exposts'=>array(
			'type'=>'list',
			'section' => 'general',
			'title'=> get_string('posts', 'local_mb2builder'),
			'options' => array(
				0 => get_string('showall', 'local_mb2builder'),
				'exclude' => get_string('exclude', 'local_mb2builder'),
				'include' => get_string('include', 'local_mb2builder')
			),
			'default' => 0,
			'action' => 'ajax'
		),
		'postids'=>array(
			'type'=>'text',
			'section' => 'general',
			'showon' => 'exposts:exclude|include',
			'title' => get_string('postids', 'local_mb2builder'),
			'desc' => get_string('postidsdesc', 'local_mb2builder'),
			'action' => 'ajax'
		),
		'postexternal' => array(
			'type'=>'yesno',
			'section' => 'general',
			'title'=> get_string('postexternal', 'local_mb2builder'),
			'options' => array(
				1 => get_string('yes', 'local_mb2builder'),
				0 => get_string('no', 'local_mb2builder')
			),
			'default' => 1,
			'action' => 'ajax'
		),
		'limit'=>array(
			'type'=>'number',
			'section' => 'general',
			'min' => 1,
			'max' => 99,
			'title'=> get_string('itemsperpage', 'local_mb2builder'),
			'default' => 4,
			'action' => 'ajax'
		),
		'layout' => array(
			'type' => 'list',
			'section' => 'layouttab',
			'title'=> get_string('layouttab', 'local_mb2builder'),
			'options' => array(
				//1 => get_string('modern', 'local_mb2builder'),
				2 => get_string('columns', 'local_mb2builder'),
				3 => get_string('carousel', 'local_mb2builder')
				//3 => get_string('carousel', 'local_mb2builder')
			),
			'default' => 2,
			'action' => 'ajax',
			'class_remove' => 'layout-1 layout-2',
			'class_prefix' => 'layout-',
			'advlayout' => 1
		),
		// 'carousel' => array(
		// 	'type'=>'yesno',
		// 	'showon' => 'layout:2',
		// 	'section' => 'layouttab',
		// 	'title'=> get_string('carousel', 'local_mb2builder'),
		// 	'options' => array(
		// 		1 => get_string('yes', 'local_mb2builder'),
		// 		0 => get_string('no', 'local_mb2builder')
		// 	),
		// 	'default' => 0,
		// 	'action' => 'callback',
		// 	'callback' => 'layout-carousel'
		// ),
		'columns'=>array(
			'type'=>'range',
			'section' => 'layouttab',
			'showon' => 'layout:2|3',
			'min' => 1,
			'max' => 5,
			'title'=> get_string('columns', 'local_mb2builder'),
			'default' => 4,
			'changemode' => 'input',
			'action' => 'class',
			'class_remove' => 'theme-col-1 theme-col-2 theme-col-3 theme-col-4 theme-col-5',
			'class_prefix' => 'theme-col-',
			'selector' => '.mb2-pb-content-list'
		),
		'gutter' => array(
			'type' => 'buttons',
			'section' => 'layouttab',
			'showon' => 'layout:2|3',
			'title'=> get_string('grdwidth', 'local_mb2builder'),
			'options' => array(
				'normal' => get_string('normal', 'local_mb2builder'),
				'thin' => get_string('thin', 'local_mb2builder'),
				'none' => get_string('none', 'local_mb2builder')
			),
			'default' => 'normal',
			'action' => 'callback',
			'callback' => 'carousel',
			'class_remove' => 'gutter-normal gutter-thin gutter-none',
			'class_prefix' => 'gutter-',
			'selector' => '.mb2-pb-content-list',
			'selector2' => '.superpost'
		),
		'superpost' => array(
			'type' => 'yesno',
			'section' => 'layouttab',
			'showon' => 'layout:2|3',
			'title'=> get_string('superpost', 'local_mb2builder'),
			'options' => array(
				1 => get_string('yes', 'local_mb2builder'),
				0 => get_string('no', 'local_mb2builder')
			),
			'default' => 0,
			'action' => 'ajax'
		),
		'desc'=>array(
			'type'=>'yesno',
			'section' => 'layouttab',
			'title'=> get_string('content', 'local_mb2builder'),
			'options' => array(
				1 => get_string('yes', 'local_mb2builder'),
				0 => get_string('no', 'local_mb2builder')
			),
			'action' => 'ajax',
			'default' => 1
		),
		'date' => array(
			'type' => 'yesno',
			'section' => 'layouttab',
			'title'=> get_string('date', 'local_mb2builder'),
			'options' => array(
				1 => get_string('yes', 'local_mb2builder'),
				0 => get_string('no', 'local_mb2builder')
			),
			'default' => 0,
			'action' => 'ajax'
		),
		'author' => array(
			'type' => 'yesno',
			'section' => 'layouttab',
			'title'=> get_string('author', 'local_mb2builder'),
			'options' => array(
				1 => get_string('yes', 'local_mb2builder'),
				0 => get_string('no', 'local_mb2builder')
			),
			'default' => 0,
			'action' => 'ajax'
		),
		// 'titlelimit'=>array(
		// 	'type'=>'number',
		// 	'section' => 'layouttab',
		// 	'min' => 1,
		// 	'max' => 999,
		// 	'title'=> get_string('titlelimit', 'local_mb2builder'),
		// 	'default' => 6,
		// 	'action' => 'ajax'
		// ),
		// 'desclimit'=>array(
		// 	'type'=>'number',
		// 	'section' => 'layouttab',
		// 	'min' => 0,
		// 	'max' => 999,
		// 	'title'=> get_string('desclimit', 'local_mb2builder'),
		// 	'default' => 25,
		// 	'action' => 'ajax'
		// ),
		// 'linkbtn' => array(
		// 	'type' => 'yesno',
		// 	'section' => 'layouttab',
		// 	'title'=> get_string('readmorebtn', 'local_mb2builder'),
		// 	'options' => array(
		// 		1 => get_string('yes', 'local_mb2builder'),
		// 		0 => get_string('no', 'local_mb2builder')
		// 	),
		// 	'default' => 0,
		// 	'action' => 'ajax'
		// ),

		// 'btntext'=>array(
		// 	'type'=>'text',
		// 	'section' => 'layouttab',
		// 	'showon' => 'linkbtn:1',
		// 	'title'=> get_string('btntext', 'local_mb2builder'),
		// 	'action' => 'text',
		// 	'selector' => '.mb2-pb-content-readmore a',
		// 	'default' => get_string( 'readmorefp', 'local_mb2builder' )
		// ),
		'animtime'=>array(
			'type'=>'number',
			'section' => 'carousel',
			'min' => 300,
			'max' => 2000,
			'title'=> get_string('sanimate', 'local_mb2builder'),
			'default' => 450,
			'action' => 'callback',
			'callback' => 'carousel'
		),
		'pausetime'=>array(
			'type'=>'number',
			'section' => 'carousel',
			'min' => 1000,
			'max' => 20000,
			'title'=> get_string('spausetime', 'local_mb2builder'),
			'default' => 5000,
			'action' => 'callback',
			'callback' => 'carousel'
		),
		'sloop' => array(
			'type' => 'yesno',
			'section' => 'carousel',
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
			'default' => 1,
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
			'default' => 0,
			'action' => 'callback',
			'callback' => 'carousel'
		),
		'snav' => array(
			'type' => 'yesno',
			'section' => 'carousel',
			'title'=> get_string('dirnav', 'local_mb2builder'),
			'options' => array(
				1 => get_string('yes', 'local_mb2builder'),
				0 => get_string('no', 'local_mb2builder')
			),
			'default' => 1,
			'action' => 'callback',
			'callback' => 'carousel'
		),
		// 'prestyle' => array(
		//     'type' => 'list',
		//     'section' => 'style',
		//     'title' => get_string('prestyle', 'local_mb2builder'),
		//     'options' => array(
		//         'none' => get_string('none', 'local_mb2builder'),
		//         'nlearning' => 'New Learning'
		//     ),
		// 	'default' => 'none',
		// 	'action' => 'class',
		// 	'class_remove' => 'prestylenone prestylenlearning',
		// 	'class_prefix' => 'prestyle',
		// 	'ignorecarousel' => 1
		// ),
		// 'colors'=>array(
		// 	'type'=>'textarea',
		// 	'section' => 'style',
		// 	'title'=> get_string('colors', 'local_mb2builder'),
		// 	'desc'=> get_string('colorsdesc', 'local_mb2builder'),
		// 	'action' => 'ajax'
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


define('LOCAL_MB2BUILDER_SETTINGS_BLOG', base64_encode( serialize( $mb2_settings ) ));
