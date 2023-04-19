<?php

namespace App\Services;

use App\Models\User;
use Illuminate\Support\Facades\Auth;

class UserService
{
    private User|null $user = null;

    public function getAll()
    {
        return User::all();
    }

    public function getUser($id)
    {
        return User::find($id);
    }

    /**
     * @throws \Exception
     */
    public function createUser($data): User
    {
        $user = new User();
        $user->name = $data['name'];
        $user->phone = $data['phone'];

        if (!$user->save()) {
            throw new \Exception('Error while save user');
        }

        $this->user = $user;

        (new LinkService())->generate($user);

        return $user;
    }

    public function deleteCurrent(): bool
    {
        if ($this->user) {
            return $this->user->delete();
        }

        return false;
    }

    public function deleteUser($user): bool
    {
        return $user->delete();
    }
}
