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

namespace tool_messenger;

/**
 * Local functions for tool_messenger plugin
 */
class locallib {

    private function get_roleids($data) {
        $roleids = implode(",", $data->recipients);
        if (isset($data->followup) && $data->followup != 0) {
            $record->parentid = $data->followup;
            $parent = new \tool_messenger\message_persistent(intval($data->followup));
            $parentid = $parent->get("id");
            $knockoutdate = $parent->get('knockoutdate');
            $roleids = $parent->get('roleids');
        }
        return $roleids;
    }

    /**
     * Registers a new job for sending a message to a class of users.
     * @param $data object|array
     * @return message_persistent|null
     * @throws \coding_exception
     * @throws \core\invalid_persistent_exception
     */
    public function register_new_job ($data) {
        if ((isset($data->recipients) and count($data->recipients) != 0) or isset($data->followup)) {

            $record = new \stdClass();

            $knockoutdate = 0;
            if ($data->knockout_enable) {
                $knockoutdate = $data->knockout_date;
            }

            $parentid = null;
            $roleids = $this->get_roleids($data);

            $record->message = $data->message['text'];
            $record->subject = $data->subject;
            $record->progress = 0;
            $record->priority = $data->priority;
            $record->finished = 0;
            $record->parentid = $parentid;
            $record->roleids = $roleids;
            $record->knockoutdate = $knockoutdate;
            $record->firstlogin = $record->firstloginenable ? $record->firstlogin : 0;
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
     *
     */
    public function register_popup($data) {
        if ((isset($data->recipients) and count($data->recipients) != 0) or isset($data->followup)) {
            $record = new \stdClass();
            $record->header = $data->popupheader;
            $record->message = $data->message['text'];
            $record->roleids = $this->get_roleids($data);
            $record->enddate = $data->popup_enddate;
            $record->firstlogin = $record->firstloginenable ? $record->firstlogin : 0;
            $persistent = new \tool_messenger\popup_persistent(0, $record);
            $persistent->create();
        }
    }

    public function abort_popup ($popupid) {
        $persistent = new \tool_messenger\popup_persistent(intval($popupid));
        $persistent->set('enddate', 0);
        $persistent->save();
    }

    /**
     * Aborts the sending of a message to a class of users
     * @param $jobid int the id of the job to cancel
     * @throws \coding_exception
     */
    public function abort_job ($jobid) {
        $persistent = new \tool_messenger\message_persistent(intval($jobid));
        $persistent->set('finished', 1);
        $persistent->set('aborted', 1);
        $persistent->save();
    }

    public static function track_user_popups ($userid) {
        global $DB;
        $DB->execute("INSERT INTO {tool_messenger_popuptracking} (userid, lastpopup) VALUES($userid, 0)");
    }

}
