<?php

namespace App\Services;

use Illuminate\Support\Facades\Storage;
use App\Services;

class UserStorageDbService
{
    private $storageDbService;

    public function __construct()
    {
        $this->storageDbService = new Services\StorageDbService("user.json", "id");
    }

    public function getAll()
    {
       return $this->storageDbService->getAll();
    }

    public function exist($id = null){
        return $this->storageDbService->existByAttr($id, 'id');
    }

    public function existUserName($user_name, $id = null){
        return $this->storageDbService->existByAttr($user_name, 'user_name', $id);
    }

    public function existEmail($email, $id = null){
        return $this->storageDbService->existByAttr($email, 'email', $id);
    }

    public function getById($key)
    {
        return (object)$this->storageDbService->getByKey($key);
    }

    public function profile($key)
    {
        $object = $this->storageDbService->getByKey($key);

        return $object ? (object)[
            'name' => $object->name,
            'email' => $object->email,
            'user_name' => $object->user_name
        ] : (object)[];
    }


    public function insert($object)
    {
       return $this->storageDbService->insert($object);
    }

    public function delete($key)
    {
        return $this->storageDbService->delete($key);
    }

    public function update($key, $object)
    {
        return $this->storageDbService->update($key, $object);
    }
}
