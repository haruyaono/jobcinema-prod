<?php

namespace App\Job\Profiles\Repositories;

use Jsdecena\Baserepo\BaseRepository;
use App\Job\Users\User;
use App\Job\Profiles\Profile;
use App\Job\Profiles\Repositories\Interfaces\ProfileRepositoryInterface;
use App\Job\Profiles\Exceptions\CreateProfileErrorException;
use App\Job\Profiles\Exceptions\ProfileNotFoundException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Database\QueryException;
use Illuminate\Support\Collection;

class ProfileRepository extends BaseRepository implements ProfileRepositoryInterface
{
    /**
     * ProfileRepository constructor.
     * @param Profile $profile
     */
    public function __construct(Profile $profile)
    {
        parent::__construct($profile);
        $this->model = $profile;
    }

      /**
     * Create the profile
     *
     * @param array $data
     *
     * @return Profile
     * @throws CreateProfileErrorException
     */
    public function createProfile(array $data) : Profile
    {
        try {
            return $this->create($data);
        } catch (QueryException $e) {
            throw new CreateProfileErrorException('プロフィールの作成に失敗しました。');
        }
    }

    /**
     * @param array $data
     * @return bool
     */
    public function updateProfile(array $data): bool
    {
        return $this->update($data);
    }

    /**
     * Soft delete the profile
     * 
     * @return bool
     * @throws \Exception
     */
    public function deleteProfile() : bool
    {
        return $this->delete();
    }

    /**
     * Return the profile
     * 
     * @param int $id
     * 
     * @return Profile
     * @throws ProfileNotFoundException
     */
    public function findProfileById(int $id) : Profile
    {
        try
        {
            return $this->findOneOrFail($id);
        } 
        catch (ModelNotFoundException $e)
        {
            throw new ProfileNotFoundException('プロフィールが見つかりませんでした。');
        }
    }



   
}