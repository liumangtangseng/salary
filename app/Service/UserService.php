<?php
namespace App\Service;

use App\Models\Staff;
use App\Repository\UserRepository;
use Illuminate\Support\Facades\Hash;

class UserService
{

    public $UserRepository;
    /**
     * UserService constructor.
     * @param UserRepository $getUserRepository
     */
    public function __construct(UserRepository $UserRepository)
    {
        $this->UserRepository = $UserRepository;
    }

    public function getStaffSalary(array $data)
    {
        if(count($data)>0&&isset($data['staff_id'])&&$data['staff_id']>0)
        {
            $data['year'] = (isset($data['year'])&&!empty($data['year']))?$data['year']:date("Y");
            $data['month'] = (isset($data['month'])&&!empty($data['month']))?$data['month']:date("m");
            return $this->UserRepository->getStaffSalaryByTime($data);
        }
        else
        {
            return [];
        }     
    }

    /**
     * @param array $data
     * @return int
     */
    public function doUserLogin(array $data)
    {
        if ($data['pwd'] == '123456')
        {
            return 4;
        }
        $user_info = $this->UserRepository->getUserInfo();
        $key = array_column($user_info,'id_card');
        $value = array_column($user_info,'pwd');
		$name = array_column($user_info,'staff_name');
        $id = array_column($user_info,'id');
        $tmp = array_combine($key,$value);
        $id_tmp = array_combine($key,$id);
		$name_tmp = array_combine($key,$name);
		$id_tmp = array_combine($key,$id);
        if(in_array($data['id_card'],$key))
        {
            if (Hash::check($data['pwd'], $tmp[$data['id_card']]))
            {
                $status = 2;
                session()->put('staff_id', $id_tmp[$data['id_card']]);
				session()->put('staff_name', $name_tmp[$data['id_card']]);
                $ip=$this->getip();
                Staff::where('id_card','=',$data['id_card'])->update(['last_ip'=>$ip,'last_time'=>date("Y-m-d H:i:s")]);
            }
            else
            {
                $status = 3;
            }
        }
        else
        {
            $status = 1;
        }
        return $status;
    }

    public function getip() {
        static $realip;
        if (isset($_SERVER)) {
            if (isset($_SERVER['HTTP_X_FORWARDED_FOR'])) {
                $realip = $_SERVER['HTTP_X_FORWARDED_FOR'];
            } else if (isset($_SERVER['HTTP_CLIENT_IP'])) {
                $realip = $_SERVER['HTTP_CLIENT_IP'];
            } else {
                $realip = $_SERVER['REMOTE_ADDR'];
            }
        } else {
            if (getenv('HTTP_X_FORWARDED_FOR')) {
                $realip = getenv('HTTP_X_FORWARDED_FOR');
            } else if (getenv('HTTP_CLIENT_IP')) {
                $realip = getenv('HTTP_CLIENT_IP');
            } else {
                $realip = getenv('REMOTE_ADDR');
            }
        }
        return $realip;
    }

}