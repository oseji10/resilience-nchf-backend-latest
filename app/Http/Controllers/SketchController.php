<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Sketch;
use App\Models\Encounters;
use Illuminate\Support\Facades\Storage;

class SketchController extends Controller
{
    public function saveSketches(Request $request)
    {
        // Validate incoming request data
        $validated = $request->validate([
            'rightEyeFront' => 'required|string',
            'rightEyeBack' => 'required|string',
            'leftEyeFront' => 'required|string',
            'leftEyeBack' => 'required|string',
            'patientId' => 'required|string',
            'encounterId' => 'required|string'
        ]);
    
        // Convert base64 to image and store it
        $rightEyeFrontImage = $this->saveBase64Image($validated['rightEyeFront'], 'right_eye_front');
        $rightEyeBackImage = $this->saveBase64Image($validated['rightEyeBack'], 'right_eye_back');
        $leftEyeFrontImage = $this->saveBase64Image($validated['leftEyeFront'], 'left_eye_front');
        $leftEyeBackImage = $this->saveBase64Image($validated['leftEyeBack'], 'left_eye_back');
    
        // Create a new sketch entry in the database with the file paths
        $sketch = Sketch::create([
            'right_eye_front' => $rightEyeFrontImage,
            'right_eye_back' => $rightEyeBackImage,
            'left_eye_front' => $leftEyeFrontImage,
            'left_eye_back' => $leftEyeBackImage,
            'patientId' => $request->patientId,
            'encounterId' => $request->encounterId
        ]);
    
        // Update the encounter record with the sketchId
        $encounter = Encounters::where('encounterId', $request->encounterId)->first();
    
        if ($encounter) {
            $encounter->update([
                'sketchId' => $sketch->sketchId, // Use the generated sketchId
            ]);
        }
    
        // Return a response to the frontend
        return response()->json([
            'message' => 'Sketches saved successfully',
            'sketchId' => $sketch->sketchId, // Include the sketchId in the response
            'sketch' => $sketch
        ], 200);
    }
    

    private function saveBase64Image($base64Data, $imageName)
    {
        // Remove the base64 prefix (data:image/png;base64,)
        $imageData = preg_replace('/^data:image\/\w+;base64,/', '', $base64Data);
        $imageData = base64_decode($imageData);

        // Generate a unique filename for each image
        $filename = $imageName . '_' . uniqid() . '.png';

        // Save the image in the public/images folder
        Storage::put('public/images/' . $filename, $imageData);

        // Return the file path to store in the database
        return 'images/' . $filename; // This will be the relative URL to the image
    }
}
