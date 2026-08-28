<?php
$session = App\Models\CashSession::latest()->first();
if ($session && $session->opening_amount == 25) {
    $session->opening_amount = 250000;
    $session->save();
    echo "Updated session {$session->id} opening amount to 250000.\n";
} else {
    echo "No update needed. Current opening amount: " . ($session ? $session->opening_amount : 'None') . "\n";
}
