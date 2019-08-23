<?php

namespace Ipsum\Admin\app\Console\Commands;

use Illuminate\Console\Command;

class CreateUser extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'ipsum:admin:user
                            {--N|name= : The name of the new user}
                            {--E|email= : The user\'s email address}
                            {--P|password= : User\'s password}
                            {--R|role= : User\'s role }
                            {--encrypt=true : Encrypt user\'s password if it\'s plain text ( true by default )}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create a new user';

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $this->info('Creating a new user');

        if (!$name = $this->option('name')) {
            $name = $this->ask('Name');
        }

        if (!$email = $this->option('email')) {
            $email = $this->ask('Email');
        }

        if (!$password = $this->option('password')) {
            $password = $this->secret('Password');
        }

        if ($this->option('encrypt')) {
            $password = bcrypt($password);
        }

        if (!$role = $this->option('role')) {
            $role = $this->ask('Role');
        }

        $auth = config('ipsum.admin.user_model');
        $user = new $auth();
        $user->name = $name;
        $user->email = $email;
        $user->password = $password;
        $user->role = $role;

        if ($user->save()) {
            $this->info('Successfully created new user');
        } else {
            $this->error('Something went wrong trying to save your user');
        }
    }
}
