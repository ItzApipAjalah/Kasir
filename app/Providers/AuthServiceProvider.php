<?php

namespace App\Providers;

// use Illuminate\Support\Facades\Gate;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Laravel\Sanctum\Sanctum;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The model to policy mappings for the application.
     *
     * @var array<class-string, class-string>
     */
    protected $policies = [
        // 'App\Models\Model' => 'App\Policies\ModelPolicy',
    ];

    /**
     * Register any authentication / authorization services.
     */
    public function boot(): void
    {
        $this->registerPolicies();

        // Check if the method exists before calling it
        if (method_exists(Sanctum::class, 'tokensCan')) {
            Sanctum::tokensCan([
                'admin' => 'Access admin functionality',
                'petugas' => 'Access petugas functionality',
                'petugas_gudang' => 'Access petugas gudang functionality',
                'pelanggan' => 'Access pelanggan functionality',
            ]);
        }
    }
}
