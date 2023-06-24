<?php

namespace App\Services;

use App\Models\MenuItem;

class MenuItemService
{
    public static function store(array $data): MenuItem{
        $item = MenuItem::create($data);
        if (isset($data['image'])){
            uploadToGallery($item, $data['image'], 'image');
        }
        return $item;
    }

    public static function update(MenuItem $item, array $data): MenuItem{
        $item->update($data);
        if (isset($data['image'])){
            uploadToGallery($item, $data['image'], 'image');
        }
        return $item;
    }
}
