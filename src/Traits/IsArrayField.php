<?php


namespace Tanthammar\TallForms\Traits;


use Tanthammar\TallForms\BaseField;
use Tanthammar\TallForms\Exceptions\invalidArrayFieldType;

trait IsArrayField
{
    public $fields = [];
    public $array_wrapper_class; //set in parent construct
    public $array_wrapper_grid_class; //set in parent construct

    public function fields($fields = []): self
    {
        foreach ($fields as $field) {
            throw_if(!$field->allowed_in_array,
                new invalidArrayFieldType($field->name, $field->type)
            );
        }
        $this->fields = $fields;
        return $this;
    }

    /**
     * Applied to the outer wrapper surrounding Array and KeyVal field groups
     * Default 'rounded border bg-gray-50';
     *
     * @param string $classes
     * @return $this
     */
    public function wrapperClass(string $classes): self
    {
        $this->array_wrapper_class = $classes;
        return $this;
    }

    public function wrapperGrid(string $classes): self
    {
        $this->array_wrapper_grid_class = $classes;
        return $this;
    }

    public function fieldToArray()
    {
        $array = [];
        if (filled($this->fields)) {
            foreach ($this->fields as $field) {
                $array[] = (array)$field;
            }
        }
        $array[$this->key] = $array;
        return $array;
    }

}
