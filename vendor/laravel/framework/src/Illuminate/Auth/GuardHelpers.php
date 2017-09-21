<?php

namespace Illuminate\Auth;

use App\UserTeam;

use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;

/**
 * These methods are typically the same across all guards.
 */
trait GuardHelpers
{
    /**
     * The currently authenticated user.
     *
     * @var \Illuminate\Contracts\Auth\Authenticatable
     */
    protected $user;

    /**
     * The user provider implementation.
     *
     * @var \Illuminate\Contracts\Auth\UserProvider
     */
    protected $provider;

    /**
     * Determine if the current user is authenticated.
     *
     * @return \Illuminate\Contracts\Auth\Authenticatable
     *
     * @throws \Illuminate\Auth\AuthenticationException
     */
    public function authenticate()
    {
        if (! is_null($user = $this->user())) {
            return $user;
        }

        throw new AuthenticationException;
    }

    /**
     * Determine if the current user is authenticated.
     *
     * @return bool
     */
    public function check()
    {
        return ! is_null($this->user());
    }

    /**
     * Determine if the current user is a guest.
     *
     * @return bool
     */
    public function guest()
    {
        return ! $this->check();
    }

    /**
     * Get the ID for the currently authenticated user.
     *
     * @return int|null
     */
    public function id()
    {
        if ($this->user()) {
            return $this->user()->getAuthIdentifier();
        }
    }

    /**
     * Set the current user.
     *
     * @param  \Illuminate\Contracts\Auth\Authenticatable  $user
     * @return $this
     */
    public function setUser(AuthenticatableContract $user)
    {
        $this->user = $user;

        return $this;
    }

    /**
     * 取得是否有小主管權限
     *
     * @return array(TeamObj)/false
     */
     public function hasMiniManagement()
     {
         $Teams = false;
         if (!empty($this->user()->getAuthIdentifier())) {

             $Teams = UserTeam::getTeamIdByUserIdInMiniManagement($this->user()->getAuthIdentifier());

         }

         return $Teams;
     }

    /**
    * 取得是否有主管權限
    *
    * @return array(TeamObj)/false
    */
    public function hasManagement()
    {
        $Teams = false;
        if (!empty($this->user()->getAuthIdentifier())) {

            $Teams = UserTeam::getTeamIdByUserIdInManagement($this->user()->getAuthIdentifier());

        }

        return $Teams;
    }

    /**
    * 取得是否有HR權限
    *
    * @return true/false
    */
    public function hasHr()
    {
        if ( $this->user()->role == "hr" || $this->user()->role == "admin" ) {

            return true;

        }else{

            return false;

        }
    }

    /**
    * 取得是否有BOSS權限
    *
    * @return true/false
    */
    public function hasAdmin()
    {
        if ( $this->user()->role == "admin" ) {

            return true;

        }else{

            return false;

        }
    }
}
