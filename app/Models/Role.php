<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use \Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Spatie\Permission\Models\Role as OriginalRole;
use Spatie\Permission\Guard;

class Role extends OriginalRole
{
    public $guard_name = 'api';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'guard_name', 'core', 'client_id'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'guard_name', 'pivot.role_id', 'pivot.permission_id'
    ];


    /**
    * @return \Illuminate\Database\Eloquent\Relations\belongsToMany|Collection
    */
    public function rolesPermissions()
    {
        return $this->belongsToMany(Permission::class,'role_has_permissions');
    }

    /**
    * @return \Illuminate\Database\Eloquent\Relations\belongsTo|Client
    */
    public function client()
    {
       return $this->belongsTo(Client::class);
    }


    public static function create(array $attributes = [])
    {
        $attributes['guard_name'] = $attributes['guard_name'] ?? Guard::getDefaultName(static::class);
        return static::query()->create($attributes);
    }

}
