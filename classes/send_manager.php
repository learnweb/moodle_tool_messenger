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

defined('MOODLE_INTERNAL') || die();

class send_manager {

    public function send_emails_for_job_with_limit($jobid, $limit) {
        global $DB;
        $jobdata = new message_persistent($jobid);
        if (!message_persistent::try_lock($jobdata)) {
            return 0;
        }
        $progress = $jobdata->get('progress');
        $message = $jobdata->get('message');
        $subject = $jobdata->get('subject');
        $roleids = explode(",", $jobdata->get('roleids'));
        $knockoutdate = $jobdata->get('knockoutdate');
        $userfrom = \core_user::get_user(get_config('tool_messenger', 'sendinguserid'));
        $parentlimit = -1;
        if (!empty($parentid = $jobdata->get('parentid'))) {
            $parent = new message_persistent($parentid);
            $parentlimit = $parent->get('progress');
        }
        $userbatch = $this->get_userids($roleids, $knockoutdate, $progress, $limit, $parentlimit);
        foreach ($userbatch as $userid) {
            $userto = \core_user::get_user($userid->userid);
            email_to_user($userto, $userfrom, $subject, $message);
        }
        if ($limit > count($userbatch)) {
            $jobdata->set('finished', 1);
        }
        if (isset($userid)) {
            $jobdata->set('progress', $userid->userid);
        }
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
        $instantjobids = $DB->get_fieldset_sql(
            "SELECT id FROM {tool_messenger_messagejobs} WHERE finished != 1 AND instant = 1" .
            " ORDER BY priority DESC, timecreated ASC");
        $standardjobids = $DB->get_fieldset_sql(
            "SELECT id FROM {tool_messenger_messagejobs} WHERE finished != 1 AND instant = 0" .
                    " ORDER BY priority DESC, timecreated ASC");

        if (count($standardjobids) + count($instantjobids) == 0) {
            return;
        }

        $amount = 0;
        $i = 0;
        foreach ($instantjobids as $instantjob) {
            $amount += $this->send_emails_for_job_with_limit($instantjob, -1);
        }
        while ($amount < $cronlimit && $i < count($standardjobids)) {
            $amount += $this->send_emails_for_job_with_limit($standardjobids[$i], $cronlimit);
            $i++;
        }
    }

    public function get_userids($roleids, $knockoutdate, $progress, $limit, $parentlimit): array {
        global $DB;
        if (count($roleids) == 0) {
            return [];
        }
        $sql = "SELECT DISTINCT userid FROM {role_assignments} ra JOIN {user} u ON u.id = ra.userid";
        $where = " WHERE (roleid = " . $roleids[0];
        for ($i = 1; $i < count($roleids); $i++) {
            $where .= "OR roleid = " . $roleids[$i];
        }
        $where .= ") AND u.lastaccess > $knockoutdate";
        $where .= " AND userid > $progress";
        if ($parentlimit >= 0) {
            $where .= " AND userid <= $parentlimit";
        }
        if ($limit >= 0) {
            $limit = " LIMIT $limit";
        }

        $userids = $DB->get_records_sql($sql . $where . $limit);
        return $userids;
    }

}