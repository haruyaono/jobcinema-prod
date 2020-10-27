<?php

namespace App\Job\ApplyDetails\Repositories;

use Jsdecena\Baserepo\BaseRepository;
use App\Job\ApplyDetails\ApplyDetail;
use App\Job\ApplyDetails\Repositories\Interfaces\ApplyDetailRepositoryInterface;
use App\Job\ApplyDetails\Exceptions\ApplyDetailInvalidArgumentException;
use Illuminate\Database\QueryException;

class ApplyDetailRepository extends BaseRepository implements ApplyDetailRepositoryInterface
{
    /**
     * ApplyDetailRepository constructor.
     * @param ApplyDetail $applyDetail
     */
    public function __construct(ApplyDetail $applyDetail)
    {
        parent::__construct($applyDetail);
        $this->applyDetail = $applyDetail;
    }

    /**
     * Create the applyDetail
     *
     * @param array $params
     * @return ApplyDetail
     * @throws ApplyDetailInvalidArgumentException
     */
    public function createApplyDetail(array $params): ApplyDetail
    {
        try {

            $applyDetail = $this->create($params);
            return $applyDetail;
        } catch (QueryException $e) {
            throw new ApplyDetailInvalidArgumentException($e->getMessage(), 500, $e);
        }
    }
}
