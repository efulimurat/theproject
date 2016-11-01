<?php

namespace App\Library\ReportAPI\Models;

use App\Modules\Errors;

class BaseModel {

    function __construct() {
        $model = get_class($this);
    }

    protected function validate() {
        $validObject = true;

        /** Check Object is defined */
        $className = get_class($this);
        $modelObj = new $className;
        foreach ($this as $obj => $val) {
            if (!property_exists($modelObj, $obj)) {
                $validObject = false;
            }
        }

        /** Set Object Check Error */
        if (!$validObject) {
            $Error = new Errors;
            $Error->setError("App400", "Unknown Property");
        }

        /**  Check Validation Rules if defined */
        if (!empty($this->validations())) {
            $validationRules = $this->validations();
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

            /** Set Validation Error */
            if (!$validObject) {
                $Error = new Errors;
                $Error->setError("App400", "Validation Errors");
            }
        }

        return $validObject;
    }

}
