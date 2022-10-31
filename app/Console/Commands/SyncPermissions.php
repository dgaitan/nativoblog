<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class SyncPermissions extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'nativo:sync-permissions';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $this->info('Starting permissions sync...');

        // Reset cached roles and permissions
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

        $bloggerPermissions = [
            'edit_profile', 'see_my_dashboard', 'search_my_posts',
            'see_my_posts', 'edit_my_posts', 'create_post'
        ];

        $supervisorPermissions = [
            ...$bloggerPermissions,
            'see_my_bloggers', 'see_my_bloggers_posts',
            'edit_my_bloggers_posts', 'delete_my_bloggers_posts'
        ];

        $adminPermissions = [
            ...$bloggerPermissions,
            'see_all_posts', 'see_user_types', 'see_users', 'create_users', 'edit_users',
            'delete_users', 'filter_user_types', 'assign_user_types', 'delete_user',
            'assign_supervisor', 'see_supervisors', 'see_all_posts', 'delete_any_post',
            'edit_any_post'
        ];

        $permissionsByRole = [
            'blogger' => $bloggerPermissions,
            'admin' => $adminPermissions,
            'supervisor' => $supervisorPermissions,
        ];

        foreach ($permissionsByRole as $role => $permissions) {
            $role = Role::firstOrCreate(['name' => $role]);
            $perms = [];

            foreach ($permissions as $perm) {
                $perms[] = Permission::firstOrCreate([
                    'name' => $perm,
                ]);
            }

            $role->givePermissionTo($perms);
        }

        $this->info('Sync Completed!');

        $roles = Role::all();
        $rolesInfo = [];

        foreach ($roles as $role) {
            $rolesInfo[] = [$role->name, $role->permissions->count()];
        }

        $this->table(
            ['Role Name', 'Total Permissions'],
            $rolesInfo
        );
    }
}
