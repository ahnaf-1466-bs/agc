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
 * @package   theme_mb2cg2
 * @copyright 2017 Mariusz Boloz (http://marbol2.com)
 * @license   Commercial https://themeforest.net/licenses
 *
 */

defined('MOODLE_INTERNAL') || die();

require_once( $CFG->dirroot . '/local/mb2builder/lib.php' );
require_once( $CFG->dirroot . '/local/mb2builder/classes/layouts_api.php' );


if ( ! class_exists( 'mb2builderApi' ) )
{

	class mb2builderApi
	{



		/*
		 *
		 * Method to get required fields
		 *
		 */
		 public static function get_fields()
		 {
			 global $CFG;

			 $fieldsdir = $CFG->dirroot . '/local/mb2builder/builder/fields/';

			 foreach ( scandir( $fieldsdir ) as $type )
	 		 {
				 $file_type = pathinfo( $type, PATHINFO_EXTENSION );

	 			 if ( $file_type === 'php' )
	 			 {
					 require_once ( $fieldsdir . basename( $type ) );
	 			 }
			 }

		 }






		 /*
 		  *
 		  * Method to get settings of bulder elements
 		  *
 		  */
		  public static function get_element_settings()
 		  {

			 foreach ( self::get_elements() as $el )
			 {
				 if ( file_exists( LOCAL_MB2BUILDER_PATH_THEME_ELEMENTS . $el . '/settings.php' ) )
	 			 {
	 				 require_once ( LOCAL_MB2BUILDER_PATH_THEME_ELEMENTS . $el . '/settings.php' );
	 			 }
	 		 }

 		  }








		  /*
  		   *
  		   * Method to get settings of staic elements. Secion, row, column
  		   *
  		   */
 		  public static function get_static_elements_settings()
  		  {
			  global $CFG;

			  $elements = array( 'section', 'row', 'column' );

			  foreach ( $elements as $e )
			  {
				  if ( file_exists( LOCAL_MB2BUILDER_PATH_THEME_SETTINGS . $e . '/settings.php' ) )
				  {
					  require_once( LOCAL_MB2BUILDER_PATH_THEME_SETTINGS . $e . '/settings.php' );
				  }
			  }

  		  }



		  /*
  		   *
  		   * Method to get import layouts
  		   *
  		   */
		  public static function get_import_layouts()
  		  {
			  $layouts = array();

			  if ( ! is_dir( LOCAL_MB2BUILDER_PATH_THEME_IMPORT_LAYOUTS ) )
			  {
				  return array();
			  }

			  foreach ( scandir( LOCAL_MB2BUILDER_PATH_THEME_IMPORT_LAYOUTS ) as $layout )
			  {
				  $type = pathinfo( $layout, PATHINFO_EXTENSION );

				  if ( $type !== 'php' )
				  {
					  continue;
				  }

				  $layouts[] = str_replace( '.php', '', $layout );
			  }

			  return $layouts;

		  }








		  /*
  		   *
  		   * Method to get import block
  		   *
  		   */
		  public static function get_import_blocks()
  		  {
			  $blocks = array();

			  if ( ! is_dir( LOCAL_MB2BUILDER_PATH_THEME_IMPORT_BLOCKS ) )
			  {
				  return array();
			  }

			  foreach ( scandir( LOCAL_MB2BUILDER_PATH_THEME_IMPORT_BLOCKS ) as $block )
			  {
				  $type = pathinfo( $block, PATHINFO_EXTENSION );

				  if ( $type !== 'php' )
				  {
					  continue;
				  }

				  $blocks[] = str_replace( '.php', '', $block );
			  }

			  return $blocks;

		  }






		  /*
  		   *
  		   * Method to include import blocks settings
  		   *
  		   */
		  public static function include_import_blocks()
  		  {
			  // Include blocks settings
			  foreach ( self::get_import_blocks() as $block )
			  {
				  require_once( LOCAL_MB2BUILDER_PATH_THEME_IMPORT_BLOCKS . $block . '.php' );
			  }

			  // Include layouts settings
			  foreach ( self::get_import_layouts() as $layout )
			  {
				  require_once( LOCAL_MB2BUILDER_PATH_THEME_IMPORT_LAYOUTS . $layout . '.php' );
			  }
		  }





		 /*
 		  *
 		  * Method to get settings of bulder elements
 		  *
 		  */
		  public static function get_elements()
		  {

			 $elements = array();

		     if ( is_dir( LOCAL_MB2BUILDER_PATH_THEME_ELEMENTS ) )
		     {
		         foreach ( scandir( LOCAL_MB2BUILDER_PATH_THEME_ELEMENTS ) as $element )
		         {
		         	if( $element === '..' || $element === '.' )
		         	{
		         		continue;
		         	}

		         	if ( is_dir( LOCAL_MB2BUILDER_PATH_THEME_ELEMENTS . $element ) )
		         	{
		         		$elements[] = $element;
		         	}
		         }
		     }

		     sort( $elements );

		     return $elements;

		  }






		  /*
  		   *
  		   * Method to get builder settings
  		   *
  		   */
		  public static function get_builder_settings( $opts = array() )
		  {
			  global $CFG, $USER;
			  $output = '';

			  // Get elements settings
			  self::get_static_elements_settings();
			  self::get_element_settings();

			  // Get fields
			  self::get_fields();

			  // Include import blocks
			  self::include_import_blocks();

			  // Get settings from static elements
			  $section_config = unserialize( base64_decode( LOCAL_MB2BUILDER_SETTINGS_SECTION ) );
			  $row_config = unserialize( base64_decode( LOCAL_MB2BUILDER_SETTINGS_ROW ) );
			  $col_config = unserialize( base64_decode( LOCAL_MB2BUILDER_SETTINGS_COL ) );

			  $output .= '<div class="mb2-pb-settings mb2-pb-settings-section" data-baseurl="' . $CFG->wwwroot . '" data-themeurl="' . $CFG->wwwroot . '/' . local_mb2builder_themedir() . '/' . local_mb2builder_get_theme_name() . '" data-sesskey="' . $USER->sesskey . '">';
			  $output .= '<div class="hidden">';
			  $output .= self::languege_strings();
			  $output .= '<textarea id="buildertextimport"></textarea>';

			  $output .= '<div class="template-settings-section">';
			  $output .= self::settings_template( $section_config, 'settings-section' );
			  $output .= self::settings_template( $row_config, 'settings-row' );
			  $output .= self::settings_template( $col_config, 'settings-column' );
			  $output .= self::get_settings_template_elements();
			  $output .= '</div>';
			  $output .= '<div class="template-elements-section">';
			  $output .= format_text('[mb2pb_row template="1"][/mb2pb_row]', FORMAT_HTML);
			  $output .= self::get_element_templates();
			  $output .= '</div>';
			  $output .= '</div>';
			  $output .= self::modal_template('import-export', $opts);
			  $output .= self::modal_template('settings-section');
			  $output .= self::modal_template('settings-row');
			  $output .= self::modal_template('settings-column');
			  $output .= self::modal_template('settings-element');
			  $output .= self::modal_template('settings-subelement');
			  $output .= self::modal_template('row-layout');
			  $output .= self::modal_template('elements', $opts);
			  $output .= self::modal_template('images');
			  $output .= self::modal_template('sample-images');
			  $output .= self::modal_template('file-manager');
			  $output .= self::modal_template('font-icons');
			  $output .= '</div>';

			  return $output;

		  }



		  /*
 		   *
 		   * Method to export page to json file
 		   *
 		   */
		  public static function get_element_templates()
		  {
			  $output = '';

			  $elements = self::get_elements();

			  foreach ( $elements as $e )
			  {
				  $output .= format_text('[mb2pb_' . $e . ' template="1" ][/mb2pb_' . $e . ']', FORMAT_HTML);
			  }

			  return $output;

		  }




		  /*
 		   *
 		   * Method to export page to json file
 		   *
 		   */
		  public static function export_page( $data, $filename )
		  {

			 $fs = get_file_storage();
			 $context = \context_system::instance();

			 // Create new file with page layout
			 $opt = array(
				 'contextid' => $context->id,
				 'component' => 'local_mb2builder',
				 'filearea' => 'pagesexport',
				 'itemid' => 0,
				 'filepath' => '/',
				 'filename' => $filename
			 );

			 // Get old file and remove it
			 // TO DO: make sure that files which user don't need are removed
			 // We don't want to keep it in database
			 // Check functionality of get_db_pages method
			 $file = $fs->get_file( $opt['contextid'], $opt['component'], $opt['filearea'], $opt['itemid'], $opt['filepath'], $opt['filename'] );

			 if ( ! is_bool( $file ) )
			 {
				 $file->delete();
			 }

			 // Create new file with builder content
			 $fs->create_file_from_string( $opt, $data );
			 $file = $fs->get_file( $opt['contextid'], $opt['component'], $opt['filearea'],$opt['itemid'], $opt['filepath'], $opt['filename'] );

			 return moodle_url::make_pluginfile_url( $file->get_contextid(), $file->get_component(), $file->get_filearea(), NULL, $file->get_filepath(), $file->get_filename() );

		}





		/*
		 *
		 * Method to get images to insert
		 *
		 */
		public static function get_images_preview()
		{
			$output = '';
			$fs = get_file_storage();
			$context = context_system::instance();
			$files = $fs->get_area_files( $context->id, 'local_mb2builder', 'images' );

			foreach( $files as $f )
			{
				if ( $f->get_filename() === '.' )
				{
					continue;
				}

				$url = moodle_url::make_pluginfile_url( $f->get_contextid(), $f->get_component(), $f->get_filearea(), NULL, $f->get_filepath(), $f->get_filename() );

				$output .= '<div class="mb2-pb-image-toinsert">';
				$output .= '<span class="imgremove" data-imgname="' . $f->get_filename() . '">&times;</span>';
				$output .= '<a href="#" class="mb2-pb-insert-image" data-imgurl="' . $url . '" data-imgname="' . strtolower( $f->get_filename() ) . '" data-dismiss="modal">';
				$output .= '<img src="' . $url . '?preview=thumb" alt="' . $f->get_filename() . '" />';
				$output .= '<span class="imgdesc">' . $f->get_filename() . '</span>';
				$output .= '</a>';
				$output .= '</div>';
			}

			return $output;

		}








		/*
		 *
		 * Method to get sample images to insert
		 *
		 */
		public static function get_sample_images_preview()
		{
			$output = '';
			$images = self::get_sample_images_list();

			foreach( $images as $i )
			{
				$url = self::get_image_path( $i['url'] );

				$output .= '<div class="mb2-pb-image-toinsert">';
				$output .= '<a href="#" class="mb2-pb-insert-image" data-imgurl="' . $url . '" data-imgname="' . strtolower( $i['name'] ) . '" data-dismiss="modal">';
				$output .= '<img src="' . $url . '" alt="' . $i['name'] . '" />';
				$output .= '<span class="imgdesc">' . $i['name'] . '</span>';
				$output .= '</a>';
				$output .= '</div>';
			}


			return $output;

		}







		/*
		 *
		 * Method to get samle images
		 *
		 */
		public static function get_sample_images_list()
		{

			global $CFG;

			$imgdir = $CFG->dirroot . '/local/mb2builder/pix/sample-data/';

			$dirs = scandir( $imgdir );
			$images = array();

			if ( ! is_dir( $imgdir ) )
			{
				return $images;
			}

			foreach( $dirs as $i )
			{
				if ( $i === '.' || $i === '..' )
				{
					continue;
				}

				if ( is_dir( $imgdir . $i ) )
				{
					foreach( scandir( $imgdir . $i ) as $ii )
					{
						if ( $ii === '.' || $ii === '..' )
						{
							continue;
						}

						if ( is_dir( $imgdir . $i . '/' . $ii ) )
						{
							foreach ( scandir( $imgdir . $i . '/' . $ii ) as $iii )
							{

								if ( $iii === '.' || $iii === '..' )
								{
									continue;
								}

								$images[] = array( 'name' => $iii, 'url' => 'sample-data/' . $i . '/' . $ii . '/' . self::get_basename( $iii ) );
							}
						}

					}
				}
			}

			return $images;

		}






		/*
		 *
		 * Method to remove file extension
		 *
		 */
		public static function get_basename( $filename )
		{

			// Convert file name into array
			$filenamearr = explode( '.', $filename );

			// Get last element from the array
			// We need last element because file name may contains more tha one dot (file.name.jpg)
			$lastitem = end( $filenamearr );

			// Remove file extension from the filename
			$filename = str_replace( '.' . $lastitem, '',  $filename );

			return $filename;

		}






		/*
		 *
		 * Method to save file in filearea
		 *
		 */
		public static function delete_file( $filename )
		{
			global $USER;

			if ( ! $filename )
			{
				return;
			}

			$fs = get_file_storage();
			$contextid = context_system::instance();

			$file = $fs->get_file( $contextid->id, 'local_mb2builder', 'images', 0, '/', $filename, $USER->id );

			if ( $file )
			{
				$file->delete();
			}

		}








		/*
		 *
		 * Method to save file in filearea
		 *
		 */
		public static function save_file( $itemid, $overwrite = false )
		{
			global $USER;

			if ( ! $itemid )
			{
				return;
			}

			$fs = get_file_storage();
			$context = context_user::instance( $USER->id );
			$newcontextid = context_system::instance();

			// Get file from draft area
			$draftfiles = $fs->get_area_files( $context->id, 'user', 'draft', $itemid, 'id DESC', false );

			if ( ! $draftfiles )
			{
				return;
			}

			$draftfile = reset( $draftfiles );

			// Define options for new file record
			$file_record = array(
				'contextid'=> $newcontextid->id,
				'component' => 'local_mb2builder',
				'filearea' => 'images',
				'itemid'=> 0,
				'filepath' => '/',
				'filename' => $draftfile->get_filename(),
				'userid' => $USER->id
			);

			$oldfile = $fs->get_file( $newcontextid->id, 'local_mb2builder', 'images', 0, '/', $draftfile->get_filename(), $USER->id );

			// Check if file with the same name key_exists
			// We don't want delete any files, so we have to change image name
			if ( $oldfile )
			{
				$newname = explode( '.', $draftfile->get_filename() );
				$filetype = end( $newname );
				$newname = str_replace( '.' . $filetype, '',  $draftfile->get_filename() ) . uniqid( '_' );
				$file_record['filename'] = $newname . '.' . $filetype;
			}

            return $fs->create_file_from_storedfile( $file_record, $draftfile );

		}





		/*
		 *
		 * Method to files from database
		 *
		 */
		public static function get_db_pages()
		{

		    global $CFG, $DB;
		    $results = array();
		    $context = \context_system::instance();

		    $query = 'SELECT * FROM ' . $CFG->prefix . 'files WHERE component=\'local_mb2builder\' AND contextid=' . $context->id;
		    $row = $DB->get_records_sql($query);

		    foreach ( $row as $el )
		    {
		        $results[] = $el->filename;
		    }

		    return $results;
		}




		/*
		 *
		 * Method to get inputs
		 *
		 */
		public static function get_input_items( $key, $attr )
		{
			 return call_user_func( array( 'LocalMb2builder' . ucfirst( $attr['type'] ), 'local_mb2builder_get_input'), $key, $attr );
		}






		/*
		 *
		 * Method to get settings from builder elements
		 *
		 */
		public static function get_settings_template_elements()
		{

			$output = '';

			foreach ( self::get_elements() as $element )
			{

				$cons_fields_name = 'LOCAL_MB2BUILDER_SETTINGS_' . strtoupper( $element );

				$config_fields = unserialize( base64_decode( constant( $cons_fields_name ) ) );
				$type = 'settings-element-' . $element;

				$output .= self::settings_template( $config_fields, $type );

				if ( isset( $config_fields['subelement'] ) )
				{
					$type = 'settings-subelement-' . $element;
					$output .= self::settings_template( $config_fields['subelement'], $type );
				}


			}

			return $output;

		}





		/*
		 *
		 * Method to get import blocks settings
		 *
		 */
		public static function get_import_block_settings( $block, $layout = false )
		{
			if ( $layout )
			{
				$blocks = self::get_import_layouts();
			}
			else
			{
				$blocks = self::get_import_blocks();
			}

			$arrayk = array_search ( $block, $blocks );

			if ( ! isset( $blocks[$arrayk] ) )
			{
				return;
			}

			$blocksettings = $blocks[$arrayk];

			if ( $layout )
			{
				$blocksettings = 'LOCAL_MB2BUILDER_IMPORT_LAYOUTS_' . strtoupper( $blocksettings );
			}
			else
			{
				$blocksettings = 'LOCAL_MB2BUILDER_IMPORT_BLOCKS_' . strtoupper( $blocksettings );
			}

			$blocksettings = unserialize( base64_decode( constant( $blocksettings ) ) );

			return $blocksettings;

		}








		public static function settings_template( $config_fields, $type )
		{

			$output = '';

			$output .= '<div id="tab-' . $type . '" class="theme-tabs tabs top">';
			$output .= '<ul class="nav nav-tabs">';

			$config_tabs = $config_fields['tabs'];

			foreach ($config_tabs as $tab=>$tname)
			{
				$isactive = $tab === 'general' ? ' active': '';
				$output .= '<li class="nav-item' . $isactive . '"><a class="nav-link' . $isactive . '" data-toggle="tab" href="#' . $type . '-' . $tab . '">' . $tname . '</a></li>';
			}

			$output .= '</ul>';


			$output .= '<div class="tab-content">';

			foreach ($config_tabs as $tab=>$tname)
			{

				$isactive = $tab === 'general' ? ' in active': '';
				$output .= '<div id="' . $type . '-' . $tab . '" class="tab-pane fade' . $isactive . '">';

				foreach ($config_fields['attr'] as $fname=>$attr)
				{
					if ($attr['section'] === $tab)
					{
						$output .= self::get_input_items( $fname, $attr );
					}
				}

				$output .= '</div>';
			}

			$output .= '</div>';
			$output .= '</div>';

			return $output;

		}





		public static function modal_template( $type = '', $opts = array() )
		{

			global $CFG;

			$output = '';
			$modal_cls = '';
			$modalcls = '';
			$cancelcls = '';

			if ( preg_match( '@settings-@', $type ) )
			{
				$modalcls = ' mb2-pb-modal';
				$cancelcls = ' mb2-pb-page-cancel';
			}

			if ( $type === 'images' || $type === 'sample-images' || $type === 'font-icons' || $type === 'elements' || $type === 'import-export' )
			{
				$modal_cls = ' modal-md';
				$modalcls = '';
			}

			$images_data = $type === 'images' ? ' data-images_baseurl="' . self::set_images_base_url() . '"' : '';

			$modal_title = 'Modal';

			if ($type === 'row-layout')
			{
				$modal_title = get_string('columns', 'local_mb2builder');
			}
			elseif ($type === 'font-icons')
			{
				$modal_title = get_string('icons', 'local_mb2builder');
			}
			elseif ($type ===  'images' )
			{
				$modal_title = get_string('customimages', 'local_mb2builder');
			}
			elseif ($type === 'sample-images' )
			{
				$modal_title = get_string('sampleimages', 'local_mb2builder');
			}
			elseif ($type === 'file-manager')
			{
				$modal_title = get_string('uploadimages', 'local_mb2builder');
			}
			elseif ($type === 'elements')
			{
				$modal_title = get_string('addelement', 'local_mb2builder');
			}
			elseif ($type === 'import-export')
			{
				$modal_title = get_string('importexport', 'local_mb2builder');
			}

			$output .= '<div id="mb2-pb-modal-' . $type . '" class="modal fade' . $modalcls . '" data-type="' . $type . '" role="dialog"' . $images_data . '>';
			$output .= '<div class="modal-dialog' . $modal_cls . '" role="document">';
			$output .= '<div class="modal-content">';
			$output .= '<div class="modal-header">';
			$output .= '<button type="button" class="close" data-dismiss="modal">&times;</button>';
			$output .= '<h4 class="modal-title">' . $modal_title . '</h4>';
			$output .= '</div>';
			$output .= '<div class="modal-body">';
			$output .= $type === 'row-layout' ? self::get_row_layout() : '';
			$output .= $type === 'elements' ? self::get_layout_elements($opts) : '';
			$output .= $type === 'images' ? self::get_images() : '';
			$output .= $type === 'sample-images' ? self::get_sample_images() : '';
			$output .= $type === 'font-icons' ? self::get_font_icons() : '';
			$output .= $type === 'import-export' ? self::import_export( $opts ) : '';
			$output .= $type === 'file-manager' ? self::get_file_manager_iframe() : '';
			$output .= $type === 'file-manager' ? '<div class="mb2-pb-overlay"></div>' : '';
			$output .= '</div>';

			if ($type !== 'row-layout' && $type !== 'elements')
			{
				$output .= '<div class="modal-footer">';

				$save_btn = 1;
				//$dismiss = ' data-dismiss="modal"';
				$dismiss = ' data-modal="#mb2-pb-modal-' . $type . '"';
				$btn_id = 'save-' . $type;
				$cancel_text = get_string('cancel');

				if ($type === 'file-manager')
				{
					$dismiss = '';
					$btn_id = 'applay-' . $type;
					$cancel_text = get_string('close','local_mb2builder');
				}

				if ( $type === 'images' )
				{
					$save_btn = 0;
					$output .= '<button class="mb2-pb-upload-images btn btn-success btn-sm" data-toggle="modal" data-target="#mb2-pb-modal-file-manager">' .
					get_string('uploadimages','local_mb2builder') . '</button>';
					$output .= '<button class="mb2-pb-upload-images btn btn-info btn-sm" data-toggle="modal" data-target="#mb2-pb-modal-sample-images" data-dismiss="modal">' .	get_string('sampleimages','local_mb2builder') . '</button>';
				}

				if ( $type === 'sample-images' )
				{
					$save_btn = 0;
					$output .= '<button class="btn btn-success btn-sm" data-toggle="modal" data-target="#mb2-pb-modal-images" data-dismiss="modal">' .
					get_string('customimages','local_mb2builder') . '</button>';

				}

				if ($type === 'font-icons')
				{
					$save_btn = 0;
				}

				if ( $type === 'import-export' )
				{
					$save_btn = 0;
					$cancel_text = get_string('close','local_mb2builder');
				}

				$output .= $save_btn ? '<button type="button" id="' . $btn_id . '" class="btn btn-sm btn-success mb2-pb-page-apply"' . $dismiss . '>' . get_string('save', 'admin') . '</button>' : '';
				$output .= '<button type="button" class="btn btn-sm btn-danger' . $cancelcls . '" data-dismiss="modal">' . $cancel_text . '</button>';
				$output .= '</div>';
			}


			$output .= '</div>';
			$output .= '</div>';
			$output .= '</div>';

			return $output;
		}





		/*
		 *
		 * Method to set builder base urls
		 *
		 */
		public static function set_images_base_url()
		{
		    global $CFG;
		    $context = \context_system::instance();

		    if ( $CFG->slasharguments )
		    {
		        return new moodle_url( $CFG->wwwroot . '/pluginfile.php/' . $context->id . '/local_mb2builder/images/', array() );
		    }
		    else
		    {
		        return new moodle_url( $CFG->wwwroot . '/pluginfile.php', array( 'file' => '/' . $context->id . '/local_mb2builder/images/' ) );
		    }

		}



		/*
		 *
		 * Method to set builder base urls
		 *
		 */
		public static function get_icons_arr( $path, $class_prefix = 'fa-', $output_pref = '' ){

		    $icons = array();

		    if( !file_exists($path) )
		    {
		        return $icons;
		    }

		    $css = file_get_contents($path);
		    $pattern = '/\.(' . $class_prefix . '(?:\w+(?:-)?)+):before\s+{\s*content:\s*"(.+)";\s+}/';

		    preg_match_all($pattern, $css, $matches, PREG_SET_ORDER);

		    foreach ($matches as $match) {
		        if ($output_pref)
		        {
		            $match1 = str_replace($class_prefix, $output_pref, $match[1]);
		            $icons[$match1] = $match[2];
		        }
		        else
		        {
		            $icons[$match[1]] = $match[2];
		        }
		    }

		    return $icons;

		}




		public static function languege_strings()
		{

			$output = '';

			$output .= '<span id="mb2-pb-lang"';
			$output .= ' data-addrow="' . get_string('addrow','local_mb2builder') . '"';
			$output .= ' data-remove="' . get_string('remove','local_mb2builder') . '"';
			$output .= ' data-settings="' . get_string('settings','local_mb2builder') . '"';
			$output .= ' data-section="' . get_string('section','local_mb2builder') . '"';
			$output .= ' data-row="' . get_string('row','local_mb2builder') . '"';
			$output .= ' data-duplicate="' . get_string('duplicate','local_mb2builder') . '"';
			$output .= ' data-col="' . get_string('column','local_mb2builder') . '"';
			$output .= ' data-columns="' . get_string('columns','local_mb2builder') . '"';
			$output .= ' data-addelement="' . get_string('addelement','local_mb2builder') . '"';
			$output .= ' data-element="' . get_string('element','local_mb2builder') . '"';
			$output .= ' data-copy="' . get_string('copy','local_mb2builder') . '"';
			$output .= ' data-item="' . get_string('item','local_mb2builder') . '"';
			$output .= ' data-move="' . get_string('move','local_mb2builder') . '"';
			$output .= ' data-importtextempty="' . get_string('importtextempty','local_mb2builder') . '"';
			$output .= ' data-importtextnotvalidjson="' . get_string('importtextnotvalidjson','local_mb2builder') . '"';
			$output .= ' data-importsuccess="' . get_string('importsuccess','local_mb2builder') . '"';
			$output .= ' data-cannotremove="' . get_string('cannotremove', 'local_mb2builder') . '"';
			$output .= ' data-cantopenmodal="' . get_string('cantopenmodal', 'local_mb2builder') . '"';
			$output .= ' data-requirefield="' . get_string('requirefield', 'local_mb2builder') . '"';
			$output .= ' data-processing="' . get_string('processing', 'local_mb2builder') . '"';
			$output .= ' data-savelayoutbtn="' . get_string('savelayoutbtn', 'local_mb2builder') . '"';
			$output .= ' data-layoutcreated="' . get_string('layoutcreated', 'local_mb2builder') . '"';
			$output .= ' data-importlayoutbtn="' . get_string('importlayoutbtn', 'local_mb2builder') . '"';
			$output .= ' data-selectlayout="' . get_string('selectlayout', 'local_mb2builder') . '"';
			$output .= ' data-shortcodereplaced="' . get_string('shortcodereplaced', 'local_mb2builder') . '"';
			$output .= ' data-htmlerror="' . get_string('htmlerror', 'local_mb2builder') . '"';
			$output .= '></span>';

			return $output;


		}



		public static function get_row_layout()
		{

			$output = '';

			$layout_arr = array(
				'12',
				'6,6',
				'4,4,4',
				'3,3,3,3',
				'3,6,3',
				'3,3,6',
				'6,3,3',
				'9,3',
				'3,9',
				'8,4',
				'4,8',
				'7,5',
				'5,7',
				'10,2',
				'2,10'
			);

			$output .= '<div class="mb2-pb-row-variants">';

			foreach ($layout_arr as $l)
			{
				$output .= '<a href="#" class="mb2-pb-row-variant row-' . str_replace(',', '', $l) . '" data-row_variant="' . $l . '" title="' .
				str_replace(',', '-', $l) . '" data-modal="#mb2-pb-modal-row-layout">';

				$el_arr = explode(',', $l);
				foreach ($el_arr as $e)
				{
					$output .= '<span class="rowel-' . $e . '">' . $e . '</span>';
				}

				$output .= '</a>';
			}

			$output .= '</div>';

			return $output;

		}






		public static function get_layout_elements($options = array())
		{

			$output = '';
			$elements = self::get_elements();

			$output .= '<div class="mb2-pb-elements">';

			foreach ( $elements as $element )
			{
				$cons_fields_name = 'LOCAL_MB2BUILDER_SETTINGS_' . strtoupper( $element );
				$config_fields = unserialize( base64_decode( constant( $cons_fields_name ) ) );
				$subel = isset( $config_fields['subelement'] ) ? 1 : 0;

				// Do not show footer elements on normal page builder
				if ( isset( $config_fields['footer'] ) &&  ! $options['footer'] )
				{
					continue;
				}

				$output .= '<a href="#" class="mb2-pb-modal-el ' . $config_fields['id'] . '" data-id="' . $config_fields['id'] . '" data-subelement="' . $subel . '" data-subelement_name="' . $config_fields['subid'] . '" data-dismiss="modal">';
				$output .= '<i class="' . $config_fields['icon'] . '"></i>';
				$output .= '<span>' . $config_fields['title'] . '</span>';
				$output .= '</a>';
			}

			$output .= '</div>';

			return $output;

		}





		public static function get_images()
		{
			global $CFG;
			$output = '';
			$ajaxurl = new moodle_url( $CFG->wwwroot . '/local/mb2builder/ajax/image-delete.php', array() );

			$output .= '<div class="icons-search"><input type="text" class="mb2-pb-search-image" placeholder="' . get_string( 'searchimagefor', 'local_mb2builder' ) . '" /></div>';
			$output .= '<div class="mb2-pb-images" data-url="' . $ajaxurl . '">';
			$output .= self::get_images_preview();
			$output .= '</div>';
			$output .= '<div class="mb2-pb-overlay"></div>';

			return $output;

		}






		public static function get_sample_images()
		{

			$output = '';

			$output .= '<div class="icons-search"><input type="text" class="mb2-pb-search-image" placeholder="' . get_string( 'searchimagefor', 'local_mb2builder' ) . '" /></div>';
			$output .= '<div class="mb2-pb-images">';
			$output .= self::get_sample_images_preview();
			$output .= '</div>';

			return $output;

		}




		public static function get_file_manager_iframe()
		{

			global $CFG;
			$output = '';

			require_once( $CFG->dirroot . '/local/mb2builder/form-media.php' );
			$ajaxurl = new moodle_url( $CFG->wwwroot . '/local/mb2builder/ajax/image-upload.php', array() );

			$output .= '<div class="mb2-pb-uploadmedia-wrap" data-url="' . $ajaxurl . '">';
			$mform = new media_edit_form( 'index.php' );
			$output .= $mform->render();
			$output .= '</div>';

			return $output;

		}




		public static function get_font_icons()
		{

			$output = '';
			$icons_lineicons = array();
			$path_fa = LOCAL_MB2BUILDER_PATH_THEME_ASSETS . '/font-awesome/css/font-awesome.css';
			$path_glyphicons = LOCAL_MB2BUILDER_PATH_THEME_ASSETS . '/Glyphicons-Halflings/glyphicons.css';
			$path_7stroke = LOCAL_MB2BUILDER_PATH_THEME_ASSETS . '/Pe-icon-7-stroke/css/Pe-icon-7-stroke.css';
			$path_lineicons = LOCAL_MB2BUILDER_PATH_THEME_ASSETS . '/LineIcons/LineIcons.css';
			$path_remixicon = LOCAL_MB2BUILDER_PATH_THEME_ASSETS . '/remixicon/remixicon.css';
			$serachfiled = '<div class="icons-search"><input type="text" class="mb2-pb-search-icon" placeholder="' . get_string( 'searchiconfor', 'local_mb2builder' ) . '" /></div>';

			$icons_fa = self::get_icons_arr( $path_fa );
			$icons_glyphicons = self::get_icons_arr( $path_glyphicons, 'glyphicon-' );
			$icons_7stroke = self::get_icons_arr( $path_7stroke, '' );
			$icons_remixicon = self::get_icons_arr( $path_remixicon, '' );

			if ( file_exists( $path_lineicons ) )
			{
				$icons_lineicons = self::get_icons_arr( $path_lineicons, '' );
			}

			$output .= '<div id="tab-font-icons" class="theme-tabs tabs top">';
			$output .= '<ul class="nav nav-tabs">';
			$output .= file_exists($path_fa) ? '<li class="nav-item active"><a class="nav-link active show" data-toggle="tab" href="#tab-font-icons-fa">Font Awesome</a></li>' : '';
			$output .= file_exists($path_glyphicons) ? '<li class="nav-item"><a class="nav-link" data-toggle="tab" href="#tab-font-icons-glyph">Glyphicons</a></li>' : '';
			$output .= file_exists($path_7stroke) ? '<li class="nav-item"><a class="nav-link" data-toggle="tab" href="#tab-font-icons-7stroke">7 Stroke</a></li>' : '';
			$output .= file_exists($path_remixicon) ? '<li class="nav-item"><a class="nav-link" data-toggle="tab" href="#tab-font-icons-remix">Remix icons</a></li>' : '';
			$output .= file_exists($path_lineicons) ? '<li class="nav-item"><a class="nav-link" data-toggle="tab" href="#tab-font-icons-lineicons">Line icons</a></li>' : '';
			$output .= '</ul>';

			$output .= '<div class="tab-content">';

			if ( file_exists( $path_fa ) && count( $icons_fa ) )
			{
				$output .= '<div id="tab-font-icons-fa" class="tab-pane fade in active">';
				$output .= $serachfiled;
				$output .= '<div class="mb2-pb-icons">';

				foreach ($icons_fa as $k=>$v)
				{
					$output .= '<a href="#" class="mb2-pb-choose-icon" data-iconname="fa ' . $k . '" title="' . $k . '" data-dismiss="modal"><i class="fa ' . $k . '"></i></a>';
				}

				$output .= '</div>';
				$output .= '</div>';
			}

			if ( file_exists( $path_glyphicons ) && count( $icons_glyphicons ) )
			{
				$output .= '<div id="tab-font-icons-glyph" class="tab-pane fade">';
				$output .= $serachfiled;
				$output .= '<div class="mb2-pb-icons">';

				foreach ($icons_glyphicons as $k=>$v)
				{
					$output .= '<a href="#" class="mb2-pb-choose-icon" data-iconname="glyphicon ' . $k . '" title="' . $k . '" data-dismiss="modal"><i class="glyphicon ' . $k . '"></i></a>';
				}

				$output .= '</div>';
				$output .= '</div>';
			}

			if ( file_exists( $path_7stroke ) && count( $icons_7stroke ) )
			{
				$output .= '<div id="tab-font-icons-7stroke" class="tab-pane fade">';
				$output .= $serachfiled;
				$output .= '<div class="mb2-pb-icons">';

				foreach ($icons_7stroke as $k=>$v)
				{
					$output .= '<a href="#" class="mb2-pb-choose-icon" data-iconname="' . $k . '" title="' . $k . '" data-dismiss="modal"><i class=" ' . $k . '"></i></a>';
				}

				$output .= '</div>';
				$output .= '</div>';
			}

			if ( file_exists( $path_remixicon ) && count( $icons_remixicon ) )
			{
				$output .= '<div id="tab-font-icons-remix" class="tab-pane fade">';
				$output .= $serachfiled;
				$output .= '<div class="mb2-pb-icons">';

				foreach ($icons_remixicon as $k=>$v)
				{
					$output .= '<a href="#" class="mb2-pb-choose-icon" data-iconname="' . $k . '" title="' . $k . '" data-dismiss="modal"><i class=" ' . $k . '"></i></a>';
				}

				$output .= '</div>';
				$output .= '</div>';
			}

			if ( file_exists( $path_lineicons ) && count( $icons_lineicons ) )
			{
				$output .= '<div id="tab-font-icons-lineicons" class="tab-pane fade">';
				$output .= $serachfiled;
				$output .= '<div class="mb2-pb-icons">';

				foreach ($icons_lineicons as $k=>$v)
				{
					$output .= '<a href="#" class="mb2-pb-choose-icon" data-iconname="' . $k . '" title="' . $k . '" data-dismiss="modal"><i class=" ' . $k . '"></i></a>';
				}

				$output .= '</div>';
				$output .= '</div>';
			}

			$output .= '</div>';
			$output .= '</div>';


			return $output;

		}





		public static function import_export( $opts = array() )
		{

			$output = '';
			$blockactive = $opts['footer'] ? ' in active': '';
			$navblockactive = $opts['footer'] ? ' active': '';

			$output .= '<div id="tab-import-export" class="theme-tabs tabs top">';
			$output .= '<ul class="nav nav-tabs">';

			if ( ! $opts['footer'] )
			{
				$output .= '<li class="nav-item active"><a class="nav-link active show" data-toggle="tab" href="#tab-importtemplates">' . get_string('layouts','local_mb2builder') . '</a></li>';
			}

			$output .= '<li class="nav-item"><a class="nav-link' .
			$navblockactive . '" data-toggle="tab" href="#tab-importrows">' . get_string('importrows','local_mb2builder') . '</a></li>';
			$output .= '<li class="nav-item"><a class="nav-link" data-toggle="tab" href="#tab-import">' . get_string('import','local_mb2builder') . '</a></li>';
			$output .= '<li class="nav-item"><a class="nav-link" data-toggle="tab" href="#tab-export">' . get_string('export','local_mb2builder') . '</a></li>';
			$output .= '</ul>';

			$output .= '<div class="tab-content">';

			if ( ! $opts['footer'] )
			{
				$output .= '<div id="tab-importtemplates" class="tab-pane fade in active">';
				$output .= self::get_import_blocks_list( true );
				$output .= '</div>';
			}

			$output .= '<div id="tab-importrows" class="tab-pane fade' . $blockactive . '">';
			$output .= self::get_import_blocks_list();
			$output .= '</div>';

			$output .= '<div id="tab-import" class="tab-pane fade">';
			$output .= self::get_latout_form();
			$output .= '</div>';

			$output .= '<div id="tab-export" class="tab-pane fade">';

			$output .= self::get_export_form();
			$output .= '</div>';

			$output .= '</div>';
			$output .= '</div>';

			return $output;

		}






		/*
		 *
		 * Method to get layout export form
		 *
		 */
		public static function get_export_form()
		{

			global $CFG, $USER;
			$output = '';
			$layouts = Mb2builderLayoutsApi::get_list_records();
			$ajaxurl = new moodle_url( $CFG->wwwroot . '/local/mb2builder/ajax/save-layout.php', array() );

			$output .= '<form id="mb2-pb-form-savelayout" class="mb2-pb-tabsform" action="" method="" data-url="' . $ajaxurl . '">';
			// We always needs to create new layout record
			// Se we have to set empty 'itemid' field
			$output .= '<input type="hidden" name="itemid" id="savelayoutitemid" value="" />';
			$output .= '<input type="hidden" name="sesskey" value="' . $USER->sesskey . '" />';
			$output .= '<textarea name="content" id="savelayoutcontent" class="hidden"></textarea>';
			$output .= '<div class="formfield field-formel">';
			$output .= '<div class="update-layout">';
			$output .= '<label for="editlayoutid"> ' . get_string( 'overridelayout', 'local_mb2builder' ) . '</label>';
			$output .= '<select name="layoutid" id="editlayoutid" class="mb2-pb-layout-list">';
			$output .= '<option value="0">' . get_string( 'none', 'local_mb2builder' ) . '</option>';

			if ( count( $layouts ) )
			{
				foreach ( $layouts as  $layout )
				{
					$output .= '<option value="' . $layout->id . '">' . $layout->name . '</option>';
				}
			}

			$output .= '</select>';
			$output .= '</div>';
			$output .= '<div style="position:relative;">';
			$output .= '<input type="text" name="name" id="savelayoutname" value="" placeholder="' . get_string( 'savelayoutplh', 'local_mb2builder' ) . '" />';
			$output .= '<span class="mb2-pb-error">' . get_string( 'requirefield', 'local_mb2builder' ) . '</span>';
			$output .= '</div>';
			$output .= '</div>';

			$output .= '<div class="formfield button-formel">';
			$output .= '<input class="btn btn-success" type="submit" value="' . get_string( 'savelayoutbtn', 'local_mb2builder' ) . '" />';
			$output .= '</div>';

			$output .= '<div class="mb2-pb-success">' . get_string( 'layoutcreated', 'local_mb2builder' ) . '!</div>';


			$output .= '</form>';

			return $output;

		}





		/*
		 *
		 * Method to layouts list
		 *
		 */
		public static function get_latout_form()
		{

			$output = '';
			$layouts = Mb2builderLayoutsApi::get_list_records();

			global $CFG, $USER;
			$output = '';
			$ajaxurl = new moodle_url( $CFG->wwwroot . '/local/mb2builder/ajax/import-layout-custom.php', array() );

			$output .= '<form id="mb2-pb-form-importlayout" class="mb2-pb-tabsform" action="" method="" data-url="' . $ajaxurl . '">';
			$output .= '<input type="hidden" name="sesskey" value="' . $USER->sesskey . '" />';
			$output .= '<div class="formfield field-formel">';
			$output .= '<div class="formfieldcheck">';
			$output .= '<input type="checkbox" id="layoutkeep" name="importlayoutkeep" value="0">';
			$output .= '<label for="layoutkeep"> ' . get_string( 'importkeep', 'local_mb2builder' ) . '</label>';
			$output .= '</div>';

			$output .= '<div style="position:relative;">';
			$output .= '<select name="layoutid" id="importlayoutid" class="mb2-pb-layout-list">';
			$output .= '<option value="0">' . get_string( 'selectlayout', 'local_mb2builder' ) . '</option>';

			if ( count( $layouts ) )
			{
				foreach ( $layouts as  $layout )
				{
					$output .= '<option value="' . $layout->id . '">' . $layout->name . '</option>';
				}
			}

			$output .= '</select>';
			$output .= '<span class="mb2-pb-error">' . get_string( 'requirefield', 'local_mb2builder' ) . '</span>';
			$output .= '</div>';

			$output .= '</div>';

			$output .= '<div class="formfield button-formel"><input class="btn btn-success" type="submit" value="' . get_string( 'importlayoutbtn', 'local_mb2builder' ) . '" /></div>';

			$output .= '<div class="mb2-pb-success">' . get_string( 'layoutimported', 'local_mb2builder' ) . '!</div>';
			$output .= '</form>';

			return $output;

		}





		/*
		 *
		 * Method to get import blocks list
		 *
		 */
		public static function get_import_blocks_list( $layout = false )
		{
			$output = '';

			if ( $layout )
			{
				$blocks = self::get_import_layouts();
				$part = 'layouts';
			}
			else
			{
				$blocks = self::get_import_blocks();
				$part = 'blocks';
			}

			$output .= '<div class="mb2-pb-import-select">';
			$output .= '<label for="mb2pb_select_block_' . $part . '">' . get_string( 'category', 'local_mb2builder' ) . '</label> <select name="mb2pb_select_block_' . $part . '" id="mb2pb_select_block_' . $part . '">';
			$output .= '<option value="">' . get_string( 'all', 'local_mb2builder' ) . '</option>';

			foreach ( $blocks as $block )
			{
				$output .= '<option value="' . $block . '">' . get_string( $block, 'local_mb2builder' ) . '</option>';
			}

			$output .= '</select>';
			$output .= '</div>';

			$output .= '<div class="mb2-pb-import-blocks-wrap">';
			$output .= '<div class="mb2-pb-import-blocks">';

			foreach ( $blocks as $block )
			{
				$blocksettings = self::get_import_block_settings( $block, $layout );

				foreach ( $blocksettings['items'] as $k => $item )
				{
					$output .= '<div class="block-item" data-category="' . $blocksettings['id'] . '">';
					$output .= '<div class="block-item-inner">';
					$output .= '<img src="' . self::get_import_thumbs( $part, $item['thumb'] ) . '" alt="' . $item['name'] . '" />';
					$output .= '<a class="mb2-pb-import-part" href="#" data-part="' . $part . '" data-tags="' . $item['tags'] . '" data-category="' . $blocksettings['id'] . '" data-itemid="' . $k . '" data-dismiss="modal" title="' . get_string('import', 'local_mb2builder') . '">';
					$output .= '<i class="fa fa-upload"></i>';
					$output .= '</a>';
					$output .= '</div>';
					$output .= '</div>';
				}
			}

			$output .= '</div>';
			$output .= '</div>';

			return $output;

		}






		/*
		 *
		 * Method to get blocks images
		 *
		 */
		public static function get_import_thumbs( $type = 'blocks', $image = '' )
		{

			global $CFG, $OUTPUT;
			$theme = self::get_theme_name();
			$path = 'import/' . $theme . '/' . $type . '/' . $image;

			return self::get_image_path( $path );

		}




		/*
		 *
		 * Method to get theme name
		 *
		 */
		public static function get_theme_name()
		{

			global $CFG;

		    if ( isset( get_config( 'local_mb2builder' )->theme ) && get_config( 'local_mb2builder' )->theme )
		    {
		        return get_config( 'local_mb2builder' )->theme;
		    }

		    return $CFG->theme;

		}





		/*
		 *
		 * Method to get plugin image path
		 *
		 */
		public static function get_image_path( $path )
		{

			global $CFG, $OUTPUT;
			$context = context_system::instance();

			if ( ! $path )
			{
				return;
			}

			// Special condition for Moodle 3.3 and erlier
			// We don't need it because plugin works since Moodle 3.6, but it not hurts
			if ( $CFG->version < 2017051500 )
			{
				return $OUTPUT->pix_url( $path, 'local_mb2builder' );
			}
			else
			{
				return $OUTPUT->image_url( $path, 'local_mb2builder' );
			}

		}





		/*
		 *
		 * Method to get sample image
		 *
		 */
		public static function get_sample_image( $value )
		{

			global $CFG, $OUTPUT;

			$imagename = '';

			if ( ! preg_match( '@mb2sampledata@', $value ) )
			{
				return $value;
			}

			// The image data in elemnt settings is the following:
			// 'mb2sampledata:/year/month/imagename'
			$imagename = explode( ':', $value );
			$imagename = $imagename[1];

			// Get sample data image
			$path = 'sample-data/' . $imagename;

			return self::get_image_path( $path );

		}



	}


}
