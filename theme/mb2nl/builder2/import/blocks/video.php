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
	'id' => 'video',
	'title' => get_string( 'video', 'local_mb2builder' ),
	'items' => array(
		array(
			'name' => 'video-1',
			'thumb' => 'video-1',
			'tags' => 'importvideo tabs',
			'data' => '[{"type":"mb2pb_row","settings":{"id":"row","bgfixed":"0","colgutter":"s","prbg":"0","scheme":"light","rowhidden":"0","pt":"70","pb":"10","fw":"0","rowaccess":"0","elname":"Row"},"attr":[{"type":"mb2pb_col","settings":{"id":"column","col":"6","pt":"0","pb":"30","mobcenter":"0","moborder":"0","align":"none","height":"0","scheme":"light","elname":"Column"},"attr":[{"type":"mb2pb_el","settings":{"id":"videoweb","width":"770","videourl":"https://www.youtube.com/watch?v=RU5-s9Fexo4","ratio":"16:9","mt":"0","mb":"30","elname":"Video - web"},"attr":[]}]},{"type":"mb2pb_col","settings":{"id":"column","col":"6","pt":"0","pb":"30","mobcenter":"1","moborder":"0","align":"none","height":"0","scheme":"light","elname":"Column"},"attr":[{"type":"mb2pb_el","settings":{"id":"tabs","tabpos":"top","height":"100","isicon":"1","icon":"fa fa-trophy","mt":"0","mb":"21","elname":"Tabs"},"attr":[{"type":"mb2pb_subel","settings":{"id":"tabs_item","title":"Lorem ipsum","icon":"fa fa-graduation-cap","text":"<h4>Suspendisse pulvinar augue</h4><p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Curabitur aliquet quam id dui posuere blandit. Pellentesque in ipsum id orci porta dapibus. Curabitur aliquet quam id dui posuere blandit. Quisque velit nisi, pretium ut lacinia in, elementum id enim. Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed porttitor lectus nibh. Curabitur arcu erat, accumsan id imperdiet et, porttitor at sem. Vestibulum ante ipsum.</p>","elname":"Tabs item"},"attr":[]},{"type":"mb2pb_subel","settings":{"id":"tabs_item","title":"Vestibulum ante","icon":"fa fa-university","text":"<h4>Pellentesque commodo eros</h4><p>Vestibulum ante ipsum primis in faucibus orci luctus et ultrices posuere cubilia Curae; Donec velit neque, auctor sit amet aliquam vel, ullamcorper sit amet ligula. Vivamus magna justo, lacinia eget consectetur sed, convallis at tellus. Nulla quis lorem ut libero malesuada feugiat. Mauris blandit aliquet elit, eget tincidunt nibh pulvinar a. Cras ultricies ligula sed magna dictum porta. Curabitur arcu erat, accumsan id imperdiet et, porttitor.</p>","elname":"Tabs item"},"attr":[]},{"type":"mb2pb_subel","settings":{"id":"tabs_item","title":"Quisque libero","icon":"fa fa-book","text":"<h4>Aenean leo ligula porttitor</h4><p>Donec rutrum congue leo eget malesuada. Vestibulum ante ipsum primis in faucibus orci luctus et ultrices posuere cubilia Curae. Donec velit neque, auctor sit amet aliquam vel, ullamcorper sit amet ligula. Curabitur arcu erat, accumsan id imperdiet et, porttitor at sem. Mauris blandit aliquet elit. Mauris blandit aliquet elit, eget tincidunt nibh pulvinar a. Proin eget tortor risus. Vivamus suscipit tortor eget felis porttitor.</p>","elname":"Tabs item"},"attr":[]}]},{"type":"mb2pb_el","settings":{"id":"line","color":"dark","size":"1","double":"0","style":"dashed","mt":"0","mb":"28","elname":"Line"},"attr":[]},{"type":"mb2pb_el","settings":{"id":"button","type":"primary","size":"lg","link":"#","target":"0","fw":"0","fweight":"400","lspacing":"0","wspacing":"0","rounded":"0","upper":"0","ml":"0","mr":"15","mt":"0","mb":"15","border":"0","center":"0","text":"Read more","elname":"Button"},"attr":[]},{"type":"mb2pb_el","settings":{"id":"button","type":"success","size":"lg","link":"#","target":"0","fw":"0","fweight":"400","lspacing":"0","wspacing":"0","rounded":"0","upper":"0","ml":"0","mr":"0","mt":"0","mb":"15","border":"0","center":"0","text":"Apply now","elname":"Button"},"attr":[]}]}]}]'
		),
		array(
			'name' => 'video-2',
			'thumb' => 'video-2',
			'tags' => 'importvideo tabs',
			'data' => '[{"type":"mb2pb_row","settings":{"id":"row","bgcolor":"rgb(29, 53, 87)","bgfixed":"0","colgutter":"s","prbg":"0","scheme":"dark","rowhidden":"0","pt":"70","pb":"10","fw":"0","rowaccess":"0","elname":"Row"},"attr":[{"type":"mb2pb_col","settings":{"id":"column","col":"6","pt":"0","pb":"30","mobcenter":"1","moborder":"0","align":"none","height":"0","scheme":"light","elname":"Column"},"attr":[{"type":"mb2pb_el","settings":{"id":"tabs","tabpos":"top","height":"100","isicon":"1","icon":"fa fa-trophy","mt":"0","mb":"21","elname":"Tabs"},"attr":[{"type":"mb2pb_subel","settings":{"id":"tabs_item","title":"Lorem ipsum","icon":"fa fa-graduation-cap","text":"<h4>Suspendisse pulvinar augue</h4><p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Curabitur aliquet quam id dui posuere blandit. Pellentesque in ipsum id orci porta dapibus. Curabitur aliquet quam id dui posuere blandit. Quisque velit nisi, pretium ut lacinia in, elementum id enim. Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed porttitor lectus nibh. Curabitur arcu erat, accumsan id imperdiet et, porttitor at sem. Vestibulum ante ipsum.</p>","elname":"Tabs item"},"attr":[]},{"type":"mb2pb_subel","settings":{"id":"tabs_item","title":"Vestibulum ante","icon":"fa fa-university","text":"<h4>Pellentesque commodo eros</h4><p>Vestibulum ante ipsum primis in faucibus orci luctus et ultrices posuere cubilia Curae; Donec velit neque, auctor sit amet aliquam vel, ullamcorper sit amet ligula. Vivamus magna justo, lacinia eget consectetur sed, convallis at tellus. Nulla quis lorem ut libero malesuada feugiat. Mauris blandit aliquet elit, eget tincidunt nibh pulvinar a. Cras ultricies ligula sed magna dictum porta. Curabitur arcu erat, accumsan id imperdiet et, porttitor.</p>","elname":"Tabs item"},"attr":[]},{"type":"mb2pb_subel","settings":{"id":"tabs_item","title":"Quisque libero","icon":"fa fa-book","text":"<h4>Aenean leo ligula porttitor</h4><p>Donec rutrum congue leo eget malesuada. Vestibulum ante ipsum primis in faucibus orci luctus et ultrices posuere cubilia Curae. Donec velit neque, auctor sit amet aliquam vel, ullamcorper sit amet ligula. Curabitur arcu erat, accumsan id imperdiet et, porttitor at sem. Mauris blandit aliquet elit. Mauris blandit aliquet elit, eget tincidunt nibh pulvinar a. Proin eget tortor risus. Vivamus suscipit tortor eget felis porttitor.</p>","elname":"Tabs item"},"attr":[]}]},{"type":"mb2pb_el","settings":{"id":"line","color":"custom","custom_color":"rgba(255, 255, 255, 0.29)","size":"1","double":"0","style":"dashed","mt":"0","mb":"28","elname":"Line"},"attr":[]},{"type":"mb2pb_el","settings":{"id":"button","type":"primary","size":"lg","link":"#","target":"0","fw":"0","fweight":"400","lspacing":"0","wspacing":"0","rounded":"0","upper":"0","ml":"0","mr":"15","mt":"0","mb":"15","border":"0","center":"0","text":"Read more","elname":"Button"},"attr":[]},{"type":"mb2pb_el","settings":{"id":"button","type":"success","size":"lg","link":"#","target":"0","fw":"0","fweight":"400","lspacing":"0","wspacing":"0","rounded":"0","upper":"0","ml":"0","mr":"0","mt":"0","mb":"15","border":"0","center":"0","text":"Apply now","elname":"Button"},"attr":[]}]},{"type":"mb2pb_col","settings":{"id":"column","col":"6","pt":"0","pb":"30","mobcenter":"0","moborder":"0","align":"none","height":"0","scheme":"light","elname":"Column"},"attr":[{"type":"mb2pb_el","settings":{"id":"videoweb","width":"770","videourl":"https://www.youtube.com/watch?v=RU5-s9Fexo4","ratio":"16:9","mt":"0","mb":"30","elname":"Video - web"},"attr":[]}]}]}]'
		)
	)
);

define( 'LOCAL_MB2BUILDER_IMPORT_BLOCKS_VIDEO', base64_encode( serialize( $mb2_settings ) ) );
