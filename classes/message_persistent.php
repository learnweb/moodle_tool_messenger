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
 * Class for loading/storing messages for the tool_messenger plugin
 *
 * @package tool_messagejobs
 * @copyright 2021 Robin Tschudi
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
                'type' => PARAM_RAW,
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
            'roleids' => array (
                'type' => PARAM_TEXT,
                'message' => new \lang_string('invalidroleids', 'tool_messenger')
            ),
            'knockoutdate' => array (
                'type' => PARAM_INT,
                'message' => new \lang_string('invalidknockoutdate', 'tool_messenger')
            ),
            'instant' => array (
                'type' => PARAM_INT,
                'message' => new \lang_string('invalidinstant', 'tool_messenger')
            ),
            'senttonum' => array (
                'type' => PARAM_INT,
                'message' => new \lang_string('invalidsenttonum', 'tool_messenger')
            ),
            'aborted' => array (
                'type' => PARAM_INT,
                'message' => new \lang_string('invalidaborted', 'tool_messenger')
            ),
            'totalnumofusers' => array (
                'type' => PARAM_INT,
                'message' => new \lang_string('invalidnumofusers', 'tool_messenger')
            ),
            'failamount' => array (
                'type' => PARAM_INT,
                'message' => new \lang_string('invalidfailamount', 'tool_messenger'),
                'default' => 0
            )
        );
    }

}