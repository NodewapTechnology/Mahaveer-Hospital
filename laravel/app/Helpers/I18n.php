<?php

namespace App\Helpers;

class I18n
{
    /**
     * Get translated value for a model attribute.
     * Fallback: current lang → English default.
     */
    public static function t($model, string $field, ?string $lang = null): ?string
    {
        $lang = $lang ?: session('lang', 'en');
        $translations = is_array($model?->translations ?? null) ? $model->translations : [];
        if ($lang !== 'en' && !empty($translations[$lang][$field])) {
            return $translations[$lang][$field];
        }
        return $model->{$field} ?? null;
    }

    /**
     * Static UI string translations (English/Hindi).
     */
    public static function ui(string $key): string
    {
        static $dict = null;
        if ($dict === null) {
            $dict = [
                'en' => [
                    'nav.home' => 'Home', 'nav.about' => 'About', 'nav.services' => 'Services',
                    'nav.doctors' => 'Doctors', 'nav.gallery' => 'Gallery', 'nav.events' => 'Events',
                    'nav.offers' => 'Offers', 'nav.testimonials' => 'Testimonials', 'nav.blog' => 'Blog',
                    'nav.contact' => 'Contact', 'nav.more' => 'More',
                    'cta.book' => 'Book Appointment', 'cta.call' => 'Call', 'cta.learn_more' => 'Learn more',
                    'cta.view_all' => 'View all', 'cta.view_profile' => 'View Profile', 'cta.enquire' => 'Enquire',
                    'label.emergency' => '24/7 Emergency', 'label.our_doctors' => 'Our Doctors',
                    'label.specialities' => 'Our Specialities', 'label.testimonials' => 'Patient Stories',
                    'label.offers' => 'Health Packages', 'label.upcoming_events' => 'Upcoming Events',
                    'label.gallery' => 'Gallery', 'label.faq' => 'Frequently Asked',
                    'label.contact_us' => 'Get in touch', 'label.form_name' => 'Full Name',
                    'label.form_phone' => 'Phone', 'label.form_email' => 'Email',
                    'label.form_message' => 'Message', 'label.form_subject' => 'Subject',
                    'label.form_doctor' => 'Preferred Doctor', 'label.form_date' => 'Preferred Date',
                    'label.form_submit' => 'Send Enquiry',
                    'label.chat_whatsapp' => 'Chat on WhatsApp',
                    'success.enquiry' => 'Thank you! Our team will contact you shortly.',
                ],
                'hi' => [
                    'nav.home' => 'होम', 'nav.about' => 'हमारे बारे में', 'nav.services' => 'सेवाएं',
                    'nav.doctors' => 'डॉक्टर्स', 'nav.gallery' => 'गैलरी', 'nav.events' => 'कार्यक्रम',
                    'nav.offers' => 'ऑफर्स', 'nav.testimonials' => 'रोगी अनुभव', 'nav.blog' => 'ब्लॉग',
                    'nav.contact' => 'संपर्क', 'nav.more' => 'और',
                    'cta.book' => 'अपॉइंटमेंट बुक करें', 'cta.call' => 'कॉल', 'cta.learn_more' => 'और जानें',
                    'cta.view_all' => 'सभी देखें', 'cta.view_profile' => 'प्रोफ़ाइल देखें', 'cta.enquire' => 'पूछताछ करें',
                    'label.emergency' => '24×7 आपातकाल', 'label.our_doctors' => 'हमारे डॉक्टर्स',
                    'label.specialities' => 'हमारी विशेषज्ञताएं', 'label.testimonials' => 'रोगियों की कहानियाँ',
                    'label.offers' => 'हेल्थ पैकेज', 'label.upcoming_events' => 'आगामी कार्यक्रम',
                    'label.gallery' => 'गैलरी', 'label.faq' => 'सामान्य प्रश्न',
                    'label.contact_us' => 'संपर्क में रहें', 'label.form_name' => 'पूरा नाम',
                    'label.form_phone' => 'फ़ोन', 'label.form_email' => 'ईमेल',
                    'label.form_message' => 'संदेश', 'label.form_subject' => 'विषय',
                    'label.form_doctor' => 'पसंदीदा डॉक्टर', 'label.form_date' => 'पसंदीदा तिथि',
                    'label.form_submit' => 'भेजें',
                    'label.chat_whatsapp' => 'व्हाट्सएप पर चैट करें',
                    'success.enquiry' => 'धन्यवाद! हमारी टीम शीघ्र ही आपसे संपर्क करेगी।',
                ],
            ];
        }
        $lang = session('lang', 'en');
        return $dict[$lang][$key] ?? $dict['en'][$key] ?? $key;
    }
}
