<?php
App\Models\Tenant::find('lopez')->run(function () {
    $user = App\Models\User::firstOrCreate(
        ['email' => 'admin@lopez.com'],
        [
            'name' => 'Administrador López',
            'password' => bcrypt('password123')
        ]
    );
    echo "User created: " . $user->email . " / password123\n";
});
