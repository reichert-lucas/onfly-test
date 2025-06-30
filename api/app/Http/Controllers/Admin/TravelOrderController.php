<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\TravelOrder\ChangeStatusRequest;
use App\Http\Requests\TravelOrder\SearchRequest;
use App\Http\Resources\TravelOrderResource;
use App\Mail\StatusChangedMessage;
use App\Models\TravelOrder;
use App\Scopes\UserScope;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;

class TravelOrderController extends Controller
{
    public function index(SearchRequest $request)
    {
        return TravelOrderResource::collection(
            TravelOrder::search($request->validated())
                ->withoutGlobalScope(UserScope::class)
                ->paginate(10)
        );
    }

    public function show(int $order)
    {
        $order = TravelOrder::withoutGlobalScope(UserScope::class)->findOrFail($order);

        return response()->json(new TravelOrderResource($order));
    }

    public function changeStatus(ChangeStatusRequest $request, int $order)
    {
        try {
            DB::beginTransaction();

            $order = $request->getOrder($order);
    
            $order->travel_order_status_id = $request->status_id;
            $order->save();

            $user = $order->user;
            
            Mail::to($user->email)
                ->queue(new StatusChangedMessage(
                    $user->name,
                    $request->status_id
                ));

            DB::commit();
        } catch(\Exception $e) {
            DB::rollBack();
            
            return throw $e;
        }

        return response()->json(new TravelOrderResource($order));
    }
}
