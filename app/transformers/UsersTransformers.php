<?php

namespace App\transformers;

use Illuminate\Database\Eloquent\Model;

class UsersTransformers
{
    public function transformModel(Model $modelOrCollection)
    {
        return [
            'id' => $modelOrCollection->id,
            'name' => $modelOrCollection->name,
            'email' => $modelOrCollection->email,
            'token' => $modelOrCollection->api_token,
        ];
    }
}