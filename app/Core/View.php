<?php

namespace App\Core;

use App\Core\Interfaces\Application as IApplication;
use App\Core\Interfaces\Response as IResponse;

class View implements IResponse
{
    public function __construct(
        protected string $view,
        protected array $data = [],
    ) {
    }

    public function toHtml(IApplication $application): string
    {
        extract($this->data);

        ob_start();
        include $this->viewPath($application);
        $html = ob_get_clean();

        return $html;
    }

    protected function viewPath(IApplication $application): string
    {
        return $application->rootPath().'/views/'.str_replace('.', '/', $this->view).'.php';
    }
}
