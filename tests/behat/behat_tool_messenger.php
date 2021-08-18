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

class behat_tool_messenger extends behat_base{

    public const ERRORSAVEPATH = "/var/www/public/moodle/errorbackend.html";

    /**
     * Store Page content on failure
     *
     * @AfterStep
     */
    public function take_screenshot_after_failed_step (Behat\Behat\Hook\Scope\AfterStepScope $scope) {
        $logall = true;
        if (99 === $scope->getTestResult()->getResultCode() || $logall) {
            if (file_exists(self::ERRORSAVEPATH)) {
                $img = $this->getSession()->getDriver()->getContent();
                file_put_contents(self::ERRORSAVEPATH, $img);
            }
        }
    }

    /**
     * @param $table
     * @Then there should be a persistent with the following data:
     */
    public function there_should_be_a_persistent_with_the_following_data ($table) {
        global $DB;
        $persistentid = $DB->get_field_sql("SELECT ID FROM {tool_messenger_messagejobs} ORDER BY ID DESC LIMIT 1");
        $persistent = new \tool_messenger\message_persistent($persistentid);
        $should = $table->getRowsHash();
        foreach ($should as $key => $value) {
            if ($value != $persistent->get($key)) {
                throw new Exception($value . ' does not equal ' . $persistent->get($key) . ' for key ' . $key);
            }
        }
    }

    /**
     * @param $name
     * @Given I check the checkbox with the name :name
     */
    public function i_check_the_checkbox_with_the_name($name) {
        $checkbox = $this->find_field($name);
        $checkbox->check();
    }

    /**
     * @param $name
     * @Given I uncheck the checkbox with the name :name
     */
    public function i_uncheck_the_checkbox_with_the_name($name) {
        $data = $this->find_all('css', '[name=' . $name . ']');
        foreach ($data as $node) {
            $node->uncheck();
        }
        ob_flush();
    }

}
