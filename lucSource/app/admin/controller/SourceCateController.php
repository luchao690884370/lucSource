<?php

namespace plugin\lucSource\app\admin\controller;

use plugin\admin\app\controller\Crud;
use plugin\lucSource\app\model\SourceCate;
use support\exception\BusinessException;
use support\Request;
use support\Response;

class SourceCateController extends Crud
{
    /**
	 * @var SourceCate
     */
    protected $model = null;

    /**
     * 构造函数
     * @return void
     */
    public function __construct()
    {
        $this->model = new SourceCate;
    }

    /**
     * 源码分类列表
     * @return Response
     */
    public function lists()
    {
        return view('source-cate/lists');
    }

    /** 插入
     * @param Request $request
     * @return Response
     * @throws BusinessException
     */
    public function insert(Request $request): Response
    {
        if ($request->method() === 'POST') {
            return parent::insert($request);
        }
        return view('source-cate/add');
    }

    /**
     * 更新
     * @param Request $request
     * @return Response
     * @throws BusinessException
     */
    public function update(Request $request): Response
    {
        if ($request->method() === 'POST') {
            return parent::update($request);
        }
        return view('source-cate/edit');
    }

    /**
     * 删除
     * @param Request $request
     * @return Response
     */
    public function delete(Request $request): Response
    {
        return parent::delete($request);
    }
}