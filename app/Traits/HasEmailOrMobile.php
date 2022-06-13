<?php

namespace App\Traits;


trait HasEmailOrMobile
{

    public function checkEmailOrMobile($attributes): string
    {
        $username = $attributes['username'];
        $field_type = filter_var($username, FILTER_VALIDATE_EMAIL) ? 'email' : 'mobile';
        request()->merge([
            $field_type => $username
        ]);
        return $field_type;
    }
}

