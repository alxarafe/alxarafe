<?php

namespace Alxarafe\Scripts;

require __DIR__ . '/../../vendor/autoload.php';

class MockIO
{
    public function write($msg)
    {
        echo $msg . PHP_EOL;
    }
    public function getIO()
    {
        return $this;
    }
}

$event = new MockIO(); // ComposerScripts::postUpdate expects an event object with getIO() method.
// Our MockIO can act as both the event and the IO for simplicity here if we tweak postUpdate slightly
// or we can wrap it. Let's wrap it properly.

class MockEvent
{
    private $io;
    public function __construct()
    {
        $this->io = new MockIO();
    }
    public function getIO()
    {
        return $this->io;
    }
}

echo "Manual Asset Publication Triggered..." . PHP_EOL;

if (class_exists(ComposerScripts::class)) {
    ComposerScripts::postUpdate(new MockEvent());
} else {
    echo "ComposerScripts class not found." . PHP_EOL;
    exit(1);
}
