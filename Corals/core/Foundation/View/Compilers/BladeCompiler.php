<?php

namespace Corals\Foundation\View\Compilers;

use Illuminate\View\Compilers\BladeCompiler;

class CoralsBladeCompiler extends BladeCompiler
{

    public function isExpired($path)
    {

        $contents = $this->files->get($path);
        foreach (\Shortcode::tags() as $tag_key => $function) {
            if (strpos($contents, "@{$tag_key}(") !== false) {
                return true;
            }
        }

        return parent::isExpired($path);
    }
}
