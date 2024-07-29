<?php

namespace App\Domain\Categories\Actions;

use App\Domain\Categories\DTO\CategoryDTO;
use App\Models\Category;
use Spatie\LaravelData\Data;

class CreateCategoryAction extends Data
{
    public static function execute(CategoryDTO $DTO){
        $category = new Category($DTO->toArray());
        $category->save();
        return $category;
    }

}
