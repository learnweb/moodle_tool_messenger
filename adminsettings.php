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
 * Settings for the evasys_sync block
 *
 * @package block_evasys_sync
 * @license http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

require_once(__DIR__ . '/../../../config.php');
require_once($CFG->libdir . '/adminlib.php');
require_once($CFG->dirroot . '/course/lib.php');
$delid = optional_param('d', 0, PARAM_INT);
$confirm = optional_param('c', 0, PARAM_INT);
require_login();

// Set the URL that should be used to return to this page.
$PAGE->set_url('/tool/messenger/adminsettings');
$PAGE->set_context(context_system::instance());

if (has_capability('moodle/site:config', context_system::instance())) {
    global $DB;
    echo $OUTPUT->header();
    echo $OUTPUT->heading(get_string('settings', 'tool_messenger'));

    $mform = new tool_messenger\admin_form();

    if ($data = $mform->get_data()) {
        if (isset($data->saveconfigbutton)) {
            if (isset($data->emailspercron)) {
                set_config('emailspercron', $data->emailspercron, 'tool_messenger');
            }
            if (isset($data->sendinguserid)) {
                set_config('sendinguserid', $data->sendinguserid, 'tool_messenger');
            }
            if (isset($data->locklimit)) {
                set_config('locklimit', $data->locklimit, 'tool_messenger');
            }
        }
        if (isset($data->abort)) {
            $persistent = new \tool_messenger\message_persistent(intval($data->abort));
            $persistent->set('finished', 1);
            $persistent->save();
        }
        if (isset($data->sendmessagebutton) and
            ((isset($data->recipients) and count($data->recipients) != 0) or isset($data->followup))) {

            if (isset($data->followup)) {
                $record = new \stdClass();
                $record->parentid = $data->followup;
                $parent = new \tool_messenger\message_persistent(intval($data->followup));
                $record->userids = $parent->get("userids");
                $record->message = $data->message;
                $record->subject = $data->subject;
                $record->progress = 0;
                $record->priority = $data->priority;
                $record->finished = 0;

                $persistent = new \tool_messenger\message_persistent(0, $record);
                $job = $persistent->create();
            } else {
                $sql = "SELECT DISTINCT userid FROM {role_assignments} ra JOIN {user} u ON u.id = ra.userid";
                $where = " WHERE (roleid = " . $data->recipients[0];
                for ($i = 1; $i < count($data->recipients); $i++) {
                    $where .= "OR roleid = " . $data->recipients[$i];
                }
                $where .= ") AND u.lastaccess > " . $data->knockout_date;

                $users = $DB->get_records_sql($sql . $where);
                $record = new \stdClass();
                $record->userids = implode(',', array_keys($users));
                if (count($users) > 0) {
                    $record->message = $data->message;
                    $record->subject = $data->subject;
                    $record->progress = 0;
                    $record->priority = $data->priority;
                    $record->finished = 0;

                    $persistent = new \tool_messenger\message_persistent(0, $record);
                    $job = $persistent->create();
                }
            }

            if (isset($data->directsend) and $data->directsend and $job) {
                $task = new \tool_messenger\task\sendmailsinstant();
                $task->set_custom_data(['jobid' => $job->get('id')]);
                \core\task\manager::queue_adhoc_task($task);
            }
        }
    }

    $mform->display();
    echo $OUTPUT->footer();
}
