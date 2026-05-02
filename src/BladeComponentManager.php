<?php

namespace Zakarialabib\BComponents;

use Illuminate\Support\Str;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\HtmlString;
use Illuminate\Foundation\Application;

class BladeComponentManager
{
    /**
     * The application instance.
     *
     * @var Application
     */
    protected $app;

    /**
     * Create a new BladeComponentManager instance.
     *
     * @param Application $app
     * @return void
     */
    public function __construct($app)
    {
        $this->app = $app;
    }

    /**
     * Create a component instance
     *
     * @param string $name
     * @param array $attributes
     * @return HtmlString
     */
    public function create($name, $attributes = [])
    {
        $viewName = $this->getViewName($name);
        
        // Check if the view exists
        if (!View::exists($viewName)) {
            throw new \Exception("Component view {$viewName} does not exist.");
        }
        
        // Render the component
        return new HtmlString(View::make($viewName, $attributes)->render());
    }

    /**
     * Get the component view name
     *
     * @param string $name
     * @return string
     */
    public function getViewName($name)
    {
        // Check if the component has a namespace
        if (Str::contains($name, '::')) {
            return $name;
        }
        
        // Check if the component is in a subdirectory
        if (Str::contains($name, '.')) {
            return "bcomponents::components.{$name}";
        }
        
        return "bcomponents::components.{$name}";
    }

    /**
     * Check if a component exists
     *
     * @param string $name
     * @return bool
     */
    public function exists($name)
    {
        return View::exists($this->getViewName($name));
    }

    /**
     * Get the default classes for a component
     *
     * @param string $component
     * @return string|null
     */
    public function getDefaultClasses($component)
    {
        return Config::get("bcomponents.default_classes.{$component}");
    }

    /**
     * Check if a component is enabled
     *
     * @param string $component
     * @return bool
     */
    public function isEnabled($component)
    {
        return (bool) Config::get("bcomponents.components.enabled.{$component}", true);
    }

    /**
     * Get the CSS framework
     *
     * @return string
     */
    public function getCssFramework()
    {
        return Config::get('bcomponents.css_framework', 'tailwind');
    }

    /**
     * Get the component prefix
     *
     * @return string
     */
    public function getPrefix()
    {
        return Config::get('bcomponents.prefix', 'b');
    }
}
