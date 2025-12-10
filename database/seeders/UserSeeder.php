<?php

namespace Database\Seeders;

use App\Helpers\Roles;
use App\Models\User;
use App\Models\UserRole;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        $roles = Roles::asArray();

        foreach ($roles as $index => $role) {
            if ($role === 'user') {
                // user rolidagi 10 ta foydalanuvchi
                for ($i = 1; $i <= 10; $i++) {
                    $phone = '+99894' . str_pad(930000 + $i, 6, '0', STR_PAD_LEFT); // avvalgi bilan to'qnashmaydi
                    $user = User::create([
                        'name' => ucfirst($role) . " $i",
                        'login' => $role . $i,
                        'email' => $role . $i . '@example.com',
                        'password' => Hash::make($role),
                        'status' => 1,
                        'phone' => $phone,
                    ]);

                    UserRole::create([
                        'name' => $role,
                        'role' => $role,
                        'user_id' => $user->id,
                    ]);
                }
            } else {
                // super_admin va admin bitta foydalanuvchi
                $phone = '+99894' . str_pad(920000 + $index, 6, '0', STR_PAD_LEFT);
                $user = User::create([
                    'name' => ucfirst(str_replace('_', ' ', $role)),
                    'login' => $role,
                    'email' => $role . '@example.com',
                    'password' => Hash::make($role),
                    'status' => 1,
                    'phone' => $phone,
                ]);

                UserRole::create([
                    'name' => $role,
                    'role' => $role,
                    'user_id' => $user->id,
                ]);
            }
        }
    }
}
