<?php
$email = 'admin@zonapos.com';
$user = \App\Models\User::where('email', $email)->first();

if ($user) {
    $user->password = \Illuminate\Support\Facades\Hash::make('admin123');
    $user->save();
    echo "User found. Password reset to 'admin123'.\n";
} else {
    $user = \App\Models\User::create([
        'name' => 'Admin',
        'email' => $email,
        'password' => \Illuminate\Support\Facades\Hash::make('admin123'),
    ]);
    echo "User created with password 'admin123'.\n";
}
