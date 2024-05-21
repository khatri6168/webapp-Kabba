<?php

namespace Botble\Terms\Providers;

use Botble\Base\Facades\DashboardMenu;
use Botble\Base\Traits\LoadAndPublishDataTrait;
use Botble\Terms\Contracts\Terms as TermsContract;
use Botble\Terms\TermsSupport;
use Botble\Terms\Models\Terms;
use Botble\Terms\Models\TermsCategory;
use Botble\Terms\Repositories\Eloquent\TermsCategoryRepository;
use Botble\Terms\Repositories\Eloquent\TermsRepository;
use Botble\Terms\Repositories\Interfaces\TermsCategoryInterface;
use Botble\Terms\Repositories\Interfaces\TermsInterface;
use Botble\LanguageAdvanced\Supports\LanguageAdvancedManager;
use Illuminate\Routing\Events\RouteMatched;
use Botble\Base\Supports\ServiceProvider;

class TermsServiceProvider extends ServiceProvider
{
    use LoadAndPublishDataTrait;

    public function register(): void
    {
        $this->app->bind(TermsCategoryInterface::class, function () {
            return new TermsCategoryRepository(new TermsCategory());
        });

        $this->app->bind(TermsInterface::class, function () {
            return new TermsRepository(new Terms());
        });

        $this->app->singleton(TermsContract::class, TermsSupport::class);
    }

    public function boot(): void
    {
        $this
            ->setNamespace('plugins/terms')
            ->loadHelpers()
            ->loadAndPublishConfigurations(['permissions', 'general'])
            ->loadMigrations()
            ->loadAndPublishTranslations()
            ->loadRoutes()
            ->loadAndPublishViews()
            ->publishAssets();

        if (defined('LANGUAGE_ADVANCED_MODULE_SCREEN_NAME')) {
            LanguageAdvancedManager::registerModule(Terms::class, [
                'question',
                'answer',
            ]);
            LanguageAdvancedManager::registerModule(TermsCategory::class, [
                'name',
            ]);
        }

        $this->app['events']->listen(RouteMatched::class, function () {
            DashboardMenu::make()
                ->registerItem([
                    'id' => 'cms-plugins-terms',
                    'priority' => 5,
                    'parent_id' => null,
                    'name' => 'plugins/terms::terms.terms',
                    'icon' => 'far fa-check-circle',
                    'url' => route('terms.index'),
                    'permissions' => ['terms.index'],
                ])
                ->registerItem([
                    'id' => 'cms-plugins-globalterms-list',
                    'priority' => 0,
                    'parent_id' => 'cms-plugins-terms',
                    'name' => 'plugins/terms::terms.global_rental',
                    'icon' => null,
                    'url' => route('globalterms.index'),
                    'permissions' => ['globalterms.index'],
                ])
                ->registerItem([
                    'id' => 'cms-plugins-terms-list',
                    'priority' => 1,
                    'parent_id' => 'cms-plugins-terms',
                    'name' => 'plugins/terms::terms.products_specific',
                    'icon' => null,
                    'url' => route('terms.index'),
                    'permissions' => ['terms.index'],
                ])
                /* ->registerItem([
                    'id' => 'cms-plugins-salesterms-list',
                    'priority' => 2,
                    'parent_id' => 'cms-plugins-terms',
                    'name' => 'plugins/terms::terms.global_sales',
                    'icon' => null,
                    'url' => route('terms.index'),
                    'permissions' => ['terms.index'],
                ]) */;
                
        });

        $this->app->register(HookServiceProvider::class);
        $this->app->register(EventServiceProvider::class);
    }
}
