@if ($paginator->hasPages())
    <nav role="navigation" aria-label="Navigasi Halaman">

        <div class="flex gap-2 items-center justify-between sm:hidden">
            @if ($paginator->onFirstPage())
                <span class="inline-flex items-center px-4 py-2 text-sm font-medium text-gray-400 bg-gray-50 border border-gray-200 cursor-not-allowed rounded-xl">
                    &laquo; Sebelumnya
                </span>
            @else
                <a href="{{ $paginator->previousPageUrl() }}" rel="prev" class="inline-flex items-center px-4 py-2 text-sm font-bold text-[#A33215] bg-white border border-gray-200 rounded-xl hover:bg-orange-50 hover:border-[#FA8145] focus:outline-none focus:ring-2 focus:ring-[#FA8145] active:bg-orange-100 transition-all">
                    &laquo; Sebelumnya
                </a>
            @endif

            @if ($paginator->hasMorePages())
                <a href="{{ $paginator->nextPageUrl() }}" rel="next" class="inline-flex items-center px-4 py-2 text-sm font-bold text-[#A33215] bg-white border border-gray-200 rounded-xl hover:bg-orange-50 hover:border-[#FA8145] focus:outline-none focus:ring-2 focus:ring-[#FA8145] active:bg-orange-100 transition-all">
                    Selanjutnya &raquo;
                </a>
            @else
                <span class="inline-flex items-center px-4 py-2 text-sm font-medium text-gray-400 bg-gray-50 border border-gray-200 cursor-not-allowed rounded-xl">
                    Selanjutnya &raquo;
                </span>
            @endif
        </div>

        <div class="hidden sm:flex-1 sm:flex sm:gap-4 sm:items-center sm:justify-between mt-4">
            <div>
                <p class="text-sm text-gray-600 font-medium leading-5">
                    Menampilkan
                    @if ($paginator->firstItem())
                        <span class="font-bold text-[#A33215]">{{ $paginator->firstItem() }}</span>
                        hingga
                        <span class="font-bold text-[#A33215]">{{ $paginator->lastItem() }}</span>
                    @else
                        {{ $paginator->count() }}
                    @endif
                    dari total
                    <span class="font-bold text-[#A33215]">{{ $paginator->total() }}</span>
                    data
                </p>
            </div>

            <div>
                <span class="inline-flex shadow-sm rounded-xl overflow-hidden border border-gray-200">

                    @if ($paginator->onFirstPage())
                        <span aria-disabled="true" aria-label="Sebelumnya">
                            <span class="inline-flex items-center px-3 py-2 text-sm font-medium text-gray-400 bg-gray-50 border-r border-gray-200 cursor-not-allowed leading-5" aria-hidden="true">
                                <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M12.707 5.293a1 1 0 010 1.414L9.414 10l3.293 3.293a1 1 0 01-1.414 1.414l-4-4a1 1 0 010-1.414l4-4a1 1 0 011.414 0z" clip-rule="evenodd" />
                                </svg>
                            </span>
                        </span>
                    @else
                        <a href="{{ $paginator->previousPageUrl() }}" rel="prev" class="inline-flex items-center px-3 py-2 text-sm font-bold text-[#C54716] bg-white border-r border-gray-200 leading-5 hover:bg-orange-50 hover:text-[#A33215] focus:outline-none focus:ring-2 focus:ring-[#FA8145] active:bg-orange-100 transition-all" aria-label="Sebelumnya">
                            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M12.707 5.293a1 1 0 010 1.414L9.414 10l3.293 3.293a1 1 0 01-1.414 1.414l-4-4a1 1 0 010-1.414l4-4a1 1 0 011.414 0z" clip-rule="evenodd" />
                            </svg>
                        </a>
                    @endif


                    @foreach ($elements as $element)

                        @if (is_string($element))
                            <span aria-disabled="true">
                                <span class="inline-flex items-center px-4 py-2 text-sm font-medium text-gray-400 bg-white border-r border-gray-200 cursor-default leading-5">{{ $element }}</span>
                            </span>
                        @endif


                        @if (is_array($element))
                            @foreach ($element as $page => $url)
                                @if ($page == $paginator->currentPage())
                                    <span aria-current="page">
                                        <span class="inline-flex items-center px-4 py-2 text-sm font-black text-white bg-[#C54716] border-r border-[#A33215] cursor-default leading-5 shadow-inner">{{ $page }}</span>
                                    </span>
                                @else
                                    <a href="{{ $url }}" class="inline-flex items-center px-4 py-2 text-sm font-bold text-[#A33215] bg-white border-r border-gray-200 leading-5 hover:bg-orange-50 hover:text-[#C54716] focus:outline-none focus:ring-2 focus:ring-[#FA8145] active:bg-orange-100 transition-all" aria-label="Ke halaman {{ $page }}">
                                        {{ $page }}
                                    </a>
                                @endif
                            @endforeach
                        @endif
                    @endforeach


                    @if ($paginator->hasMorePages())
                        <a href="{{ $paginator->nextPageUrl() }}" rel="next" class="inline-flex items-center px-3 py-2 text-sm font-bold text-[#C54716] bg-white leading-5 hover:bg-orange-50 hover:text-[#A33215] focus:outline-none focus:ring-2 focus:ring-[#FA8145] active:bg-orange-100 transition-all" aria-label="Selanjutnya">
                            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd" />
                            </svg>
                        </a>
                    @else
                        <span aria-disabled="true" aria-label="Selanjutnya">
                            <span class="inline-flex items-center px-3 py-2 text-sm font-medium text-gray-400 bg-gray-50 cursor-not-allowed leading-5" aria-hidden="true">
                                <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd" />
                                </svg>
                            </span>
                        </span>
                    @endif
                </span>
            </div>
        </div>
    </nav>
@endif
