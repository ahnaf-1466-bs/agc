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


if ( ! class_exists('Mb2builderFootersApi') )
{

    class Mb2builderFootersApi
    {


        /**
         *
         * Method to get a list of all services.
         *
         */
        public static function get_list_records($limitfrom = 0, $limitnum = 0)
        {
            global $DB;

            $records = $DB->get_records('local_mb2builder_footers', null, 'id', '*', $limitfrom, $limitnum);

            return $records;

        }






        /**
         *
         * Method to get sindle record.
         *
         */
        public static function get_record( $itemid = 0, $footerid = false )
        {
            global $DB;

            if ( $footerid )
            {
                return $DB->get_record_sql( 'SELECT * FROM {local_mb2builder_footers} WHERE footerid = ?', array( $itemid ) );
            }

            return $DB->get_record( 'local_mb2builder_footers', array( 'id' => $itemid ), '*', MUST_EXIST );

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
         * Method to fave footer during editing
         *
         */
        public static function get_form_democontent( $opts = array() )
        {
            global $CFG, $USER;
            $output = '';
            $ajaxurl = new moodle_url( $CFG->wwwroot . '/local/mb2builder/ajax/save-footer.php', array() );

            $output .= '<form id="mb2-pb-form-democontent" action="" method="" data-url="' . $ajaxurl . '">';
            $output .= '<input type="hidden" name="sesskey" value="' . $USER->sesskey . '" />';
            $output .= '<input type="hidden" name="itemid" id="democontentitemid" value="' . $opts['itemid'] . '" />';
            $output .= '<input type="hidden" name="footerid" id="democontentfooterid" value="' . $opts['footerid'] . '" />';
            $output .= '<textarea name="democontent" id="democontent"></textarea>';
            $output .= '<input type="submit" value="Submit">';
            $output .= '</form>';

            return $output;

        }



        /**
         *
         * Method to check if footer with specific footerid exists
         *
         */
        public static function is_footerid( $id, $footerid = false )
        {
            global $DB;

            if ( ! $id )
            {
                return false;
            }

            // We have to search by footerid
            if ( $footerid )
            {
                $sql = 'SELECT * FROM {local_mb2builder_footers} WHERE footerid = ?';
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

            $data->id = $DB->insert_record( 'local_mb2builder_footers', array( 'sortorder' => count( $items ) + 1 ) );

            self::update_record_data( $data );

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
            $DB->update_record( 'local_mb2builder_footers', $data );

        }




        /**
         *
         * Method to check if user can delete item.
         *
         */
        public static function can_delete()
        {
            return has_capability( 'local/mb2builder:managefooters', context_system::instance() );
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

            $DB->delete_records( 'local_mb2builder_footers', array( 'id' => $itemid ) );

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
            if ( ! $opts['itemid'] && ! $opts['footerid'] )
            {
                $data->id = null;
                $data->name = null;
                $data->timecreated = null;
                $data->createdby = null;
            }

            // This is the case when user back to the footer
            if ( $opts['itemid'] )
            {
                $data = self::get_record( $opts['itemid'] );
            }

            // This is the case when user editing footer first time
            // itemid doesn't appear in the url, there is only footerid
            // We need to search record by footerid instead itemid
            // This is require because if user cancel settings option iframe will be reloaded and user lost all earlier changes
            if ( $opts['footerid'] )
            {
                // We have to check if footer exists
                // If yes we will get data from the existing record
                if ( Mb2builderFootersApi::is_footerid( $opts['footerid'], true ) )
                {
                    $data = self::get_record( $opts['footerid'], true );
                }
                // If record doesn't exists we have to create it
                // For this we need define some data parts
                else
                {
                    $data->footerid = $opts['footerid'];
                    $data->name = $opts['name'] ? urldecode( $opts['name'] ) : 'Footer' . time();
                }
            }

            // Set date created and modified
            $data->timecreated = isset( $data->timecreated ) ? $data->timecreated : time();
            $data->timemodified = $data->timecreated < time() ? time() : 0;

            // Set create and modifier
            $data->createdby = isset( $data->createdby ) ? $data->createdby : $USER->id;
            $data->modifiedby = $data->timecreated == time() ? 0 : $USER->id;

            // Set demo content when footer is saved via AJAX request
            // This is used in 'save-footer.php' files
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




        /*
         *
         * Method to get user
         *
         */
        public static function get_user( $id )
        {
            global $DB;

            if ( ! $id )
            {
                return;
            }

            return $DB->get_record( 'user', array( 'id'=> $id ) );
        }




        /*
         *
         * Method to footers array for select
         *
         */
        public static function get_footers_for_select()
        {

            $footers = array( 0 => get_string('selectfooter', 'local_mb2builder') );

            $createdfooters = self::get_list_records();

            if ( ! count($createdfooters) )
            {
                return $footers;
            }

            foreach ($createdfooters as $f )
            {
                $footers[$f->id] = $f->name;
            }

            return $footers;

        }

    }
}
