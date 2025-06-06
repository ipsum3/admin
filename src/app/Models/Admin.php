<?php

namespace Ipsum\Admin\app\Models;

use Ipsum\Admin\app\Casts\AsCustomFieldsObject;
use Ipsum\Admin\app\Notifications\ResetPassword;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

/**
 * Ipsum\Admin\app\Models\Admin
 *
 * @property int $id
 * @property string $name
 * @property string|null $firstname
 * @property string $email
 * @property string $password
 * @property string|null $secret_totp
 * @property array $acces
 * @property int|null $role
 * @property string|null $remember_token
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read string $acces_to_string
 * @property-read string $role_to_string
 * @property-read \Illuminate\Notifications\DatabaseNotificationCollection<int, \Illuminate\Notifications\DatabaseNotification> $notifications
 * @property-read int|null $notifications_count
 * @method static \Illuminate\Database\Eloquent\Builder|Admin newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Admin newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Admin query()
 * @mixin \Eloquent
 */
class Admin extends Authenticatable
{
    use Notifiable;

    protected $guard = 'ipsumAdmin';

    const SUPERADMIN = 1;
    const ADMIN = 2;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'firstname', 'email', 'password', 'role', 'acces', 'custom_fields',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    protected $casts = [
        'custom_fields' => AsCustomFieldsObject::class,
    ];



    public function sendPasswordResetNotification($token)
    {
        $this->notify(new ResetPassword($token));
    }


    /**
     * Retourne le rôle de l'utilisateur
     *
     * @return string
     */
    public function getRoleToStringAttribute()
    {
        $roles = config('ipsum.admin.roles');
        return isset($roles[$this->role]) ? $roles[$this->role] : '';
    }
    /**
     * Vérifie le rôle de l'utilisateur
     *
     * @param int $role
     * @return bool
     */
    public function hasRole($role)
    {
        return $this->role == $role;
    }
    /**
     * Vérifi que l'utilisateur est super administrateur
     *
     * @return bool
     */
    public function isSuperAdmin()
    {
        return $this->role == self::SUPERADMIN;
    }
    /**
     * Vérifi que l'utilisateur est administrateur ou super administrateur
     *
     * @return bool
     */
    public function isAdmin()
    {
        return $this->role == self::ADMIN or $this->role == self::SUPERADMIN;
    }
    /**
     * Retourne les zones d'accès de l'utilisateur
     *
     * @return array
     */
    public function getAccesAttribute()
    {
        return !empty($this->attributes['acces']) ? unserialize($this->attributes['acces']) : null;
    }
    public function setAccesAttribute($acces)
    {
        $this->attributes['acces'] = $acces ? serialize($acces) : null;
    }

    /**
     * Retourne les zones d'accès de l'utilisateur
     *
     * @return string
     */
    public function getAccesToStringAttribute()
    {
        return is_array($this->acces) ? implode(', ', $this->acces) : '';
    }

    /**
     * Vérifie l'accés de l'utilisateur
     *
     * @param string $acces
     * @return bool
     */
    public function hasAcces($acces)
    {
        return empty($acces)
            or ($this->acces and in_array($acces, $this->acces))
            or ($this->isAdmin())
            or $this->isSuperAdmin();
    }

    
}
