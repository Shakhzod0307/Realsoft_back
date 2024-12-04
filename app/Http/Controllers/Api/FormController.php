<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Form;
use CURLFile;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Telegram\Bot\Api;
use Telegram\Bot\FileUpload\InputFile;


class FormController extends Controller
{
    public function forms(Request $request)
    {
        $searchQuery = $request->input('search', '');
        $forms = Form::when($searchQuery, function ($query) use ($searchQuery) {
            $query->where(function ($q) use ($searchQuery) {
                $q->where('name', 'LIKE', "%{$searchQuery}%")
                    ->orWhere('company_name', 'LIKE', "%{$searchQuery}%")
                    ->orWhere('number', 'LIKE', "%{$searchQuery}%")
                    ->orWhere('email', 'LIKE', "%{$searchQuery}%")
                    ->orWhere('message', 'LIKE', "%{$searchQuery}%");
            });
        })
            ->paginate(20);
        return response()->json(['result'=>$forms],200);
    }

    public function postForm(Request $request)
    {
        try {
            $validatedData = $request->validate([
                'name' => 'required|string|max:255',
                'company_name' => 'required|string|max:255',
                'number' => 'required|string|max:20',
                'email' => 'nullable|email|max:255',
                'message' => 'required',
                'file' => 'nullable|file',
            ]);
            $filePath = null;
            if ($request->hasFile('file')) {
                $file = $request->file('file');
                $imageName = $file->getClientOriginalName();
                $file->move(public_path('forms'), $imageName);
                $filePath = $imageName;
            }
            $form = new Form();
            $form->name = $validatedData['name'];
            $form->company_name = $validatedData['company_name'];
            $form->number = $validatedData['number'];
            $form->email = $validatedData['email'];
            $form->message = $validatedData['message'];
            $form->file = $filePath;
            $form->save();
            $this->sendToTelegram($validatedData, $filePath,$form->id);
            return response()->json([
                'message' => 'Form submitted successfully!',
            ], 201);
        } catch (\Exception $e) {
            return response()->json([
                'error' => 'An error occurred while submitting the form.',
                'details' => $e->getMessage(),
            ], 500);
        }
    }
    private function sendToTelegram($validatedData, $filePath,$id): void
    {
        try {
            $telegram = new Api(env('TELEGRAM_BOT_TOKEN'));
            $chatId = env('TELEGRAM_CHAT_ID');
            $message = "*New Form Submission: No ".$id."*\n\n" .
                "*Name:* " . $validatedData['name'] . "\n" .
                "*Company:* " . $validatedData['company_name'] . "\n" .
                "*Email:* " . ($validatedData['email'] ?? 'Not provided') . "\n" .
                "*Phone:* " . $validatedData['number'] . "\n" .
                "*Message:* " . $validatedData['message'];

            $telegram->sendMessage([
                'chat_id' => $chatId,
                'text' => $message,
                'parse_mode' => 'Markdown',
            ]);

            if ($filePath) {
                $file = public_path('forms/' . $filePath);
                $extension = pathinfo($filePath, PATHINFO_EXTENSION);
                if (in_array(strtolower($extension), ['jpg', 'jpeg', 'png', 'gif', 'tiff', 'webp'])) {
                    $telegram->sendPhoto([
                        'chat_id' => $chatId,
                        'photo' => InputFile::create($file),
                        'caption' => 'Attached photo from form submission '.$id,
                    ]);
                } elseif (in_array(strtolower($extension), ['pdf', 'docx', 'txt', 'xlsx', 'pptx', 'csv', 'zip'])) {
                    $telegram->sendDocument([
                        'chat_id' => $chatId,
                        'document' => InputFile::create($file),
                        'caption' => 'Attached document from form submission '.$id,
                    ]);
                }
            }
        } catch (\Exception $e) {
            Log::error('Telegram message sending failed: ' . $e->getMessage());
        }
    }

}
