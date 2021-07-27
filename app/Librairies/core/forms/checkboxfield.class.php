<?php

declare(strict_types=1);
class CheckBoxField extends BaseField
{
    public function checkboxType()
    {
        $this->type = self::TYPE_CHECKBOX;
        return $this;
    }

    public function renderField(): string
    {
        return sprintf(
            '<input type="%s" name="%s" value="%s" class="%s %s" id="%s" %s %s>',
            $this->type,
            $this->attribute,
            'on',
            $this->fieldclass ?? '',
            $this->model->hasError($this->attribute) ? 'is-invalid' : '',
            $this->fieldID ?? '',
            $this->customAttribute,
            $this->model->save_for_later == 'on' ? 'checked' : ''
        );
    }

    public function FieldTemplate(): string
    {
        $template = file_get_contents(FILES . 'template' . DS . 'base' . DS . 'forms' . DS . 'inputcheckboxTemplate.php');
        $template = str_replace('{{wrapperClass}}', $this->FieldwrapperClass ?? '', $template);
        $template = str_replace('{{labelClass}}', $this->labelClass ?? '', $template);
        $template = str_replace('{{inputID}}', $this->fieldID, $template);
        $template = str_replace('{{spanClass}}', $this->spanClass ?? '', $template);
        $template = str_replace('{{label}}', $this->label ?? '', $template);
        return $template;
    }
}