<?php

require_once DOKU_INC . 'inc/form.php';

class ajax_loader {
    public static function getLoader($plugin, $obj) {
        if(!isset($_SESSION[DOKU_COOKIE]['ajax_loader'])) {
            $_SESSION[DOKU_COOKIE]['ajax_loader'] = array();
        }
        $_SESSION[DOKU_COOKIE]['ajax_loader'][] = $obj;
        end($_SESSION[DOKU_COOKIE]['ajax_loader']);
        $form = new Doku_Form(array('class' => 'ajax_loader'));
        $form->addHidden('ajax_loader_data', key($_SESSION[DOKU_COOKIE]['ajax_loader']));
        $form->addHidden('ajax_loader_sid', session_id());
        $form->addHidden('call', 'ajax_loader_' . $plugin);
        return '<div>' . $form->getForm() . '</div>';
    }

    public static function isLoader($plugin, $call) {
        return $call === "ajax_loader_$plugin";
    }

    public static function handleLoad() {
        session_id($_REQUEST['ajax_loader_sid']);
        session_start();
        $data = $_SESSION[DOKU_COOKIE]['ajax_loader'][$_REQUEST['ajax_loader_data']]->exec();
        unset($_SESSION[DOKU_COOKIE]['ajax_loader'][$_REQUEST['ajax_loader_data']]);
        return $data;
    }
}
