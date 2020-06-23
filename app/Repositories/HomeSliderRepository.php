<?php

namespace App\Repositories;

use Illuminate\Support\Str;
use App\Models\Admin\Category;
use App\Models\Admin\HomeSlider;
use Intervention\Image\Facades\Image;
use App\Repositories\Interfaces\HomeSliderRepositoryInterface;

class HomeSliderRepository implements HomeSliderRepositoryInterface
{
    public function getAllSlider()
    {
        return HomeSlider::with('image')->with('category')->latest()->get();
    }

    public function addHomeSlider($data)
    {
        $homeSlider = HomeSlider::create([
            'category_id' => $data['category_id'],
            'tags' => $data['tags'],
            'title' => $data['title'],
            'offer' => $data['offer'],
            'content' => $data['content']
        ]);

        if(isset($data['image'])) {
            $path = 'uploads/admin/home/';
            $thumbnailPath = 'uploads/admin/home/thumbnail/';
            $file = $data['image'];
            $image = Image::make($file);
            $thumbnailImage = Image::make($file);
            $image = $image->resize(1920, 728);
            $thumbnailImage = $thumbnailImage->resize(75, 75);
            $imageName = Str::slug($data['title']).time().$file->getClientOriginalName();
            $image->save($path.$imageName);
            $thumbnailImage->save($thumbnailPath.$imageName);
            $homeSlider->image()->create([
                'url' => env('APP_URL') . '/' .$path.$imageName,
                'name' => $imageName
            ]);
        }

        return $homeSlider;
    }
}
