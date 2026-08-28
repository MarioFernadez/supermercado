@section('title', ($page->meta_title ?: $page->title) . ' | ' . ($settings['store_name'] ?? 'ZonaShop'))
@section('meta_description', $page->meta_description ?: Str::limit(strip_tags($page->content), 160))
@section('og_type', 'article')

<div class="min-h-screen bg-gray-50 dark:bg-gray-900 pb-20">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 pt-10">
        <div class="bg-white dark:bg-gray-800 rounded-3xl shadow-sm border border-gray-100 dark:border-gray-700 overflow-hidden">
            <div class="p-8 sm:p-12">
                <h1 class="text-3xl sm:text-4xl font-black text-gray-900 dark:text-white mb-8">{{ $page->title }}</h1>
                
                <div class="prose-custom text-gray-800 dark:text-gray-200">
                    {!! $page->content !!}
                </div>
            </div>
        </div>
    </div>
    
    <!-- Basic CSS rules for the WYSIWYG content -->
    <style>
        .prose-custom h1 { font-size: 2.25rem; font-weight: 800; margin-bottom: 1rem; margin-top: 2rem; color: inherit; }
        .prose-custom h2 { font-size: 1.875rem; font-weight: 700; margin-bottom: 1rem; margin-top: 1.5rem; color: inherit; }
        .prose-custom h3 { font-size: 1.5rem; font-weight: 600; margin-bottom: 1rem; margin-top: 1.5rem; color: inherit; }
        .prose-custom p { margin-bottom: 1.25rem; line-height: 1.75; font-size: 1.125rem; }
        .prose-custom ul { list-style-type: disc; padding-left: 1.5rem; margin-bottom: 1.25rem; }
        .prose-custom ol { list-style-type: decimal; padding-left: 1.5rem; margin-bottom: 1.25rem; }
        .prose-custom li { margin-bottom: 0.5rem; }
        .prose-custom a { color: #4f46e5; text-decoration: underline; }
        .prose-custom img { max-width: 100%; height: auto; border-radius: 0.75rem; margin-top: 1.5rem; margin-bottom: 1.5rem; box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1); }
        .prose-custom strong, .prose-custom b { font-weight: 700; color: inherit; }
        .prose-custom i, .prose-custom em { font-style: italic; }
        .prose-custom u { text-decoration: underline; }
        .prose-custom s, .prose-custom strike { text-decoration: line-through; }
        .dark .prose-custom a { color: #818cf8; }
    </style>
</div>
