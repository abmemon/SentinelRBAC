<?php

namespace ABMemon\SentinelRBAC\Console\Commands;

use Illuminate\Console\Command;
use ABMemon\SentinelRBAC\Models\Role;

class MakeRoleCommand extends Command
{
    protected $signature = 'sentinelrbac:make-role {name} {--label=}';
    protected $description = 'Create a new role';

    public function handle(): void
    {
        Role::firstOrCreate(
            ['name' => $this->argument('name')],
            ['label' => $this->option('label')]
        );

        $this->info("Role '{$this->argument('name')}' created.");
    }
}
