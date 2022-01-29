<?php

use Carbon\Carbon;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Intervention\Image\Facades\Image;

if (!function_exists('config_path')) {
    /**
     * Get the configuration path.
     *
     * @param string $path
     *
     * @return string
     */
    function config_path($path = '')
    {
        return app()->basePath() . '/config' . ($path ? '/' . $path : $path);
    }
}

if (!function_exists('generate_otp')) {
    /**
     * Generate random OTP
     *
     * @param int $length
     *
     * @return string
     */
    function generate_otp(int $length = 6)
    {
        $pool = '0123456789';

        do {
            $code = substr(str_shuffle(str_repeat($pool, $length)), 0, $length);
        } while (strlen((string)((int)$code)) < $length);

        return $code;
    }
}

if (!function_exists('success')) {
    /**
     * Return successful response from the application.
     *
     * @param string $message
     * @param null $object
     * @param int $status
     *
     * @return JsonResponse
     */
    function success(string $message = '', $object = null, int $status = 200)
    {
        return response()->json(['success' => true, 'message' => $message, 'data' => $object], $status);
    }
}

if (!function_exists('failed')) {
    /**
     * Return failed response from the application.
     *
     * @param string $message
     * @param int $status
     *
     * @return JsonResponse
     */
    function failed(string $message = '', int $status = 500)
    {
        return response()->json(['success' => false, 'message' => $message, 'statusCode' => $status], $status);
    }
}

if (!function_exists('uploadFile')) {
    /**
     * Return failed response from the application.
     *
     *
     * @param \Illuminate\Filesystem\Filesystem $filesystem
     * @param null $folder
     * @return string
     */
    function uploadFile(\Illuminate\Filesystem\Filesystem $filesystem, $folder = null)
    {
        $upload = request()->file('file');
//        return $upload;
        $year = Carbon::now()->year;
        $month = Carbon::now()->month;
        $day = Carbon::now()->day;
        $date = $year . '-' . $month . '-' . $day;
        if ($folder != null)
            $imagePath = "/upload/files/{$folder}/{$date}";
        else
            $imagePath = "/upload/files/{$date}";

        File::makeDirectory(public_path($imagePath), 0755, true, true);
        $filename = $upload->getClientOriginalName();
        if ($filesystem->exists(public_path("{$imagePath}/{$filename}"))) {
            $filename = Carbon::now()->timestamp . "-{$filename}";
        }
        $upload->move(public_path($imagePath), $filename);
        return "{$imagePath}/{$filename}";
    }
}


