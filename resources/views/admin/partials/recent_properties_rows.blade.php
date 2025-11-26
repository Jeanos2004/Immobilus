@forelse($recentProperties as $property)
<tr>
  <td>{{ $property->id }}</td>
  <td>
    <a href="{{ route('property.details', [$property->id, Str::slug($property->property_name)]) }}" target="_blank">{{ $property->property_name }}</a>
  </td>
  <td>{{ $property->type->type_name ?? 'N/A' }}</td>
  <td>{{ currency_gnf($property->lowest_price) }}</td>
  <td>
    @if($property->status == 1)
      <span class="badge bg-success">Actif</span>
    @else
      <span class="badge bg-danger">Inactif</span>
    @endif
  </td>
  <td>{{ $property->user->name ?? 'N/A' }}</td>
</tr>
@empty
<tr>
  <td colspan="6" class="text-center">Aucune propriété disponible</td>
</tr>
@endforelse


