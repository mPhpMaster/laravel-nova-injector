<?php

namespace MPhpMaster\LaravelNovaInjector;

use Illuminate\Contracts\Support\Htmlable;
use Illuminate\Contracts\View\View;

/**
 * @mixin \MPhpMaster\LaravelNovaInjector\InjectHeadTitle
 */
trait TLaravelNovaInjectorValue
{
    /**
     * The callback to be used to resolve the field's value.
     *
     * @var callable
     */
    protected $resolveCallback;

// region: Card

    /**
     * Define the callback that should be used to resolve the field's value.
     *
     * @param callable $resolveCallback
     *
     * @return $this
     */
    public function resolveUsing(callable $resolveCallback)
    {
        $this->resolveCallback = $resolveCallback;

        return $this;
    }

    /**
     * @return string
     */
    public function resolve()
    {
        $result = "";
        if( !$this->resolveCallback ) {
            if( $this->calledModelClass && $for = data_get($this->meta, 'for') ) {
                try {
                    $method = "get" . \Str::studly($for) . "Value";
                    $result = method_exists($this->calledModelClass, $method)
                        ? $this->calledModelClass::{$method}()
                        : null;
                    $result ??= method_exists($this->calledClass, $method)
                        ? $this->calledClass::{$method}()
                        : "";
                } catch(\Exception $exception) {
                    $result = "";
                }
            }
        } elseif( is_callable($this->resolveCallback) ) {
            $result = call_user_func($this->resolveCallback);
        }

        if( is_object($result) ) {
            try {
                if( method_exists($result, 'render') ) {
                    return (string) ($result instanceof View
                        ? $result->with($this->baseJsonSerialize())->render()
                        : $result->render());
                }

                if( method_exists($result, 'toHtml') || $result instanceof Htmlable ) {
                    return (string) $result->toHtml();
                }

                if( method_exists($result, 'toString') ) {
                    return (string) $result->toString();
                }

                if( method_exists($result, '__toString') ) {
                    return (string) $result->__toString();
                }

                return (string) $result;
            } catch(\Exception $exception) {

            }
        }

        return (string) $result;
    }
// endregion: Card

// region: showWhenEmpty
    /**
     * @param bool $value
     *
     * @return $this
     */
    public function showWhenEmpty(bool $value = false)
    {
        $this->withMeta([ 'showWhenEmpty' => $value ]);

        return $this;
    }

    /**
     * @param bool $value
     *
     * @return $this
     */
    public function hideWhenEmpty(bool $value = true)
    {
        $this->showWhenEmpty(!$value);

        return $this;
    }

// endregion: showWhenEmpty

// region: valueType
    /**
     * @return $this
     */
    public function appendableValue()
    {
        $this->withMeta([ 'valueType' => 'appendable' ]);

        return $this;
    }

    /**
     * @return $this
     */
    public function suffixableValue()
    {
        $this->withMeta([ 'valueType' => 'suffixable' ]);

        return $this;
    }

    /**
     * @return $this
     */
    public function replaceableValue()
    {
        $this->withMeta([ 'valueType' => 'replaceable' ]);

        return $this;
    }
// endregion: valueType

}
