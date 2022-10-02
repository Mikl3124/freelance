<?php

namespace App\Http\Livewire\Update;

use Artisan;
use File;
use Livewire\Component;

class UpdateComponent extends Component
{

    /**
     * Init component
     *
     * @return void
     */
    public function mount()
    {
        // Check if update file exists, or application is up to date
        if (!File::exists(base_path('updating'))) {
            return redirect('/');
        }

        // Run migration
        Artisan::call('migrate', [ '--force' => true ]);

        // After that we need to run seeder
        Artisan::call('db:seed', [ '--class' => 'OfflinePaymentSettingsTableSeeder', '--force' => true ]);
        Artisan::call('db:seed', [ '--class' => 'SettingsAppearanceTableSeeder', '--force' => true ]);
        Artisan::call('db:seed', [ '--class' => 'BlogSettingsTableSeeder', '--force' => true ]);

        // Clear cache
        Artisan::call('view:clear');

        // Delete update file
        File::delete(base_path('updating'));

        // Redirect
        return redirect('/');
    }
    
}