<?php

namespace App\Repositories\User;

use App\Exceptions\User\UserNotFoundException;
use App\Models\Role;
use App\Models\User;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

class UserRepository implements IUserRepository
{
    /** @var string */
    private string $userClass;

    private int $paginationLength;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->userClass = User::class;
        $this->paginationLength = config('app.pagination_length');
    }

    /**
     * Get an instance of the User class.
     *
     * @return User
     */
    public function getUserClass(): User
    {
        return app($this->userClass);
    }

    /**
     * @param int|null $page
     * @param int|null $pageSize
     * @return mixed
     */
    public function getPaginated(?int $page, ?int $pageSize)
    {
        $pageSize = $pageSize ?? $this->paginationLength;

        return $this->getUserClass()->paginate($pageSize ?? $this->paginationLength);
    }

    /**
     * @return Collection
     */
    public function getAll(): Collection
    {
        return $this->getUserClass()->all();
    }

    /**
     * @param $id
     * @return Builder|Builder[]|Collection|Model|null
     * @throws UserNotFoundException
     */
    public function findById($id)
    {
        $user = $this->getUserClass()->query()->find($id);

        if (!$user) {
            throw UserNotFoundException::withId($id);
        }

        return $user;
    }

    public function create(array $attributes)
    {
        $attributes['role_id'] = Role::IS_USER;

        return $this->getUserClass()->query()->create($attributes);
    }
}
