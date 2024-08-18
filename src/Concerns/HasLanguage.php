<?php

namespace Dipesh\Calendar\Concerns;

use Dipesh\NepaliDate\Contracts\Language;
use Dipesh\NepaliDate\lang\Nepali;

/**
 * Trait HasLanguage
 *
 * This trait provides methods to set and retrieve the language for a class that uses it.
 * It includes a property to store the language and methods to set and get the language.
 *
 * @package Dipesh\Calendar\Concerns
 */
trait HasLanguage
{
    /**
     * The language instance used for localization.
     *
     * @var Language
     */
    public Language $language;

    /**
     * Set the language instance.
     *
     * This method allows setting a specific language for the class.
     *
     * @param Language $language The language instance to set.
     * @return static The instance of the class that uses this trait.
     */
    public function setLang(Language $language): static
    {
        $this->language = $language;

        return $this;
    }

    /**
     * Get the language instance.
     *
     * This method returns the current language instance.
     * If no language is set, it defaults to the Nepali language.
     *
     * @return Language The language instance.
     */
    public function getLanguage(): Language
    {
        return new Nepali();
    }
}
