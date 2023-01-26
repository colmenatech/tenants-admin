<?php
/**
 *  Generated with: https://github.com/kamansoft/vemto-filament-plugin
 *  for: elcatalogo-admin
 *  by: kamansoft.com
 */

namespace App\Filament\Resources;

use App\Models\Tenant;
use Illuminate\Support\Str;
use Filament\{Tables, Forms};
use Filament\Resources\{Form, Table, Resource};
use Filament\Forms\Components\Grid;
use Filament\Forms\Components\Card;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Components\KeyValue;
use Illuminate\Database\Eloquent\Model;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\RichEditor;
use Filament\Tables\Filters\SelectFilter;
use App\Filament\Filters\DateRangeFilter;
use App\Filament\Resources\TenantResource\Pages;

class TenantResource extends Resource
{
    protected static ?string $model = Tenant::class;

    protected static ?string $navigationIcon = 'heroicon-o-collection';

    protected static ?string $recordTitleAttribute = 'name';

    public static function getModelLabel(): string
    {
        return __('Tenant');
    }

    public static function getPluralModelLabel(): string
    {
        return __('Tenants');
    }

    public static function form(Form $form): Form
    {
        return $form->schema([
            Card::make()->schema([
                Grid::make(['default' => 0])->schema([
                    Toggle::make('status')
                        ->label(__('Status'))
                        ->rules(['boolean'])
                        ->required()
                        ->columnSpan([
                            'default' => 12,
                            'md' => 12,
                            'lg' => 12,
                        ]),

                    TextInput::make('name')
                        ->label(__('Name'))
                        ->rules(['max:255', 'string'])
                        ->required()
                        ->unique(
                            'tenants',
                            'name',
                            fn(?Model $record) => $record
                        )
                        ->placeholder('Name')
                        ->columnSpan([
                            'default' => 12,
                            'md' => 12,
                            'lg' => 12,
                        ]),

                    TextInput::make('domain')
                        ->label(__('Domain'))
                        ->rules(['max:255', 'string'])
                        ->required()
                        ->unique(
                            'tenants',
                            'domain',
                            fn(?Model $record) => $record
                        )
                        ->placeholder('Domain')
                        ->columnSpan([
                            'default' => 12,
                            'md' => 12,
                            'lg' => 12,
                        ]),

                    TextInput::make('database')
                        ->label(__('Database'))
                        ->rules(['max:255', 'string'])
                        ->required()
                        ->unique(
                            'tenants',
                            'database',
                            fn(?Model $record) => $record
                        )
                        ->placeholder('Database')
                        ->columnSpan([
                            'default' => 12,
                            'md' => 12,
                            'lg' => 12,
                        ]),

                    FileUpload::make('image')
                        ->label(__('Image'))
                        ->rules(['image', 'max:2048'])
                        ->nullable()
                        ->image()
                        ->preserveFilenames()
                        ->directory(
                            request()->host() . '/uploads/' . 'Tenants/images/'
                        )
                        ->placeholder('Image')
                        ->columnSpan([
                            'default' => 12,
                            'md' => 12,
                            'lg' => 12,
                        ]),

                    KeyValue::make('system_settings')
                        ->label(__('System Settings'))
                        ->nullable()
                        ->columnSpan([
                            'default' => 12,
                            'md' => 12,
                            'lg' => 12,
                        ]),

                    KeyValue::make('settings')
                        ->label(__('Settings'))
                        ->nullable()
                        ->columnSpan([
                            'default' => 12,
                            'md' => 12,
                            'lg' => 12,
                        ]),

                    Select::make('user_id')
                        ->label(__('User'))
                        ->rules(['exists:users,id'])
                        ->nullable()
                        ->relationship('user', 'name')
                        ->searchable()
                        ->placeholder('User')
                        ->columnSpan([
                            'default' => 12,
                            'md' => 12,
                            'lg' => 12,
                        ]),

                    Select::make('subscription_id')
                        ->label(__('Subscription'))
                        ->rules(['exists:subscriptions,id'])
                        ->required()
                        ->relationship('subscription', 'name')
                        ->searchable()
                        ->placeholder('Subscription')
                        ->columnSpan([
                            'default' => 12,
                            'md' => 12,
                            'lg' => 12,
                        ]),

                    Select::make('tenant_request_id')
                        ->label(__('Tenant Request'))
                        ->rules(['exists:tenant_requests,id'])
                        ->nullable()
                        ->relationship('tenantRequest', 'email')
                        ->searchable()
                        ->placeholder('Tenant Request')
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
                Tables\Columns\IconColumn::make('status')
                    ->label(__('Status'))
                    ->toggleable()
                    ->boolean(),
                Tables\Columns\TextColumn::make('name')
                    ->label(__('Name'))
                    ->toggleable()
                    ->searchable(true, null, true)
                    ->limit(50),
                Tables\Columns\TextColumn::make('domain')
                    ->label(__('Domain'))
                    ->toggleable()
                    ->searchable(true, null, true)
                    ->limit(50),
                Tables\Columns\TextColumn::make('database')
                    ->label(__('Database'))
                    ->toggleable()
                    ->searchable(true, null, true)
                    ->limit(50),
                Tables\Columns\ImageColumn::make('image')
                    ->label(__('Image'))
                    ->toggleable()
                    ->circular(),
                Tables\Columns\TextColumn::make('user.name')
                    ->label(__('User'))
                    ->toggleable()
                    ->limit(50),
                Tables\Columns\TextColumn::make('subscription.name')
                    ->label(__('Subscription'))
                    ->toggleable()
                    ->limit(50),
                Tables\Columns\TextColumn::make('tenantRequest.email')
                    ->label(__('Tenant Request'))
                    ->toggleable()
                    ->limit(50),
            ])
            ->filters([
                DateRangeFilter::make('created_at'),

                SelectFilter::make('user_id')
                    ->relationship('user', 'name')
                    ->indicator('User')
                    ->multiple()
                    ->label('User'),

                SelectFilter::make('subscription_id')
                    ->relationship('subscription', 'name')
                    ->indicator('Subscription')
                    ->multiple()
                    ->label('Subscription'),

                SelectFilter::make('tenant_request_id')
                    ->relationship('tenantRequest', 'email')
                    ->indicator('TenantRequest')
                    ->multiple()
                    ->label('TenantRequest'),
            ]);
    }

    public static function getRelations(): array
    {
        return [TenantResource\RelationManagers\TagsRelationManager::class];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListTenants::route('/'),
            'create' => Pages\CreateTenant::route('/create'),
            'view' => Pages\ViewTenant::route('/{record}'),
            'edit' => Pages\EditTenant::route('/{record}/edit'),
        ];
    }
}
