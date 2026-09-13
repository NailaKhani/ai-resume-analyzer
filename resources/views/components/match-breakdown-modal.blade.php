@props(['candidate'])

<div x-data="{ open: false }" @open-modal-{{ $candidate->id }}.window="open = true">
    <!-- Trigger Button (Invisible, triggered via JS) -->
    
    <!-- Modal Backdrop -->
    <div x-show="open" 
         style="display:none;position:fixed;inset:0;background:rgba(15,23,42,0.6);backdrop-filter:blur(4px);z-index:50;display:flex;align-items:center;justify-content:center;padding:1rem;"
         x-transition:enter="transition ease-out duration-200"
         x-transition:enter-start="opacity-0"
         x-transition:enter-end="opacity-100"
         x-transition:leave="transition ease-in duration-150"
         x-transition:leave-start="opacity-100"
         x-transition:leave-end="opacity-0">
        
        <!-- Modal Content -->
        <div @click.away="open = false" 
             style="background:white;width:100%;max-width:500px;border-radius:24px;box-shadow:0 25px 50px -12px rgba(0,0,0,0.25);overflow:hidden;position:relative;"
             x-transition:enter="transition ease-out duration-300 transform"
             x-transition:enter-start="opacity-0 translate-y-8 scale-95"
             x-transition:enter-end="opacity-100 translate-y-0 scale-100"
             x-transition:leave="transition ease-in duration-200 transform"
             x-transition:leave-start="opacity-100 translate-y-0 scale-100"
             x-transition:leave-end="opacity-0 translate-y-8 scale-95">
             
            <!-- Header -->
            <div style="padding:1.5rem 2rem;background:linear-gradient(135deg,#7C3AED,#C084FC);color:white;display:flex;justify-content:space-between;align-items:center;">
                <div>
                    <h3 style="margin:0;font-size:1.25rem;font-weight:800;">AI Analysis Breakdown</h3>
                    <p style="margin:0;font-size:0.85rem;opacity:0.9;">Match Score: {{ $candidate->match_score }}%</p>
                </div>
                <button @click="open = false" style="background:rgba(255,255,255,0.2);border:none;width:32px;height:32px;border-radius:50%;color:white;display:flex;align-items:center;justify-content:center;cursor:pointer;transition:background 0.2s;" onmouseover="this.style.background='rgba(255,255,255,0.3)'" onmouseout="this.style.background='rgba(255,255,255,0.2)'">
                    <svg width="20" height="20" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/></svg>
                </button>
            </div>

            <!-- Body -->
            <div style="padding:2rem;">
                
                <!-- Matched Skills -->
                <div style="margin-bottom:1.5rem;">
                    <h4 style="font-size:0.9rem;font-weight:700;color:#374151;margin:0 0 0.75rem;display:flex;align-items:center;gap:0.5rem;">
                        <svg width="18" height="18" fill="none" stroke="#059669" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                        Skills Found
                    </h4>
                    <div style="display:flex;flex-wrap:wrap;gap:0.5rem;">
                        @forelse((array)$candidate->parsed_skills as $skill)
                            <span style="padding:0.35rem 0.85rem;background:#d1fae5;color:#065f46;border-radius:8px;font-size:0.8rem;font-weight:700;border:1px solid #a7f3d0;">{{ $skill }}</span>
                        @empty
                            <span style="font-size:0.85rem;color:#94a3b8;">No exact matches found.</span>
                        @endforelse
                    </div>
                </div>

                <!-- Missing Skills -->
                <div style="margin-bottom:1.5rem;">
                    <h4 style="font-size:0.9rem;font-weight:700;color:#374151;margin:0 0 0.75rem;display:flex;align-items:center;gap:0.5rem;">
                        <svg width="18" height="18" fill="none" stroke="#dc2626" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                        Missing Skills
                    </h4>
                    <div style="display:flex;flex-wrap:wrap;gap:0.5rem;">
                        @forelse((array)$candidate->missing_skills as $skill)
                            <span style="padding:0.35rem 0.85rem;background:#fee2e2;color:#991b1b;border-radius:8px;font-size:0.8rem;font-weight:700;border:1px solid #fecaca;">{{ $skill }}</span>
                        @empty
                            <span style="font-size:0.85rem;color:#059669;font-weight:600;">Perfect match! All required skills found.</span>
                        @endforelse
                    </div>
                </div>

                <!-- AI Advice -->
                @if($candidate->ai_advice)
                <div style="padding:1.25rem;background:#faf5ff;border:1px solid #ede9fe;border-radius:12px;">
                    <h4 style="font-size:0.85rem;font-weight:800;color:#7C3AED;margin:0 0 0.5rem;text-transform:uppercase;letter-spacing:0.05em;">AI Recommendation</h4>
                    <p style="margin:0;font-size:0.9rem;color:#475569;line-height:1.5;">{{ $candidate->ai_advice }}</p>
                </div>
                @endif
                
            </div>
        </div>
    </div>
</div>
