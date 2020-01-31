<?php

class InputValidator {

    private $data; //Data submitted with POST
    private $errors = []; //Stores errors
    private static $fields = ['sku', 'name', 'price', 'type', 'special_attribute', 'special_attribute_value']; //Required fields (InputValidator::$fields)

    public function __construct($post_data) {
        $this->data = $post_data;
    }

    public function validateForm() {
        foreach(self::$fields as $field) { //Cycle through array and refer to each element as $field
            if(!array_key_exists($field, $this->data)){
                trigger_error("$field is not present in data");
                return;
            }
        }
        var_dump($this->data);
        $this->validateName();
        $this->validatePrice();
        $this->validateSku();
        $this->validateAttrbType();
        $this->validateAttrbValue();
        $this->validateType();
        return $this->errors;
    }

    private function validateName() {
        $val = trim($this->data['name']); //Trim whitespace

        if(empty($val)){ //Condition - if input is empty after trimming whitespace
             $this->addError('name', 'Name cannot be empty');
        }

    }

    private function validateSKU() {
        $val = trim($this->data['sku']); //Trim whitespace

        if(empty($val)){ //Condition - if input is empty after trimming whitespace
             $this->addError('sku', 'SKU cannot be empty');
        } else {
            if(!ctype_alnum($val)){
                $this->addError('sku', 'SKU must be alphanumeric');
            }
        }

    }

    private function validatePrice() { //Private = can be called from inside this class
        $val = trim($this->data['price']); //Trim whitespace

        if(empty($val)){ //Condition - if input is empty after trimming whitespace
             $this->addError('price', 'Price cannot be empty');
        } else {
            if(!filter_var($val, FILTER_VALIDATE_FLOAT)){
                $this->addError('price', 'Price must be a valid number');
            }
        }

    }

    private function validateType() {
        $val = trim($this->data['type']); //Trim whitespace

        if(empty($val)){ //Condition - if input is empty after trimming whitespace
             $this->addError('type', 'Type cannot be empty');
        }
    }

    private function validateAttrbType() {
        $val = trim($this->data['special_attribute']); //Trim whitespace

        if(empty($val)){ //Condition - if input is empty after trimming whitespace
             $this->addError('special_attribute', 'Special attribute cannot be empty');
        }

    }

    private function checkEmptyInput($key, $value) {
        if (empty($value)) {
            $this->addError($key, 'Value cannot be empty');
        } 
    }

    private function checkFloat($key, $value) {
        if(!filter_var($value, FILTER_VALIDATE_FLOAT)){
            $this->addError($key, 'Value must be a valid number');
        }
    }

    private function validateAttrbValue() {

        if (is_array($this->data['special_attribute_value'])) {

            foreach($this->data['special_attribute_value'] as $key => $value) {
                $value = trim($value);
                self::checkEmptyInput($key, $value);
                self::checkFloat($key, $value);
            }

/*             $height = trim($this->data['special_attribute_value']['height']);
            $width = trim($this->data['special_attribute_value']['width']);
            $length = trim($this->data['special_attribute_value']['length']);

            self::checkEmptyInput('special_attribute_value', $height);
            self::checkEmptyInput('special_attribute_value', $width);
            self::checkEmptyInput('special_attribute_value', $length);

            self::checkFloat('special_attribute_value', $height);
            self::checkFloat('special_attribute_value', $width);
            self::checkFloat('special_attribute_value', $length); */
            
/*             if (empty($height)) {
                $this->addError('special_attribute_value', 'Height cannot be empty');
            }
            if (empty($width)) {
                $this->addError('special_attribute_value', 'Width cannot be empty');
            }
            if (empty($length)) {
                $this->addError('special_attribute_value', 'Length cannot be empty'); 
            }*/
/*             if(!filter_var($height, FILTER_VALIDATE_FLOAT)){
                $this->addError('price', 'height must be a valid number');
            }
            if(!filter_var($width, FILTER_VALIDATE_FLOAT)){
                $this->addError('price', 'width must be a valid number');
            }
            if(!filter_var($length, FILTER_VALIDATE_FLOAT)){
                $this->addError('price', 'length must be a valid number');
            } */

        } else{

        $val = trim($this->data['special_attribute_value']); //Trim whitespace

        if(empty($val)){ //Condition - if input is empty after trimming whitespace
             $this->addError('special_attribute_value', 'Special attribute value cannot be empty');
        }
    }
    }
    
    //Adds existing errors to error array $errors
    private function addError($key, $val) {     
            $this->errors[$key] = $val;
    }
}

