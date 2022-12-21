<?php

namespace App\Http\Requests;

use App\Http\Responses\JsonResponse;
use Illuminate\Contracts\Container\BindingResolutionException;
use Laravel\Lumen\Http\Request;
use Illuminate\Contracts\Container\Container;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Validation\ValidationException;
use Illuminate\Validation\ValidatesWhenResolvedTrait;
use Illuminate\Contracts\Validation\ValidatesWhenResolved;
use Illuminate\Contracts\Validation\Factory as ValidationFactory;

abstract class BaseRequest extends Request implements ValidatesWhenResolved
{
    use ValidatesWhenResolvedTrait;

    /**
     * The container instance.
     *
     * @var Container
     */
    protected $container;

    /**
     * The key to be used for the view error bag.
     *
     * @var string
     */
    protected $errorBag = 'default';

    /**
     * Get the validator instance for the request.
     *
     * @return Validator
     * @throws BindingResolutionException
     */
    protected function getValidatorInstance(): Validator
    {
        $factory = $this->container->make(ValidationFactory::class);

        if (method_exists($this, 'validator')) {
            $validator = $this->container->call([$this, 'validator'], compact('factory'));
        } else {
            $validator = $this->createDefaultValidator($factory);
        }

        if (method_exists($this, 'withValidator')) {
            $this->withValidator($validator);
        }

        return $validator;
    }

    /**
     * Create the default validator instance.
     *
     * @param ValidationFactory $factory
     * @return Validator
     */
    protected function createDefaultValidator(ValidationFactory $factory): Validator
    {
        return $factory->make(
            $this->validationData(), $this->container->call([$this, 'rules']),
            $this->messages(), $this->attributes()
        );
    }

    /**
     * Get data to be validated from the request.
     *
     * @return array
     */
    protected function validationData(): array
    {
        return $this->all();
    }

    /**
     * Handle a failed validation attempt.
     *
     * @param Validator $validator
     * @return ValidationException
     * @throws ValidationException
     */
    protected function failedValidation(Validator $validator): ValidationException
    {
        throw new ValidationException($validator, $this->formatErrors($validator));
    }

    /**
     * Format the errors from the given Validator instance.
     *
     * @param Validator $validator
     * @return JsonResponse
     */
    protected function formatErrors(Validator $validator): JsonResponse
    {
        $errors = $validator->errors();
        return (new JsonResponse())
            ->setError($errors->first())
            ->setCode(422)
            ->setStatusCode(422);
    }

    /**
     * Get custom messages for validator errors.
     *
     * @return array
     */
    public function messages(): array
    {
        return [];
    }

    /**
     * Get custom attributes for validator errors.
     *
     * @return array
     */
    public function attributes(): array
    {
        return [];
    }

    /**
     * Set the container implementation.
     *
     * @param Container $container
     * @return $this
     */
    public function setContainer(Container $container): BaseRequest
    {
        $this->container = $container;

        return $this;
    }

    /**
     * Get the validated data from the request.
     *
     * @return array
     * @throws BindingResolutionException
     * @throws ValidationException
     */
    public function validated(): array
    {
        return $this->getValidatorInstance()->validated();
    }

    /**
     * @param string $key
     * @return string
     */
    public function getMessage(string $key): string
    {
        return !empty($this->messages()[$key])
            ? $this->messages()[$key]
            : 'Validation failed';
    }

    /**
     * @return mixed
     */
    abstract function getDTO();
}
