<?php

namespace App;

use Symfony\Bundle\FrameworkBundle\Kernel\MicroKernelTrait;
use Symfony\Component\HttpKernel\Kernel as BaseKernel;

use Symfony\Component\Console\Kernel as ConsoleKernel;
use Symfony\Component\Console\Scheduler\Scheduler;

class Kernel extends BaseKernel
{
    use MicroKernelTrait;
    
}
