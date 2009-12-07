<?php
/**
 * DokuWiki Plugin ac (activecollab Component)
 *
 * @license GPL 2 http://www.gnu.org/licenses/gpl-2.0.html
 * @author  Adrian Lang <lang@cosmocode.de>
 */

require_once DOKU_INC . 'inc/HTTPClient.php';
require_once DOKU_INC . 'inc/JSON.php';

class syntax_plugin_ac_ac {

    public function __construct($url, $token) {
        $this->base_url = "{$url}?token={$token}&format=json";
    }

    public function get($path, $data = array()) {
        $client = new DokuHTTPClient();
        $json = new JSON();
        return $json->decode($client->get($this->base_url . '&' .
                                          "path_info=/{$path}&" .
                                          buildURLparams($data, '&')));
    }

    public function objToString($obj) {
        return "<a href='$obj->permalink'>$obj->name</a>";
    }

    public function fetch($type, $values) {
        $all = $this->get($type);
        $ret = array();
        foreach($all as $elem) {
            $match = true;
            foreach($values as $prop => $val) {
                if ($elem->$prop !== $val) {
                    $match = false;
                    break;
                }
            }
            if ($match) {
                $ret[] = $elem;
            }
        }
        return $ret;
    }

    public function fetchSingle($type, $values) {
        $ret = $this->fetch($type, $values);
        return (count($ret) === 0) ?  false : $ret[0];
    }
}

// vim:ts=4:sw=4:et:enc=utf-8:
