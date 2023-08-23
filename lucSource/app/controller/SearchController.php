<?php

namespace plugin\lucSource\app\controller;

use support\Request;
use support\View;
use plugin\lucSource\app\model\SourceCode;
use plugin\lucSource\app\model\Article;
use JasonGrimes\Paginator;
use support\Db;

class SearchController extends Base
{
    public function index(Request $request)
    {

		$param = $request->get();
        $type  = isset($param['type'])?$param['type']:1;//1.源码 2文章
		$keywords  = isset($param['keywords'])?$param['keywords']:'';//关键字搜索
		$page = isset($param['page'])?$param['page']:1;

		$page_size =10;
		$url='/search?type='.$type.'&keywords='.$keywords.'&page=(:num)';
		if($type==1){
			$data=  SourceCode::where('title','like','%'.$keywords.'%')->paginate($page_size, '*', 'page', $page);
		} else{
			$data=  Article::where('title','like','%'.$keywords.'%')->paginate($page_size, '*', 'page', $page);
		}

		$source_count= SourceCode::where('title','like','%'.$keywords.'%')->count();
		$article_count= Article::where('title','like','%'.$keywords.'%')->count();

		$retrun_params['type']=$type;
		$retrun_params['keywords']=$keywords;
		$retrun_params['source_count']=$source_count;
		$retrun_params['article_count']=$article_count;

		$paginator = new Paginator($data->total(), $page_size, $page, $url);
		$paginator->setPreviousText("上一页");
		$paginator->setNextText("下一页");

		$data = json_encode($data);
		$data = json_decode($data, true);


		return view('html/search',['data'=>$data,'retrun_params'=>$retrun_params ,'paginator'  => $paginator]);
    }




}
