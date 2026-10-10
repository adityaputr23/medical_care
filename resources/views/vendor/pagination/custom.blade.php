@if ($paginator->hasPages())
    <nav role="navigation" aria-label="Pagination Navigation" style="display:flex; align-items:center; justify-content:space-between; flex-wrap:wrap; gap:12px; margin-top:20px; padding-top:16px; border-top:1px solid var(--border-color, #e2e8f0);">
        
        {{-- Info teks --}}
        <p style="font-size:13px; color:var(--gray-400, #94a3b8); font-weight:500;">
            Menampilkan
            <span style="font-weight:700; color:var(--gray-700, #334155);">{{ $paginator->firstItem() }}</span>
            &ndash;
            <span style="font-weight:700; color:var(--gray-700, #334155);">{{ $paginator->lastItem() }}</span>
            dari
            <span style="font-weight:700; color:var(--gray-700, #334155);">{{ $paginator->total() }}</span>
            data
        </p>

        {{-- Tombol pagination --}}
        <div style="display:flex; align-items:center; gap:4px;">
            {{-- Previous --}}
            @if ($paginator->onFirstPage())
                <span style="display:inline-flex; align-items:center; gap:6px; padding:0 14px; height:36px; border-radius:8px; font-size:13px; font-weight:600; background:var(--gray-50, #f8fafc); color:var(--gray-200, #e2e8f0); border:1px solid var(--border-color, #e2e8f0); cursor:not-allowed;">
                    ← Prev
                </span>
            @else
                <a href="{{ $paginator->previousPageUrl() }}" rel="prev" style="display:inline-flex; align-items:center; gap:6px; padding:0 14px; height:36px; border-radius:8px; font-size:13px; font-weight:600; background:white; color:var(--gray-500, #64748b); border:1px solid var(--border-color, #e2e8f0); transition:all 0.2s; text-decoration:none;"
                    onmouseover="this.style.background='var(--admin-primary,#10439f)'; this.style.color='white'; this.style.borderColor='var(--admin-primary,#10439f)';"
                    onmouseout="this.style.background='white'; this.style.color='var(--gray-500,#64748b)'; this.style.borderColor='var(--border-color,#e2e8f0)';">
                    ← Prev
                </a>
            @endif

            {{-- Page Numbers --}}
            @foreach ($elements as $element)
                @if (is_string($element))
                    <span style="display:inline-flex; align-items:center; justify-content:center; width:36px; height:36px; border-radius:8px; font-size:13px; font-weight:600; background:var(--gray-50,#f8fafc); color:var(--gray-400,#94a3b8); border:1px solid var(--border-color,#e2e8f0);">
                        …
                    </span>
                @endif

                @if (is_array($element))
                    @foreach ($element as $page => $url)
                        @if ($page == $paginator->currentPage())
                            <span aria-current="page" style="display:inline-flex; align-items:center; justify-content:center; min-width:36px; height:36px; padding:0 10px; border-radius:8px; font-size:13px; font-weight:700; background:var(--admin-primary,#10439f); color:white; border:1px solid var(--admin-primary,#10439f); box-shadow:0 4px 12px rgba(16,67,159,0.25);">
                                {{ $page }}
                            </span>
                        @else
                            <a href="{{ $url }}" style="display:inline-flex; align-items:center; justify-content:center; min-width:36px; height:36px; padding:0 10px; border-radius:8px; font-size:13px; font-weight:600; background:white; color:var(--gray-500,#64748b); border:1px solid var(--border-color,#e2e8f0); transition:all 0.2s; text-decoration:none;"
                                onmouseover="this.style.background='#eef3fd'; this.style.color='var(--admin-primary,#10439f)'; this.style.borderColor='rgba(16,67,159,0.2)';"
                                onmouseout="this.style.background='white'; this.style.color='var(--gray-500,#64748b)'; this.style.borderColor='var(--border-color,#e2e8f0)';">
                                {{ $page }}
                            </a>
                        @endif
                    @endforeach
                @endif
            @endforeach

            {{-- Next --}}
            @if ($paginator->hasMorePages())
                <a href="{{ $paginator->nextPageUrl() }}" rel="next" style="display:inline-flex; align-items:center; gap:6px; padding:0 14px; height:36px; border-radius:8px; font-size:13px; font-weight:600; background:white; color:var(--gray-500,#64748b); border:1px solid var(--border-color,#e2e8f0); transition:all 0.2s; text-decoration:none;"
                    onmouseover="this.style.background='var(--admin-primary,#10439f)'; this.style.color='white'; this.style.borderColor='var(--admin-primary,#10439f)';"
                    onmouseout="this.style.background='white'; this.style.color='var(--gray-500,#64748b)'; this.style.borderColor='var(--border-color,#e2e8f0)';">
                    Next →
                </a>
            @else
                <span style="display:inline-flex; align-items:center; gap:6px; padding:0 14px; height:36px; border-radius:8px; font-size:13px; font-weight:600; background:var(--gray-50,#f8fafc); color:var(--gray-200,#e2e8f0); border:1px solid var(--border-color,#e2e8f0); cursor:not-allowed;">
                    Next →
                </span>
            @endif
        </div>
    </nav>
@endif
