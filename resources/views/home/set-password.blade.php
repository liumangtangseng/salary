<!doctype html>
<html  lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="{{URL::asset('assets/css/google.css')}}" rel="stylesheet">
    <title>修改新密码</title>
    <link rel="shortcut icon" type="image/icon" href="{{URL::asset('logo/favicon.ico')}}"/>
    <meta name="_token" content="{{ csrf_token() }}">
    <link rel="stylesheet" href="{{URL::asset('assets/css/font-awesome.min.css')}}">
    <link rel="stylesheet" href="{{URL::asset('assets/css/animate.css')}}">
    <link rel="stylesheet" href="{{URL::asset('assets/css/bootstrap.min.css')}}">
    <link rel="stylesheet" href="{{URL::asset('assets/css/bootsnav.css')}}" >
    <link rel="stylesheet" href="{{URL::asset('assets/css/style.css')}}">
    <link rel="stylesheet" href="{{URL::asset('assets/css/responsive.css')}}">
    <link rel="stylesheet" href="{{URL::asset('css/layer.css')}}">
    <script src="http://cdn.bootcss.com/jquery/1.12.3/jquery.min.js"></script>
    <script src="{{URL::asset('js/layer.js')}}"></script>
</head>
<body>
<section class="signin popup-in">
    <div class="container">
        <div class="sign-content popup-in-content">
            <div class="popup-in-txt">
                <h2>重置新密码</h2>
                <div class="row">
                    @if(!empty($tip))
                        <div class="alert alert-warning" role="alert" style="z-index: 999">
                            　{!!$tip!!}
                        </div>
                    @endif
                    <div class="col-sm-12">
                        <div class="signin-form">
                            <div class="form-group">
                                <label for="signin_form">新密码</label>
                                <input type="text" name="pwd" class="form-control" id="pwd" placeholder="输入新密码">
                            </div>
                            <div class="form-group">
                                <input type="hidden" name="email" class="form-control" id="email" value="<?php if(isset($email)&&!empty($email))  echo $email;?>">
                            </div>
                            <div class="form-group">
                                <input type="hidden" name="condition" class="form-control" id="condition" value="<?php if(isset($tip)&&!empty($tip))  echo 1;else echo 2;?>">
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-sm-12">
                        <div class="signin-footer">
                            <button type="button" class="btn signin_btn" id="submit_pwd">
                                发送
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

</section>


<footer class="footer-copyright">
    <div id="scroll-Top">
        <i class="fa fa-angle-double-up return-to-top" id="scroll-top" data-toggle="tooltip" data-placement="top" title="" data-original-title="Back to Top" aria-hidden="true"></i>
    </div>

</footer>
<script>
    $(function () {
        $("#submit_pwd").click(function () {
            let pwd = $('#pwd').val();
            let email = $('#email').val();
            let condition = $('#condition').val();
            if(pwd.length <= 0 ||condition == 1||email.length<=0)
            {
                layer.open({
                    title: '提示'
                    ,content: '链接过期或者没有输入密码！'
                });
            }else {
                $.ajax({
                    //请求方式
                    type : "POST",
                    header: {'X-CRSF-TOKEN': $('meta[name="_token"]').attr('content')},
                    //请求的媒体类型
                    dataType: 'json',
                    //请求地址
                    url : "{{ url('/save_password') }}",
                    //数据，json字符串
                    data : {'email':email,'pwd':pwd,'condition':condition,'_token':'{{csrf_token()}}'},
                    //请求成功
                    success : function(result) {
                        if(result == 1)
                        {
                            layer.open({
                                title: '提示'
                                ,content: '此链接已失效!'
                            });
                        }else if(result == 2)
                        {
                            layer.open({
                                title: '提示'
                                ,content: '修改成功,请重新登录！'
                            });
                        }
                        else if(result == 3)
                        {
                            layer.open({
                                title: '提示'
                                ,content: '修改失败，请重试！'
                            });
                        }
                        else
                        {
                            layer.open({
                                title: '提示'
                                ,content: '未知错误!'
                            });
                        }
                    },
                    //请求失败，包含具体的错误信息
                    error : function(e){
                        console.log(e);
                        layer.open({
                            title: '提示'
                            ,content: '未知错误，请重试！'
                        });
                    }
                });
            }

        })
    })
</script>
<script src="{{URL::asset('assets/js/jquery.js')}}"></script>
<script src="{{URL::asset('assets/js/modernizr.min.js')}}"></script>
<script src="{{URL::asset('assets/js/bootstrap.min.js')}}"></script>
<script src="{{URL::asset('assets/js/bootsnav.js')}}"></script>
<script src="{{URL::asset('assets/js/jquery.sticky.js')}}"></script>
<script src="{{URL::asset('assets/js/jquery.easing.min.js')}}"></script>
<script src="{{URL::asset('assets/js/custom.js')}}"></script>

</body>

</html>