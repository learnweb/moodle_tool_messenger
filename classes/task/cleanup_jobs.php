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

/**
 * Taskclass for cleaning up jobs
 */
class cleanup_jobs extends scheduled_task {

    public function get_name() {
        return get_string('cleanupjobstask', 'tool_messenger');
    }

    /**
     * Deletes all jobs that are older than the saveperiod supplied in the plugins config.
     * @throws \dml_exception
     */
    public function execute() {
        global $DB;
        $time = time();
        $saveperiod = get_config('tool_messenger', 'cleanupduration');
        if (!$saveperiod) {
            return;
        }
        $knockoutdate = $time - $saveperiod;
        $DB->execute('DELETE FROM {tool_messenger_messagejobs} WHERE timemodified < ' . $knockoutdate);
    }
}
