{{-- A clickable column heading for the order list. $column is a key of Order::SORTABLE. --}}
@php
    $currentSort = is_string(request('sort')) && array_key_exists(request('sort'), \App\Models\Order::SORTABLE) ? request('sort') : 'id';
    $currentDirection = request('direction') === 'asc' ? 'asc' : 'desc';
    $active = $currentSort === $column;

    // A new column starts newest first for id and date, A to Z otherwise
    $direction = $active
        ? ($currentDirection === 'asc' ? 'desc' : 'asc')
        : (in_array($column, ['id', 'date']) ? 'desc' : 'asc');
@endphp
<th @if ($active) aria-sort="{{ $currentDirection === 'asc' ? 'ascending' : 'descending' }}" @endif>
    <a href="{{ request()->fullUrlWithQuery(['sort' => $column, 'direction' => $direction]) }}" style="color: inherit; white-space: nowrap">
        {{ $label }}
        @if ($active)
        <span aria-hidden="true">{{ $currentDirection === 'asc' ? '▲' : '▼' }}</span>
        @endif
    </a>
</th>
