<?php

namespace App\Library\ReportAPI\Models;

class BaseModel {

    function __construct() {
        $model = get_class($this);
    }

    protected function validate() {
        $validObject = true;
        if (isset($this->validations)) {
            $validationRules = $this->validations;
            foreach ($validationRules as $objName => $validationFunc) {
                $val = $this->$objName;
                if (!empty($val)) {
                    if (method_exists($this, $validationFunc)) {
                        $validationCheck = call_user_func_array(array($this, $validationFunc), array($val));
                    } else {
                        $validationCheck = call_user_func_array($validationFunc, array($val));
                    }
                    if (!$validationCheck) {
                        $validObject = false;
                    }
                }
            }
            return $validObject;
        }
    }
    
}
