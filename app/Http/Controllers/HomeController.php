<?php

namespace App\Http\Controllers;

use App\Models\Staff;
use Illuminate\Http\Request;

use App\Service\UserService;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;

class HomeController extends Controller
{

    public function __construct(Request $request, UserService $userService)
    {
        $this->request = $request;
        $this->userService = $userService;
    }

    public function login()
    {
        return view('login');
    }

    public function doUserLogout()
    {
        Session::flush();
        return redirect('/login');
    }

    public function forgetPassword()
    {
        return view('home.forget-password');
    }

    public function index()
    {
        $say = $this->getSay();
        $year = date("Y");
        $month = date("m");
        session()->put('time', $year.'-'.$month);
        $salary = $this->userService->getStaffSalary(['staff_id'=>1,'year'=>$year,'month'=>$month]);
        return view('home.index',['say'=>$say,'salary'=>$salary]);
    }

    public function searchSalary()
    {
        //session()->put('staff_id', 1);
        $say = $this->getSay();
        $staff_id = session()->get('staff_id');
        //session()->put('key', $value);
        $year = date("Y");
        $month = date("m");
        $params = $this->request->get('date');
        if(!isset($params)||empty($params))
        {
            $params = $year.'-'.$month;
        }
        session()->put('time', $params);
        if(isset($staff_id)&&$staff_id>0)
        {
            $arr = explode("-",$params);
            $salary = $this->userService->getStaffSalary(['staff_id'=>$staff_id,'year'=>$arr[0],'month'=>$arr[1]]);
            return view('home.index',['say'=>$say,'salary'=>$salary]);
        }
        else
        {
            return redirect('/login');
        }
    }

    public function getSay()
    {
        //$say = config('params.classic_sayings.'.rand(0,32));
		$say = "您的个人薪资信息是公司与个人劳动契约之机密性信息，任何人不得打听，议论他人薪资，亦不得将个人薪资所得告诉他人。";
        return $say;
    }

    public function submitNewEmail()
    {
        if(!captcha_check($this->request->input('captcha'))){
            $data = 1;
            return json_encode($data);
        }else{
            $email = $this->request->input('email');
            $mail = new MailController();
            $data = $mail->send($email);
            return json_encode($data);
        }
    }

    public function setPassword($token = '')
    {
        $email = '';
        if(!empty($token)){
            $param = unserialize(decrypt($token));
            if(isset($param['email']))
                $email = $param['email'];
            $staff = Staff::where('email','=',$param['email'])
                ->where('remember_token','=',$param['token'])
                ->where('expiration_time','>=',date("Y-m-d H:i:s"))
                ->first();
            if($staff)
                $tip = '';
            else
                $tip = "<span>此链接已过期,请<a href='".route('forgetPassword')."'>点击</a>重新申请</span>";
        }else{
            $tip = "<span>此链接已过期,请<a href='".route('forgetPassword')."'>点击</a>重新申请</span>";
        }
        return view('home.set-password',['tip'=>$tip,'email'=>$email]);
    }

    public function saveNewPassword()
    {
        if(($this->request->input('condition'))==1){
            $data = 1;
        }else{
            $email = $this->request->input('email');
            $pwd = Hash::make($this->request->input('pwd'));
            $num=Staff::where('email','=',$email)->update(['pwd'=>$pwd]);
            if($num>0) {
                $data = 2;
            } else{
                $data = 3;
            }
        }
        return json_encode($data);
    }
}
