<?php

namespace Illuminate\Contracts\Auth;

interface Guard
{
    /**
     * Determine if the current user is authenticated.
     *
     * @return bool
     */
    public function check();

    /**
     * Determine if the current user is a guest.
     *
     * @return bool
     */
    public function guest();

    /**
     * Get the currently authenticated user.
     *
     * @return \Illuminate\Contracts\Auth\Authenticatable|null
     */
    public function user();

    /**
     * Get the ID for the currently authenticated user.
     *
     * @return int|null
     */
    public function id();

    /**
     * Validate a user's credentials.
     *
     * @param  array  $credentials
     * @return bool
     */
    public function validate(array $credentials = []);

    /**
     * Set the current user.
     *
     * @param  \Illuminate\Contracts\Auth\Authenticatable  $user
     * @return void
     */
    public function setUser(Authenticatable $user);

    /**
     * 取得是否有小主管權限
     *
     * @return array(TeamId)/false
     */
    public function hasMiniManagement();

    /**
     * 取得是否有主管權限
     *
     * @return array(TeamId)/false
     */
    public function hasManagement();

    /**
     * 取得是否有HR權限
     *
     * @return true/false
     */
    public function hasHr();

    /**
     * 取得是否有BOSS權限
     *
     * @return true/false
     */
    public function hasAdmin();
}
