<div class="px-4 sm:px-6 lg:px-8 py-8 w-full max-w-9xl mx-auto">
    <!-- Page header -->
    <div class="mb-8">
        <h1 class="text-2xl md:text-3xl text-gray-800 dark:text-gray-100 font-bold">{{ $pageId ? 'Editar Página' : 'Nueva Página' }}</h1>
    </div>

    <!-- Include Quill Theme -->
    <link href="https://cdn.quilljs.com/1.3.7/quill.snow.css" rel="stylesheet">
    <script src="https://cdn.quilljs.com/1.3.7/quill.min.js"></script>

    <div class="bg-white dark:bg-gray-800 shadow-sm rounded-xl border border-gray-200 dark:border-gray-700 p-6">
        <form wire:submit.prevent="save">
            <div class="grid gap-5">
                <!-- Título -->
                <div>
                    <label class="block text-sm font-medium mb-1 dark:text-gray-300">Título de la Página <span class="text-rose-500">*</span></label>
                    <input type="text" wire:model="title" class="form-input w-full dark:bg-gray-700 dark:border-gray-600 dark:text-white rounded-lg" placeholder="Ej. Quiénes Somos" required>
                    @error('title') <span class="text-rose-500 text-xs mt-1">{{ $message }}</span> @enderror
                </div>

                <!-- Contenido (Quill) -->
                <div class="mt-4" wire:ignore>
                    <label class="block text-sm font-medium mb-1 dark:text-gray-300">Contenido</label>
                    <div x-data="{ content: @entangle('content') }" x-init="
                        const quill = new Quill($refs.editor, {
                            theme: 'snow',
                            modules: {
                                toolbar: [
                                    [{ 'header': [1, 2, 3, false] }],
                                    ['bold', 'italic', 'underline', 'strike'],
                                    [{ 'color': [] }, { 'background': [] }],
                                    [{ 'list': 'ordered'}, { 'list': 'bullet' }],
                                    ['link', 'image', 'video'],
                                    ['clean']
                                ]
                            }
                        });
                        quill.root.innerHTML = content;
                        quill.on('text-change', () => {
                            content = quill.root.innerHTML;
                        });
                    ">
                        <div x-ref="editor" class="bg-white dark:bg-gray-900 text-gray-900 dark:text-white" style="min-height: 400px; font-family: inherit;"></div>
                    </div>
                </div>

                <!-- Slug -->
                <div>
                    <label class="block text-sm font-medium mb-1 dark:text-gray-300">Slug (URL amigable)</label>
                    <input type="text" wire:model="slug" class="form-input w-full dark:bg-gray-700 dark:border-gray-600 dark:text-white rounded-lg" placeholder="Se generará automáticamente si se deja en blanco">
                    @error('slug') <span class="text-rose-500 text-xs mt-1">{{ $message }}</span> @enderror
                </div>

                <hr class="dark:border-gray-700">

                <h3 class="text-lg font-bold dark:text-gray-100">Optimización SEO (Opcional)</h3>

                <!-- Meta Title -->
                <div>
                    <label class="block text-sm font-medium mb-1 dark:text-gray-300">Meta Título (SEO)</label>
                    <input type="text" wire:model="meta_title" class="form-input w-full dark:bg-gray-700 dark:border-gray-600 dark:text-white rounded-lg" placeholder="Título para buscadores">
                </div>

                <!-- Meta Description -->
                <div>
                    <label class="block text-sm font-medium mb-1 dark:text-gray-300">Meta Descripción (SEO)</label>
                    <textarea wire:model="meta_description" rows="3" class="form-input w-full dark:bg-gray-700 dark:border-gray-600 dark:text-white rounded-lg" placeholder="Breve resumen de la página para buscadores..."></textarea>
                </div>

                <hr class="dark:border-gray-700">

                <!-- Estado -->
                <div>
                    <label class="flex items-center">
                        <input type="checkbox" wire:model="is_published" class="form-checkbox bg-gray-100 border-gray-300 text-indigo-500 rounded focus:ring-indigo-500">
                        <span class="text-sm ml-2 dark:text-gray-300">Página Pública (Visible para todos)</span>
                    </label>
                </div>

                <!-- Actions -->
                <div class="mt-6 flex justify-end gap-3">
                    <a href="{{ route('pages.index') }}" class="btn bg-white dark:bg-gray-700 border-gray-200 dark:border-gray-600 hover:border-gray-300 text-gray-700 dark:text-gray-300 rounded-lg px-4 py-2">
                        Cancelar
                    </a>
                    <button type="submit" class="btn bg-indigo-500 hover:bg-indigo-600 text-white rounded-lg px-4 py-2">
                        Guardar Página
                    </button>
                </div>
            </div>
        </form>
    </div>

    <!-- Fix Quill Dark Mode text color -->
    <style>
        .ql-editor { font-family: inherit; font-size: 1rem; }
        .dark .ql-toolbar { border-color: #374151 !important; background: #1f2937; }
        .dark .ql-container { border-color: #374151 !important; }
        .dark .ql-stroke { stroke: #d1d5db; }
        .dark .ql-fill { fill: #d1d5db; }
        .dark .ql-picker-label { color: #d1d5db; }
        .dark .ql-picker-options { background-color: #1f2937; border-color: #374151; }
        .dark .ql-snow .ql-picker.ql-expanded .ql-picker-label { color: #818cf8; stroke: #818cf8; fill: #818cf8; }
        .dark .ql-snow .ql-picker.ql-expanded .ql-picker-options { border-color: #374151; }
    </style>
</div>
