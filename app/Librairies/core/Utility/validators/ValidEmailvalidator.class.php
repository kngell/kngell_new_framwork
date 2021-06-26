<?php
class ValidEmailvalidator extends CustomValidator
{
    public function runValidation()
    {
        $pass=true;
        $value = $this->_model->{$this->field};
        if (!empty($value)) {
            $pass = filter_var($value, FILTER_VALIDATE_EMAIL);
        }
        return $pass;
    }
}