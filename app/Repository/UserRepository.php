<?php
/**
 * Created by PhpStorm.
 * User: chunfei.wang
 * Date: 2020/9/2
 * Time: 17:27
 */

namespace App\Repository;


class UserRepository
{
    /**
     * @param array $data
     * @return \Illuminate\Database\Eloquent\Model|null|object|string|static
     */
    public function getStaffSalaryByTime(array $data)
    {
        $salary = [];
        if(isset($data['staff_id'])&&!empty($data['staff_id']))
        {
            $salary = \DB::table('salary')
                ->where('year',$data['year'])
                ->where('month',$data['month'])
                ->where('staff_id',$data['staff_id'])
                ->first();
        }
        return $salary;
    }

    public function getUserInfo()
    {
        $user_info = \DB::table('staff')
            ->select('id','id_card','pwd','staff_name')
            ->where('status',1)
            ->get()->toArray();
        return $user_info;
    }

}