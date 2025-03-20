<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\UserRequest;
use App\Models\User;
use App\Services\ImageService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class UserController extends Controller
{
    protected $imageService;

    public function __construct(ImageService $imageService)
    {
        $this->imageService = $imageService;
    }
    public function index()
    {
        $users = User::get();
        return view('admin.users.index', compact('users'));
    } // index

    public function create()
    {
        return view('admin.users.create');
    } // create

    public function store(UserRequest $request)
    {
        $user = User::create($request->validated());

        // Check if a profile image is uploaded
        if ($request->hasFile('profile_image') || ! $request->file('profile_image')->isValid()) {
            $imagePaths = $this->imageService->uploadProfileImage($request->file('profile_image'), $user->id);

            // Save image paths in the user model
            $user->update([
                'profile_image' => $imagePaths['profile_image'],
                'thumbnail'     => $imagePaths['thumbnail'],
            ]);
        }
        return redirect()->route('admin.users.index');
    } // store

    public function show(User $user)
    {
        return view('admin.users.show', compact('user'));
    } // show

    public function edit(User $user)
    {
        return view('admin.users.edit', compact('user'));
    } // edit

    public function update(UserRequest $request, User $user)
    {
        $oldProfileImagePath = $user->profile_image;
        $oldThumbnailPath    = $user->thumbnail;

        $validatedData = collect($request->validated())->except('profile_image')->toArray();
        $user->update($validatedData);

        if ($request->hasFile('profile_image') && $request->file('profile_image')->isValid()) {

            $imagePaths = $this->imageService->uploadProfileImage($request->file('profile_image'), $user->id);

            $user->update([
                'profile_image' => $imagePaths['profile_image'],
                'thumbnail'     => $imagePaths['thumbnail'],
            ]);

            if (is_string($oldProfileImagePath) && ! empty($oldProfileImagePath)) {
                $cleanPath = str_replace('storage/', '', $oldProfileImagePath);
                Storage::disk('public')->delete($cleanPath);
            }

            if (is_string($oldThumbnailPath) && ! empty($oldThumbnailPath)) {
                $thumbPath = str_replace('storage/', '', $oldThumbnailPath);
                Storage::disk('public')->delete($thumbPath);
            }
        }

        return redirect()->route('admin.users.index');
    } // update

    public function destroy(User $user)
    {
        $oldProfileImagePath = $user->profile_image;
        $oldThumbnailPath    = $user->thumbnail;

        if (is_string($oldProfileImagePath) && ! empty($oldProfileImagePath)) {
            $cleanPath = str_replace('storage/', '', $oldProfileImagePath);
            Storage::disk('public')->delete($cleanPath);
        }

        if (is_string($oldThumbnailPath) && ! empty($oldThumbnailPath)) {
            $thumbPath = str_replace('storage/', '', $oldThumbnailPath);
            Storage::disk('public')->delete($thumbPath);
        }

        $user->delete();
        return redirect()->route('admin.users.index');
    } // destroy

    public function updateVerifiedStatus(Request $request)
    {
        $user              = User::findOrFail($request->user_id);
        $user->is_verified = $request->is_verified;
        $user->save();

        return response()->json(['success' => true]);
    }

}
