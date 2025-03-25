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
 * Local functions for tool_messenger plugin
 *
 * @package tool_messenger
 * @copyright 2021 Robin Tschudi
 * @license http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
namespace tool_messenger;

use coding_exception;
use core\invalid_persistent_exception;
use dml_exception;

/**
 * Local functions for tool_messenger plugin
 *
 * @package tool_messenger
 * @copyright 2021 Robin Tschudi
 * @license http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
class locallib {

    /**
     * Registers a new job for sending a message to a class of users.
     * @param $data object|array
     * @return message_persistent|null
     * @throws coding_exception
     * @throws invalid_persistent_exception|dml_exception
     */
    public function register_new_job($data) {
        if ((isset($data->recipients) and count($data->recipients) != 0) or isset($data->followup)) {

            $record = new \stdClass();

            $knockoutdate = 0;
            if ($data->knockout_enable) {
                $knockoutdate = $data->knockout_date;
            }

            $parentid = null;
            $roleids = implode(",", $data->recipients);
            if (isset($data->followup) && $data->followup != 0) {
                $record->parentid = $data->followup;
                $parent = new \tool_messenger\message_persistent(intval($data->followup));
                $parentid = $parent->get("id");
                $knockoutdate = $parent->get('knockoutdate');
                $roleids = $parent->get('roleids');
            }

            $record->message = $data->message['text'];
            $record->subject = $data->subject;
            $record->progress = 0;
            $record->priority = $data->priority;
            $record->finished = 0;
            $record->parentid = $parentid;
            $record->roleids = $roleids;
            $record->knockoutdate = $knockoutdate;
            $record->instant = $data->directsend;

            $manager = new \tool_messenger\send_manager();
            $roles = $manager->get_userids(explode(",", $roleids), $knockoutdate, 0, -1, -1);
            $record->totalnumofusers = count($roles);
            $record->aborted = 0;
            $record->senttonum = 0;

            $persistent = new \tool_messenger\message_persistent(0, $record);
            return $persistent->create();
        }
        return null;
    }

    /**
     * Aborts the sending of a message to a class of users
     * @param $jobid int the id of the job to cancel
     * @throws coding_exception
     */
    public function abort_job($jobid) {
        $persistent = new \tool_messenger\message_persistent(intval($jobid));
        $persistent->set('finished', 1);
        $persistent->set('aborted', 1);
        $persistent->save();
    }

}
