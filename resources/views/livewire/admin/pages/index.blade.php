<div class="px-4 sm:px-6 lg:px-8 py-8 w-full max-w-9xl mx-auto">
    <!-- Page header -->
    <div class="sm:flex sm:justify-between sm:items-center mb-8">
        <div class="mb-4 sm:mb-0">
            <h1 class="text-2xl md:text-3xl text-gray-800 dark:text-gray-100 font-bold">Páginas (CMS)</h1>
            <p class="text-sm text-gray-500 mt-1">Crea y gestiona páginas estáticas como Políticas, Quiénes Somos, etc.</p>
        </div>
        <div class="grid grid-flow-col sm:auto-cols-max justify-start sm:justify-end gap-2">
            <a href="{{ route('pages.create') }}" class="btn bg-indigo-500 hover:bg-indigo-600 text-white rounded-lg px-4 py-2 flex items-center gap-2">
                <svg class="w-4 h-4 fill-current opacity-50 shrink-0" viewBox="0 0 16 16">
                    <path d="M15 7H9V1c0-.6-.4-1-1-1S7 .4 7 1v6H1c-.6 0-1 .4-1 1s.4 1 1 1h6v6c0 .6.4 1 1 1s1-.4 1-1V9h6c.6 0 1-.4 1-1s-.4-1-1-1z" />
                </svg>
                <span>Nueva Página</span>
            </a>
        </div>
    </div>

    @if (session()->has('message'))
        <div class="mb-4 bg-emerald-100 text-emerald-700 p-4 rounded-lg border border-emerald-200">
            {{ session('message') }}
        </div>
    @endif

    <!-- Table -->
    <div class="bg-white dark:bg-gray-800 shadow-sm rounded-xl border border-gray-200 dark:border-gray-700 relative">
        <div class="p-4 border-b border-gray-200 dark:border-gray-700">
            <input type="text" wire:model.live.debounce.300ms="search" placeholder="Buscar página por título..." class="form-input w-full md:w-1/3 rounded-lg border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-gray-300" />
        </div>

        <div class="overflow-x-auto">
            <table class="table-auto w-full dark:text-gray-300">
                <thead class="text-xs uppercase text-gray-400 dark:text-gray-500 bg-gray-50 dark:bg-gray-700/50 rounded-t-xl">
                    <tr>
                        <th class="px-4 py-3 whitespace-nowrap"><div class="font-semibold text-left">Título</div></th>
                        <th class="px-4 py-3 whitespace-nowrap"><div class="font-semibold text-left">Slug/URL</div></th>
                        <th class="px-4 py-3 whitespace-nowrap"><div class="font-semibold text-left">Estado</div></th>
                        <th class="px-4 py-3 whitespace-nowrap"><div class="font-semibold text-right">Acciones</div></th>
                    </tr>
                </thead>
                <tbody class="text-sm divide-y divide-gray-100 dark:divide-gray-700">
                    @forelse($pages as $page)
                        <tr>
                            <td class="px-4 py-3 whitespace-nowrap">
                                <div class="font-medium text-gray-800 dark:text-gray-100">{{ $page->title }}</div>
                            </td>
                            <td class="px-4 py-3 whitespace-nowrap">
                                <a href="{{ url('/pagina/' . $page->slug) }}" target="_blank" class="text-indigo-500 hover:text-indigo-600 hover:underline">/pagina/{{ $page->slug }}</a>
                            </td>
                            <td class="px-4 py-3 whitespace-nowrap">
                                <button wire:click="togglePublish('{{ $page->id }}')" class="px-2.5 py-1 text-xs font-bold rounded-full {{ $page->is_published ? 'bg-emerald-100 text-emerald-600 dark:bg-emerald-500/20 dark:text-emerald-400' : 'bg-gray-100 text-gray-500 dark:bg-gray-700 dark:text-gray-400' }}">
                                    {{ $page->is_published ? 'Publicado' : 'Borrador' }}
                                </button>
                            </td>
                            <td class="px-4 py-3 whitespace-nowrap text-right">
                                <div class="flex items-center justify-end gap-2">
                                    <a href="{{ url('/pagina/' . $page->slug) }}" target="_blank" class="text-slate-400 hover:text-indigo-500 dark:text-slate-500 dark:hover:text-indigo-400" title="Ver Página">
                                        <span class="sr-only">Ver</span>
                                        <svg class="w-8 h-8 fill-current p-1.5" viewBox="0 0 24 24">
                                            <path d="M12 4.5C7 4.5 2.73 7.61 1 12c1.73 4.39 6 7.5 11 7.5s9.27-3.11 11-7.5c-1.73-4.39-6-7.5-11-7.5zM12 17c-2.76 0-5-2.24-5-5s2.24-5 5-5 5 2.24 5 5-2.24 5-5 5zm0-8c-1.66 0-3 1.34-3 3s1.34 3 3 3 3-1.34 3-3-1.34-3-3-3z"/>
                                        </svg>
                                    </a>
                                    <a href="{{ route('pages.edit', $page->id) }}" class="text-slate-400 hover:text-slate-500 dark:text-slate-500 dark:hover:text-slate-400" title="Editar">
                                        <span class="sr-only">Editar</span>
                                        <svg class="w-8 h-8 fill-current" viewBox="0 0 32 32">
                                            <path d="M19.7 8.3c-.4-.4-1-.4-1.4 0l-10 10c-.2.2-.3.4-.3.7v4c0 .6.4 1 1 1h4c.3 0 .5-.1.7-.3l10-10c.4-.4.4-1 0-1.4l-4-4zM12.6 22H10v-2.6l6-6 2.6 2.6-6 6zm7.4-7.4L17.4 12l1.6-1.6 2.6 2.6-1.6 1.6z" />
                                        </svg>
                                    </a>
                                    <button wire:click="deletePage('{{ $page->id }}')" wire:confirm="¿Estás seguro de eliminar esta página?" class="text-rose-500 hover:text-rose-600 rounded-full">
                                        <span class="sr-only">Eliminar</span>
                                        <svg class="w-8 h-8 fill-current" viewBox="0 0 32 32">
                                            <path d="M13 15h2v6h-2zM17 15h2v6h-2z" />
                                            <path d="M20 9c0-.6-.4-1-1-1h-6c-.6 0-1 .4-1 1v2H8v2h1v10c0 .6.4 1 1 1h12c.6 0 1-.4 1-1V13h1v-2h-4V9zm-6 1h4v1h-4v-1zm7 12H11V13h10v9z" />
                                        </svg>
                                    </button>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="px-4 py-6 text-center text-gray-500 dark:text-gray-400">
                                No se encontraron páginas. Crea una nueva para empezar.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="p-4 border-t border-gray-200 dark:border-gray-700">
            {{ $pages->links() }}
        </div>
    </div>
</div>
