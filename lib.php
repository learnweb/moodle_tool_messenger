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
 * @package    tool_messenger
 * @copyright  2021 Robin Tschudi
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

defined('MOODLE_INTERNAL') || die;

require_once($CFG->dirroot . '/admin/tool/messenger/externallib.php');
function tool_messenger_after_config() {
    global $PAGE, $SESSION;
    if (isloggedin() && !isguestuser()) {
        $cooldownperiod = intval(get_config('tool_messenger', 'popupcooldown'));

        if (!isset($SESSION->tool_messenger_popupcheck) ||
            $SESSION->tool_messenger_popupcheck + $cooldownperiod < time()) {

            $SESSION->tool_messenger_popupcheck = time();
            $PAGE->requires->js_call_amd('tool_messenger/popup', 'init');
        }
    }
}
