<?php

namespace App\Providers;

use App\Models\User;
use App\Observers\UserObserver;
use App\Repositories\ClientRepository;
use App\Repositories\DocumentRepository;
use App\Repositories\NotaryClientProductRepository;
use App\Repositories\NotaryClientProgressRepository;
use App\Repositories\Interfaces\ClientRepositoryInterface;
use App\Repositories\Interfaces\DocumentRepositoryInterface;
use App\Repositories\Interfaces\NotaryConsultationServiceInterface;
use App\Repositories\Interfaces\ProductRepositoryInterface;
use App\Repositories\Interfaces\NotaryClientProductRepositoryInterface;
use App\Repositories\Interfaces\NotaryClientProgressRepositoryInterface;
use App\Repositories\NotaryConsultationRepository;
use App\Repositories\ProductRepository;
use App\Services\NotaryConsultationService;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
        $this->app->bind(ProductRepositoryInterface::class, ProductRepository::class);
        $this->app->bind(DocumentRepositoryInterface::class, DocumentRepository::class);
        $this->app->bind(ClientRepositoryInterface::class, ClientRepository::class);
        $this->app->bind(NotaryConsultationServiceInterface::class, NotaryConsultationRepository::class);
        $this->app->bind(NotaryClientProductRepositoryInterface::class, NotaryClientProductRepository::class);
        $this->app->bind(NotaryClientProgressRepositoryInterface::class, NotaryClientProgressRepository::class);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
        User::observe(UserObserver::class);
        Paginator::useBootstrapFive();
    }
}
