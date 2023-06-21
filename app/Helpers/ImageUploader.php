<?php

namespace App\Helpers;

use Illuminate\Http\Request;

class ImageUploader
{
    /**
     * @param Request $request
     * @return string
     */
    public static function handleImageRequestData(Request $request): string
    {
        $imageName = 'uploads/images/' . time(). '.' . $request->image->extension();
        $request->image->move(public_path('uploads/images'), $imageName);

        return $imageName;
    }
}
