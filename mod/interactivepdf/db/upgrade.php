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
 *
 *
 * @package    mod_management
 * @copyright  2022 Brain station 23 ltd <>  {@link https://brainstation-23.com/}
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
function xmldb_interactivepdf_upgrade($oldversion) {
    global $DB;

    $dbman = $DB->get_manager();

    function xmldb_mod_customfields_upgrade($oldversion) {
        global $DB;

        $table = new xmldb_table('interactivepdf_attempts');

        if ($oldversion < 20230519247) {
            // Add teacher_signature field.
            $field = new xmldb_field('teacher_signature', XMLDB_TYPE_TEXT, '255', null, null, null, null, 'timefinish');
            $dbman->add_field($table, $field);

            // Add student_signature field.
            $field = new xmldb_field('student_signature', XMLDB_TYPE_TEXT, '255', null, null, null, null, 'teacher_signature');
            $dbman->add_field($table, $field);

            // Moodle 3.1 and later require this line.
            upgrade_plugin_savepoint(true, 20230519247, 'mod', 'interactivepdf');
        }

        return true;
    }

    if ($oldversion < 2023051914) {
        // Define table interactivepdf_attempts
        $table = new xmldb_table('interactivepdf_attempts');

        // Define table fields
        $table->add_field('id', XMLDB_TYPE_INTEGER, '10', null, XMLDB_NOTNULL, XMLDB_SEQUENCE);
        $table->add_field('interactivepdfid', XMLDB_TYPE_INTEGER, '10', null, XMLDB_NOTNULL);
        $table->add_field('attempt', XMLDB_TYPE_INTEGER, '10', null, XMLDB_NOTNULL);
        $table->add_field('userid', XMLDB_TYPE_INTEGER, '10', null, XMLDB_NOTNULL);
        $table->add_field('status', XMLDB_TYPE_INTEGER, '10', null, XMLDB_NOTNULL);
        $table->add_field('timemodified', XMLDB_TYPE_INTEGER, '10', '0', XMLDB_NOTNULL);

        // Define table keys
        $table->add_key('primary', XMLDB_KEY_PRIMARY, ['id']);
        $table->add_key('interactivepdfid', XMLDB_KEY_FOREIGN, ['interactivepdfid'], 'interactivepdf', ['id']);

        // Create the table
        $dbman->create_table($table);

        // Add additional upgrade steps if needed

        // Update the plugin version
        upgrade_plugin_savepoint(true, 2023051914, 'interactivepdf',null);
    }

    // Add more upgrade steps for subsequent versions if needed

    return true;
}
