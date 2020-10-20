@include('layout.header')
<div class="container theme-showcase" role="main">
<div class="jumbotron" style="background: linear-gradient(to right,#2775ff,#7202bb);">
    <h2 style="color: rgba(255,255,255,.9);display: inline-block;">Hi,{{Session::get('staff_name')}}</h2> &nbsp;&nbsp;&nbsp;&nbsp;<span><button type="submit" class="btn btn-warning" style="display: inline-block;margin-bottom: 10px;" onclick="logout()">退出登陆</button></span>
    <p style="color: rgba(255,255,255,.9);">
        {{$say}}
    </p>
</div>
<div class="row" style="margin-bottom: 20px;">
    <div class="col-sm-3"></div>
        <div class="col-sm-6" style="text-align: center;">
            <div>
            <form class="form-inline" action="{{ route('search') }}">
                <div class="form-group">
                <input type="text" class="form-control dateY" placeholder="请输入查询的年份月份" name="date" autocomplete="off" value="@php $time = Session::get('time'); if(isset($time) & !empty($time)) echo  Session::get('time');@endphp">
                </div>
                <button type="submit" class="btn btn-default">
                    查询
                </button>
            </form>
            </div>
        </div>
    <div class="col-sm-3"></div>
</div>
{{--  <div class="row">
    <div class="col-sm-3"></div>
    <div class="col-sm-6" style="margin: 0 auto;">
        <form class="navbar-form navbar-left">
            <div class="form-group">
              <input type="text" placeholder="Email" class="form-control" style="display: inline-block">
            </div>
            <div class="form-group">
              <input type="password" placeholder="Password" class="form-control" style="display: inline-block">
            </div>
            <button type="submit" class="btn btn-success" style="display: inline-block">Sign in</button>
          </form>
    </div>
    <div class="col-sm-3"></div>
</div>  --}}


<div class="row">
    <div class="col-sm-3"></div>
    <div class="col-sm-6">
        <ul class="list-group">
            @if(isset($salary) && !empty($salary))
            <li class="list-group-item active">{{$salary->year.'-'.$salary->month}}</li>
            <li class="list-group-item">基本工资:{{$salary->basic_salary}}</li>
            <li class="list-group-item">岗位工资:{{$salary->post_salary}}</li>
            <li class="list-group-item">保密费用:{{$salary->confidentiality_fee}}</li>
            <li class="list-group-item">补贴:{{$salary->subsidy}}</li>
            <li class="list-group-item">实习/兼职补贴:{{$salary->internship_subsidy}}</li>
            <li class="list-group-item">绩效奖金:{{$salary->performance_bonus}}</li>
            <li class="list-group-item">其他加给:{{$salary->other_additions}}</li>
            <li class="list-group-item">中/夜班补贴:{{$salary->mid_night_shift_subsidy}}</li>
            <li class="list-group-item">加班工资:{{$salary->overtime_pay}}</li>
            <li class="list-group-item">当月应发工资合计:{{$salary->total_payable_salay}}</li>
            <li class="list-group-item">差岗日扣款:{{$salary->post_deduction}}</li>
            <li class="list-group-item">事假扣款:{{$salary->leave_deduction}}</li>
            <li class="list-group-item">病假扣款:{{$salary->sick_leave_deduction}}</li>
            <li class="list-group-item">其他扣款:{{$salary->other_deduction}}</li>
            <li class="list-group-item">当月实际工资合计:{{$salary->total_actual_salary}}</li>
            <li class="list-group-item">缴费基数:{{$salary->expends_base}}</li>
            <li class="list-group-item">个人承担公积金:{{$salary->fund}}</li>
            <li class="list-group-item">个人承担社保:{{$salary->social_security}}</li>
            <li class="list-group-item">扣除社保公积金后工资合计:{{$salary->total_salary_reduce_other}}</li>
            <li class="list-group-item">应缴纳所得税:{{$salary->income_tax}}</li>
            <li class="list-group-item">实发到卡金额:{{$salary->total_salary_to_card}}</li>
          @else
            <li class="list-group-item">暂无数据</li>
          @endif
          
        </ul>
      </div>
      <div class="col-sm-3"></div>
</div>
    <script>
        function logout()
        {
            window.location.href = "{{ route('logout') }}"
        }
        $(function () {
            // $(".datetime").datetimepicker({
            //     format:'YYYY-MM-DD',
            //     timepicker:true
            // });
            $('.dateY').datetimepicker({
                format: 'yyyy-mm',
                weekStart: 1,
                autoclose: true,
                startView: 3,
                minView: 3,
                forceParse: false,
                bootcssVer:2
            });
        });
    </script>

{{--  <footer class="blog-footer">
    <p>
        All Rights Reserved Copyright 2020 苏ICP备14032156号-1
    </p>
    <p>
        苏州泓迅生物科技股份有限公司 热线电话：4000-973-630
    </p>
    <p>
        <a target="_blank" href="http://www.beian.gov.cn/portal/registerSystemInfo?recordcode=32059002001473" style="display:inline-block;text-decoration:none;height:20px;line-height:20px;"><img src="http://www.synbio-tech.com.cn/wp-content/themes/Kornio/images/bajh.png" style="float:left;">苏公网安备 32059002001473号</a>
    </p>
  </footer>  --}}
{{--  <script>
    $(function(){
        $('#table').bootstrapTable({
            //url: "{{ url('/admin/ajax/reports/get_territory')}}",
            pagination: true,
            search: false,
            pageSize: 15,
            pageList: [5, 10, 15, 20],
            showColumns: true,
            searchOnEnterKey: true,
            showRefresh: false,
            striped: true,
            searchAlign: 'left',
            locale: 'en-US',
            sidePagination: "server",
            //queryParams: queryParams,
            columns: [
                [																			
                    {'field': 'id', 'title': 'ID'},
                    {'field': 'year', 'title': '年'},
                    {'field': 'month', 'title': '月'},
                    {'field': 'basic_salary', 'title': '基本工资'},
                    {'field': 'post_salary', 'title': '岗位工资'},
                    {'field': 'confidentiality_fee', 'title': '保密费用'},
                    {'field': 'subsidy', 'title': '补贴'},
                    {'field': 'internship_subsidy', 'title': '实习/兼职补贴'},
                    {'field': 'performance_bonus', 'title': '绩效奖金'},
                    {'field': 'other_additions', 'title': '其他加给'},
                    {'field': 'mid_night_shift_subsidy', 'title': '中/夜班补贴'},
                    {'field': 'overtime_pay', 'title': '加班工资'},
                    {'field': 'total_payable_salay', 'title': '当月应发工资合计'},
                    {'field': 'post_deduction', 'title': '差岗日扣款'},
                    {'field': 'leave_deduction', 'title': '事假扣款'},
                    {'field': 'sick_leave_deduction', 'title': '病假扣款'},
                    {'field': 'other_deduction', 'title': '其他扣款'},
                    {'field': 'total_actual_salary', 'title': '当月实际工资合计'},
                    {'field': 'fund', 'title': '个人承担公积金'},
                    {'field': 'social_security', 'title': '个人承担社保'},
                    {'field': 'total_salary_reduce_other', 'title': '扣除社保公积金后工资合计'},
                    {'field': 'income_tax', 'title': '本月所得税'},
                    {'field': 'total_salary_to_card', 'title': '实发到卡金额'}
                    ]]
        });
    });
</script>  --}}
@include('layout.footer')