<?php

namespace ABMemon\SentinelRBAC\Console\Commands;

use Illuminate\Console\Command;
use ABMemon\SentinelRBAC\Models\Permission;

class MakePermissionCommand extends Command
{
    protected $signature = 'sentinelrbac:make-permission {name} {--label=}';
    protected $description = 'Create a new permission';

    public function handle(): void
    {
        Permission::firstOrCreate(
            ['name' => $this->argument('name')],
            ['label' => $this->option('label')]
        );

        $this->info("Permission '{$this->argument('name')}' created.");
    }
}
