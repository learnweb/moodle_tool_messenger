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
 * Tool messenger block admin form.
 *
 * @package block_evasys_sync
 * @copyright 2017 Robin Tschudi
 * @license http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

namespace tool_messenger;

use moodleform;
use html_writer;

defined('MOODLE_INTERNAL') || die;

require_once($CFG->libdir . '/formslib.php');

class sendmessage_form extends moodleform {
    protected function definition() {
        $mform = $this->_form;

        $mform->addElement('html', '<div id="adminsettings">');

        $followuprequest = isset($_POST["followup"]) and !isset($_POST["sendmessagebutton"]);
        if (!$followuprequest) {
            $mform->addElement('hidden', 'followup', null);
            $mform->setType('followup', PARAM_INT);
            $mform->setDefault('followup', 0);
        } else {
            $name = 'followup';
            $title = get_string('followupto', 'tool_messenger');
            $mform->addElement('text', $name, $title);
            $mform->setType($name, PARAM_INT);
            $mform->addHelpButton($name, $name, 'tool_messenger');
            $mform->setDefault($name, $_POST["followup"]);
            $parent = new message_persistent($_POST["followup"]);
        }
        $mform->addElement('hidden', 'abort', null);
        $mform->setType('abort', PARAM_INT);
        $mform->setType('followupto', PARAM_INT);

        $name = 'subject';
        $title = get_string('subject', 'tool_messenger');
        $mform->addElement('textarea', $name, $title, 'wrap="virtual" rows="1" cols="100"');
        $mform->setType($name, PARAM_TEXT);

        $name = 'message';
        $title = get_string('message', 'tool_messenger');
        $mform->addElement('editor', $name, $title,
            array('enable_filemanagement' => false, 'maxfiles' => 0, 'noclean' => true, 'trusttext' => true));
        $mform->setType($name, PARAM_RAW);

        $name = 'recipients';
        $title = get_string('sendto', 'tool_messenger');
        $roles = $this->get_reverse_roles();
        $mform->addElement('select', $name, $title, $roles)->setMultiple(true);
        if ($followuprequest) {
            $mform->disabledIf($name, 'followup', 'neq', 0);
        }
        $name = 'knockout_enable';
        $title = get_string('knockoutenable', 'tool_messenger');
        $mform->addElement('advcheckbox', $name, $title, ' ');
        $default = 1;
        if ($followuprequest) {
            $default = $parent->get('knockoutdate') == 0;
            $mform->disabledIf($name, 'followup', 'neq', 0);
        }
        $mform->setDefault($name, $default);

        $name = 'knockout_date';
        $title = get_string ('knockoutdate', 'tool_messenger');
        $mform->addElement('date_selector', $name, $title, array(
            'startyear' => 2010,
            'stopyear'  => 2030,
            'timezone'  => 99,
            'optional'  => false
        ));
        if ($followuprequest) {
            $timestamp = (int) $parent->get('knockoutdate');
            $mform->setDefault($name, $timestamp);
            $mform->disabledIf($name, 'followup', 'neq', 0);
        } else {
            $timestamp = strtotime('-1 years', time());
            $mform->setDefault($name, $timestamp);
            $mform->disabledIf($name, 'knockout_enable');
        }

        $name = 'predictionlink';
        $title = get_string($name, 'tool_messenger');
        $linktext = get_string('predicitonlinktext', 'tool_messenger');
        $mform->addElement('static', '', $title, '<div col-md-9 form-inline felement>'.
            '<a href="" id="predictiontrigger">'. $linktext . '</a> <div id="predictionbox">' .
            get_string('noprediction', 'tool_messenger') . '</div>'.
            '</div>');

        $name = 'priority';
        $title = get_string('priority', 'tool_messenger');
        $mform->addElement('select', $name, $title, [1, 2, 3, 4, 5]);
        $mform->addHelpButton($name, $name, 'tool_messenger');

        $name = 'directsend';
        $title = get_string('directsend', 'tool_messenger');
        $mform->addElement('advcheckbox', $name, $title, ' ');
        $mform->setType($name, PARAM_BOOL);

        // Add Button.
        $mform->addElement('submit', 'sendmessagebutton', get_string('sendmessagebutton', 'tool_messenger'));

        // Add Table.
        $mform->addElement('html', $this->tablehead());
        $this->table_body();

        $mform->addElement('html', '</div>');
    }

    private function get_roles () {
        global $DB;
        return $DB->get_records_sql_menu('SELECT shortname, id FROM {role}');
    }

    private function get_reverse_roles () {
        global $DB;
        return $DB->get_records_sql_menu('SELECT id, shortname FROM {role}');
    }


