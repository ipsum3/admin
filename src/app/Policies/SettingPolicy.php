<?php

namespace Ipsum\Admin\app\Policies;


use Illuminate\Auth\Access\HandlesAuthorization;
use Ipsum\Admin\app\Models\Admin;
use Ipsum\Core\app\Models\Setting;

class SettingPolicy
{
    use HandlesAuthorization;

    public function before(Setting $user, $ability)
    {
        if ($user->isSuperAdmin()) {
            return true;
        }
    }

    public function update(Admin $user, Setting $model)
    {
        return true;
    }

}
