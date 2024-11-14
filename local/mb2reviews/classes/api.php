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
 * @package    local_mb2reviews
 * @copyright  2021 Mariusz Boloz (mb2themes.com)
 * @license    Commercial https://themeforest.net/licenses
 */

defined('MOODLE_INTERNAL') || die();



if ( ! class_exists( 'Mb2reviewsApi' ) )
{
    class Mb2reviewsApi
    {



        /**
         *
         * Method to get a list of all services.
         *
         */
        public static function get_list_records( $courseid = 0, $isenabled = false, $content = false, $count = false, $limitfrom = 0, $limitnum = 0 )
        {
            global $DB;

            $params = array();
            $sqlquery = '';
            $sqlorder = '';
            $sqlwhere = ' WHERE 1=1';

            if ( $courseid )
            {
                $params[] = $courseid;
                $sqlwhere .= ' AND course=?';
            }

            if ( $isenabled )
            {
                $params[] = 1;
                $sqlwhere .= ' AND enable=?';
            }

            if ( $content )
            {
                $sqlwhere .= ' AND content!=\'\'';
            }

            if ( $count )
            {
                $limitfrom = 0;
                $limitnum = 0;
                $sqlquery .= 'SELECT COUNT(*)';
            }
            else
            {
                $sqlquery .= 'SELECT *';
                $sqlorder .= ' ORDER BY id DESC';
            }

            $sqlquery .= ' FROM {local_mb2reviews_items}';

            if ( $count )
            {
                return $DB->count_records_sql( $sqlquery . $sqlwhere . $sqlorder, $params, $limitfrom, $limitnum );
            }

            return $DB->get_records_sql( $sqlquery . $sqlwhere . $sqlorder, $params, $limitfrom, $limitnum );

        }




        /**
         *
         * Method to get sindle record.
         *
         */
        public static function get_record( $itemid = 0 )
        {
            global $DB;

            $record = $DB->get_record( 'local_mb2reviews_items', array( 'id' => $itemid ), '*', MUST_EXIST );

            return $record;

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
         * Method to update the prev or next record
         *
         */
        public static function get_sortorder_items($courseid = 0 )
        {

            $newitems = array();
            $items = self::get_list_records( $courseid );

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

            $items = self::get_list_records();
            $data->id = $DB->insert_record( 'local_mb2reviews_items', array( 'sortorder' => count( $items ) + 1 ) );

            return self::update_record_data( $data );

        }




        /**
         *
         * Method to set editor options.
         *
         */
        public static function text_editor_options()
        {
            global $CFG;
            require_once($CFG->libdir.'/formslib.php');
            $options = array();

            $options['subdirs'] = false;
            $options['maxfiles'] = -1;
            $options['context'] = context_system::instance();

            return $options;

        }





        /**
         *
         * Method to set editor options.
         *
         */
        public static function file_area_options()
        {
            global $CFG;
            require_once($CFG->libdir.'/formslib.php');
            $options = array();

            $options['subdirs'] = false;
            $options['maxfiles'] = 1;
            $options['context'] = context_system::instance();

            return $options;

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
            $DB->update_record('local_mb2reviews_items', $data);

        }




        /**
         *
         * Method to check if user can delete item.
         *
         */
        public static function can_delete()
        {
            return has_capability('local/mb2reviews:deleteitems', context_system::instance());
        }




        /**
         *
         * Method to check if user can edit item.
         *
         */
        public static function can_edit()
        {
            return has_capability('local/mb2reviews:manageitems', context_system::instance());
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

            $DB->delete_records( 'local_mb2reviews_items', array( 'id' => $itemid ) );

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

            foreach ( $sortorder_items as $item )
            {
                $i++;
                $callbacksorted = $items[$item];
                $callbacksorted->sortorder = $i;
                self::update_record_data($callbacksorted);
            }

        }





        /**
         *
         * Method to change item status.
         *
         */
        public static function switch_status($itemid = 0)
        {

            $items = self::get_list_records();
            $item = $items[$itemid];
            $item->enable = !$item->enable;
            self::update_record_data( $item );

        }




        /**
         *
         * Method to change item status.
         *
         */
        public static function switch_featured($itemid = 0)
        {

            $items = self::get_list_records();
            $item = $items[$itemid];
            $item->featured = !$item->featured;
            self::update_record_data( $item );

        }



        /**
         *
         * Method to change item status.
         *
         */
        public static function update_feedback($itemid, $feedback, $oldfeedback)
        {

            $item = self::get_record( $itemid );

            if ( ( $oldfeedback === 'yes' && $feedback === 'yes' ) || ( $oldfeedback === '' && $feedback === 'no' ) )
            {
                $item->helpful = $item->helpful - 1;
            }
            elseif ( ( $oldfeedback === 'no' && $feedback === 'no' ) || ( $oldfeedback === '' && $feedback === 'yes' ) )
            {
                $item->helpful = $item->helpful + 1;
            }
            elseif ( $oldfeedback === 'no' && $feedback === 'yes' )
            {
                $item->helpful = $item->helpful + 2;
            }
            elseif ( $oldfeedback === 'yes' && $feedback === 'no' )
            {
                $item->helpful = $item->helpful - 2;
            }
            elseif ( $oldfeedback === '' && $feedback === 'no' )
            {
                $item->helpful = $item->helpful - 2;
            }

            self::update_record_data( $item );

        }







        /**
         *
         * Method to get form data.
         *
         */
        public static function get_form_data( $form, $itemid = 0 )
        {
            global $CFG, $USER;
            require_once( $CFG->libdir . '/formslib.php' );
            $data = new stdClass();
            $options = get_config('local_mb2reviews');
            $isenable = $options->autoapprove ? 1 : 0;
            $urlrating = optional_param( 'rating', 0, PARAM_INT );

            if ( ! $itemid )
            {
                $data->id = null;
                $data->rating = $urlrating;
                $data->course = optional_param( 'course', 0, PARAM_INT );
                $data->enable = $isenable;
                $data->timecreated = null;
                $data->createdby = null;
            }
            else
            {
                $data = self::get_record( $itemid );
            }

            // Set rating data
            $data->rating = $urlrating ? $urlrating : $data->rating;

            // Set date created and modified
            $data->timecreated = $data->timecreated ? $data->timecreated : time();
            $data->timemodified = $data->timecreated < time() ? time() : 0;

            // Set create and modifier
            $data->createdby = $data->createdby ? $data->createdby : $USER->id;
            $data->modifiedby = $data->timecreated == time() ? 0 : $USER->id;

            $form->set_data($data);

            return $form->get_data();

        }






        /**
         *
         * Method to move up item.
         *
         */
        public static function move_up ($itemid = 0)
        {

            $items = self::get_list_records();
            $previtem = self::get_record_near($itemid, 'prev');

            if ($previtem)
            {
                // Move down prev item
                $itemprev = $items[$previtem];
                $itemprev->sortorder = $itemprev->sortorder + 1;
                self::update_record_data($itemprev);

                // Move up current item
                $currentitem = $items[$itemid];
                $currentitem->sortorder = $currentitem->sortorder - 1;
                self::update_record_data($currentitem);
            }

        }






        /**
         *
         * Method to move down item.
         *
         */
        public static function move_down ($itemid = 0)
        {

            $items = self::get_list_records();
            $nextitem = self::get_record_near($itemid, 'next');

            if ($nextitem)
            {
                // Move up next item
                $itemnext = $items[$nextitem];
                $itemnext->sortorder = $itemnext->sortorder - 1;
                self::update_record_data($itemnext);

                // Move down current item
                $currentitem = $items[$itemid];
                $currentitem->sortorder = $currentitem->sortorder + 1;
                self::update_record_data($currentitem);
            }

        }




        /**
         *
         * Method to get course record.
         *
         */
        public static function get_course( $courseid )
        {
            global $DB;

            $sqlquery = 'SELECT id, fullname FROM {course} WHERE id = ?';

            if ( $DB->record_exists_sql( $sqlquery, array( $courseid ) ) )
            {
                return $DB->get_record_sql( $sqlquery, array( $courseid ) );
            }

            return false;

        }






        /*
         *
         * Method to get user
         *
         */
        public static function get_user($id)
        {
            global $DB;

            $sqlquery = 'SELECT firstname, lastname FROM {user} WHERE id = ?';

            if ( $DB->record_exists_sql( $sqlquery, array( $id ) ) )
            {
                return $DB->get_record_sql( $sqlquery, array( $id ) );
            }

            return false;
        }



    }
}
