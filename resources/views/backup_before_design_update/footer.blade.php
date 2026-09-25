<footer class="bg-slate-900 text-slate-400 border-t border-slate-800 mt-auto">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12 lg:py-16">
        <div class="grid grid-cols-1 md:grid-cols-4 gap-8 lg:gap-12">
            
            <!-- Brand Column -->
            <div class="space-y-4 md:col-span-1">
                <div class="flex items-center space-x-3">
                    <div class="w-10 h-10 rounded-2xl bg-gradient-to-tr from-amber-400 via-rose-400 to-sky-400 flex items-center justify-center shadow-lg shadow-amber-400/25">
                        <i data-lucide="sparkles" class="w-5 h-5 text-white"></i>
                    </div>
                    <span class="text-2xl font-black text-white tracking-tight">
                        KAN
                    </span>
                </div>
                <p class="text-sm text-slate-400 leading-relaxed">
                    Joyful early childhood and interactive learning platform. Phonics sing-alongs, playful counting, finger painting, and glowing star rewards for curious young minds.
                </p>
                <div class="flex items-center space-x-3 pt-2">
                    <a href="#" class="w-8 h-8 rounded-xl bg-slate-800 hover:bg-amber-500 hover:text-white flex items-center justify-center transition-colors">
                        <i data-lucide="twitter" class="w-4 h-4"></i>
                    </a>
                    <a href="#" class="w-8 h-8 rounded-xl bg-slate-800 hover:bg-amber-500 hover:text-white flex items-center justify-center transition-colors">
                        <i data-lucide="github" class="w-4 h-4"></i>
                    </a>
                    <a href="#" class="w-8 h-8 rounded-xl bg-slate-800 hover:bg-amber-500 hover:text-white flex items-center justify-center transition-colors">
                        <i data-lucide="linkedin" class="w-4 h-4"></i>
                    </a>
                </div>
            </div>

            <!-- Quick Links -->
            <div>
                <h4 class="text-xs font-extrabold uppercase tracking-wider text-slate-200 mb-4">Explore</h4>
                <ul class="space-y-2.5 text-sm font-medium">
                    <li><a href="{{ route('courses.index') }}" class="hover:text-amber-400 transition-colors">All Activities</a></li>
                    <li><a href="{{ route('certificate.verify') }}" class="hover:text-amber-400 transition-colors">Verify Star Certificate</a></li>
                    <li><a href="{{ route('courses.index', ['price' => 'free']) }}" class="hover:text-amber-400 transition-colors">Free Play Activities</a></li>
                    <li><a href="{{ route('register', ['role' => 'instructor']) }}" class="hover:text-amber-400 transition-colors">Teach on KAN</a></li>
                </ul>
            </div>

            <!-- Learning Categories -->
            <div>
                <h4 class="text-xs font-extrabold uppercase tracking-wider text-slate-200 mb-4">Play Categories</h4>
                <ul class="space-y-2.5 text-sm font-medium">
                    <li><a href="{{ route('courses.index', ['category' => 'phonics-abcs']) }}" class="hover:text-amber-400 transition-colors">Phonics & ABCs</a></li>
                    <li><a href="{{ route('courses.index', ['category' => 'numbers-counting']) }}" class="hover:text-amber-400 transition-colors">Numbers & Counting</a></li>
                    <li><a href="{{ route('courses.index', ['category' => 'colors-creative-arts']) }}" class="hover:text-amber-400 transition-colors">Colors & Creative Arts</a></li>
                    <li><a href="{{ route('courses.index', ['category' => 'animal-safari-nature']) }}" class="hover:text-amber-400 transition-colors">Animal Safari & Nature</a></li>
                </ul>
            </div>

            <!-- Trust & Features -->
            <div>
                <h4 class="text-xs font-extrabold uppercase tracking-wider text-slate-200 mb-4">Why KAN</h4>
                <div class="space-y-3 text-xs">
                    <div class="flex items-start space-x-2.5">
                        <i data-lucide="check-circle" class="w-4 h-4 text-emerald-400 mt-0.5 flex-shrink-0"></i>
                        <span>Play-based curricula crafted by certified Montessori educators.</span>
                    </div>
                    <div class="flex items-start space-x-2.5">
                        <i data-lucide="palette" class="w-4 h-4 text-amber-400 mt-0.5 flex-shrink-0"></i>
                        <span>Fun drawing assignments with personalized teacher star grading.</span>
                    </div>
                    <div class="flex items-start space-x-2.5">
                        <i data-lucide="award" class="w-4 h-4 text-rose-400 mt-0.5 flex-shrink-0"></i>
                        <span>Official verifiable Star Award certificates for little achievers.</span>
                    </div>
                </div>
            </div>

        </div>

        <div class="border-t border-slate-800/80 mt-12 pt-8 flex flex-col sm:flex-row items-center justify-between text-xs text-slate-500">
            <p>&copy; {{ date('Y') }} KAN. All rights reserved.</p>
            <div class="flex space-x-6 mt-4 sm:mt-0">
                <a href="#" class="hover:text-slate-400">Parent Guide</a>
                <a href="#" class="hover:text-slate-400">Privacy Policy</a>
                <a href="#" class="hover:text-slate-400">Terms of Service</a>
            </div>
        </div>
    </div>
</footer>
