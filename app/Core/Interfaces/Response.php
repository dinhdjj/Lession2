<?php

namespace App\Core\Interfaces;

interface Response
{
    /** Convert response to html */
    public function toHtml(Application $application): string;
}
