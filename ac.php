<?php
/**
 * DokuWiki Plugin activecosmo (activecollab Component)
 *
 * @license GPL 2 http://www.gnu.org/licenses/gpl-2.0.html
 * @author  Adrian Lang <lang@cosmocode.de>
 */

require_once DOKU_INC . 'inc/HTTPClient.php';
require_once DOKU_INC . 'inc/JSON.php';

class syntax_plugin_activecosmo_ac {

    public function __construct($url, $token) {
        $this->base_url = "{$url}?token={$token}&format=json";
    }

    public function get($path, $data = array()) {
        $client = new DokuHTTPClient();
        $json = new JSON();
        return $json->decode($client->get($this->base_url . '&path_info=' .
                                          $path . buildURLparams($data, '&')));
    }

    public function objToString($obj) {
        return "<a href='$obj->permalink'>$obj->name</a>";
    }
}

// vim:ts=4:sw=4:et:enc=utf-8:
