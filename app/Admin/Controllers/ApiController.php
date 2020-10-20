<?php

namespace App\Admin\Controllers;

use App\models\Dep;
use Encore\Admin\Controllers\AdminController;

class ApiController extends AdminController
{
    public function getDept()
    {
        $dept = \DB::table('dep')->select('id','dep_name as text')->get();

        return response()->json($dept);
    }
}
