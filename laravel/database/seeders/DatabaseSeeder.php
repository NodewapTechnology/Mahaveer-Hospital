<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use App\Models\Admin;
use App\Models\Banner;
use App\Models\AboutPage;
use App\Models\Service;
use App\Models\Doctor;
use App\Models\GalleryItem;
use App\Models\Event;
use App\Models\Testimonial;
use App\Models\Offer;
use App\Models\Blog;
use App\Models\Faq;
use App\Models\ContactDetail;
use App\Models\SocialLink;
use App\Models\SeoSetting;
use App\Models\WebsiteSetting;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // ---------------------- Admin -----------------------
        Admin::updateOrCreate(
            ['email' => 'admin@mahaveerhospital.com'],
            ['name' => 'Admin', 'password' => Hash::make('Admin@12345')]
        );

        // ---------------------- Website Settings -----------------------
        WebsiteSetting::updateOrCreate(['id' => 1], [
            'site_name' => 'Mahaveer Multi-Speciality Hospital',
            'tagline' => 'Trusted care. Expert surgeons. 24×7 emergency.',
            'logo' => null,
            'favicon' => null,
            'footer_text' => 'Compassionate care rooted in North Bihar — advanced medicine, unmatched hospitality.',
            'copyright_text' => '© ' . date('Y') . ' Mahaveer Multi-Speciality Hospital. All rights reserved.',
            'appointment_cta_label' => 'Book Appointment',
            'primary_color' => '#3b1f4a',
            'accent_color' => '#d64a3a',
        ]);

        // ---------------------- Contact -----------------------
        ContactDetail::updateOrCreate(['id' => 1], [
            'phone_primary' => '+91 6287797276',
            'phone_secondary' => '+91 9430082726',
            'emergency_phone' => '+91 6287797276',
            'email_primary' => 'care@mahaveerhospital.com',
            'email_support' => 'info@mahaveerhospital.com',
            'address' => 'Adarsh Nagar, near NH-28 Bypass',
            'city' => 'Samastipur',
            'state' => 'Bihar',
            'pincode' => '848101',
            'map_embed' => 'https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3592.6!2d85.7708!3d25.86',
            'opening_hours' => 'OPD: Mon-Sat 9am–8pm  |  Emergency: 24×7',
        ]);

        // ---------------------- Social -----------------------
        $socials = [
            ['platform' => 'Facebook', 'icon' => 'fab fa-facebook-f', 'url' => 'https://facebook.com/'],
            ['platform' => 'Instagram', 'icon' => 'fab fa-instagram', 'url' => 'https://instagram.com/'],
            ['platform' => 'YouTube', 'icon' => 'fab fa-youtube', 'url' => 'https://youtube.com/'],
            ['platform' => 'WhatsApp', 'icon' => 'fab fa-whatsapp', 'url' => 'https://wa.me/916287797276'],
        ];
        foreach ($socials as $i => $s) {
            SocialLink::updateOrCreate(['platform' => $s['platform']], array_merge($s, ['sort' => $i, 'is_active' => true]));
        }

        // ---------------------- Banners -----------------------
        Banner::truncate();
        Banner::create([
            'title' => 'Trusted care for every life stage',
            'subtitle' => 'AIIMS-trained surgeons, state-of-the-art laparoscopic OT, 24×7 emergency & round-the-clock ICU under one roof in Samastipur.',
            'badge' => 'Rated #1 by Samastipur families',
            'cta_text' => 'Book Appointment',
            'cta_link' => '/contact',
            'image' => 'images/uploads/doctors/dr-amardeep-900.webp',
            'sort' => 1, 'is_active' => true,
        ]);
        Banner::create([
            'title' => 'Advanced Laparoscopic Surgery',
            'subtitle' => '4K high-definition keyhole surgery for gallbladder, appendix, hernia and abdominal tumours — with 2× faster recovery.',
            'badge' => 'Speciality Spotlight',
            'cta_text' => 'Learn More',
            'cta_link' => '/services',
            'image' => null,
            'sort' => 2, 'is_active' => true,
        ]);

        // ---------------------- About -----------------------
        AboutPage::updateOrCreate(['id' => 1], [
            'heading' => 'A hospital built on trust, precision and heart.',
            'overline' => 'About Mahaveer Hospital',
            'intro' => 'Mahaveer Multi-Speciality Hospital was founded to bring metropolitan-standard clinical care to the heart of North Bihar — without the metropolitan-scale wait times or cost.',
            'body' => "<p>Located in Adarsh Nagar, Samastipur, our 60-bed facility is led by AIIMS-trained surgeon <strong>Dr. Amardeep (MBBS, MS, FMAS)</strong> and a team of specialists in orthopaedics, gynaecology, general medicine and paediatrics.</p><p>From 4K laparoscopic operating theatres to a 24×7 trauma-ready emergency wing, every corner of Mahaveer Hospital is designed around a simple promise: the right care, at the right time, with genuine warmth.</p>",
            'image' => null,
            'stats' => [
                ['label' => 'Successful Surgeries', 'value' => '12,000+'],
                ['label' => 'Years of Experience', 'value' => '15+'],
                ['label' => 'Expert Doctors', 'value' => '20+'],
                ['label' => 'Emergency Response', 'value' => '24×7'],
            ],
            'values' => [
                ['title' => 'Clinical Excellence', 'body' => 'Evidence-based protocols, AIIMS-trained specialists and modern operating suites.'],
                ['title' => 'Patient-first Care', 'body' => 'Transparent pricing, dedicated relationship managers and multi-lingual support.'],
                ['title' => 'Compassionate Team', 'body' => 'Every nurse, doctor and technician is chosen for empathy first.'],
            ],
        ]);

        // ---------------------- Services -----------------------
        Service::truncate();
        $services = [
            ['name' => 'Laparoscopic Surgery', 'icon' => 'fa-scissors', 'features' => ['Gallbladder Removal', 'Appendix', 'Hernia Repair', 'Abdominal Tumours']],
            ['name' => 'Orthopaedics & Joint Care', 'icon' => 'fa-bone', 'features' => ['Joint Replacement', 'Arthroscopy', 'Fracture Care', 'Sports Injury']],
            ['name' => 'Gynaecology & Obstetrics', 'icon' => 'fa-baby', 'features' => ['Painless Delivery', 'High-Risk Pregnancy', 'Fertility Support', 'Menstrual Health']],
            ['name' => 'General Medicine', 'icon' => 'fa-stethoscope', 'features' => ['Diabetes', 'Hypertension', 'Fever & Infections', 'Preventive Health']],
            ['name' => 'Paediatrics', 'icon' => 'fa-child', 'features' => ['New-born Care', 'Vaccination', 'Growth Monitoring', 'Paediatric Emergencies']],
            ['name' => 'Emergency & Trauma', 'icon' => 'fa-truck-medical', 'features' => ['24×7 ER', 'Ambulance Service', 'Trauma Team', 'ICU Backup']],
        ];
        foreach ($services as $i => $s) {
            Service::create([
                'name' => $s['name'],
                'slug' => Str::slug($s['name']),
                'short_description' => 'Comprehensive '.$s['name'].' with advanced technology and expert team.',
                'description' => '<p>Our '.$s['name'].' department is equipped with cutting-edge technology and led by highly experienced specialists dedicated to compassionate, evidence-based patient care.</p>',
                'icon' => $s['icon'],
                'features' => $s['features'],
                'sort' => $i,
                'is_active' => true,
            ]);
        }

        // ---------------------- Doctors -----------------------
        Doctor::truncate();
        Doctor::create([
            'name' => 'Dr. Amardeep',
            'slug' => 'dr-amardeep',
            'photo' => 'images/uploads/doctors/dr-amardeep-600.webp',
            'designation' => 'Senior Consultant & Head of Surgery',
            'qualification' => 'MBBS, MS, FMAS',
            'experience' => '15+ years',
            'specialization' => 'Advanced Laparoscopic & General Surgery',
            'description' => 'AIIMS-trained laparoscopic surgeon with over 15 years of experience. Dr. Amardeep specialises in 4K high-definition keyhole surgery of gallbladder, appendix, hernia and abdominal tumours. Trusted by 12,000+ patients across North Bihar.',
            'available_timing' => 'Mon–Sat: 10:00 AM – 2:00 PM  |  5:00 PM – 8:00 PM',
            'contact_phone' => '+91 6287797276',
            'contact_email' => 'dramardeep@mahaveerhospital.com',
            'is_featured' => true,
            'sort' => 1, 'is_active' => true,
        ]);
        $others = [
            ['name' => 'Dr. Sunita Sharma', 'designation' => 'Sr. Consultant — Gynaecology', 'qualification' => 'MBBS, MS (OBG)', 'specialization' => 'High-Risk Pregnancy & Painless Delivery', 'experience' => '12 years'],
            ['name' => 'Dr. Rakesh Kumar', 'designation' => 'Consultant — Orthopaedics', 'qualification' => 'MBBS, MS Ortho', 'specialization' => 'Joint Replacement & Arthroscopy', 'experience' => '10 years'],
            ['name' => 'Dr. Anjali Verma', 'designation' => 'Consultant — Paediatrics', 'qualification' => 'MBBS, MD (Peds)', 'specialization' => 'New-born & Child Health', 'experience' => '9 years'],
            ['name' => 'Dr. Vinay Singh', 'designation' => 'Consultant — General Medicine', 'qualification' => 'MBBS, MD (Med)', 'specialization' => 'Diabetes & Hypertension', 'experience' => '11 years'],
        ];
        foreach ($others as $i => $d) {
            Doctor::create([
                'name' => $d['name'],
                'slug' => Str::slug($d['name']),
                'photo' => null,
                'designation' => $d['designation'],
                'qualification' => $d['qualification'],
                'experience' => $d['experience'],
                'specialization' => $d['specialization'],
                'description' => $d['name'].' brings deep clinical expertise and a warm bedside manner. Recognised across Samastipur for evidence-based practice and patient-first care.',
                'available_timing' => 'Mon–Sat: 11:00 AM – 3:00 PM',
                'contact_phone' => '+91 6287797276',
                'contact_email' => null,
                'is_featured' => false,
                'sort' => $i + 2, 'is_active' => true,
            ]);
        }

        // ---------------------- Gallery -----------------------
        GalleryItem::truncate();
        $galleryImgs = [
            'https://images.unsplash.com/photo-1519494026892-80bbd2d6fd0d?w=1200&q=72&auto=format,compress&fit=crop',
            'https://images.unsplash.com/photo-1587351021759-3e566b6af7cc?w=1200&q=72&auto=format,compress&fit=crop',
            'https://images.unsplash.com/photo-1516549655169-df83a0774514?w=1200&q=72&auto=format,compress&fit=crop',
            'https://images.unsplash.com/photo-1538108149393-fbbd81895907?w=1200&q=72&auto=format,compress&fit=crop',
            'https://images.unsplash.com/photo-1631815589968-fdb09a223b1e?w=1200&q=72&auto=format,compress&fit=crop',
            'https://images.unsplash.com/photo-1551601651-2a8555f1a136?w=1200&q=72&auto=format,compress&fit=crop',
            'https://images.unsplash.com/photo-1666214277657-e6c98346b73b?w=1200&q=72&auto=format,compress&fit=crop',
            'https://images.unsplash.com/photo-1666214280391-8b1e9f4b3f26?w=1200&q=72&auto=format,compress&fit=crop',
        ];
        $cats = ['Facilities', 'Operation Theatre', 'ICU', 'Reception', 'Events', 'Team', 'Patient Care', 'Emergency'];
        foreach ($galleryImgs as $i => $img) {
            GalleryItem::create([
                'title' => $cats[$i].' — Mahaveer Hospital',
                'category' => $cats[$i],
                'image' => $img,
                'caption' => 'A glimpse of our '.$cats[$i].' at Mahaveer Multi-Speciality Hospital.',
                'sort' => $i, 'is_active' => true,
            ]);
        }

        // ---------------------- Events -----------------------
        Event::truncate();
        $events = [
            ['title' => 'Free Health Check-up Camp', 'days' => 5, 'venue' => 'Mahaveer Hospital, Samastipur', 'sd' => 'Free BP, sugar & BMI screening for all senior citizens.'],
            ['title' => 'World Cancer Day Awareness', 'days' => 20, 'venue' => 'OPD Lobby', 'sd' => 'Interactive session on early cancer detection with our senior surgeons.'],
            ['title' => 'Diabetes Care Workshop', 'days' => 35, 'venue' => 'Auditorium, 2nd Floor', 'sd' => 'Lifestyle, diet and medication essentials — with live Q&A.'],
            ['title' => 'Women\'s Wellness Day', 'days' => 50, 'venue' => 'Gynae Wing', 'sd' => 'Free consultation for women 25–55 with our OBG specialists.'],
        ];
        foreach ($events as $i => $e) {
            Event::create([
                'title' => $e['title'],
                'slug' => Str::slug($e['title']),
                'event_date' => now()->addDays($e['days'])->toDateString(),
                'event_time' => '10:00:00',
                'venue' => $e['venue'],
                'image' => 'https://images.unsplash.com/photo-1584982751601-97dcc096659c?w=1200&q=72&auto=format,compress&fit=crop',
                'short_description' => $e['sd'],
                'description' => '<p>Join us for an insightful and free session organised by Mahaveer Hospital in association with local community partners.</p>',
                'is_active' => true,
            ]);
        }

        // ---------------------- Testimonials -----------------------
        Testimonial::truncate();
        $tms = [
            ['name' => 'Rekha Devi', 'role' => 'Gallbladder Surgery Patient', 'quote' => 'Dr. Amardeep sir explained everything in simple Hindi. My surgery was done through 3 tiny holes and I went home the very next day. Thank you Mahaveer team!'],
            ['name' => 'Manoj Yadav', 'role' => 'Family of Emergency Patient', 'quote' => 'At 2 AM, the ambulance reached in 12 minutes. The ER team was ready — my father is alive today because of Mahaveer Hospital.'],
            ['name' => 'Priya Kumari', 'role' => 'Painless Delivery', 'quote' => 'Dr. Sunita ma\'am and the nursing team made my delivery feel safe and dignified. The rooms are clean, food is home-style, and staff behaviour is beyond words.'],
            ['name' => 'Suresh Prasad', 'role' => 'Knee Replacement Patient', 'quote' => 'I couldn\'t walk without pain for 3 years. After my knee replacement here, I climbed stairs on the 5th day. Best decision of my life.'],
            ['name' => 'Anita Singh', 'role' => 'Diabetes Care', 'quote' => 'The doctors don\'t just prescribe — they explain, follow up, and truly care. My HbA1c dropped from 11 to 6.8 in six months.'],
            ['name' => 'Ramesh Sharma', 'role' => 'Hernia Repair', 'quote' => 'Laparoscopic hernia repair was smooth, no big cuts and only 1 night stay. Highly recommend Dr. Amardeep and Mahaveer.'],
        ];
        foreach ($tms as $i => $tm) {
            Testimonial::create(array_merge($tm, ['rating' => 5, 'is_active' => true, 'sort' => $i]));
        }

        // ---------------------- Offers -----------------------
        Offer::truncate();
        $offers = [
            ['title' => 'Free Full Body Check-up', 'badge' => 'Limited Time', 'sd' => 'Complete diagnostic package — CBC, LFT, KFT, ECG, X-Ray & doctor consultation.', 'disc' => 'FREE'],
            ['title' => '30% Off on Laparoscopic Packages', 'badge' => 'Speciality', 'sd' => 'Gallbladder, appendix and hernia laparoscopic packages at exclusive pricing.', 'disc' => '30% OFF'],
            ['title' => 'Senior Citizen Wellness Plan', 'badge' => 'Popular', 'sd' => 'Yearly wellness plan for 60+ with quarterly check-ups and free ambulance.', 'disc' => '₹2,499/year'],
            ['title' => 'Mother & Baby Care Package', 'badge' => 'New', 'sd' => 'Complete antenatal, delivery and post-natal care in one caring bundle.', 'disc' => 'Save ₹15,000'],
        ];
        foreach ($offers as $o) {
            Offer::create([
                'title' => $o['title'],
                'slug' => Str::slug($o['title']),
                'badge' => $o['badge'],
                'short_description' => $o['sd'],
                'description' => '<p>Terms & conditions apply. Please contact our care team for eligibility and enrolment details.</p>',
                'image' => 'https://images.unsplash.com/photo-1666214280444-71029ceac7bf?w=1200&q=72&auto=format,compress&fit=crop',
                'valid_from' => now()->toDateString(),
                'valid_until' => now()->addMonths(2)->toDateString(),
                'discount_label' => $o['disc'],
                'is_active' => true,
            ]);
        }

        // ---------------------- Blogs -----------------------
        Blog::truncate();
        $blogs = [
            ['title' => '5 Signs Your Gallbladder Needs Immediate Attention', 'auth' => 'Dr. Amardeep', 'excerpt' => 'Right-upper abdominal pain after fatty food is often the first warning sign. Here\'s what to look for and when to consult a surgeon.'],
            ['title' => 'How Painless Delivery Works — A Mother\'s Guide', 'auth' => 'Dr. Sunita Sharma', 'excerpt' => 'Epidural anaesthesia in modern obstetrics — safe, mother-friendly and increasingly the norm at Mahaveer Hospital.'],
            ['title' => 'Knee Replacement Recovery — Week by Week', 'auth' => 'Dr. Rakesh Kumar', 'excerpt' => 'What to expect in the first 6 weeks after joint replacement — physiotherapy, milestones and red-flags.'],
        ];
        foreach ($blogs as $i => $b) {
            Blog::create([
                'title' => $b['title'],
                'slug' => Str::slug($b['title']),
                'cover_image' => 'https://images.unsplash.com/photo-1576091160399-112ba8d25d1d?w=1200&q=72&auto=format,compress&fit=crop',
                'author' => $b['auth'],
                'excerpt' => $b['excerpt'],
                'content' => '<p>'.$b['excerpt'].'</p><p>Book a consultation at Mahaveer Multi-Speciality Hospital, Samastipur, for evidence-based care from our AIIMS-trained team.</p>',
                'published_at' => now()->subDays(($i + 1) * 7)->toDateString(),
                'is_active' => true,
            ]);
        }

        // ---------------------- FAQs -----------------------
        Faq::truncate();
        $faqs = [
            ['q' => 'Does Mahaveer Hospital offer 24×7 emergency services?', 'a' => 'Yes, our trauma & emergency team is available round-the-clock. Call +91 6287797276 immediately.'],
            ['q' => 'Is laparoscopic (keyhole) surgery available here?', 'a' => 'Yes, Dr. Amardeep (MBBS, MS, FMAS) performs 4K high-definition laparoscopic surgery for gallbladder, appendix, hernia and abdominal tumours.'],
            ['q' => 'How do I book an appointment?', 'a' => 'Click the "Book Appointment" button on the site or call +91 6287797276. Our team will call you back to confirm your slot.'],
            ['q' => 'Where is the hospital located?', 'a' => 'Adarsh Nagar, Samastipur, Bihar 848101 (near NH-28 Bypass).'],
            ['q' => 'Do you accept cashless insurance?', 'a' => 'Yes, we are empanelled with all major insurers including Star Health, HDFC Ergo, ICICI Lombard, Care Health, and CGHS.'],
        ];
        foreach ($faqs as $i => $f) {
            Faq::create(['question' => $f['q'], 'answer' => $f['a'], 'sort' => $i, 'is_active' => true]);
        }

        // ---------------------- SEO -----------------------
        SeoSetting::truncate();
        $seo = [
            ['page_key' => 'home', 'title' => 'Best Hospital in Samastipur · Mahaveer Multi-Speciality', 'description' => 'Mahaveer Multi-Speciality Hospital — Best hospital in Samastipur, laparoscopic surgery, orthopaedics, gynaecology and 24×7 emergency care.', 'keywords' => 'best hospital in Samastipur, laparoscopic surgery, Dr Amardeep, emergency hospital Bihar'],
            ['page_key' => 'about', 'title' => 'About Us · Mahaveer Hospital', 'description' => 'Learn about Mahaveer Multi-Speciality Hospital — our story, vision and commitment to trusted care in North Bihar.', 'keywords' => 'about Mahaveer hospital, hospital Samastipur about'],
            ['page_key' => 'doctors', 'title' => 'Meet Our Doctors · Mahaveer Hospital', 'description' => 'Meet Dr. Amardeep and the AIIMS-trained specialist team at Mahaveer Multi-Speciality Hospital, Samastipur.', 'keywords' => 'doctors Samastipur, best surgeons Bihar'],
            ['page_key' => 'services', 'title' => 'Services & Specialities · Mahaveer Hospital', 'description' => 'Explore our full range of clinical services — laparoscopic surgery, orthopaedics, gynaecology, paediatrics and emergency care.', 'keywords' => 'services hospital Samastipur, laparoscopic, orthopaedic, gynaecology'],
            ['page_key' => 'gallery', 'title' => 'Gallery · Mahaveer Hospital', 'description' => 'Photo gallery — facilities, operating theatres, events and patient stories at Mahaveer Multi-Speciality Hospital.', 'keywords' => 'hospital gallery photos'],
            ['page_key' => 'events', 'title' => 'Events & Camps · Mahaveer Hospital', 'description' => 'Upcoming health camps, awareness sessions and community events at Mahaveer Hospital.', 'keywords' => 'health camp Samastipur, hospital events'],
            ['page_key' => 'contact', 'title' => 'Contact Us · Mahaveer Hospital', 'description' => 'Contact Mahaveer Multi-Speciality Hospital, Samastipur — call, email or visit us. 24×7 emergency line active.', 'keywords' => 'contact hospital Samastipur, book appointment'],
            ['page_key' => 'offers', 'title' => 'Offers & Health Packages · Mahaveer Hospital', 'description' => 'Special health packages, senior citizen plans and speciality offers at Mahaveer Hospital.', 'keywords' => 'health package Samastipur, hospital offers'],
            ['page_key' => 'testimonials', 'title' => 'Patient Stories · Mahaveer Hospital', 'description' => 'Real stories from real patients — read what families across Samastipur say about their Mahaveer Hospital experience.', 'keywords' => 'patient testimonials, hospital reviews'],
            ['page_key' => 'blogs', 'title' => 'Health Blog · Mahaveer Hospital', 'description' => 'Expert health articles from our doctors — surgical care, women\'s health, joint pain, diabetes and more.', 'keywords' => 'health blog, medical articles, hospital blog'],
        ];
        foreach ($seo as $s) {
            SeoSetting::create($s);
        }
    }
}
