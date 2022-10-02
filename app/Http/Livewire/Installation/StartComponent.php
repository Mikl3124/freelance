<?php

namespace App\Http\Livewire\Installation;

use Livewire\Component;
use Artesaos\SEOTools\Traits\SEOTools as SEOToolsTrait;
use Artisan;
use Config;
use Honey;

class StartComponent extends Component
{

    use SEOToolsTrait;

    public $phone;
    public $purchase_link;

    /**
     * Init component
     *
     * @return void
     */
    public function mount()
    {
        // Set livewire app url
        Config::write('livewire.app_url', url('/'));
        Config::write('livewire.asset_url', url('public'));

        // Set application url
        Config::write('app.url', url('/'));

        // Set filesystems links
        Config::write('filesystems.disks.public.url', url('storage'));
        Config::write('filesystems.disks.custom.url', url('public/storage'));

        // Clear cache
        Artisan::call('config:clear');

        // Set purchase link
        $this->purchase_link = config('global.purchase_link');

        // Set support phone
        // We prefer whatsapp support for fast replies
        // But first you have to add a comment in Codecanyon
        $this->phone         = config('global.whatsapp');
    }

    /**
     * Render component
     *
     * @return Illuminate\View\View
     */
    public function render()
    {
        // SEO
        $this->seo()->setTitle("Installation | Get started");

        return view('livewire.installation.start')->extends('livewire.installation.layout')->section('content');
    }


    /**
     * Go to next step
     *
     * @return void
     */
    public function next()
    {
        // Redirect to next step
        return redirect('install/requirements');
    }
    
}
