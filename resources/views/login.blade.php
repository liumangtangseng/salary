<!doctype html>
<html  lang="en">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1"> 
		<link href="{{URL::asset('assets/css/google.css')}}" rel="stylesheet">
        <title>登陆</title>
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
						<h2>Synbio 登陆</h2>
						<div class="row">
							<div class="col-sm-12">
								<div class="signin-form">
										<div class="form-group">
										    <label for="signin_form">身份证号</label>
										    <input type="text" name="id_card" class="form-control" id="id_card" placeholder="输入身份证号">
										</div>
										<div class="form-group">
											<label for="signin_form">密码</label>
										    <input type="password" name="pwd" class="form-control" id="pwd" placeholder="输入密码">
										</div>
								</div>
							</div>
						</div>
						<div class="row">
							<div class="col-sm-12">
								<div class="signin-password">
									<div class="awesome-checkbox-list">
										<ul class="unstyled centered">
											<li>
											    <a href="{{ route('forgetPassword') }}">忘记密码?</a>
											</li>
										</ul>
									</div>
								</div>
							</div>
						</div>

						<div class="row">
							<div class="col-sm-12">
								<div class="signin-footer">
									<button type="button" class="btn signin_btn" id="submit">
									登陆
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
				$("#submit").click(function () {
					let id_card = $('#id_card').val();
					let pwd =  $('#pwd').val();
					if(id_card.length<=0 || pwd.length<=0)
					{
						layer.open({
							title: '提示'
							,content: '请输入用户名或者密码!'
						});
					}else {
						$.ajax({
							//请求方式
							type : "POST",
							header: {'X-CRSF-TOKEN': $('meta[name="_token"]').attr('content')},
							//请求的媒体类型
							dataType: 'json',
							//请求地址
							url : "{{ route('doLogin') }}",
							//数据，json字符串
							data : {'id_card':id_card,'pwd':pwd,'_token':'{{csrf_token()}}'},
							//请求成功
							success : function(result) {
								if(result == 1)
								{
									layer.open({
										title: '提示'
										,content: '用户不存在或者用户已注销!'
									});
								}else if(result == 3)
								{
									layer.open({
										title: '提示'
										,content: '密码错误!'
									});
								} else if(result == 4)
								{
									layer.open({
										title: '提示'
										,content: '请先修改初始密码在登录!'
									});
								}

								else if(result == 2)
								{
									window.location.href = "{{ route('home') }}"
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
								layer.open({
									title: '提示'
									,content: '登陆失败,请重试!'
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