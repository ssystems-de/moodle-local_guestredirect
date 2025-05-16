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
 * Local plugin 'Guest redirect' - Settings.
 *
 * @package    local_guestredirect
 * @copyright  2025 Mahmoud Chehada, ssystems GmbH <mchehada@ssystems.de>
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

defined('MOODLE_INTERNAL') || die();

if ($hassiteconfig) {
    // Create new settings page.
    $settings = new admin_settingpage('local_guestredirect', get_string('pluginname', 'local_guestredirect', null, true));

    if ($ADMIN->fulltree) {

        $name = 'local_guestredirect/enable';
        $title = get_string('setting_enable', 'local_guestredirect', null, true);
        $description = get_string('setting_enable_desc', 'local_guestredirect', null, true);
        $yesnooption = [1 => get_string('yes'),
                0 => get_string('no'), ];
        $setting = new admin_setting_configselect($name, $title, $description, 0, $yesnooption);
        $settings->add($setting);
    }

    $ADMIN->add('authsettings', $settings);
}
