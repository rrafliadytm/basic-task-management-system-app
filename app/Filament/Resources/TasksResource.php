<?php

namespace App\Filament\Resources;

use App\Filament\Resources\TasksResource\Pages;
use App\Filament\Resources\TasksResource\RelationManagers;
use App\Models\Tasks;
use App\Models\categories;
use App\Models\priorities;
use App\Models\User;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use LimitIterator;
use Illuminate\Contracts\Support\Htmlable;



class TasksResource extends Resource
{
    protected static ?string $modelLabel = 'Task Management';
    protected static ?string $navigationLabel = 'Task Management';

    protected static ?string $model = Tasks::class;
    protected static ?string $navigationIcon = 'heroicon-o-briefcase';

    // Form View
    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('title')
                    ->required()
                    ->maxLength(255),
                Forms\Components\Textarea::make('description')
                    ->maxLength(255)
                    ->columnSpan('full'),
                Forms\Components\DatePicker::make('deadline')
                    ->required(),
                Forms\Components\Select::make('status')
                    ->label('Select Status')
                    ->options([
                        'Pending' => 'Pending',
                        'In-Progress' => 'In-Progress',
                        'Completed' => 'Completed',
                    ])
                    ->required()
                    ->default('Pending'),
                Forms\Components\Select::make('category_id')
                    ->label('Select Category')
                    ->required()
                    ->options(categories::query()->pluck('name', 'id'))
                    ->searchable()
                    ->preload(),
                Forms\Components\Select::make('priority_id')
                    ->label('Select Priority')
                    ->required()
                    ->options(priorities::query()->orderBy('id', 'asc')->pluck('name', 'id'))
                    ->preload(),
                Forms\Components\Select::make('user_id')
                    ->label('Username')
                    ->relationship('users', 'name')
                    ->searchable()
                    ->preload()
                    ->createOptionForm([
                        Forms\Components\TextInput::make('name')
                            ->required()
                            ->maxLength(255),
                        Forms\Components\TextInput::make('email')
                            ->label('Email address')
                            ->email()
                            ->required()
                            ->maxLength(255),
                        Forms\Components\TextInput::make('password')
                            ->label('Password')
                            ->password()
                            ->required()
                            ->minLength(3)
                            ->maxLength(8)
                            ->revealable() // Toggle visibility of the password field
                            ->dehydrateStateUsing(fn ($state) => bcrypt($state))
                            ->visible(fn (Forms\Get $get) => $get('id') === null), // Only show password field when creating a new user
                    ])
                    ->required(),
        ]);
    }

    // Tables View
    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('title')
                    ->searchable(),
                Tables\Columns\TextColumn::make('deadline')
                    ->date()
                    ->sortable(),
                Tables\Columns\TextColumn::make('status'),
                Tables\Columns\TextColumn::make('categories.name')
                    ->label('Category')
                    ->searchable(),
                Tables\Columns\TextColumn::make('priorities.name')
                    ->label('Priority')
                    ->searchable(),
                Tables\Columns\TextColumn::make('users.name')
                    ->label('Username')
                    ->searchable(),
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])

            // Filters
            ->filters([
                Tables\Filters\SelectFilter::make('status')
                    ->label('Select Status')
                    ->options([
                        'Pending' => 'Pending',
                        'In-Progress' => 'In-Progress',
                        'Completed' => 'Completed',
                    ]),
                Tables\Filters\SelectFilter::make('category_id')
                    ->label('Select Category')
                    ->options(categories::query()->pluck('name', 'id')),
                Tables\Filters\SelectFilter::make('priority_id')
                    ->label('Select Priority')
                    ->options(priorities::query()->pluck('name', 'id')),
                Tables\Filters\SelectFilter::make('user_id')
                    ->label('Select Username')
                    ->options(User::query()->pluck('name', 'id'))
            ])

            // Actions
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])

            // Bulk Actions
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
            'index' => Pages\ListTasks::route('/'),
            'create' => Pages\CreateTasks::route('/create'),
            'edit' => Pages\EditTasks::route('/{record}/edit'),
        ];
    }

}
