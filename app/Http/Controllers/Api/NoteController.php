<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Note;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class NoteController extends Controller
{
    /**
     * Format the response based on Accept header
     */
    private function format($data, $status = 200)
    {
        $acceptHeader = strtolower(request()->header('Accept', ''));
        $formatParam = strtolower(request()->get('format', ''));

        // Check if XML is requested
        if (
            str_contains($acceptHeader, 'application/xml') ||
            str_contains($acceptHeader, 'text/xml') ||
            ($formatParam === 'xml' && str_contains($acceptHeader, '*/*'))
        ) {
            return $this->convertToXml($data, $status);
        }

        // Default to JSON
        return response()->json($data, $status);
    }

    /**
     * Convert data to XML format
     */
    private function convertToXml($data, $status = 200)
    {
        try {
            // Create XML root element
            $xml = new \SimpleXMLElement('<?xml version="1.0" encoding="UTF-8"?><response></response>');
            
            // Add success flag - handle different possible formats
            $successValue = $data['success'] ?? false;
            $xml->addChild('success', $successValue ? '1' : '0');
            
            // Handle the data element
            if (isset($data['data'])) {
                $dataElement = $xml->addChild('data');
                
                // Get the data
                $dataContent = $data['data'];
                
                // Convert Eloquent objects to array
                if ($dataContent instanceof \Illuminate\Database\Eloquent\Model) {
                    $dataContent = $dataContent->toArray();
                } elseif ($dataContent instanceof \Illuminate\Database\Eloquent\Collection) {
                    $dataContent = $dataContent->toArray();
                }
                
                // Check if data is an array
                if (is_array($dataContent)) {
                    if (empty($dataContent)) {
                        // Empty array
                        $dataElement[0] = '';
                    } elseif (array_keys($dataContent) === range(0, count($dataContent) - 1)) {
                        // It's a list (indexed array) - multiple notes
                        $notesElement = $dataElement->addChild('notes');
                        foreach ($dataContent as $note) {
                            $noteElement = $notesElement->addChild('note');
                            $this->addArrayToXml($note, $noteElement);
                        }
                    } else {
                        // It's a single note (associative array)
                        $this->addArrayToXml($dataContent, $dataElement);
                    }
                } else {
                    // Data is not an array (could be string, null, etc.)
                    $dataElement[0] = (string) $dataContent;
                }
            }
            
            // Add message if present
            if (isset($data['message'])) {
                $xml->addChild('message', htmlspecialchars($data['message'], ENT_XML1, 'UTF-8'));
            }

            return response($xml->asXML(), $status)
                ->header('Content-Type', 'application/xml');

        } catch (\Exception $e) {
            Log::error('XML conversion failed: ' . $e->getMessage());
            Log::error('Data being converted: ' . print_r($data, true));
            // Fall back to JSON on error
            return response()->json($data, $status);
        }
    }

    /**
     * Recursively add array data to XML element
     */
    private function addArrayToXml($data, &$xml)
    {
        if (!is_array($data)) {
            return;
        }
        
        foreach ($data as $key => $value) {
            // Sanitize the key name for XML
            $key = $this->sanitizeXmlKey($key);
            
            if (is_array($value)) {
                // For nested arrays, create a child element
                $child = $xml->addChild($key);
                $this->addArrayToXml($value, $child);
            } elseif (is_object($value)) {
                // Convert objects to string if possible
                $xml->addChild($key, htmlspecialchars((string) $value, ENT_XML1, 'UTF-8'));
            } else {
                // Simple value
                $xml->addChild($key, htmlspecialchars((string) $value, ENT_XML1, 'UTF-8'));
            }
        }
    }

    /**
     * Sanitize XML element names
     */
    private function sanitizeXmlKey($key)
    {
        // Replace any non-alphanumeric characters with underscores
        $key = preg_replace('/[^a-zA-Z0-9_-]/', '_', (string) $key);
        
        // Ensure the key doesn't start with a number
        if (empty($key) || is_numeric(substr($key, 0, 1))) {
            $key = 'item_' . $key;
        }
        
        return $key;
    }

    /* -------------------------------------------------
     *  RESOURCE ENDPOINTS
     * -------------------------------------------------*/

    public function index()
    {
        return $this->format([
            'success' => true,
            'data' => Note::all(),
        ]);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|string',
        ]);

        $note = Note::create($validated);

        return $this->format([
            'success' => true,
            'message' => 'Note created successfully',
            'data' => $note,
        ], 201);
    }

    public function show(Note $note)
    {
        return $this->format([
            'success' => true,
            'data' => $note,
        ]);
    }

    public function update(Request $request, Note $note)
    {
        $validated = $request->validate([
            'title' => 'sometimes|required|string|max:255',
            'content' => 'sometimes|required|string',
        ]);

        $note->update($validated);

        return $this->format([
            'success' => true,
            'message' => 'Note updated successfully',
            'data' => $note,
        ]);
    }

    public function destroy(Note $note)
    {
        $note->delete();

        return $this->format([
            'success' => true,
            'message' => 'Note deleted successfully',
        ]);
    }
}