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

require_once(__DIR__ . '/../../../config.php');

const PLUGINNAME = 'tool_messenger';

require_login();
has_capability('moodle/site:config', context_system::instance()) || die();

$roles = optional_param('roles', "no data", PARAM_TEXT);
$knockoutdate = optional_param('knockoutdate', -1, PARAM_INT);
$parentid = optional_param('parentid', -1, PARAM_INT);

if ($roles == "no data" and $knockoutdate == -1 and $parentid == -1) {
    echo get_string('predicionerror', PLUGINNAME);
    die();
}

if ($parentid != -1) {
    $parent = new \tool_messenger\message_persistent((int) $parentid);
    $knockoutdate = $parent->get('knockoutdate');
    $roles = $parent->get('roleids');
}

$manager = new \tool_messenger\send_manager();
echo get_string('prediction_about', PLUGINNAME);
echo count($manager->get_userids(explode(",", $roles), $knockoutdate, 0, -1, -1));
echo get_string('prediction_sent', PLUGINNAME);
