<div class="relative" 
     x-data="{ 
        open: false,
        filter: 'all',
        notifications: [
            @if(Auth::check() && Auth::user()->isAdmin())
                { id: 1, title: 'New Course Enrollment', desc: 'Elena Rostova enrolled in Cloud Architecture & Microservices.', time: '10m ago', unread: true, icon: 'user-plus', color: 'blue', link: '{{ route('admin.enrollments.index') }}' },
                { id: 2, title: 'Assignment Submitted', desc: 'Marcus Thorne submitted Capstone Project for final grading.', time: '45m ago', unread: true, icon: 'clipboard-check', color: 'emerald', link: '{{ route('admin.assignments.index') }}' },
                { id: 3, title: 'Certificate Verified & Issued', desc: 'Certificate #KAN-2026-9812 verified with digital credential URL.', time: '2h ago', unread: true, icon: 'award', color: 'amber', link: '{{ route('admin.certificates.index') }}' },
                { id: 4, title: 'Platform Security & Uptime', desc: 'Automated health audit completed. System running at 99.9% uptime.', time: '5h ago', unread: false, icon: 'shield-check', color: 'indigo', link: '{{ route('admin.reports.index') }}' }
            @elseif(Auth::check() && Auth::user()->isInstructor())
                { id: 1, title: 'Submissions Awaiting Grading', desc: '2 students submitted Phonics Drawing activities ready for your evaluation.', time: '15m ago', unread: true, icon: 'clipboard-check', color: 'emerald', link: '{{ route('instructor.assignments.index') }}' },
                { id: 2, title: '5 New Students Enrolled', desc: 'New learners joined your interactive curriculum this morning.', time: '1h ago', unread: true, icon: 'users', color: 'blue', link: '{{ route('instructor.students.index') }}' },
                { id: 3, title: 'New 5-Star Course Review', desc: 'A student left a 5-star rating with positive feedback on your course.', time: '3h ago', unread: true, icon: 'star', color: 'amber', link: '{{ route('instructor.courses.index') }}' }
            @elseif(Auth::check())
                { id: 1, title: 'Assignment Graded! ⭐', desc: 'Your creative assignment received ⭐⭐⭐ Super Star with score 95/100!', time: '20m ago', unread: true, icon: 'award', color: 'emerald', link: '{{ route('student.assignments.index') }}' },
                { id: 2, title: 'Certificate of Completion Ready', desc: 'Congratulations! Your official verified certificate is ready to view & download.', time: '1h ago', unread: true, icon: 'award', color: 'blue', link: '{{ route('student.my-courses') }}' },
                { id: 3, title: 'New Lesson Published', desc: 'Lesson 4: Advanced Modules has been added to your enrolled course.', time: '4h ago', unread: true, icon: 'play-circle', color: 'indigo', link: '{{ route('student.my-courses') }}' }
            @endif
        ],
        init() {
            try {
                const userKey = '{{ Auth::id() ?? 0 }}';
                const cleared = localStorage.getItem('kan_notifs_cleared_' + userKey);
                if (cleared === 'true') {
                    this.notifications = [];
                } else {
                    const readIds = JSON.parse(localStorage.getItem('kan_notifs_read_' + userKey) || '[]');
                    if (Array.isArray(readIds)) {
                        this.notifications.forEach(n => {
                            if (readIds.includes(n.id)) {
                                n.unread = false;
                            }
                        });
                    }
                }
            } catch(e) {
                console.error('Notification storage error:', e);
            }
            this.$watch('open', () => this.$nextTick(() => { if (window.lucide) lucide.createIcons(); }));
            this.$watch('filter', () => this.$nextTick(() => { if (window.lucide) lucide.createIcons(); }));
        },
        get unreadCount() {
            return this.notifications.filter(n => n.unread).length;
        },
        get filteredNotifications() {
            if (this.filter === 'unread') {
                return this.notifications.filter(n => n.unread);
            }
            return this.notifications;
        },
        saveReadState() {
            try {
                const userKey = '{{ Auth::id() ?? 0 }}';
                const readIds = this.notifications.filter(n => !n.unread).map(n => n.id);
                localStorage.setItem('kan_notifs_read_' + userKey, JSON.stringify(readIds));
            } catch(e) {}
        },
        toggleRead(id) {
            const item = this.notifications.find(n => n.id === id);
            if (item) {
                item.unread = !item.unread;
                this.saveReadState();
                this.$nextTick(() => { if (window.lucide) lucide.createIcons(); });
            }
        },
        markAsRead(id) {
            const item = this.notifications.find(n => n.id === id);
            if (item && item.unread) {
                item.unread = false;
                this.saveReadState();
                this.$nextTick(() => { if (window.lucide) lucide.createIcons(); });
            }
        },
        markAllRead() {
            this.notifications.forEach(n => n.unread = false);
            this.saveReadState();
            this.$nextTick(() => { if (window.lucide) lucide.createIcons(); });
        },
        clearAll() {
            this.notifications = [];
            try {
                const userKey = '{{ Auth::id() ?? 0 }}';
                localStorage.setItem('kan_notifs_cleared_' + userKey, 'true');
            } catch(e) {}
            this.$nextTick(() => { if (window.lucide) lucide.createIcons(); });
        },
        restoreDemo() {
            try {
                const userKey = '{{ Auth::id() ?? 0 }}';
                localStorage.removeItem('kan_notifs_cleared_' + userKey);
                localStorage.removeItem('kan_notifs_read_' + userKey);
            } catch(e) {}
            location.reload();
        }
     }"
     @click.away="open = false">
    
    <!-- Bell Trigger Button -->
    <button @click="open = !open; $nextTick(() => { if (window.lucide) lucide.createIcons(); })" 
            type="button" 
            class="relative p-2 rounded-xl text-slate-500 hover:text-slate-800 hover:bg-slate-100 transition-colors focus:outline-none"
            title="Notifications">
        <i data-lucide="bell" class="w-4 h-4"></i>
        <template x-if="unreadCount > 0">
            <span class="absolute top-1.5 end-1.5 flex h-2 w-2">
                <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-rose-400 opacity-75"></span>
                <span class="relative inline-flex rounded-full h-2 w-2 bg-rose-500"></span>
            </span>
        </template>
    </button>

    <!-- Sleek, Proportioned Dropdown Modal / Flyout -->
    <div x-show="open" 
         x-transition:enter="transition ease-out duration-150" 
         x-transition:enter-start="transform opacity-0 scale-95" 
         x-transition:enter-end="transform opacity-100 scale-100" 
         x-transition:leave="transition ease-in duration-100" 
         x-transition:leave-start="transform opacity-100 scale-100" 
         x-transition:leave-end="transform opacity-0 scale-95" 
         class="absolute end-0 mt-2 w-80 sm:w-[350px] rounded-2xl bg-white shadow-xl shadow-slate-900/10 ring-1 ring-black/5 py-0 z-50 text-start overflow-hidden border border-slate-100 font-sans"
         style="display: none;">
        
        <!-- Header -->
        <div class="px-4 py-3 border-b border-slate-100 bg-white flex items-center justify-between">
            <div class="flex items-center space-x-2 rtl:space-x-reverse">
                <span class="text-xs font-bold uppercase tracking-wider text-slate-900">Notifications</span>
                <template x-if="unreadCount > 0">
                    <span class="px-2 py-0.5 rounded-full bg-rose-50 text-rose-600 text-[10px] font-semibold ring-1 ring-rose-500/20" x-text="unreadCount + ' unread'"></span>
                </template>
            </div>
            
            <div class="flex items-center space-x-2 rtl:space-x-reverse">
                <template x-if="unreadCount > 0">
                    <button @click="markAllRead()" type="button" class="text-[11px] font-semibold text-blue-600 hover:text-blue-700 hover:underline">
                        Mark all read
                    </button>
                </template>
            </div>
        </div>

        <!-- Filter Tabs -->
        <div class="px-4 py-1.5 border-b border-slate-100 bg-slate-50/60 flex items-center space-x-1.5 rtl:space-x-reverse text-xs">
            <button type="button" @click="filter = 'all'" 
                    class="px-2.5 py-1 rounded-lg text-[11px] font-semibold transition-all"
                    :class="filter === 'all' ? 'bg-white text-slate-900 shadow-2xs border border-slate-200' : 'text-slate-500 hover:text-slate-800 hover:bg-slate-100'">
                All (<span x-text="notifications.length"></span>)
            </button>
            <button type="button" @click="filter = 'unread'" 
                    class="px-2.5 py-1 rounded-lg text-[11px] font-semibold transition-all"
                    :class="filter === 'unread' ? 'bg-blue-600 text-white shadow-2xs' : 'text-slate-500 hover:text-slate-800 hover:bg-slate-100'">
                Unread (<span x-text="unreadCount"></span>)
            </button>
        </div>

        <!-- List Content (Balanced & Crisp with Zero-Reload Dynamic Toggle) -->
        <div class="max-h-72 overflow-y-auto divide-y divide-slate-100/80">
            <template x-for="item in filteredNotifications" :key="item.id">
                <div @click="toggleRead(item.id)" 
                     class="flex items-start p-3 hover:bg-slate-50/80 transition-colors group relative cursor-pointer select-none"
                     :class="item.unread ? 'bg-blue-50/25' : ''">
                    
                    <!-- Icon with Modern Corner Indicator Badge -->
                    <div class="relative flex-shrink-0 me-3 mt-0.5">
                        <div class="w-8 h-8 rounded-xl flex items-center justify-center shadow-2xs"
                             :class="item.color === 'blue' ? 'bg-blue-100 text-blue-600' : (item.color === 'emerald' ? 'bg-emerald-100 text-emerald-600' : (item.color === 'amber' ? 'bg-amber-100 text-amber-600' : 'bg-indigo-100 text-indigo-600'))">
                            <i :data-lucide="item.icon" class="w-4 h-4"></i>
                        </div>
                        <template x-if="item.unread">
                            <span class="absolute -top-0.5 -end-0.5 w-2.5 h-2.5 rounded-full bg-blue-600 ring-2 ring-white"></span>
                        </template>
                    </div>

                    <!-- Details -->
                    <div class="flex-1 min-w-0">
                        <div class="flex items-center justify-between gap-1.5 mb-0.5">
                            <h4 class="text-xs font-semibold text-slate-900 group-hover:text-blue-600 transition-colors truncate" x-text="item.title"></h4>
                            <span class="text-[10px] font-normal text-slate-400 bg-slate-100 px-1.5 py-0.5 rounded flex-shrink-0" x-text="item.time"></span>
                        </div>
                        <p class="text-[11px] text-slate-500 leading-snug font-normal mb-1.5" x-text="item.desc"></p>
                        
                        <div class="flex items-center justify-between pt-0.5">
                            <template x-if="item.link">
                                <a :href="item.link" 
                                   @click.stop="markAsRead(item.id)" 
                                   class="inline-flex items-center text-[10px] font-semibold text-blue-600 hover:text-blue-700 hover:underline space-x-1 rtl:space-x-reverse">
                                    <span>View Details</span>
                                    <i data-lucide="arrow-right" class="w-3 h-3"></i>
                                </a>
                            </template>
                            <button type="button" 
                                    @click.stop="toggleRead(item.id)" 
                                    class="text-[10px] text-slate-400 hover:text-slate-600 font-medium">
                                <span x-text="item.unread ? 'Mark read' : 'Mark unread'"></span>
                            </button>
                        </div>
                    </div>
                </div>
            </template>

            <!-- Empty State -->
            <template x-if="filteredNotifications.length === 0">
                <div class="py-7 px-4 text-center">
                    <div class="w-9 h-9 rounded-xl bg-slate-100 text-slate-400 flex items-center justify-center mx-auto mb-2">
                        <i data-lucide="bell-off" class="w-4 h-4"></i>
                    </div>
                    <p class="text-xs font-semibold text-slate-700">No notifications</p>
                    <p class="text-[11px] text-slate-400 font-normal mt-0.5">You're all caught up with recent activities.</p>
                </div>
            </template>
        </div>

        <!-- Footer -->
        <div class="px-4 py-2 border-t border-slate-100 bg-slate-50/50 flex items-center justify-between text-xs">
            <template x-if="notifications.length > 0">
                <button @click="clearAll()" type="button" class="text-slate-400 hover:text-rose-600 font-semibold transition-colors text-[11px]">
                    Clear all
                </button>
            </template>
            <template x-if="notifications.length === 0">
                <button @click="restoreDemo()" type="button" class="text-blue-600 hover:text-blue-700 font-semibold transition-colors text-[11px]">
                    Reset Notifications
                </button>
            </template>
            <span class="text-[10px] text-slate-400 font-normal">KAN Real-Time Sync</span>
        </div>

    </div>
</div>
