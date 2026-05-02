<?php

namespace Zakarialabib\BComponents\Support;

use Illuminate\Support\Str;

class ComponentManager
{
    /**
     * Get the component view name
     *
     * @param string $name
     * @return string
     */
    public static function getViewName($name)
    {
        return "bcomponents::components.{$name}";
    }
    
    /**
     * Check if a component exists
     *
     * @param string $name
     * @return bool
     */
    public static function exists($name)
    {
        return view()->exists("bcomponents::components.{$name}");
    }
    
    public static function getDefaultClasses($name): ?string
    {
        return null;
    }
}
