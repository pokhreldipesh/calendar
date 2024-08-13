<?php

namespace Dipesh\Calendar\Concerns;

use Dipesh\NepaliDate\Contracts\Language;
use Dipesh\NepaliDate\lang\Nepali;

trait HasLanguage
{
    public Language $language;
    public function setLang(Language $language): static
    {
         $this->language = $language;

         return $this;
    }

    public function getLanguage(): Language
    {
        return new Nepali();
    }
}
