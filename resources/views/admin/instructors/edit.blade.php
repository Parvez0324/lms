@extends('layouts.admin')

@section('title', 'Edit Instructor')

@section('admin_content')
<div class="max-w-xl mx-auto space-y-4">
    <div class="flex items-center justify-between">
        <div>
            <h1 class="text-xl font-black text-slate-900">Edit Instructor</h1>
            <p class="text-xs text-slate-500">Modify details for {{ $instructor->name }}</p>
        </div>
        <a href="{{ route('admin.instructors.index') }}" class="text-xs font-bold text-slate-500 hover:text-slate-800 flex items-center space-x-1">
            <i data-lucide="arrow-left" class="w-3.5 h-3.5"></i>
            <span>Back</span>
        </a>
    </div>

    <div class="bg-white p-5 rounded-2xl border border-slate-200/80 shadow-sm">
        <form action="{{ route('admin.instructors.update', $instructor->id) }}" method="POST" class="space-y-3.5">
            @csrf
            @method('PUT')

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                <div>
                    <label class="block text-[11px] font-bold uppercase tracking-wider text-slate-700 mb-1">Full Name</label>
                    <input type="text" name="name" value="{{ old('name', $instructor->name) }}" required 
                           class="w-full px-3 py-2 bg-slate-50 border border-slate-200 rounded-xl text-xs text-slate-900 focus:bg-white focus:border-rose-500 focus:ring-2 focus:ring-rose-500/20">
                </div>
                <div>
                    <label class="block text-[11px] font-bold uppercase tracking-wider text-slate-700 mb-1">Email Address</label>
                    <input type="email" name="email" value="{{ old('email', $instructor->email) }}" required 
                           class="w-full px-3 py-2 bg-slate-50 border border-slate-200 rounded-xl text-xs text-slate-900 focus:bg-white focus:border-rose-500 focus:ring-2 focus:ring-rose-500/20">
                </div>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                <div>
                    <label class="block text-[11px] font-bold uppercase tracking-wider text-slate-700 mb-1">New Password (Optional)</label>
                    <input type="password" name="password" placeholder="Leave blank to keep current" 
                           class="w-full px-3 py-2 bg-slate-50 border border-slate-200 rounded-xl text-xs text-slate-900 focus:bg-white focus:border-rose-500 focus:ring-2 focus:ring-rose-500/20">
                </div>
                <div>
                    <label class="block text-[11px] font-bold uppercase tracking-wider text-slate-700 mb-1">Specialty / Headline</label>
                    <input type="text" name="headline" value="{{ old('headline', $instructor->headline) }}" 
                           class="w-full px-3 py-2 bg-slate-50 border border-slate-200 rounded-xl text-xs text-slate-900 focus:bg-white focus:border-rose-500 focus:ring-2 focus:ring-rose-500/20">
                </div>
            </div>

            <div>
                <label class="block text-[11px] font-bold uppercase tracking-wider text-slate-700 mb-1">Bio Summary</label>
                <textarea name="bio" rows="2" class="w-full px-3 py-1.5 bg-slate-50 border border-slate-200 rounded-xl text-xs text-slate-900 focus:bg-white focus:border-rose-500 focus:ring-2 focus:ring-rose-500/20">{{ old('bio', $instructor->bio) }}</textarea>
            </div>

            <div>
                <label class="block text-[11px] font-bold uppercase tracking-wider text-slate-700 mb-1">Status</label>
                <select name="status" required class="w-full px-3 py-2 bg-slate-50 border border-slate-200 rounded-xl text-xs font-semibold text-slate-700 focus:bg-white focus:border-rose-500">
                    <option value="active" {{ $instructor->status === 'active' ? 'selected' : '' }}>Active</option>
                    <option value="banned" {{ $instructor->status === 'banned' ? 'selected' : '' }}>Banned</option>
                </select>
            </div>

            <div class="pt-3 border-t border-slate-100 flex justify-end space-x-2">
                <a href="{{ route('admin.instructors.index') }}" class="px-4 py-2 bg-slate-100 text-slate-600 font-bold text-xs rounded-xl hover:bg-slate-200">Cancel</a>
                <button type="submit" class="px-5 py-2 bg-rose-600 hover:bg-rose-700 text-white font-bold text-xs rounded-xl shadow-md shadow-rose-500/20">Save Changes</button>
            </div>
        </form>
    </div>
</div>
@endsection
