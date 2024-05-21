<?php

namespace Database\Seeders;

use Botble\Base\Supports\BaseSeeder;
use Botble\Faq\Models\Faq;
use Botble\Faq\Models\FaqCategory;
use Botble\Language\Models\LanguageMeta;
use Illuminate\Support\Facades\DB;

class FaqSeeder extends BaseSeeder
{
    public function run(): void
    {
        Faq::query()->truncate();
        FaqCategory::query()->truncate();
        DB::table('faqs_translations')->truncate();
        DB::table('faq_categories_translations')->truncate();
        LanguageMeta::query()->where('reference_type', FaqCategory::class)->delete();
        LanguageMeta::query()->where('reference_type', Faq::class)->delete();

        $categories = [
            'General',
            'Buying',
            'Payment',
            'Support',
        ];

        foreach ($categories as $index => $value) {
            FaqCategory::query()->create([
                'name' => $value,
                'order' => $index,
            ]);
        }

        $faqs = [
            [
                'question' => 'Where does it come from?',
                'answer' => 'If several languages coalesce, the grammar of the resulting language is more simple and regular than that of the individual languages. The new common language will be more simple and regular than the existing European languages.',
            ],
            [
                'question' => 'How StarBelly Work?',
                'answer' => 'To an English person, it will seem like simplified English, as a skeptical Cambridge friend of mine told me what Occidental is. The European languages are members of the same family. Their separate existence is a myth.',
            ],
            [
                'question' => 'What is your shipping policy?',
                'answer' => 'Everyone realizes why a new common language would be desirable: one could refuse to pay expensive translators. To achieve this, it would be necessary to have uniform grammar, pronunciation and more common words.',
            ],
            [
                'question' => 'Where To Place A FAQ Page',
                'answer' => 'Just as the name suggests, a FAQ page is all about simple questions and answers. Gather common questions your customers have asked from your support team and include them in the FAQ, Use categories to organize questions related to specific topics.',
            ],
            [
                'question' => 'Why do we use it?',
                'answer' => 'It will be as simple as Occidental; in fact, it will be Occidental. To an English person, it will seem like simplified English, as a skeptical Cambridge friend of mine told me what Occidental.',
            ],
            [
                'question' => 'Where can I get some?',
                'answer' => 'To an English person, it will seem like simplified English, as a skeptical Cambridge friend of mine told me what Occidental is. The European languages are members of the same family. Their separate existence is a myth.',
            ],
            [
                'question' => 'Where does it come from?',
                'answer' => 'If several languages coalesce, the grammar of the resulting language is more simple and regular than that of the individual languages. The new common language will be more simple and regular than the existing European languages.',
            ],
            [
                'question' => 'How StarBelly Work?',
                'answer' => 'To an English person, it will seem like simplified English, as a skeptical Cambridge friend of mine told me what Occidental is. The European languages are members of the same family. Their separate existence is a myth.',
            ],
            [
                'question' => 'What is your shipping policy?',
                'answer' => 'Everyone realizes why a new common language would be desirable: one could refuse to pay expensive translators. To achieve this, it would be necessary to have uniform grammar, pronunciation and more common words.',
            ],
            [
                'question' => 'Where To Place A FAQ Page',
                'answer' => 'Just as the name suggests, a FAQ page is all about simple questions and answers. Gather common questions your customers have asked from your support team and include them in the FAQ, Use categories to organize questions related to specific topics.',
            ],
            [
                'question' => 'Why do we use it?',
                'answer' => 'It will be as simple as Occidental; in fact, it will be Occidental. To an English person, it will seem like simplified English, as a skeptical Cambridge friend of mine told me what Occidental.',
            ],
            [
                'question' => 'Where can I get some?',
                'answer' => 'To an English person, it will seem like simplified English, as a skeptical Cambridge friend of mine told me what Occidental is. The European languages are members of the same family. Their separate existence is a myth.',
            ],
            [
                'question' => 'Where does it come from?',
                'answer' => 'If several languages coalesce, the grammar of the resulting language is more simple and regular than that of the individual languages. The new common language will be more simple and regular than the existing European languages.',
            ],
            [
                'question' => 'How StarBelly Work?',
                'answer' => 'To an English person, it will seem like simplified English, as a skeptical Cambridge friend of mine told me what Occidental is. The European languages are members of the same family. Their separate existence is a myth.',
            ],
            [
                'question' => 'What is your shipping policy?',
                'answer' => 'Everyone realizes why a new common language would be desirable: one could refuse to pay expensive translators. To achieve this, it would be necessary to have uniform grammar, pronunciation and more common words.',
            ],
            [
                'question' => 'Where To Place A FAQ Page',
                'answer' => 'Just as the name suggests, a FAQ page is all about simple questions and answers. Gather common questions your customers have asked from your support team and include them in the FAQ, Use categories to organize questions related to specific topics.',
            ],
            [
                'question' => 'Why do we use it?',
                'answer' => 'It will be as simple as Occidental; in fact, it will be Occidental. To an English person, it will seem like simplified English, as a skeptical Cambridge friend of mine told me what Occidental.',
            ],
            [
                'question' => 'Where can I get some?',
                'answer' => 'To an English person, it will seem like simplified English, as a skeptical Cambridge friend of mine told me what Occidental is. The European languages are members of the same family. Their separate existence is a myth.',
            ],
            [
                'question' => 'Where does it come from?',
                'answer' => 'If several languages coalesce, the grammar of the resulting language is more simple and regular than that of the individual languages. The new common language will be more simple and regular than the existing European languages.',
            ],
            [
                'question' => 'How StarBelly Work?',
                'answer' => 'To an English person, it will seem like simplified English, as a skeptical Cambridge friend of mine told me what Occidental is. The European languages are members of the same family. Their separate existence is a myth.',
            ],
            [
                'question' => 'What is your shipping policy?',
                'answer' => 'Everyone realizes why a new common language would be desirable: one could refuse to pay expensive translators. To achieve this, it would be necessary to have uniform grammar, pronunciation and more common words.',
            ],
            [
                'question' => 'Where To Place A FAQ Page',
                'answer' => 'Just as the name suggests, a FAQ page is all about simple questions and answers. Gather common questions your customers have asked from your support team and include them in the FAQ, Use categories to organize questions related to specific topics.',
            ],
            [
                'question' => 'Why do we use it?',
                'answer' => 'It will be as simple as Occidental; in fact, it will be Occidental. To an English person, it will seem like simplified English, as a skeptical Cambridge friend of mine told me what Occidental.',
            ],
            [
                'question' => 'Where can I get some?',
                'answer' => 'To an English person, it will seem like simplified English, as a skeptical Cambridge friend of mine told me what Occidental is. The European languages are members of the same family. Their separate existence is a myth.',
            ],
        ];

        $categoriesCount = FaqCategory::query()->count();

        foreach ($faqs as $faq) {
            Faq::query()->create([
                'category_id' => rand(1, $categoriesCount),
                'question' => $faq['question'],
                'answer' => $faq['answer'],
            ]);
        }

        $translations = [
            'Chung',
            'Mua',
            'Thanh toán',
            'Hỗ trợ',
        ];

        foreach ($translations as $index => $item) {
            DB::table('faq_categories_translations')->insert([
                'lang_code' => 'vi',
                'faq_categories_id' => $index + 1,
            ]);
        }
    }
}
