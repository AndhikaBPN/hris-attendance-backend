<?php

namespace App\Services\User;

use App\Repositories\User\UserRepository;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class UserService
{
    protected $userRepository;

    public function __construct(UserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    public function getAllUsers($perPage = 10)
    {
        return $this->userRepository->getAllPaginated($perPage);
    }

    public function getUserById($id)
    {
        return $this->userRepository->findById($id);
    }

    public function createUser(array $data)
    {
        // Generate prefix: YYYYMM
        $prefix = date('Ym');

        // Find latest employee_card_id with this prefix
        $latestUser = User::where('employee_card_id', 'like', $prefix . '%')
            ->orderBy('employee_card_id', 'desc')
            ->first();

        if ($latestUser && preg_match('/^' . $prefix . '(\d{4})$/', $latestUser->employee_card_id, $matches)) {
            $nextNumber = intval($matches[1]) + 1;
        } else {
            $nextNumber = 1;
        }

        // Pad with zeros to 4 digits
        $data['employee_card_id'] = $prefix . str_pad($nextNumber, 4, '0', STR_PAD_LEFT);

        $createdBy = auth()->id();

        if($createdBy == null) {
            $createdBy = 0; // System or admin ID
        }

        $data['created_by'] = $createdBy;
        $data['updated_by'] = $createdBy;
        $data['password'] = Hash::make($data['password']);
        return $this->userRepository->create($data);
    }

    public function updateUser(User $user, array $data, $updatedBy)
    {
        if (isset($data['password'])) {
            $data['password'] = Hash::make($data['password']);
        }
        $data['updated_by'] = $updatedBy;
        return $this->userRepository->update($user, $data);
    }

    public function deleteUser(User $user, $updatedBy)
    {
        $data['updated_by'] = $updatedBy;
        return $this->userRepository->delete($user);
    }
}
