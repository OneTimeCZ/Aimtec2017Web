<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Watson\Validating\ValidatingTrait;

/**
 * Class BaseModel
 * Parent of each App Model
 *
 * @package App\Models
 */
abstract class BaseModel extends Model
{
    use ValidatingTrait;

    protected $observables = ['validating', 'validated'];

    /**
     * Get an attribute from the model. Tries also converting camelCase to snake_case
     *
     * @param  string  $key
     * @return mixed
     */
    public function getAttribute($key)
    {
        if (array_key_exists($key, $this->attributes) || $this->hasGetMutator($key)) {
            return $this->getAttributeValue($key);
        }

        $snakeKey = snake_case($key);
        if (array_key_exists($snakeKey, $this->attributes) || $this->hasGetMutator($snakeKey)) {
            return $this->getAttributeValue($snakeKey);
        }

        return $this->getRelationValue($key);
    }

    /**
     * Sets an attribute. Uses snake_case every time.
     *
     * @param string $key
     * @param mixed $value
     * @return BaseModel|Model
     */
    public function setAttribute($key, $value)
    {
        return parent::setAttribute(snake_case($key), $value);
    }

    public function addRule($key, $rule)
    {
        if (array_key_exists($key, $this->rules)) {
            $this->rules[$key] .= "|" . $rule;
        }
        else {
            $this->rules[$key] = $rule;
        }
    }
}
