<?php
/**
 * DokuWiki Plugin ac (Syntax Component)
 *
 * @license GPL 2 http://www.gnu.org/licenses/gpl-2.0.html
 * @author  Adrian Lang <lang@cosmocode.de>
 */

if(!defined('DOKU_INC')) die();
if(!defined('DOKU_PLUGIN')) define('DOKU_PLUGIN',DOKU_INC.'lib/plugins/');
require_once DOKU_PLUGIN.'action.php';

require_once DOKU_PLUGIN . 'ac/common.php';

class action_plugin_ac extends DokuWiki_Action_Plugin {
    private $ac = null;

    function __construct() {
        $this->ac = new syntax_plugin_ac_ac($this->getConf('url'),
                                            $this->getConf('token'));
    }

    function getInfo() {
        return confToHash(dirname(__FILE__).'/plugin.info.txt');
    }

    /**
     * Register handlers
     */
    function register( Doku_Event_Handler $controller) {
        $controller->register_hook('AJAX_CALL_UNKNOWN', 'BEFORE', $this,
                                   'handle_ajax');
    }

    /**
     * Handle AJAX request
     */
    function handle_ajax($event) {
        if (!ajax_loader::isLoader('ac', $event->data)) {
            return;
        }

        $command = ajax_loader::handleLoad();
        $action_classname = 'syntax_plugin_ac_action_' . $command[0];
        $action = new $action_classname($this->ac, array_slice($command, 1));
        echo $action->exec();

        $event->stopPropagation();
        $event->preventDefault();
    }

}
