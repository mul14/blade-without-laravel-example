<?php

require './vendor/autoload.php';

use \Illuminate\Events\Dispatcher;
use \Illuminate\Filesystem\Filesystem;

use \Illuminate\View\View as BaseView;
use \Illuminate\View\Factory;
use \Illuminate\View\FileViewFinder;
use \Illuminate\View\Compilers\BladeCompiler;
use \Illuminate\View\Engines\CompilerEngine;
use \Illuminate\View\Engines\PhpEngine;
use \Illuminate\View\Engines\EngineResolver;

class View
{
    protected static $instance;

    public static function __callStatic($method, $args)
    {
        if (! static::$instance) {
            static::$instance = (new self)->boot();
        }

        return static::$instance->{$method}(...$args);
    }

    protected function boot()
    {
        $event = new Dispatcher;

        $filesystem = new FileSystem;

        $finder = new FileViewFinder($filesystem, [__DIR__.'/views']);

        $engine = new CompilerEngine(
            new BladeCompiler($filesystem, __DIR__.'/views/_cache')
        );

        $resolver = new EngineResolver;

        $resolver->register('blade', function () use ($engine) {
            return $engine;
        });

        $resolver->register('php', function () {
            return new PhpEngine;
        });

        $factory = new Factory($resolver, $finder, $event);

        $view = new BaseView($factory, $engine, '', '');

        return $view->getFactory();
    }
}
