<?php

namespace App\Actions;

use App\Models\Event;
use Inertia\Inertia;
use Lorisleiva\Actions\Concerns\AsAction;

class ShowHome
{
    use AsAction;

    public function handle()
    {
        return Event::orderBy('starts_at')->get();
    }

    public function asController()
    {
        return Inertia::render('Home', [
            'events' => $this->handle()
        ]);
    }
}
