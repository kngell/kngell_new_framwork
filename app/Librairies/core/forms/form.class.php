<?php

declare(strict_types=1);
class Form
{
    protected FieldInterface $field;
    protected TextareaField $textarea;
    protected SelectField $select;
    protected CheckBoxField $checkbox;
    protected RadioField $radio;

    public function __construct(InputField $field, TextareaField $textarea, SelectField $select, CheckBoxField $checkbox, RadioField $radio)
    {
        $this->field = $field;
        $this->textarea = $textarea;
        $this->select = $select;
        $this->checkbox = $checkbox;
        $this->radio = $radio;
    }

    public function setModel(Model $model = null) : self
    {
        $this->field->setModel($model);
        $this->textarea->setModel($model);
        $this->select->setModel($model);
        $this->checkbox->setModel($model);
        $this->radio->setModel($model);
        return $this;
    }

    public function setClass(array $args = []) : self
    {
        foreach ($args as $elmt => $class) {
            $this->field->setClass($elmt, $class);
            $this->select->setClass($elmt, $class);
            $this->textarea->setClass($elmt, $class);
            $this->checkbox->setClass($elmt, $class);
            $this->radio->setClass($elmt, $class);
        }
        return $this;
    }

    public function setDefault()
    {
        $this->field->setDefault();
        $this->textarea->setDefault();
        $this->select->setDefault();
        $this->checkbox->setDefault();
        $this->radio->setDefault();
        return $this;
    }

    public function getInputField()
    {
        return $this->field;
    }

    public function getTextarea()
    {
        return $this->textarea;
    }

    public function getSelect()
    {
        return $this->select;
    }

    public function getCheckbox()
    {
        return $this->checkbox;
    }

    public function getRadio()
    {
        return $this->radio;
    }

    public function begin(string $action = '', string $method = '')
    {
        return sprintf('<form action ="%s" method="%s">', $action, $method);
    }

    public function end()
    {
        return '</form>';
    }

    public function input(string $attribbute)
    {
        $this->field->setAttr($attribbute);
        return $this->field;
    }

    public function textarea(string $attribbute)
    {
        $this->textarea->setAttr($attribbute);
        return $this->textarea;
    }

    public function select(string $attribbute)
    {
        $this->select->setAttr($attribbute);
        return $this->select;
    }

    public function checkbox(string $attribbute)
    {
        $this->checkbox->setAttr($attribbute);
        return $this->checkbox;
    }

    public function radio(string $attribbute)
    {
        $this->radio->setAttr($attribbute);
        return $this->radio;
    }
}