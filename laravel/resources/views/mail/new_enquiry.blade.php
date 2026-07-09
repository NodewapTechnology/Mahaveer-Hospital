<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>New Enquiry</title>
</head>
<body style="margin:0;padding:0;background:#f5f2ec;font-family:'Segoe UI',Arial,sans-serif;color:#1a1523;">
    <table role="presentation" cellpadding="0" cellspacing="0" width="100%" style="padding:32px 12px;">
        <tr><td align="center">
            <table role="presentation" cellpadding="0" cellspacing="0" width="600" style="max-width:600px;background:#fff;border-radius:14px;overflow:hidden;box-shadow:0 12px 36px rgba(26,21,35,.1);">
                <tr>
                    <td style="background:linear-gradient(135deg,#2a1435,#3b1f4a);padding:28px 32px;color:#fff;">
                        <div style="font-size:12px;letter-spacing:.2em;text-transform:uppercase;color:#e5a530;font-weight:700;">Mahaveer Hospital</div>
                        <div style="font-family:Georgia,serif;font-size:26px;margin-top:6px;">New Appointment Enquiry</div>
                    </td>
                </tr>
                <tr>
                    <td style="padding:28px 32px;">
                        <p style="margin:0 0 20px;color:#3f374a;">You've received a new enquiry from the website contact form:</p>
                        <table role="presentation" cellpadding="0" cellspacing="0" width="100%" style="border-collapse:collapse;">
                            <tr><td style="padding:10px 0;border-bottom:1px solid #efeadf;color:#786f83;font-size:12px;letter-spacing:.14em;text-transform:uppercase;font-weight:700;width:140px;">Name</td><td style="padding:10px 0;border-bottom:1px solid #efeadf;font-weight:600;">{{ $enquiry->name }}</td></tr>
                            <tr><td style="padding:10px 0;border-bottom:1px solid #efeadf;color:#786f83;font-size:12px;letter-spacing:.14em;text-transform:uppercase;font-weight:700;">Phone</td><td style="padding:10px 0;border-bottom:1px solid #efeadf;"><a href="tel:{{ $enquiry->phone }}" style="color:#d64a3a;text-decoration:none;">{{ $enquiry->phone }}</a></td></tr>
                            @if($enquiry->email)
                            <tr><td style="padding:10px 0;border-bottom:1px solid #efeadf;color:#786f83;font-size:12px;letter-spacing:.14em;text-transform:uppercase;font-weight:700;">Email</td><td style="padding:10px 0;border-bottom:1px solid #efeadf;"><a href="mailto:{{ $enquiry->email }}" style="color:#3b1f4a;">{{ $enquiry->email }}</a></td></tr>
                            @endif
                            @if($enquiry->preferred_doctor)
                            <tr><td style="padding:10px 0;border-bottom:1px solid #efeadf;color:#786f83;font-size:12px;letter-spacing:.14em;text-transform:uppercase;font-weight:700;">Preferred Doctor</td><td style="padding:10px 0;border-bottom:1px solid #efeadf;">{{ $enquiry->preferred_doctor }}</td></tr>
                            @endif
                            @if($enquiry->preferred_date)
                            <tr><td style="padding:10px 0;border-bottom:1px solid #efeadf;color:#786f83;font-size:12px;letter-spacing:.14em;text-transform:uppercase;font-weight:700;">Preferred Date</td><td style="padding:10px 0;border-bottom:1px solid #efeadf;">{{ $enquiry->preferred_date }}</td></tr>
                            @endif
                            @if($enquiry->subject)
                            <tr><td style="padding:10px 0;border-bottom:1px solid #efeadf;color:#786f83;font-size:12px;letter-spacing:.14em;text-transform:uppercase;font-weight:700;">Subject</td><td style="padding:10px 0;border-bottom:1px solid #efeadf;">{{ $enquiry->subject }}</td></tr>
                            @endif
                            @if($enquiry->message)
                            <tr><td style="padding:10px 0;color:#786f83;font-size:12px;letter-spacing:.14em;text-transform:uppercase;font-weight:700;vertical-align:top;">Message</td><td style="padding:10px 0;white-space:pre-line;">{{ $enquiry->message }}</td></tr>
                            @endif
                        </table>
                        <div style="margin-top:24px;padding:14px;background:#f5f2ec;border-radius:10px;font-size:13px;color:#786f83;">
                            <strong style="color:#3b1f4a;">Source:</strong> {{ $enquiry->source ?? 'contact' }} · <strong style="color:#3b1f4a;">Received:</strong> {{ optional($enquiry->created_at)->format('d M Y, h:i A') }}
                        </div>
                        <div style="margin-top:22px;text-align:center;">
                            <a href="{{ url('/admin/enquiries/' . $enquiry->id) }}" style="display:inline-block;padding:12px 24px;background:#d64a3a;color:#fff;text-decoration:none;border-radius:999px;font-weight:700;font-size:14px;">Open in Admin →</a>
                        </div>
                    </td>
                </tr>
                <tr><td style="padding:20px 32px;text-align:center;background:#f5f2ec;color:#786f83;font-size:12px;">© {{ date('Y') }} Mahaveer Multi-Speciality Hospital · Automated notification</td></tr>
            </table>
        </td></tr>
    </table>
</body>
</html>
