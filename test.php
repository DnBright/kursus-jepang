<?php
$user = App\Models\User::first(); // Assuming first user is the test user, wait, let's get latest user or all users
$courses = App\Models\Course::all();
foreach($courses as $c) {
    echo "Course: " . $c->title . " Level: " . $c->level . "\n";
}
