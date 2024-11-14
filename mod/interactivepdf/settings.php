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
 * Administration settings definitions for the interactivepdf module.
 *
 * @package   mod_interactivepdf
 * @copyright 2010 Petr Skoda
 * @license   http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

use mod_interactivepdf\admin\review_setting;

defined('MOODLE_INTERNAL') || die();

require_once($CFG->dirroot . '/mod/interactivepdf/lib.php');
require_once($CFG->dirroot . '/mod/interactivepdf/locallib.php');

// First get a list of interactivepdf reports with there own settings pages. If there none,
// we use a simpler overall menu structure.
$reports = core_component::get_plugin_list_with_file('interactivepdf', 'settings.php', false);
$reportsbyname = [];
foreach ($reports as $report => $reportdir) {
    $strreportname = get_string($report . 'report', 'interactivepdf_'.$report);
    $reportsbyname[$strreportname] = $report;
}
core_collator::ksort($reportsbyname);

// First get a list of interactivepdf reports with there own settings pages. If there none,
// we use a simpler overall menu structure.
$rules = core_component::get_plugin_list_with_file('interactivepdfaccess', 'settings.php', false);
$rulesbyname = [];
foreach ($rules as $rule => $ruledir) {
    $strrulename = get_string('pluginname', 'interactivepdfaccess_' . $rule);
    $rulesbyname[$strrulename] = $rule;
}
core_collator::ksort($rulesbyname);

// Create the interactivepdf settings page.
if (empty($reportsbyname) && empty($rulesbyname)) {
    $pagetitle = get_string('modulename', 'interactivepdf');
} else {
    $pagetitle = get_string('generalsettings', 'admin');
}
$interactivepdfsettings = new admin_settingpage('modsettinginteractivepdf', $pagetitle, 'moodle/site:config');

if ($ADMIN->fulltree) {
    // Introductory explanation that all the settings are defaults for the add interactivepdf form.
    $interactivepdfsettings->add(new admin_setting_heading('interactivepdfintro', '', get_string('configintro', 'interactivepdf')));

    // What to do with overdue attempts.
    $setting = new \mod_interactivepdf\admin\overdue_handling_setting('interactivepdf/overduehandling',
        get_string('overduehandling', 'interactivepdf'), get_string('overduehandling_desc', 'interactivepdf'),
        ['value' => 'autosubmit', 'adv' => false], null);
    $setting->set_locked_flag_options(admin_setting_flag::ENABLED, false);
    $interactivepdfsettings->add($setting);

    // Number of attempts.
    $options = [get_string('unlimited')];
    for ($i = 1; $i <= INTERACTIVEPDF_MAX_ATTEMPT_OPTION; $i++) {
        $options[$i] = $i;
    }
    $setting = new admin_setting_configselect('interactivepdf/attempts',
        get_string('attemptsallowed', 'interactivepdf'), get_string('configattemptsallowed', 'interactivepdf'),
        0, $options);
    $setting->set_advanced_flag_options(admin_setting_flag::ENABLED, false);
    $setting->set_locked_flag_options(admin_setting_flag::ENABLED, false);
    $interactivepdfsettings->add($setting);

    // Grading method.
    $setting = new \mod_interactivepdf\admin\grade_method_setting('interactivepdf/grademethod',
        get_string('grademethod', 'interactivepdf'), get_string('configgrademethod', 'interactivepdf'),
        ['value' => INTERACTIVEPDF_GRADEHIGHEST, 'adv' => false], null);
    $setting->set_locked_flag_options(admin_setting_flag::ENABLED, false);
    $interactivepdfsettings->add($setting);

    // Maximum grade.
    $setting = new admin_setting_configtext('interactivepdf/maximumgrade',
        get_string('maximumgrade'), get_string('configmaximumgrade', 'interactivepdf'), 10, PARAM_INT);
    $setting->set_locked_flag_options(admin_setting_flag::ENABLED, false);
    $interactivepdfsettings->add($setting);
}

if (empty($reportsbyname) && empty($rulesbyname)) {
    $ADMIN->add('modsettings', $interactivepdfsettings);
} else {
    $ADMIN->add('modsettings', new admin_category('modsettingsinteractivepdfcat',
        get_string('modulename', 'interactivepdf'), $module->is_enabled() === false));
    $ADMIN->add('modsettingsinteractivepdfcat', $interactivepdfsettings);
}
$settings = null; // We do not want standard settings link.