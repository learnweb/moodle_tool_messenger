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
 * Class for loading/storing course-date pairs in the DB.
 *
 * @package block_evasys_sync
 * @copyright 2019 Robin Tschudi
 * @license http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
namespace tool_messenger;
use core\persistent;

defined('MOODLE_INTERNAL') || die;

class message_persistent extends persistent{
    const TABLE = 'tool_messenger_messagejobs';

    protected static function define_properties() {
        return array(
            'message' => array (
                'type' => PARAM_TEXT,
                'required' => true,
                'message' => new \lang_string('invalidmessage', 'tool_messenger')
            ),
            'subject' => array (
                'type' => PARAM_TEXT,
                'required' => true,
                'message' => new \lang_string('invalidsubject', 'tool_messenger')
            ),
            'progress' => array (
                'type' => PARAM_INT,
                'message' => new \lang_string('invalidprogress', 'tool_messenger')
            ),
            'lock' => array (
                'type' => PARAM_INT,
                'message' => new \lang_string('invalidlock', 'tool_messenger'),
                'null' => NULL_ALLOWED,
                'default' => null
            ),
            'priority' => array(
                'type' => PARAM_INT,
                'message' => new \lang_string('invalidpriority', 'tool_messenger')
            ),
            'finished' => array (
                'type' => PARAM_INT,
                'message' => new \lang_string('invalidfinished', 'tool_messenger')
            ),
            'parentid' => array (
                'type' => PARAM_INT,
                'message' => new \lang_string('invalidparentid', 'tool_messenger'),
                'null' => NULL_ALLOWED,
                'default' => null
            ),
            'userids' => array (
                'type' => PARAM_TEXT,
                'message' => new \lang_string('invaliduserids', 'tool_messenger')
            )
        );
    }

    /**
     * @throws \dml_exception
     */
    public static function get_open_jobs_with_priority(): array {
        global $DB;
        return $DB->get_records_sql("SELECT * FROM {" . TABLE . "} WHERE finished = 0");
    }

    public static function try_lock ($persistent) {
        $lock = $persistent->get('lock');
        if ($lock != 0) {
            // Sanity check.
            $sanitytimeperiod = '+' . get_config('tool_messenger', 'lock_limit') . ' minutes';
            if (strtotime($sanitytimeperiod, $lock) >= time()) {
                return false;
            }
        }
        $persistent->set('lock', time());
        $persistent->save();
        return true;
    }

}