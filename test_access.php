<?php
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

$u = User::where('email', 'teststudent@example.com')->first();
if (!$u) {
    $u = User::create([
        'name' => 'Test', 'email' => 'teststudent@example.com', 'password' => bcrypt('password'),
        'role' => 'member', 'status' => 'pending'
    ]);
}
Auth::login($u);

$activePackages = $u->transactions()->where('status', 'approved')->pluck('package_type')->toArray();
echo "Active Packages for new user: " . json_encode($activePackages) . "\n";

$access = [
    'N5' => false,
    'N4' => false,
    'Tokutei Ginou' => false,
];
foreach ($activePackages as $package) {
    $up = strtoupper($package);
    if (str_contains($up, 'N5')) $access['N5'] = true;
    if (str_contains($up, 'N4')) $access['N4'] = true;
    if (str_contains($up, 'TOKUTEI')) $access['Tokutei Ginou'] = true;
}
echo "Access array: " . json_encode($access) . "\n";

