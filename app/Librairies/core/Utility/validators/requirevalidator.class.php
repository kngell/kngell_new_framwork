<?php
class Requirevalidator extends CustomValidator
{
    public function runValidation()
    {
        $pass = true;
        $value = $this->_model->{$this->field};
        $pass = (!empty($value));
        return $pass;
    }
}