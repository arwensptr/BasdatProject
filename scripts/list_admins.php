<?php
require __DIR__ . '/../vendor/autoload.php';
$app = require_once __DIR__ . '/../bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();
$users = \App\Models\User::where('role', 'admin')->get(['id','email','role']);
if ($users->isEmpty()) {
    echo "NO_ADMIN\n";
    exit;
}
foreach ($users as $u) {
    echo $u->id . '|' . $u->email . '|' . $u->role . "\n";
}
