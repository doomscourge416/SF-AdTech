<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\User;

class AssignAdminRole extends Command
{
    protected $signature = 'user:assign-admin {id}';
    protected $description = 'Назначает роль admin указанному пользователю';

    public function handle()
    {
        $userId = $this->argument('id');
        $user = User::findOrFail($userId);

        $user->role = 'admin';
        $user->save();

        $this->info("Пользователь #{$userId} назначен администратором");
    }
}
