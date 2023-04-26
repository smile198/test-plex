<?php

namespace App\Dto;

use App\Attributes\DtoRule;
use Illuminate\Contracts\Support\Arrayable;

final readonly class OfferDto implements Arrayable
{
    #[DtoRule(max: 255)]
    public string $title;
    #[DtoRule(min: 1000, max: 999999999)]
    public int $price;
    #[DtoRule(max: 4096)]
    public ?string $description;
    public bool $isActive;
    #[DtoRule(date_format: 'Y-m-d H:i:s')]
    public string $publishAt;

    function __construct(
        string $title,
        int $price,
        bool $isActive,
        string $publishAt,
        ?string $description = null,
    ) {
        $this->title = $title;
        $this->price = $price;
        $this->isActive = $isActive;
        $this->publishAt = $publishAt;
        $this->description = $description;
    }

    public function toArray()
    {
        return get_object_vars($this);
    }
}
