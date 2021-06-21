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

namespace tool_messenger\task;

use core\task\scheduled_task;

class cleanup_jobs extends scheduled_task {

    public function get_name() {
        // TODO: Implement get_name() method.
    }

    public function execute() {
        global $DB;
        $time = time();
        $period = get_config('tool_messenger', 'cleanupduration');
        if (!$period) {
            return;
        }
        $knockoutdate = $time - $period;
        $DB->execute('DELETE FROM {tool_messenger_messagejobs} WHERE timemodified < ' . $knockoutdate);
    }
}