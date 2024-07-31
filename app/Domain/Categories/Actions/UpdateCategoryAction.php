<?php

namespace App\Domain\Categories\Actions;

use App\Domain\Categories\DTO\CategoryDTO;
use App\Models\Category;


class UpdateCategoryAction
{
    public static function execute(Category $category,CategoryDTO $DTO){
        $category->update($DTO->toArray());
        return $category;
    }

}
