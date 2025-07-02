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

$string['pluginname'] = 'Gast-Weiterleitung';
$string['privacy:metadata'] = 'Das Plugin Gast-Weiterleitung speichert keine personenbezogenen Daten.';
$string['setting_enable'] = 'Gast-Weiterleitung aktivieren';
$string['setting_enable_desc'] = 'Das Plugin Gast-Weiterleitung bietet einen speziellen Weiterleitungsmechanismus, der es Benutzern ermöglicht, über eine spezielle URL als Gast auf Kurse zuzugreifen, ohne von der globalen Einstellung autologinguests abhängig zu sein und ohne dass sie auf der Loginseite den Knopf "Anmelden als Gast" klicken müssen. Sobald diese Einstellung aktiviert ist, werden Benutzer, die die URL /local/guestredirect/index.php?id=&lt;courseid&gt; aufrufen (wobei &lt;courseid&gt; mit der jeweiligen Kurs-ID eines Kurses, welcher sichtbar ist und in dem der Gastzugriff natürlich aktiviert wurde, ersetzt wird), zur Kursseite weitergeleitet und bei Bedarf als Gast angemeldet.';
$string['setting_enable_note'] = 'Bitte beachten Sie, dass dieser Weiterleitungsmechanismus auch funktioniert, wenn der Gast-Login-Knopf auf der Login-Seite nicht aktiviert ist. Dies ist nützlich für Fälle, in denen Sie den Gastzugriff auf bestimmte Kurse erlauben möchten, ohne den Gast-Login-Knopf global verfügbar zu machen.';
