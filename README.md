
# 🔐 SentinelRBAC

**SentinelRBAC** is a powerful and flexible Role-Based Access Control (RBAC) package for Laravel 10+ and 12+.  
It provides a clean and scalable way to manage **roles**, **permissions**, and **group-based permissions**, while supporting **Laravel Sanctum** for secure token-based APIs.

---

## ⚙️ Features

- ✅ Role-based access control
- ✅ Permission-based route/view protection
- ✅ Group-based permission assignment
- ✅ Middleware for roles and permissions
- ✅ Blade directives
- ✅ Laravel Sanctum support
- ✅ Artisan commands for roles & permissions
- ✅ Cached permission resolution
- ✅ API-ready (token auth)

---

## 🛠️ Installation

```bash
composer require abmemon/sentinelrbac
```

> 🔁 If using a local or private repo before publishing to Packagist:

Add to your Laravel project’s `composer.json`:

```json
"repositories": [
  {
    "type": "vcs",
    "url": "https://github.com/your-username/SentinelRBAC"
  }
]
```

Then run:

```bash
composer require abmemon/sentinelrbac:dev-master
```

---

## 🧱 Setup

### 1. Publish Config & Migrations

```bash
php artisan vendor:publish --tag=sentinelrbac
php artisan migrate
```

### 2. Add Trait to User Model

```php
use ABMemon\SentinelRBAC\Traits\HasRolesAndPermissions;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable, HasRolesAndPermissions;
}
```

✅ This gives the user:
- // Roles
- `$user->assignRole('admin');`
- `$user->removeRole('editor');`
- `$user->syncRoles(['admin', 'editor']);`
- `$user->hasRole('admin');`
- `$user->hasAnyRole(['admin', 'manager']);`
- `$user->hasAllRoles(['admin', 'manager']);`
- `$user->getRoleNames();` // Collection of role names

- // Permissions
- `$user->givePermissionTo('edit-posts');`
- `$user->revokePermissionTo('delete-posts');`
- `$user->syncPermissions(['edit-posts', 'publish-posts']);`
- `$user->hasPermission('edit-posts');`
- `$user->hasAnyPermission(['edit-posts', 'publish-posts']);`
- `$user->getPermissionNames();` // Collection of permission names

- // Group Support
- `$user->groups(); // Relationship`
- `$user->getAllPermissionsCached(); // Permissions from user + roles + groups`

- // Utility
- `$user->refreshPermissionCache();`

---

## 🧰 Artisan Commands

### 🎭 Create Role
```bash
php artisan rbac:create-role admin
```

### 🛡 Create Permission
```bash
php artisan rbac:create-permission edit-posts
```

### 👤 Assign Role to User
```bash
php artisan rbac:assign-role user@example.com admin
```

---

## 🔐 Protecting Routes

### ✅ With Permission

```php
Route::middleware(['auth:sanctum', 'permission:edit-posts'])->get('/posts/edit', function () {
    return response()->json(['message' => 'Edit page']);
});
```

### ✅ With Role (Optional)

```php
Route::middleware(['auth:sanctum', 'role:admin'])->get('/admin', function () {
    return response()->json(['message' => 'Admin dashboard']);
});
```

---

## 🎨 Blade Directives

```blade
@permission('edit-posts')
    <a href="/posts/edit">Edit Post</a>
@endpermission

@role('admin')
    <p>Welcome, Admin!</p>
@endrole
```

---

## 👥 Group-Based Permissions

Groups are great for managing permissions across departments, teams, or organizations.

### 1. Assign Permission to Group

```php
$group = Group::create(['name' => 'Sales']);
$group->givePermissionTo('view-dashboard');
```

### 2. Add User to Group

```php
$user->groups()->attach($group);
```

✅ The user now inherits the group’s permissions automatically.

---

## 📦 API Usage (Laravel Sanctum)

### 🔐 Token-based Login Route

```php
Route::post('/login', function (Request $request) {
    $user = User::where('email', $request->email)->first();

    if (! $user || ! Hash::check($request->password, $user->password)) {
        return response()->json(['message' => 'Invalid credentials'], 401);
    }

    return response()->json([
        'token' => $user->createToken('api-token')->plainTextToken
    ]);
});
```

### ✅ Authenticated Route

```php
Route::middleware('auth:sanctum')->get('/me', function () {
    return response()->json(auth()->user());
});
```

> ⚠️ Always include `Authorization: Bearer {token}` in your API requests

---

## ⚡ Advanced Tips

- Permissions are cached per user: `user_permissions_{id}`
- Use `cache()->forget("user_permissions_{$user->id}")` to clear manually
- Use roles and groups to **assign** permissions, but always **check with permissions**

---

## 🧪 Testing Setup (Optional Seeder)

You can seed:

```php
// Create role and permission
$admin = Role::create(['name' => 'admin']);
$edit = Permission::create(['name' => 'edit-posts']);
$admin->givePermissionTo($edit);

// Assign to user
$user = User::first();
$user->assignRole('admin');
```

---

## 🧩 Configuration File (`config/sentinelrbac.php`)

This file is published with:

```bash
php artisan vendor:publish --tag=sentinelrbac
```

You can customize model paths, permission table names, etc.

---

## 📜 License

MIT License — free to use, extend, and modify.

---

## 👤 Author

**Ahmed Bakhsh Memon**  
🌐 [abmemon.com](https://abmemon.com)  
🐙 [GitHub](https://github.com/abmemon)

---

## 🙌 Contributions

Pull requests, issues, suggestions, and stars are all welcome.

---

## ⭐ Example API Flow (Postman)

| Endpoint                               | Method | Auth | Description                     |
|----------------------------------------|--------|------|---------------------------------|
| `/api/login`                           | POST   | ❌   | Get Sanctum token               |
| `/api/me`                              | GET    | ✅   | Return current user             |
| `/api/rbac/users/1/roles/sync`         | POST   | ✅   | Sync roles to user              |
| `/api/rbac/users/1/permissions/sync`   | POST   | ✅   | Sync direct permissions to user |
| `/api/rbac/groups/1/users/sync`        | POST   | ✅   | Sync users to group             |
| `/api/rbac/groups/1/permissions/sync`  | POST   | ✅   | Sync permissions to group       |

---

Enjoy clean and scalable access control with **SentinelRBAC** 🛡️🔥
