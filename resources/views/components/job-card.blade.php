@props(['job', 'role' => 'candidate'])

<div class="job-card">
    <div style="display:flex;justify-content:space-between;align-items:flex-start;margin-bottom:1rem;">
        <div style="width:48px;height:48px;background:linear-gradient(135deg,#7C3AED,#C084FC);border-radius:12px;display:flex;align-items:center;justify-content:center;color:white;font-weight:900;font-size:1.2rem;box-shadow:0 4px 12px rgba(124,58,237,0.3);">
            {{ strtoupper(substr($job->title, 0, 1)) }}
        </div>
        @php
            $lvl = $job->experience_level ?? 'mid';
            $badgeClass = ['entry'=>'badge-entry','mid'=>'badge-mid','senior'=>'badge-senior'][$lvl] ?? '';
        @endphp
        <span class="badge {{ $badgeClass }}">{{ ucfirst($lvl) }}</span>
    </div>
    
    <h3 style="font-size:1.1rem;font-weight:800;color:#1e1b4b;margin:0 0 0.5rem;line-height:1.3;">
        {{ $job->title }}
    </h3>
    
    <div style="display:flex;align-items:center;gap:0.5rem;margin-bottom:1rem;color:#64748b;font-size:0.82rem;">
        <svg width="14" height="14" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
        {{ $job->created_at->diffForHumans() }}
    </div>

    <div style="display:flex;flex-wrap:wrap;gap:0.4rem;margin-bottom:1.5rem;">
        @foreach(array_slice(explode(',', $job->required_skills), 0, 3) as $skill)
            <span style="padding:3px 10px;background:#f8fafc;border:1px solid #e2e8f0;border-radius:6px;font-size:0.75rem;color:#475569;font-weight:600;">
                {{ trim($skill) }}
            </span>
        @endforeach
    </div>
    
    <div style="margin-top:auto;display:flex;justify-content:space-between;align-items:center;padding-top:1rem;border-top:1px solid #f1f5f9;">
        @if($role === 'hr')
            <span style="font-size:0.85rem;font-weight:700;color:#7C3AED;">
                {{ $job->candidates()->count() }} Applicants
            </span>
            <a href="{{ route('jobs.show', $job) }}" style="font-size:0.85rem;font-weight:700;color:#1e1b4b;text-decoration:none;">Manage</a>
        @else
            <a href="{{ route('jobs.show', $job) }}" style="width:100%;text-align:center;padding:0.6rem;background:#faf5ff;color:#7C3AED;border-radius:8px;font-weight:700;font-size:0.85rem;text-decoration:none;transition:background 0.2s;" onmouseover="this.style.background='#ede9fe'" onmouseout="this.style.background='#faf5ff'">
                View & Apply
            </a>
        @endif
    </div>
</div>
