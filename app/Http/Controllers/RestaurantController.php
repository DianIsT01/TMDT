<?php

namespace App\Http\Controllers;

use App\Category;
use App\Restaurant;
use Illuminate\Support\Facades\File;
use Intervention\Image\Facades\Image;

class RestaurantController extends Controller
{
    public function index(){
        return view('dashboard.dashboard');
    }

    public function management(){
        $categories = Category::pluck('id', 'name');

        return view('dashboard.management', compact('categories'));
    }

    public function menu(){
        return view('dashboard.menu');
    }

    public function addCategory(){
        $data = request()->validate([
            'category_id' => 'required|numeric'
        ]);

        if(!auth()->user()->categories->contains($data['category_id'])){
            switch ($data['category_id']){
                case 1:
                    auth()->user()->categories()->detach(['2', '3']);
                    auth()->user()->categories()->attach('1');
                    break;
                case 2:
                    auth()->user()->categories()->detach(['1', '3']);
                    auth()->user()->categories()->attach('2');
                    break;
                case 3:
                    auth()->user()->categories()->detach(['1', '2']);
                    auth()->user()->categories()->attach('3');
                    break;
                default:
                    auth()->user()->categories()->attach($data['category_id']);
            }
        }
        else {
            return redirect()->back()->with('error', 'That category already exists for this restaurant');
        }

        return redirect()->back();
    }

    public function setImage(){
        $currentUser = auth()->user();
        $data  = request()->validate([
            'image' => 'required|image'
        ]);

        if(File::exists(public_path('storage/'.$currentUser->image))
            && $currentUser->image !== 'uploads/default.jpeg'){
            File::delete(public_path('storage/'.$currentUser->image));
        }

        $imagePath = $data['image']->store('uploads', 'public');
        $image = Image::make(public_path("storage/{$imagePath}"))->fit(1200, 1200);
        $image->save();

        Restaurant::findOrFail($currentUser->id)->update([
            'image' => $imagePath
        ]);

        return redirect()->back();
    }
}
