<?php

namespace App\Services;

use App\Models\User;

class UserService
{
    public function getAccessibleEtaId(User $user)
    {
        $accessibleEta = $user->etas->first();

        if ($accessibleEta) {
            return $accessibleEta->id;
        }

        return null;
    }

    public function redirectRole(User $user)
    {
        // dd($user);

        if ($user->role === 'master') {
            return redirect()->route('dashboard.index');
        }

        return redirect()->route('record.index');
        // Personalize conforme necessário se nenhum redirecionamento for possível
        return redirect()->route('login');
    }
}
