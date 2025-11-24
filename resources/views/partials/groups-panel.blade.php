@php
    // If $groups not provided, load a few for display
    $groups = $groups ?? \App\Models\Group::latest()->limit(8)->get();
@endphp

<div class="bg-white rounded-2xl shadow-lg border border-blue-900/10 overflow-hidden">
    <!-- Search Section -->
    <div class="p-4 bg-gradient-to-r from-blue-50 to-blue-100 border-b border-blue-200">
        <input 
            id="groupSearchInput"
            type="text"
            onkeyup="searchGroups()"
            class="w-full border-2 border-blue-300 rounded-full px-4 py-2 text-sm focus:outline-none focus:border-blue-900 focus:ring-2 focus:ring-blue-900/20 transition" 
            placeholder="Search circles..." 
        />
    </div>

    <!-- Circles List -->
    <div class="p-4">
        <h4 class="text-lg font-extrabold text-blue-900 mb-3 flex items-center gap-2">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path>
            </svg>
            Circles
        </h4>
        <ul id="groupsList" class="space-y-3 max-h-96 overflow-y-auto">
            @forelse($groups as $group)
                @php
                    $isOwner = $group->user_id === auth()->id();
                    $isMember = $group->users->where('id', auth()->id())->count() > 0;
                    $pendingRequest = auth()->check() ? \App\Models\GroupJoinRequest::where('group_id', $group->id)
                        ->where('user_id', auth()->id())
                        ->where('status', 'pending')
                        ->first() : null;
                @endphp
                <li class="p-3 bg-blue-50/50 rounded-xl border border-blue-100 hover:shadow-md transition">
                    <div class="flex items-start justify-between gap-2">
                        <div class="flex-1 min-w-0">
                            <div class="flex items-center gap-2 mb-1">
                                <div class="group-name font-bold text-sm text-blue-900 truncate">{{ $group->name }}</div>
                                @if($isOwner)
                                    <span class="text-xs px-2 py-0.5 bg-yellow-100 text-yellow-800 rounded-full font-bold">Author</span>
                                @elseif($isMember)
                                    <span class="text-xs px-2 py-0.5 bg-green-100 text-green-800 rounded-full font-bold">Member</span>
                                @endif
                            </div>
                            @if($group->description)
                                <div class="group-desc text-xs text-gray-600 mt-1 line-clamp-2">{{ \Illuminate\Support\Str::limit($group->description, 60) }}</div>
                            @endif
                            <div class="text-xs text-blue-600 mt-1 font-medium">{{ $group->users->count() }} members</div>
                        </div>

                        <div class="flex-shrink-0">
                            @auth
                                @if(!$isOwner)
                                    <form action="{{ route('groups.join', $group) }}" method="POST">
                                        @csrf
                                        @if($isMember)
                                            <button type="submit" class="text-xs px-3 py-1.5 rounded-full bg-red-100 text-red-700 font-bold hover:bg-red-200 border border-red-300 transition">
                                                Leave
                                            </button>
                                        @elseif($pendingRequest)
                                            <button type="submit" class="text-xs px-3 py-1.5 rounded-full bg-yellow-100 text-yellow-700 font-bold hover:bg-yellow-200 border border-yellow-300 transition">
                                                Pending
                                            </button>
                                        @else
                                            <button type="submit" class="text-xs px-3 py-1.5 rounded-full bg-blue-900 text-white font-bold hover:bg-blue-800 transition">
                                                Join
                                            </button>
                                        @endif
                                    </form>
                                @endif
                            @endauth
                        </div>
                    </div>
                </li>
            @empty
                <li class="text-center py-8 text-gray-400">
                    <svg class="w-12 h-12 mx-auto mb-2 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path>
                    </svg>
                    <p class="text-sm font-medium">No circles yet</p>
                </li>
            @endforelse
        </ul>
    </div>

    <!-- Create Circle Section -->
    <div class="p-4 bg-gradient-to-r from-blue-50 to-blue-100 border-t border-blue-200">
        <button 
            type="button"
            onclick="toggleCreateCircle()"
            class="w-full flex items-center justify-center gap-2 text-sm font-bold text-blue-900 hover:text-blue-700 transition mb-3"
        >
            <svg id="createCircleIcon" class="w-4 h-4 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
            </svg>
            <span id="createCircleText">Create a Circle</span>
        </button>
        
        <div id="createCircleForm" style="display: none;">
            @auth
                <form action="{{ route('groups.store') }}" method="POST" class="space-y-2">
                    @csrf
                    <input 
                        name="name" 
                        placeholder="Circle name" 
                        class="w-full border-2 border-blue-300 px-3 py-2 text-sm rounded-lg focus:outline-none focus:border-blue-900 focus:ring-2 focus:ring-blue-900/20 transition" 
                        required 
                    />
                    <textarea 
                        name="description" 
                        placeholder="Short description (optional)" 
                        class="w-full border-2 border-blue-300 px-3 py-2 text-sm rounded-lg focus:outline-none focus:border-blue-900 focus:ring-2 focus:ring-blue-900/20 transition resize-none" 
                        rows="2"
                    ></textarea>
                    <button class="w-full bg-blue-900 text-white px-4 py-2 rounded-lg font-bold hover:bg-blue-800 transition shadow-md">
                        Create Circle
                    </button>
                </form>
            @else
                <div class="text-xs text-gray-600 text-center py-3 bg-white rounded-lg">
                    Please login to create or join circles.
                </div>
            @endauth
        </div>
    </div>
</div>

<script>
function searchGroups() {
    const searchInput = document.getElementById('groupSearchInput');
    const query = searchInput.value.toLowerCase().trim();
    const groupItems = document.querySelectorAll('#groupsList li');
    
    groupItems.forEach(item => {
        const groupName = item.querySelector('.group-name')?.textContent.toLowerCase() || '';
        const groupDesc = item.querySelector('.group-desc')?.textContent.toLowerCase() || '';
        
        if (groupName.includes(query) || groupDesc.includes(query) || query === '') {
            item.style.display = '';
        } else {
            item.style.display = 'none';
        }
    });
}

function toggleCreateCircle() {
    const form = document.getElementById('createCircleForm');
    const icon = document.getElementById('createCircleIcon');
    const text = document.getElementById('createCircleText');
    
    if (form.style.display === 'none') {
        form.style.display = 'block';
        icon.style.transform = 'rotate(45deg)';
        text.textContent = 'Hide Form';
    } else {
        form.style.display = 'none';
        icon.style.transform = 'rotate(0deg)';
        text.textContent = 'Create a Circle';
    }
}
</script>
