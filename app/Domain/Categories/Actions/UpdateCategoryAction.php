<?php

namespace App\Domain\Categories\Actions;

use App\Domain\Categories\DTO\CategoryDTO;
use App\Domain\Users\Users\DTO\UserDTO;
use App\Models\Category;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Spatie\LaravelData\Data;

class UpdateCategoryAction extends Data
{
    public static function execute(Category $category,CategoryDTO $DTO){
        $category->update($DTO->toArray());
        return $category;
    }

}
