<?php

namespace MPhpMaster\LaravelNovaInjector;

use Exception;
use Laravel\Nova\Card;

/**
 * needs public static function getHeadTitleValue in nova res or in model.
 * Custom class
 */
class LaravelNovaInjector extends Card
{
    use TLaravelNovaInjectorValue,
        TLaravelNovaInjectorElement,
        TLaravelNovaInjectorCard;

    /** @var string */
    public $component = 'LaravelNovaInjector';
    /** @var string */
    public $width = '1/2';

    public function __construct(string $for = '')
    {
        parent::__construct($this->component);

        try {
            $this->calledClass = currentNovaResourceClass();
            /** @var string $model */
            $this->calledModelClass = (string)(property_exists($this->calledClass, 'model') ? $this->calledClass::$model : "");
        } catch (Exception $exception) {
        }

        $this->removeElement()
            ->removeParentElementWhenEmpty()
            ->makeFor($for)
            ->hideWhenEmpty()
            ->appendableValue();
    }
}
