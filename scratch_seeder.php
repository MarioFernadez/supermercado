<?php
require 'vendor/autoload.php';
$app = require_once 'bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

\App\Models\MenuItem::truncate();
\App\Models\MenuItem::create(['name'=>'Inicio', 'url'=>'/', 'order'=>1, 'is_active'=>true]);
\App\Models\MenuItem::create(['name'=>'Catálogo', 'url'=>'/buscar', 'order'=>2, 'is_active'=>true]);
\App\Models\MenuItem::create(['name'=>'La empresa', 'url'=>'#', 'order'=>3, 'is_active'=>true]);
\App\Models\MenuItem::create(['name'=>'Contacto', 'url'=>'#', 'order'=>4, 'is_active'=>true]);
echo "Menus created successfully\n";
