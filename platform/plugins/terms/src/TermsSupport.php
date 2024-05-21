<?php

namespace Botble\Terms;

use Botble\Terms\Contracts\Terms as TermsContract;
use Botble\Theme\Facades\Theme;

class TermsSupport implements TermsContract
{
    public function registerSchema(TermsCollection $termss): void
    {
        $schema = [
            '@context' => 'https://schema.org',
            '@type' => 'TERMSPage',
            'mainEntity' => [],
        ];

        /*foreach ($terms->toArray() as $term) {
            $schema['mainEntity'][] = [
                '@type' => 'Question',
                'name' => $term->getQuestion(),
                'acceptedAnswer' => [
                    '@type' => 'Answer',
                    'text' => $term->getAnswer(),
                ],
            ];
        }*/

        $schema = json_encode($schema);

        Theme::asset()
            ->container('header')
            ->writeScript('terms-schema', $schema, attributes: ['type' => 'application/ld+json']);
    }
}
