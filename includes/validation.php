<?php

class InputValidator
{

    private $data; //Data submitted with POST
    private $validationErrors = []; //Stores errors
    private static $fields = ['sku', 'name', 'price', 'type', 'special_attribute', 'special_attribute_value']; //Required fields (InputValidator::$fields)

    public function __construct($post_data)
    {
        $this->data = $post_data;
    }

    public function validateForm()
    {
        foreach (self::$fields as $field) { //Cycle through array and refer to each element as $field
            if (!array_key_exists($field, $this->data)) {
                throw new Exception("$field is not present in form data");
                return;
            }
        }

        $this->validateName();
        $this->validatePrice();
        $this->validateSku();
        $this->validateAttrbType();
        $this->validateAttrbValue();
        $this->validateType();
        
        if (!empty($this->validationErrors)) {
            $this->validationErrors['errType'] = 'validationErr';
        }
        return $this->validationErrors;
    }

    private function validateName()
    {
        $val = trim($this->data['name']); //Trim whitespace

        if (empty($val)) { //Condition - if input is empty after trimming whitespace
            $this->addError('name', 'Name cannot be empty');
        }
    }

    private function validateSKU()
    {
        $val = trim($this->data['sku']); //Trim whitespace

        if (empty($val)) { //Condition - if input is empty after trimming whitespace
            $this->addError('sku', 'SKU cannot be empty');
        } else {
            if (!ctype_alnum($val)) {
                $this->addError('sku', 'SKU must be alphanumeric');
            }
        }
    }

    private function validatePrice()
    { //Private = can be called from inside this class
        $val = trim($this->data['price']); //Trim whitespace

        if (empty($val)) { //Condition - if input is empty after trimming whitespace
            $this->addError('price', 'Price cannot be empty');
        } else {
            if (!filter_var($val, FILTER_VALIDATE_FLOAT)) {
                $this->addError('price', 'Price must be a valid number');
            }
        }
    }

    private function validateType()
    {
        $val = trim($this->data['type']); //Trim whitespace

        if (empty($val)) { //Condition - if input is empty after trimming whitespace
            $this->addError('type', 'Type cannot be empty');
        }
    }

    private function validateAttrbType()
    {
        $val = trim($this->data['special_attribute']); //Trim whitespace

        if (empty($val)) { //Condition - if input is empty after trimming whitespace
            $this->addError('special_attribute', 'Special attribute cannot be empty');
        }
    }

    private function checkEmptyInput($key, $value)
    {
        if (empty($value)) {
            $this->addError($key, 'Value cannot be empty');
            return false;
        }
        return true;
    }

    private function checkFloat($key, $value)
    {
        if (!filter_var($value, FILTER_VALIDATE_FLOAT)) {
            $this->addError($key, 'Value must be a valid number');
            return false;
        } else {
            return true;
        }
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

            $val = trim($this->data['special_attribute_value']); //Trim whitespace

            if (empty($val)) { //Condition - if input is empty after trimming whitespace
                $this->addError('special_attribute_value', 'Value cannot be empty');
            } else {
                if (!filter_var($val, FILTER_VALIDATE_FLOAT)) {
                    $this->addError('special_attribute_value', 'Value must be a valid number');
                }
            }
        }
    }

    //Adds existing errors to error array $validationErrors
    private function addError($key, $val)
    {
        $this->validationErrors[$key] = $val;
    }
}
