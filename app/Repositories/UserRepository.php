<?php

namespace App\Repositories;

use App\Models\User;

class UserRepository {
    public function __construct(
        private User $model
    ) {}



    public function getUserByID(int $userID): mixed {
        return $this->model->findOrFail($userID);
    }

}
