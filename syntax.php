<?php
/**
 * DokuWiki Plugin ac (Syntax Component)
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
require_once DOKU_PLUGIN . 'ac/common.php';

class syntax_plugin_ac extends DokuWiki_Syntax_Plugin {
    function getInfo() {
        return confToHash(dirname(__FILE__).'/plugin.info.txt');
    }

    function getType() { return 'substition'; }
    function getSort() { return 32; }
    function getPType(){ return 'block'; }

    function connectTo($mode) {
        $this->Lexer->addSpecialPattern('{{AC::\w+(?:>[^}]+)?}}', $mode,
                                        'plugin_ac');
    }

    function handle($match, $state, $pos, &$handler) {
        preg_match('/{{AC::(\w+)(?:>([^}]+))?}}/', $match, $command);
        return array_slice($command, 1);
    }

    function render($mode, &$renderer, $data) {
        if($mode == 'xhtml') {
            $renderer->doc .= ajax_loader::getLoader('ac', $data);
        }
    }
}

// vim:ts=4:sw=4:et:enc=utf-8:
