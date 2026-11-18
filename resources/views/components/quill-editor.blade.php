@props([
    'placeholder' => 'Write your content here...',
    'minHeight'   => '180px',
])

<div x-data="{
        content: @entangle($attributes->wire('model')),
        quill: null,
        initQuill() {
            if (this.quill) return;

            const init = () => {
                if (typeof window.Quill === 'undefined') {
                    setTimeout(init, 50);
                    return;
                }

                this.quill = new window.Quill(this.$refs.editor, {
                    theme: 'snow',
                    placeholder: '{{ $placeholder }}',
                    modules: {
                        toolbar: [
                            [{ 'header': [2, 3, 4, false] }],
                            ['bold', 'italic', 'underline', 'strike'],
                            [{ 'list': 'ordered' }, { 'list': 'bullet' }],
                            ['blockquote', 'code-block'],
                            ['link', 'clean']
                        ]
                    }
                });

                if (this.content) {
                    this.quill.root.innerHTML = this.content;
                }

                this.quill.on('text-change', () => {
                    const html = this.quill.root.innerHTML;
                    this.content = (html === '<p><br></p>' || html === '') ? '' : html;
                });

                this.$watch('content', (val) => {
                    if (this.quill && val !== this.quill.root.innerHTML) {
                        const sel = this.quill.getSelection();
                        this.quill.root.innerHTML = val || '';
                        if (sel) {
                            try { this.quill.setSelection(sel); } catch(e) {}
                        }
                    }
                });
            };

            this.$nextTick(() => init());
        }
    }" 
    x-init="initQuill()"
    wire:ignore
    {{ $attributes->whereDoesntStartWith('wire:model')->class(['nordroy-quill-wrapper rounded-2xl overflow-hidden border border-slate-200 dark:border-slate-800 bg-white dark:bg-slate-950 transition-colors']) }}>
    
    <div x-ref="editor" style="min-height: {{ $minHeight }};" class="text-sm text-slate-800 dark:text-slate-100"></div>

    <style>
        .nordroy-quill-wrapper .ql-toolbar.ql-snow {
            border-top: none;
            border-left: none;
            border-right: none;
            border-bottom: 1px solid #e2e8f0;
            background: #f8fafc;
            border-top-left-radius: 1rem;
            border-top-right-radius: 1rem;
            padding: 8px 12px;
        }
        .dark .nordroy-quill-wrapper .ql-toolbar.ql-snow {
            background: #0f172a;
            border-bottom-color: #1e293b;
        }
        .nordroy-quill-wrapper .ql-container.ql-snow {
            border: none;
            font-family: inherit;
            font-size: 0.875rem;
            border-bottom-left-radius: 1rem;
            border-bottom-right-radius: 1rem;
        }
        .dark .nordroy-quill-wrapper .ql-container.ql-snow {
            background: #020617;
            color: #f1f5f9;
        }
        .nordroy-quill-wrapper .ql-editor {
            min-height: {{ $minHeight }};
            line-height: 1.6;
            padding: 14px 16px;
        }
        .dark .nordroy-quill-wrapper .ql-stroke {
            stroke: #94a3b8 !important;
        }
        .dark .nordroy-quill-wrapper .ql-fill {
            fill: #94a3b8 !important;
        }
        .dark .nordroy-quill-wrapper .ql-picker {
            color: #94a3b8 !important;
        }
        .dark .nordroy-quill-wrapper .ql-picker-options {
            background-color: #0f172a !important;
            border: 1px solid #334155 !important;
            color: #f1f5f9 !important;
            border-radius: 0.75rem;
            box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.5);
        }
        .dark .nordroy-quill-wrapper .ql-picker-item:hover {
            color: #38bdf8 !important;
            background: #1e293b;
        }
        .dark .nordroy-quill-wrapper .ql-editor.ql-blank::before {
            color: #64748b !important;
            font-style: normal;
        }
    </style>
</div>
