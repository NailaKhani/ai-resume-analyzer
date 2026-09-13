@props(['title', 'value', 'icon', 'color' => '#7C3AED'])

<div class="glass-panel" style="padding:1.5rem;display:flex;align-items:center;gap:1.25rem;">
    <div style="width:52px;height:52px;border-radius:14px;background:linear-gradient(135deg,{{ $color }}30,{{ $color }}10);display:flex;align-items:center;justify-content:center;color:{{ $color }};flex-shrink:0;">
        {{ $icon }}
    </div>
    <div>
        <p style="color:#64748b;font-size:0.875rem;font-weight:600;margin:0 0 0.25rem;text-transform:uppercase;letter-spacing:0.05em;">{{ $title }}</p>
        <p style="font-size:1.75rem;font-weight:900;color:#1e1b4b;margin:0;line-height:1;">{{ $value }}</p>
    </div>
</div>
