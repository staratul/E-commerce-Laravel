<?php

namespace App\Repositories;

use App\Http\Helper;
use Illuminate\Support\Str;
use App\Models\Admin\Category;
use App\Models\Admin\HomeSlider;
use Intervention\Image\Facades\Image;
use Illuminate\Support\Facades\File;
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
            'tags' => Helper::implode($data['tags']),
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

    public function updateHomeslider($data)
    {
        $homeSlider = HomeSlider::where('id', $data['home_slider_id'])->update([
            'category_id' => $data['category_id'],
            'tags' => Helper::implode($data['tags']),
            'title' => $data['title'],
            'offer' => $data['offer'],
            'content' => $data['content']
        ]);

        if(isset($data['image'])) {
            $path = 'uploads/admin/home/';
            $thumbnailPath = 'uploads/admin/home/thumbnail/';

            $homeSliderImage = HomeSlider::where('id', $data['home_slider_id'])->with('image')->first();
            if(isset($homeSliderImage->image)){
                if(File::exists($path.$homeSliderImage->image->name)) {
                    File::delete($path.$homeSliderImage->image->name);
                }
                if(File::exists($thumbnailPath.$homeSliderImage->image->name)) {
                    File::delete($thumbnailPath.$homeSliderImage->image->name);
                }
            }
            $file = $data['image'];
            $image = Image::make($file);
            $thumbnailImage = Image::make($file);
            $image = $image->resize(1920, 728);
            $thumbnailImage = $thumbnailImage->resize(75, 75);
            $imageName = Str::slug($data['title']).time().$file->getClientOriginalName();
            $image->save($path.$imageName);
            $thumbnailImage->save($thumbnailPath.$imageName);
            $homeSliderImage->image()->update([
                'url' => env('APP_URL') . '/' .$path.$imageName,
                'name' => $imageName
            ]);
        }

        return $homeSlider;
    }
}
