<?php

namespace MPhpMaster\LaravelNovaInjector;

use Exception;
use Laravel\Nova\Card;

/**
 * @mixin \MPhpMaster\LaravelNovaInjector\InjectHeadTitle
 */
trait TLaravelNovaInjectorElement
{
    /**
     * @param string $for
     *
     * @return $this
     */
    public function makeFor(string $for = '')
    {
        $this->withMeta(['for' => $for]);

        return $this;
    }

// region: Element Options
    /**
     * @param bool $remove
     *
     * @return $this
     */
    public function removeParentElementWhenEmpty(bool $remove = true)
    {
        $this->withMeta(['removeParentElementWhenEmpty' => $remove]);

        return $this;
    }

    /**
     * @param bool $remove
     *
     * @return $this
     */
    public function removeElement(bool $remove = true)
    {
        $this->withMeta(['removeElement' => $remove]);

        return $this;
    }
// endregion: Element Options

}
