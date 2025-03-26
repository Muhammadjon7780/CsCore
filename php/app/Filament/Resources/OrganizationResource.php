<?php

namespace App\Filament\Resources;

use App\Filament\Resources\OrganizationResource\Pages;
use App\Models\Organization;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;

class OrganizationResource extends Resource
{
    protected static ?string $model = Organization::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('name')
                ->required()
                ->maxLength(255),

            Forms\Components\Textarea::make('address')
                ->required(),


            Forms\Components\TextInput::make('contact_email')
                ->email()
                ->unique(table: 'organizations', column: 'contact_email', ignoreRecord: true)
                ->required(),


            Forms\Components\Select::make('status')
                ->options([
                    'active' => 'Active',
                    'blocked' => 'Blocked',
                ])
                ->default('active')
                ->required(),

            Forms\Components\Select::make('default_language')
                ->options([
                    'UZ' => 'Uzbek',
                    'RU' => 'Russian',
                    'ENG' => 'English',
                ])
                ->default('ENG')
                ->required(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
            Tables\Columns\TextColumn::make('name')->sortable()->searchable(),
            Tables\Columns\TextColumn::make('address')->limit(50),
            Tables\Columns\TextColumn::make('contact_email'),
            Tables\Columns\TextColumn::make('status')
                ->badge()
                ->colors([
                    'active' => 'success',
                    'blocked' => 'danger',
                ]),
            Tables\Columns\TextColumn::make('default_language'),
            Tables\Columns\TextColumn::make('created_at')->dateTime(),
            ])
            ->filters([
            SelectFilter::make('status')
                ->options([
                    'active' => 'Active',
                    'blocked' => 'Blocked',
                ]),
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
            'index' => Pages\ListOrganizations::route('/'),
            'create' => Pages\CreateOrganization::route('/create'),
            'edit' => Pages\EditOrganization::route('/{record}/edit'),
        ];
    }
}
