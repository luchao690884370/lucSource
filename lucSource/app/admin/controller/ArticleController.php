<?php

namespace plugin\lucSource\app\admin\controller;

use plugin\admin\app\controller\Crud;
use plugin\lucSource\app\model\Article;
use support\exception\BusinessException;
use support\Request;
use support\Response;
use support\View;

class ArticleController  extends Crud
{
    /**
     * @var Article
     */
    protected $model = null;

    /**
     * 构造函数
     * @return void
     */
    public function __construct()
    {
        $this->model = new Article;
    }
    /**
     * 文章列表
     * @return Response
     */
    public function lists()
    {
        return view('article/lists');
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

        return view('article/add');
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
        return view('article/edit');
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