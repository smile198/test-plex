<?php

namespace App\Attributes;

#[Attribute]
class DtoRule
{
    function __construct(
        public ?int $min = null,
        public ?int $max = null,
        public ?string $date_format = null,
    ) {}
}
