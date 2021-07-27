<?php

declare(strict_types=1);
class TextareaField extends BaseField
{
    protected int $row;

    public function row(int $r)
    {
        $this->row = $r;
        return $this;
    }

    public function renderField(): string
    {
        return sprintf(
            '<textarea name="%s" class="form-control %s %s" id="%s" row="%s">%s</textarea>',
            $this->attribute,
            $this->fieldclass ?? '',
            $this->model->hasError($this->attribute) ? 'is-invalid' : '',
            $this->fieldID ?? '',
            $this->row ?? '',
            $this->model->htmlDecode($this->model->{$this->attribute}),
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