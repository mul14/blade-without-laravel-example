<?php

require './bootstrap.php';

// Render Blade
echo View::make('sample')->withName('Mulia');

// Render PHP
echo View::make('hello');
