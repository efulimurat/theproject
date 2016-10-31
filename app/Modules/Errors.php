<?php

namespace App\Modules;

class Errors extends Base {

    private $errorCode, $errorDetails;

    public function __construct() {
        parent::__construct();
    }
    /**
     * Set Errors
     * 
     * @param string $errorCode Call method about error type
     * @param string $errorDetails Created Error Details Data Array
     * @return void
     */
    public function setError($errorCode = null, $errorDetails = array()) {
        self::$errorOccured = true;
        $this->errorDetails = $errorDetails;
        if (!is_null($errorCode)) {
            $methodName = "error" . $errorCode;
            if (method_exists($this, $methodName)) {
                return $this->$methodName();
            } else {
                return $this->defaultErrors();
            }
        } else {
            return $this->defaultErrors();
        }
    }
    /**
     * Set Error By Status
     * @param integer $status Status Code
     * @param string $errorDetails Created Error Details Data Array
     * @return void
     */
    public function setErrorByStatus($status = 400, $errorDetails = array()) {
        $statusFunc = $this->getStatusMethod($status); 
        return $this->setError($statusFunc, $errorDetails);
    }
    
   /**
    * Common Error Function to prepare error details data for some errors
    * 
    * @return void
    */
    private function errorApiReason() {
        $view = 400;
        $viewData = [
            "title" => "400 Error Occured",
            "msg" => "An error occured while getting data from requested API and returned a message:",
            "reason" => $this->errorDetails
        ];
        $viewData = json_encode($viewData);
        return $this->prepareErrorPage($view, $viewData);
    }

    /**
     * 401 Error Function to prepare error details data for Authorization errors
     * 
     * @return void
     */
    private function errorApi401() {
        $view = 401;
        $viewData = [
            "title" => "401 Error Occured",
            "msg" => "While sending API Request, an error occured.It's probably about API Token Key. Please contact technical staff for problem. The Response Message is:",
            "reason" => $this->errorDetails
        ];
        $viewData = json_encode($viewData);
        return $this->prepareErrorPage($view, $viewData);
    }
    
    /**
     * Method of Status Code
     * 
     * @param type $status Statuc Code
     * @return string
     */
    private function getStatusMethod($status) {
        $methodSet = [
            401 => "Api401"
        ];
        return $methodSet[$status];
    }
    /**
    * Common Error Function to prepare error details data for some errors
    * 
    * @return void
    */
    private function errorApp400() {
        $view = 400;
        $viewData = [
            "title" => "400 Error Occured",
            "msg" => "An error occured while getting data and returned a message:",
            "reason" => $this->errorDetails
        ];
        $viewData = json_encode($viewData);
        return $this->prepareErrorPage($view, $viewData);
    }
    /**
     * Abort on Errors
     * 
     * @param type $view Error Page View
     * @param type $viewData ViewData
     */
    private function prepareErrorPage($view, $viewData) {
        abort($view, $viewData);
    }

}