<?php

namespace plugin\lucSource\app\controller;

use support\Request;
use support\Db;
use support\View;
use plugin\admin\app\model\Option;
use plugin\lucSource\app\model\Links;
use plugin\lucSource\app\model\ArticleCate;
use plugin\lucSource\app\model\Article;
use plugin\lucSource\app\model\SourceCate;
use plugin\lucSource\app\model\SourceCode;
use plugin\lucSource\app\common\Web;

class Base
{
	protected $template = '';
	protected function _initialize() {

	}

	public function __construct() {

		if (!$this->template) {
            $this->template = 'default';
        }

		View::assign('path', request()->path());

		$session= request() ->session();
		$user = session('user');
        if($user){
			View::assign('user', $user);
		}

        $this->initWeb();
        $this->initData();
    }

	protected function initWeb()
    {
        $name = Web::SETTING_OPTION_NAME;
        $setting = Option::where('name', $name)->value('value');
        $setting = $setting ? json_decode($setting, true) : [
            'web_name' => 'luc源码系统',
            'logo_image' => '/app/lucSource/default/images/logo.png',
            'host_name' => '',
            'icp' => '',
            'beian' => '',
            'seo_keywords' => '',
            'seo_desc' => '',
            'tongji_code' => '',
            'copyright' => '',
		    'company_profile'=>'',
        ];
        foreach ($setting as $k => $i) {
            View::assign($k, $i);
        }
    }


	protected function initData()
    {
		$links = Links::get()->toArray();   //友情链接
		View::assign('links', $links);

		//文章分类 文章列表
	     $CmsArticle_data = array();
	     $CmsArticleCate = ArticleCate::get()->toArray();
	     foreach($CmsArticleCate as $key => $val){
		     $CmsArticle = Article::select('id', 'title', 'thumb','read', 'created_at')->where('cate_id',$val['id'])->orderBy('created_at', 'desc')->take(10)->get()->toArray();
		     $vv=array();
		     foreach($CmsArticle as $k => $v){
			     $v['nav_title']=$val['title'];
				 $v['nav_id']=$val['id'];
				 $v['nav_desc']=$val['desc'];
			     $vv[]=$v;
		     }
		     $CmsArticle_data[]=$vv;
	     }
	     View::assign('CmsArticleCate', $CmsArticleCate);
	     View::assign('CmsArticle_data', $CmsArticle_data);


		//源码分类  源码列表
	     $SourceCode_data = array();
	     $SourceCate = SourceCate::get()->toArray();
	     foreach($SourceCate as $key => $val){
		     $SourceCode = SourceCode::select('id', 'title', 'thumb','read', 'created_at')->where('cate_id',$val['id'])->orderBy('created_at', 'asc')->take(12)->get()->toArray();
		     $vv=array();
		     foreach($SourceCode as $k => $v){
			     $v['nav_title']=$val['title'];
				 $v['nav_id']=$val['id'];
				 $v['nav_desc']=$val['desc'];
			     $vv[]=$v;
		     }
		     $SourceCode_data[]=$vv;
	     }
	     View::assign('SourceCate', $SourceCate);
	     View::assign('SourceCode_data', $SourceCode_data);

     }





}
