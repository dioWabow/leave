<?php

namespace App\Classes;

use App\UserTeam;
use App\User;

use Illuminate\Support\Facades\Storage;

class UserHelper
{
    public static function getRoleByUserId($user_id)
    {
        $role_name = '';

        $role = User::getRoleByUserId($user_id);

        if ($role == 'admin') {

            $role_name = '最高管理者';
            return $role_name;

        } elseif($role == 'hr') {

            $role_name = 'HR';
            return $role_name;

        } else {

            if (UserTeam::getTeamIdByUserIdInManagement($user_id)) {

                $role_name = '主管';
                return $role_name;

            } elseif(UserTeam::getTeamIdByUserIdInMiniManagement($user_id)) {

                $role_name = '小主管';
                return $role_name;

            } else {

                $role_name = '員工';
                return $role_name;

            }
        }

    }

}