<?php

namespace App\Filament\Pages;

use App\Models\City;
use App\Models\Department;
use App\Models\Sale;
use App\Models\Segmentation;
use Filament\Pages\Page;
use Filament\Tables\Table;
use App\Models\SegmentRegister;
use Filament\Tables\Filters\Filter;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Contracts\HasTable;  // Añade esta interfaz
use Filament\Tables\Concerns\InteractsWithTable; // Añade este trait


class TableSegmentionsPage extends Page implements HasTable
{
    use InteractsWithTable;

    protected static ?string $navigationIcon = 'heroicon-o-document-text';

    protected static string $view = 'filament.pages.table-segmentions-page';

    protected static ?string $title = 'Tabla de Segmentaciones';
    protected static ?string $model = Sale::class;


    public $data;

    /* public function mount()
    {
        $this->data = SegmentRegister::latest()->with(['segment', 'sale.customer', 'sale.shop', 'sale.seller', 'sale.paymentMethod', 'sale.returnAlert'])->get();

    } */

    public function table(Table $table): Table
    {
        return $table
            ->query(
                SegmentRegister::query()
                    ->latest()
                    ->with(['segment', 'sale.customer', 'sale.shop', 'sale.seller', 'sale.paymentMethod', 'sale.returnAlert'])
            )
            ->columns([
                TextColumn::make('segment.type')
                    ->label('Seg'),
                TextColumn::make('sale.customer.customer_name')
                    ->label('Cliente'),
                TextColumn::make('sale.customer.first_name')
                    ->label('Primer Nombre'),
                TextColumn::make('sale.customer.phone')
                    ->label('Telefón'),
                TextColumn::make('sale.customer.email')
                    ->label('Correo'),
                TextColumn::make('sale.customer.city.name')
                    ->label('Ciudad'),
                TextColumn::make('sale.customer.city.department.name')
                    ->label('Departamento'),
                TextColumn::make('sale.orders_number')
                    ->label('Ordenes'),
                TextColumn::make('sale.number_entries')
                    ->label('Entradas'),
                TextColumn::make('sale.returns_number')
                    ->label('Devoluciones'),
                TextColumn::make('sale.last_order_date_delivered')
                    ->label('Fecha de entrega'),
                TextColumn::make('sale.last_order_date_delivered')
                    ->label('Fecha de entrega'),
                TextColumn::make('sale.last_order_date_delivered')
                    ->label('Fecha de entrega'),
                TextColumn::make('sale.total_revenues')
                    ->label('Ingresos'),
                TextColumn::make('sale.return_value')
                    ->label('Valor devoluciones'),
                TextColumn::make('sale.paymentMethod.name')
                    ->label('Método de pago'),
                TextColumn::make('sale.seller.name')
                    ->label('Vendedor'),
                TextColumn::make('sale.customer.is_frequent_customer')
                    ->label('Es común'),
                TextColumn::make('sale.shop.name')
                    ->label('Tienda'),
                TextColumn::make('sale.last_item_purchased')
                    ->label('Último item comprado'),
                TextColumn::make('sale.last_item_purchased')
                    ->label('Antepenúltimo item comprado'),
                TextColumn::make('sale.last_days_purchase_days')
                    ->label('Días desde última compra'),
                TextColumn::make('sale.returnAlert.type')
                    ->label('Alerta de Devolución'),
            ])
            ->filters([
                SelectFilter::make('segment.type')
                ->label('Seg')
                ->options(Segmentation::all()->pluck('type', 'type')),
                SelectFilter::make('sale.customer.customer_name')
                ->label('Cliente'),
                SelectFilter::make('sale.customer.city.name')
                ->label('Ciudad')
                ->options(City::all()->pluck('name', 'id')),
                SelectFilter::make('sale.customer.city.department.name')
                ->label('Departamento')
                    ->options(Department::all()->pluck('name', 'name')),
            ]);
    }
}