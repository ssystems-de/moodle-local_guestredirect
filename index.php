<?php
require_once(__DIR__ . '/../../config.php');

$courseid = required_param('id', PARAM_INT);
$course = get_course($courseid);

if (!isloggedin() || isguestuser()) {
    require_login($course, true);
} else {
    require_login($course);
}

$redirecturl = new moodle_url("/course/view.php", ['id' => $courseid]);
redirect($redirecturl);
