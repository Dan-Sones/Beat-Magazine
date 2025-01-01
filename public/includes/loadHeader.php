<?php

use S246109\BeatMagazine\Controllers\HeaderController;

$headerController = new HeaderController(new \S246109\BeatMagazine\Services\SessionService());

echo $headerController->index();