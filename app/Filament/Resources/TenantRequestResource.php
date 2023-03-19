<?php
/**
 *  Generated with: https://github.com/kamansoft/vemto-filament-plugin
 *  for: elcatalogo-admin
 *  by: kamansoft.com
 */

namespace App\Filament\Resources;

use Illuminate\Support\Str;
use App\Models\TenantRequest;
use Filament\{Tables, Forms};
use Filament\Resources\{Form, Table, Resource};
use Filament\Forms\Components\Grid;
use Filament\Forms\Components\Card;
use Illuminate\Database\Eloquent\Model;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\RichEditor;
use App\Filament\Filters\DateRangeFilter;
use App\Filament\Resources\TenantRequestResource\Pages;

class TenantRequestResource extends Resource
{
    protected static ?string $model = TenantRequest::class;

    protected static ?string $navigationIcon = 'heroicon-o-collection';

    protected static ?string $recordTitleAttribute = 'email';

    public static function getModelLabel(): string
    {
        return __('TenantRequest');
    }

    public static function getPluralModelLabel(): string
    {
        return __('TenantRequests');
    }

    public static function form(Form $form): Form
    {
        return $form->schema([
            Card::make()->schema([
                Grid::make(['default' => 0])->schema([
                    TextInput::make('email')
                        ->label(__('Email'))
                        ->rules(['email'])
                        ->required()
                        ->unique(
                            'tenant_requests',
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

                    TextInput::make('phone')
                        ->label(__('Phone'))
                        ->rules(['max:255', 'string'])
                        ->required()
                        ->unique(
                            'tenant_requests',
                            'phone',
                            fn(?Model $record) => $record
                        )
                        ->placeholder(__('Phone'))
                        ->columnSpan([
                            'default' => 12,
                            'md' => 12,
                            'lg' => 12,
                        ]),

                    RichEditor::make('description')
                        ->label(__('Description'))
                        ->rules(['string'])
                        ->disableToolbarButtons([
                            'attachFiles',
                            'blockquote',
                            'codeBlock',
                            'h2',
                            'h3',
                            //'italic',
                            //'link',
                            'strike',
                        ])
                        ->required()
                        ->placeholder(__('Description'))
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
                            request()->host() .
                                '/uploads/' .
                                'TenantRequests/images/'
                        )
                        ->placeholder(__('Image'))
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
                Tables\Columns\TextColumn::make('email')
                    ->label(__('Email'))
                    ->toggleable()
                    ->searchable(true, null, true)
                    ->limit(50),
                Tables\Columns\TextColumn::make('phone')
                    ->label(__('Phone'))
                    ->toggleable()
                    ->searchable(true, null, true)
                    ->limit(50),
                Tables\Columns\TextColumn::make('description')
                    ->label(__('Description'))
                    ->toggleable()
                    ->searchable()
                    ->limit(50),
                Tables\Columns\ImageColumn::make('image')
                    ->label(__('Image'))
                    ->toggleable()
                    ->circular(),
            ])
            ->filters([DateRangeFilter::make('created_at')]);
    }

    public static function getRelations(): array
    {
        return [];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListTenantRequests::route('/'),
            'create' => Pages\CreateTenantRequest::route('/create'),
            'view' => Pages\ViewTenantRequest::route('/{record}'),
            'edit' => Pages\EditTenantRequest::route('/{record}/edit'),
        ];
    }
}
