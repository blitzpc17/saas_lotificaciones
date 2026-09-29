<?php
$t = App\Models\Tenant::create(['id' => 'admin']);
$t->domains()->create(['domain' => 'admin.localhost']);
echo "Tenant admin created\n";
