@props(['candidate'])

<div x-data="{ open: false }" 
     @open-modal-{{ $candidate->id }}.window="open = true" 
     @keydown.escape.window="open = false">
    
    <!-- Modal Overlay Backdrop -->
    <div x-show="open" 
         x-cloak
         style="position: fixed; inset: 0; z-index: 99999; background: rgba(15, 23, 42, 0.65); backdrop-filter: blur(4px); display: flex; align-items: center; justify-content: center; padding: 1rem;"
         x-transition:enter="transition ease-out duration-200"
         x-transition:enter-start="opacity-0"
         x-transition:enter-end="opacity-100"
         x-transition:leave="transition ease-in duration-150"
         x-transition:leave-start="opacity-100"
         x-transition:leave-end="opacity-0">
        
        <!-- Modal Card Container -->
        <div @click.outside="open = false" 
             style="background: white; width: 100%; max-width: 520px; border-radius: 24px; box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.35); overflow: hidden; position: relative;"
             x-transition:enter="transition ease-out duration-300 transform"
             x-transition:enter-start="opacity-0 translate-y-8 scale-95"
             x-transition:enter-end="opacity-100 translate-y-0 scale-100"
             x-transition:leave="transition ease-in duration-200 transform"
             x-transition:leave-start="opacity-100 translate-y-0 scale-100"
             x-transition:leave-end="opacity-0 translate-y-8 scale-95">
             
            <!-- Header -->
            <div style="padding: 1.5rem 2rem; background: linear-gradient(135deg, #4F46E5, #7C3AED); color: white; display: flex; justify-content: space-between; align-items: center;">
                <div>
                    <h3 style="margin: 0; font-size: 1.25rem; font-weight: 800;">AI Analysis Breakdown</h3>
                    <p style="margin: 0.2rem 0 0 0; font-size: 0.88rem; opacity: 0.95;">Candidate: {{ $candidate->user->name }} • Match Score: {{ number_format($candidate->match_score, 1) }}%</p>
                </div>
                <!-- Functional Close Button (Cross X) -->
                <button type="button" 
                        @click.stop="open = false" 
                        aria-label="Close modal"
                        style="background: rgba(255, 255, 255, 0.25); border: none; width: 36px; height: 36px; border-radius: 50%; color: white; display: flex; align-items: center; justify-content: center; cursor: pointer; transition: all 0.2s;" 
                        onmouseover="this.style.background='rgba(255, 255, 255, 0.4)'" 
                        onmouseout="this.style.background='rgba(255, 255, 255, 0.25)'">
                    <svg width="20" height="20" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/></svg>
                </button>
            </div>

            <!-- Body -->
            <div style="padding: 2rem;">
                
                <!-- Matched Skills -->
                <div style="margin-bottom: 1.5rem;">
                    <h4 style="font-size: 0.92rem; font-weight: 800; color: #1E293B; margin: 0 0 0.75rem; display: flex; align-items: center; gap: 0.5rem;">
                        <svg width="18" height="18" fill="none" stroke="#10B981" stroke-width="2.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                        Skills Found
                    </h4>
                    <div style="display: flex; flex-wrap: wrap; gap: 0.5rem;">
                        @forelse((array)$candidate->parsed_skills as $skill)
                            <span style="padding: 0.4rem 0.9rem; background: #D1FAE5; color: #065F46; border-radius: 8px; font-size: 0.82rem; font-weight: 700; border: 1px solid #A7F3D0;">{{ $skill }}</span>
                        @empty
                            <span style="font-size: 0.85rem; color: #94A3B8;">No exact skill matches found.</span>
                        @endforelse
                    </div>
                </div>

                <!-- Missing Skills -->
                <div style="margin-bottom: 1.5rem;">
                    <h4 style="font-size: 0.92rem; font-weight: 800; color: #1E293B; margin: 0 0 0.75rem; display: flex; align-items: center; gap: 0.5rem;">
                        <svg width="18" height="18" fill="none" stroke="#EF4444" stroke-width="2.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                        Missing Skills
                    </h4>
                    <div style="display: flex; flex-wrap: wrap; gap: 0.5rem;">
                        @forelse((array)$candidate->missing_skills as $skill)
                            <span style="padding: 0.4rem 0.9rem; background: #FEE2E2; color: #991B1B; border-radius: 8px; font-size: 0.82rem; font-weight: 700; border: 1px solid #FECACA;">{{ $skill }}</span>
                        @empty
                            <span style="font-size: 0.85rem; color: #10B981; font-weight: 700;">Perfect match! All required skills found.</span>
                        @endforelse
                    </div>
                </div>

                <!-- AI Advice -->
                @if($candidate->ai_advice)
                <div style="padding: 1.25rem; background: #EEF2FF; border: 1px solid #C7D2FE; border-radius: 14px; margin-bottom: 1.5rem;">
                    <h4 style="font-size: 0.82rem; font-weight: 800; color: #4F46E5; margin: 0 0 0.4rem; text-transform: uppercase; letter-spacing: 0.05em;">AI Recommendation</h4>
                    <p style="margin: 0; font-size: 0.9rem; color: #334155; line-height: 1.6;">{{ $candidate->ai_advice }}</p>
                </div>
                @endif

                <!-- Bottom Footer Action -->
                <div style="display: flex; justify-content: flex-end; padding-top: 1rem; border-top: 1px solid #E2E8F0;">
                    <button type="button" 
                            @click="open = false" 
                            style="padding: 0.6rem 1.4rem; background: #F1F5F9; color: #334155; border: 1px solid #CBD5E1; border-radius: 50px; font-size: 0.88rem; font-weight: 700; cursor: pointer; transition: background 0.2s;"
                            onmouseover="this.style.background='#E2E8F0'" 
                            onmouseout="this.style.background='#F1F5F9'">
                        Close
                    </button>
                </div>
                
            </div>
        </div>
    </div>
</div>
