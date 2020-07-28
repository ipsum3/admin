<?php

namespace Ipsum\Admin\app\Models;

use Ipsum\Admin\app\Notifications\ResetPassword;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

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
        'name', 'firstname', 'email', 'password', 'role', 'acces',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
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
        return unserialize($this->attributes['acces']);
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
