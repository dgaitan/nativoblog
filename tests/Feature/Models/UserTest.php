<?php

namespace Tests\Feature\Models;

use App\User;
use Exception;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class UserTest extends TestCase
{
    use RefreshDatabase;

    public function test_user_must_be_blogger_by_default(): void
    {
        $user = $this->create_user();

        $this->assertTrue($user->isBlogger());
        $this->assertFalse($user->isSupervisor());
        $this->assertFalse($user->isAdmin());
    }

    public function test_user_is_supervisor(): void
    {
        $user = $this->create_user();
        
        $this->assertTrue($user->isBlogger());
        $this->assertFalse($user->isSupervisor());
        $this->assertFalse($user->isAdmin());

        // NOw we change the user to a supervisor
        $user->makeSupervisor();
        $this->assertFalse($user->isBlogger());
        $this->assertTrue($user->isSupervisor());
        $this->assertFalse($user->isAdmin());
    }

    public function test_user_is_admin(): void
    {
        $user = $this->create_user();
        
        $this->assertTrue($user->isBlogger());
        $this->assertFalse($user->isSupervisor());
        $this->assertFalse($user->isAdmin());

        // NOw we change the user to an admin
        $user->makeAdmin();
        $this->assertFalse($user->isBlogger());
        $this->assertFalse($user->isSupervisor());
        $this->assertTrue($user->isAdmin());
    }

    public function test_user_permissions_if_blogger(): void {
        $user = $this->create_user();

        $this->assertTrue($user->isBlogger());

        // Test true permissions
        $this->assertTrue($user->hasPermissionTo('edit_profile'));
        $this->assertTrue($user->hasPermissionTo('see_my_dashboard'));
        $this->assertTrue($user->hasPermissionTo('search_my_posts'));

        // Test wrong permissions
        $this->assertFalse($user->hasPermissionTo('see_my_bloggers'));
    }

    public function test_user_permissions_if_supervisor(): void {
        $user = $this->create_user();
        $user->makeSupervisor();

        $this->assertTrue($user->isSupervisor());

        // Test true permissions
        $this->assertTrue($user->hasPermissionTo('edit_profile'));
        $this->assertTrue($user->hasPermissionTo('see_my_dashboard'));
        $this->assertTrue($user->hasPermissionTo('search_my_posts'));
        $this->assertTrue($user->hasPermissionTo('see_my_bloggers_posts'));
        $this->assertTrue($user->hasPermissionTo('see_my_bloggers'));

        // Test wrong permissions
        $this->assertFalse($user->hasPermissionTo('assign_user_types'));
    }

    public function test_user_permissions_if_admin(): void {
        $user = $this->create_user();
        $user->makeAdmin();

        $this->assertTrue($user->isAdmin());

        // Test true permissions
        $this->assertTrue($user->hasPermissionTo('edit_profile'));
        $this->assertTrue($user->hasPermissionTo('see_my_dashboard'));
        $this->assertTrue($user->hasPermissionTo('search_my_posts'));
        $this->assertTrue($user->hasPermissionTo('see_my_bloggers_posts'));
        $this->assertTrue($user->hasPermissionTo('see_my_bloggers'));
        $this->assertTrue($user->hasPermissionTo('assign_user_types'));
    }

    protected function create_user(): User
    {
        return User::create([
            'name' => 'John',
            'last_name' => 'Doe',
            'email' => 'john@doe.com',
            'password' => 'secret',
        ]);
    }
}