@php
    $modalDoctors = \App\Models\Doctor::where('is_active', true)->orderBy('sort')->get(['id', 'name']);
@endphp
<div class="book-modal" id="bookModal" data-book-modal aria-hidden="true" data-testid="booking-modal">
    <div class="book-modal-overlay" data-book-close></div>
    <div class="book-modal-card" role="dialog" aria-modal="true" aria-label="Book Your Appointment">
        <button type="button" class="book-modal-x" data-book-close aria-label="Close" data-testid="booking-modal-close"><i class="fas fa-xmark"></i></button>

        <div class="book-modal-head">
            <div class="mini-icon"><i class="fas fa-calendar-check"></i></div>
            <div>
                <h3>Book Your Appointment</h3>
                <p>We'll call to confirm within a few hours.</p>
            </div>
        </div>

        <form method="POST" action="{{ route('contact.submit') }}" class="hero-appt-form" data-testid="booking-modal-form" novalidate>
            @csrf
            <input type="hidden" name="source" value="hero_form">
            <input type="hidden" name="subject" value="Online Appointment Request">

            <div class="field-group">
                <label>Full Name <span class="req">*</span></label>
                <div class="input-wrap"><i class="fas fa-user"></i>
                    <input type="text" name="name" required placeholder="Your name" data-testid="modal-name" autocomplete="name">
                </div>
            </div>
            <div class="field-group">
                <label>Mobile Number <span class="req">*</span></label>
                <div class="input-wrap"><i class="fas fa-phone"></i>
                    <input type="tel" name="phone" required placeholder="10-digit mobile" data-testid="modal-phone" inputmode="numeric" pattern="[0-9+\-\s]{7,15}" autocomplete="tel">
                </div>
            </div>
            <div class="field-row">
                <div class="field-group">
                    <label>Village <span class="req">*</span></label>
                    <div class="input-wrap"><i class="fas fa-house"></i>
                        <input type="text" name="village" required placeholder="Village name" data-testid="modal-village">
                    </div>
                </div>
                <div class="field-group">
                    <label>Doctor <span class="req">*</span></label>
                    <div class="input-wrap select-wrap"><i class="fas fa-user-doctor"></i>
                        <select name="preferred_doctor" required data-testid="modal-doctor">
                            <option value="" disabled selected>Select doctor</option>
                            @foreach($modalDoctors as $ad)
                                <option value="{{ $ad->name }}">{{ $ad->name }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
            </div>
            <div class="field-group">
                <label>Preferred Date <span class="req">*</span></label>
                <div class="input-wrap date-wrap"><i class="fas fa-calendar-days"></i>
                    <input type="date" name="preferred_date" required min="{{ date('Y-m-d') }}" data-testid="modal-date">
                </div>
            </div>

            <button type="submit" class="btn-mh btn-accent-mh hero-appt-submit" data-testid="modal-submit">
                <i class="fas fa-paper-plane"></i> <span>Book My Appointment</span>
            </button>
            <div class="hero-appt-note">
                <i class="fas fa-shield-halved"></i>
                <span>Your details are safe. NABH Standard Protocols · 100% confidential.</span>
            </div>
        </form>
    </div>
</div>
