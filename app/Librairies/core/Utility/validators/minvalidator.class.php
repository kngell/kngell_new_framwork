<?php
class Minvalidator extends CustomValidator
{
    public function runValidation()
    {
        $value = $this->_model->{$this->field};
        $pass = (strlen($value) >= $this->rule);
        return $pass;
    }
}