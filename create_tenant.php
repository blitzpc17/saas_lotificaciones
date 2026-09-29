<?php
$t = App\Models\Tenant::create(['id' => 'lopez']);
$t->domains()->create(['domain' => 'lopez.localhost']);
echo "Tenant created successfully\n";
