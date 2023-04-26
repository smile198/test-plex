<?php

namespace App\Http\Controllers;

use App\Dto\OfferDto;
use App\Http\Controllers\Controller;
use App\Http\Requests\OfferCreateFormRequest;

class OfferController extends Controller
{
    public function create(OfferCreateFormRequest $request): OfferDto
    {
        return $request->toDto();
    }
}
