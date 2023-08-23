<?php

namespace plugin\lucSource\app\admin\controller;

use Intervention\Image\ImageManagerStatic as Image;
use support\Request;
use support\Response;

class UploadController extends \plugin\admin\app\controller\UploadController
{

    public function timeImage(Request $request): Response
    {
        $data = $this->base($request, '/upload/img/'.date('Ymd'));
        $realpath = $data['realpath'];
        try {
            $img = Image::make($realpath);
            $max_height = 1170;
            $max_width = 1170;
            $width = $img->width();
            $height = $img->height();
            $ratio = 1;
            if ($height > $max_height || $width > $max_width) {
                $ratio = $width > $height ? $max_width / $width : $max_height / $height;
            }
            $img->resize($width*$ratio, $height*$ratio)->save($realpath);
        } catch (\Exception $e) {
            unlink($realpath);
            return json( [
                'code'  => 500,
                'msg'  => '处理图片发生错误'
            ]);
        }
        $res['code']=0;
        $res['data']=$data['url'];
        $res['msg']='上传成功';
        return json($res);
    }
}
