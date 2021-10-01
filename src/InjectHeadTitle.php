<?php

namespace MPhpMaster\LaravelNovaInjector;

/**
 * needs public static function getHeadTitleValue in nova res or in model.
 * HeadTitle changer class
 */
class InjectHeadTitle extends LaravelNovaInjector
{
    public function __construct(string $for = 'HeadTitle')
    {
        parent::__construct($for);
    }

    /**
     * Prepare the element for JSON serialization.
     *
     * @return array
     */
    public function jsonSerialize()
    {
        return $this->calledClass !== \Nova::resourceForKey(getNovaResource()) || getNovaResourceId()
            ? []
            : array_merge([
                              'for_value' => $this->resolve(),
                          ], $this->baseJsonSerialize());
    }
}
