<?php

declare(strict_types=1);
class InputField extends BaseField
{
    public string $type;

    public function passwordType()
    {
        $this->type = self::TYPE_PASSWORD;
        return $this;
    }

    public function emailType()
    {
        $this->type = self::TYPE_EMAIL;
        return $this;
    }

    public function renderField(): string
    {
        return sprintf(
            '<input type="%s" name="%s" value="%s" class="form-control %s %s" id="%s" autocomplete="nope" placeholder=" " %s>',
            $this->type,
            $this->attribute,
            $this->model->htmlDecode($this->model->{$this->attribute}),
            $this->fieldclass ?? '',
            $this->model->hasError($this->attribute) ? 'is-invalid' : '',
            $this->fieldID ?? '',
            $this->customAttribute
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