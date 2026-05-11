@if ($paginator->hasPages())
    <nav role="navigation" aria-label="Phân trang" class="flex flex-col items-stretch gap-4 border-t border-stone-200 pt-8 sm:flex-row sm:items-center sm:justify-between">
        <p class="text-sm text-stone-600">
            @if ($paginator->firstItem())
                <span class="font-medium text-stone-800">{{ $paginator->firstItem() }}</span>
                –
                <span class="font-medium text-stone-800">{{ $paginator->lastItem() }}</span>
                / {{ $paginator->total() }} mục
            @else
                {{ $paginator->count() }} mục
            @endif
        </p>
        <div class="flex flex-wrap items-center justify-center gap-1 sm:justify-end">
            @if ($paginator->onFirstPage())
                <span class="inline-flex min-h-10 min-w-10 items-center justify-center rounded-lg border border-stone-200 bg-stone-50 text-stone-400" aria-hidden="true">‹</span>
            @else
                <a
                    href="{{ $paginator->previousPageUrl() }}"
                    rel="prev"
                    class="inline-flex min-h-10 min-w-10 items-center justify-center rounded-lg border border-stone-200 bg-white text-sm font-medium text-brand-800 shadow-sm hover:bg-brand-50"
                    aria-label="Trang trước"
                >‹</a>
            @endif

            @foreach ($elements as $element)
                @if (is_string($element))
                    <span class="px-2 text-stone-400">…</span>
                @endif
                @if (is_array($element))
                    @foreach ($element as $page => $url)
                        @if ($page == $paginator->currentPage())
                            <span
                                class="inline-flex min-h-10 min-w-10 items-center justify-center rounded-lg bg-brand-700 text-sm font-semibold text-white shadow-sm"
                                aria-current="page"
                            >{{ $page }}</span>
                        @else
                            <a
                                href="{{ $url }}"
                                class="inline-flex min-h-10 min-w-10 items-center justify-center rounded-lg border border-stone-200 bg-white text-sm font-medium text-stone-700 shadow-sm hover:border-brand-200 hover:bg-brand-50"
                            >{{ $page }}</a>
                        @endif
                    @endforeach
                @endif
            @endforeach

            @if ($paginator->hasMorePages())
                <a
                    href="{{ $paginator->nextPageUrl() }}"
                    rel="next"
                    class="inline-flex min-h-10 min-w-10 items-center justify-center rounded-lg border border-stone-200 bg-white text-sm font-medium text-brand-800 shadow-sm hover:bg-brand-50"
                    aria-label="Trang sau"
                >›</a>
            @else
                <span class="inline-flex min-h-10 min-w-10 items-center justify-center rounded-lg border border-stone-200 bg-stone-50 text-stone-400" aria-hidden="true">›</span>
            @endif
        </div>
    </nav>
@endif
