<?php

namespace App\Http\Controllers\Index;

use Illuminate\Http\Request;
use App\Http\Requests;
use Illuminate\Support\Facades\Storage;
use App\Http\Controllers\Controller;

class UploadController extends Controller
{
    /**
     * 上传图片
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(Request $request)
    {
        $result = [
            'errno' => -1,
            'data' => []
        ];
        if (!$request->hasFile('file')) {
            return response()->json($result, 422);
        }
        $file = $request->file('file');
        if (!$file->isValid()) {
            return response()->json($result, 422);
        }
        $prefix = $request->input('type', 'uploads');
  
        $path = $file->store($prefix, 'uploads');

        if (!empty($path)) {
            $data = [
                'errno' => 0,
                'data' => [
                    asset($path)
                ]
            ];
            return response()->json($data);
        }
        return response()->json($result, 422);
    }

    /**
     * 删除图片
     * @param Request $request
     */
    public function delete(Request $request)
    {
        $pic = $request->input('name');
        if(file_exists(public_path($pic))) {
            unlink(public_path($pic));
        }
        return  response()->json([
            'status'=>1,
            'msg' => '',
            'data' => [],
        ]);
    }

    public function uploadPic(Request $request)
    {
        $file = $request->file('file');
        $size = getimagesize($file->path());
        $width = $size[0];
        $height = $size[1];
        switch ($size['mime']) {
            case 'image/jpeg':
                $src = imagecreatefromjpeg($file->path());
                break;
            case 'image/png':
                $src = imagecreatefrompng($file->path());
                break;
            default:
                $src = imagecreatefromjpeg($file->path());
                break;
        }
        $max = 400;
        if ($width > $height) {
            $width = $max;
            $height *= $max / $size[0];
        } else {
            $height = $max;
            $width *= $max / $size[1];
        }
        $image = imagecreatetruecolor(round($width, 2), round($height, 2));
        imagecopyresampled($image, $src, 0, 0, 0, 0, $width, $height, $size[0], $size[1]);
        header('content-type:image/jpeg');
        $prefix = $request->input('type', 'avatar');

        $path = '/' . $prefix . '/' . uniqid() . '.jpg';
        $filename = public_path() . $path;

        imagejpeg($image, $filename);
        $filename = asset($path);
        imagedestroy($image);
        //把图片地址存到session中
        $request->session()->put('crop_image', $path);
        $request->session()->put('crop_image_prefix', $prefix);
        $data = [
            'status' => true,
            'name' => $filename,
            'msg' => '',
        ];
        return response()->json($data);
    }

    public function crop(Request $request)
    {
        $result = [
            'status' => false,
            'name' => '',
            'msg' => '上传失败',
        ];
        //得到图片地址
        $filename = $request->session()->get('crop_image');

        $prefix = $request->session()->get('crop_image_prefix');
        $data = $this->cropImage($prefix, public_path() . $filename, $request->input('x1'), $request->input('y1'), $request->input('w'), $request->input('h'));
        $bucket = config('oss.bucket', 'xiaogukeji');
        OSS::publicUpload($bucket, $data['name'], $data['path']);
        //把本地文件删除掉
        unlink($data['path']);
        $pic = config('oss.piclink') . '/' . $data['name'];
        if (!empty($result)) {
            $data = [
                'status' => true,
                'name' => $pic,
                'msg' => '',
            ];
            return response()->json($data);
        }
        return response()->json($result, 422);
    }

    protected function cropImage($prefix, $path, $x, $y, $w, $h)
    {
        $size = getimagesize($path);
        $width = $size[0];
        $height = $size[1];
        $src = imagecreatefromjpeg($path);
        $image = imagecreatetruecolor($w, $h);
//        imagecopyresampled($image, $src, 0, 0, $x, $y, $width, $height, $w, $h);
        imagecopy($image,$src,0,0,$x,$y,$w,$h);
        header('content-type:image/jpeg');
        //从字符串是得到prefix
        $newPath = '/' . $prefix . '/' . uniqid() . '.jpg';
        $filename = public_path() . $newPath;
        imagejpeg($image, $filename);
        imagedestroy($image);
        //把以前的图片删了
        unlink($path);
        return [
            'path' => $filename,
            'name' => 'public' . $newPath,
        ];
    }
}