if (!function_exists('uploadFileBase64')) {
    /**
     * Return failed response from the application.
     *
     *
     * @return string
     */
    function uploadFileBase64()
    {
        $image=request()->input('file');
            $year = Carbon::now()->year;
            $month = Carbon::now()->month;
            $day = Carbon::now()->day;
            $date = $year . '-' . $month . '-' . $day;
            $imagePath = "/upload/files/{$date}";
            File::makeDirectory(public_path($imagePath), 0755, true, true);
            $image = str_replace('data:image/jpg;base64,', '', $image);
            $image = str_replace(' ', '+', $image);
            $filename = Str::random(12) . '.' . 'png';
            if (File::exists(public_path("{$imagePath}/{$filename}"))) {
                $filename = Carbon::now()->timestamp . "-{$filename}";
            }
            File::put(public_path("{$imagePath}/{$filename}"), base64_decode($image));
           return "{$imagePath}/{$filename}";

//        }
    }

    if (!function_exists('resizeImage')) {

        function resizeImage(\Illuminate\Http\Request $request, \Illuminate\Filesystem\Filesystem $filesystem, $attribute)
        {
            $image = request()->file('file');
            $year = Carbon::now()->year;
            $month = Carbon::now()->month;
            $day = Carbon::now()->day;
            $date = $year . '-' . $month . '-' . $day;
            $ext = $image->getClientOriginalExtension();
            $filename = $image->getClientOriginalName() . '_' . $attribute["width"] . 'X' . $attribute["height"] . '.' . $ext;
            $imagePath = "/upload/files/gallery/{$date}";
            File::makeDirectory(public_path($imagePath), 0755, true, true);
            $img = Image::make($image);
            $img->fit((int)$attribute["width"], (int)$attribute["height"]);
            $fileSize = $img->filesize();
            $fileSize /= 1000;
            $img->encode($ext, 90);
            $img->save(public_path("{$imagePath}/{$filename}"));
            $input["extension"] = $ext;
            $input["path"] = "{$imagePath}/{$filename}";
            $input["size"] = round($fileSize, 2) . ' ' . 'KB';
            $input["dimension"] = $attribute["width"] . 'X' . $attribute["height"];
            return $input;
        }
    }

    if (!function_exists('resizeImageBase64')) {

        function resizeImageBase64($imageBase64,$attribute,$filename)
        {
            $image = $imageBase64;
            $year = Carbon::now()->year;
            $month = Carbon::now()->month;
            $day = Carbon::now()->day;
            $date = $year . '-' . $month . '-' . $day;
            $imagePath = "/upload/files/gallery/{$date}";
            File::makeDirectory(public_path($imagePath), 0755, true, true);
            $image = str_replace('data:image/jpg;base64,', '', $image);
            $image = str_replace(' ', '+', $image);
            $imageName= $filename . '_' . $attribute["width"] . 'X' . $attribute["height"] . '.' . 'png';
            if (File::exists(public_path("{$imagePath}/{$imageName}"))) {
                $imageName = Carbon::now()->timestamp . "-{$imageName}";
            }
            $image = base64_decode($image);
            $img = Image::make($imageBase64);
            $img->fit((int)$attribute["width"], (int)$attribute["height"]);
            $fileSize = $img->filesize();
            $fileSize /= 1000;
            $img->encode('png', 90);
            $img->save(public_path("{$imagePath}/{$imageName}"));
            $input["extension"] = 'png';
            $input["path"] = "{$imagePath}/{$imageName}";
            $input["size"] = round($fileSize, 2) . ' ' . 'KB';
            $input["dimension"] = $attribute["width"] . 'X' . $attribute["height"];
            return $input;
        }
    }


    if (!function_exists('filesDirectory')) {

        function filesDirectory()
        {
            return Storage::disk('products')->getDriver()->getAdapter()->getPathPrefix();
        }
    }
    if (!function_exists('filesDirectorySftp')) {

        function filesDirectorySftp()
        {
            return Storage::disk('remote-sftp')->getDriver()->getAdapter()->getPathPrefix();
        }
    }
    if (!function_exists('moveOutFileFromTmp')) {

        function moveOutFileFromTmp($attribute)
        {
            File::makeDirectory(filesDirectory() . $attribute["type"] . 's/' . $attribute["episode_id"], 0755, true, true);
            $file = filesDirectory() . 'tmp/' . $attribute['filename'];

            $ext = pathinfo($file, PATHINFO_EXTENSION);


            $newFileName = date('YmdHis') . uniqid() . '.' . $ext;


            $newFile = filesDirectory() . $attribute['type'] . 's/' . $attribute["episode_id"] . '/' . $newFileName;


            $move = rename($file, $newFile);


            // also move images
//            $image = rtrim($attribute['image'], ',');
//
//            $images = explode(',', $image);
//
//            foreach ($images as $image) {
//                $imagePath = filesDirectory() . '/tmp-images/' . $image;
//
//                $newImage = filesDirectory() . $attribute['type'] . 's/' . 'product_' . $attribute['product_id'] . '/' . 'episode_' . $attribute["episode_id"] . '/' . $image;
//
//                rename($imagePath, $newImage);
//
//                $input["destinationPath"] = filesDirectory() . '/' . $attribute['type'] . 's/' . 'product_' . $attribute['product_id'] . '/' . 'episode_' . $attribute["episode_id"] . '/';
//
//                // save image with different sizes
//                foreach (Config::get('constants.options') as $size) {
//                    $input["width"] = $size;
//                    $input["height"] = $size;
//                    resizeImage($newImage, $input);
//                }
//
//            }

            return $newFileName;
        }

    }

    if (!function_exists('getDetailsOfImage')) {

        function getDetailsOfImage(\Illuminate\Http\Request $request)
        {
            $file = $request->file('file');
            $image["dimension"] = Image::make($file)->width() . '*' . Image::make($file)->height();
            $fileSize = Image::make($file)->filesize();
            $fileSize /= 1000;
            $image["size"] = round($fileSize, 2) . ' ' . 'KB';
            $image["extension"] = $file->getClientOriginalExtension();
            return $image;
        }
    }


}
