<?php
// This file is part of the Moodle plugin tool_messenger
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


defined('MOODLE_INTERNAL') || die;

if ($hassiteconfig) { // Needs this condition or there is error on login page.
    $category = new admin_category('tool_messenger_category',
        get_string('tool_messenger', 'tool_messenger'));
    $ADMIN->add('tools', $category);

    $settings = new admin_settingpage('tool_messenger',
        get_string('general_config_header', 'tool_messenger'));
    $ADMIN->add('tool_messenger_category', $settings);

    $settings->add(new admin_setting_configtext('tool_messenger/emailspercron',
        get_string('cronjobamount', 'tool_messenger'),
        '',
        1000
    ));

    $settings->add(new admin_setting_configtext('tool_messenger/sendinguserid',
        get_string('sendinguserid', 'tool_messenger'),
        '',
        \core_user::get_noreply_user()->id
    ));

    $settings->add(new admin_setting_configduration('tool_messenger/cleanupduration',
        get_string('cleanupduration', 'tool_messenger'),
        '',
        90 * 24 * 60 * 60
    )); // Dafault value is 180 days.

    $ADMIN->add('tool_messenger_category', new admin_externalpage('tool_messenger_messaging',
        get_string('sendmessage_section', 'tool_messenger'),
        new moodle_url('/admin/tool/messenger/sendmessage.php')));
}
$settings = null;