<footer class="bg-slate-950 text-slate-400 border-t border-slate-800 mt-auto font-sans">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-10 lg:py-14">
        <div class="grid grid-cols-1 md:grid-cols-4 gap-8 lg:gap-10">
            
            <!-- Brand Column -->
            <div class="space-y-3.5 md:col-span-1">
                <div class="flex items-center space-x-2.5 rtl:space-x-reverse">
                    <div class="w-9 h-9 rounded-xl bg-gradient-to-tr from-sky-500 to-blue-600 flex items-center justify-center shadow-md shadow-sky-500/25">
                        <i data-lucide="sparkles" class="w-4.5 h-4.5 text-white"></i>
                    </div>
                    <div class="flex items-center gap-1.5">
                        <span class="text-xl font-black text-white tracking-tight">KAN</span>
                        <span class="text-xs font-black px-1.5 py-0.5 rounded bg-blue-900/60 text-sky-400 border border-sky-400/30">LMS</span>
                    </div>
                </div>
                <p class="text-xs text-slate-400 leading-relaxed">
                    {{ __('messages.hero_desc_left') }}
                </p>
                <div class="flex items-center space-x-2.5 rtl:space-x-reverse pt-1">
                    <a href="#" class="w-8 h-8 rounded-lg bg-slate-900 hover:bg-blue-600 hover:text-white flex items-center justify-center transition-colors">
                        <i data-lucide="twitter" class="w-4 h-4"></i>
                    </a>
                    <a href="#" class="w-8 h-8 rounded-lg bg-slate-900 hover:bg-blue-600 hover:text-white flex items-center justify-center transition-colors">
                        <i data-lucide="github" class="w-4 h-4"></i>
                    </a>
                    <a href="#" class="w-8 h-8 rounded-lg bg-slate-900 hover:bg-blue-600 hover:text-white flex items-center justify-center transition-colors">
                        <i data-lucide="linkedin" class="w-4 h-4"></i>
                    </a>
                </div>
            </div>

            <!-- Quick Links -->
            <div>
                <h4 class="text-xs font-extrabold uppercase tracking-wider text-slate-200 mb-3.5">Explore</h4>
                <ul class="space-y-2 text-xs font-medium">
                    <li><a href="{{ route('courses.index') }}" class="hover:text-sky-400 transition-colors">{{ __('messages.explore_courses') }}</a></li>
                    <li><a href="{{ route('certificate.verify') }}" class="hover:text-sky-400 transition-colors">{{ __('messages.verify_certificate') }}</a></li>
                    <li><a href="{{ route('courses.index', ['price' => 'free']) }}" class="hover:text-sky-400 transition-colors">Free Courses</a></li>
                    <li><a href="{{ route('register', ['role' => 'instructor']) }}" class="hover:text-sky-400 transition-colors">{{ __('messages.btn_join_instructor') }}</a></li>
                </ul>
            </div>

            <!-- Learning Categories -->
            <div>
                <h4 class="text-xs font-extrabold uppercase tracking-wider text-slate-200 mb-3.5">Categories</h4>
                <ul class="space-y-2 text-xs font-medium">
                    <li><a href="{{ route('courses.index', ['category' => 'technology-development']) }}" class="hover:text-sky-400 transition-colors">Technology & Software</a></li>
                    <li><a href="{{ route('courses.index', ['category' => 'business-leadership']) }}" class="hover:text-sky-400 transition-colors">Business & Management</a></li>
                    <li><a href="{{ route('courses.index', ['category' => 'design-creativity']) }}" class="hover:text-sky-400 transition-colors">Design & Media</a></li>
                    <li><a href="{{ route('courses.index', ['category' => 'science-analytics']) }}" class="hover:text-sky-400 transition-colors">Data & Analytics</a></li>
                </ul>
            </div>

            <!-- Trust & Features -->
            <div>
                <h4 class="text-xs font-extrabold uppercase tracking-wider text-slate-200 mb-3.5">{{ __('messages.why_kan') }}</h4>
                <div class="space-y-2.5 text-xs">
                    <div class="flex items-start space-x-2 rtl:space-x-reverse">
                        <i data-lucide="check-circle" class="w-3.5 h-3.5 text-emerald-400 mt-0.5 flex-shrink-0"></i>
                        <span>Structured learning paths designed by industry leaders.</span>
                    </div>
                    <div class="flex items-start space-x-2 rtl:space-x-reverse">
                        <i data-lucide="clipboard-check" class="w-3.5 h-3.5 text-sky-400 mt-0.5 flex-shrink-0"></i>
                        <span>Real-time quiz evaluations and interactive coding assignments.</span>
                    </div>
                    <div class="flex items-start space-x-2 rtl:space-x-reverse">
                        <i data-lucide="award" class="w-3.5 h-3.5 text-indigo-400 mt-0.5 flex-shrink-0"></i>
                        <span>Official verifiable digital certificates with unique codes.</span>
                    </div>
                </div>
            </div>

        </div>

        <div class="border-t border-slate-900 mt-8 pt-6 flex flex-col sm:flex-row items-center justify-between text-xs text-slate-500 gap-3">
            <p>{{ __('messages.copyright') }}</p>
            <div class="flex space-x-5 rtl:space-x-reverse">
                <a href="#" class="hover:text-slate-400">{{ __('messages.privacy') }}</a>
                <a href="#" class="hover:text-slate-400">{{ __('messages.terms') }}</a>
                <a href="#" class="hover:text-slate-400">{{ __('messages.support') }}</a>
            </div>
        </div>
    </div>
</footer>
