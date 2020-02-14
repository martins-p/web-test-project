<?php

class InputValidator
{
    private $data; //Variable for storing POST data
    private $validationErrors = [];
    private static $fields = ['sku', 'name', 'price', 'type', 'special_attribute', 'special_attribute_value'];

    public function __construct($postData)
    {
        $this->data = $postData;
    }

    public function validateForm()
    {
        //Check if all form fields are set 
        foreach (self::$fields as $field) {
            if (!array_key_exists($field, $this->data)) {
                throw new Exception("$field is not present in form data");
            }
        }

        //Run validator methods
        $this->data['name'] = $this->validateName($this->data['name']);
        $this->data['price'] = $this->validatePrice($this->data['price']);
        $this->data['sku'] = $this->validateSku($this->data['sku']);
        $this->data['type'] = $this->validateProductType($this->data['type']);
        $this->data['special_attribute'] = $this->validateAttrbType($this->data['special_attribute']);
        $this->data['special_attribute_value'] = $this->validateAttrbValue($this->data['special_attribute_value']);

        //Add error type to error array
        if (empty($this->validationErrors)) {
            return $this->data;
        } else {
            $this->validationErrors['errType'] = 'validationError';
            return $this->validationErrors;
        }
    }

    private function sanitizeString(string $input)
    {
        $output = trim($input);
        $output = stripslashes($output);
        $output = filter_var($output, FILTER_SANITIZE_STRING);
        return $output;
    }

    //Validator methods
    private function validateName($name)
    {
        $val = $this->sanitizeString($name);
        $this->checkEmptyInput('name', $val, 'Name');
        return $val;
    }

    public function validateSKU($sku)
    {
        $val = trim($sku);
        $this->checkEmptyInput('sku', $val, 'SKU');
        if (!array_key_exists('sku', $this->validationErrors)) {
            $this->checkAlphanum('sku', $val, 'SKU');
        }
        return $val;
    }

    private function validatePrice($price)
    {
        $val = trim($price);
        $this->checkEmptyInput('price', $val, 'Price');
        if (!array_key_exists('price', $this->validationErrors)) {
            $this->checkFloat('price', $val, 'Price');
        }
        return $val;
    }

    private function validateProductType($type)
    {
        $val = $this->sanitizeString($type);
        $this->checkEmptyInput('type', $val, 'Type');
        return $val;
    }

    private function validateAttrbType($attribute)
    {
        $val = $this->sanitizeString($attribute);
        $this->checkEmptyInput('special_attribute', $val, 'Attribute type');
        return $val;
    }

    private function validateAttrbValue($attributeValue)
    {

        if (is_array($attributeValue)) {

            foreach ($attributeValue as $key => $value) {
                $value = trim($value);
                if (!$this->checkEmptyInput($key, $value)) {
                    continue;
                };
                $this->checkFloat($key, $value);
            }
            if (!array_key_exists('height', $this->validationErrors) && !array_key_exists('width', $this->validationErrors) && !array_key_exists('length', $this->validationErrors)) {
                return $this->dimensionsToString($attributeValue);
            }
        } else {

            $val = trim($attributeValue);
            $this->checkEmptyInput('special_attribute_value', $val, 'Value');
            if (!array_key_exists('special_attribute_value', $this->validationErrors)) {
                $this->checkFloat('special_attribute_value', $val, 'Value');
            }
            return $val;
        }
    }


    private function addError($key, $val)
    {
        $this->validationErrors[$key] = $val;
    }


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

    private function dimensionsToString($array) //Converts Height, Width and Length input values to 'HxWxL' string
    {
        $trimmed = array_map('trim', $array);
        $string = implode('x', $trimmed);
        return $string;
    }
}
