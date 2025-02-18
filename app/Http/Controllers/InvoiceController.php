<?php

namespace App\Http\Controllers;

use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use App\Models\Billing; 
use App\Models\Hospital; 
use App\Models\HospitalStaff; 
use Illuminate\Support\Facades\Auth;
class InvoiceController extends Controller
{

    public function getHospitalId()  {
        $hospitalAdminId = Auth::id(); 
        
        // Retrieve the hospitalId of the logged-in admin from the HospitalStaff table
        $currentHospital = HospitalStaff::where('userId', $hospitalAdminId)->first();
    
        if (!$currentHospital) {
            return response()->json(['message' => 'Hospital admin not found'], 404);
        }
    
        return $currentHospital->hospitalId;
    
      }

    public function generateInvoice(Request $request)
    {
        // Get hospital
        $hospitalId = $this->getHospitalId();
        $hospital = Hospital::where('hospitalId', $hospitalId)->first();
        // Retrieve data for all patients' bills, or you can filter as needed.
        $billings = Billing::selectRaw('transactionId, patientId, SUM(cost) as total_cost')
    ->where('hospitalId', $this->getHospitalId())
    ->groupBy('transactionId', 'patientId')
    ->get();


        // Calculate total for all patients.
        $totalAmount = $billings->sum('total_cost');

        // Prepare the data for the invoice.
        $data = [
            'invoiceDate' => now()->format('d/m/Y'),
            'invoiceNumber' => 'INV-' . strtoupper(uniqid()),
            'billings' => $billings,
            'totalAmount' => $totalAmount,
            'hospitalName' => $hospital->hospitalName,
        ];

        // Load a view and pass the data to the PDF.
        $pdf = Pdf::loadView('invoices', $data);

        // Return the generated PDF to the browser for download.
        return $pdf->download('bulk_invoice.pdf');
    }
}

