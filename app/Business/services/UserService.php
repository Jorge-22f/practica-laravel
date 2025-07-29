<?php

namespace App\Business\Services;

use App\Models\User;

class UserService
{

    public function __construct(protected EncryptorService $encryptorService){

    }

    public function encryptEmail(int $id): string
    {
        $user = User::find($id);

        return $this->encryptorService->encrypt($user->email);
    }

}