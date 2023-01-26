<?php
/**
 *  Generated with: https://github.com/kamansoft/vemto-filament-plugin
 *  used files template : elcatalogo-admin
 *  by: kamansoft.com
 */

namespace App\Filament\Resources\UserResource\Pages;

use App\Filament\Resources\UserResource;
use Filament\Resources\Pages\ListRecords;
use App\Filament\Traits\HasDescendingOrder;

class ListUsers extends ListRecords
{
    use HasDescendingOrder;

    protected static string $resource = UserResource::class;
}
