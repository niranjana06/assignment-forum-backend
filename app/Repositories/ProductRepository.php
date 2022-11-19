<?php

namespace App\Repositories;

use App\Models\Product;
use App\Repositories\Interfaces\ProductRepositoryInterface;
use Illuminate\Database\Eloquent\Model;

class ProductRepository extends BaseRepository implements ProductRepositoryInterface
{
    /**
     * @param Product $model
     */
    public function __construct(Product $model)
    {
        /** @var TYPE_NAME $model */
        parent::__construct($model);
        $this->model = $model;
    }

    public function getById($id)
    {
        return $this->model->where('id', $id)
            //->withCount('postsApproved')
            ->with('postsApproved')
            ->first();
    }
}
