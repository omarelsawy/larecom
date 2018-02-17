<?php

namespace App\Http\Resources\User;

use Illuminate\Http\Resources\Json\Resource;

class UsersResource extends Resource
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
            'name' => $this->name,
            'href' =>[
                'relate link' => route('users.show' , $this->id)
            ]

        ];
    }
}
