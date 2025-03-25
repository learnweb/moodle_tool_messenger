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
 * Taskclass for cleaning up jobs
 * @package tool_messenger
 * @copyright 2021 Robin Tschudi
 * @license http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
namespace tool_messenger\task;

use coding_exception;
use core\task\scheduled_task;
use dml_exception;
use lang_string;

/**
 * Taskclass for cleaning up jobs
 * @package tool_messenger
 * @copyright 2021 Robin Tschudi
 * @license http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
class cleanup_jobs extends scheduled_task {

    /**
     * Get the Name.
     * @return lang_string|string
     * @throws coding_exception
     */
    public function get_name() {
        return get_string('cleanupjobstask', 'tool_messenger');
    }

    /**
     * Deletes all jobs that are older than the saveperiod supplied in the plugins config.
     * @throws dml_exception
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
