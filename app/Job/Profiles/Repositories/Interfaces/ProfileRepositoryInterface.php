<?php

namespace App\Job\Profiles\Repositories\Interfaces;

use Jsdecena\Baserepo\BaseRepositoryInterface;
use App\Job\Profiles\Profile;
use App\Job\Users\User;
use Illuminate\Support\Collection;

interface ProfileRepositoryInterface extends BaseRepositoryInterface
{  

    public function createProfile(array $data) : Profile;

    public function updateProfile(array $data): bool;

    public function deleteProfile() : bool;

    public function findProfileById(int $id) : Profile;

    public function getResume() : Profile;
}