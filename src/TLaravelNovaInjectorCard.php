<?php

namespace MPhpMaster\LaravelNovaInjector;

/**
 * @mixin \MPhpMaster\LaravelNovaInjector\InjectHeadTitle
 */
trait TLaravelNovaInjectorCard
{
    protected string $calledClass = "";
    protected string $calledModelClass = "";

    /**
     * Prepare the element for JSON serialization.
     *
     * @return array
     */
    public function jsonSerialize()
    {
        return array_merge([
            'for_value' => $this->resolve(),
        ], $this->baseJsonSerialize());
    }

    /**
     * Prepare the element for JSON serialization.
     *
     * @return array
     */
    public function baseJsonSerialize()
    {
        $label = $this->calledClass && class_exists($this->calledClass) && method_exists($this->calledClass, 'label')
            ? $this->calledClass::label()
            : "";
        $width = $this->width;

        $data = compact('label', 'width');
        return array_merge($data, parent::jsonSerialize());
    }
}
