<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class DeleteRestoreButtons extends Component
{

    public string $routePrefix;
    public $model;

    /**
     * Create a new component instance.
     * @param string $routePrefix e.g., 'voters' (used for routes like voters.destroy, voters.restore, voters.force-delete)
     * @param mixed $model The Eloquent model instance
     */
    public function __construct(string $routePrefix, $model)
    {
         $this->routePrefix = $routePrefix;
        $this->model = $model;
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.delete-restore-buttons');
    }
}
