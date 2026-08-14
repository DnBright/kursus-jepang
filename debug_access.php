<?php
$user = App\Models\User::where('email', 'coba2@gmail.com')->first();
if (!$user) {
    echo "User not found\n";
    exit;
}
$activePackages = $user->transactions()->where('status', 'approved')->pluck('package_type')->toArray();
echo "Active Packages for " . $user->email . ":\n";
print_r($activePackages);

$courses = App\Models\Course::all();
echo "\nChecking Courses:\n";
foreach ($courses as $c) {
    $hasAccess = false;
    foreach ($activePackages as $ap) {
        if (
            (!empty($c->title) && stripos($c->title, $ap) !== false) || 
            (!empty($c->level) && stripos($c->level, $ap) !== false) || 
            (!empty($c->level) && stripos($ap, $c->level) !== false)
        ) {
            $hasAccess = true;
            break;
        }
    }
    echo "Course [" . $c->id . "] Title: '" . $c->title . "' Level: '" . $c->level . "' -> Access: " . ($hasAccess ? "YES" : "NO") . "\n";
}