    /**
     * Prints the table head (e.g. column names).
     * @return string
     */
    public function tablehead() {
        $attributes['class'] = 'generaltable tool_messenger';
        $attributes['id'] = 'course_category_table';
        $output = html_writer::start_tag('table', $attributes);

        $output .= html_writer::start_tag('thead', array());
        $output .= html_writer::start_tag('tr', array());

        $attributes = array();
        $attributes['class'] = 'header c0';
        $attributes['scope'] = 'col';
        $output .= html_writer::tag('th', get_string('id', 'tool_messenger'), $attributes);
        $attributes = array();
        $attributes['class'] = 'header c1';
        $attributes['scope'] = 'col';
        $output .= html_writer::tag('th', get_string('timereceived', 'tool_messenger'), $attributes);
        $attributes = array();
        $attributes['class'] = 'header c2';
        $attributes['scope'] = 'col';
        $output .= html_writer::tag('th', get_string('message', 'tool_messenger'), $attributes);
        $attributes = array();
        $attributes['class'] = 'header c3';
        $attributes['scope'] = 'col';
        $output .= html_writer::tag('th', get_string('to', 'tool_messenger'), $attributes);
        $attributes = array();
        $attributes['class'] = 'header c4';
        $attributes['scope'] = 'col';
        $output .= html_writer::tag('th', get_string('progress', 'tool_messenger'), $attributes);
        $attributes = array();
        $attributes['class'] = 'header c5';
        $attributes['scope'] = 'col';
        $output .= html_writer::tag('th', get_string('priority', 'tool_messenger'), $attributes);
        $attributes = array();
        $attributes['class'] = 'header c6';
        $attributes['scope'] = 'col';
        $output .= html_writer::tag('th', get_string('options', 'tool_messenger'), $attributes);
        $output .= html_writer::end_tag('tr');
        $output .= html_writer::end_tag('thead');

        return $output;
    }

    /**
     * Prints course categories and assigned moodle users.
     * @return string
     */
    private function table_body() {
        $mform = $this->_form;
        $records = $this->getrecords();

        $mform->addElement('html', '<tbody>');
        $roles = $this->get_reverse_roles();
        foreach ($records as $record) {
            $mform->addElement('html', '<tr>');
            $mform->addElement('html', '<td class="cell c1"><div>' .
                $record->get('id') .
                '</div></td>');
            $mform->addElement('html', '<td class="cell c1"><div>' .
                date('d.m.Y H:i', $record->get("timecreated")) .
                '</div></td>');
            $mform->addElement('html', '<td class="cell c2"><div>' .
                '<button class="optionbutton btn btn-primary showmessagebutton" messageid="' . $record->get("id").
                '">Show message </button>' .
                '</div></td>');
            // @codingStandardsIgnoreStart phpcs:disable
            $to = implode(", ", array_map(function ($item) use ($roles) {
                if ($roles[$item])
                    return $roles[$item];
                return 'deleted role';
                }, // Phpcs wants this to be one ident level up.
                explode(",", $record->get('roleids'))));
            // @codingStandardsIgnoreEnd phpcs:enable
            $mform->addElement('html', '<td class="cell c3"><div class="tablewrap">' .
                 $to .
                '</div></td>');
            if ($record->get("finished")) {
                $status = $record->get('aborted') == 1 ? 'aborted' : 'finished';
                $statusstring = get_string($status, 'tool_messenger');
            } else {
                $statusstring = $record->get('senttonum') . " / " . $record->get("totalnumofusers");
            }
            $mform->addElement('html', '<td class="cell c4"><div>' .
                $statusstring .
                '</div></td>');
            $mform->addElement('html', '<td class="cell c5"><div>' .
                $record->get("priority") .
                '</div></td>');

            $mform->addElement('html', '<td class="cell c6">'.
                '<input type="submit" class = "optionbutton btn btn-primary" name="followup" id="followup_'
                . $record->get('id') . '"
                value="' . get_string('followup', 'tool_messenger') . '">'
            );
            if (!$record->get('finished')) {
                $mform->addElement('html',
                    '<input type="submit" class = "optionbutton btn btn-primary delbutton" name="abort" id="abort_'
                    . $record->get('id') . '"
                value="' . get_string('abort', 'tool_messenger') . '">'
                );
            }
            $mform->addElement('html', '</tr>');
        }
        $mform->addElement('html', '</tbody>');
        $mform->addElement('html', '</table>');
    }

    /**
     * Returns all messagejobs.
     * @return array
     */
    private function getrecords() {
        $records = \tool_messenger\message_persistent::get_records();
        return $records;
    }

    /**
     * Validates the user ids.
     *
     * @param array $data
     * @param array $files
     * @return array
     */
    public function validation($data, $files) {
        $errors = parent::validation($data, $files);
        return $errors;
    }
}