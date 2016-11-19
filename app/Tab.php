<?php


namespace App;


class Tab {

    public $name;

    public $view;

    public $icon;

    public $display;

    /**
     * Tab constructor.
     * @param $name
     * @param $display
     * @param $view
     * @param $icon
     */
    public function __construct($name, $display, $view, $icon = null) {
        $this->name = $name;
        $this->view = $view;
        $this->icon = $icon;
        $this->display = $display;
    }


}