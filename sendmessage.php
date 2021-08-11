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
 * Sendmessage setting site for the tool_messenger Plugin
 *
 * @package tool_messenger
 * @license http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 * @copyright Robin Tschudi 2021
 */

use tool_messenger\message_persistent;

require_once(__DIR__ . '/../../../config.php');
require_once($CFG->libdir . '/adminlib.php');
require_once($CFG->dirroot . '/course/lib.php');
require_login();

// Set the URL that should be used to return to this page.
$PAGE->set_url('/tool/messenger/sendmessage');
$PAGE->set_context(context_system::instance());

if (has_capability('moodle/site:config', context_system::instance())) {
    global $DB;
    echo $OUTPUT->header();
    echo $OUTPUT->heading(get_string('settings', 'tool_messenger'));

    $followuprequest = isset($_POST['followup']);
    if (isset($_POST['cancelmessagebutton'])) {
        $followuprequest = false;
    }

    $mform = new tool_messenger\send_message_form(null, array('customdata' => array('followuprequest' => $followuprequest)));

    if ($data = $mform->get_data()) {
        if (isset($data->abort) && $data->abort > 0) {
            $lib = new \tool_messenger\locallib();
            $lib->abort_job($data->abort);
        }
        if (isset($data->sendmessagebutton)) {
            $lib = new \tool_messenger\locallib();
            if ($data->type <= 1) {
                $lib->register_new_job($data);
            }
            if ($data->type >= 1) {
                $lib->register_popup($data);
            }
        }
    }

    $mform->print_table();

    $PAGE->requires->js_call_amd('tool_messenger/options', 'init');
    if ($followuprequest) {
        $parent = new message_persistent($data->followup);
        $PAGE->requires->js_call_amd('tool_messenger/followup', 'set_correct_parent_date', array($parent->get('knockoutdate')));
    } else {
        $PAGE->requires->js_call_amd('tool_messenger/followup', 'set_correct_parent_date', array(strtotime('-1 years', time())));
    }
    $mform->display();
    echo $OUTPUT->footer();
}
