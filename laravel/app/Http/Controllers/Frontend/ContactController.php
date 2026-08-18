<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Mail\NewEnquiryMail;
use App\Models\Doctor;
use App\Models\Enquiry;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Illuminate\Validation\ValidationException;

class ContactController extends Controller
{
    public function index()
    {
        return view('frontend.contact', [
            'doctors' => Doctor::where('is_active', true)->orderBy('sort')->get(['id', 'name']),
        ]);
    }

    public function submit(Request $request)
    {
        $isHeroForm = $request->input('source') === 'hero_form';

        $rules = [
            'name' => 'required|string|max:120',
            'email' => 'nullable|email|max:150',
            'phone' => 'required|string|max:20',
            'subject' => 'nullable|string|max:200',
            'message' => 'nullable|string|max:2000',
            'preferred_doctor' => 'nullable|string|max:150',
            'preferred_date' => 'nullable|string|max:50',
            'village' => 'nullable|string|max:120',
            'district' => 'nullable|string|max:120',
            'source' => 'nullable|string|max:50',
            'g-recaptcha-response' => 'nullable|string',
        ];

        if ($isHeroForm) {
            // All required for hero form
            $rules['village'] = 'required|string|max:120';
            $rules['preferred_doctor'] = 'required|string|max:150';
            $rules['preferred_date'] = 'required|date|after_or_equal:today';
        }

        $data = $request->validate($rules);

        // reCAPTCHA v3 verification (skipped when not configured)
        $settings = \App\Models\WebsiteSetting::first();
        $siteKey = $settings?->recaptcha_site_key ?: config('mahaveer.site_key');
        $secret  = $settings?->recaptcha_secret_key ?: config('mahaveer.secret_key');
        if ($secret && $siteKey) {
            $token = $request->input('g-recaptcha-response');
            if (!$token) {
                throw ValidationException::withMessages(['captcha' => 'Captcha missing. Please refresh and try again.']);
            }
            try {
                $resp = Http::asForm()->timeout(6)->post('https://www.google.com/recaptcha/api/siteverify', [
                    'secret' => $secret,
                    'response' => $token,
                    'remoteip' => $request->ip(),
                ])->json();
                $score = $resp['score'] ?? 0;
                if (empty($resp['success']) || $score < config('mahaveer.min_score', 0.5)) {
                    throw ValidationException::withMessages(['captcha' => 'Automated request detected. Please try again.']);
                }
            } catch (ValidationException $e) {
                throw $e;
            } catch (\Throwable $e) {
                Log::warning('recaptcha error: ' . $e->getMessage());
            }
        }

        unset($data['g-recaptcha-response']);
        $data['source'] = $data['source'] ?? ($request->is('enquiry') ? 'appointment' : 'contact');
        $enquiry = Enquiry::create($data);

        // Email notification to admin (fire-and-forget; failures logged only)
        $notify = $settings?->notify_email ?: (config('mahaveer.notify_email') ?: optional(\App\Models\ContactDetail::first())->email);
        if ($notify) {
            try {
                Mail::to($notify)->send(new NewEnquiryMail($enquiry));
            } catch (\Throwable $e) {
                Log::warning('enquiry mail failed: ' . $e->getMessage());
            }
        }

        if ($request->wantsJson() || $request->ajax()) {
            return response()->json(['success' => true, 'message' => 'Thank you! Our team will call you back shortly.', 'id' => $enquiry->id]);
        }

        if ($isHeroForm) {
            return redirect()->to(url()->previous() . '#appointment-card')
                ->with('appointment_success', 'Booking received! We\'ll call you shortly to confirm.');
        }

        return redirect()->route('contact')->with('success', 'Thank you! Our team will contact you within a few hours.');
    }
}
