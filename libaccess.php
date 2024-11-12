<?php
/**
 * @package    local
 * @subpackage mwsgroups
 * @copyright  2012-2014 Silecs {@link http://www.silecs.info/societe}
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

defined('MOODLE_INTERNAL') || die();

function mwsgroups_require_permission($userid) {
    global $DB;
    
    $systemcontext = context_system::instance();
    if (has_capability('local/mwsgroups:search', $systemcontext, $userid)) {
        return true;
    }
    $permit_cohorts = get_config('local_mwsgroups', 'cohorts_cap');
    if ($permit_cohorts != '') {
        $permit_cohorts = preg_replace('/\s+,\s+/', ',', $permit_cohorts);
        $permitted_cohorts = explode(',', $permit_cohorts);
        $sql = "SELECT c.idnumber FROM {cohort} c JOIN {cohort_members} cm ON (cm.cohortid = c.id) "
             . "WHERE cm.userid = ?";
        $member_of = $DB->get_fieldset_sql($sql, array($userid));
        if ( count(array_intersect($permitted_cohorts, $member_of)) > 0 ) {
            return true;
        }
    }
    return false;
}
