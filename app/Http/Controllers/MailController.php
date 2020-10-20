<?php

namespace App\Http\Controllers;

use App\Models\Staff;
use Illuminate\Http\Request;
use Mail;

class MailController extends Controller
{
    public function send($email)
    {
        $name = '重置密码';
        //$image = Storage::get('images/obama.jpg'); //本地文件
        //$image = 'http://www.baidu.com/sousuo/pic/sdaadar24545ssqq22.jpg';//网上图片
        $token = csrf_token();
        $expiration_time = date('Y-m-d H:i:s',strtotime("+10 minute"));
        $num=Staff::where('email','=',$email)->update(['remember_token'=>$token,'expiration_time'=>$expiration_time]);
        $d = serialize(array('email'=>$email, 'token'=>$token));
        $msg = encrypt($d);
        //$url = route('setPassword',[$msg]);
		$url = env('APP_URL').'/set_password/'.$msg;
        if($num>0){
            Mail::send('mail.mail',['url'=>$url],function($message) use ($email,$name){
                $to = $email;
                $message->to($to)->subject($name);
            });
            if(count(Mail::failures()) < 1){
                return 3;
            }else{
                return 2;
            }
        }else{
            return 4;
        }

    }
}
