<?php

namespace Botble\Contact\Providers;

use Botble\Base\Facades\DashboardMenu;
use Botble\Base\Facades\EmailHandler;
use Botble\Base\Traits\LoadAndPublishDataTrait;
use Botble\Contact\Models\Contact;
use Botble\Contact\Models\ContactReply;
use Botble\Contact\Repositories\Eloquent\ContactReplyRepository;
use Botble\Contact\Repositories\Eloquent\ContactRepository;
use Botble\Contact\Repositories\Interfaces\ContactInterface;
use Botble\Contact\Repositories\Interfaces\ContactReplyInterface;
use Illuminate\Routing\Events\RouteMatched;
use Botble\Base\Supports\ServiceProvider;

class ContactServiceProvider extends ServiceProvider
{
    use LoadAndPublishDataTrait;

    public function register(): void
    {
        $this->app->bind(ContactInterface::class, function () {
            return new ContactRepository(new Contact());
        });

        $this->app->bind(ContactReplyInterface::class, function () {
            return new ContactReplyRepository(new ContactReply());
        });
    }

    public function boot(): void
    {
        $this
            ->setNamespace('plugins/contact')
            ->loadHelpers()
            ->loadAndPublishConfigurations(['permissions', 'email'])
            ->loadRoutes()
            ->loadAndPublishViews()
            ->loadAndPublishTranslations()
            ->loadMigrations()
            ->publishAssets();

        $this->app['events']->listen(RouteMatched::class, function () {
            DashboardMenu::registerItem([
                'id' => 'cms-plugins-contact',
                'priority' => 6,
                'parent_id' => null,
                'name' => 'Contacts/CRM',
                'icon' => 'far fa-envelope',
                'url' => null,
                'permissions' => ['newsletter.index'],
            ])
            ->registerItem([
                'id' => 'cms-plugins-contac',
                'priority' => 1,
                'parent_id' => 'cms-plugins-contact',
                'name' => 'Customers/Leads',
                'icon' => 'far fa-envelope',
                'url' => route('contacts.index'),
                'permissions' => ['contacts.index'],
            ])
            ->registerItem([
                'id' => 'cms-plugins-contact-tag',
                'priority' => 2,
                'parent_id' => 'cms-plugins-contact',
                'name' => 'Text Brodcast', 
                'icon' => 'far fa-comments',
                'url' => route('smslogs'),
                'permissions' => ['contacts.tags'],
            ])
            ->registerItem([
                'id' => 'cms-plugins-email-brodcast',
                'priority' => 3,
                'parent_id' => 'cms-plugins-contact',
                'name' => 'Email Brodcast', 
                'icon' => 'far fa-newspaper',
                'url' => route('newsletter.index'),
                'permissions' => ['contacts.tags'],
            ])
            ->registerItem([
                'id' => 'cms-plugins-sales-fullels',
                'priority' => 4,
                'parent_id' => 'cms-plugins-contact',
                'name' => 'Auto Sales Funnels', 
                'icon' => 'fa fa-tag',
                'url' => '#',
                'permissions' => ['contacts.tags'],
            ])
            ->registerItem([
                'id' => 'cms-plugins-contact-tags',
                'priority' => 5,
                'parent_id' => 'cms-plugins-contact',
                'name' => 'Tag', 
                'icon' => 'fa fa-tag',
                'url' => route('contacts.contacttags'),
                'permissions' => ['contacts.tags'],
            ])
            ->registerItem([
                'id' => 'cms-plugins-contact-company',
                'priority' => 5,
                'parent_id' => 'cms-plugins-contact',
                'name' => 'Company', 
                'icon' => 'fa fa-building-o',
                'url' => route('contacts.company'),
                'permissions' => ['contacts.tags'],
            ]);

            EmailHandler::addTemplateSettings(CONTACT_MODULE_SCREEN_NAME, config('plugins.contact.email', []));
        });

        $this->app->booted(function () {
            $this->app->register(HookServiceProvider::class);
        });
    }
}
