<?php
namespace plugin\lucSource\app\controller;

use app\controller\BaseController;
use support\Request;
use support\View;
use plugin\lucSource\app\model\ArticleCate;
use plugin\lucSource\app\model\Article;
use JasonGrimes\Paginator;
use support\Db;

class NewsController extends Base
{
    public function index(Request $request)
    {
		$param = $request->get();
        $cate_id= isset($param['cate_id'])?$param['cate_id']:'';
		$page= isset($param['page'])?$param['page']:1;
		$page_size =30;

		$where =[];
        if($cate_id!=''){
			$where['cate_id']= $cate_id;
			$url='/news?cate_id='.$cate_id.'&page=(:num)';
		} else{
			$url='/news?page=(:num)';
		}
		$news_nav = ArticleCate::get()->toArray();
		$news =  Article::where($where)->paginate($page_size, '*', 'page', $page);
		$paginator = new Paginator($news->total(), $page_size, $page, $url);
		$paginator->setPreviousText("上一页");
		$paginator->setNextText("下一页");

		$news = json_encode($news);
		$news = json_decode($news, true);

		return view('html/news',['news_nav'=>$news_nav,'news'=>$news, 'cate_id'=>$cate_id,'paginator'  => $paginator]);
    }

    public function info(Request $request)
    {
		$param = $request->get();
        $id = $param['id'];
		$data = Article::where('id',$id)->first();
		$data->read += 1; // 增加阅读量
		$data->save(); // 保存更新后的记录
		$data= $data->toArray();

		$previousData = Article::where('id', '<', $data['id'])->first();//上一篇
		$nextData = Article::where('id', '>', $data['id'])->first();//下一篇


		$nav = ArticleCate::where('id',$data['cate_id'])->first()->toArray();
		return view('html/news_info',['data'=>$data ,'nav'=>$nav ,'previousData'=>$previousData,'nextData'=>$nextData]);
    }



}
