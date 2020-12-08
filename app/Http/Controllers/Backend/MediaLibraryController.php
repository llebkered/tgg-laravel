<?php

namespace App\Http\Controllers\Backend;

use App\Models\Product;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

class MediaLibraryController extends Controller
{
    public function delete($mediaId)
    {
        $media = Media::find($mediaId);
        $file_name = $media->file_name;
        $model = Product::find($media->model_id);
        $model->deleteMedia($media->id);

        return redirect()->back()->with('success_message', $file_name .' has been deleted.');
    }
}

// $media = Media::find($request->input('id'));
// $model = Model::find($media->model_id);
// $model->deleteMedia($media->id);
