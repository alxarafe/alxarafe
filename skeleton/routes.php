<?php

use Alxarafe\Lib\Router;

// Define your generic routes here
Router::add('home', '/', 'FrameworkTest.Test.index');
Router::add('test', '/test', 'FrameworkTest.Test.index');
Router::add('markdown-test', '/markdown-test', 'FrameworkTest.MarkdownTest.index');
