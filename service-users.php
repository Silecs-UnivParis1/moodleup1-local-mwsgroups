<?php

define('NO_OUTPUT_BUFFERING', true);
require('../../config.php');
require_once(__DIR__ . '/lib.php');

global $USER;

if (isloggedin() && !isguestuser() && (user_has_role_assignment($USER->id,3) || user_has_role_assignment($USER->id,4) || is_siteadmin())) {
    $token = required_param('token', PARAM_RAW);
    $exclude = optional_param('exclude', '', PARAM_TAGLIST); // usernames to exclude, separated by ","
    $cohorts = optional_param('cohorts', '', PARAM_TAGLIST); // cohorts to restrict to, separated by ","
    $callback = optional_param('callback', '', PARAM_ALPHANUMEXT); // if set, use jsonp instead of json

    $search_u = new mws_search_users();
    $search_u->maxrows = optional_param('maxRows', 10, PARAM_INT);
    $search_u->filterstudent = optional_param('filter_student', 'both', PARAM_ALPHA);
    $search_u->exclude = explode(',', $exclude);
    $search_u->affiliation = optional_param('affiliation', false, PARAM_BOOL); // ask for an "affiliation" field on each user
    $search_u->affectation = optional_param('affectation', true, PARAM_BOOL);
    $search_u->cohorts = explode(',', $cohorts);
    $res  = $search_u->search($token);

    if (empty($callback)) {
        header('Content-Type: application/json; charset="UTF-8"');
        echo json_encode($res);
    } else {
        header('Content-Type: application/javascript; charset="UTF-8"');
        echo $callback . '(' . json_encode($res) . ');';
    }
}
