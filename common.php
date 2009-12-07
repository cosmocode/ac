<?php
/**
 * DokuWiki Plugin ac (common stuff)
 *
 * @license GPL 2 http://www.gnu.org/licenses/gpl-2.0.html
 * @author  Adrian Lang <lang@cosmocode.de>
 */

if(!defined('DOKU_INC')) die();
if(!defined('DOKU_PLUGIN')) define('DOKU_PLUGIN',DOKU_INC.'lib/plugins/');
require_once DOKU_PLUGIN.'action.php';

require_once DOKU_PLUGIN . 'ac/actions/action.php';
require_once DOKU_PLUGIN . 'ac/ac.php';
require_once DOKU_PLUGIN . 'ac/ajax_loader.php';

function syntax_plugin_ac_autoload($name) {
    if (strpos($name, 'syntax_plugin_ac_action_') !== 0) {
        return false;
    }
    $subclass = substr($name, 24);
    if (!@file_exists(DOKU_PLUGIN . 'ac/actions/' . $subclass . '.php')) {
        eval("class syntax_plugin_ac_action_$subclass extends " .
             'syntax_plugin_ac_action { };');
        return true;
    }
    require_once DOKU_PLUGIN . 'ac/actions/' . $subclass . '.php';
    return true;
}

spl_autoload_register('syntax_plugin_ac_autoload');

