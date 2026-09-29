<?php
$t = App\Models\Tenant::find('lopez');
if ($t) {
    $t->domains()->create(['domain' => 'lopez.localhost']);
    echo "Domain added to existing tenant lopez\n";
} else {
    echo "Tenant lopez not found\n";
}
