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
 * Local plugin 'Guest redirect' - Language pack.
 *
 * @package    local_guestredirect
 * @copyright  2025 Mahmoud Chehada, ssystems GmbH <mchehada@ssystems.de>
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

defined('MOODLE_INTERNAL') || die();

$string['pluginname'] = 'Guest Redirect';
$string['privacy:metadata'] = 'The Guest Redirect plugin does not store any personal data.';
$string['setting_enable'] = 'Enable guest redirect';
$string['setting_enable_desc'] = 'The guest redirect plugin provides a dedicated redirect mechanism that allows users to access courses as guests via a special URL, without relying on the global autologinguests setting and without urging the guest to click on the "Log in as guest" button on the login page. As soon as this setting is enabled, users who visit the /local/guestredirect/index.php?id=&lt;courseid&gt; URL (where &lt;courseid&gt; is replaced with the particular course ID) will be redirected to the course page and logged in as guest if necessary.';
$string['setting_enable_note'] = 'Please note that this redirect mechanism even works if the guest login button is not enabled on the login page. This is useful for cases where you want to allow guest access to specific courses without exposing the guest login button globally.';
