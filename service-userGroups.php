<?php
// test ex. http://localhost/moodle-paris1/local/mwsgroups/service-userGroups.php?uid=
define('NO_OUTPUT_BUFFERING', true);
require('../../config.php');
require_once('./lib.php');
require_once('./libaccess.php');

global $USER;

if (mwsgroups_require_permission($USER->id)) {
    $uid = required_param('uid', PARAM_RAW);
    $callback = optional_param('callback', '', PARAM_ALPHANUMEXT); // if set, use jsonp instead of json

    $PAGE->set_context(context_system::instance());

    $res = mws_userGroupsId($uid);

    if (empty($callback)) {
        header('Content-Type: application/json; charset="UTF-8"');
        echo json_encode($res);
    } else {
        header('Content-Type: application/javascript; charset="UTF-8"');
        echo $callback . '(' . json_encode($res) . ');';
    }
}
