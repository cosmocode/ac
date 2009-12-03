<?php
/**
 * DokuWiki Plugin activecosmo (Syntax Component)
 *
 * @license GPL 2 http://www.gnu.org/licenses/gpl-2.0.html
 * @author  Adrian Lang <lang@cosmocode.de>
 */

// must be run within Dokuwiki
if (!defined('DOKU_INC')) die();

if (!defined('DOKU_LF')) define('DOKU_LF', "\n");
if (!defined('DOKU_TAB')) define('DOKU_TAB', "\t");
if (!defined('DOKU_PLUGIN')) define('DOKU_PLUGIN',DOKU_INC.'lib/plugins/');

require_once DOKU_PLUGIN.'syntax.php';

require_once DOKU_PLUGIN . 'activecosmo/actions/action.php';
require_once DOKU_PLUGIN . 'activecosmo/ac.php';

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

class syntax_plugin_activecosmo extends DokuWiki_Syntax_Plugin {
    private $ac = null;

    function __construct() {
        $this->ac = new syntax_plugin_activecosmo_ac(
                                 'http://ac.cosmocode.de/public/api.php',
                                 '30-UECdCk98X8vFLLWnCm3nXdnFUXOMjcvOEzfPxcBt');
    }

    function getInfo() {
        return confToHash(dirname(__FILE__).'/plugin.info.txt');
    }

    function getType() { return 'substition'; }
    function getSort() { return 32; }
    function getPType(){ return 'block'; }

    function connectTo($mode) {
        $this->Lexer->addSpecialPattern('{{AC::\w+(?:>[^}]+)?}}', $mode, 'plugin_activecosmo');
    }

    function handle($match, $state, $pos, &$handler) {
        preg_match('/{{AC::(\w+)(?:>([^}]+))?}}/', $match, $command);
        $action_classname = 'syntax_plugin_activecosmo_action_' . $command[1];
        return new $action_classname($this->ac, $command[2]);
    }

    function render($mode, &$renderer, $data) {
        if($mode == 'xhtml') {
            $renderer->doc .= $data->render();
        }
    }
}

// vim:ts=4:sw=4:et:enc=utf-8:
