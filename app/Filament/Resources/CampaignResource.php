<?php

namespace App\Filament\Resources;


use Closure;
use Filament\Forms;
use App\Models\City;
use App\Models\Shop;
use Filament\Tables;
use App\Models\Block;
use App\Models\Seller;
use App\Enum\EventEnum;
use App\Models\Country;
use Filament\Forms\Get;
use App\Models\Campaign;
use App\Models\Template;
use Filament\Forms\Form;
use App\Enum\UserTypeEnum;
use App\Models\Department;
use Filament\Tables\Table;
use App\Models\ReturnAlert;
use App\Models\SegmentType;
use App\Models\Segmentation;
use App\Models\PaymentMethod;
use App\Enum\TypeCampaignEnum;
use Filament\Resources\Resource;
use App\Enum\TypeSegmentationEnum;
use App\Enum\EventProductoPolisEnum;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\DatePicker;
use Illuminate\Database\Eloquent\Builder;
use Filament\Forms\Components\DateTimePicker;
use App\Filament\Resources\CampaignResource\Pages;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Filament\Resources\CampaignResource\RelationManagers;

class CampaignResource extends Resource
{
    protected static ?string $model = Campaign::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    protected static ?string $navigationGroup = 'Configuraciones';

    protected static ?string $pluralModelLabel = 'Campañas';

    protected static ?string $modelLabel = 'Campaña';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Section::make('Campaña')
                    ->collapsible()
                    ->columns([
                        'sm' => 3,
                        'xl' => 4,
                        '2xl' => 12,
                    ])
                    ->description('Información de la campaña')
                    ->schema([
                        TextInput::make('name')
                            ->label('Campaña')
                            ->required()
                            ->maxLength(400)
                            ->columnSpan(12),
                        DatePicker::make('start_date')
                            ->label('Fecha de inicio')
                            ->required()
                            ->columnSpan(6),
                        DatePicker::make('end_date')
                            ->label('Fecha de finalización')
                            ->required()
                            ->columnSpan(6),
                    ]),

                Section::make('Segmentación de campañas')
                    ->collapsible()
                    ->description('Seleccionar tipo de campaña')
                    ->schema([
                        Select::make('type_campaign')
                            ->label('Tipo de campaña')
                            ->enum(TypeCampaignEnum::class)
                            ->required()
                            ->options(TypeCampaignEnum::class)
                            ->live()
                    ]),

                Section::make('Filtros de segmentación')
                    ->collapsible()
                    ->description('Agregar filtros a la segmentación para productopolis')
                    ->schema([
                        Section::make('Información del segmento')
                            ->columns([
                                'sm' => 3,
                                'xl' => 4,
                                '2xl' => 8,
                            ])
                            ->schema([
                                Select::make('filters.payment_method_id')
                                    ->label('Método de pago')
                                    ->options(PaymentMethod::all()->pluck('name', 'id'))
                                    //->searchable()
                                    ->preload()
                                    ->columnSpan([
                                        'sm' => 2,
                                        'xl' => 3,
                                        '2xl' => 4,
                                    ]),

                                Select::make('filters.alert_id')
                                    ->label('Alertas de devolución')
                                    ->options(ReturnAlert::all()->pluck('type', 'id'))
                                    ->preload()
                                    ->columnSpan([
                                        'sm' => 2,
                                        'xl' => 3,
                                        '2xl' => 4,
                                    ]),
                                Select::make('filters.department_id')
                                    ->label('Departamento')
                                    //->searchable()
                                    ->preload()
                                    ->options(Department::all()->pluck('name', 'id'))
                                    ->columnSpan([
                                        'sm' => 2,
                                        'xl' => 3,
                                        '2xl' => 4,
                                    ]),

                                Select::make('filters.city_id')
                                    ->label('Ciudad')
                                    //->searchable()
                                    ->preload()
                                    ->options(City::all()->pluck('name', 'id'))
                                    ->columnSpan([
                                        'sm' => 2,
                                        'xl' => 3,
                                        '2xl' => 4,
                                    ]),

                                TextInput::make('filters.limit')
                                    ->label('Limite')
                                    ->columnSpan([
                                        'sm' => 2,
                                        'xl' => 3,
                                        '2xl' => 4,
                                    ]),
                                Select::make('filters.segment_type_id')
                                    ->label('Tipo de Segmento')
                                    //->searchable()
                                    ->preload()
                                    ->options(SegmentType::all()->pluck('name', 'id'))
                                    ->columnSpan([
                                        'sm' => 2,
                                        'xl' => 3,
                                        '2xl' => 4,
                                    ]),

                                Select::make('filters.seller_id')
                                    ->label('Vendedor')
                                    //->searchable()
                                    ->preload()
                                    ->options(Seller::all()->pluck('name', 'id'))
                                    ->columnSpan([
                                        'sm' => 2,
                                        'xl' => 3,
                                        '2xl' => 4,
                                    ]),

                                Select::make('filters.shop_id')
                                    ->label('Tienda')
                                    //->searchable()
                                    ->preload()
                                    ->options(Shop::all()->pluck('name', 'id'))
                                    ->columnSpan([
                                        'sm' => 2,
                                        'xl' => 3,
                                        '2xl' => 4,
                                    ]),
                                DatePicker::make('filters.date_first_order')
                                    ->label('Fecha de inicio')
                                    ->columnSpan([
                                        'sm' => 2,
                                        'xl' => 3,
                                        '2xl' => 4,
                                    ]),
                                DatePicker::make('filters.date_last_order')
                                    ->label('Fecha de finalización')
                                    ->columnSpan([
                                        'sm' => 2,
                                        'xl' => 3,
                                        '2xl' => 4,
                                    ]),

                            ]),
                    ])
                    ->visible(fn($get) => $get('type_campaign') === TypeCampaignEnum::ProductoPolis->value),
                Section::make('Bloques')
                    ->collapsible()
                    ->description('Agregar bloques a la campaña')
                    ->schema([
                        Repeater::make('blocks')
                            ->collapsible()
                            ->relationship('blocks')
                            ->label('Bloques')
                            ->schema(Block::getForm())
                            ->columnSpan(12),
                    ])
                    ->visible(fn($get) => $get('type_campaign') === TypeCampaignEnum::ProductoPolis->value),

