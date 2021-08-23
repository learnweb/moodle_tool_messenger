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
 * This file keeps track of the capabilities of the tool_messenger plugin
 *
 * @package   tool_messenger
 * @license   http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 * @copyright Robin Tschudi 2021
 */

defined('MOODLE_INTERNAL') || die();

$services = array (
    'tool_messenger_fetchlazydata' => array (
        'functions' => array('tool_messenger_predict_users', 'tool_messenger_get_message'),
        'requirecapability' => 'moodle/site:config',
        'restricteduseres' => 0,
        'enabled' => 1,
        'downloadfiles' => 0,
        'uploadfiles' => 0
    )
);
$functions = array (
    'tool_messenger_predict_users' => array (
        'classname' => 'tool_messenger_external',
        'methodname' => 'predict_users',
        'classpath' => 'admin/tool/messenger/externallib.php',
        'description' => 'predicts users that are being sent a message',
        'type' => 'read',
        'ajax' => 'true',
        'capabilities' => 'moodle/site:config'
    ),
    'tool_messenger_get_message' => array (
        'classname' => 'tool_messenger_external',
        'methodname' => 'get_message',
        'classpath' => 'admin/tool/messenger/externallib.php',
        'description' => 'gets a message from a job',
        'type' => 'read',
        'ajax' => 'true',
        'capabilities' => 'moodle/site:config'
    )
);
