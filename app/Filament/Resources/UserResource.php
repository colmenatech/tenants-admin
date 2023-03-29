<?php
/**
 *  Generated with: https://github.com/kamansoft/vemto-filament-plugin
 *  for: elcatalogo-admin
 *  by: kamansoft.com
 */

namespace App\Filament\Resources;

use App\Models\User;
use Illuminate\Support\Str;
use Filament\{Tables, Forms};
use Filament\Resources\{Form, Table, Resource};
use Livewire\Component;
use Filament\Forms\Components\Grid;
use Filament\Forms\Components\Card;
use Illuminate\Database\Eloquent\Model;
use Filament\Forms\Components\TextInput;
use App\Filament\Filters\DateRangeFilter;
use App\Filament\Resources\UserResource\Pages;

class UserResource extends Resource
{
    protected static ?string $model = User::class;

    protected static ?string $navigationIcon = 'heroicon-o-collection';

    protected static ?string $recordTitleAttribute = 'name';

    public static function getModelLabel(): string
    {
        return __('User');
    }

    public static function getPluralModelLabel(): string
    {
        return __('Users');
    }

    public static function form(Form $form): Form
    {
        return $form->schema([
            Card::make()->schema([
                Grid::make(['default' => 0])->schema([
                    TextInput::make('name')
                        ->label(__('Name'))
                        ->rules(['max:255', 'string'])
                        ->required()
                        ->placeholder(__('Name'))
                        ->columnSpan([
                            'default' => 12,
                            'md' => 12,
                            'lg' => 12,
                        ]),

                    TextInput::make('email')
                        ->label(__('Email'))
                        ->rules(['email'])
                        ->required()
                        ->unique(
                            'users',
                            'email',
                            fn(?Model $record) => $record
                        )
                        ->email()
                        ->placeholder(__('Email'))
                        ->columnSpan([
                            'default' => 12,
                            'md' => 12,
                            'lg' => 12,
                        ]),

                    TextInput::make('password')
                        ->label(__('Password'))
                        ->required()
                        ->password()
                        ->dehydrateStateUsing(fn($state) => \Hash::make($state))
                        ->required(
                            fn(Component $livewire) => $livewire instanceof
                                Pages\CreateUser
                        )
                        ->placeholder(__('Password'))
                        ->columnSpan([
                            'default' => 12,
                            'md' => 12,
                            'lg' => 12,
                        ]),
                ]),
            ]),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->poll('60s')
            ->columns([
                Tables\Columns\TextColumn::make('name')
                    ->label(__('Name'))
                    ->toggleable()
                    ->searchable(true, null, true)
                    ->limit(50),
                Tables\Columns\TextColumn::make('email')
                    ->label(__('Email'))
                    ->toggleable()
                    ->searchable(true, null, true)
                    ->limit(50),
            ]);
    }

    public static function getRelations(): array
    {
        return [UserResource\RelationManagers\TenantsRelationManager::class];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListUsers::route('/'),
            'create' => Pages\CreateUser::route('/create'),
            'view' => Pages\ViewUser::route('/{record}'),
            'edit' => Pages\EditUser::route('/{record}/edit'),
        ];
    }
}
