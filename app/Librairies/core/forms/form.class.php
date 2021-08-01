<?php

declare(strict_types=1);
class Form
{
    protected FieldInterface $field;
    protected TextareaField $textarea;
    protected SelectField $select;
    protected CheckBoxField $checkbox;
    protected RadioField $radio;
    protected ImageDragAndDropField $imageDD;
    protected string $action = '';
    protected string $method = '';
    protected string $formID = '';
    protected string $formClass = '';
    protected string $formCustomAttr = '';
    protected array $fieldCommonclass = [];

    public function __construct(InputField $field, TextareaField $textarea, SelectField $select, CheckBoxField $checkbox, RadioField $radio, ImageDragAndDropField $imageDD)
    {
        $this->field = $field;
        $this->textarea = $textarea;
        $this->select = $select;
        $this->checkbox = $checkbox;
        $this->radio = $radio;
        $this->imageDD = $imageDD;
    }

    public function custumAttr(array $attrs = [])
    {
        foreach ($attrs as $key => $attr) {
            $this->{$key} = $attr;
        }

        return $this;
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

    public function setFieldClass(array $args = []) : self
    {
        // $this->field->setClass($args);
        // $this->select->setClass($args);
        // $this->textarea->setClass($args);
        // $this->checkbox->setClass($args);
        // $this->radio->setClass($args);
        $this->fieldCommonclass = $args;
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
        return $this->field->setDefault()->setClass($this->fieldCommonclass);
    }

    public function getTextarea()
    {
        return $this->textarea->setDefault()->setClass($this->fieldCommonclass);
    }

    public function getSelect()
    {
        return $this->select->setDefault()->setClass($this->fieldCommonclass);
    }

    public function getCheckbox()
    {
        return $this->checkbox->setDefault()->setClass($this->fieldCommonclass);
    }

    public function getRadio()
    {
        return $this->radio->setDefault()->setClass($this->fieldCommonclass);
    }

    public function getImageDD()
    {
        return $this->imageDD;
    }

    public function begin()
    {
        return sprintf(
            '<form action ="%s" method="%s" class="%s" id="%s" %s>',
            $this->action,
            $this->method,
            $this->formClass,
            $this->formID,
            $this->formCustomAttr
        );
    }

    public function submit(int $submitBtnNumber = 1)
    {
        $button = '';
        $submitType = 'submit';
        for ($i = 0; $i < $submitBtnNumber ; $i++) {
            if ($i > 0) {
                $submitType = 'button';
            }
            if ($submitBtnNumber === 1) {
                $text = 'Send';
            } else {
                $text = $i == 0 ? 'Cancel' : 'Send';
            }
            $button .= '<div class="action"><button type="' . $submitType . '" name="submitBtn" id="submitBtn' . $i . '" class="button">' . $text . '</button></div>';
        }
        return '<div class="mb-3">' . $button . '</div>';
    }

    public function end()
    {
        return '</form>';
    }

    public function input(string $attribbute)
    {
        return $this->field->setDefault()->setAttr($attribbute)->setClass($this->fieldCommonclass);
    }

    public function textarea(string $attribbute)
    {
        return $this->textarea->setDefault()->setAttr($attribbute)->setClass($this->fieldCommonclass);
    }

    public function select(string $attribbute)
    {
        return $this->select->setDefault()->setAttr($attribbute)->setClass($this->fieldCommonclass);
    }

    public function checkbox(string $attribbute)
    {
        return $this->checkbox->setDefault()->setAttr($attribbute)->setClass($this->fieldCommonclass)->checkboxType();
    }

    public function radio(string $attribbute)
    {
        return $this->radio->setDefault()->setAttr($attribbute)->setClass($this->fieldCommonclass);
    }

    public function imageDD()
    {
        return $this->imageDD;
    }
}