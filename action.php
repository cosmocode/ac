<?php
/**
 * Allow users to tag a page
 *
 * @author Adrian Lang <lang@cosmocode.de>
 */

if(!defined('DOKU_INC')) die();
if(!defined('DOKU_PLUGIN')) define('DOKU_PLUGIN',DOKU_INC.'lib/plugins/');
require_once DOKU_PLUGIN.'action.php';

require_once DOKU_PLUGIN . 'activecosmo/common.php';

class action_plugin_activecosmo extends DokuWiki_Action_Plugin {

    function getInfo() {
        return confToHash(dirname(__FILE__).'/plugin.info.txt');
    }

    /**
     * Register handlers
     */
    function register(&$controller) {
        $controller->register_hook('AJAX_CALL_UNKNOWN', 'BEFORE', $this,
                                   'handle_ajax');
    }

    /**
     * Handle AJAX request
     */
    function handle_ajax($event) {
        if (!ajax_loader::isLoader('activecosmo', $event->data)) {
            return;
        }
        echo ajax_loader::handleLoad();
        $event->stopPropagation();
        $event->preventDefault();
    }

}
