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

use core\task\adhoc_task;
use tool_messenger\send_manager;

class sendmailsinstant extends adhoc_task {

    public function execute() {
        $data = $this->get_custom_data();
        $sendmanager = new send_manager();
        $sendmanager->send_emails_for_job($data->jobid);
    }
}