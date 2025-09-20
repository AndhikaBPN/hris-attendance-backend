<?php

namespace App\Repositories\User;

use App\Models\User;

class UserRepository
{
    public function getAll()
    {
        return User::with(['role', 'division', 'position', 'manager'])->get();
    }

    public function findById($id)
    {
        return User::with(['role', 'division', 'position', 'manager'])->find($id);
    }

    public function getAllPaginated($perPage = 10)
    {
        return User::with(['role', 'division', 'position', 'manager'])->paginate($perPage);
    }

    public function create(array $data)
    {
        return User::create($data);
    }

    public function update(User $user, array $data)
    {
        $user->update($data);
        return $user;
    }

    public function delete(User $user)
    {
        $user->deleted = true;
        $user->save();
        return $user;
    }
}
