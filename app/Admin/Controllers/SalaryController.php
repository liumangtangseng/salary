<?php

namespace App\Admin\Controllers;

use App\Admin\Extensions\Tools\ExcelImport;
use App\Models\Salary;
use App\Models\Staff;
use Encore\Admin\Admin;
use Encore\Admin\Controllers\AdminController;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Media\MediaManager;
use Encore\Admin\Show;
use Encore\Admin\Layout\Content;
use Illuminate\Http\Request;
use Excel;

class SalaryController extends AdminController
{
    /**
     * Title for current resource.
     *
     * @var string
     */
    protected $title = 'Salary';

    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        $grid = new Grid(new Salary());
        $grid->filter(function($filter){
            // 去掉默认的id过滤器
            $filter->disableIdFilter();
            // 在这里添加字段过滤器
            $filter->where(function ($query) {
                $query->whereHas('staff', function ($query) {
                    $query->where('staff_name', 'like', "%{$this->input}%");
                });
            },'员工姓名');

        });

        $grid->tools(function ($tools) {
            $tools->append(new ExcelImport());
        });
        $grid->column('id', __('ID'));
        $grid->column('year', __('年'));
        $grid->column('month', __('月'));
        $grid->column('staff_id', __('姓名'))->display(function ($staff_id){
                $staff = \DB::table('staff')->where('id', $staff_id)->first();
                if(isset($staff))
                    return '<span class="label label-success">'.$staff->staff_name.'</span>';
            }
        );
        $grid->column('basic_salary', __('基本工资'));
        $grid->column('post_salary', __('岗位工资'));
        $grid->column('confidentiality_fee', __('保密费用'));
        $grid->column('subsidy', __('补贴'));
        $grid->column('internship_subsidy', __('实习/兼职补贴'));
        $grid->column('performance_bonus', __('绩效奖金'));
        $grid->column('other_additions', __('其他加给'));
        $grid->column('mid_night_shift_subsidy', __('中/夜班补贴'));
        $grid->column('overtime_pay', __('加班工资'));
        $grid->column('total_payable_salay', __('当月应发工资合计'));
        $grid->column('post_deduction', __('差岗日扣款'));
        $grid->column('leave_deduction', __('事假扣款'));
        $grid->column('sick_leave_deduction', __('病假扣款'));
        $grid->column('other_deduction', __('其他扣款'));
        $grid->column('total_actual_salary', __('当月实际工资合计'));
        $grid->column('expends_base', __('缴费基数'));
        $grid->column('fund', __('个人承担公积金'));
        $grid->column('social_security', __('个人承担社保'));
        $grid->column('total_salary_reduce_other', __('扣除社保公积金后工资合计'));
        $grid->column('income_tax', __('应缴纳所得税'));
        $grid->column('total_salary_to_card', __('实发到卡金额'));
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
        $show = new Show(Salary::findOrFail($id));
        $show->field('id', __('ID'));
        $show->field('year', __('年'));
        $show->field('month', __('月'));
        $show->field('staff_id', __('姓名'))->display(function ($staff_id){
                $staff = \DB::table('staff')->where('id', $staff_id)->first();
                if(isset($staff))
                    return '<span class="label label-success">'.$staff->staff_name.'</span>';
            }
        );
        $show->field('basic_salary', __('基本工资'));
        $show->field('post_salary', __('岗位工资'));
        $show->field('confidentiality_fee', __('保密费用'));
        $show->field('subsidy', __('补贴'));
        $show->field('internship_subsidy', __('实习/兼职补贴'));
        $show->field('performance_bonus', __('绩效奖金'));
        $show->field('other_additions', __('其他加给'));
        $show->field('mid_night_shift_subsidy', __('中/夜班补贴'));
        $show->field('overtime_pay', __('加班工资'));
        $show->field('total_payable_salay', __('当月应发工资合计'));
        $show->field('post_deduction', __('差岗日扣款'));
        $show->field('leave_deduction', __('事假扣款'));
        $show->field('sick_leave_deduction', __('病假扣款'));
        $show->field('other_deduction', __('其他扣款'));
        $show->field('total_actual_salary', __('当月实际工资合计'));
        $show->field('expends_base', __('缴费基数'));
        $show->field('fund', __('个人承担公积金'));
        $show->field('social_security', __('个人承担社保'));
        $show->field('total_salary_reduce_other', __('扣除社保公积金后工资合计'));
        $show->field('income_tax', __('应缴纳所得税'));
        $show->field('total_salary_to_card', __('实发到卡金额'));
        return $show;
    }

    /**
     * Make a form builder.
     *
     * @return Form
     */
    protected function form()
    {
        $form = new Form(new Salary());

        $form->date('year', __('年'))->format('YYYY');
        $form->date('month', __('月'))->format('MM');
        $form->select('staff_id', __('姓名'))->options(function (){
                $staff = \DB::table('staff')->select('id','staff_name')->get()->toArray();
                $options = [];
                if(isset($staff)){
                    $key = array_column($staff,'id');
                    $value = array_column($staff,'staff_name');
                    $options = array_combine($key,$value); 
                }
                return $options;
            }
        );
        $form->currency('basic_salary', __('基本工资'))->symbol('￥');
        $form->currency('post_salary', __('岗位工资'))->symbol('￥');
        $form->currency('confidentiality_fee', __('保密费用'))->symbol('￥');
        $form->currency('subsidy', __('补贴'))->symbol('￥');
        $form->currency('internship_subsidy', __('实习/兼职补贴'))->symbol('￥');
        $form->currency('performance_bonus', __('绩效奖金'))->symbol('￥');
        $form->currency('other_additions', __('其他加给'))->symbol('￥');
        $form->currency('mid_night_shift_subsidy', __('中/夜班补贴'))->symbol('￥');
        $form->currency('overtime_pay', __('加班工资'))->symbol('￥');
        $form->currency('total_payable_salay', __('当月应发工资合计'))->symbol('￥');
        $form->currency('post_deduction', __('差岗日扣款'))->symbol('￥');
        $form->currency('leave_deduction', __('事假扣款'))->symbol('￥');
        $form->currency('sick_leave_deduction', __('病假扣款'))->symbol('￥');
        $form->currency('other_deduction', __('其他扣款'))->symbol('￥');
        $form->currency('total_actual_salary', __('当月实际工资合计'))->symbol('￥');
        $form->currency('expends_base', __('缴费基数'))->symbol('￥');
        $form->currency('fund', __('个人承担公积金'))->symbol('￥');
        $form->currency('social_security', __('个人承担社保'))->symbol('￥');
        $form->currency('total_salary_reduce_other', __('扣除社保公积金后工资合计'))->symbol('￥');
        $form->currency('income_tax', __('应缴纳所得税'))->symbol('￥');
        $form->currency('total_salary_to_card', __('实发到卡金额'))->symbol('￥');
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

    public function addStaffSalary(Content $content)
    {
        $form = new Form(new Salary());
        $form->date('year', __('年'))->format('YYYY');
        $form->date('month', __('月'))->format('MM');
        $form->file('salaly',__('文件上传'))->rules('mimes:doc,docx,xlsx,xls')->removable();
        $form->setAction('/admin/staff-salary/add-salary');
        $form->footer(function ($footer) {
            // 去掉`查看`checkbox
            $footer->disableViewCheck();

            // 去掉`继续编辑`checkbox
            $footer->disableEditingCheck();

            // 去掉`继续创建`checkbox
            $footer->disableCreatingCheck();

        });
        return $content
            ->title('薪酬')
            ->description('添加')
            ->body($form);
    }

    public function doStaffSalary(Request $request)
    {
        $files = $request->file('files');
        $dir = $request->get('dir', '/');
        $manager = new MediaManager($dir,'xlsx');
        try {
            //文件上传服务器
            if ($manager->upload($files)) {
                admin_toastr('导入成功');
            }
            //文件存储路径
            $filePath = "public/uploads/".$files[0]->getClientOriginalName();
            Excel::load($filePath, function($reader) {
                $reader = $reader->getSheet(0);
                $data = $reader->toArray();
                //dd($data);
                unset($data[0]);
                //$data = $reader->all();
                //dd($data);
                //批量存储
                $value=[];
                //print_r($data);exit;
                foreach ($data as $k => $v ){
                    //存储表格每行的值
//                    $value['year']   =$v['year'];
//                    $value['month']   =$v['month'];
//                    $value['staff_id']  = Staff::where('id_card',$value['id_card'])->value('id');
//                    $value['basic_salary'] = $v['basic_salary'];
//                    $value['post_salary']  = $v['post_salary'];
//                    $value['confidentiality_fee'] = $v['confidentiality_fee'];
//                    $value['subsidy'] = $v['subsidy'];
//                    $value['internship_subsidy']   =$v['internship_subsidy'];
//                    $value['performance_bonus']   = $v['performance_bonus'];
//                    $value['other_additions']   = $v['other_additions'];
//                    $value['mid_night_shift_subsidy']   =$v['mid_night_shift_subsidy'];
//                    $value['overtime_pay']   = $v['overtime_pay'];
//                    $value['total_payable_salay']   =$v['total_payable_salay'];
//                    $value['post_deduction']   =$v['post_deduction'];
//                    $value['leave_deduction']   =$v['leave_deduction'];
//                    $value['sick_leave_deduction']   =$v['sick_leave_deduction'];
//                    $value['other_deduction']   = $v['other_deduction'];
//                    $value['total_actual_salary']   =$v['total_actual_salary'];
//                    $value['fund']   =$v['fund'];
//                    $value['social_security']   =$v['social_security'];
//                    $value['total_salary_reduce_other']   =$v['total_salary_reduce_other'];
//                    $value['income_tax']   =$v['income_tax'];
//                    $value['total_salary_to_card']   =$v['total_salary_to_card'];
                    $value['year']  = date('Y');
                    $value['month']   = intval($v[0])<10?'0'.intval($v[0]):intval($v[0]);
                    $value['staff_id']  = Staff::where('staff_name',$v[1])->value('id');
                    $value['basic_salary'] = $v[2];
                    $value['post_salary']  = $v[3];
                    $value['confidentiality_fee'] = $v[4];
                    $value['subsidy'] = $v[5];
                    $value['internship_subsidy']   =$v[6];
                    $value['performance_bonus']   = $v[7];
                    $value['other_additions']   = $v[8];
                    $value['mid_night_shift_subsidy']   =$v[9];
                    $value['overtime_pay']   = $v[10];
                    $value['total_payable_salay']   =$v[11];
                    $value['post_deduction']   =$v[12];
                    $value['leave_deduction']   =$v[13];
                    $value['sick_leave_deduction']   =$v[14];
                    $value['other_deduction']   = $v[15];
                    $value['total_actual_salary']   =$v[16];
                    $value['expends_base']   =$v[17];
                    $value['fund']   =$v[18];
                    $value['social_security']   =$v[19];
                    $value['total_salary_reduce_other']   =$v[20];
                    $value['income_tax']   =$v[21];
                    $value['total_salary_to_card']   =$v[22];
                    //dd($value);
                    Salary::create($value);
                }
            });

        } catch (\Exception $e) {
            admin_toastr($e->getMessage(), 'error');
        }
        return back();
    }
}
