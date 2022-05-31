<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;
use App\Services;

class ExistUserName implements Rule
{
    private $id;
    private $userStorageDbService;

    /**
     * Create a new rule instance.
     *
     * @return void
     */
    public function __construct($id = null, $userStorageDbService = new Services\UserStorageDbService)
    {
        $this->id = $id;
        $this->userStorageDbService = $userStorageDbService;
    }

    /**
     * Determine if the validation rule passes.
     *
     * @param  string  $attribute
     * @param  mixed  $value
     * @return bool
     */
    public function passes($attribute, $value)
    {
        return !$this->userStorageDbService->existUserName($value, $this->id);
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'Este usuário já está cadastrado';
    }
}
