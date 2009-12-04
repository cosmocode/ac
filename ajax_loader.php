<?php

require_once DOKU_INC . 'inc/form.php';

class ajax_loader {
    public static function getLoader($plugin, $data) {
        $form = new Doku_Form(array('class' => 'ajax_loader'));
        $form->addHidden('call', "ajax_loader_$plugin");
        foreach($data as $k => $v) {
            $form->addHidden("ajax_loader_data[$k]", $v);
        }
        return '<div>' . $form->getForm() . '</div>';
    }

    public static function isLoader($plugin, $call) {
        return $call === "ajax_loader_$plugin";
    }

    public static function handleLoad() {
        @session_start();
        return $_REQUEST['ajax_loader_data'];
    }
}
