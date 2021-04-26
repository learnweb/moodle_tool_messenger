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


class send_manager {

    public function send_emails_for_job_with_limit($jobid, $limit) {
        global $DB;
        $jobdata = new message_persistent($jobid);
        if (!message_persistent::try_lock($jobdata)) {
            return 0;
        }
        $progress = $jobdata->get('progress');
        $userids = $jobdata->get('userids');
        $message = $jobdata->get('message');
        $subject = $jobdata->get('subject');
        $userfrom = \core_user::get_user(get_config('tool_messenger', 'sendinguserid'));
        $useridarray = explode(",", $userids);
        if ($limit === -1) {
            if (!empty($parentid = $jobdata->get('parentid'))) {
                $parent = new message_persistent($parentid);
                $limit = $parent->get('progress');
            } else {
                $limit = null;
            }
        } else {
            if (!empty($parentid = $jobdata->get('parentid'))) {
                $parent = new message_persistent($parentid);
                $limit = min($parent->get('progress'), $limit);
            }
        }
        $userbatch = array_slice($useridarray, $progress, $limit);
        foreach ($userbatch as $userid) {
            $userto = \core_user::get_user($userid);
            email_to_user($userto, $userfrom, $subject, $message);
        }
        if (count($useridarray) <= $progress + count($userbatch)) {
            $jobdata->set('finished', 1);
        }
        $jobdata->set('progress', $progress + count($userbatch));
        $jobdata->set('lock', 0); // Unlock.
        $jobdata->save();
        return count($userbatch);
    }

    public function send_emails_for_job($jobid) {
        $this->send_emails_for_job_with_limit($jobid, -1);
    }

    public function run_to_cronlimit() {
        global $DB;
        $cronlimit = get_config('tool_messenger', 'emailspercron');
        $jobids = $DB->get_fieldset_sql(
            "SELECT id FROM {tool_messenger_messagejobs} WHERE finished != 1 ORDER BY priority DESC, timecreated ASC");

        if (count($jobids) == 0) {
            return;
        }

        $amount = 0;
        $i = 0;
        while ($amount < $cronlimit && $i < count($jobids)) {
            $amount += $this->send_emails_for_job_with_limit($jobids[$i], $cronlimit);
            $i++;
        }
    }

}