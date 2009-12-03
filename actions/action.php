<?php
abstract class syntax_plugin_activecosmo_action {
    protected $ac = null;

    public function __construct($ac, $data) {
        $this->ac = $ac;
    }

    abstract public function render();
}
