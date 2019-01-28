<?php

namespace Corals\Foundation\View;

use  Corals\Foundation\View\Compilers\CoralsBladeCompiler;
use Illuminate\View\Engines\CompilerEngine;

class ViewServiceProvider extends \Illuminate\View\ViewServiceProvider
{
    public function registerBladeEngine($resolver)
    {
        $this->app->singleton('blade.compiler', function () {
            return new CoralsBladeCompiler(
                $this->app['files'], $this->app['config']['view.compiled']
            );
        });

        $resolver->register('blade', function () {
            return new CompilerEngine($this->app['blade.compiler']);
        });
    }
}
