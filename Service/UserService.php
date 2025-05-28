<?php

declare(strict_types = 1);

require_once __DIR__ . "/../Model/User.php";

require_once __DIR__ . "/../Repository/UserRepository.php";

class UserService {
    private UserRepository $userRepository;

    public function __construct() {
        $this->userRepository = new UserRepository();
    }

    public function createUser(
        string $firstName,
        string $lastName,
        string $email,
        string $password,
        string $salt,
        string $token,
        bool $isVerified = false
    ): User {
        return $this->userRepository->create(
            $firstName,
            $lastName,
            $email,
            $password,
            $salt,
            $token,
            $isVerified
        );
    }

    public function getUser(int $id): User {
        return $this->userRepository->read($id);
    }

    public function updateUser(User $user): void {
        $this->userRepository->update($user);
    }

    public function deleteUser(User $user): void {
        $this->userRepository->delete($user);
    }
}