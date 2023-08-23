<?php

namespace plugin\lucSource\app\admin\controller;

use plugin\admin\app\controller\Crud;
use plugin\lucSource\app\model\Slide;
use plugin\lucSource\app\model\SlideInfo;
use support\exception\BusinessException;
use support\Request;
use support\Response;

class SlideController extends Crud
{
    /**
	 * @var Slide
     */
    protected $model = null;

    /**
     * 构造函数
     * @return void
     */
    public function __construct()
    {
        $this->model = new Slide;
    }
    /**
     * 广告列表
     * @return Response
     */
    public function lists()
    {
        return view('slide/lists');
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
        return view('slide/add');
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
        return view('slide/edit');
    }

    /**
     * 删除广告组
     * @param Request $request
     * @return Response
     */
    public function delete(Request $request): Response
    {
        return parent::delete($request);
    }

    /**
     * 广告详情
     * @return Response
     */
    public function infoLists()
    {
        return view('slide/info_lists');
    }

    public function infoSelect(Request $request)
    {

        $this->model = new SlideInfo();
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
     * 插入详情
     * @param Request $request
     * @return Response
     * @throws BusinessException
     */
    public function infoInsert(Request $request): Response
    {
        $this->model = new SlideInfo();
        if ($request->method() === 'POST') {
            return parent::insert($request);
        }
        return view('slide/info_add');
    }

    /**
     * 更新详情
     * @param Request $request
     * @return Response
     * @throws BusinessException
     */
    public function infoUpdate(Request $request): Response
    {
        $this->model = new SlideInfo();
        if ($request->method() === 'POST') {
            return parent::update($request);
        }
        return view('slide/info_edit');
    }

    /**
     * 删除详情
     * @param Request $request
     * @return Response
     */
    public function infoDelete(Request $request): Response
    {
        $this->model = new SlideInfo();
        return parent::delete($request);
    }

}