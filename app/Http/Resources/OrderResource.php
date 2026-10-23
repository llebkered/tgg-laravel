<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class OrderResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'email' => $this->email,
            'customer_id' => $this->customer_id,
            'order_status_id' => $this->order_status_id,
            'address_id' => $this->address_id,
            'line1' => $this->line1,
            'line2' => $this->line2,
            'city' => $this->city,
            'state' => $this->state,
            'postcode' => $this->postcode,
            'state' => $this->state,
            'country' => $this->country,
            'phone' => $this->phone,
            // 'cart' => $this->cart, //(array)json_decode($this->cart),
            'description' => $this->description,
            'comments' => $this->comments,
            'tax' => $this->tax,
            'gst' => $this->gstAmount(),
            'id' => $this->id,
            'order_status' => $this->order_status,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}
