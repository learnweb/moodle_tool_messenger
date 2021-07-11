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
        $jobdata = new message_persistent($jobid);
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
            $roleids = explode(",", $parent->get('roleids'));
            $knockoutdate = $jobdata->get('knockoutdate');
        }

        $userbatch = $this->get_userids($roleids, $knockoutdate, $progress, $limit, $parentlimit);
        $lastprocesseduser = -1;
        foreach ($userbatch as $userid) {
            $lastprocesseduser = max(intval($userid->userid), $lastprocesseduser);
            $userto = \core_user::get_user($userid->userid);
            // Why is the return of email_to_user not checked?
            // email_to_user returns true if sending was successfull false if not. However it also returns false...
            // if the error is with the users config, for example a deleted user, a user with no email etc.
            // because of this if we'd stop execution on getting a false here we might get stuck on a single invalid...
            // user record.
            email_to_user($userto, $userfrom, $subject, $message);
        }
        $numofprocessedusers = count($userbatch);
        if ($limit > $numofprocessedusers && ($parentlimit == -1 or $parent->get('finished'))) {
            $jobdata->set('finished', 1);
        }
        if ($numofprocessedusers > 0) {
            $jobdata->set('progress', $lastprocesseduser);
            $jobdata->set('senttonum', $jobdata->get('senttonum') + $numofprocessedusers);
        }
        $jobdata->save();
        return $numofprocessedusers;
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

        $amountofmailssent = 0;
        $i = 0;
        foreach ($instantjobids as $instantjob) {
            $amountofmailssent += $this->send_emails_for_job_with_limit($instantjob, -1);
        }
        while ($amountofmailssent <= $cronlimit && $i < count($standardjobids)) {
            $amountofmailssent += $this->send_emails_for_job_with_limit($standardjobids[$i], ($cronlimit - $amountofmailssent));
            $i++;
        }
    }

    public function get_userids($roleids, $knockoutdate, $progress, $limit, $parentlimit): array {
        global $DB;
        if (count($roleids) == 0 or $roleids[0] == "") {
            return [];
        }
        $sql = "SELECT DISTINCT userid FROM {role_assignments} ra JOIN {user} u ON u.id = ra.userid";
        $where = " WHERE (roleid = " . $roleids[0];
        for ($i = 1; $i < count($roleids); $i++) {
            $where .= "OR roleid = " . $roleids[$i];
        }
        $where .= ") AND u.lastaccess >= $knockoutdate";
        $where .= " AND userid > $progress";
        if ($parentlimit >= 0) {
            $where .= " AND userid <= $parentlimit";
        }
        $sqllimit = " ORDER BY userid ASC";
        if ($limit >= 0) {
            $sqllimit .= " LIMIT $limit";
        }

        $userids = $DB->get_records_sql($sql . $where . $sqllimit);
        return $userids;
    }

}