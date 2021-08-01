<?php

declare(strict_types=1);
interface FieldInterface
{
    /**
     * Render Field input Type
     * --------------------------------------------------------------------------------------------------
     * @return string
     */
    public function renderField() : string ;

    /**
     * Render Field template
     * --------------------------------------------------------------------------------------------------
     * @return string
     */
    public function FieldTemplate() : string;

    /**
     * Set field global class
     * --------------------------------------------------------------------------------------------------
     * @param array $args
     * @return self
     */
    public function setClass(array $args = []) : self;

    /**
     * Set Field Attribute
     * --------------------------------------------------------------------------------------------------
     * @param string $attribute
     * @return void
     */
    public function setAttr(string $attribute) : self;

    public function setModel(Model $model) : self;

    public function setDefault() : self;
}