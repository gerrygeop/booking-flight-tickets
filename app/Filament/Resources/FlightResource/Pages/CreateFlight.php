<?php

namespace App\Filament\Resources\FlightResource\Pages;

use App\Filament\Resources\FlightResource;
use App\Models\Flight;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateFlight extends CreateRecord
{
    protected static string $resource = FlightResource::class;

    protected function afterCreate(): void
    {
        $flight = Flight::find($this->record->id);
        $flight->generateSeats();
    }
}
