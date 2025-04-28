<?php

namespace Pratiksh\Imperium\Http\Controllers;

use Illuminate\Http\Request;

class FileUploadController extends Controller
{
    // Process the file upload
    public function process(Request $request): string
    {
        $files = $request->allFiles();

        if (empty($files)) {
            abort(422, 'No files were uploaded.');
        }

        if (count($files) > 1) {
            abort(422, 'Only 1 file can be uploaded at a time.');
        }

        $requestKey = array_key_first($files);

        $file = is_array($request->input($requestKey))
            ? $request->file($requestKey)[0]
            : $request->file($requestKey);

        // Get File name removing whitespace and special symbols replace with -
        $filename = preg_replace('/[^a-zA-Z0-9.]/', '-', $file->getClientOriginalName());

        return $file->storeAs('/uploads/tmp/', $filename, 'public');
    }

    // Revert the file upload
    public function revert(Request $request)
    {
        $file = $request->input('file');

        if (empty($file)) {
            abort(422, 'No file was uploaded.');
        }

        // If the file exists, delete it
        if (file_exists(public_path('storage/'.$file))) {
            unlink(public_path('storage/'.$file));
        }
    }
}
