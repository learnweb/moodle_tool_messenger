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
 * This file keeps track of the task of the tool_messenger plugin
 *
 * @package   tool_messenger
 * @license   http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 * @copyright Robin Tschudi 2021
 */

defined('MOODLE_INTERNAL') || die();

$tasks = array(
    array(
        'classname' => '\tool_messenger\task\send_mails',
        'blocking' => 0,
        'minute' => '*',
        'hour' => '*',
        'day' => '*',
        'month' => '*',
        'dayofweek' => '*',
        'disabled' => 0
    ),
    array(
        'classname' => '\tool_messenger\task\cleanup_jobs',
        'blocking' => 0,
        'minute' => '7',
        'hour' => '3',
        'day' => '1',
        'month' => '*',
        'dayofweek' => '*',
        'disabled' => 0
    ),
);
