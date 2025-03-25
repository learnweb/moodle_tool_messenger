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
 * Class for persistent messages for the tool_messenger plugin
 *
 * @package tool_messenger
 * @copyright 2021 Robin Tschudi
 * @license http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
namespace tool_messenger;
use core\persistent;

defined('MOODLE_INTERNAL') || die;

/**
 * Class for persistent messages for the tool_messenger plugin
 *
 * @package tool_messenger
 * @copyright 2021 Robin Tschudi
 * @license http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
class message_persistent extends persistent {
    /** Define the constant name. */
    const TABLE = 'tool_messenger_messagejobs';

    /**
     * Properties for persistent messages.
     * @return array[]
     */
    protected static function define_properties() {
        return [
            'message' => [
                'type' => PARAM_RAW,
                'required' => true,
                'message' => new \lang_string('invalidmessage', 'tool_messenger'),
            ],
            'subject' => [
                'type' => PARAM_TEXT,
                'required' => true,
                'message' => new \lang_string('invalidsubject', 'tool_messenger'),
            ],
            'progress' => [
                'type' => PARAM_INT,
                'message' => new \lang_string('invalidprogress', 'tool_messenger'),
            ],
            'priority' => [
                'type' => PARAM_INT,
                'message' => new \lang_string('invalidpriority', 'tool_messenger'),
            ],
            'finished' => [
                'type' => PARAM_INT,
                'message' => new \lang_string('invalidfinished', 'tool_messenger'),
            ],
            'parentid' => [
                'type' => PARAM_INT,
                'message' => new \lang_string('invalidparentid', 'tool_messenger'),
                'null' => NULL_ALLOWED,
                'default' => null,
            ],
            'roleids' => [
                'type' => PARAM_TEXT,
                'message' => new \lang_string('invalidroleids', 'tool_messenger'),
            ],
            'knockoutdate' => [
                'type' => PARAM_INT,
                'message' => new \lang_string('invalidknockoutdate', 'tool_messenger'),
            ],
            'instant' => [
                'type' => PARAM_INT,
                'message' => new \lang_string('invalidinstant', 'tool_messenger'),
            ],
            'senttonum' => [
                'type' => PARAM_INT,
                'message' => new \lang_string('invalidsenttonum', 'tool_messenger'),
            ],
            'aborted' => [
                'type' => PARAM_INT,
                'message' => new \lang_string('invalidaborted', 'tool_messenger'),
            ],
            'totalnumofusers' => [
                'type' => PARAM_INT,
                'message' => new \lang_string('invalidnumofusers', 'tool_messenger'),
            ],
            'failamount' => [
                'type' => PARAM_INT,
                'message' => new \lang_string('invalidfailamount', 'tool_messenger'),
                'default' => 0,
            ],
        ];
    }

}
