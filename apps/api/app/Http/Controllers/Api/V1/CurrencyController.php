<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Resources\CurrencyResource;
use App\Services\CurrencyService;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class CurrencyController extends Controller
{
    public function __construct(private readonly CurrencyService $currencyService)
    {}

    public function index(Request $request): AnonymousResourceCollection
    {
        $showAll = $request->filled('show_all') && $request->show_all == true;
        $currencies = $showAll ? $this->currencyService->getAll() : $this->currencyService->getActive();

        return CurrencyResource::collection($currencies);
    }

    public function show(Request $request, string $code): CurrencyResource
    {
        $currency = $this->currencyService->findByCode($code);

        abort_if($currency === null, 404, 'Currency not found');

        return new CurrencyResource($currency);
    }
}
