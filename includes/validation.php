<?php

class InputValidator
{

    private $data;
    private $validationErrors = [];
    private static $fields = ['sku', 'name', 'price', 'type', 'special_attribute', 'special_attribute_value'];

    public function __construct($post_data)
    {
        $this->data = $post_data;
    }

    public function validateForm()
    {
        //Check if all form fields are set 
        foreach (self::$fields as $field) {
            if (!array_key_exists($field, $this->data)) {
                throw new Exception("$field is not present in form data");
                //return;
            }
        }
        //Run validator methods
        $this->validateName();
        $this->validatePrice();
        $this->validateSku();
        $this->validateAttrbType();
        $this->validateAttrbValue();
        $this->validateType();

        //Add error type to error array
        if (!empty($this->validationErrors)) {
            $this->validationErrors['errType'] = 'validationError';
        }
        return $this->validationErrors;
    }
    //Validator methods
    private function validateName()
    {
        $val = trim($this->data['name']);
        $val = stripslashes($val);
        self::checkEmptyInput('name', $val, 'Name');
    }

    private function validateSKU()
    {
        $val = trim($this->data['sku']);
        if (self::checkEmptyInput('sku', $val, 'SKU')) {
            self::checkAlphanum('sku', $val, 'SKU');
        }
    }

    private function validatePrice()
    {
        $val = trim($this->data['price']);
        if (self::checkEmptyInput('price', $val, 'Price')) {
            self::checkFloat('price', $val, 'Price');
        }
    }

    private function validateType()
    {
        $val = trim($this->data['type']);
        self::checkEmptyInput('type', $val, 'Type');
    }

    private function validateAttrbType()
    {
        $val = trim($this->data['special_attribute']);
        self::checkEmptyInput('special_attribute', $val, 'Attribute type');
    }

    private function validateAttrbValue()
    {

        if (is_array($this->data['special_attribute_value'])) {

            foreach ($this->data['special_attribute_value'] as $key => $value) {
                $value = trim($value);
                if (!self::checkEmptyInput($key, $value)) {
                    continue;
                };
                self::checkFloat($key, $value);
            }
        } else {

            $val = trim($this->data['special_attribute_value']);
            if (self::checkEmptyInput('special_attribute_value', $val, 'Value')) {
                self::checkFloat('special_attribute_value', $val, 'Value');
            }
        }
    }

    //Error array population method
    private function addError($key, $val)
    {
        $this->validationErrors[$key] = $val;
    }

    //Input checker functions
    private function checkEmptyInput($key, $value, $fieldName = 'Value')
    {
        if (empty($value)) {
            $this->addError($key, $fieldName . ' cannot be empty');
            return false;
        }
        return true;
    }

    private function checkFloat($key, $value, $fieldName = 'Value')
    {
        if (!filter_var($value, FILTER_VALIDATE_FLOAT)) {
            $this->addError($key, $fieldName . ' must be a valid number');
            return false;
        } else {
            return true;
        }
    }
    private function checkAlphanum($key, $value, $fieldName = 'Value')
    {
        if (!ctype_alnum($value)) {
            $this->addError($key, $fieldName . ' must be alphanumeric');
        }
    }
}
