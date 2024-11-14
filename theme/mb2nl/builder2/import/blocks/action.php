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
	'id' => 'action',
	'title' => get_string( 'action', 'local_mb2builder' ),
	'items' => array(
		array(
			'name' => 'action-1',
			'thumb' => 'action-1',
			'tags' => 'action',
			'data' => '[{"type":"mb2pb_row","settings":{"id":"row","bgcolor":"rgba(10, 9, 8, 0.75)","bgfixed":"0","colgutter":"s","prbg":"0","scheme":"dark","bgimage":"https://dummyimage.com/1900x800/b0ccd9/333.jpg","rowhidden":"0","pt":"60","pb":"0","fw":"0","rowaccess":"0","elname":"Row"},"attr":[{"type":"mb2pb_col","settings":{"id":"column","col":"8","pt":"0","pb":"30","mobcenter":"1","moborder":"0","align":"left","height":"0","scheme":"light","elname":"Column"},"attr":[{"type":"mb2pb_el","settings":{"id":"heading","tag":"h2","size":"1.8","align":"left","fweight":"600","lspacing":"0","wspacing":"0","upper":"1","mt":"13","mb":"30","content":"Fusce ac felis sit amet nam quam nunc blandit","elname":"Heading"},"attr":[]}]},{"type":"mb2pb_col","settings":{"id":"column","col":"4","pt":"0","pb":"30","mobcenter":"1","moborder":"0","align":"right","height":"0","scheme":"light","elname":"Column"},"attr":[{"type":"mb2pb_el","settings":{"id":"button","type":"success","size":"lg","link":"#","target":"0","fw":"0","fweight":"400","lspacing":"0","wspacing":"0","rounded":"0","upper":"0","ml":"0","mr":"0","mt":"0","mb":"30","border":"1","center":"0","text":"Apply now","elname":"Button"},"attr":[]}]}]}]'
		),
		array(
			'name' => 'action-2',
			'thumb' => 'action-2',
			'tags' => 'action',
			'data' => '[{"type":"mb2pb_row","settings":{"id":"row","bgcolor":"rgba(10, 17, 40, 0.85)","bgfixed":"0","colgutter":"s","prbg":"0","scheme":"dark","bgimage":"https://dummyimage.com/1900x800/b0ccd9/333.jpg","rowhidden":"0","pt":"70","pb":"25","fw":"0","rowaccess":"0","elname":"Row"},"attr":[{"type":"mb2pb_col","settings":{"id":"column","col":"12","pt":"0","pb":"30","mobcenter":"0","moborder":"0","align":"center","height":"0","scheme":"light","elname":"Column"},"attr":[{"type":"mb2pb_el","settings":{"id":"title","tag":"h2","align":"center","issubtext":"0","subtext":"Subtext here","size":"n","sizerem":"2.4","fweight":"600","lspacing":"0","wspacing":"0","upper":"1","style":"1","mt":"0","mb":"30","content":"Pellentesque habitant morbi?","elname":"Title"},"attr":[]},{"type":"mb2pb_el","settings":{"id":"text","size":"n","sizerem":"1.2","showtitle":"0","fweight":"400","lspacing":"0","wspacing":"0","upper":"0","title":"Title text","mt":"0","mb":"30","content":"<p>Etiam ultricies nisi vel augue. Aenean massa. Sed aliquam ultrices mauris. Phasellus magna. Fusce neque. Fusce neque. In enim justo, rhoncus ut, imperdiet a, venenatis vitae, justo. Curabitur at lacus ac velit ornare lobortis. Nam commodo suscipit quam.</p>","elname":"Text"},"attr":[]},{"type":"mb2pb_el","settings":{"id":"button","type":"primary","size":"lg","link":"#","target":"0","fw":"0","fweight":"400","lspacing":"0","wspacing":"0","rounded":"0","upper":"0","ml":"0","mr":"15","mt":"0","mb":"15","border":"0","center":"0","text":"Read more","elname":"Button"},"attr":[]},{"type":"mb2pb_el","settings":{"id":"button","type":"success","size":"lg","link":"#","target":"0","fw":"0","fweight":"400","lspacing":"0","wspacing":"0","rounded":"0","upper":"0","ml":"0","mr":"0","mt":"0","mb":"15","border":"1","center":"0","text":"Apply now","elname":"Button"},"attr":[]}]}]}]'
		)
	)
);

define( 'LOCAL_MB2BUILDER_IMPORT_BLOCKS_ACTION', base64_encode( serialize( $mb2_settings ) ) );
