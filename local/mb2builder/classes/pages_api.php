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
 * @package    local_mb2builder
 * @copyright  2018 - 2022 Mariusz Boloz (mb2moodle.com)
 * @license    Commercial https://themeforest.net/licenses
 */

defined('MOODLE_INTERNAL') || die();


if ( ! class_exists('Mb2builderPagesApi') )
{

    class Mb2builderPagesApi
    {


        /**
         *
         * Method to get a list of all services.
         *
         */
        public static function get_list_records($limitfrom = 0, $limitnum = 0)
        {
            global $DB;

            $records = $DB->get_records('local_mb2builder_pages', null, 'id', '*', $limitfrom, $limitnum);

            return $records;

        }






        /**
         *
         * Method to get sindle record.
         *
         */
        public static function get_record( $itemid = 0, $pageid = false )
        {
            global $DB;

            if ( $pageid )
            {
                return $DB->get_record_sql( 'SELECT * FROM {local_mb2builder_pages} WHERE pageid = ?', array( $itemid ) );
            }

            return $DB->get_record( 'local_mb2builder_pages', array( 'id' => $itemid ), '*', MUST_EXIST );

        }




        /**
         *
         * Method to update the prev or next record
         *
         */
        public static function get_record_near($id, $type = 'prev')
        {

            $items = self::get_list_records();
            $newitems = self::get_sortorder_items();
            $nearitem = 0;

            $sortorder = $items[$id]->sortorder;

            // Get preview item
            if ($type === 'prev' && isset($newitems[$sortorder-1]))
            {
                $nearitem = $newitems[$sortorder-1];
            }

            // Get next item
            if ($type === 'next' && isset($newitems[$sortorder+1]))
            {
                $nearitem = $newitems[$sortorder+1];
            }

            return $nearitem;


        }




        /**
         *
         * Method to fave page during editing
         *
         */
        public static function get_form_democontent( $opts = array() )
        {
            global $CFG, $USER;
            $output = '';
            $ajaxurl = new moodle_url( $CFG->wwwroot . '/local/mb2builder/ajax/save-page.php', array() );

            $output .= '<form id="mb2-pb-form-democontent" action="" method="" data-url="' . $ajaxurl . '">';
            $output .= '<input type="hidden" name="sesskey" value="' . $USER->sesskey . '" />';
            $output .= '<input type="hidden" name="itemid" id="democontentitemid" value="' . $opts['itemid'] . '" />';
            $output .= '<input type="hidden" name="pageid" id="democontentpageid" value="' . $opts['pageid'] . '" />';
            $output .= '<textarea name="democontent" id="democontent"></textarea>';
            $output .= '<input type="submit" value="Submit">';
            $output .= '</form>';

            return $output;

        }




        /**
         *
         * Method to search for page shortcode in Moodle page content
         *
         */
        public static function check_for_page( $id )
        {

            global $CFG, $DB;

            $output = '';
            $search = '%[mb2page pageid="'.  $id .'"%';
            $fpsql = 'SELECT * FROM {course_sections} WHERE ' . $DB->sql_like('summary', '?');
            $psql = 'SELECT * FROM {page} WHERE ' . $DB->sql_like('content', '?');

            $output .= '<ul class="mb2-pb-index-pages">';

            if ( $DB->record_exists_sql( $fpsql, array( $search ) ) )
            {
                $url = new moodle_url( $CFG->wwwroot, array( 'redirect' => 0 ) );

                $output .= '<li>';
                $output .= '<a href="' . $url . '">' . get_string( 'sitehome' ) . '</a>';
                $output .= '</li>';
            }
            elseif ( $DB->record_exists_sql( $psql, array( $search ) ) )
            {
                $pages = $DB->get_records_sql( $psql, array( $search ) );

                foreach ( $pages as $p )
                {
                    $modsql = 'SELECT id FROM {course_modules} WHERE instance = ? AND deletioninprogress = 0';

                    if ( ! $DB->record_exists_sql( $modsql, array( $p->id ) ) )
                    {
                        $output .= '<li class="nopages">';
                        $output .= '<span>' . $p->name . '</span>';
                        $output .= '</li>';
                        continue;
                    }

                    //$module = $DB->get_record( 'course_modules', array( 'instance' => $p->id ), 'id', MUST_EXIST );
                    //$url = new moodle_url( '/mod/page/view.php', array( 'id' => $module->id ) );
                    $url = '';
                    $output .= '<li>';
                    //$output .= '<a href="' . $url . '">' . $p->name . '</a>';
                    $output .= '<span>' . $p->name . '</span>';
                    $output .= '</li>';
                }
            }
            else
            {
                $output .= '<li class="nopages">';
                $output .= get_string( 'nopage', 'local_mb2builder' );
                $output .= '</li>';
            }

            $output .= '</ul>';

            return $output;


        }





        /**
         *
         * Method to check if page with specific pageid exists
         *
         */
        public static function is_pageid( $id, $pageid = false )
        {
            global $DB;

            if ( ! $id )
            {
                return false;
            }

            // We have to search by pageid
            if ( $pageid )
            {
                $sql = 'SELECT * FROM {local_mb2builder_pages} WHERE pageid = ?';
            }
            // We have to search by id
            else
            {
                $sql = 'SELECT * FROM {local_mb2builder_pages} WHERE id = ?';
            }

            if ( $DB->record_exists_sql( $sql, array( $id ) ) )
            {
                return true;
            }

            return false;

        }




        /**
         *
         * Method to check if page with specific pageid exists
         *
         */
        public static function is_footerid( $id, $footerid = false )
        {

            global $DB;

            if ( ! $id )
            {
                return false;
            }

            // We have to search by pageid
            if ( $footerid )
            {
                $sql = 'SELECT * FROM {local_mb2builder_footers} WHERE pageid = ?';
            }
            // We have to search by id
            else
            {
                $sql = 'SELECT * FROM {local_mb2builder_footers} WHERE id = ?';
            }

            if ( $DB->record_exists_sql( $sql, array( $id ) ) )
            {
                return true;
            }

            return false;


        }




        /**
         *
         * Method to update the prev or next record
         *
         */
        public static function get_sortorder_items()
        {

            $newitems = array();
            $items = self::get_list_records();

            // Create new array of items
            // Set 'sortorder' as a key of array's values
            foreach ($items as $item)
            {
                $newitems[$item->sortorder] = $item->id;
            }

            // Sort new array by sortorder
            ksort($newitems);

            return $newitems;

        }





        /**
         *
         * Method to add new record.
         *
         */
        public static function add_record( $data )
        {
            global $DB;

            if ( ! $data )
            {
                $data = new stdClass();
            }

            $items = self::get_list_records();

            $data->id = $DB->insert_record( 'local_mb2builder_pages', array( 'sortorder' => count( $items ) + 1 ) );

            self::update_record_data( $data );

        }





        /**
         *
         * Method to update Moodle records.
         *
         */
        public static function update_moodle_page( $pageid, $itemid )
        {
            global $DB;
            $data = new stdClass();

            // Get page content if exists
            $pagecontent = self::get_fp_summary();
            $shortcode = '[mb2page pageid="' . $itemid . '"]';

            if ( $pageid == 0 )
            {
                return;
            }

            // Update front page summary
            if ( $pageid == -1 && self::get_fp_sectionid() )
            {
                $data->id = self::get_fp_sectionid();
                $data->summary = $shortcode;
                $DB->update_record( 'course_sections', $data );
            }
            // Update other pages
            else
            {
                $data->id = $pageid;
                $data->content = $shortcode;
                $DB->update_record( 'page', $data );
            }

        }






        /**
         *
         * Method to get front page course section ID.
         *
         */
        public static function get_fp_sectionid()
        {

            $fp = self::get_fp();

            if ( ! $fp )
            {
                return;
            }

            return $fp->id;

        }





        /**
         *
         * Method to get front page summary content.
         *
         */
        public static function get_fp_summary()
        {

            $fp = self::get_fp();

            if ( ! $fp )
            {
                return;
            }

            return $fp->summary;

        }





        /**
         *
         * Method to get front page
         *
         */
        public static function get_fp()
        {

            global $DB, $SITE;

            $sql = 'SELECT * FROM {course_sections} WHERE course = ? AND section = ?';

            if ( ! $DB->record_exists_sql( $sql, array( $SITE->id, 1 ) ) )
            {
                return null;
            }

            $fp = $DB->get_record( 'course_sections', array( 'course' => $SITE->id, 'section' => 1 ), '*', MUST_EXIST );

            return $fp;

        }







        /**
         *
         * Method to get front page content.
         *
         */
        public static function get_page_content()
        {
            global $DB;

            $id = self::get_page_id();

            if ( ! $id )
            {
                return;
            }

            $pcontent = $DB->get_record( 'page', array( 'id' => $id ), '*', MUST_EXIST );

            return $pcontent->content;
        }





        /**
         *
         * Method to get page id from shortcode.
         *
         */
        public static function get_shortcode_id( $content = '' )
        {

            // This is require because of problem witdh shortcode_parse_atts
            // if inshortcode is '"]' shortcode_parse_atts can't get shortcode pageid
            $content = str_replace( '"]', '" ]', $content );

            $shortcode = self::get_page_shortcode( $content );

            if ( ! isset( $shortcode[0] ) )
            {
                return 0;
            }

            if ( ! function_exists( 'shortcode_parse_atts' ) )
            {
                return 0;
            }

            $attribs = shortcode_parse_atts( $shortcode[0] );

            if ( ! isset( $attribs['pageid'] ) )
            {
                return 0;
            }

            // Now we have to check if page exists
            if ( isset( $attribs['pageid'] ) && ! array_key_exists( $attribs['pageid'], self::get_list_records() ) )
            {
                return 0;
            }

            return $attribs['pageid'];

        }




        /**
         *
         * Method to get apge shortcode regex.
         *
         */
        public static function get_page_shortcode( $content = '' )
        {

            $regex = '\\[(\\[?)(mb2page)\\b([^\\]\\/]*(?:\\/(?!\\])[^\\]\\/]*)*?)(?:(\\/)\\]|\\](?:([^\\[]*+(?:\\[(?!\\/\\2\\])[^\\[]*+)*+)\\[\\/\\2\\])?)(\\]?)';
        	preg_match_all( "/$regex/is", $content, $match );
        	return $match[0];

        }




        /**
         *
         * Method to get page id.
         *
         */
        public static function get_page_id()
        {
            global $PAGE, $DB;

            if ( $PAGE->pagetype !== 'mod-page-view' )
            {
                return;
            }

            if ( ! isset( $PAGE->cm->id ) )
            {
                return;
            }

            $pageid = $DB->get_record( 'course_modules', array( 'id' => $PAGE->cm->id ), 'instance', MUST_EXIST );

            // Get page instance id
            return $pageid->instance;

        }









        /**
         *
         * Method to update the record in the database.
         *
         */
        public static function update_record_data( $data )
        {
            global $DB;

            // Update existing item
            $DB->update_record( 'local_mb2builder_pages', $data );

        }




        /**
         *
         * Method to check if user can delete item.
         *
         */
        public static function can_delete()
        {
            return has_capability( 'local/mb2builder:managepages', context_system::instance() );
        }




        /**
         *
         * Method to delete item.
         *
         */
        public static function delete( $itemid )
        {
            global $DB;

            if ( ! self::can_delete() )
            {
                return;
            }

            $DB->delete_records( 'local_mb2builder_pages', array( 'id' => $itemid ) );

            self::update_sortorder( $itemid );

        }








        /**
         *
         * Method to update sortorder after delet item.
         *
         */
        public static function update_sortorder($itemid = 0)
        {
            $items = self::get_list_records();
            $sortorder_items = self::get_sortorder_items();
            $sortorder_items = array_diff($sortorder_items, array($itemid));
            $i = 0;

            foreach ($sortorder_items as $item)
            {
                $i++;
                $callbacksorted = $items[$item];
                $callbacksorted->sortorder = $i;
                self::update_record_data($callbacksorted);
            }

        }







        /**
         *
         * Method to set form data.
         *
         */
        public static function set_record_data( $opts = array() )
        {

            global $USER;
            $data = new stdClass();

            // This case should't appears but this is for safety
            if ( ! $opts['itemid'] && ! $opts['pageid'] )
            {
                $data->id = null;
                $data->title = null;
                $data->timecreated = null;
                $data->createdby = null;
            }

            // This is the case when user back to the page
            if ( $opts['itemid'] )
            {
                $data = self::get_record( $opts['itemid'] );
            }

            // This is the case when user editing page first time
            // itemid doesn't appear in the url, there is only pageid
            // We need to search record by pageid instead itemid
            // This is require because if user cancel settings option iframe will be reloaded and user lost all earlier changes
            if ( $opts['pageid'] )
            {
                // We have to check if page exists
                // If yes we will get data from the existing record
                if ( Mb2builderPagesApi::is_pageid( $opts['pageid'], true ) )
                {
                    $data = self::get_record( $opts['pageid'], true );
                }
                // If record doesn't exists we have to create it
                // For this we need define some data parts
                else
                {
                    $data->pageid = $opts['pageid'];
                    $data->title = $opts['pagename'] ? urldecode( $opts['pagename'] ) : 'Page' . time();
                }
            }

            // Set date created and modified
            $data->timecreated = isset( $data->timecreated ) ? $data->timecreated : time();
            $data->timemodified = $data->timecreated < time() ? time() : 0;

            // Set create and modifier
            $data->createdby = isset( $data->createdby ) ? $data->createdby : $USER->id;
            $data->modifiedby = $data->timecreated == time() ? 0 : $USER->id;

            // Set demo content when page is saved via AJAX request
            // This is used in 'save-page.php' files
            if ( isset( $opts['democontent'] ) )
            {
                $data->democontent = $opts['democontent'];
            }

            return $data;

        }





        /**
         *
         * Method to get form data.
         *
         */
        public static function get_form_data( $form, $data )
        {
            global $CFG;
            require_once( $CFG->libdir . '/formslib.php' );

            $form->set_data( $data );

            return $form->get_data();

        }






        /**
         *
         * Method to move up item.
         *
         */
        public static function move_up( $itemid = 0 )
        {

            $items = self::get_list_records();
            $previtem = self::get_record_near($itemid, 'prev');

            if ($previtem)
            {
                // Move down prev item
                $itemprev = $items[$previtem];
                $itemprev->sortorder = $itemprev->sortorder + 1;
                self::update_record_data( $itemprev );

                // Move up current item
                $currentitem = $items[$itemid];
                $currentitem->sortorder = $currentitem->sortorder - 1;
                self::update_record_data( $currentitem );
            }

        }






        /**
         *
         * Method to move down item.
         *
         */
        public static function move_down( $itemid = 0 )
        {

            $items = self::get_list_records();
            $nextitem = self::get_record_near($itemid, 'next');

            if ( $nextitem )
            {
                // Move up next item
                $itemnext = $items[$nextitem];
                $itemnext->sortorder = $itemnext->sortorder - 1;
                self::update_record_data( $itemnext );

                // Move down current item
                $currentitem = $items[$itemid];
                $currentitem->sortorder = $currentitem->sortorder + 1;
                self::update_record_data( $currentitem );
            }

        }




        /**
         *
         * Method to check if page module or front page summary has page shortcode.
         *
         */
        public static function has_page()
        {
           global $DB, $PAGE;

           $content = '';

           if ( $PAGE->pagetype === 'mod-page-view' )
           {
               $content = self::get_page_content();
           }
           // added $PAGE->pagelayout === 'frontpage'
           // IRITH HERMAN case
           elseif ( $PAGE->pagetype === 'site-index' && $PAGE->pagelayout === 'frontpage' )
           {
               $content = self::get_fp_summary();
           }

           // Check if mb2page shortcode exists
           // And check if mb2page with specific ID exists
           $mb2page = self::get_shortcode_id( $content );

           if ( $mb2page )
           {
               return true;
           }

           return false;

       }



    }
}
