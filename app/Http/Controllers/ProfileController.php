<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileUpdateRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;
use Illuminate\Validation\Rules\Password;
use Illuminate\Http\JsonResponse;
use Smalot\PdfParser\Parser as SmalotParser;
use Spatie\PdfToText\Pdf;

class ProfileController extends Controller
{
    public function edit(Request $request): View
    {
        return view('profile.edit', [
            'user' => $request->user(),
        ]);
    }

    public function update(ProfileUpdateRequest $request): RedirectResponse
    {
        $user = $request->user();
        $user->fill($request->validated());

        if ($user->isDirty('email')) {
            $user->email_verified_at = null;
        }

        if ($request->hasFile('profile_picture')) {
            if ($user->profile_picture) {
                Storage::disk('public')->delete($user->profile_picture);
            }
            $path = $request->file('profile_picture')->store('profile-pictures', 'public');
            $user->profile_picture = $path;
        }

        $user->save();
        return Redirect::route('profile.edit')->with('status', 'profile-updated');
    }

    public function updatePassword(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'current_password' => ['required', 'current_password'],
            'password' => ['required', Password::defaults(), 'confirmed'],
        ]);

        $request->user()->update([
            'password' => Hash::make($validated['password']),
        ]);

        return back()->with('status', 'password-updated');
    }

    public function destroy(Request $request): RedirectResponse
    {
        $request->validate([
            'password' => ['required', 'current_password'],
        ]);

        $user = $request->user();

        if ($user->profile_picture) {
            Storage::disk('public')->delete($user->profile_picture);
        }

        Auth::logout();
        $user->delete();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return Redirect::to('/');
    }

    public function removeProfilePicture(Request $request): RedirectResponse
    {
        $user = $request->user();

        if ($user->profile_picture) {
            Storage::disk('public')->delete($user->profile_picture);
            $user->profile_picture = null;
            $user->save();
        }

        return back()->with('status', 'profile-picture-removed');
    }

    public function uploadResume(Request $request): JsonResponse
    {
        $request->validate([
            'resume' => 'required|file|mimes:pdf|max:2048',
        ]);

        $file = $request->file('resume');
        $path = $file->store('resumes', 'public');
        $fullPath = storage_path('app/public/' . $path);

        try {
            $text = Pdf::getText($fullPath);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'error' => 'Failed to extract text: ' . $e->getMessage()
            ]);
        }

        try {
            $parser = new SmalotParser();
            $pdf = $parser->parseFile($fullPath);
            $details = $pdf->getDetails();
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'error' => 'Failed to parse PDF: ' . $e->getMessage()
            ]);
        }

        $parsedData = [
            'name' => $this->extractName($text),
            'email' => $this->extractEmail($text),
            'skills' => $this->extractSkills($text),
            'experience' => $this->extractExperience($text),
        ];

        // Automatically save to user profile
        $user = $request->user();
        if ($parsedData['name'] !== 'Not found') {
            $user->name = $parsedData['name'];
        }
        if ($parsedData['email'] !== 'Not found') {
            $user->email = $parsedData['email'];
        }
        $user->skills = $parsedData['skills'] ?? null;
        $user->experience = $parsedData['experience'] ?? null;
        $user->save();

        return response()->json([
            'success' => true,
            'parsedData' => $parsedData,
            'raw_text' => $text,
            'meta' => $details,
            'path' => $path,
        ]);
    }

    private function extractName(string $text): string
    {
        preg_match('/Name[:\s]+([A-Z][a-z]+\s[A-Z][a-z]+)/', $text, $matches);
        return $matches[1] ?? 'Not found';
    }

    private function extractEmail(string $text): string
    {
        preg_match('/[a-z0-9.\-_]+@[a-z0-9\-_]+\.[a-z]{2,}/i', $text, $matches);
        return $matches[0] ?? 'Not found';
    }

    private function extractSkills(string $text): string
    {
        preg_match('/Skills\s*[:\-]?\s*(.+?)(\n|\r)/i', $text, $matches);
        return $matches[1] ?? 'Not found';
    }

    private function extractExperience(string $text): string
    {
        preg_match('/Experience\s*[:\-]?\s*(.+?)(\n|\r)/i', $text, $matches);
        return $matches[1] ?? 'Not found';
    }
}
