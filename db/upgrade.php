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
 * This file keeps track of upgrades to the tool_messenger plugin
 *
 * Sometimes, changes between versions involve alterations to database
 * structures and other major things that may break installations. The upgrade
 * function in this file will attempt to perform all the necessary actions to
 * upgrade your older installation to the current version. If there's something
 * it cannot do itself, it will tell you what you need to do.  The commands in
 * here will all be database-neutral, using the functions defined in DLL libraries.
 *
 * @package   tool_messenger
 * @license   http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

defined('MOODLE_INTERNAL') || die();

/**
 * Execute tool_messenger upgrade from the given old version
 *
 * @param int $oldversion
 * @return bool
 */
function xmldb_tool_messenger_upgrade ($oldversion) {
    global $DB;
    $dbman = $DB->get_manager();
    if ($oldversion < 2021040602) {

        $table = new xmldb_table('tool_messenger_messagejobs');

        $table->add_field('id', XMLDB_TYPE_INTEGER, '10', null, XMLDB_NOTNULL, XMLDB_SEQUENCE, null);
        $table->add_field('usermodified', XMLDB_TYPE_INTEGER, '10', null, XMLDB_NOTNULL, null, null);
        $table->add_field('timecreated', XMLDB_TYPE_INTEGER, '10', null, XMLDB_NOTNULL, null, null);
        $table->add_field('timemodified', XMLDB_TYPE_INTEGER, '10', null, XMLDB_NOTNULL, null, null);
        $table->add_field('message', XMLDB_TYPE_TEXT, null, null, XMLDB_NOTNULL, null, null);
        $table->add_field('progress', XMLDB_TYPE_INTEGER, '5', null, XMLDB_NOTNULL, null, null);
        $table->add_field('userids', XMLDB_TYPE_TEXT, null, null, XMLDB_NOTNULL, null, null);
        $table->add_field('lock', XMLDB_TYPE_INTEGER, '10', null, null, null);
        $table->add_field('priority', XMLDB_TYPE_INTEGER, '3', null, XMLDB_NOTNULL, null, null);
        $table->add_field('finished', XMLDB_TYPE_INTEGER, '1', null, XMLDB_NOTNULL, null, 0);
        $table->add_field('parentid', XMLDB_TYPE_INTEGER, '10', null, null, null);

        // Adding keys to table.
        $table->add_key('primary', XMLDB_KEY_PRIMARY, array('id'));

        // Conditionally launch create table.
        if (!$dbman->table_exists($table)) {
            $dbman->create_table($table);
        }

        // savepoint reached.
        upgrade_plugin_savepoint(true, 2021040602, 'tool', 'messenger');
    }

    if ($oldversion < 2021040603) {

        $table = new xmldb_table('tool_messenger_messagejobs');

        $table->add_field('subject', XMLDB_TYPE_TEXT, null, null, XMLDB_NOTNULL, null, null);

        foreach ($table->getFields() as $item) {
            if (!$dbman->field_exists($table, $item)) {
                $dbman->add_field($table, $item);
            }
        }

        upgrade_plugin_savepoint(true, 2021040603, 'tool', 'messenger');
    }

    if ($oldversion < 2021040610) {
        $table = new xmldb_table('tool_messenger_messagejobs');
        $field = new xmldb_field('userids', XMLDB_TYPE_TEXT, null, null, XMLDB_NOTNULL, null, null);
        if ($dbman->field_exists($table, $field)) {
            $dbman->drop_field($table, $field);
        }
        $table->add_field('roleids', XMLDB_TYPE_TEXT, null, null, XMLDB_NOTNULL, null);
        $table->add_field('knockoutdate', XMLDB_TYPE_INTEGER, '10', null, null, null);
        $table->add_field('instant', XMLDB_TYPE_INTEGER, '1', null, null, null);

        foreach ($table->getFields() as $item) {
            if (!$dbman->field_exists($table, $item)) {
                $dbman->add_field($table, $item);
            }
        }
        upgrade_plugin_savepoint(true, 2021040610, 'tool', 'messenger');
    }

    if ($oldversion < 2021043001) {
        $table = new xmldb_table('tool_messenger_messagejobs');

        $table->add_field('senttonum', XMLDB_TYPE_INTEGER, '10', null, XMLDB_NOTNULL, null, 0);
        $table->add_field('aborted', XMLDB_TYPE_INTEGER, '1', null, null, null, null);
        foreach ($table->getFields() as $item) {
            if (!$dbman->field_exists($table, $item)) {
                $dbman->add_field($table, $item);
            }
        }

        upgrade_plugin_savepoint(true, 2021043001, 'tool', 'messenger');
    }

    if ($oldversion < 2021053001) {
        $table = new xmldb_table('tool_messenger_messagejobs');
        $field = new xmldb_field('aborted', XMLDB_TYPE_INTEGER, '1', null, null, null, null);
        if ($dbman->field_exists($table, $field)) {
            $dbman->drop_field($table, $field);
        }

        $table->add_field('aborted', XMLDB_TYPE_INTEGER, '1', null, XMLDB_NOTNULL, null, 0);
        $table->add_field('totalnumofusers', XMLDB_TYPE_INTEGER, '10', null, XMLDB_NOTNULL, null, 0);
        foreach ($table->getFields() as $item) {
            if (!$dbman->field_exists($table, $item)) {
                $dbman->add_field($table, $item);
            }
        }
        upgrade_plugin_savepoint(true, 2021053001, 'tool', 'messenger');
    }

    if ($oldversion < 2021070800) {
        $table = new xmldb_table('tool_messenger_messagejobs');
        $field = new xmldb_field('lock', XMLDB_TYPE_INTEGER, '10', null, null, null);
        if ($dbman->field_exists($table, $field)) {
            $dbman->drop_field($table, $field);
        }
        upgrade_plugin_savepoint(true, 2021070800, 'tool', 'messenger');
    }

    if ($oldversion < 2021072900) {
        $table = new xmldb_table('tool_messenger_messagejobs');

        $table->add_field('failamount', XMLDB_TYPE_INTEGER, '10', null, XMLDB_NOTNULL, null, 0);
        foreach ($table->getFields() as $item) {
            if (!$dbman->field_exists($table, $item)) {
                $dbman->add_field($table, $item);
            }
        }

        upgrade_plugin_savepoint(true, 2021072900, 'tool', 'messenger');
    }

    if ($oldversion < 2021080500) {
        $table = new xmldb_table('tool_messenger_messagejobs');
        $field = new xmldb_field('progress', XMLDB_TYPE_INTEGER, '10', null, XMLDB_NOTNULL, null, null);
        $dbman->change_field_precision($table, $field);

        upgrade_plugin_savepoint(true, 2021080500, 'tool', 'messenger');
    }

    if ($oldversion < 2021081000) {
        $table = new xmldb_table('tool_messenger_popups');

        $table->add_field('id', XMLDB_TYPE_INTEGER, '10', null, XMLDB_NOTNULL, XMLDB_SEQUENCE, null);
        $table->add_field('usermodified', XMLDB_TYPE_INTEGER, '10', null, XMLDB_NOTNULL, null, null);
        $table->add_field('timecreated', XMLDB_TYPE_INTEGER, '10', null, XMLDB_NOTNULL, null, null);
        $table->add_field('timemodified', XMLDB_TYPE_INTEGER, '10', null, XMLDB_NOTNULL, null, null);
        $table->add_field('message', XMLDB_TYPE_TEXT, null, null, XMLDB_NOTNULL, null, null);
        $table->add_field('header', XMLDB_TYPE_TEXT, null, null, XMLDB_NOTNULL, null, null);
        $table->add_field('roleids', XMLDB_TYPE_TEXT, null, null, XMLDB_NOTNULL, null);

        // Adding keys to table.
        $table->add_key('primary', XMLDB_KEY_PRIMARY, array('id'));

        // Conditionally launch create table.
        if (!$dbman->table_exists($table)) {
            $dbman->create_table($table);
        }

        upgrade_plugin_savepoint(true, 2021081000, 'tool', 'messenger');
    }

    if ($oldversion < 2021081003) {
        $table = new xmldb_table('tool_messenger_popuptracking');

        $table->add_field('id', XMLDB_TYPE_INTEGER, '10', null, XMLDB_NOTNULL, XMLDB_SEQUENCE, null);
        $table->add_field('userid', XMLDB_TYPE_INTEGER, '10', null, XMLDB_NOTNULL, null, null);
        $table->add_field('lastpopup', XMLDB_TYPE_INTEGER, '10', null, XMLDB_NOTNULL, null, null);
        // Adding keys to table.
        $table->add_key('primary', XMLDB_KEY_PRIMARY, array('id'));

        // Conditionally launch create table.
        if (!$dbman->table_exists($table)) {
            $dbman->create_table($table);
        }

        upgrade_plugin_savepoint(true, 2021081003, 'tool', 'messenger');
    }

    if ($oldversion < 2021081006) {
        $table = new xmldb_table('tool_messenger_popups');

        $table->add_field('enddate', XMLDB_TYPE_INTEGER, '10', null, XMLDB_NOTNULL, null, 0);

        foreach ($table->getFields() as $item) {
            if (!$dbman->field_exists($table, $item)) {
                $dbman->add_field($table, $item);
            }
        }
        upgrade_plugin_savepoint(true, 2021081006, 'tool', 'messenger');
    }

    if ($oldversion < 2021101900) {
        $table = new xmldb_table('tool_messenger_messagejobs');
        $table->add_field('firstlogindate', XMLDB_TYPE_INTEGER, '10', null, null, null, 0);

        foreach ($table->getFields() as $item) {
            if (!$dbman->field_exists($table, $item)) {
                $dbman->add_field($table, $item);
            }
        }
        upgrade_plugin_savepoint(true, 2021101900, 'tool', 'messenger');
    }

    if ($oldversion < 2021102402) {
        $table = new xmldb_table('tool_messenger_popups');
        $table->add_field('firstlogindate', XMLDB_TYPE_INTEGER, '10', null, null, null, 0);

        foreach ($table->getFields() as $item) {
            if (!$dbman->field_exists($table, $item)) {
                $dbman->add_field($table, $item);
            }
        }
        upgrade_plugin_savepoint(true, 2021101902, 'tool', 'messenger');
    }

    return true;
}
