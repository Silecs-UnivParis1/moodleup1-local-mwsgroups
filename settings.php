<?php
/**
 * @package    local
 * @subpackage mwsgroups
 * @copyright  2012-2014 Silecs {@link http://www.silecs.info/societe}
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

defined('MOODLE_INTERNAL') || die();

if (has_capability('moodle/site:config', context_system::instance())) {
    $settings = new admin_settingpage('local_mwsgroups', get_string('pluginname', 'local_mwsgroups'));
    $ADMIN->add('localplugins', $settings);
    $setting = new admin_setting_configtext(
        'local_mwsgroups/cohorts_cap',
        'Cohortes autorisées en recherche',
        "Liste des cohortes autorisées à faire une recherche enseignant/groupe : identifiants séparés par des virgules.",
        'affiliation-teacher,affiliation-staff,affiliation-researcher,groups-applications.moodle.Mcours-managers'
    );
    $settings->add($setting);
}
