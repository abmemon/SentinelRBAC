<?php

namespace ABMemon\SentinelRBAC\Console\Commands;

use Illuminate\Console\Command;
use ABMemon\SentinelRBAC\Models\Role;
use ABMemon\SentinelRBAC\Models\Permission;

class RbacSetupCommand extends Command
{
    protected $signature = 'sentinelrbac:setup';
    protected $description = 'Seed roles and permissions';

    public function handle(): void
    {
        $admin = Role::firstOrCreate(['name' => 'admin']);
        $editor = Role::firstOrCreate(['name' => 'editor']);

        $permissions = ['edit-posts', 'delete-posts', 'publish-posts'];
        foreach ($permissions as $perm) {
            $p = Permission::firstOrCreate(['name' => $perm]);
            $admin->permissions()->syncWithoutDetaching([$p->id]);
        }

        $this->info("SentinelRBAC default roles and permissions seeded.");
    }
}
