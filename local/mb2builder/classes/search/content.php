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
 * Search area for mod_page activities.
 *
 * @package    mod_page
 * @copyright  2015 David Monllao {@link http://www.davidmonllao.com}
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */



namespace local_mb2builder\search;

class content extends \core_search\base {


    public function get_document_recordset($modifiedfrom = 0, \context $context = null)
    {
        global $DB;

        return $DB->get_recordset_select( 'local_mb2builder_pages', 'timemodified >= ?', array( 0 ) );
    }



   /**
    *
    * Method to set search results
    *
    */
   public function get_document( $record, $options = [] )
   {

        // Get the default implementation.
        $doc = \core_search\document_factory::instance( $record->id, $this->componentname, $this->areaname );

        // Get Moodle page module
        $page_mod = $this->get_page_module( $record->id );

        if ( isset( $page_mod->id ) )
        {
            $doc->set( 'title', $page_mod->name );
            $doc->set( 'courseid', $page_mod->course );
        }
        else
        {
            $doc->set( 'title', $record->title );
            $doc->set( 'courseid', 1 );
        }

        // Add the subtitle and additional info fields.
        $doc->set( 'modified', $record->timemodified );
        $doc->set( 'content', $record->content );
        $doc->set( 'contextid', 1 );
        $doc->set( 'owneruserid', $record->createdby );

        return $doc;

    }



    /**
     * Link to the message.
     *
     * @param \core_search\document $doc
     * @return \moodle_url
     */
    public function get_doc_url(\core_search\document $doc)
    {

        $pageid = $this->get_page_instance( $doc->get('itemid') );

        if ( ! $pageid )
        {
            return new \moodle_url( '/local/mb2builder/index.php', array( ) );
        }

        return new \moodle_url( '/mod/page/view.php', array( 'id' => $pageid ) );
    }



    /**
     * Link to the conversation.
     *
     * @param \core_search\document $doc
     * @return \moodle_url
     */
    public function get_context_url(\core_search\document $doc)
    {
        $pageid = $this->get_page_instance( $doc->get('itemid') );

        if ( ! $pageid )
        {
            return new \moodle_url( '/local/mb2builder/index.php', array( ) );
        }

        return new \moodle_url( '/mod/page/view.php', array( 'id' => $pageid ) );
    }



    public function check_access($id) {

        global $DB;
        try {

            $record = $DB->get_record('local_mb2builder_pages', array('id' => $id), '*', MUST_EXIST);

        } catch (\dml_missing_record_exception $ex) {
            // If the record does not exist anymore in Moodle we should return \core_search\manager::ACCESS_DELETED.
            return \core_search\manager::ACCESS_DELETED;
        } catch (\dml_exception $ex) {
            // Skip results if there is any unexpected error.
            return \core_search\manager::ACCESS_DENIED;
        }

        // if ($myobject->visible === false) {
        //     return \core_search\manager::ACCESS_DENIED;
        // }

        return \core_search\manager::ACCESS_GRANTED;
    }




     function get_page_module( $id )
     {
        global $DB;

        // Get page which contains mb2page shortcode
        $pages = $DB->get_records_sql( 'SELECT * FROM {page} WHERE ' .
        $DB->sql_like('content', ':content'), ['content' => '%[mb2page pageid="' . $id . '"%'] );

        // If there is more pages with the same shortcode, get the first one
        return array_shift( $pages );
    }






    function get_page_instance( $id )
    {
       global $DB;

       $page = $this->get_page_module( $id );

       if ( ! isset( $page->id ) )
       {
           return;
       }

       $instance = $DB->get_record( 'course_modules', array( 'id' => $page->id ), 'id', MUST_EXIST );

       return $instance->id;
   }




}
