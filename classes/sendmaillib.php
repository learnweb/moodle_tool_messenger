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


class sendmaillib {

    public function register_new_job ($data) {
        if ((isset($data->recipients) and count($data->recipients) != 0) or isset($data->followup)) {

            $record = new \stdClass();

            $parentid = null;
            if (isset($data->followup)) {
                $record->parentid = $data->followup;
                $parent = new \tool_messenger\message_persistent(intval($data->followup));
                $parentid = $parent->get("id");
            }
            $knockoutdate = 0;
            if ($data->knockout_enable) {
                $knockoutdate = $data->knockout_date;
            }

            $record->message = $data->message['text'];
            $record->subject = $data->subject;
            $record->progress = 0;
            $record->priority = $data->priority;
            $record->finished = 0;
            $record->parentid = $parentid;
            $record->roleids = implode(",", $data->recipients);
            $record->knockoutdate = $knockoutdate;
            $record->instant = $data->directsend;

            $persistent = new \tool_messenger\message_persistent(0, $record);
            return $persistent->create();
        }
        return null;
    }

    public function abort_job ($jobid) {
        $persistent = new \tool_messenger\message_persistent(intval($jobid));
        $persistent->set('finished', 1);
        $persistent->save();
    }

}