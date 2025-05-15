<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ImageUploadController extends Controller
{
    public function upload(Request $request)
    {
        $image = $request->file('image');

        // Validate the image
        $this->validate($request, [
            'image' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        // Store the image
        $imageName = time().'.'.$image->getClientOriginalExtension();
        Storage::disk('public')->put($imageName, file_get_contents($image));

        // Return the image URL
        return response()->json(['image_url' => asset('storage/'.$imageName)]);
    }

}
