<section class="category-section centred">
    <div class="auto-container">
        <div class="sec-title text-center mb-5">
            <h5>Nos catégories</h5>
            <h2>Types de propriétés</h2>
        </div>
        <div class="inner-container wow slideInLeft animated" data-wow-delay="00ms" data-wow-duration="1500ms">
            <ul class="category-list clearfix">
                @php
                    // Définir les icônes pour chaque type de propriété
                    $icons = ['icon-1', 'icon-2', 'icon-3', 'icon-4', 'icon-5', 'icon-6', 'icon-7', 'icon-8'];
                    
                    // Trier les types de propriétés par nom
                    $sortedTypes = $propertyTypes->sortBy('type_name');
                    $i = 0;
                @endphp
                
                @foreach($sortedTypes as $type)
                    @php
                        // Compter le nombre de propriétés pour ce type
                        $count = \App\Models\Property::where('ptype_id', $type->id)
                            ->where('status', 1)
                            ->count();
                        
                        // Sélectionner une icône (en boucle si nécessaire)
                        $icon = $icons[$i % count($icons)];
                        $i++;
                    @endphp
                    <li class="category-item">
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
            <div class="more-btn mt-4"><a href="{{ route('property.list') }}" class="theme-btn btn-one">Voir toutes les catégories</a></div>
        </div>
    </div>
</section>

<style>
    /* Styles améliorés pour la section catégories */
    .category-section {
        padding: 70px 0;
        background-color: #f7f7f7;
    }
    
    .category-section .sec-title {
        margin-bottom: 40px;
    }
    
    .category-section .sec-title h5 {
        color: #2dbe6c;
        font-size: 18px;
        font-weight: 500;
        text-transform: uppercase;
        margin-bottom: 10px;
    }
    
    .category-section .sec-title h2 {
        font-size: 36px;
        font-weight: 700;
        color: #0a0a0a;
    }
    
    .category-list {
        display: flex;
        flex-wrap: wrap;
        justify-content: center;
        margin: 0 -15px;
    }
    
    .category-item {
        width: 20%;
        padding: 0 15px;
        margin-bottom: 30px;
    }
    
    .category-block-one {
        background-color: #fff;
        border-radius: 10px;
        box-shadow: 0 5px 20px rgba(0, 0, 0, 0.05);
        transition: all 0.3s ease;
        height: 100%;
    }
    
    .category-block-one:hover {
        transform: translateY(-10px);
        box-shadow: 0 15px 30px rgba(0, 0, 0, 0.1);
    }
    
    .category-block-one .inner-box {
        padding: 30px 20px;
        text-align: center;
        height: 100%;
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
    }
    
    .category-block-one .icon-box {
        width: 70px;
        height: 70px;
        line-height: 70px;
        text-align: center;
        background-color: #f2f5fa;
        border-radius: 50%;
        margin: 0 auto 20px;
        transition: all 0.3s ease;
    }
    
    .category-block-one:hover .icon-box {
        background-color: #2dbe6c;
    }
    
    .category-block-one .icon-box i {
        font-size: 30px;
        color: #2dbe6c;
        transition: all 0.3s ease;
    }
    
    .category-block-one:hover .icon-box i {
        color: #fff;
    }
    
    .category-block-one h5 {
        font-size: 18px;
        font-weight: 600;
        margin-bottom: 10px;
    }
    
    .category-block-one h5 a {
        color: #0a0a0a;
        transition: all 0.3s ease;
    }
    
    .category-block-one:hover h5 a {
        color: #2dbe6c;
    }
    
    .category-block-one span {
        display: inline-block;
        font-size: 16px;
        font-weight: 500;
        color: #2dbe6c;
        background-color: rgba(45, 190, 108, 0.1);
        padding: 5px 15px;
        border-radius: 20px;
    }
    
    /* Responsive */
    @media (max-width: 1199px) {
        .category-item {
            width: 25%;
        }
    }
    
    @media (max-width: 991px) {
        .category-item {
            width: 33.33%;
        }
    }
    
    @media (max-width: 767px) {
        .category-item {
            width: 50%;
        }
    }
    
    @media (max-width: 480px) {
        .category-item {
            width: 100%;
        }
    }
</style>