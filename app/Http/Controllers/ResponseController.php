<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Carbon;

class ResponseController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $i = 1;
        $submittedBy = auth()->user()->id;
        $formId = $request->input('form_id');
        $fieldNames = $request->input('fieldNames');
        $fieldAnswers = $request->input('fieldAnswers');

        foreach ($fieldNames as $fieldName => $fieldLabel) {
            $answerKey = "ans" . $i++;
            $answer = $fieldAnswers[$answerKey] ?? null;

            if ($answer !== null) {
                $responseNo = $this->generateUniqueResponseNo();

                // Insert data into the response_fields table using DB::table
                DB::table('response_fields')->insert([
                    'response_no' => $responseNo,
                    'form_id' => $formId,
                    'submitted_by' => $submittedBy,
                    'field_name' => $fieldLabel, // Store field label in field_name column
                    'field_value' => $answer,    // Store answer in field_value column
                    'created_at' => Carbon::now(),
                    'updated_at' => Carbon::now(),
                ]);
            }
        }

        return response()->json(['message' => 'Form submitted successfully']);
        
        // Insert form data into `response_fields` table
        // DB::table('response_fields')->insert([
        //     'response_no' => $this->generateUniqueResponseNo(),
        //     'form_id' => $request->input('formData.form_id'),
        //     'submitted_by' => Auth::id(),
        //     'field_name' => '',
        //     'field_value' => $request->input('formData.selectedModel'),
        //     'created_at' => Carbon::now(),
        //     'updated_at' => Carbon::now()
        // ]);
    }

    private function generateUniqueResponseNo()
    {
        // Implement your logic to generate a unique response number here
        // This can be based on timestamps, UUIDs, or any other method you prefer
        
        $timestamp = now()->format('ymdHis');
        $userId = auth()->user()->id;

        $responseNo = $timestamp . '-' . $userId;

        return $responseNo;
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}