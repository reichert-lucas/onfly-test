<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\TravelOrder\ChangeStatusRequest;
use App\Http\Resources\TravelOrderResource;
use App\Models\TravelOrder;
use App\Scopes\UserScope;

class TravelOrderController extends Controller
{
    public function index()
    {
        return TravelOrderResource::collection(
            TravelOrder::withoutGlobalScope(UserScope::class)->paginate(10)
        );
    }

    public function show(int $order)
    {
        $order = TravelOrder::withoutGlobalScope(UserScope::class)->findOrFail($order);

        return response()->json(new TravelOrderResource($order));
    }

    public function changeStatus(ChangeStatusRequest $request, int $order)
    {
        $order = $request->getOrder($order);
        
        $order->travel_order_status_id = $request->status_id;
        $order->save();

        return response()->json(new TravelOrderResource($order));
    }
}
