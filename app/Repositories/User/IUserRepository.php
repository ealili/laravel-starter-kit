<?php

namespace App\Repositories\User;

interface IUserRepository
{
    public function getAll();

    public function getPaginated(?int $page, ?int $pageSize);

    public function findById($id);

    public function create(array $attributes);
}
