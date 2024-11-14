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
	'id' => 'hero',
	'title' => get_string( 'hero', 'local_mb2builder' ),
	'items' => array(
		array(
			'name' => 'hero-1',
			'thumb' => 'hero-1',
			'tags' => 'hero video',
			'data' => '[{"type":"mb2pb_row","settings":{"id":"row","bgcolor":"rgba(2, 32, 54, 0.65)","bgfixed":"0","colgutter":"s","prbg":"0","scheme":"dark","bgimage":"https://dummyimage.com/1900x1300/6f7076/333.jpg","rowhidden":"0","pt":"120","pb":"70","fw":"0","rowaccess":"0","elname":"Row"},"attr":[{"type":"mb2pb_col","settings":{"id":"column","col":"6","pt":"0","pb":"30","mobcenter":"1","moborder":"0","align":"left","height":"0","scheme":"light","elname":"Column"},"attr":[{"type":"mb2pb_el","settings":{"id":"heading","tag":"h2","size":"2.8","align":"left","fweight":"600","lspacing":"0","wspacing":"0","upper":"0","mt":"0","mb":"20","content":"Pellentesque libero tortor","elname":"Heading"},"attr":[]},{"type":"mb2pb_el","settings":{"id":"text","align":"left","size":"n","sizerem":"1.2","showtitle":"0","fweight":"400","lspacing":"0","wspacing":"0","upper":"0","title":"Title text","mt":"0","mb":"30","content":"<p>Fusce vel dui. Aenean leo ligula, porttitor eu, consequat vitae, eleifend ac, enim. Nunc nulla. Duis vel nibh at velit scelerisque suscipit. Praesent turpis.</p>","elname":"Text"},"attr":[]},{"type":"mb2pb_el","settings":{"id":"button","type":"primary","size":"xlg","link":"#","target":"0","fw":"0","fweight":"400","lspacing":"0","wspacing":"0","rounded":"0","upper":"0","ml":"0","mr":"0","mt":"0","mb":"20","border":"0","center":"0","text":"Start learning now","elname":"Button"},"attr":[]}]},{"type":"mb2pb_col","settings":{"id":"column","col":"6","pt":"0","pb":"30","mobcenter":"0","moborder":"0","align":"left","height":"0","scheme":"light","elname":"Column"},"attr":[]}]}]'
		),
		array(
			'name' => 'hero-2',
			'thumb' => 'hero-2',
			'tags' => 'hero',
			'data' => '[{"type":"mb2pb_row","settings":{"id":"row","bgcolor":"rgba(10, 9, 8, 0.65)","bgfixed":"0","colgutter":"s","prbg":"0","scheme":"dark","bgimage":"https://dummyimage.com/1900x1300/6f7076/333.jpg","rowhidden":"0","pt":"120","pb":"60","fw":"0","rowaccess":"0","elname":"Row"},"attr":[{"type":"mb2pb_col","settings":{"id":"column","col":"12","pt":"0","pb":"30","mobcenter":"1","moborder":"0","align":"center","height":"0","scheme":"light","elname":"Column"},"attr":[{"type":"mb2pb_el","settings":{"id":"heading","tag":"h4","size":"3.5","align":"none","fweight":"700","lspacing":"0","wspacing":"0","upper":"1","mt":"0","mb":"16","content":"Suspendisse pulvinar augue ac venenatis","elname":"Heading"},"attr":[]},{"type":"mb2pb_el","settings":{"id":"text","align":"none","size":"n","sizerem":"1.6","showtitle":"0","fweight":"400","lspacing":"0","wspacing":"0","upper":"0","title":"Title text","mt":"0","mb":"30","content":"<p>Donec rutrum congue leo eget malesuada nulla quis lorem ut libero</p>","elname":"Text"},"attr":[]},{"type":"mb2pb_el","settings":{"id":"button","type":"primary","size":"xlg","link":"#","target":"0","fw":"0","fweight":"400","lspacing":"0","wspacing":"0","rounded":"0","upper":"0","ml":"0","mr":"0","mt":"0","mb":"15","border":"0","center":"0","text":"Start study now","elname":"Button"},"attr":[]}]}]}]'
		),
		array(
			'name' => 'hero-3',
			'thumb' => 'hero-3',
			'tags' => 'hero search',
			'data' => '[{"type":"mb2pb_row","settings":{"id":"row","bgcolor":"rgba(10, 9, 8, 0.62)","bgfixed":"0","colgutter":"normal","prbg":"0","scheme":"dark","bgimage":"https://dummyimage.com/1900x1300/6f7076/333.jpg","rowhidden":"0","pt":"120","pb":"60","fw":"0","rowaccess":"0","elname":"Row"},"attr":[{"type":"mb2pb_col","settings":{"id":"column","col":"12","pt":"0","pb":"30","mobcenter":"1","moborder":"0","align":"center","height":"0","scheme":"light","elname":"Column"},"attr":[{"type":"mb2pb_el","settings":{"id":"heading","tag":"h4","size":"3.5","align":"none","fweight":"700","lspacing":"0","wspacing":"0","upper":"1","mt":"0","mb":"16","content":"Suspendisse pulvinar augue ac venenatis","elname":"Heading"},"attr":[]},{"type":"mb2pb_el","settings":{"id":"text","align":"none","size":"n","sizerem":"1.6","showtitle":"0","fweight":"400","lspacing":"0","wspacing":"0","upper":"0","title":"Title text","mt":"0","mb":"30","content":"<p>Donec rutrum congue leo eget malesuada nulla quis lorem ut libero</p>","elname":"Text"},"attr":[]},{"type":"mb2pb_el","settings":{"id":"search","placeholder":"Search courses","global":"0","rounded":"0","width":"750","size":"n","mt":"0","mb":"30","elname":"Search"},"attr":[]}]}]}]'
		),
		array(
			'name' => 'hero-4',
			'thumb' => 'hero-4',
			'tags' => 'hero',
			'data' => '[{"type":"mb2pb_row","settings":{"id":"row","bgcolor":"rgb(202, 233, 255)","bgfixed":"0","colgutter":"s","prbg":"0","scheme":"light","heroimg":"1","heroimgurl":"https://dummyimage.com/1030x980/bddcf2/333.jpg","herov":"center","herow":"571","heroml":"55","herogradl":"0","herogradr":"0","bgtext":"0","bgtextmob":"0","bgtexttext":"Sample text","btsize":"290","btfweight":"600","btlh":"1","btlspacing":"0","btwspacing":"0","btupper":"0","bth":"left","btv":"center","btcolor":"rgba(0, 0, 0, 0.05)","rowhidden":"0","pt":"190","pb":"140","fw":"0","va":"0","parallax":"0","rowaccess":"0","wave":"0","wavecolor":"#ffffff","wavepos":"1","wavefliph":"1","wavetop":"0","wavewidth":"269","waveheight":"21","waveover":"1","mt":"0","elname":"Row"},"attr":[{"type":"mb2pb_col","settings":{"id":"column","col":"7","pt":"0","pb":"30","mobcenter":"1","moborder":"0","align":"left","height":"0","scheme":"light","elname":"Column"},"attr":[{"type":"mb2pb_el","settings":{"id":"heading","tag":"h2","size":"3","align":"left","fweight":"600","lspacing":"0","wspacing":"0","upper":"0","mt":"0","mb":"20","width":"2000","lh":"1","content":"Study online with New Learning","elname":"Heading"},"attr":[]},{"type":"mb2pb_el","settings":{"id":"text","align":"left","size":"n","sizerem":"1.25","color":"rgb(0, 0, 0)","showtitle":"0","fweight":"400","lh":"1.7","lspacing":"0","wspacing":"0","tupper":"0","tfw":"600","tlh":"1.2","tlspacing":"0","twspacing":"0","tsizerem":"1.4","upper":"0","title":"Title text","mt":"0","mb":"30","pv":"0","ph":"0","tmb":"30","width":"2000","rounded":"0","button":"0","btype":"primary","bsize":"normal","link":"#","target":"0","brounded":"0","bmt":"0","bborder":"0","btext":"Read more","scheme":"light","content":"<p>Taking your online and distance learning to new heights. Accounting, graphic design, business management and more...</p>","elname":"Text"},"attr":[]},{"type":"mb2pb_el","settings":{"id":"button","type":"primary","size":"xlg","link":"#","target":"0","fw":"0","fweight":"400","lspacing":"0","wspacing":"0","rounded":"0","upper":"0","ml":"0","mr":"20","mt":"0","mb":"20","border":"0","center":"0","text":"Discover more","elname":"Button"},"attr":[]},{"type":"mb2pb_el","settings":{"id":"button","type":"primary","size":"xlg","link":"#","target":"0","fw":"0","fweight":"400","lspacing":"0","wspacing":"0","rounded":"0","upper":"0","ml":"0","mr":"0","mt":"0","mb":"20","border":"1","center":"0","text":"Start learning now","elname":"Button"},"attr":[]}]},{"type":"mb2pb_col","settings":{"id":"column","col":"5","pt":"0","pb":"30","mobcenter":"0","moborder":"0","align":"left","height":"0","scheme":"light","elname":"Column"},"attr":[]}]}]'
		)

	)
);

define( 'LOCAL_MB2BUILDER_IMPORT_BLOCKS_HERO', base64_encode( serialize( $mb2_settings ) ) );
