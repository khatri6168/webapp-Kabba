<?php

namespace Botble\Terms\Contracts;

use Botble\Terms\TermsCollection;

interface Terms
{
    public function registerSchema(TermsCollection $faqs): void;
}
