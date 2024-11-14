<?php
// This file is part of Moodle - https://moodle.org/
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
// along with Moodle.  If not, see <https://www.gnu.org/licenses/>.

/**
 * Version details of mod_interactivepdf.
 *
 * @package    mod_interactivepdf
 * @copyright  2023 @Md. Faisal Abid
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
//echo "Hello";
global $DB, $PAGE, $CFG, $OUTPUT;
require_once(__DIR__ . '/../../../config.php');
require_once("../lib.php");

$id = required_param("id", PARAM_INT); // Course_module ID
$pageid = required_param("pageid", PARAM_INT); // Page ID
$contentid = optional_param("contentid",null, PARAM_INT);

$cm = get_coursemodule_from_id('interactivepdf', $id, 0, false, MUST_EXIST);
$course = $DB->get_record('course', array('id' => $cm->course), '*', MUST_EXIST);
$moduleinstance = $DB->get_record('interactivepdf', array('id' => $cm->instance), '*', MUST_EXIST);

require_login($course, true, $cm);
$context = context_module::instance($cm->id);

$PAGE->set_url('/mod/interactivepdf/view_page.php', array('id' => $id, 'pageid' => $pageid));
$PAGE->set_title("Interactive PDF - Page");
$PAGE->set_heading("Interactive PDF - Page");

// Fetch the page content using $pageid
$page = $DB->get_record('interactivepdf_pages', array('id' => $pageid));

//$content = $DB->get_record('interactivepdf_contents',array('contentid' => $content));


$sql = "SELECT h.id as contentid, h.html, h.timecreated, h.timemodified";
$sql .= " FROM {interactivepdf_htmls} h";
$sql .= " JOIN {interactivepdf_contents} c ON c.id = h.content_id";
$sql .= " WHERE c.page_id = :pageid";

$contents = $DB->get_records_sql($sql, ['pageid' => $pageid]);
foreach ($contents as $content){
    $html = interactivepdf_prepear_html_data_for_view($content,$context);

}
//$htmls = $DB->get_records('interactivepdf_htmls');
// Render the template
$display = (object) [
    'cmid' => $id,
    'pageid' => $pageid,
    'page' => $page->title,
    'contents' => array_values($contents),
];

echo $OUTPUT->header();

echo $OUTPUT->render_from_template('mod_interactivepdf/view_page', $display);

echo $OUTPUT->footer();