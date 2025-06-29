<?php

namespace App\Http\Requests\TravelOrder;

use App\Enum\TravelOrderStatusEnum;
use App\Models\TravelOrder;
use App\Scopes\UserScope;
use Illuminate\Foundation\Http\FormRequest;

class ChangeStatusRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'status_id' => 'required|integer|exists:travel_order_statuses,id'
        ];
    }

    public function withValidator($validator)
    {
        $validator->after(function ($validator) {
            $order = $this->getOrder(intval($this->route('order')));
            
            if ($order->user_id === $this->user()->id) {
                $validator->errors()->add('status_id', 'Você não pode alterar o status de uma ordem criada por você mesmo.');
            }
            
            $currentStatus = $order->travel_order_status_id;
            $newStatus = $this->status_id;
            
            $allowedTransitions = [
                TravelOrderStatusEnum::REQUESTED->value => [
                    TravelOrderStatusEnum::APPROVED->value,
                    TravelOrderStatusEnum::CANCELLED->value
                ],
                TravelOrderStatusEnum::APPROVED->value => [
                    TravelOrderStatusEnum::CANCELLED->value
                ],
                TravelOrderStatusEnum::CANCELLED->value => [],
            ];
            
            if (!in_array($newStatus, $allowedTransitions[$currentStatus] ?? [])) {
                $validator->errors()->add('status_id', 'Transição de status não permitida.');
            }
        });
    }

    public function getOrder(int $orderId): TravelOrder
    {
        return TravelOrder::withoutGlobalScope(UserScope::class)->findOrFail($orderId);
    }
}