                Section::make('Filtros de segmentación')
                    ->collapsible()
                    ->description('Agregar filtros a la segmentación para Medical')
                    ->schema([
                        Section::make('Información del segmento')
                            ->columns([
                                'sm' => 3,
                                'xl' => 4,
                                '2xl' => 8,
                            ])
                            ->schema([
                                Select::make('filters.country')
                                    ->label('País')
                                    ->options(Country::all()->pluck('name', 'name'))
                                    ->preload()
                                    ->columnSpan([
                                        'sm' => 2,
                                        'xl' => 3,
                                        '2xl' => 4,
                                    ]),

                                Select::make('filters.is_lead')
                                    ->label('Tipo de Usuario')
                                    ->Enum(UserTypeEnum::class)
                                    ->options(UserTypeEnum::class)
                                    ->preload()

                                    ->columnSpan([
                                        'sm' => 2,
                                        'xl' => 3,
                                        '2xl' => 4,
                                    ]),

                                Select::make('filters.event')
                                    ->label('Criterio de entrada')
                                    ->enum(EventEnum::class)
                                    ->options(EventEnum::class)
                                    ->columnSpan([
                                        'sm' => 2,
                                        'xl' => 3,
                                        '2xl' => 4,
                                    ]),

                                Toggle::make('filters.exists')
                                    ->label('Confirmación')
                                    ->inline(false)
                                    ->columnSpan([
                                        'sm' => 2,
                                        'xl' => 3,
                                        '2xl' => 4,
                                    ]),

                                Select::make('filters.exit_criterion')
                                    ->label('Criterio de salida')
                                    ->enum(EventEnum::class)
                                    ->options(EventEnum::class)
                                    ->reactive()
                                    ->columnSpan([
                                        'sm' => 2,
                                        'xl' => 3,
                                        '2xl' => 4,
                                    ]),

                                Toggle::make('filters.next_step_executed')
                                    ->label('Ejecutado')
                                    ->inline(false)
                                    ->columnSpan([
                                        'sm' => 2,
                                        'xl' => 3,
                                        '2xl' => 4,
                                    ]),


                                DatePicker::make('filters.created_since')
                                    ->label('Creado desde')
                                    ->columnSpan([
                                        'sm' => 2,
                                        'xl' => 3,
                                        '2xl' => 4,
                                    ]),

                                DatePicker::make('filters.start_date')
                                    ->label('Fecha de inicio de evento')
                                    ->columnSpan([
                                        'sm' => 2,
                                        'xl' => 3,
                                        '2xl' => 4,
                                    ]),
                                DatePicker::make('filters.end_date')
                                    ->label('Fecha de finalización de evento')
                                    ->columnSpan([
                                        'sm' => 2,
                                        'xl' => 3,
                                        '2xl' => 4,
                                    ]),

                            ]),
                    ])
                    ->visible(fn($get) => $get('type_campaign') === TypeCampaignEnum::Medical->value),

                Section::make('Bloques')
                    ->collapsible()
                    ->description('Agregar bloques a la campaña')
                    ->schema([
                        Repeater::make('blocks')
                            ->collapsible()
                            ->relationship('blocks')
                            ->label('Bloques')
                            ->schema(Block::getForm(fn ($get) => [
                                'exit_criterion' => $get('filters.exit_criterion'),
                            ]))
                            ->columnSpan(12)
                            
                    ])
                    ->visible(fn($get) => $get('type_campaign') === TypeCampaignEnum::Medical->value),

            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name')
                    ->label('Campaña')
                    ->searchable(),
                Tables\Columns\TextColumn::make('start_date')
                    ->label('Fecha de inicio')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('end_date')
                    ->label('Fecha de finalización')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListCampaigns::route('/'),
            'create' => Pages\CreateCampaign::route('/create'),
            'edit' => Pages\EditCampaign::route('/{record}/edit'),
        ];
    }
}
