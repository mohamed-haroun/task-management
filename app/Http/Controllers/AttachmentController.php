<?php

namespace App\Http\Controllers;

use App\Models\Attachment;
use App\Models\Task;
use App\Traits\HttpResponses;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;

class AttachmentController extends Controller
{
    use HttpResponses;
    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request, Task $task)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'file' => ['file', 'mimes:jpg,jpeg,png,docx,xl,pdf', 'max:2048'],
        ]);

        // Store the file in storage\app\public folder
        $file = $request->file('file');
        $filePath = $file->store('attachments', 'public');

        $task->attachments()->create([
            'name' => $request->post('name'),
            'path' => $filePath,
        ]);

        return $this->success([
            'message' => 'File successfully uploaded',
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Task $task, Attachment $attachment)
    {
        $request->validate([
            'name' => 'sometimes|string|max:255',
            'file' => ['sometimes','file', 'mimes:jpg,jpeg,png', 'max:2048'],
        ]);

//        dd($request->all());

        // If the update includes new file
        if ($request->hasFile('file')) {
            // 1: Delete the old file
            File::delete(Storage::path('public/' . $attachment->path));

            // 2: Store the file in storage\app\public folder
            $file = $request->file('file');
            $filePath = $file->store('attachments', 'public');
        }

        $task->attachments()->update([
            'name' => $request->post('name'),
            'path' => $filePath ?? $attachment->path,
        ]);

        return $this->success([
            'message' => 'Attachment successfully updated',
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Task $task, Attachment $attachment)
    {

        File::delete(Storage::path('public/' . $attachment->path));

        $task->attachments()->where('id', $attachment->id)->delete();

        return $this->success([
            'message' => 'Attachment successfully deleted',
        ]);
    }
}
