<?php
/**
 * Created by PhpStorm.
 * User: HP
 * Date: 13/12/2021
 * Time: 03:19 PM
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Contracts\Pagination\Paginator;
use \Illuminate\Database\Eloquent\Model as EloquentModel;

class Model extends EloquentModel
{
    /**
     * @param $attributes
     * @return \Illuminate\Database\Eloquent\Builder|EloquentModel
     */
    public function createModel($attributes): ?EloquentModel
    {
        return self::query()->create($attributes);
    }

    /**
     * @param $id
     * @return \Illuminate\Database\Eloquent\Builder|EloquentModel|object|null
     */
    public function show($id): ?Model
    {
        return self::query()->where('id', $id)->first();
    }


    /**
     * @param int $id
     * @param array $attributes
     * @return Model|null
     */
    public function updateAndFetch(int $id, array $attributes): ?Model
    {
        if ($this->updateModel($id, $attributes)) {
            return $this->find($id);
        }

        return null;
    }

    /**
     * @param int $id
     * @param array $attributes
     *
     * @return bool
     */
    public function updateModel(int $id, array $attributes): bool
    {
        return $this->query()
            ->where('id', $id)
            ->update($attributes);
    }


    /**
     * @param int $id
     * @return Model|\Illuminate\Database\Eloquent\Builder|\Illuminate\Database\Eloquent\Builder[]|\Illuminate\Database\Eloquent\Collection|EloquentModel|null
     */
    public function find(int $id) : ?Model
    {
        return $this->query()->findOrFail($id);
    }

    /**
     * @param $id
     * @return mixed
     */
    public function deleteModel($id) : bool
    {
        return self::query()->where('id', $id)->delete();
    }

    public function read($perPage) : Paginator
    {
        return $this->query()->paginate($perPage);
    }
}