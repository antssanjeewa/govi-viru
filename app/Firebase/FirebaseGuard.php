<?php

namespace App\Firebase;

use App\Firebase\User;
use Firebase\Auth\Token\Verifier;

class FirebaseGuard
{
    protected $verifier;

    public function __construct(Verifier $verifier)
    {
        $this->verifier = $verifier;
    }

    public function user($request)
    {
        $token = $request->bearerToken();

        try {
            $token = $this->verifier->verifyIdToken($token);
            return new User($token->getClaims());
        }
        catch (\Exception $e) {
            return;
        }
    }
}
