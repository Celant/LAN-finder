<?php

namespace App\Actions;

use App\Models\Event;
use Clickbar\Magellan\Data\Geometries\Point;
use Clickbar\Magellan\Database\PostgisFunctions\ST;
use Inertia\Inertia;
use JustSteveKing\LaravelPostcodes\Rules\Postcode;
use JustSteveKing\LaravelPostcodes\Service\PostcodeService;
use Lorisleiva\Actions\ActionRequest;
use Lorisleiva\Actions\Concerns\AsAction;

class SearchPostcode
{
    use AsAction;

    public function rules(): array
    {
        return [
            'postcode' => [
                'required',
                'string',
                new Postcode(resolve(PostcodeService::class))
            ]
        ];
    }

    public function handle(PostcodeService $service, $postcode)
    {
        $postcodeInfo = $service->getPostcode($postcode);
        $location = Point::makeGeodetic($postcodeInfo->latitude, $postcodeInfo->longitude);

        $events = Event::select()
            ->stSelect(ST::distanceSphere($location, 'location'), as: 'distance_to_event')
            ->stOrderBy(ST::distanceSphere($location, 'location'), 'ASC')
            ->get();

        //dd($location, $events);

        return ['location' => [
            'lat' => $location->getLatitude(),
            'long' => $location->getLongitude(),
        ], 'events' => $events];
    }

    public function asController(PostcodeService $service, ActionRequest $request)
    {
        $data = $request->validated();
        $response = $this->handle($service, $data['postcode']);
        return Inertia::render('Search', [
            'location' => $response['location'],
            'events' => $response['events'],
        ]);
    }
}
