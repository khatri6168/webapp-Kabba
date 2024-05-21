<?php

namespace Database\Seeders;

use Botble\ACL\Models\User;
use Botble\Base\Models\MetaBox as MetaBoxModel;
use Botble\Base\Supports\BaseSeeder;
use Botble\Blog\Models\Category;
use Botble\Blog\Models\Post;
use Botble\Blog\Models\Tag;
use Botble\Language\Models\LanguageMeta;
use Botble\Slug\Models\Slug;
use Botble\Base\Facades\Html;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;
use Botble\Slug\Facades\SlugHelper;

class BlogSeeder extends BaseSeeder
{
    public function run(): void
    {
        $this->uploadFiles('blog');

        Post::query()->truncate();
        Category::query()->truncate();
        Tag::query()->truncate();
        DB::table('posts_translations')->truncate();
        DB::table('categories_translations')->truncate();
        DB::table('tags_translations')->truncate();
        Slug::query()->where('reference_type', Post::class)->delete();
        Slug::query()->where('reference_type', Tag::class)->delete();
        Slug::query()->where('reference_type', Category::class)->delete();
        MetaBoxModel::query()->where('reference_type', Post::class)->delete();
        MetaBoxModel::query()->where('reference_type', Tag::class)->delete();
        MetaBoxModel::query()->where('reference_type', Category::class)->delete();
        LanguageMeta::query()->where('reference_type', Post::class)->delete();
        LanguageMeta::query()->where('reference_type', Tag::class)->delete();
        LanguageMeta::query()->where('reference_type', Category::class)->delete();

        $categories = [
            'Design',
            'Lifestyle',
            'Travel Tips',
            'Healthy',
            'Travel Tips',
            'Hotel',
            'Nature',
        ];

        foreach ($categories as $item) {
            $category = Category::query()->create([
                'name' => $item,
                'description' => fake()->realText(),
                'author_type' => User::class,
                'author_id' => 1,
                'is_featured' => rand(0, 1),
            ]);

            Slug::query()->create([
                'reference_type' => Category::class,
                'reference_id' => $category->id,
                'key' => Str::slug($category->name),
                'prefix' => SlugHelper::getPrefix(Category::class),
            ]);
        }

        $tags = [
            'General',
            'Design',
            'Fashion',
            'Branding',
            'Modern',
        ];

        foreach ($tags as $item) {
            $tag = Tag::query()->create([
                'name' => $item,
                'author_type' => User::class,
                'author_id' => 1,
            ]);

            Slug::query()->create([
                'reference_type' => Tag::class,
                'reference_id' => $tag->id,
                'key' => Str::slug($tag->name),
                'prefix' => SlugHelper::getPrefix(Tag::class),
            ]);
        }

        $posts = [
            'The Top 2020 Handbag Trends to Know',
            'Top Search Engine Optimization Strategies!',
            'Which Company Would You Choose?',
            'Used Car Dealer Sales Tricks Exposed',
            '20 Ways To Sell Your Product Faster',
            'The Secrets Of Rich And Famous Writers',
            'Imagine Losing 20 Pounds In 14 Days!',
            'Are You Still Using That Slow, Old Typewriter?',
            'A Skin Cream That’s Proven To Work',
            '10 Reasons To Start Your Own, Profitable Website!',
            'Simple Ways To Reduce Your Unwanted Wrinkles!',
            'Apple iMac with Retina 5K display review',
            '10,000 Web Site Visitors In One Month:Guaranteed',
            'Unlock The Secrets Of Selling High Ticket Items',
            '4 Expert Tips On How To Choose The Right Men’s Wallet',
            'Sexy Clutches: How to Buy & Wear a Designer Clutch Bag',
        ];

        $usersCount = User::query()->count();

        foreach ($posts as $index => $item) {
            $content =
                '<p>Fretful human far recklessly while caterpillar well a well blubbered added one a some far whispered rampantly whispered while irksome far clung irrespective wailed more rosily and where saluted while black dear so yikes as considering recast to some crass until.</p>' .
                ($index % 3 === 0 ? Html::tag('p', '[youtube-video]https://www.youtube.com/watch?v=SlPhMPnQ58k[/youtube-video]') : '') .
                File::get(database_path('seeders/contents/post.html'));

            $post = Post::query()->create([
                'author_type' => User::class,
                'author_id' => rand(1, $usersCount),
                'name' => $item,
                'views' => rand(100, 10000),
                'is_featured' => rand(0, 1),
                'image' => 'blog/' . ($index >= 6 ? rand(1, 6) : $index + 1) . '.jpg',
                'description' => fake()->realText(),
                'content' => $content,
            ]);

            $post->categories()->sync([
                fake()->numberBetween(1, 4),
                fake()->numberBetween(5, 7),
            ]);

            $post->tags()->sync([1, 2, 3, 4, 5]);

            Slug::query()->create([
                'reference_type' => Post::class,
                'reference_id' => $post->id,
                'key' => Str::slug($post->name),
                'prefix' => SlugHelper::getPrefix(Post::class),
            ]);
        }

        $translations = [
            'Phong cách sống',
            'Sức khỏe',
            'Món ngon',
            'Sức khỏe',
            'Mẹo du lịch',
            'Khách sạn',
            'Thiên nhiên',
        ];

        foreach ($translations as $index => $item) {
            DB::table('categories_translations')->insert([
                'lang_code' => 'vi',
                'categories_id' => $index + 1,
            ]);
        }

        $translations = [
            'Chung',
            'Thiết kế',
            'Thời trang',
            'Thương hiệu',
            'Hiện đại',
        ];

        foreach ($translations as $index => $item) {
            DB::table('tags_translations')->insert([
                'lang_code' => 'vi',
                'tags_id' => $index + 1,
            ]);
        }

        $translations = [
            'Xu hướng túi xách hàng đầu năm 2020 cần biết',
            'Các Chiến lược Tối ưu hóa Công cụ Tìm kiếm Hàng đầu!',
            'Bạn sẽ chọn công ty nào?',
            'Lộ ra các thủ đoạn bán hàng của đại lý ô tô đã qua sử dụng',
            '20 Cách Bán Sản phẩm Nhanh hơn',
            'Bí mật của những nhà văn giàu có và nổi tiếng',
            'Hãy tưởng tượng bạn giảm 20 bảng Anh trong 14 ngày!',
            'Bạn vẫn đang sử dụng máy đánh chữ cũ, chậm đó?',
            'Một loại kem dưỡng da đã được chứng minh hiệu quả',
            '10 Lý do Để Bắt đầu Trang web Có Lợi nhuận của Riêng Bạn!',
            'Những cách đơn giản để giảm nếp nhăn không mong muốn của bạn!',
            'Đánh giá Apple iMac với màn hình Retina 5K',
            '10.000 Khách truy cập Trang Web Trong Một Tháng: Được Đảm bảo',
            'Mở khóa Bí mật Bán được vé Cao',
            '4 Lời khuyên của Chuyên gia về Cách Chọn Ví Nam Phù hợp',
            'Sexy Clutches: Cách Mua & Đeo Túi Clutch Thiết kế',
        ];

        foreach ($translations as $index => $item) {
            $post = Post::query()->find($index + 1);

            DB::table('posts_translations')->insert([
                'lang_code' => 'vi',
                'posts_id' => $post->id,
                'name' => $item,
                'description' => $post->description,
                'content' => $post->content,
            ]);
        }
    }
}
