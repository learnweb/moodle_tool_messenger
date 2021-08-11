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
defined('MOODLE_INTERNAL') || die();

require_once("$CFG->libdir/externallib.php");

/**
 * name of the plugin...
 */
const PLUGINNAME = 'tool_messenger';

/**
 * external api for ajax calls
 * @package tool_messenger
 */
class tool_messenger_external extends external_api {

    /**
     * Returns description of method parameters
     * @return external_function_parameters
     */
    public static function predict_users_parameters() {
        return new external_function_parameters(
            array(
                    'parentid' => new external_value(PARAM_INT, 'parentid', VALUE_DEFAULT, -1),
                    'knockoutdate' => new external_value(PARAM_INT, 'parentid', VALUE_DEFAULT, -1),
                    'roles' => new external_value(PARAM_TEXT, 'parentid', VALUE_DEFAULT, "no_data"),
                )
        );
    }

    /**
     * Returns description of method parameters
     * @return \external_value
     */
    public static function predict_users_returns() {
        return new \external_value(PARAM_TEXT, 'prediction to display');
    }

    /**
     * Returns a prediction to display for the user
     * @param $parentid int
     * @param $knockoutdate int
     * @param $roles string
     * @return lang_string|string
     * @throws coding_exception
     */
    public static function predict_users($parentid, $knockoutdate, $roles) {
        if ($roles == "no data" and $knockoutdate == -1 and $parentid == -1) {
            return (get_string('predicionerror', PLUGINNAME));
        }

        if ($parentid != -1) {
            $parent = new \tool_messenger\message_persistent((int) $parentid);
            $knockoutdate = $parent->get('knockoutdate');
            $roles = $parent->get('roleids');
        }
        $manager = new \tool_messenger\send_manager();
        return (get_string('prediction_about', PLUGINNAME)
            . count($manager->get_userids(explode(",", $roles), $knockoutdate, 0, -1, -1))
            . get_string('prediction_sent', PLUGINNAME));
    }

    /**
     * Returns description of method parameters
     * @return external_function_parameters
     */
    public static function get_message_parameters() {
        return new external_function_parameters(
            array(
                'id' => new external_value(PARAM_INT, 'id', VALUE_REQUIRED),
            )
        );
    }

    /**
     * Returns description of method parameters
     * @return \external_value
     */
    public static function get_message_returns() {
        return new \external_value(PARAM_RAW, 'json encoded data for the message');
    }

    /**
     * Returns a the message as json object
     * @param $id int
     * @return string
     * @throws coding_exception
     */
    public static function get_message($id) {
        global $DB;

        $message = $DB->get_field(\tool_messenger\message_persistent::TABLE, 'message', array('id' => $id));
        $subject = $DB->get_field(\tool_messenger\message_persistent::TABLE, 'subject', array('id' => $id));

        return json_encode(array('message' => $message, 'subject' => $subject));
    }

    /**
     * Returns description of method parameters
     * @return external_function_parameters
     */
    public static function get_popups_for_user_parameters() {
        return new external_function_parameters(array());
    }

    /**
     * Returns description of method parameters
     * @return \external_value
     */
    public static function get_popups_for_user_returns() {
        return new \external_value(PARAM_RAW, 'json response');
    }

    public static function get_popups_for_user () {
        global $USER, $DB;
        $userid = intval($USER->id);
        $roleids = $DB->get_fieldset_sql("SELECT DISTINCT roleid FROM {role_assignments} WHERE userid=" . $userid);
        $lastpopupid = $DB->get_field('tool_messenger_popuptracking', 'lastpopup', array('userid' => $userid));

        if ($lastpopupid === false) {
            \tool_messenger\locallib::track_user_popups($userid);
            $lastpopupid = 0;
        }

        $popups = \tool_messenger\popup_persistent::get_popups_for_role_since($roleids, $lastpopupid);
        $cleanedpopups = array_map(function($data) {
            return ['id' => $data->get('id'), 'header' => $data->get('header'), 'message' => $data->get('message')];
        }, $popups);
        return json_encode($cleanedpopups);
    }

    /**
     * Returns description of method parameters
     * @return external_function_parameters
     */
    public static function set_lastpopupid_for_user_parameters() {
        return new external_function_parameters(array(
            'lastpopupid' => new external_value(PARAM_INT, 'lastpopupid', VALUE_REQUIRED),
        ));
    }

    /**
     * Returns description of method parameters
     * @return \external_value
     */
    public static function set_lastpopupid_for_user_returns() {
        return null;
    }

    public static function set_lastpopupid_for_user ($lastpopupid) {
        global $USER, $DB;
        $userid = intval($USER->id);
        $DB->set_field('tool_messenger_popuptracking', 'lastpopup', $lastpopupid, array('userid' => $userid));
    }
}
