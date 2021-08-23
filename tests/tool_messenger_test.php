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
 * Test script for the moodle tool_messenger plugin.
 *
 * @package    tool_messenger
 * @copyright  2021 Robin Tschudi
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
defined('MOODLE_INTERNAL') || die();
/**
 * Test class for the moodle tool_messenger plugin.
 *
 * @package    tool_messenger
 * @copyright  2021 Robin Tschudi | WWU Münster
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
class tool_messenger_testcase extends advanced_testcase {


    /**
     * Set up the test environment.
     */
    protected function setUp() {
        parent::setUp();
        $this->resetAfterTest(true);
        $generator = self::getDataGenerator();
        $timestamp = time();
        $timestamponeyearago = $timestamp - 31622600;

        $course1 = $generator->create_course();
        $course2 = $generator->create_course();

        $student1 = $generator->create_and_enrol($course1, 'student', array('username' => 'student1', 'lastaccess' => $timestamp));
        $student2 = $generator->create_and_enrol($course2, 'student', array('username' => 'student2', 'lastaccess' => $timestamp));
        $student3 = $generator->create_and_enrol($course1, 'student', array('username' => 'student3', 'lastaccess' => $timestamponeyearago));

        $teacher1 = $generator->create_and_enrol($course1, 'teacher', array('username' => 'teacher1', 'lastaccess' => $timestamp));
        $teacher2 = $generator->create_and_enrol($course2, 'teacher', array('username' => 'teacher2', 'lastaccess' => $timestamp));
        $teacher3 = $generator->create_and_enrol($course1, 'teacher', array('username' => 'teacher3', 'lastaccess' => $timestamponeyearago));
    }

    /**
     * Test if Mails are sent.
     * @throws \core\invalid_persistent_exception
     * @throws coding_exception
     * @throws dml_exception
     */
    public function test_sending_mails() {
        $data = new \stdClass();
        $data->recipients = array($this->get_roleid('teacher'));
        $data->subject = 'subject';
        $data->message = array('text' => 'message');
        $data->directsend = 0;
        $data->knockout_enable = 0;
        $data->priority = 1;

        $lib = new \tool_messenger\locallib();
        $lib->register_new_job($data);

        $sink = $this->redirectEmails();
        set_config('emailspercron', 6, 'tool_messenger');
        $manager = new \tool_messenger\send_manager();
        $manager->run_to_cronlimit();

        $messages = $sink->get_messages();
        $this->assertEquals(3, count($messages));
        $this->assertStringContainsString('subject', $messages[0]->subject);
        $this->assertStringContainsString('message', $messages[0]->body);
    }

    /**
     * Test if the cronlimit works.
     * @throws \core\invalid_persistent_exception
     * @throws coding_exception
     * @throws dml_exception
     */
    public function test_cronlimit() {
        $data = new \stdClass();
        $data->recipients = array($this->get_roleid('teacher'));
        $data->subject = 'subject';
        $data->message = array('text' => 'message');
        $data->directsend = 0;
        $data->knockout_enable = 0;
        $data->priority = 1;

        $lib = new \tool_messenger\locallib();
        $lib->register_new_job($data);

        $sink = $this->redirectEmails();
        set_config('emailspercron', 2, 'tool_messenger');
        $manager = new \tool_messenger\send_manager();

        $manager->run_to_cronlimit();
        $this->assertEquals(2, $sink->count());
        $sink->clear();

        $manager->run_to_cronlimit();
        $this->assertEquals(1, $sink->count());
    }

    /**
     * Test whether users who did not log in are excluded.
     * @throws \core\invalid_persistent_exception
     * @throws coding_exception
     * @throws dml_exception
     */
    public function test_knockoutdate() {
        $data = new \stdClass();
        $timestamplessthanoneyearago = time() - 31622600 + 1;
        $data->recipients = array($this->get_roleid('teacher'));
        $data->subject = 'subject';
        $data->message = array('text' => 'message');
        $data->directsend = 0;
        $data->knockout_enable = 1;
        $data->knockout_date = $timestamplessthanoneyearago;
        $data->priority = 1;

        $lib = new \tool_messenger\locallib();
        $lib->register_new_job($data);

        $sink = $this->redirectEmails();
        set_config('emailspercron', 3, 'tool_messenger');
        $manager = new \tool_messenger\send_manager();

        $manager->run_to_cronlimit();
        $this->assertEquals(2, $sink->count());
    }

    /**
     * Test the instant sending feature
     * @throws \core\invalid_persistent_exception
     * @throws coding_exception
     * @throws dml_exception
     */
    public function test_instant_sending() {
        $data = new \stdClass();
        $timestamplessthanoneyearago = time() - 31622600 + 1;
        $data->recipients = array($this->get_roleid('teacher'));
        $data->subject = 'subject';
        $data->message = array('text' => 'message');
        $data->directsend = 1;
        $data->knockout_enable = 1;
        $data->knockout_date = $timestamplessthanoneyearago;
        $data->priority = 1;

        $lib = new \tool_messenger\locallib();
        $lib->register_new_job($data);

        $sink = $this->redirectEmails();
        set_config('emailspercron', 1, 'tool_messenger');
        $manager = new \tool_messenger\send_manager();

        $manager->run_to_cronlimit();
        $this->assertEquals(2, $sink->count());
    }

    /**
     * Test the follow up feature.
     * @throws \core\invalid_persistent_exception
     * @throws coding_exception
     * @throws dml_exception
     */
    public function test_followup() {
        $data = new \stdClass();
        $data->recipients = array($this->get_roleid('teacher'));
        $data->subject = 'subject';
        $data->message = array('text' => 'message');
        $data->directsend = 0;
        $data->knockout_enable = 0;
        $data->priority = 1;

        $lib = new \tool_messenger\locallib();
        $parentid = $lib->register_new_job($data);

        $data->recipients = array();
        $data->priority = 2;
        $data->message = array('text' => 'followup');
        $data->followup = $parentid->get('id');
        $lib->register_new_job($data);

        $sink = $this->redirectEmails();
        set_config('emailspercron', 2, 'tool_messenger');
        $manager = new \tool_messenger\send_manager();

        $manager->run_to_cronlimit();
        $messages = $sink->get_messages();
        $this->assertEquals(2, count($messages));
        $this->assertStringContainsString('message', $messages[0]->body);
        $this->assertStringContainsString('message', $messages[1]->body);
        $sink->clear();

        $manager->run_to_cronlimit();
        $messages = $sink->get_messages();
        $this->assertEquals(2, count($messages));
        $this->assertStringContainsString('followup', $messages[0]->body);
        $this->assertStringContainsString('followup', $messages[1]->body);
        $sink->clear();

        $manager->run_to_cronlimit();
        $messages = $sink->get_messages();
        $this->assertEquals(1, count($messages));
        $this->assertStringContainsString('message', $messages[0]->body);
        $sink->clear();

        $manager->run_to_cronlimit();
        $messages = $sink->get_messages();
        $this->assertEquals(1, count($messages));
        $this->assertStringContainsString('followup', $messages[0]->body);
    }

    /**
     * Test the abort feature.
     * @throws \core\invalid_persistent_exception
     * @throws coding_exception
     * @throws dml_exception
     */
    public function test_abort() {
        $data = new \stdClass();
        $data->recipients = array($this->get_roleid('teacher'));
        $data->subject = 'subject';
        $data->message = array('text' => 'message');
        $data->directsend = 0;
        $data->knockout_enable = 0;
        $data->priority = 1;

        $lib = new \tool_messenger\locallib();
        $jobid = $lib->register_new_job($data);
        $lib->abort_job($jobid->get('id'));

        $sink = $this->redirectEmails();
        set_config('emailspercron', 6, 'tool_messenger');
        $manager = new \tool_messenger\send_manager();

        $manager->run_to_cronlimit();

        $messages = $sink->get_messages();
        $this->assertEquals(0, count($messages));
    }

    /**
     * Test the priority feature.
     * @throws \core\invalid_persistent_exception
     * @throws coding_exception
     * @throws dml_exception
     */
    public function test_priority() {
        $data = new \stdClass();
        $data->recipients = array($this->get_roleid('teacher'));
        $data->subject = 'subject';
        $data->message = array('text' => 'message');
        $data->directsend = 0;
        $data->knockout_enable = 0;
        $data->priority = 1;

        $lib = new \tool_messenger\locallib();
        $lib->register_new_job($data);
        $data->priority = 2;
        $data->message = array('text' => 'prioritymessage');
        $lib->register_new_job($data);

        $sink = $this->redirectEmails();
        set_config('emailspercron', 3, 'tool_messenger');
        $manager = new \tool_messenger\send_manager();

        $manager->run_to_cronlimit();

        $messages = $sink->get_messages();
        $this->assertEquals(3, count($messages));
        $this->assertStringContainsString('prioritymessage', $messages[0]->body);
        $this->assertStringContainsString('prioritymessage', $messages[1]->body);
        $this->assertStringContainsString('prioritymessage', $messages[2]->body);
        $sink->clear();

        $manager->run_to_cronlimit();

        $messages = $sink->get_messages();
        $this->assertEquals(3, count($messages));
        $this->assertStringContainsString('message', $messages[0]->body);
        $this->assertStringContainsString('message', $messages[1]->body);
        $this->assertStringContainsString('message', $messages[2]->body);
    }

    /**
     * Get the role id.
     * @param $role
     * @return false|mixed
     * @throws dml_exception
     */
    private function get_roleid($role) {
        global $DB;
        return $DB->get_field('role', 'id', array('shortname' => $role));
    }
}

