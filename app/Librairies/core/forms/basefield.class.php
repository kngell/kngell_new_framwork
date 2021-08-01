<?php

declare(strict_types=1);
abstract class BaseField implements FieldInterface
{
    protected const TYPE_TEXT = 'text';
    protected const TYPE_EMAIL = 'email';
    protected const TYPE_NUMBER = 'number';
    protected const TYPE_PASSWORD = 'password';
    protected const TYPE_CHECKBOX = 'checkbox';
    protected const TYPE_RADIO = 'radio';
    protected const TYPE_HIDDEN = 'hidden';
    protected string $attribute;
    protected string $label;
    protected string $FieldwrapperClass;
    protected string $labelClass;
    protected string $require;
    protected string $fieldclass;
    protected string $fieldID;
    protected string $customAttribute = '';
    protected string $spanClass;
    protected string $fieldValue;
    protected string $labelUp;
    protected bool $withLabel = false;

    protected Model $model;

    public function hidden()
    {
        $this->type = self::TYPE_HIDDEN;
        return $this;
    }

    public function checkboxType()
    {
        $this->type = self::TYPE_CHECKBOX;
        return $this;
    }

    public function __toString()
    {
        return sprintf(
            $this->FieldTemplate(),
            $this->renderField(),
        );
    }

    public function setAttr(string $attribute) : self
    {
        $this->type = self::TYPE_TEXT;
        $this->attribute = $attribute;
        return $this;
    }

    public function setClass(array $args = []) : self
    {
        foreach ($args as $tag => $class) {
            $this->$tag = $class;
        }
        return $this;
    }

    public function setModel(Model $model = null) : self
    {
        if (null == $model) {
            if (isset($this->model)) {
                unset($this->model);
            }
        } else {
            $this->model = $model;
        }
        return $this;
    }

    public function setDefault() : self
    {
        foreach ($this as $key => $value) {
            if (is_string($value)) {
                $this->{$key} = '';
            }
            if (is_bool($value)) {
                $this->{$key} = false;
            }
        }
        return $this;
    }

    public function spanClass(string $class)
    {
        $this->spanClass = $class;
        return $this;
    }

    public function attr(array $attrs = [])
    {
        foreach ($attrs as $key => $attr) {
            $this->customAttribute .= $key . ' = "' . $attr . '" ';
        }

        return $this;
    }

    public function class(string $custom)
    {
        $actual = $this->fieldclass ?? '';
        $this->fieldclass = $actual . ' ' . $custom;
        return $this;
    }

    public function id(string $id)
    {
        $this->fieldID = $id;
        return $this;
    }

    public function Label(string $label) : self
    {
        $this->withLabel = true;
        $this->label = $label;
        return $this;
    }

    public function labelUp(string $label)
    {
        $this->withLabel = true;
        $this->label = $label;
        $this->labelUp = ' {{label}} %s';
        return $this;
    }

    public function LabelClass(string $labelclass) : self
    {
        $this->labelClass = $labelclass;
        return $this;
    }

    public function wrapperClass(string $wrapper)
    {
        $actual = $this->FieldwrapperClass ?? '';
        $this->FieldwrapperClass = $actual . ' ' . $wrapper;
        return $this;
    }

    public function req()
    {
        $this->require = '<span class="text-danger">*</span>';
        return $this;
    }

    public function value(string $val) : self
    {
        $this->fieldValue = $val;
        return $this;
    }

    public function fieldID()
    {
        if (isset($this->model)) {
            return $this->fieldID . $this->model->{$this->model->get_colID()};
        }
        return $this->fieldID;
    }

    public function labelValue()
    {
        if (isset($this->model)) {
            return $this->model->htmlDecode($this->model->{$this->attribute}) ?? '';
        }
        return $this->label;
    }

    public function labelDescrValue()
    {
        if (isset($this->model)) {
            return $this->model->htmlDecode($this->labelDescr) ?? '';
        }
        return $this->labelDescr;
    }

    public function fieldValue()
    {
        if (isset($this->model) && (!isset($this->fieldValue) || empty($this->fieldValue))) {
            return $this->model->htmlDecode((string)$this->model->{$this->model->get_colID()});
        }
        return $this->fieldValue ?? '';
    }

    public function fieldAttributeValue() :string
    {
        if (isset($this->model)) {
            return $this->model->htmlDecode($this->model->{$this->attribute});
        }
        return '';
    }

    public function hasErrors()
    {
        if (isset($this->model)) {
            return $this->model->hasError($this->attribute) ? 'is-invalid' : '';
        }
        return '';
    }

    public function errors() : string
    {
        if (isset($this->model)) {
            return (string)$this->model->getFirstError($this->attribute);
        }
        return '';
    }

    public function fieldLabelTemplate() : string
    {
        $template = file_get_contents(FILES . 'template' . DS . 'base' . DS . 'forms' . DS . 'inputLabelTemplate.php');
        $template = str_replace('{{inputID}}', $this->fieldID ?? $this->attribute, $template);
        $template = str_replace('{{classlabel}}', $this->labelClass ?? '', $template);
        $template = str_replace('{{label}}', $this->label ?? '', $template);
        $template = str_replace('{{req}}', $this->require ?? '', $template);
        return $template;
    }
}