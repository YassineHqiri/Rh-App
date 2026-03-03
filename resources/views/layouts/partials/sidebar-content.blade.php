{{-- Logo & Brand --}}
<div class="flex items-center gap-3 mb-8 pb-6 border-b border-slate-700">
    <div class="flex items-center justify-center w-10 h-10 rounded-xl bg-gradient-to-br from-blue-400 to-blue-600 shadow-lg">
        <svg class="w-6 h-6 text-white" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" d="M13 10V3L4 14h7v7l9-11h-7z"/>
        </svg>
    </div>
    <div>
        <h1 class="text-lg font-bold text-white">AtlasTech HR</h1>
        <p class="text-xs text-slate-400">v2.0</p>
    </div>
</div>

{{-- Navigation Sections --}}
<nav class="flex flex-1 flex-col space-y-8">
    <!-- Main Navigation -->
    <div class="space-y-1">
        <p class="text-xs font-semibold text-slate-400 uppercase tracking-widest px-3 mb-3">Main</p>
        
        <a href="{{ route('dashboard') }}" 
           class="sidebar-nav-item group flex items-center gap-3 rounded-lg px-3 py-2.5 text-sm font-medium text-slate-300 hover:text-white {{ request()->routeIs('dashboard') ? 'active' : '' }}">
            <svg class="w-5 h-5 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 12l8.954-8.955c.44-.439 1.152-.439 1.591 0L21.75 12M4.5 9.75v10.125c0 .621.504 1.125 1.125 1.125H9.75v-4.875c0-.621.504-1.125 1.125-1.125h2.25c.621 0 1.125.504 1.125 1.125V21h4.125c.621 0 1.125-.504 1.125-1.125V9.75M8.25 21h8.25"/>
            </svg>
            <span>Dashboard</span>
            <div class="ml-auto w-1.5 h-1.5 rounded-full bg-blue-400 opacity-0 group-hover:opacity-100 transition"></div>
        </a>

        <a href="{{ route('employees.index') }}" 
           class="sidebar-nav-item group flex items-center gap-3 rounded-lg px-3 py-2.5 text-sm font-medium text-slate-300 hover:text-white {{ request()->routeIs('employees.*') ? 'active' : '' }}">
            <svg class="w-5 h-5 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" d="M15 19.128a9.38 9.38 0 002.625.372 9.337 9.337 0 004.121-.952 4.125 4.125 0 00-7.533-2.493M15 19.128v-.003c0-1.113-.285-2.16-.786-3.07M15 19.128v.106A12.318 12.318 0 018.624 21c-2.331 0-4.512-.645-6.374-1.766l-.001-.109a6.375 6.375 0 0111.964-3.07M12 6.375a3.375 3.375 0 11-6.75 0 3.375 3.375 0 016.75 0zm8.25 2.25a2.625 2.625 0 11-5.25 0 2.625 2.625 0 015.25 0z"/>
            </svg>
            <span>Employees</span>
            <div class="ml-auto w-1.5 h-1.5 rounded-full bg-green-400 opacity-0 group-hover:opacity-100 transition"></div>
        </a>

        <a href="{{ route('departments.index') }}" 
           class="sidebar-nav-item group flex items-center gap-3 rounded-lg px-3 py-2.5 text-sm font-medium text-slate-300 hover:text-white {{ request()->routeIs('departments.*') ? 'active' : '' }}">
            <svg class="w-5 h-5 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" d="M3.375 19.5h17.25m-17.25 0a1.125 1.125 0 01-1.125-1.125M3.375 19.5h0c0 .621.504 1.125 1.125 1.125m17.25 0a1.125 1.125 0 001.125-1.125m0 0V5.25m0 0H21m0 0V3.75m0 0a1.125 1.125 0 00-1.125-1.125M3.375 3.75V5.25m0 0H3m0 0a1.125 1.125 0 011.125-1.125M9.75 9.375c0-.621.504-1.125 1.125-1.125h3.75c.621 0 1.125.504 1.125 1.125v3.75c0 .621-.504 1.125-1.125 1.125h-3.75c-.621 0-1.125-.504-1.125-1.125v-3.75z"/>
            </svg>
            <span>Departments</span>
            <div class="ml-auto w-1.5 h-1.5 rounded-full bg-amber-400 opacity-0 group-hover:opacity-100 transition"></div>
        </a>
    </div>

    <!-- Management Section -->
    <div class="space-y-1">
        <p class="text-xs font-semibold text-slate-400 uppercase tracking-widest px-3 mb-3">Management</p>
        
        <a href="{{ route('salaries.index') }}" 
           class="sidebar-nav-item group flex items-center gap-3 rounded-lg px-3 py-2.5 text-sm font-medium text-slate-300 hover:text-white {{ request()->routeIs('salaries.*') ? 'active' : '' }}">
            <svg class="w-5 h-5 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" d="M12 6v12m-3-2.818l.879.659c1.171.879 3.07.879 4.242 0 1.172-.879 1.172-2.303 0-3.182C13.536 12.219 12.768 12 12 12c-.725 0-1.45-.22-2.003-.659-1.106-.879-1.106-2.303 0-3.182s2.9-.879 4.006 0l.415.33M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
            </svg>
            <span>Salary & Payroll</span>
            <div class="ml-auto w-1.5 h-1.5 rounded-full bg-purple-400 opacity-0 group-hover:opacity-100 transition"></div>
        </a>

        <a href="{{ route('leaves.index') }}" 
           class="sidebar-nav-item group flex items-center gap-3 rounded-lg px-3 py-2.5 text-sm font-medium text-slate-300 hover:text-white {{ request()->routeIs('leaves.*') ? 'active' : '' }}">
            <svg class="w-5 h-5 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" d="M6.75 3v2.25M17.25 3v2.25M3 18.75V7.5a2.25 2.25 0 012.25-2.25h13.5A2.25 2.25 0 0121 7.5v11.25m-18 0A2.25 2.25 0 005.25 21h13.5A2.25 2.25 0 0021 18.75m-18 0v-7.5A2.25 2.25 0 015.25 9h13.5A2.25 2.25 0 0121 11.25v7.5"/>
            </svg>
            <span>Leave Management</span>
            <div class="ml-auto w-1.5 h-1.5 rounded-full bg-rose-400 opacity-0 group-hover:opacity-100 transition"></div>
        </a>
    </div>

    <!-- Admin Section -->
    @if(Auth::user()->isItAdmin() || Auth::user()->isAdmin())
    <div class="space-y-1">
        <p class="text-xs font-semibold text-slate-400 uppercase tracking-widest px-3 mb-3">Administration</p>
        
        @if(Auth::user()->isItAdmin())
        <a href="{{ route('users.index') }}" 
           class="sidebar-nav-item group flex items-center gap-3 rounded-lg px-3 py-2.5 text-sm font-medium text-slate-300 hover:text-white {{ request()->routeIs('users.*') ? 'active' : '' }}">
            <svg class="w-5 h-5 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" d="M18 18.72a9.094 9.094 0 003.741-.479 3 3 0 00-4.682-2.72m.94 3.198l.001.031c0 .225-.012.447-.037.666A11.944 11.944 0 0112 21c-2.17 0-4.207-.576-5.963-1.584A6.062 6.062 0 016 18.719m12 0a5.971 5.971 0 00-.941-3.197m0 0A5.995 5.995 0 0012 12.75a5.995 5.995 0 00-5.058 2.772m0 0a3 3 0 00-4.681 2.72 8.986 8.986 0 003.74.477m.94-3.197a5.971 5.971 0 00-.94 3.197M15 6.75a3 3 0 11-6 0 3 3 0 016 0zm6 3a2.25 2.25 0 11-4.5 0 2.25 2.25 0 014.5 0zm-13.5 0a2.25 2.25 0 11-4.5 0 2.25 2.25 0 014.5 0z"/>
            </svg>
            <span>User Management</span>
            <div class="ml-auto w-1.5 h-1.5 rounded-full bg-indigo-400 opacity-0 group-hover:opacity-100 transition"></div>
        </a>
        @endif

        @if(Auth::user()->isAdmin())
        <a href="{{ route('audit.index') }}" 
           class="sidebar-nav-item group flex items-center gap-3 rounded-lg px-3 py-2.5 text-sm font-medium text-slate-300 hover:text-white {{ request()->routeIs('audit.*') ? 'active' : '' }}">
            <svg class="w-5 h-5 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" d="M9 12h3.75M9 15h3.75M9 18h3.75m3 .75H18a2.25 2.25 0 002.25-2.25V6.108c0-1.135-.845-2.098-1.976-2.192a48.424 48.424 0 00-1.123-.08m-5.801 0c-.065.21-.1.433-.1.664 0 .414.336.75.75.75h4.5a.75.75 0 00.75-.75 2.25 2.25 0 00-.1-.664m-5.8 0A2.251 2.251 0 0113.5 2.25H15c1.012 0 1.867.668 2.15 1.586m-5.8 0c-.376.023-.75.05-1.124.08C9.095 4.01 8.25 4.973 8.25 6.108V8.25m0 0H4.875c-.621 0-1.125.504-1.125 1.125v11.25c0 .621.504 1.125 1.125 1.125h9.75c.621 0 1.125-.504 1.125-1.125V9.375c0-.621-.504-1.125-1.125-1.125H8.25zM6.75 12h.008v.008H6.75V12zm0 3h.008v.008H6.75V15zm0 3h.008v.008H6.75V18z"/>
            </svg>
            <span>Audit Logs</span>
            <div class="ml-auto w-1.5 h-1.5 rounded-full bg-cyan-400 opacity-0 group-hover:opacity-100 transition"></div>
        </a>
        @endif
    </div>
    @endif
</nav>

{{-- Footer Info --}}
<div class="border-t border-slate-700 pt-4">
    <div class="flex items-center gap-2 px-3 py-3 rounded-lg bg-slate-800/50">
        <svg class="w-4 h-4 text-cyan-400 flex-shrink-0" fill="currentColor" viewBox="0 0 24 24">
            <path d="M12 1C6.48 1 2 5.48 2 11s4.48 10 10 10 10-4.48 10-10S17.52 1 12 1zm-2 15l-5-5 1.41-1.41L10 12.17l7.59-7.59L19 6l-9 9z"/>
        </svg>
        <div>
            <p class="text-xs font-semibold text-slate-300">System Status</p>
            <p class="text-xs text-slate-400">Secure & Active</p>
        </div>
    </div>
</div>