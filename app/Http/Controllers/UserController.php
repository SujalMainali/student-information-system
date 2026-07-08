<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function show(Request $request)
    {
        $user = User::query()
            ->select([
                'id',
                'name',
                'email',
                'email_verified_at',
                'created_at',
            ])
            ->with([
                'image' => fn ($query) => $query
                    ->select([
                        'id',
                        'imageable_id',
                        'imageable_type',
                        'image_path',
                        'created_at',
                    ]),
            ])
            ->findOrFail($request->user()->id);

        return view('me.show', compact('user'));
    }

    public function get_courses(Request $request)
    {
        $user = $request->user();

        if ($user->isStudent()) {
            $courses = $user->student->courses()->get();
        } else {
            $courses = collect(); // Empty collection for admin or other roles
        }

        return view('me.courses', compact('courses'));
    }
}
