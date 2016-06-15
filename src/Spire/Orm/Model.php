<?php
namespace Spire\Orm;

class Model
{

    /**
     * @var  string  The table name.
     */
    protected static $table = '';

    /**
     * @var array Model attributes.
     */
    protected $attributes = [];

    /**
     * Constructor.
     *
     * @return void
     */
    public function __construct()
    {

    }

    /**
     * Gets an attribute.
     *
     * @param  string  $attribute  The attribute to get.
     * @return mixed
     */
    public function __get(string $attribute)
    {
        return $this->getAttribute($attribute);
    }

    /**
     * Sets an attribute.
     *
     * @param  string  $attribute  The attribute name.
     * @param  mixed   $value      The attribute value.
     * @return void
     */
    public function __set(string $attribute, $value)
    {
        $this->setAttribute($attribute, $value);
    }

    /**
     * Gets all model attributes.
     *
     * @return array
     */
    public function attributes(): array
    {
        return $this->attributes;
    }

    /**
     * Gets a model attribute.
     *
     * @param  string  $attribute  The attribute to get.
     * @return mixed
     */
    public function getAttribute(string $attribute)
    {
        return $this->attributes[$attribute] ?? false;
    }

    /**
     * Sets a model attribute.
     *
     * @param  string  $attribute
     * @param  mixed   $value
     * @return void
     */
    public function setAttribute(string $attribute, $value)
    {
        $this->attributes[$attribute] = $value;
    }

    /**
     * Checks to see if an attribute exists.
     *
     * @param  string  $attribute  The attribute to check.
     * @return bool
     */
    public function hasAttribute(string $attribute): bool
    {
        return isset($this->attributes[$attribute]);
    }

    /**
     * Saves the record.
     *
     * @return bool
     */
    public function save(): bool
    {

    }

    /**
     * Instantiates a model query with the SELECT clause.
     *
     * @param  array  $fields  The fields to select.
     * @return \Spire\Orm\Query
     */
    public static function select(array $fields): Query
    {
        $query = new Query(static::$table, get_called_class());
        return $query->select($fields);
    }

}
