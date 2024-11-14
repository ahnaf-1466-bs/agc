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
 * Defines forms.
 *
 * @package    local_mb2megamenu
 * @copyright  2019 - 2020 Mariusz Boloz (mb2themes.com)
 * @license    Commercial https://themeforest.net/licenses
 */

defined('MOODLE_INTERNAL') || die();


if ( ! class_exists( 'Mb2megamenuSettings' ) )
{

    class Mb2megamenuSettings
    {

        /*
		 *
		 * Method to set menu item settings form in modal window
		 *
		 */
        public static function menuitem_settings_form()
        {
            $output = '';
            $settings = self::menuitem_settings();

            foreach ( $settings as $setting )
            {
                $levelcls = $setting['level'] == -1 ? 'all' : $setting['level'];

                $output .= '<div class="mb2megamenu-modalform-item level-' . $levelcls . '">';

                switch( $setting['type'] )
                {
                    case 'list' :
                    $output .= self::field_list($setting);
                    break;

                    case 'checkbox' :
                    $output .= self::field_checkbox($setting);
                    break;

                    case 'icon' :
                    $output .= self::field_icon($setting);
                    break;

                    case 'image' :
                    $output .= self::field_image($setting);
                    break;

                    case 'color' :
                    $output .= self::field_color($setting);
                    break;
                        
                    case 'textarea' :
                    $output .= self::field_textarea($setting);
                    break;

                    default :
                    $output .= self::field_text($setting);
                    break;
                }

                $output .= '</div>'; // mb2megamenu-modalform-item
            }


            return $output;

        }




        /*
		 *
		 * Method to define menu item settings
		 *
		 */
        public static function menuitem_settings()
        {
            
            // Level visible:
            // -1 - all menu items
            // 1 - mega menu parent item
            // 2 - mega menu parent item AND mega menu columns
            // 3 - mega menu columns items

            $settings = array(
                array(
                    'id' => 'hidetext',
                    'type' => 'checkbox',
                    'label' => get_string('hidetext', 'local_mb2megamenu'),
                    'desc' => get_string('hidetextdesc', 'local_mb2megamenu'),
                    'options' => array(
                        1 => get_string('yes'),
                        0 => get_string('no'),
                    ),
                    'default' => 0,
                    'level' => 3
                ),
                array(
                    'id' => 'hcolor',
                    'type' => 'color',
                    'label' => get_string('textcolor', 'local_mb2megamenu'),
                    'twinlabel1' => get_string('normalstate', 'local_mb2megamenu'),
                    'twinlabel2' => get_string('hoverstate', 'local_mb2megamenu'),
                    'desc' => '',
                    'default' => '',
                    'twin' => array(
                        'id' => 'hhcolor',
                        'type' => 'color',
                        'label' => '',
                        'desc' => '',
                        'default' => ''
                    ),
                    'level' => 3
                ),
                array(
                    'id' => 'sublabel',
                    'type' => 'textarea',
                    'label' => get_string('sublabel', 'local_mb2megamenu'),
                    'desc' => get_string('sublabeldesc', 'local_mb2megamenu'),
                    'default' => '',
                    'children' => array(
                        array(
                            'id' => 'childlabel',
                            'content' => get_string('textcolor', 'local_mb2megamenu')
                        ),
                        array(
                            'id' => 'hsubcolor',
                            'type' => 'color',
                            'label' => get_string('normalstate', 'local_mb2megamenu'),
                            'desc' => '',
                            'default' => '',
                        ),
                        array(
                            'id' => 'hsubhcolor',
                            'type' => 'color',
                            'label' => get_string('hoverstate', 'local_mb2megamenu'),
                            'desc' => '',
                            'default' => '',
                        ),
                        'level' => 3
                    ),
                    'level' => -1
                ),
                array(
                    'id' => 'hlabel',
                    'type' => 'text',
                    'label' => get_string('hlabel', 'local_mb2megamenu'),
                    'desc' => get_string('hlabeldesc', 'local_mb2megamenu'),
                    'default' => '',
                    'children' => array(
                        array(
                            'id' => 'hlabelcolor',
                            'type' => 'color',
                            'label' => get_string('textcolor', 'local_mb2megamenu'),
                            'desc' => '',
                            'default' => '',
                        ),
                        array(
                            'id' => 'hlabelbgcolor',
                            'type' => 'color',
                            'label' => get_string('bgcolor', 'local_mb2megamenu'),
                            'desc' => '',
                            'default' => '',
                        ),
                        'level' => -1
                    ),
                    'level' => -1
                ),               
                array(
                    'id' => 'icon',
                    'type' => 'icon',
                    'label' => get_string('icon'),
                    'desc' => '',
                    'default' => '',
                    'children' => array(
                        array(
                            'id' => 'childlabel',
                            'content' => get_string('hiconcolor', 'local_mb2megamenu')
                        ),
                        array(
                            'id' => 'hiconcolor',
                            'type' => 'color',
                            'label' => get_string('normalstate', 'local_mb2megamenu'),
                            'desc' => '',
                            'default' => '',
                        ),
                        array(
                            'id' => 'hiconhcolor',
                            'type' => 'color',
                            'label' => get_string('hoverstate', 'local_mb2megamenu'),
                            'desc' => '',
                            'default' => '',
                        ),
                        array(
                            'id' => 'childlabel',
                            'content' => get_string('hiconbgcolor', 'local_mb2megamenu')
                        ),
                        array(
                            'id' => 'hiconbgcolor',
                            'type' => 'color',
                            'label' => get_string('normalstate', 'local_mb2megamenu'),
                            'desc' => '',
                            'default' => '',
                        ),
                        array(
                            'id' => 'hiconhbgcolor',
                            'type' => 'color',
                            'label' => get_string('hoverstate', 'local_mb2megamenu'),
                            'desc' => '',
                            'default' => '',
                        ),
                        'level' => 3
                    ),
                    'level' => -1
                ),  
                array(
                    'id' => 'image',
                    'type' => 'image',
                    'label' => get_string('bgimage', 'local_mb2megamenu'),
                    'desc' => get_string('bgimagedesc', 'local_mb2megamenu'),
                    'default' => '',
                    'level' => 2
                ),
                array(
                    'id' => 'bgcolor',
                    'type' => 'color',
                    'label' => get_string('bgcolor', 'local_mb2megamenu'),
                    'desc' => get_string('bgcolordesc', 'local_mb2megamenu'),
                    'twinlabel1' => get_string('normalstate', 'local_mb2megamenu'),
                    'twinlabel2' => get_string('hoverstate', 'local_mb2megamenu'),
                    'default' => '',
                    'twin' => array(
                        'id' => 'bghcolor',
                        'type' => 'color',
                        'label' => '',
                        'desc' => '',
                        'default' => ''
                    ),
                    'level' => 2
                ),                           
                array(
                    'id' => 'mega',
                    'type' => 'checkbox',
                    'label' => get_string('megamenu', 'local_mb2megamenu'),
                    'desc' => get_string('megamenudesc', 'local_mb2megamenu'),
                    'options' => array(
                        1 => get_string('yes'),
                        0 => get_string('no'),
                    ),
                    'default' => 0,
                    'level' => 1
                ),                
                array(
                    'id' => 'columns',
                    'type' => 'list',
                    'label' => get_string('columns', 'local_mb2megamenu'),
                    'desc' => get_string('columnsdesc', 'local_mb2megamenu'),
                    'options' => array(
                        1 => '1',
                        2 => '2',
                        3 => '3',
                        4 => '4',
                        5 => '5'
                    ),
                    'default' => 3,
                    'level' => 1
                ),
                array(
                    'id' => 'width',
                    'type' => 'list',
                    'label' => get_string('megawidth', 'local_mb2megamenu'),
                    'desc' => get_string('megawidthdesc', 'local_mb2megamenu'),
                    'options' => array(
                        'aw' => get_string('auto', 'local_mb2megamenu'),
                        'fw' => get_string('maxwidth', 'local_mb2megamenu'),
                        'cw' => get_string('contentwidth', 'local_mb2megamenu'),
                    ),
                    'default' => 'aw',
                    'level' => 1
                ),
                array(
                    'id' => 'cssclass',
                    'type' => 'text',
                    'label' => get_string('cssclass', 'local_mb2megamenu'),
                    'desc' => get_string('cssclassdesc', 'local_mb2megamenu'),
                    'default' => '',
                    'level' => -1
                )
            );


            return $settings;


        }




        /*
		 *
		 * Method to set list form filed
		 *
		 */
        public static function field_list($setting)
        {

            $output = '';
            $output .= self::field_item_label($setting);

            $output .= '<div class="form-controls">';
            $output .= '<select name="' . $setting['id'] . '" class="mb2megamenu-input input-'. $setting['type'] .' form-control" data-value="' . $setting['default'] . '">';

            foreach ( $setting['options'] as $k => $opt )
            {
                $output .= '<option value="' . $k . '">' . $opt . '</option>';
            }

            $output .= '</select>';
            $output .= '</div>'; // form-controls

            return $output;


        }





        /*
		 *
		 * Method to set checkbox form filed
		 *
		 */
        public static function field_checkbox($setting)
        {

            $output = '';
            $output .= self::field_item_label($setting);

            $output .= '<div class="form-controls">';
            $output .= '<input type="checkbox" class="mb2megamenu-input input-'. $setting['type'] .'" data-value="' . $setting['default'] . '" name="' . $setting['id'] . '">';
            $output .= '</div>'; // form-controls

            return $output;

        }





        /*
		 *
		 * Method to set checkbox form filed
		 *
		 */
        public static function field_icon($setting)
        {

            $output = '';
            $output .= self::field_item_label($setting);

            $output .= '<div class="form-controls">';
            $output .= '<div class="form-preview"></div>';
            $output .= '<div class="form-buttons">';
            $output .= '<button type="button" class="mb2megamenu-icon-select mb2-pb-btn typesuccess sizexs mb2megamenu-activate-option" data-modal="#mb2megamenu-modal-icons">' .
            get_string('select') . '</button>';
            $output .= ' <button type="button" class="mb2megamenu-fieldremove mb2-pb-btn typedanger sizexs">' . get_string('remove') . '</button>';
            $output .= '</div>'; // form-buttons
            $output .= '<input type="hidden" class="mb2megamenu-input input-'. $setting['type'] .'" name="' . $setting['id'] . '" data-value="' . $setting['default'] . '">';
            $output .= self::field_children($setting);
            $output .= '</div>'; // form-controls

            return $output;

        }




        /*
		 *
		 * Method to set checkbox form filed
		 *
		 */
        public static function field_image($setting)
        {

            $output = '';
            $output .= self::field_item_label($setting);

            $output .= '<div class="form-controls">';
            $output .= '<div class="form-preview"></div>';
            $output .= '<div class="form-buttons">';
            $output .= '<button type="button" class="mb2-pb-btn typesuccess sizexs mb2megamenu-activate-option" data-modal="#mb2megamenu-modal-images">' .
            get_string('select') . '</button>';
            $output .= ' <button type="button" class="mb2megamenu-fieldremove mb2-pb-btn typedanger sizexs">' . get_string('remove') . '</button>';
            $output .= '</div>'; // form-buttons
            $output .= '<input type="hidden" class="mb2megamenu-input input-'. $setting['type'] .'" name="' . $setting['id'] . '" data-value="' . $setting['default'] . '">';
            $output .= '</div>'; // form-controls

            return $output;

        }




        /*
		 *
		 * Method to set checkbox form filed
		 *
		 */
        public static function field_text($setting)
        {

            $output = '';
            $output .= self::field_item_label($setting);

            $output .= '<div class="form-controls">';
            $output .= '<input type="text" class="mb2megamenu-input input-'. $setting['type'] .'" name="' . $setting['id'] . '" data-value="' . $setting['default'] . '">';
            $output .= self::field_children($setting);
            $output .= '</div>'; // form-controls

            return $output;

        }
        
        
        
        
        
        
        /*
		 *
		 * Method to set checkbox form filed
		 *
		 */
        public static function field_textarea($setting)
        {

            $output = '';
            $output .= self::field_item_label($setting);

            $output .= '<div class="form-controls">';
            $output .= '<textarea class="mb2megamenu-input input-'. $setting['type'] .'" name="' . $setting['id'] . '">' . $setting['default'] . '</textarea>';
            $output .= self::field_children($setting);
            $output .= '</div>'; // form-controls

            return $output;

        }




        /*
		 *
		 * Method to set checkbox form filed
		 *
		 */
        public static function field_color($setting)
        {

            $output = '';
            $output .= self::field_item_label($setting);
            $twin = isset( $setting['twin'] );            
            $cls = $twin ? ' istwin' : '';
            
            $output .= '<div class="form-controls' . $cls . '">';
            
            $output .= $twin ? '<div class="form-twin-control">' : '';
            $output .= $twin ? '<span class="form-twin-label">' . $setting['twinlabel1'] . ':</span>' : '';
            $output .= '<input type="text" class="mb2megamenu-input mb2color input-'. $setting['type'] .'" name="' . $setting['id'] . '" data-value="' . $setting['default'] . '">';
            $output .= $twin ? '</div>' : '';
            
            if ( isset( $setting['twin'] ) )
            {                
                $twin = $setting['twin'];
                $output .= '<div class="form-twin-control">';
                $output .= '<span class="form-twin-label">' . $setting['twinlabel2'] . ':</span>';
                $output .= '<input type="text" class="mb2megamenu-input mb2color input-'. $twin['type'] .'" name="' . $twin['id'] . '" data-value="' . $twin['default'] . '">';
                $output .= '</div>';
            }
            
            $output .= '</div>'; // form-controls

            return $output;

        }







        /*
		 *
		 * Method to set checkbox form filed
		 *
		 */
        public static function field_item_label($setting)
        {

            $output = '';

            $output .= '<div class="form-label">';
            $output .= '<label>' . $setting['label'] . '</label>';
            $output .= '<div class="desc">' . $setting['desc'] . '</div>';
            $output .= '</div>'; // form-label

            return $output;

        }





        /*
		 *
		 * Method to set checkbox form filed
		 *
		 */
        public static function field_children($setting)
        {

            $output = '';

            if ( ! isset( $setting['children'] ) )
            {
                return;
            }

            $levelcls = $setting['children']['level'] == -1 ? 'all' : $setting['children']['level'];

            $output .= '<div class="form-children-controls level-' . $levelcls . '">';

            foreach ( $setting['children'] as $child )
            {                
                
                if ( ! is_array( $child ) )
                {
                    continue;
                }

                // String case for labels
                if ( $child['id'] === 'childlabel' )
                {
                    $output .= '<div class="form-child-label">' . $child['content'] . ':</div>';
                }                
                else 
                {
                    $output .= '<div class="form-twin-control">';
                    $output .= '<span class="form-twin-label">' . $child['label'] . ':</span>';
                    $output .= '<input type="text" class="mb2megamenu-input mb2color input-'. $child['type'] .'" name="' . $child['id'] . '" data-value="' . $child['default'] . '">';
                    $output .= '</div>';
                } 

            }

            $output .= '</div>'; // form-children-controls

            return $output;            

        }



        /*
		 *
		 * Method to set icons tab
		 *
		 */
        public static function font_icon_tabs()
		{

			$output = '';
			$icons_lineicons = array();
			$path_fa = LOCAL_MB2BUILDER_PATH_THEME_ASSETS . '/font-awesome/css/font-awesome.css';
			$path_glyphicons = LOCAL_MB2BUILDER_PATH_THEME_ASSETS . '/Glyphicons-Halflings/glyphicons.css';
			$path_7stroke = LOCAL_MB2BUILDER_PATH_THEME_ASSETS . '/Pe-icon-7-stroke/css/Pe-icon-7-stroke.css';
			$path_lineicons = LOCAL_MB2BUILDER_PATH_THEME_ASSETS . '/LineIcons/LineIcons.css';
			$path_remixicon = LOCAL_MB2BUILDER_PATH_THEME_ASSETS . '/remixicon/remixicon.css';
			$serachfiled = '<div class="search-modal-item"><input type="text" class="mb2megamenu-search-icon" placeholder="' . get_string( 'searchiconfor', 'local_mb2megamenu' ) . '" /></div>';

			$icons_fa = self::icons( $path_fa );
			$icons_glyphicons = self::icons( $path_glyphicons, 'glyphicon-' );
			$icons_7stroke = self::icons( $path_7stroke, '' );
			$icons_remixicon = self::icons( $path_remixicon, '' );

			if ( file_exists( $path_lineicons ) )
			{
				$icons_lineicons = self::icons( $path_lineicons, '' );
			}

			$output .= '<div class="mb2megamenu-icon-tabs theme-tabs tabs-sm">';
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
				$output .= '<div class="mb2megamenu-icons">';

				foreach ($icons_fa as $k=>$v)
				{
					$output .= '<button type="button" class="mb2megamenu-icon-toinsert themereset" data-iconname="fa ' . $k . '"><i class="fa ' . $k . '"></i></button>';
				}

				$output .= '</div>';
				$output .= '</div>';
			}

			if ( file_exists( $path_glyphicons ) && count( $icons_glyphicons ) )
			{
				$output .= '<div id="tab-font-icons-glyph" class="tab-pane fade">';
				$output .= $serachfiled;
				$output .= '<div class="mb2megamenu-icons">';

				foreach ($icons_glyphicons as $k=>$v)
				{
					$output .= '<button type="button" class="mb2megamenu-icon-toinsert themereset" data-iconname="glyphicon ' . $k . '"><i class="glyphicon ' . $k . '"></i></button>';
				}

				$output .= '</div>';
				$output .= '</div>';
			}

			if ( file_exists( $path_7stroke ) && count( $icons_7stroke ) )
			{
				$output .= '<div id="tab-font-icons-7stroke" class="tab-pane fade">';
				$output .= $serachfiled;
				$output .= '<div class="mb2megamenu-icons">';

				foreach ($icons_7stroke as $k=>$v)
				{
					$output .= '<button type="button" class="mb2megamenu-icon-toinsert themereset" data-iconname="' . $k . '"><i class=" ' . $k . '"></i></button>';
				}

				$output .= '</div>';
				$output .= '</div>';
			}

			if ( file_exists( $path_remixicon ) && count( $icons_remixicon ) )
			{
				$output .= '<div id="tab-font-icons-remix" class="tab-pane fade">';
				$output .= $serachfiled;
				$output .= '<div class="mb2megamenu-icons">';

				foreach ($icons_remixicon as $k=>$v)
				{
					$output .= '<button type="button" class="mb2megamenu-icon-toinsert themereset" data-iconname="' . $k . '"><i class=" ' . $k . '"></i></button>';
				}

				$output .= '</div>';
				$output .= '</div>';
			}

			if ( file_exists( $path_lineicons ) && count( $icons_lineicons ) )
			{
				$output .= '<div id="tab-font-icons-lineicons" class="tab-pane fade">';
				$output .= $serachfiled;
				$output .= '<div class="mb2megamenu-icons">';

				foreach ($icons_lineicons as $k=>$v)
				{
					$output .= '<button type="button" class="mb2megamenu-icon-toinsert themereset" data-iconname="' . $k . '"><i class=" ' . $k . '"></i></button>';
				}

				$output .= '</div>';
				$output .= '</div>';
			}

			$output .= '</div>';
			$output .= '</div>';


			return $output;

		}







        /*
		 *
		 * Method to get icons array from icon css file
		 *
		 */
		public static function icons( $path, $class_prefix = 'fa-', $output_pref = '' )
        {

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





        public static function images()
		{
			global $CFG;
			$output = '';
			$ajaxurl = new moodle_url( $CFG->wwwroot . '/local/mb2megamenu/ajax/image-delete.php', array() );

			$output .= '<div class="search-modal-item"><input type="text" class="mb2megamenu-search-image" placeholder="' . get_string( 'searchimagefor', 'local_mb2megamenu' ) . '" /></div>';
			$output .= '<div class="mb2megamenu-images" data-url="' . $ajaxurl . '">';
			$output .= self::image_preview();
			$output .= '</div>';
			$output .= '<div class="mb2megamenu-overlay"></div>';

			return $output;

		}



        public static function image_preview()
		{
			$output = '';
			$fs = get_file_storage();
			$context = context_system::instance();
			$files = $fs->get_area_files( $context->id, 'local_mb2megamenu', 'mb2megamenumedia' );

			foreach( $files as $f )
			{
				if ( $f->get_filename() === '.' )
				{
					continue;
				}

				$url = moodle_url::make_pluginfile_url( $f->get_contextid(), $f->get_component(), $f->get_filearea(), 0, $f->get_filepath(), $f->get_filename() );

                // For search in modal window we need  the 'simgname' (lowercase image name)

				$output .= '<div class="mb2megamenu-image-toinsert" data-imgname="' . $f->get_filename() . '" data-simgname="' . strtolower($f->get_filename()) . '">';
				$output .= '<button type="button" class="themereset imgremove">&times;</button>';
				$output .= '<button type="button" class="themereset mb2megamenu-insert-image" data-imgurl="' . $url . '">';
				$output .= '<img src="' . $url . '?preview=thumb" alt="' . $f->get_filename() . '" />';
				$output .= '<span class="imgdesc">' . $f->get_filename() . '</span>';
				$output .= '</button>';
				$output .= '</div>';
			}

			return $output;

		}



    }

}