<?php
namespace plugin\lucSource\app\controller;

use support\Request;
use support\View;
use plugin\lucSource\app\model\SourceCate;
use plugin\lucSource\app\model\SourceCode;
use JasonGrimes\Paginator;
use support\Db;

class SourceController extends Base
{
    public function index(Request $request)
    {
		$param = $request->get();
        $cate_id= isset($param['cate_id'])?$param['cate_id']:'';

		$created_at= isset($param['created_at'])?$param['created_at']:'DESC';//上新
		$read= isset($param['read'])?$param['read']:'';//人气
		$download= isset($param['download'])?$param['download']:'';//下载量

		$page= isset($param['page'])?$param['page']:1;
		$page_size = 12;

		$where =[];
        if($cate_id!=''){
			$where['cate_id']= $cate_id;
			$url='/source?cate_id='.$cate_id.'&page=(:num)';
		} else{
			$url='/source?page=(:num)';
		}
		$source_nav = SourceCate::get()->toArray();

		$read_class='';
		$download_class='';
		$created_at_class='';
		$click_read_class = "DESC";
		$click_download_class = "DESC";
		$click_created_at_class = "DESC";
		if($read!=''){
			$source =  SourceCode::where($where) ->orderBy('read', $read)->paginate($page_size, '*', 'page', $page);
			 $read_class = $read =='DESC'?'on':'on1';
			 $click_read_class =  $read=="DESC"?'ASC':'DESC';
		} else if($download!=''){
			$source =  SourceCode::where($where) ->orderBy('download', $download)->paginate($page_size, '*', 'page', $page);
			$download_class =  $download =='DESC'?'on':'on1';
		    $click_download_class =  $download=="DESC"?'ASC':'DESC';
		} else {
			$source =  SourceCode::where($where) ->orderBy('created_at', $created_at)->paginate($page_size, '*', 'page', $page);
			$created_at_class =  $created_at =='DESC'?'on':'on1';
			$click_created_at_class =  $created_at=="DESC"?'ASC':'DESC';
		}

		$order_data[0]['value']="时间";
		$order_data[0]['name']="created_at";
		$order_data[0]['order']=  $created_at;
		$order_data[0]['class_name']=  $created_at_class;
		$order_data[0]['click_class']=  $click_created_at_class;

		$order_data[1]['value']="人气";
		$order_data[1]['name']="read";
		$order_data[1]['order']=$read;
		$order_data[1]['class_name']=  $read_class;
		$order_data[1]['click_class']=  $click_read_class;

		$order_data[2]['value']="下载";
		$order_data[2]['name']= 'download';
		$order_data[2]['order']="$download";
		$order_data[2]['class_name']=  $download_class;
		$order_data[2]['click_class']=  $click_download_class;

		$paginator = new Paginator($source->total(), $page_size, $page, $url);
		$paginator->setPreviousText("上一页");
		$paginator->setNextText("下一页");

		$source = json_encode($source);
		$source = json_decode($source, true);


		return view('html/source',['source_nav'=>$source_nav,
			                                   'source'=>$source,
											   'cate_id'=>$cate_id,
											   'paginator'  => $paginator,
											   'order_data'=>$order_data]);

    }

    public function info(Request $request)
    {
		$param = $request->get();
        $id = $param['id'];
		$data = SourceCode::where('id',$id)->first();
		$data->read += 1; // 增加阅读量
		$data->save(); // 保存更新后的记录
		$data= $data->toArray();

		$nav = SourceCate::where('id',$data['cate_id'])->first()->toArray();
		return view('html/source_info',['data'=>$data ,'nav'=>$nav ]);
    }



}
