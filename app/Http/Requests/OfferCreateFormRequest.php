<?php

namespace App\Http\Requests;

use App\Dto\OfferDto;
use Illuminate\Foundation\Http\FormRequest;

class OfferCreateFormRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return false;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array|string>
     */
    public function rules(): array
    {
        $reflection = new \ReflectionClass(OfferDto::class);

        $rules = [];

        $properties = $reflection->getProperties();
        $parameters = $this->getParameters($reflection);
        foreach ($properties as $property) {
            $key = $property->name;
            $keyRules = [
                $parameters[$key]['required'] ? 'required' : 'nullable',
                $parameters[$key]['type'],
            ];

            foreach ($property->getAttributes() as $attribute) {
                foreach ($attribute->getArguments() as $attrKey => $attrValue) {
                    $keyRules[] = sprintf('%s:%s', $attrKey, $attrValue);
                }
            }

            $rules[$key] = $keyRules;
        }

        return $rules;
    }

    private function getParameters(\ReflectionClass $reflection): array
    {
        $result = [];

        foreach ($reflection->getConstructor()->getParameters() as $parameter) {
            $result[$parameter->name] = [
                'type' => $parameter->hasType() ? $this->defineRuleType($parameter->getType()) : null,
                'required' => !$parameter->isDefaultValueAvailable(),
            ];
        }

        return $result;
    }

    private function defineRuleType(\ReflectionNamedType $namedType): ?string
    {
        $type = $namedType->isBuiltin() ? $namedType->getName() : null;

        return match($type) {
            'bool' => 'boolean',
            default => $type,
        };
    }

    public function toDto(): OfferDto
    {
        return app()->make(OfferDto::class, $this->validated());
    }
}
