<?php

namespace App\Http\Controllers;

use App\Models\Group;
use App\Models\GroupJoinRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class GroupController extends Controller
{
    public function index(Request $request)
    {
        $q = $request->input('q');

        $groups = Group::when($q, fn($query) => $query->where('name', 'like', "%{$q}%"))
            ->latest()
            ->limit(10)
            ->get();

        return view('partials.groups-panel', compact('groups'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
        ]);

        $group = Group::create([
            'name' => $request->input('name'),
            'description' => $request->input('description'),
            'user_id' => Auth::id(),
        ]);

        // owner automatically joins
        $group->users()->attach(Auth::id());

        return redirect()->back()->with('status', 'group-created');
    }

    public function join(Group $group)
    {
        $user = Auth::user();

        // Check if already a member
        if ($group->users()->where('user_id', $user->id)->exists()) {
            $group->users()->detach($user->id);
            // Also delete any join requests
            GroupJoinRequest::where('group_id', $group->id)
                ->where('user_id', $user->id)
                ->delete();
            return redirect()->back()->with('status', 'left-circle');
        }

        // Check if already has a pending request
        $existingRequest = GroupJoinRequest::where('group_id', $group->id)
            ->where('user_id', $user->id)
            ->first();

        if ($existingRequest) {
            // Cancel the request
            $existingRequest->delete();
            return redirect()->back()->with('status', 'request-cancelled');
        }

        // Create a new join request
        GroupJoinRequest::create([
            'group_id' => $group->id,
            'user_id' => $user->id,
            'status' => 'pending',
        ]);

        return redirect()->back()->with('status', 'request-sent');
    }

    public function approveRequest(GroupJoinRequest $request)
    {
        $group = $request->group;
        
        // Only owner can approve
        if ($group->user_id !== Auth::id()) {
            return redirect()->back()->with('error', 'Unauthorized');
        }

        $request->update(['status' => 'accepted']);
        $group->users()->attach($request->user_id);

        return redirect()->back()->with('status', 'request-approved');
    }

    public function declineRequest(GroupJoinRequest $request)
    {
        $group = $request->group;
        
        // Only owner can decline
        if ($group->user_id !== Auth::id()) {
            return redirect()->back()->with('error', 'Unauthorized');
        }

        $request->update(['status' => 'declined']);

        return redirect()->back()->with('status', 'request-declined');
    }
}
