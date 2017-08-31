<?php

namespace App\Http\Controllers\Auth;

use App\User;

use Laravel\Socialite\Facades\Socialite;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Auth\Authenticatable;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Auth\Passwords\CanResetPassword;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Contracts\Auth\CanResetPassword as CanResetPasswordContract;
use Illuminate\Database\Eloquent\SoftDeletes;

class LoginController extends Controller implements AuthenticatableContract
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers, Authenticatable, CanResetPassword;
        
    public function logout()
    {
        Auth::logout();
        return Redirect::to('');
    }

    /**
     * 重導使用者到 Google 認證頁。
     *
     * @return Response
     */
    public function redirectToGoogle()
    {
        return Socialite::driver('google')->redirect();
    }

    /**
     * 從 Google 得到使用者資訊
     *
     * @return Response
     */
    public function handleGoogleCallback()
    {
        $user = Socialite::driver('google')->stateless()->user();

        if ( !empty( $user->email ) ) {
            //待系統設定更新完成改為取config
            if ( !empty($user->user["domain"]) && $user->user["domain"] == "wabow.com" ) {
                $model = new User;
                $model = $model->getUserByEmail($user->email);
                if ( $model ) {
                    $data = [
                        'email' => "$user->email" ,
                        'enter_date' => date( "Y-m-d 00:00:00" ),
                        'status' => 1,
                        'job_seek' => 0,
                    ];
                    $
                    $model = $model->fill($data);
                    $model->save();
                }
                if ( !empty($model->id) && Auth::loginUsingId($model->id) ) {
                    return Redirect::to('index');
                }else{
                    return Redirect::to('root_path')->withErrors(['msg' => '登入失敗']);
                }
            }else{
                //待系統設定更新完成改為公司名稱
                return Redirect::to('root_path')->withErrors(['msg' => '非哇寶國際Email(@wabow.com)']);
            }
        }else{
            return Redirect::to('root_path')->withErrors(['msg' => '登入失敗']);
        }

    }
}
