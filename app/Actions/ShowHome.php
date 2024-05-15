<?php

namespace App\Actions;

use App\Models\Event;
use Inertia\Inertia;
use JustSteveKing\LaravelPostcodes\Rules\Postcode;
use JustSteveKing\LaravelPostcodes\Service\PostcodeService;
use Lorisleiva\Actions\ActionRequest;
use Lorisleiva\Actions\Concerns\AsAction;

class ShowHome
{
    use AsAction;

    public function rules(): array
    {
        return [
            'postcode' => [
                'string',
                new Postcode(resolve(PostcodeService::class))
            ]
        ];
    }

    public function handle(PostcodeService $service, $postcode = null)
    {
        if ($postcode) {
            $location = $service->getPostcode($postcode);
            return ['location' => [
                'lat' => $location->latitude,
                'long' => $location->longitude,
            ], 'events' => Event::all()];
        }

        return ['events' => Event::all()];
    }

    public function asController(PostcodeService $service, ActionRequest $request)
    {
        $data = $request->validated();
        $response = $this->handle($service, $data['postcode'] ?? null);
        return Inertia::render('Home', $response);
    }
}
