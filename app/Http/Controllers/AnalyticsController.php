<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Models\Hospital;
use App\Models\Patient;
use App\Models\State;
use App\Models\Cancer;
use App\Models\Product;

class AnalyticsController extends Controller
{
    public function getNICRATAnalytics()
    {
        $hospitals = Hospital::withCount('patients')->get()->map(function ($hospital) {
            return [
                'name' => $hospital->hospitalShortName,
                'count' => $hospital->patients_count,
            ];
        });

        $stateOfOrigin = State::withCount('patientsOrigin')->get()->map(function ($state) {
            return [
                'name' => $state->stateName,
                'count' => $state->patients_origin_count,
            ];
        });

        $stateOfResidence = State::withCount('patientsResidence')->get()->map(function ($state) {
            return [
                'name' => $state->stateName,
                'count' => $state->patients_residence_count,
            ];
        });

        $cancerTypes = Cancer::withCount('patientsCancer')->get()->map(function ($cancerType) {
            return [
                'name' => $cancerType->cancerName,
                'count' => $cancerType->patients_cancer_count,
            ];
        });

        $products = Product::withCount('consumption')->get()->map(function ($product) {
            return [
                'name' => $product->productName,
                'count' => $product->consumption_count,
            ];
        });

        $gender = Patient::selectRaw('gender, COUNT(*) as count')
        ->groupBy('gender')
        ->get()
        ->map(function ($patient) {
            return [
                'name' => $patient->gender, // Gender name (Male/Female)
                'count' => $patient->count, // Correct count value
            ];
        });
    
        return response()->json([
            'hospitals' => $hospitals,
            'stateOfOrigin' => $stateOfOrigin,
            'stateOfResidence' => $stateOfResidence,
            'cancerTypes' => $cancerTypes,
            'products' => $products,
            'gender' => $gender,
        ]);
    }
}
