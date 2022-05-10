<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Str;
use ImageKit\ImageKit;
use Config;
use App\Models\Banner;

class BannerController extends Controller
{
    function fetchCarouselBanners() {
        try {
            $banners = Banner::paginate(4);
            if (!count($banners)) return response()->json([
                'status' => 200,
                'message' => 'No data found',
                'results' => []
            ], 200);

            return response()->json([
                'status' => 200,
                'message' => 'Data successfully fetched',
                'results' => $banners
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 500,
                'message' => 'Something Went Wrong',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    function createCarouselBanner(Request $request) {
        try {
            $newFileName = 'BANNER-' . time() . '.' . $request->file->extension();

            $imageKit = new ImageKit(
                config('imagekit.IMAGEKIT_CDN_PUBLIC_KEY'),
                config('imagekit.IMAGEKIT_CDN_PRIVATE_KEY'),
                config('imagekit.IMAGEKIT_CDN_URL')
            );

            try {
                $uploadFile = $imageKit->upload(
                    array(
                        "file" => base64_encode(file_get_contents($request->file('file'))), // required
                        "fileName" => $newFileName, // required
                        'folder' => "/Banners"
                    )
                );
            } catch (\Exception $e) {
                return response()->json([
                    'status' => 500,
                    'message' => 'Something Went Wrong',
                    'error' => $e->getMessage()
                ], 500);
            }

            $newBanner = new Banner([
                'id' => Str::uuid(),
                'image_path' => $uploadFile->success->url,
                'image_name' => $newFileName,
                'file_id' => $uploadFile->success->fileId,
                'alt_image' => $request->alt_image,
                'notes' => $request->notes,
                'description' => $request->description,
                'cta_name' => $request->cta_name,
                'cta_url' => $request->cta_url,
                'title' => $request->title,
                'status' => $request->status,
                'section' => $request->section,
                'position' => $request->position,
                'play_speed' => $request->play_speed,
                'background' => $request->background,
                'slug' => $request->slug
            ]);

            if ($newBanner->save()) {
                return response()->json([
                    'status' => 200,
                    'message' => 'Data successfully created'
                ], 200);
            }

            return response()->json([
                'status' => 400,
                'message' => 'Failed to create banner',
            ], 400);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 500,
                'message' => 'Something Went Wrong',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    function updateCarouselBanner(Request $request) {
        try {
            if (!$request->banner_id && $request->banner_id === '') return response()->json([
                'status' => 400,
                'message' => 'Banner ID is required'
            ], 400);

            $banner = Banner::where('id', $request->banner_id)->first();

            if (!$banner) return response()->json([
                'status' => 400,
                'message' => 'Banner not found'
            ], 400);

            $imageKit = new ImageKit(
                config('imagekit.IMAGEKIT_CDN_PUBLIC_KEY'),
                config('imagekit.IMAGEKIT_CDN_PRIVATE_KEY'),
                config('imagekit.IMAGEKIT_CDN_URL')
            );

            $newFileName = 'BANNER-' . time() . '.' . $request->file->extension();

            try {
                $uploadFile = $imageKit->upload(
                    array(
                        "file" => base64_encode(file_get_contents($request->file('file'))), // required
                        "fileName" => $newFileName, // required
                        'folder' => "/Banners"
                    )
                );
            } catch (\Exception $e) {
                return response()->json([
                    'status' => 500,
                    'message' => 'Something Went Wrong',
                    'error' => $e->getMessage()
                ], 500);
            }

            $imageKit->deleteFile($uploadFile->success->fileId);
            $banner->image_path = $uploadFile->success->url;
            $banner->image_name = $newFileName;
            $banner->file_id = $uploadFile->success->fileId;
            $banner->alt_image = $request->alt_image;
            $banner->notes = $request->notes;
            $banner->description = $request->description;
            $banner->cta_name = $request->cta_name;
            $banner->cta_url = $request->cta_url;
            $banner->title = $request->title;
            $banner->status = $request->status;
            $banner->section = $request->section;
            $banner->position = $request->position;
            $banner->play_speed = $request->play_speed;
            $banner->background = $request->background;
            $banner->slug = $request->slug;
            
            if ($banner->save()) {
                return response()->json([
                    'status' => 200,
                    'message' => 'Data successfully updated'
                ], 200);
            }

            return response()->json([
                'status' => 400,
                'message' => 'Failed to update banner',
            ], 400);

        } catch (\Exception $e) {
            return response()->json([
                'status' => 500,
                'message' => 'Something Went Wrong',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    function deleteCarouselBanner($id) {
        try {
            $pivot = Banner::where('id', $id)->delete();

            return response()->json([
                'status' => 200,
                'message' => 'Delete banner successfull'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 500,
                'message' => 'Something Went Wrong',
                'error' => $e->getMessage()
            ], 500);
        }
    }
}
