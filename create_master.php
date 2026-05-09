<?php
$user = \App\Models\User::updateOrCreate(
    ['email' => 'gabriel.sotelo@soteweb.com'],
    [
        'name' => 'Gabriel Sotelo',
        'password' => \Illuminate\Support\Facades\Hash::make('password'),
        'role' => 'admin'
    ]
);
echo "User ID: " . $user->id . "\n";
