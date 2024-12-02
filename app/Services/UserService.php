<?php

namespace App\Services;

use App\Models\User;

class UserService
{
    public function redirectRole(User $user)
    {
        

        if ($user->role === 'master') {
            return redirect()->route('paginainicial.index');
        }

        if ($user->role === 'administrativo') {
            return redirect()->route('paginainicial.index');
        }

        return redirect()->route('record.index');
        // Personalize conforme necessário se nenhum redirecionamento for possível
        return redirect()->route('login');
    }
}
