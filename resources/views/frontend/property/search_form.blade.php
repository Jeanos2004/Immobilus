<div class="search-field-section">
    <div class="auto-container">
        <div class="inner-container">
            <div class="search-field">
                <div class="tabs-box">
                    <div class="tab-btn-box">
                        <ul class="tab-btns tab-buttons clearfix">
                            <li class="tab-btn active-btn" data-tab="#tab-1">À vendre</li>
                            <li class="tab-btn" data-tab="#tab-2">À louer</li>
                        </ul>
                    </div>
                    <div class="tabs-content info-group">
                        <div class="tab active-tab" id="tab-1">
                            <form action="{{ route('property.search') }}" method="GET" class="search-form">
                                <input type="hidden" name="status" value="à vendre">
                                <div class="row clearfix">
                                    <div class="col-lg-4 col-md-6 col-sm-12 column">
                                        <div class="form-group">
                                            <label>Rechercher une propriété</label>
                                            <div class="field-input">
                                                <i class="fas fa-search"></i>
                                                <input type="search" name="search" placeholder="Adresse, ville ou code postal...">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-4 col-md-6 col-sm-12 column">
                                        <div class="form-group">
                                            <label>Type de propriété</label>
                                            <div class="select-box">
                                                <select name="ptype_id" class="wide">
                                                    <option value="">Tous les types</option>
                                                    @foreach($propertyTypes as $type)
                                                    <option value="{{ $type->id }}">{{ $type->type_name }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-4 col-md-6 col-sm-12 column">
                                        <div class="form-group">
                                            <label>Fourchette de prix</label>
                                            <div class="select-box">
                                                <select name="price_range" class="wide">
                                                    <option value="">Tous les prix</option>
                                                    <option value="100000-300000">100 000€ - 300 000€</option>
                                                    <option value="300000-500000">300 000€ - 500 000€</option>
                                                    <option value="500000-800000">500 000€ - 800 000€</option>
                                                    <option value="800000-1000000">800 000€ - 1 000 000€</option>
                                                    <option value="1000000-0">Plus de 1 000 000€</option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-4 col-md-6 col-sm-12 column">
                                        <div class="form-group">
                                            <label>Chambres</label>
                                            <div class="select-box">
                                                <select name="bedrooms" class="wide">
                                                    <option value="">Toutes</option>
                                                    <option value="1">1+ chambre</option>
                                                    <option value="2">2+ chambres</option>
                                                    <option value="3">3+ chambres</option>
                                                    <option value="4">4+ chambres</option>
                                                    <option value="5">5+ chambres</option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-4 col-md-6 col-sm-12 column">
                                        <div class="form-group">
                                            <label>Salles de bain</label>
                                            <div class="select-box">
                                                <select name="bathrooms" class="wide">
                                                    <option value="">Toutes</option>
                                                    <option value="1">1+ salle de bain</option>
                                                    <option value="2">2+ salles de bain</option>
                                                    <option value="3">3+ salles de bain</option>
                                                    <option value="4">4+ salles de bain</option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-4 col-md-6 col-sm-12 column">
                                        <div class="form-group">
                                            <label>Équipements</label>
                                            <div class="select-box">
                                                <select name="amenities_id" class="wide">
                                                    <option value="">Tous</option>
                                                    @foreach($amenities as $amenity)
                                                    <option value="{{ $amenity->id }}">{{ $amenity->amenities_name }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="search-btn">
                                    <button type="submit" class="theme-btn btn-one"><i class="fas fa-search"></i>Rechercher</button>
                                </div>
                            </form>
                        </div>
                        <div class="tab" id="tab-2">
                            <form action="{{ route('property.search') }}" method="GET" class="search-form">
                                <input type="hidden" name="status" value="à louer">
                                <div class="row clearfix">
                                    <div class="col-lg-4 col-md-6 col-sm-12 column">
                                        <div class="form-group">
                                            <label>Rechercher une propriété</label>
                                            <div class="field-input">
                                                <i class="fas fa-search"></i>
                                                <input type="search" name="search" placeholder="Adresse, ville ou code postal...">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-4 col-md-6 col-sm-12 column">
                                        <div class="form-group">
                                            <label>Type de propriété</label>
                                            <div class="select-box">
                                                <select name="ptype_id" class="wide">
                                                    <option value="">Tous les types</option>
                                                    @foreach($propertyTypes as $type)
                                                    <option value="{{ $type->id }}">{{ $type->type_name }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-4 col-md-6 col-sm-12 column">
                                        <div class="form-group">
                                            <label>Fourchette de prix (mensuel)</label>
                                            <div class="select-box">
                                                <select name="price_range" class="wide">
                                                    <option value="">Tous les prix</option>
                                                    <option value="500-1000">500€ - 1 000€</option>
                                                    <option value="1000-1500">1 000€ - 1 500€</option>
                                                    <option value="1500-2000">1 500€ - 2 000€</option>
                                                    <option value="2000-3000">2 000€ - 3 000€</option>
                                                    <option value="3000-0">Plus de 3 000€</option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-4 col-md-6 col-sm-12 column">
                                        <div class="form-group">
                                            <label>Chambres</label>
                                            <div class="select-box">
                                                <select name="bedrooms" class="wide">
                                                    <option value="">Toutes</option>
                                                    <option value="1">1+ chambre</option>
                                                    <option value="2">2+ chambres</option>
                                                    <option value="3">3+ chambres</option>
                                                    <option value="4">4+ chambres</option>
                                                    <option value="5">5+ chambres</option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-4 col-md-6 col-sm-12 column">
                                        <div class="form-group">
                                            <label>Salles de bain</label>
                                            <div class="select-box">
                                                <select name="bathrooms" class="wide">
                                                    <option value="">Toutes</option>
                                                    <option value="1">1+ salle de bain</option>
                                                    <option value="2">2+ salles de bain</option>
                                                    <option value="3">3+ salles de bain</option>
                                                    <option value="4">4+ salles de bain</option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-4 col-md-6 col-sm-12 column">
                                        <div class="form-group">
                                            <label>Équipements</label>
                                            <div class="select-box">
                                                <select name="amenities_id" class="wide">
                                                    <option value="">Tous</option>
                                                    @foreach($amenities as $amenity)
                                                    <option value="{{ $amenity->id }}">{{ $amenity->amenities_name }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="search-btn">
                                    <button type="submit" class="theme-btn btn-one"><i class="fas fa-search"></i>Rechercher</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
