<?php

namespace App\Traits;

use Exception;
use Illuminate\Support\Facades\Auth;

trait HasRoles
{

    /**
     * User Types or Level
     */
    public static $blogger = 3;
    public static $supervisor = 2;
    public static $admin = 1;

    /**
     * Retrieve the user type label
     *
     * @return string
     */
    public function getUserTypeLabel(): string
    {
        return self::getUserTypes()[$this->user_type];
    }

    /**
     * Make a user a blogger
     *
     * @return self
     */
    public function makeBlogger(): self
    {
        return $this->changeUserType(self::$blogger);
    }

    /**
     * Make a user a Supervisor
     *
     * @return self
     */
    public function makeSupervisor(): self
    {
        return $this->changeUserType(self::$supervisor);
    }

    /**
     * Make a user an admin
     *
     * @return self
     */
    public function makeAdmin(): self
    {
        return $this->changeUserType(self::$admin);
    }

    /**
     * Is the current user an admin?
     *
     * @return boolean
     */
    public function isAdmin(): bool
    {
        return $this->user_type === self::$admin;
    }

    /**
     * Is the user a supervisor?
     *
     * @return boolean
     */
    public function isSupervisor(): bool
    {
        return $this->user_type === self::$supervisor;
    }

    /**
     * Is the user a Blogger?
     *
     * @return boolean
     */
    public function isBlogger(): bool
    {
        return $this->user_type === self::$blogger;
    }

    /**
     * Has the user permission to?
     *
     * @param string $permission
     * @return boolean
     */
    public function hasPermissionTo(string $permission): bool
    {
        return in_array(
            $permission, 
            $this->getRolePermissions($this->user_type)
        );
    }

    /**
     * Change user type/permission level
     *
     * @param integer $userType
     * @return self
     */
    protected function changeUserType(int $userType): self
    {
        $this->validateUserType($userType);

        $this->user_type = $userType;
        $this->save();

        return $this;
    }

    /**
     * Validate user is an admin to perform an action or
     * throw an exception
     *
     * @return void
     */
    protected function needsToBeAdmin(): void
    {
        if (Auth::check() && Auth::user()->isAdmin()) {
            return;
        }

        throw new Exception('Grant Access required to perform this action');
    }

    /**
     * Get Role Permissions
     *
     * @param integer $userType
     * @return array
     */
    protected function getRolePermissions(int $userType): array
    {
        $this->validateUserType($userType);

        return [
            self::$blogger => $this->getBloggerPermissions(),
            self::$supervisor => $this->getSupervisorPermissions(),
            self::$admin => $this->getAdminPermissions()
        ][$userType];
    }

    /**
     * Validate if a user type is valid.
     * Will returns true if is valid,
     * will throws and exception if invalid.
     *
     * @param integer $userType
     * @return bool
     * @throws Exception if $userType is invalid
     */
    protected function validateUserType(int $userType)
    {
        if (! in_array($userType, array_keys(self::getUserTypes()))) {
            throw new Exception('Invalid user type! Please use a valid user type code');
        }

        return true;
    }

    /**
     * Get Blogger Permissions
     *
     * @return array
     */
    protected function getBloggerPermissions(): array
    {
        return [
            'edit_profile', 'see_my_dashboard', 'search_my_posts',
            'see_my_posts', 'edit_my_posts', 'create_post'
        ];
    }

    /**
     * Get Supervisor Permissions
     *
     * @return array
     */
    protected function getSupervisorPermissions(): array
    {
        return [
            ...$this->getBloggerPermissions(),
            'see_my_bloggers', 'see_my_bloggers_posts', 'see_users',
            'edit_my_bloggers_posts', 'delete_my_bloggers_posts',
        ];
    }

    /**
     * Get Admin Permissions
     *
     * @return array
     */
    protected function getAdminPermissions(): array
    {
        return [
            ...$this->getSupervisorPermissions(),
            'see_all_posts', 'see_user_types', 'create_users', 'edit_users',
            'delete_users', 'filter_user_types', 'assign_user_types', 'delete_user',
            'assign_supervisor', 'see_supervisors', 'see_all_posts', 'delete_any_post',
            'edit_any_post'
        ];
    }

    /**
     * Retrieve the available user types
     *
     * @return array
     */
    public static function getUserTypes(): array
    {
        return [
            self::$blogger => 'Blogger',
            self::$supervisor => 'Supervisor',
            self::$admin => 'Admin',
        ];
    }
}