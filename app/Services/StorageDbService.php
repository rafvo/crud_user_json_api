<?php

namespace App\Services;

use ArrayObject;
use Illuminate\Support\Facades\Storage;
use stdClass;

class StorageDbService
{
    private $path;
    private $tablePk;
    private $list;

    public function __construct($path, $tablePk = 'id')
    {
        $this->path = $path;
        $this->tablePk = $tablePk;
        $this->list = $this->getAll();
    }

    public function getAll()
    {
        try {
            return (array)json_decode(Storage::get($this->path));
        } catch (\Throwable $th) {
            throw $th;
        }
    }

    public function existByAttr($value, $attr = "", $id = null)
    {
        try {
            $list = $this->getAll();

            $exist = false;
            foreach ($list as $e) {
                if($e->{$attr} == $value && $e->{$this->tablePk} != $id) {
                    $exist = true;
                    break;
                }
            }
            return $exist;
        } catch (\Throwable $th) {
            throw $th;
        }
    }

    public function getByKey($key)
    {
        try {
            $list = $this->getAll();

            $item = [];

            foreach ($list as $e) {
                if((string)$e->{$this->tablePk} == (string)$key) {
                   $item[] = $e;
                   break;
                }
            }

            return $item ? $item[0] : [];
        } catch (\Throwable $th) {
            throw $th;
        }
    }

    public function insert($object)
    {
        try {
            $list = $this->getAll();
            $key = $this->uniqueKey();
            $object[$this->tablePk] = $key;
            $list[] = $object;

            if (!$this->updateFile($list))
                throw new \Exception("Erro ao inserir");

            return $this->getByKey($key);
        } catch (\Throwable $th) {
            throw $th;
        }
    }

    public function delete($key)
    {
        try {
            if (!$key)
                throw new \Exception("Chave não informada");

            $list = $this->getAll();
            $items = [];

            foreach ($list as $e) {
                if((string)$e->{$this->tablePk} != (string)$key) {
                    $items[] = $e;
                }
            }

            $this->updateFile($items);

            return $this->getAll();
        } catch (\Throwable $th) {
            throw $th;
        }
    }

    public function update($key, $object)
    {
        try {
            if (!$key)
                throw new \Exception("Chave não informada");

            $list = $this->getAll();
            $items = [];

            foreach ($list as $e) {
                if((string)$e->{$this->tablePk} == (string)$key) {
                    $object[$this->tablePk] = $e->{$this->tablePk};
                   $items[] = $object;
                } else {
                    $items[] = $e;
                }
            }

            $this->updateFile($items);

            return $this->getByKey($key);
        } catch (\Throwable $th) {
            throw $th;
        }
    }

    public function lastKey()
    {
        try {
            $list = $this->getAll();
            $lastIndex = $list && count($list) > 0 ? count($list) : 0;
            return $lastIndex ? $list[$lastIndex-1]->{$this->tablePk} : 0;
        } catch (\Throwable $th) {
            throw $th;
        }
    }

    public function uniqueKey()
    {
        try {
            return $this->lastKey() + 1;
        } catch (\Throwable $th) {
            throw $th;
        }
    }

    private function updateFile($list)
    {
        try {
            if (!$updated = Storage::put($this->path, json_encode($list)))
                throw new \Exception("Erro ao atualizar");

            return $updated;
        } catch (\Throwable $th) {
            throw $th;
        }
    }
}
