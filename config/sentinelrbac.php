<?php

return [

    /*
    |--------------------------------------------------------------------------
    | User Model
    |--------------------------------------------------------------------------
    |
    | The Eloquent user model used by your application.
    |
    */
    'user_model' => App\Models\User::class,

    /*
    |--------------------------------------------------------------------------
    | Model Bindings
    |--------------------------------------------------------------------------
    |
    | You may override the default models used internally.
    |
    */
    'models' => [
        'role' => ABMemon\SentinelRBAC\Models\Role::class,
        'permission' => ABMemon\SentinelRBAC\Models\Permission::class,
        'group' => ABMemon\SentinelRBAC\Models\Group::class,
    ],

    /*
    |--------------------------------------------------------------------------
    | Table Names
    |--------------------------------------------------------------------------
    */
    'table_names' => [
        'roles' => 'roles',
        'permissions' => 'permissions',
        'groups' => 'groups',
        'role_user' => 'role_user',
        'permission_user' => 'permission_user',
        'group_user' => 'group_user',
        'permission_role' => 'permission_role',
        'group_permission' => 'group_permission',
    ],

    /*
    |--------------------------------------------------------------------------
    | Cache Settings
    |--------------------------------------------------------------------------
    |
    | These settings control caching of permissions per user.
    |
    */
    'cache' => [
        'enabled' => true,
        'expiration_minutes' => 60,
    ],
];
