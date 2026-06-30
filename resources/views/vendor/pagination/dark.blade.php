@if ($paginator->hasPages())
<nav style="margin-top:1rem;">
    <div style="display:flex;align-items:center;justify-content:center;gap:0.25rem;flex-wrap:wrap;">

        {{-- Previous --}}
        @if ($paginator->onFirstPage())
            <span style="padding:0.4rem 0.9rem;border-radius:6px;font-size:0.8rem;font-weight:600;color:var(--text-dim);background:var(--bg);border:1px solid var(--border);opacity:0.5;cursor:default;">← Sebelumnya</span>
        @else
            <a href="{{ $paginator->previousPageUrl() }}" style="padding:0.4rem 0.9rem;border-radius:6px;font-size:0.8rem;font-weight:600;color:var(--text-muted);background:var(--surface);border:1px solid var(--border-light);text-decoration:none;">← Sebelumnya</a>
        @endif

        {{-- Numbers --}}
        @foreach ($elements as $element)
            @if (is_string($element))
                <span style="padding:0.4rem 0.6rem;font-size:0.8rem;color:var(--text-dim);">...</span>
            @endif

            @if (is_array($element))
                @foreach ($element as $page => $url)
                    @if ($page == $paginator->currentPage())
                        <span style="padding:0.4rem 0.8rem;border-radius:6px;font-size:0.8rem;font-weight:700;color:#fff;background:var(--primary);min-width:32px;text-align:center;">{{ $page }}</span>
                    @else
                        <a href="{{ $url }}" style="padding:0.4rem 0.8rem;border-radius:6px;font-size:0.8rem;font-weight:600;color:var(--text-muted);background:var(--surface);border:1px solid var(--border-light);text-decoration:none;min-width:32px;text-align:center;">{{ $page }}</a>
                    @endif
                @endforeach
            @endif
        @endforeach

        {{-- Next --}}
        @if ($paginator->hasMorePages())
            <a href="{{ $paginator->nextPageUrl() }}" style="padding:0.4rem 0.9rem;border-radius:6px;font-size:0.8rem;font-weight:600;color:var(--text-muted);background:var(--surface);border:1px solid var(--border-light);text-decoration:none;">Selanjutnya →</a>
        @else
            <span style="padding:0.4rem 0.9rem;border-radius:6px;font-size:0.8rem;font-weight:600;color:var(--text-dim);background:var(--bg);border:1px solid var(--border);opacity:0.5;cursor:default;">Selanjutnya →</span>
        @endif

    </div>

    {{-- Info --}}
    <div style="text-align:center;margin-top:0.4rem;font-size:0.72rem;color:var(--text-dim);">
        {{ $paginator->firstItem() }}–{{ $paginator->lastItem() }} dari {{ $paginator->total() }} data
    </div>
</nav>
@endif
