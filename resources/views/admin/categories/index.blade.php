@extends('layouts.admin')

@section('title', 'Course Categories')

@section('admin_content')
<div class="space-y-3.5 max-w-7xl mx-auto font-sans">
    
    <!-- Header -->
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-2.5">
        <div>
            <h1 class="text-lg sm:text-xl font-bold text-slate-900 tracking-tight">Course Categories</h1>
            <p class="text-xs text-slate-500 mt-0.5">Organize courses into domains, topics, and learning pathways</p>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-3.5">
        
        <!-- Left: Create Category Form -->
        <div class="bg-white p-3.5 sm:p-4 rounded-xl border border-slate-200/80 shadow-2xs space-y-3">
            <h3 class="text-xs font-semibold uppercase tracking-wider text-slate-900 flex items-center">
                <i data-lucide="plus-circle" class="w-3.5 h-3.5 mr-1.5 text-rose-600"></i>
                Create Category
            </h3>

            <form action="{{ route('admin.categories.store') }}" method="POST" class="space-y-3">
                @csrf

                <div>
                    <label class="block text-xs font-bold uppercase tracking-wider text-slate-700 mb-1.5">Category Name</label>
                    <input type="text" name="name" required placeholder="e.g. Web Development" 
                           class="w-full px-4 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-xs text-slate-900 placeholder-slate-400 focus:bg-white focus:border-rose-500 focus:ring-2 focus:ring-rose-500/20 transition-all">
                </div>

                <div>
                    <label class="block text-xs font-bold uppercase tracking-wider text-slate-700 mb-1.5">Icon Name (Lucide)</label>
                    <input type="text" name="icon" value="folder" placeholder="code, layout, database, shield, etc." 
                           class="w-full px-4 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-xs text-slate-900 placeholder-slate-400 focus:bg-white focus:border-rose-500 focus:ring-2 focus:ring-rose-500/20 transition-all">
                </div>

                <div>
                    <label class="block text-xs font-bold uppercase tracking-wider text-slate-700 mb-1.5">Description (Optional)</label>
                    <textarea name="description" rows="3" placeholder="Short description of this domain..." 
                              class="w-full px-4 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-xs text-slate-900 placeholder-slate-400 focus:bg-white focus:border-rose-500 focus:ring-2 focus:ring-rose-500/20 transition-all"></textarea>
                </div>

                <button type="submit" class="w-full py-2.5 bg-rose-600 hover:bg-rose-700 text-white font-bold text-xs rounded-xl shadow-md shadow-rose-500/20 transition-all flex items-center justify-center space-x-2">
                    <i data-lucide="check" class="w-4 h-4"></i>
                    <span>Save Category</span>
                </button>
            </form>
        </div>

        <!-- Right: Category List -->
        <div class="lg:col-span-2 bg-white rounded-3xl border border-slate-200/80 overflow-hidden shadow-sm">
            <div class="p-5 border-b border-slate-100">
                <h3 class="text-sm font-extrabold uppercase tracking-wider text-slate-900">Existing Categories</h3>
            </div>

            <div class="divide-y divide-slate-100">
                @forelse($categories as $category)
                    <div class="p-4 flex items-center justify-between hover:bg-slate-50/60 transition-colors text-xs" x-data="{ editing: false }">
                        
                        <!-- Display mode -->
                        <div x-show="!editing" class="flex items-center space-x-3.5">
                            <div class="w-10 h-10 rounded-xl bg-rose-50 text-rose-600 flex items-center justify-center flex-shrink-0">
                                <i data-lucide="{{ $category->icon ?: 'folder' }}" class="w-5 h-5"></i>
                            </div>
                            <div>
                                <h4 class="font-bold text-slate-900 text-sm">{{ $category->name }}</h4>
                                <span class="text-[11px] text-slate-400 font-medium">{{ $category->description ?: 'No description provided' }}</span>
                                <div class="mt-1.5 flex items-center space-x-2">
                                    <span class="text-[10px] text-brand-700 font-bold bg-brand-50 px-2 py-0.5 rounded-md">
                                        {{ $category->courses_count }} courses
                                    </span>
                                    <span class="text-[10px] font-bold {{ $category->is_active ? 'text-emerald-700 bg-emerald-50 px-2 py-0.5 rounded-md' : 'text-slate-400 bg-slate-100 px-2 py-0.5 rounded-md' }}">
                                        {{ $category->is_active ? 'Active' : 'Inactive' }}
                                    </span>
                                </div>
                            </div>
                        </div>

                        <!-- Edit Form mode -->
                        <div x-show="editing" class="flex-1 mr-4" style="display: none;">
                            <form action="{{ route('admin.categories.update', $category->id) }}" method="POST" class="space-y-2">
                                @csrf
                                @method('PUT')
                                <input type="text" name="name" value="{{ $category->name }}" required class="w-full px-3 py-1.5 bg-slate-50 border border-slate-200 rounded-lg text-xs text-slate-900">
                                <input type="text" name="icon" value="{{ $category->icon }}" placeholder="Icon" class="w-full px-3 py-1.5 bg-slate-50 border border-slate-200 rounded-lg text-xs text-slate-900">
                                <textarea name="description" rows="2" class="w-full px-3 py-1.5 bg-slate-50 border border-slate-200 rounded-lg text-xs text-slate-900">{{ $category->description }}</textarea>
                                <div class="flex items-center space-x-2">
                                    <select name="is_active" class="px-2 py-1 bg-slate-50 border border-slate-200 rounded-lg text-xs text-slate-800">
                                        <option value="1" {{ $category->is_active ? 'selected' : '' }}>Active</option>
                                        <option value="0" {{ !$category->is_active ? 'selected' : '' }}>Inactive</option>
                                    </select>
                                    <button type="submit" class="px-3 py-1 bg-emerald-600 text-white font-bold text-xs rounded-lg">Save</button>
                                    <button type="button" @click="editing = false" class="px-3 py-1 bg-slate-100 text-slate-700 text-xs rounded-lg">Cancel</button>
                                </div>
                            </form>
                        </div>

                        <!-- Action Buttons -->
                        <div x-show="!editing" class="flex items-center space-x-1">
                            <button @click="editing = true" class="p-1.5 text-slate-400 hover:text-slate-800 rounded-lg hover:bg-slate-100 transition-colors">
                                <i data-lucide="edit" class="w-4 h-4"></i>
                            </button>
                            <form action="{{ route('admin.categories.destroy', $category->id) }}" method="POST" onsubmit="return confirm('Delete this category?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="p-1.5 text-slate-400 hover:text-rose-600 rounded-lg hover:bg-slate-100 transition-colors">
                                    <i data-lucide="trash-2" class="w-4 h-4"></i>
                                </button>
                            </form>
                        </div>

                    </div>
                @empty
                    <p class="p-8 text-center text-slate-400 text-xs">No categories created yet.</p>
                @endforelse
            </div>
        </div>

    </div>
</div>
@endsection
