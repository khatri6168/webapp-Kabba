<?php

namespace Database\Seeders;

use Botble\Base\Models\MetaBox as MetaBoxModel;
use Botble\Base\Supports\BaseSeeder;
use Botble\Blog\Models\Post;
use Botble\Ecommerce\Models\Product;
use Botble\Gallery\Models\Gallery;
use Botble\Language\Models\LanguageMeta;
use Botble\Menu\Models\Menu as MenuModel;
use Botble\Menu\Models\MenuLocation;
use Botble\Menu\Models\MenuNode;
use Botble\Page\Models\Page;
use Illuminate\Support\Arr;
use Illuminate\Support\Str;
use Menu;
use Botble\Base\Facades\MetaBox;

class MenuSeeder extends BaseSeeder
{
    public function run(): void
    {
        MenuModel::query()->truncate();
        MenuLocation::query()->truncate();
        MenuNode::query()->truncate();
        MetaBoxModel::query()->where('reference_type', MenuNode::class)->delete();
        LanguageMeta::query()->where('reference_type', MenuModel::class)->delete();
        LanguageMeta::query()->where('reference_type', MenuLocation::class)->delete();

        $menus = [
            [
                'name' => 'Main menu',
                'location' => 'main-menu',
                'items' => [
                    [
                        'title' => 'Home',
                        'url' => '/',
                        'children' => [
                            [
                                'title' => 'Home 1',
                                'reference_id' => 1,
                                'reference_type' => Page::class,
                            ],
                            [
                                'title' => 'Home 2',
                                'reference_type' => Page::class,
                                'reference_id' => 2,
                            ],
                            [
                                'title' => 'Home 3',
                                'reference_type' => Page::class,
                                'reference_id' => 3,
                            ],
                            [
                                'title' => 'Home 4',
                                'reference_type' => Page::class,
                                'reference_id' => 4,
                            ],
                        ],
                    ],
                    [
                        'title' => 'Pages',
                        'url' => '#',
                        'children' => [
                            [
                                'title' => 'About 1',
                                'reference_type' => Page::class,
                                'reference_id' => 5,
                            ],
                            [
                                'title' => 'About 2',
                                'reference_type' => Page::class,
                                'reference_id' => 6,
                            ],
                            [
                                'title' => 'Blog Style 1',
                                'reference_type' => Page::class,
                                'reference_id' => 7,
                            ],
                            [
                                'title' => 'Blog Style 2',
                                'reference_type' => Page::class,
                                'reference_id' => 8,
                            ],
                            [
                                'title' => 'Publication',
                                'url' => Post::query()->find(1)->url,
                            ],
                            [
                                'title' => 'Gallery 1',
                                'reference_type' => Page::class,
                                'reference_id' => 9,
                            ],
                            [
                                'title' => 'Gallery 2',
                                'reference_type' => Page::class,
                                'reference_id' => 10,
                            ],
                            [
                                'title' => 'Gallery Detail',
                                'url' => Gallery::query()->find(1)->url,
                            ],
                            [
                                'title' => 'Reviews',
                                'reference_type' => Page::class,
                                'reference_id' => 11,
                            ],
                            [
                                'title' => 'FAQs',
                                'reference_type' => Page::class,
                                'reference_id' => 12,
                            ],
                            [
                                'title' => 'Error 404',
                                'url' => '404',
                            ],
                        ],
                    ],
                    [
                        'title' => 'Shop',
                        'url' => '#',
                        'children' => [
                            [
                                'title' => 'Products',
                                'url' => '/products',
                            ],
                            [
                                'title' => 'Shop List 1',
                                'reference_type' => Page::class,
                                'reference_id' => 13,
                            ],
                            [
                                'title' => 'Shop List 2',
                                'reference_type' => Page::class,
                                'reference_id' => 14,
                            ],
                            [
                                'title' => 'Product Page',
                                'url' => Product::query()->find(1)->url,
                            ],
                            [
                                'title' => 'Cart',
                                'url' => route('public.cart'),
                            ],
                        ],
                    ],
                    [
                        'title' => 'Auth',
                        'url' => '#',
                        'children' => [
                            [
                                'title' => 'Sign Up',
                                'url' => route('customer.register'),
                            ],
                            [
                                'title' => 'Log In',
                                'url' => route('customer.login'),
                            ],
                            [
                                'title' => 'Reset Password',
                                'url' => route('customer.password.reset'),
                            ],
                        ],
                    ],
                    [
                        'title' => 'Contact',
                        'reference_type' => Page::class,
                        'reference_id' => 15,
                    ],
                ],
            ],
        ];

        $locales = ['en_US', 'vi'];
        foreach ($menus as $index => $item) {
            foreach ($locales as $locale) {
                $item['name'] = Arr::get($this->trans(), $locale . '.' . $item['name'], $item['name']);
                $item['slug'] = Str::slug($item['name']);

                $this->saveMenu($item, $locale, $index);
            }
        }

        Menu::clearCacheMenuItems();
    }

    protected function trans(): array
    {
        return [
            'vi' => [
                'Main menu' => 'Menu chính',
                'Homepage' => 'Trang chủ',
                'Homepage 1' => 'Trang chủ 1',
                'Homepage 2' => 'Trang chủ 2',
                'Homepage 3' => 'Trang chủ 3',
                'Homepage 4' => 'Trang chủ 4',
            ],
        ];
    }

    protected function saveMenu(array $item, string $locale, int $index)
    {
        $menu = MenuModel::query()->create(Arr::except($item, ['items', 'location']));

        if (isset($item['location'])) {
            $menuLocation = MenuLocation::query()->create([
                'menu_id' => $menu->id,
                'location' => $item['location'],
            ]);

            $originValue = LanguageMeta::query()->where([
                'reference_id' => $locale == 'en_US' ? 1 : 2,
                'reference_type' => MenuLocation::class,
            ])->value('lang_meta_origin');

            LanguageMeta::saveMetaData($menuLocation, $locale, $originValue);
        }

        foreach ($item['items'] as $menuNode) {
            $this->createMenuNode($index, $menuNode, $locale, $menu->id);
        }

        $originValue = null;

        if ($locale !== 'en_US') {
            $originValue = LanguageMeta::query()->where([
                'reference_id' => $index * 2 + 1,
                'reference_type' => MenuModel::class,
            ])->value('lang_meta_origin');
        }

        LanguageMeta::saveMetaData($menu, $locale, $originValue);
    }

    protected function createMenuNode(int $index, array $menuNode, string $locale, int $menuId, int $parentId = 0): void
    {
        $menuNode['menu_id'] = $menuId;
        $menuNode['parent_id'] = $parentId;
        $menuNode['title'] = Arr::get($this->trans(), $locale . '.' . $menuNode['title'], $menuNode['title']);

        if (isset($menuNode['url'])) {
            $menuNode['url'] = str_replace(url(''), '', $menuNode['url']);
        }

        if (Arr::has($menuNode, 'children')) {
            $children = $menuNode['children'];
            $menuNode['has_child'] = true;

            unset($menuNode['children']);
        } else {
            $children = [];
            $menuNode['has_child'] = false;
        }

        $createdNode = MenuNode::query()->create(Arr::except($menuNode, 'child_style'));

        if (Arr::has($menuNode, 'child_style')) {
            MetaBox::saveMetaBoxData($createdNode, 'child_style', Arr::get($menuNode, 'child_style'));
        }

        if ($children) {
            foreach ($children as $child) {
                $this->createMenuNode($index, $child, $locale, $menuId, $createdNode->id);
            }
        }
    }
}
