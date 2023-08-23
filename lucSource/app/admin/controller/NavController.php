<?php

namespace plugin\lucSource\app\admin\controller;

use plugin\admin\app\controller\Crud;

use plugin\lucSource\app\model\Nav;
use plugin\lucSource\app\model\NavGroup;
use support\exception\BusinessException;
use support\Request;
use support\Response;

class NavController extends Crud
{
    /**
     * @var NavGroup
     */
    protected $model = null;

    /**
     * 构造函数
     * @return void
     */
    public function __construct()
    {
        $this->model = new NavGroup;
    }

    /**
     * 导航列表
     * @return Response
     */
    public function lists()
    {
        return view('nav/lists');
    }

    /**
     * 插入
     * @param Request $request
     * @return Response
     * @throws BusinessException
     */
    public function insert(Request $request): Response
    {
        if ($request->method() === 'POST') {
            return parent::insert($request);
        }
        return view('nav/add');
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
        return view('nav/edit');
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


    /**
     * 导航详情列表
     * @return Response
     */
    public function infoLists()
    {
        return view('nav/info_lists');
    }

    public function infoSelect(Request $request)
    {

        $this->model = new Nav();
        $list = parent::select($request);
        $format = $request->get('format', '');
        $body = $list->rawBody();

        if ($format == 'tree') {
            $data = json_decode($body, true);
            if ($data && $data['data']) {
                foreach ($data['data'] as &$item) {
                    if (isset($item['children'])) {
                        $item['children'] = array_values($item['children']);
                    }
                }
            }
            $list->withBody(json_encode($data));
        }
        return $list;
    }

    /**
     * 详情插入
     * @param Request $request
     * @return Response
     * @throws BusinessException
     */
    public function infoInsert(Request $request): Response
    {
        $this->model = new Nav();
        if ($request->method() === 'POST') {
            return parent::insert($request);
        }
        return view('nav/info_add');
    }

    /**
     * 详情更新
     * @param Request $request
     * @return Response
     * @throws BusinessException
     */
    public function infoUpdate(Request $request): Response
    {
        $this->model = new Nav();
        if ($request->method() === 'POST') {
            return parent::update($request);
        }
        return view('nav/info_edit');
    }

    /**
     * 详情删除
     * @param Request $request
     * @return Response
     */
    public function infoDelete(Request $request): Response
    {
        $this->model = new Nav();
        return parent::delete($request);
    }
}