<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\Request;

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\JobController;
use App\Http\Controllers\ApplicationController;

// ✅ Public Routes
Route::get('/', fn () => view('welcome'))->name('welcome');

// ✅ Authenticated Routes
Route::middleware(['auth', 'verified'])->group(function () {

    // Dashboard
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // Job Routes
    Route::resource('jobs', JobController::class);

    // Application Routes (Custom + Required)
    Route::get('/jobs/{job}/apply', [ApplicationController::class, 'create'])->name('applications.create');
    Route::post('/jobs/{job}/apply', [ApplicationController::class, 'store'])->name('applications.store');
    
    // 🔧 Route to fix the error (if Blade uses route('applications.index'))
    Route::get('/applications', [ApplicationController::class, 'index'])->name('applications.index');

    // ✅ Additional Custom Routes
    Route::get('/applications/my-applications', [ApplicationController::class, 'myApplications'])->name('applications.my-applications');
    Route::get('/applications/{application}', [ApplicationController::class, 'show'])->name('applications.show');
    Route::get('/applications/{application}/resume', [ApplicationController::class, 'downloadResume'])->name('applications.download-resume');

    // Profile Routes
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::put('/profile/password', [ProfileController::class, 'updatePassword'])->name('profile.password.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    Route::delete('/profile/picture', [ProfileController::class, 'removeProfilePicture'])->name('profile.remove-picture');
    Route::post('/profile/upload-resume', [ProfileController::class, 'uploadResume'])->name('profile.uploadResume');
});

// ✅ Resume Viewer (no auth)
Route::get('/resumes/{filename}', function ($filename) {
    $path = 'resumes/' . $filename;
    if (!Storage::disk('public')->exists($path)) {
        return response("File not found in storage: $path", 404);
    }
    return response()->file(storage_path('app/public/' . $path));
})->name('resume.view');

// ✅ Resume Upload Test
Route::get('/upload-test', fn () => view('upload-test'))->name('upload.test');

Route::post('/upload-test', function (Request $request) {
    $request->validate([
        'resume' => 'required|file|mimes:pdf,doc,docx|max:5120',
    ]);

    if ($request->hasFile('resume')) {
        $path = $request->file('resume')->store('test-resumes', 'public');
        return back()->with('success', 'Uploaded to: ' . $path);
    }

    return back()->with('error', 'Upload failed.');
})->name('upload.test.submit');

// ✅ Storage File Access (backup)
Route::get('storage/resumes/{file}', function ($file) {
    $path = storage_path("app/public/resumes/$file");
    if (!file_exists($path)) abort(404);
    return response()->file($path);
});

require __DIR__.'/auth.php';
Route::post('/upload', [ResumeUploadController::class, 'upload'])->name('resume.upload');