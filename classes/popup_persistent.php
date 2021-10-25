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
use core\persistent;

defined('MOODLE_INTERNAL') || die;

class popup_persistent extends persistent {
    const TABLE = 'tool_messenger_popups';

    protected static function define_properties() {
        return array(
            'header' => array(
                'type' => PARAM_RAW,
                'required' => true,
                'message' => new \lang_string('invalidheader', 'tool_messenger')
            ),
            'message' => array(
                'type' => PARAM_RAW,
                'required' => true,
                'message' => new \lang_string('invalidmessage', 'tool_messenger')
            ),
            'roleids' => array (
                'type' => PARAM_TEXT,
                'message' => new \lang_string('invalidroleids', 'tool_messenger')
            ),
            'enddate' => array(
                'type' => PARAM_INT,
                'message' => new \lang_string('invalidenddate', 'tool_messenger')
            ),
            'firstlogindate' => array(
                'type' => PARAM_INT,
                'message' => new \lang_string('invalidenddate', 'tool_messenger')
            ),
        );
    }

    public static function get_popups_for_role_since($roleids, $lastid) {
        global $DB, $USER;
        $recordset = $DB->get_recordset_sql('SELECT * FROM {' . self::TABLE . '} WHERE id>' . $lastid . ' AND enddate>' . time());
        $popups = [];
        foreach ($recordset as $record) {
            if (count(array_intersect(explode(',', $record->roleids), $roleids)) > 0) {
                if ($USER->timecreated >= $record->get('firstlogindate')) {
                    $popups[] = new popup_persistent(0, $record);
                }
            }
        }
        return $popups;
    }
}
