<?php

namespace App\Http\Controllers\Ajax;

use App\Http\Controllers\Controller;
use App\Service\UserService;
use Illuminate\Http\Request;

class UserAjaxController extends Controller
{
    public $request;

    public $UserService;

    /**
     * UserAjaxController constructor.
     * @param Request $request
     * @param UserService $UserService
     */
    public function __construct(Request $request, UserService $UserService)
    {
        $this->request = $request;
        $this->UserService = $UserService;
    }

    public function doUserLogin()
    {
        $param['id_card'] = $this->request->input('id_card');
        $param['pwd'] = $this->request->input('pwd');
        $data = $this->UserService->doUserLogin($param);
        return json_encode($data);
    }

}
