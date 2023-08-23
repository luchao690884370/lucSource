<?php

namespace plugin\lucSource\app\controller;
use support\Request;
use plugin\lucSource\app\model\SourceCate;

class LucController
{



	public function index(Request $request)
    {
        $SourceCate = SourceCate::select('title as name', 'id as value')->get()->toArray();
		return json(['code' => 0, 'msg' => 'ok','data'=>$SourceCate]);
    }

    //后台源码分类层级数据
    public function admin_source_cate_pid(){
        $data =[['value'=>0,'name'=>'顶级']];
		$SourceCate = SourceCate::select('title as name', 'id as value')->get()->toArray();
		array_push($data, ...$SourceCate);
		return json(['code' => 0, 'msg' => 'ok','data'=>$data]);
	}


}
