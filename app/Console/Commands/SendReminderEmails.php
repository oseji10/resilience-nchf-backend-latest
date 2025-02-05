<?php

namespace App\Console\Commands;

use App\Mail\MembershipReminderEmail;
use App\Models\User;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Mail;
use Carbon\Carbon;
use App\Models\Patients;
use App\Models\Appointments;
use App\Models\Encounters;
use App\Models\Doctors;
use DB;
use App\Models\User\BasicSetting;
use Illuminate\Support\Facades\Log;
use App\Mail\AppointmentEmail;
use App\Mail\AppointmentReminderEmail;
class SendReminderEmails extends Command
{
    protected $signature = 'send:reminder-emails';
    protected $description = 'Send reminder emails to users who have have upcoming appointments';

    public function __construct()
    {
        parent::__construct();
    }
    // // Log the response
    // Log::info('Appointments Retrieved:', ['data' => $appointment]);

    
    public function handle()
    {
        $today = Carbon::today();
        $endDate = $today->copy()->addDays(7);
    
        // Retrieve all upcoming appointments within the next 7 days
        $appointments = Appointments::whereBetween('appointmentDate', [$today, $endDate])->get();
    
        if ($appointments->isEmpty()) {
            Log::info('No upcoming appointments found.');
            return;
        }
    
        foreach ($appointments as $appointment) {
            $encounter = Encounters::where('encounterId', $appointment->encounterId)->first();
        
            if (!$encounter) {
                Log::warning("Encounter not found for appointment ID: {$appointment->appointmentId}");
                continue;
            }
        
            $patient = Patients::where('patientId', $encounter->patientId)->first();
            
            // if (is_object($patient) && isset($patient->email)) {
            //     $patientEmail = $patient->email; // Ensure it's a string
            // } elseif (is_array($patient) && isset($patient['email'])) {
            //     $patientEmail = $patient['email']; // Handle array case
            // } else {
            //     Log::error("Invalid patient email format: " . json_encode($patient));
            //     $patientEmail = 'a@rachel.com'; // Fallback
            // }
            
        // Log::info('Patient Email:', ['email' => $patientEmail]);
            $doctor = Doctors::where('doctorId', $appointment->doctor)->first();
            if (!$doctor) {
                Log::warning("Doctor not found for appointment ID: {$appointment->id}");
                continue;
            }
        
            $appointmentDate = $appointment->appointmentDate;
            $appointmentTime = $appointment->appointmentTime;
            $doctorName = $doctor->doctorName;
            $patientName = $patient['firstName'] . ' ' . $patient['lastName'];
            $patientEmail = $patient['email'];
            
            // Log email sending attempt
            Log::info("Sending email to: $patientEmail - $patientName for appointment on $appointmentDate at $appointmentTime with Dr. $doctorName");
        
            // Send email
            try {
                Mail::to($patientEmail)->send(new AppointmentReminderEmail($patientEmail, $patientName, $appointmentDate, $appointmentTime, $doctorName));
                Log::info("Email successfully sent to $patientEmail.");
            } catch (\Exception $e) {
                Log::error("Failed to send email to $patientEmail. Error: " . $e->getMessage());
            }
        }
        
    }
    
}
