

                            Block::make(PageLayoutTypesEnum::IMAGE_GALLERY->value)
                                ->schema([
                                    TextInput::make('text'),
                                    FileUpload::make('images')
                                        ->panelLayout('grid')
                                        ->directory('page-builder')
                                        ->multiple()
                                        ->reorderable()
                                        ->image()
                                        ->required()
                                        ->disk(config('filament-page-builder.disk')),

                                    TextInput::make('button-text'),
                                    TextInput::make('button-path'),
                                ]),

                            Block::make(PageLayoutTypesEnum::IMAGE_CARDS->value)
                                ->schema([
                                    Repeater::make('group')->schema([
                                        TextInput::make('text'),
                                        FileUpload::make('image')
                                            ->directory('page-builder')
                                            ->panelLayout('grid')
                                            ->image()
                                            ->required()
                                            ->disk(config('filament-page-builder.disk')),
                                        TextInput::make('button-text'),
                                        TextInput::make('button-path'),
                                    ]),
                                ]),

                            Block::make(PageLayoutTypesEnum::HORIZONTAL_TICKER->value)
                                ->schema([
                                    TextInput::make('title')->nullable(),
                                    Repeater::make('group')
                                        ->schema([
                                            TextInput::make('title')
                                                ->required(),
                                            Textarea::make('description')
                                                ->nullable(),

                                            FileUpload::make('images')
                                                ->panelLayout('grid')
                                                ->directory('page-builder')
                                                ->multiple()
                                                ->reorderable()
                                                ->image()
                                                ->required()
                                                ->disk(config('filament-page-builder.disk')),
                                        ])
                                        ->columns(),
                                ]),

                            Block::make(PageLayoutTypesEnum::BANNER->value)
                                ->schema([
                                    TextInput::make('title')
                                        ->required(),
                                    TextInput::make('text')
                                        ->required(),
                                    FileUpload::make('image')
                                        ->panelLayout('grid')
                                        ->directory('page-builder')
                                        ->reorderable()
                                        ->image()
                                        ->disk(config('filament-page-builder.disk')),

                                    TextInput::make('button-text'),
                                    TextInput::make('button-path'),
                                ]),

                            Block::make(PageLayoutTypesEnum::RICH_TEXT_PAGE->value)
                                ->schema([
                                    TextInput::make('title')
                                        ->required(),
                                    RichEditor::make('content')
                                        ->required(),
                                ]),

                            Block::make(PageLayoutTypesEnum::KEY_VALUE_SECTION->value)
                                ->schema([
                                    Repeater::make('group')
                                        ->schema([
                                            TextInput::make('title')
                                                ->live(onBlur: true)
                                                ->afterStateUpdated(fn (Set $set, ?string $state) => $set('key', Str::slug($state)))
                                                ->required(),
                                            TextInput::make('key')
                                                ->readOnly(),
                                            RichEditor::make('description')
                                                ->required(),
                                            TextInput::make('hint')
                                                ->nullable(),
                                        ])->columns(),
                                ]),

                            Block::make(PageLayoutTypesEnum::MAP_LOCATION->value)
                                ->schema([
                                    TextInput::make('title')
                                        ->required(),
                                    TextInput::make('latitude')->required(),
                                    TextInput::make('longitude')->required(),
                                    TextInput::make('address'),
                                ]),

                            Block::make(PageLayoutTypesEnum::RELATIONSHIP_CONTENT->value)
                                ->schema([
                                    Select::make('relationship')
                                        ->options(collect(PageRelationshipTypeEnum::cases())->mapWithKeys(fn ($case) => [
                                            $case->value => $case->name,
                                        ]))
                                        ->required()
                                        ->searchable(),
                                ]),
                        