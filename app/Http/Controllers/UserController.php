<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class UserController extends Controller
{
    public function updateAvatar(Request $request)
    {
        // Validação para garantir que o arquivo seja uma imagem
        $request->validate([
            'avatar' => 'required|image|max:2048', // Limite de 2MB
        ]);

        // Verificar se o usuário já tem uma imagem de perfil
        $user = auth()->user();

        // Se o usuário já tem uma imagem de perfil, remova a antiga
        if ($user->profile_image_path) {
            // Verificar se a imagem existe no storage e excluí-la
            Storage::delete('public/' . $user->profile_image_path);
        }

        // Salvar a nova imagem
        $path = $request->file('avatar')->store('avatars', 'public');

        // Atualizar o caminho da imagem no banco de dados
        $user->profile_image_path = $path;
        $user->save();

        return back()->with('success', 'Imagem de perfil atualizada com sucesso!');
    }
}
