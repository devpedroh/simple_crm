<?php

namespace App\Repositories\Eloquent;

class AbstractRepository {

    protected mixed $model;

    public function __construct () {
        $this->model = $this->resolveModel();
    }

    protected function resolveModel () {
        return app($this->model);
    }

    public function get (int $id, string $column) {
        return $this->model->find($id)->$column;
    }

    public function find (int $id, string $relation = null) {
        return $this->model->find($id);
    }

    public function findAll (array $relations = []) {

        if (COUNT($relations) > 0) {
            $validRelations = array_filter($relations, function ($relation) {
                return method_exists($this->model, $relation);
            });

            return $this->model->with($validRelations)->get();
        }

        return $this->model->all();
    }

    public function findBy (array $criteria, array $orderBy = null, $limit = null, $offset = null, array $joins = null, array $columns = ['*'], string $relation = null) {
        $model = $this->model;

        $model = $model->select($columns);

        if (count($criteria) == 1) {
            foreach ($criteria as $c) {
                $model = $model->where($c[0], $c[1], $c[2]);
            }
        } elseif (count($criteria) > 1) {
            $model = $model->where($criteria);
        }

        if ($joins) {
            foreach ($joins as $join) {
                if (isset($join['conditions']) && is_array($join['conditions'])) {
                    if (!isset($join['type'])) {
                        $model = $model->join($join['table'], function ($joinQuery) use ($join) {
                            foreach ($join['conditions'] as $condition) {
                                $joinQuery->on($condition[0], $condition[1], $condition[2]);
                            }
                        });
                    } else {
                        $model = $model->leftJoin($join['table'], function ($joinQuery) use ($join) {
                            foreach ($join['conditions'] as $condition) {
                                $joinQuery->on($condition[0], $condition[1], $condition[2]);
                            }
                        });
                    }
                } else {
                    $model = $model->join($join[0], $join[1], $join[2], $join[3], $join[4] ?? 'inner');
                }
            }
        }

        if ($orderBy) {
            if (count($orderBy) == 1) {
                foreach ($orderBy as $order) {
                    $model = $model->orderBy($order[0], $order[1]);
                }
            } elseif (count($orderBy) > 1) {
                $model = $model->orderBy($orderBy[0], $orderBy[1]);
            }
        }

        if ($limit) {
            $model = $model->take((int)$limit);
        }

        if ($offset) {
            $model = $model->skip((int)$offset);
        }

        if ($relation && method_exists($this->model, $relation)) {
            $data = $model->with($relation)->get();
        } else {
            $data = $model->get();
        }

        return $data;
    }

    public function findOneBy (array $criteria, array $joins = null, array $columns = ['*'], string $relation = null) {
        return $this->findBy($criteria, null, null, null, $joins, $columns, $relation)->first();
    }

    public function create(array $data, string $relation = null) {
        $row = $this->model->create($data);

        if ($relation && method_exists($this->model, $relation)) {
            $row->{$relation}()->createMany($data[$relation]);
        }

        return $row;
    }

    public function save(array $data) {
        return $this->model->save($data);
    }

    public function update(array $data, int $id, array $where = null, string $relation = null) {
        if (!empty($where)) {
            $row = $this->model->where($where);
        } else {
            $row = $this->model->findOrFail($id);
        }

        if ($relation && method_exists($this->model, $relation)) {
            $row->{$relation}()->delete();

            $row->{$relation}()->createMany($data[$relation]);
        }

        return $row->update($data);
    }

    public function delete(int $id, array $where = null, string $relation = null) {
        if (!empty($where)) {
            $row = $this->model->where($where);
        } else {
            $row = $this->model->findOrFail($id);
        }

        if ($relation && method_exists($this->model, $relation)) {
            $row->{$relation}()->delete();
        }

        return $row->delete();
    }

}
