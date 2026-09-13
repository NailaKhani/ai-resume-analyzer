@props(['status'])

@php
    $colors = [
        'Pending' => 'background:#f1f5f9;color:#475569;border-color:#e2e8f0',
        'Screened' => 'background:#e0f2fe;color:#0369a1;border-color:#bae6fd',
        'Shortlisted' => 'background:#fef3c7;color:#b45309;border-color:#fde68a',
        'Interviewed' => 'background:#ede9fe;color:#6d28d9;border-color:#ddd6fe',
        'Rejected' => 'background:#fee2e2;color:#b91c1c;border-color:#fecaca',
    ];
    $style = $colors[$status] ?? $colors['Pending'];
@endphp

<span style="display:inline-flex;align-items:center;padding:0.25rem 0.75rem;border-radius:99px;font-size:0.75rem;font-weight:700;border:1px solid;{{ $style }}">
    {{ $status }}
</span>
