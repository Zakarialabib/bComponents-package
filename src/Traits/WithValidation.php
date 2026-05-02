<?php

declare(strict_types=1);

namespace Zakarialabib\BComponents\Traits;

use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;

trait WithValidation
{
    /**
     * The validation rules.
     *
     * @var array
     */
    protected array $rules = [];

    /**
     * The validation messages.
     *
     * @var array
     */
    protected array $messages = [];

    /**
     * The validation attributes.
     *
     * @var array
     */
    protected array $validationAttributes = [];

    /**
     * The validation errors.
     *
     * @var array
     */
    protected array $validationErrors = [];

    /**
     * Validate the component's properties.
     *
     * @param array|null $rules
     * @param array|null $messages
     * @param array|null $attributes
     * @return array
     * @throws ValidationException
     */
    public function validateComponent(?array $rules = null, ?array $messages = null, ?array $attributes = null): array
    {
        $rules = $rules ?? $this->rules;
        $messages = $messages ?? $this->messages;
        $attributes = $attributes ?? $this->validationAttributes;

        $data = $this->getDataForValidation($rules);

        $validator = Validator::make($data, $rules, $messages, $attributes);

        if ($validator->fails()) {
            $this->validationErrors = $validator->errors()->toArray();
            
            if (method_exists($this, 'setErrorBag')) {
                $this->setErrorBag($validator->errors());
            }
            
            throw new ValidationException($validator);
        }

        $this->validationErrors = [];

        return $validator->validated();
    }

    /**
     * Get the data for validation.
     *
     * @param array $rules
     * @return array
     */
    protected function getDataForValidation($rules)
    {
        $rules = is_array($rules) ? $rules : [];
        $attributes = array_keys($rules);

        $data = [];
        foreach ($attributes as $attribute) {
            $key = explode('.', $attribute)[0];
            
            $data[$key] = $this->{$key} ?? null;
        }

        return $data;
    }

    /**
     * Reset the validation errors.
     *
     * @return $this
     */
    public function resetValidation($field = null)
    {
        $this->validationErrors = [];
        
        if (method_exists($this, 'resetErrorBag')) {
            $this->resetErrorBag($field);
        }
        
        return $this;
    }

    /**
     * Determine if the component has validation errors.
     *
     * @param string|null $key
     * @return bool
     */
    public function hasValidationErrors(?string $key = null): bool
    {
        return $key 
            ? Arr::has($this->validationErrors, $key) 
            : count($this->validationErrors) > 0;
    }

    /**
     * Get the validation errors.
     *
     * @param string|null $key
     * @return mixed
     */
    public function getValidationErrors(?string $key = null)
    {
        return $key 
            ? Arr::get($this->validationErrors, $key) 
            : $this->validationErrors;
    }
} 
