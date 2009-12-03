<?php
/**
 * Allow users to tag a page
 *
 * @author Adrian Lang <lang@cosmocode.de>
 */

if(!defined('DOKU_INC')) die();
if(!defined('DOKU_PLUGIN')) define('DOKU_PLUGIN',DOKU_INC.'lib/plugins/');
require_once DOKU_PLUGIN.'action.php';

require_once DOKU_PLUGIN . 'activecosmo/actions/action.php';
require_once DOKU_PLUGIN . 'activecosmo/ac.php';
require_once DOKU_PLUGIN . 'activecosmo/ajax_loader.php';

function syntax_plugin_activecosmo_autoload($name) {
    if (strpos($name, 'syntax_plugin_activecosmo_action_') !== 0) {
        return false;
    }
    $subclass = substr($name, 33);
    if (!@file_exists(DOKU_PLUGIN . 'activecosmo/actions/' . $subclass . '.php')) {
        eval("class syntax_plugin_activecosmo_action_$subclass extends " .
             'syntax_plugin_activecosmo_action { };');
        return true;
    }
    require_once DOKU_PLUGIN . 'activecosmo/actions/' . $subclass . '.php';
    return true;
}

spl_autoload_register('syntax_plugin_activecosmo_autoload');

