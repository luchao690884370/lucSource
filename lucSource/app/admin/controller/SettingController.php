<?php

namespace plugin\lucSource\app\admin\controller;

use plugin\admin\app\controller\Crud;
use plugin\admin\app\model\Option;
use plugin\email\api\Email;
use plugin\email\app\admin\model\Template;
use plugin\lucSource\app\common\Web;
use support\exception\BusinessException;
use support\Request;
use support\Response;

/**
 * 网站设置模块
 */
class SettingController extends Crud
{
    /**
     * 网站设置页面
     * @return Response
     */
    public function index()
    {
        return view('setting/index');
    }

    /**
     * 获取设置
     * @return Response
     */
    public function get(): Response
    {
        $name = Web::SETTING_OPTION_NAME;
        $setting = Option::where('name', $name)->value('value');
        //在wa_options表里面
        $setting = $setting ? json_decode($setting, true) : [
            'web_name' => 'luc源码系统',
            'logo_image' => '/app/lucSource/default/images/logo.png',
            'host_name'=>'',
            'icp'=>'',
            'beian'=>'',
            'seo_keywords'=>'',
            'seo_desc'=>'',
            'tongji_code'=>'',
            'copyright'=>'',
            'company_profile'=>'',
        ];
        return json(['code' => 0, 'msg' => 'ok', 'data' => $setting]);
    }

    /**
     * 更改设置
     * @param Request $request
     * @return Response
     */
    public function save(Request $request): Response
    {
        $data = [
            'web_name' => $request->post('web_name'),//网站标题
            'logo_image' => $request->post('logo_image'),//logo
            'host_name'=>$request->post('host_name'),//网站地址
            'icp'=>$request->post('icp'),//icp备案
            'beian'=>$request->post('beian'),//公安备案
            'seo_keywords'=>$request->post('seo_keywords'),//seo关键字
            'seo_desc'=>$request->post('seo_desc'),//seo描述
            'tongji_code'=>$request->post('tongji_code'),//统计代码
            'copyright'=>$request->post('copyright'),//版权信息
           'company_profile'=>$request->post('company_profile'),//公司介绍
        ];
        $value = json_encode($data);
        $name = Web::SETTING_OPTION_NAME;
        $option = Option::where('name', $name)->first();
        if ($option) {
            Option::where('name', $name)->update(['value' => $value]);
        } else {
            $option = new Option();
            $option->name = $name;
            $option->value = $value;
            $option->save();

        }
        return json(['code' => 0, 'msg' => 'ok']);
    }


}