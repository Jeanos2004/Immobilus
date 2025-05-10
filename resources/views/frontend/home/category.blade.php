<section class="category-section centred">
    <div class="auto-container">
        <div class="inner-container wow slideInLeft animated" data-wow-delay="00ms" data-wow-duration="1500ms">
            <ul class="category-list clearfix">
                @php
                    // Définir les icônes pour chaque type de propriété
                    $icons = ['icon-1', 'icon-2', 'icon-3', 'icon-4', 'icon-5', 'icon-6', 'icon-7', 'icon-8'];
                    $i = 0;
                @endphp
                
                @foreach($propertyTypes as $type)
                    @php
                        // Compter le nombre de propriétés pour ce type
                        $count = \App\Models\Property::where('type_id', $type->id)
                            ->where('status', 1)
                            ->count();
                        
                        // Sélectionner une icône (en boucle si nécessaire)
                        $icon = $icons[$i % count($icons)];
                        $i++;
                    @endphp
                    <li>
                        <div class="category-block-one">
                            <div class="inner-box">
                                <div class="icon-box"><i class="{{ $icon }}"></i></div>
                                <h5><a href="{{ route('property.type', $type->id) }}">{{ $type->type_name }}</a></h5>
                                <span>{{ $count }}</span>
                            </div>
                        </div>
                    </li>
                @endforeach
            </ul>
            <div class="more-btn"><a href="{{ route('property.list') }}" class="theme-btn btn-one">{{ __('messages.all_categories') }}</a></div>
        </div>
    </div>
</section>