<?php

namespace App\Modules;

use Illuminate\Contracts\View\Factory as ViewFactory;

class Base {

    public static $errorOccured = false;

    public function __construct() {
        
    }

    /**
     * View
     * @param type $view
     * @param type $data
     * @param type $mergeData
     * @return type
     */
    public function viewContent($view = null, $data = [], $mergeData = []) {

        $factory = app(ViewFactory::class);
        if (func_num_args() === 0) {
            return $factory;
        }
        return $factory->make($view, $data, $mergeData);
    }
    /**
     * Returns JSON data as array
     * @param string JSON $_data
     * @return array
     */
    protected function fetchJsonDataAsArray($_data) {
        if (!empty($_data)) {
            $_data = json_decode($_data, true);
        } else {
            $_data = [];
        }
        return $_data;
    }
    /**
     * Returns JSON data as object
     * @param string JSON $_data
     * @return \stdClass
     */
    protected function fetchJsonDataAsObject($_data) {
        if (!empty($_data)) {
            $_data = json_decode($_data);
        } else {
            $_data = new \stdClass;
        }
        return $_data;
    }

}
