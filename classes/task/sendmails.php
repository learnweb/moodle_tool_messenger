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

use tool_messenger\send_manager;

defined('MOODLE_INTERNAL') || die();


class sendmails extends \core\task\scheduled_task {
    /**
     * Get a descriptive name for this task (shown to admins).
     *
     * @return string
     * @throws \coding_exception
     */
    public function get_name () {
        return get_string('sendmailstask', 'tool_messenger');
    }
    /**
     * This will start and close surveys.
     */
    // It's important to note that this might use alot of space
    // ...if the Plugin data is never deleted. There would be multiple solutions for this.
    // At the moment manual removal is advised. However since you're here I assume you have some problems...
    // My personal advice is to either move records that are in the past to another table, so you can still display the dates,
    // ...or to simply remove a record once the message is send.
    public function execute () {
        $sendmailmanager = new send_manager();
        $sendmailmanager->run_to_cronlimit();
    }
}
