<?php

namespace App\Admin\Controllers;

use App\Models\Staff;
use Encore\Admin\Controllers\AdminController;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Show;
use Illuminate\Support\Facades\Hash;

class StaffController extends AdminController
{
    /**
     * Title for current resource.
     *
     * @var string
     */
    protected $title = 'Staff';

    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        $grid = new Grid(new Staff());
        $grid->filter(function($filter){
            // 去掉默认的id过滤器
            $filter->disableIdFilter();
            // 在这里添加字段过滤器
            $filter->like('staff_name', '员工姓名');
        });
        $grid->column('id', __('ID'));
        $grid->column('staff_name', __('员工姓名'));
        $grid->column('id_card', __('身份证号'))->display(function($idcard){
            return strlen($idcard)==15?substr_replace($idcard,"****",8,4):(strlen($idcard)==18?substr_replace($idcard,"****",10,4):"身份证位数不正常!");
        });
        $grid->column('dept_id', __('所属部门'))->display(function($dept_id){
            $staff = \DB::table('dep')->where('id', $dept_id)->first();
            if(isset($staff))
                return '<span class="label label-success">'.$staff->dep_name.'</span>';
        });
        $grid->column('email', __('邮箱'));
        $grid->column('mobile', __('手机号码'));
        $grid->column('work_num', __('工号'));
        $grid->column('sex', __('性别'))->using(['M'=>'男','F'=>'女']);
        $grid->column('status', __('状态'))->display(function($status){
            if($status==1)
                return '<span class="label label-success">正常</span>';
            else
                return '<span class="label label-warning">不可用</span>';
        });
        $grid->column('last_ip', __('最后一次登陆IP'));
        $grid->column('last_time', __('最后登陆时间'));
        $grid->column('created_at', __('Created at'));
        $grid->column('updated_at', __('Updated at'));
        return $grid;
    }

    /**
     * Make a show builder.
     *
     * @param mixed $id
     * @return Show
     */
    protected function detail($id)
    {
        $show = new Show(Staff::findOrFail($id));
        $show->field('id', __('ID'));
        $show->field('staff_name', __('员工姓名'));
        $show->field('id_card', __('身份证号'))->display(function($idcard){
            return strlen($idcard)==15?substr_replace($idcard,"****",8,4):(strlen($idcard)==18?substr_replace($idcard,"****",10,4):"身份证位数不正常!");
        });
        $show->field('email', __('邮箱'));
        $show->field('mobile', __('手机号码'));
        $show->field('work_num', __('工号'));
        $show->field('sex', __('性别'))->using(['M'=>'男','F'=>'女']);
        $show->field('status', __('状态'))->display(function($status){
            if($status==1)
                return '<span class="label label-success">正常</span>';
            else
                return '<span class="label label-warning">不可用</span>';
        });
        $show->field('last_ip', __('最后一次登陆IP'));
        $show->field('last_time', __('最后登陆时间'));
        $show->field('created_at', __('Created at'));
        $show->field('updated_at', __('Updated at'));
        return $show;
    }

    /**
     * Make a form builder.
     *
     * @return Form
     */
    protected function form()
    {
        $form = new Form(new Staff());
        $form->text('staff_name', __('员工姓名'))->required();
        $form->text('id_card', __('身份证号'))->rules('required|regex:/^\d+$/', [
            'regex' => 'code必须全部为数字'
        ]);;
        $form->email('email', __('邮箱'));
        $form->mobile('mobile', __('手机号码'));
        $form->password('pwd', __('密码'))->required();
        $form->text('work_num', __('工号'));
        $form->select('dept_id',__('部门'))->options('/admin/api/dept');
        $form->radio('sex', __('性别'))->options(['M'=>'男','F'=>'女'])->default('M');
        $form->select('status',__('状态'))->options([ 0 => '不可用',1 => '正常'])->default(1);
//        $form->saving(function (Form $form) {
//            if ($form->pwd && $form->model()->pwd != $form->pwd) {
//                $form->pwd = Hash::make($form->pwd);
//            }
//        });
        $form->saving(function (Form $form) {
            $form->pwd=Hash::make($form->pwd);
        });

        $form->footer(function ($footer) {
                // 去掉`查看`checkbox
                $footer->disableViewCheck();

                // 去掉`继续编辑`checkbox
                $footer->disableEditingCheck();

                // 去掉`继续创建`checkbox
                $footer->disableCreatingCheck();
        
        });

        return $form;
    }
}
