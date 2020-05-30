<?php

namespace App\Job\Users\Repositories;

use Jsdecena\Baserepo\BaseRepository;
use App\Job\JobItems\JobItem;
use App\Job\Users\User;
use App\Job\Users\Repositories\Interfaces\UserRepositoryInterface;
use App\Job\Users\Exceptions\CreateUserInvalidArgumentException;
use App\Job\Users\Exceptions\UserNotFoundException;
use App\Job\Users\Exceptions\UpdateUserInvalidArgumentException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Database\QueryException;
use Illuminate\Support\Collection as Support;

class UserRepository extends BaseRepository implements UserRepositoryInterface
{
    /**
     * UserRepository constructor.
     * @param User $user
     */
    public function __construct(User $user)
    {
        parent::__construct($user);
        $this->model = $user;
    }



    /**
     * Create the user
     *
     * @param array $params
     * @return User
     * @throws CreateUserInvalidArgumentException
     */
    public function createUser(array $params) : User
    {
        try {
            $data = collect($params)->except('password')->all();

            $user = new User($data);
            if (isset($params['password'])) {
                $user->password = bcrypt($params['password']);
            }

            $user->save();

            return $user;
        } catch (QueryException $e) {
            throw new CreateUserInvalidArgumentException($e->getMessage(), 500, $e);
        }
    }

    /**
     * Update the user
     * 
     * @param array $params
     * 
     * @return bool
     * 
     * @throws UpdateUserInvalidArgumentException
     */
    public function updateUser(array $params) : bool
    {
        try {
            return $this->model->update($params);
        } catch (QueryException $e) {
            throw new UpdateUserInvalidArgumentException($e);
        }
    }

    /**
     * Find the user or fail
     *
     * @param int $id
     *
     * @return User
     * @throws UserNotFoundException
     */
    public function findUserById(int $id) : User
    {
        try {
            return $this->findOneOrFail($id);
        } catch (ModelNotFoundException $e) {
            throw new UserNotFoundException($e);
        }
    }
   
}