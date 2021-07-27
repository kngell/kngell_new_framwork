<?php

declare(strict_types=1);
class SelectField extends BaseField
{
    public function options()
    {
        return sprintf(
            '<option value="%s"> %s </option>',
            $this->model->{$this->attribute},
            current($this->model->get_countrie($this->model->{$this->attribute})) ?? ''
        );
    }

    public function renderField(): string
    {
        return sprintf(
            '<select name="%s" class="form-select %s %s" id="%s" placeholder=" ">%s</select>',
            $this->attribute,
            $this->fieldclass ?? '',
            $this->model->hasError($this->attribute) ? 'is-invalid' : '',
            $this->fieldID ?? '',
            $this->options()
        );
    }

    public function FieldTemplate(): string
    {
        $template = file_get_contents(FILES . 'template' . DS . 'base' . DS . 'forms' . DS . 'inputfieldTemplate.php');
        $template = str_replace('{{classwrapper}}', $this->FieldwrapperClass ?? '', $template);
        $template = str_replace('{{classlabel}}', $this->labelClass ?? '', $template);
        $template = str_replace('{{inputID}}', $this->fieldID, $template);
        $template = str_replace('{{label}}', $this->label ?? '', $template);
        $template = str_replace('{{req}}', $this->require ?? '', $template);
        $template = str_replace('{{feedback}}', (string)$this->model->getFirstError($this->attribute), $template);
        return $template;
    }
}