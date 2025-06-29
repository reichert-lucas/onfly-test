<?php

namespace App\Http\Controllers\User;

use App\Enum\TravelOrderStatusEnum;
use App\Http\Controllers\Controller;
use App\Http\Requests\TravelOrder\StoreRequest;
use App\Http\Resources\TravelOrderResource;
use App\Models\TravelOrder;

class TravelOrderController extends Controller
{
    public function index()
    {
        return TravelOrderResource::collection(
            TravelOrder::paginate(10)
        );
    }

    public function store(StoreRequest $request)
    {
        $order = TravelOrder::create(array_merge(
            $request->validated(),
            [
                'user_id' => $request->user()->id,
                'system_id' => $request->user()->system_id,
                'travel_order_status_id' => TravelOrderStatusEnum::REQUESTED->value
            ]
        ));

        return response()->json(new TravelOrderResource($order), 201);
    }

    public function show(TravelOrder $order)
    {
        return response()->json(new TravelOrderResource($order));
    }
}
