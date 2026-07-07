import React, { useRef, useState } from "react";
import emailjs from "@emailjs/browser";
import { toast } from "sonner";
import { useApp } from "@/context/AppContext";
import { PHONES } from "@/lib/translations";
import { Section, Reveal, Overline } from "@/components/Section";
import { Input } from "@/components/ui/input";
import { Textarea } from "@/components/ui/textarea";
import Seo from "@/components/Seo";
import { HOSPITAL_SCHEMA, breadcrumbSchema } from "@/lib/schema";
import { Phone, Mail, MapPin, Clock, Send, MessageCircle, ArrowRight } from "lucide-react";
const SERVICE_ID = process.env.REACT_APP_EMAILJS_SERVICE_ID;
const TEMPLATE_ID = process.env.REACT_APP_EMAILJS_TEMPLATE_ID;
const PUBLIC_KEY = process.env.REACT_APP_EMAILJS_PUBLIC_KEY;
const RECIPIENT = process.env.REACT_APP_RECIPIENT_EMAIL;

function isConfigured() {
  return (
    SERVICE_ID &&
    TEMPLATE_ID &&
    PUBLIC_KEY &&
    !SERVICE_ID.startsWith("YOUR_") &&
    !TEMPLATE_ID.startsWith("YOUR_") &&
    !PUBLIC_KEY.startsWith("YOUR_")
  );
}

export default function Contact() {
  const { t, lang } = useApp();
  const formRef = useRef(null);
  const [sending, setSending] = useState(false);
  const [phoneDigits, setPhoneDigits] = useState("");

  const handlePhoneChange = (e) => {
    const digitsOnly = (e.target.value || "").replace(/\D/g, "").slice(0, 10);
    setPhoneDigits(digitsOnly);
  };

  const onSubmit = async (e) => {
    e.preventDefault();
    if (!formRef.current) return;

    if (!isConfigured()) {
      toast.error(t.contact_page.form.config_error);
      return;
    }

    setSending(true);
    try {
      await emailjs.sendForm(SERVICE_ID, TEMPLATE_ID, formRef.current, {
        publicKey: PUBLIC_KEY,
      });
      toast.success(t.contact_page.form.success);
      formRef.current.reset();
    } catch (err) {
      console.error("EmailJS error", err);
      toast.error(t.contact_page.form.error);
    } finally {
      setSending(false);
    }
  };

  return (
    <main data-testid="page-contact" className="pt-8">
      <Seo
        title={lang === "hi" ? "संपर्क करें — अपॉइंटमेंट बुक करें" : "Contact Us — Book an Appointment"}
        description={lang === "hi"
          ? "महावीर मल्टी-स्पेशलिटी हॉस्पिटल, आदर्श नगर, समस्तीपुर से संपर्क करें। फ़ोन: +91 6287797276 / 6287797277। 24×7 आपातकालीन सेवा। अपॉइंटमेंट के लिए ऑनलाइन फ़ॉर्म भरें।"
          : "Contact Mahaveer Multi-Speciality Hospital at Adarsh Nagar, Samastipur. Call +91 6287797276 or 6287797277 — 24×7 emergency services. Book an appointment via the online form."}
        canonicalPath="/contact"
        keywords="Mahaveer Hospital contact, hospital phone number Samastipur, book appointment Bihar, hospital address Adarsh Nagar, emergency contact hospital, WhatsApp doctor Samastipur"
        structuredData={[
          HOSPITAL_SCHEMA,
          breadcrumbSchema([{ name: "Contact", path: "/contact" }]),
        ]}
      />
      <Section className="pt-12 pb-12" testId="contact-hero">
        <div className="max-w-4xl space-y-6">
          <Reveal><Overline>{t.contact_page.overline}</Overline></Reveal>
          <Reveal delay={0.05}>
            <h1 className="font-display text-5xl sm:text-6xl lg:text-7xl tracking-tight leading-[0.97] text-balance text-foreground">
              {t.contact_page.title}
            </h1>
          </Reveal>
          <Reveal delay={0.15}>
            <p className="text-base sm:text-lg text-muted-foreground leading-relaxed">
              {t.contact_page.subtitle}
            </p>
          </Reveal>
        </div>
      </Section>

      <Section testId="contact-grid">
        <div className="grid lg:grid-cols-12 gap-10 lg:gap-14">
          {/* Form */}
          <div className="lg:col-span-7">
            <Reveal>
              <div className="rounded-3xl bg-card border border-border p-7 sm:p-10">
                <h3 className="font-display text-2xl sm:text-3xl tracking-tight text-foreground">
                  {lang === "hi" ? "हमें संदेश भेजें" : "Send us a message"}
                </h3>

                <form
                  ref={formRef}
                  onSubmit={onSubmit}
                  className="mt-7 grid grid-cols-1 sm:grid-cols-2 gap-5"
                  data-testid="contact-form"
                >
                  {/* hidden recipient passthrough so template can use {{to_email}} if user wants */}
                  <input type="hidden" name="to_email" value={RECIPIENT || ""} />

                  <div className="sm:col-span-1">
                    <label htmlFor="user_name" className="block text-xs uppercase tracking-[0.2em] text-muted-foreground mb-2">
                      {t.contact_page.form.name}
                    </label>
                    <Input
                      id="user_name"
                      data-testid="contact-input-name"
                      name="user_name"
                      type="text"
                      required
                      placeholder={lang === "hi" ? "आपका नाम" : "Your name"}
                      className="h-12 rounded-xl"
                    />
                  </div>

                  <div className="sm:col-span-1">
                    <label htmlFor="user_email" className="block text-xs uppercase tracking-[0.2em] text-muted-foreground mb-2">
                      {t.contact_page.form.email}
                    </label>
                    <Input
                      id="user_email"
                      data-testid="contact-input-email"
                      name="user_email"
                      type="email"
                      required
                      placeholder="you@example.com"
                      className="h-12 rounded-xl"
                    />
                  </div>

                  <div className="sm:col-span-1">
                    <label htmlFor="user_phone" className="block text-xs uppercase tracking-[0.2em] text-muted-foreground mb-2">
                      {t.contact_page.form.phone}
                    </label>
                    <div className="flex h-12 rounded-xl border border-input bg-background focus-within:ring-2 focus-within:ring-ring overflow-hidden">
                      <span
                        className="flex items-center justify-center px-3.5 bg-muted/60 border-r border-input text-sm font-semibold text-foreground/80 select-none"
                        aria-hidden="true"
                      >
                        +91
                      </span>
                      <input
                        id="user_phone"
                        data-testid="contact-input-phone"
                        type="tel"
                        inputMode="numeric"
                        autoComplete="tel-national"
                        minLength={10}
                        maxLength={10}
                        pattern="[0-9]{10}"
                        value={phoneDigits}
                        onChange={handlePhoneChange}
                        placeholder="98765 43210"
                        className="flex-1 min-w-0 bg-transparent px-3 text-sm placeholder:text-muted-foreground focus:outline-none"
                        aria-label={t.contact_page.form.phone}
                      />
                    </div>
                    <input
                      type="hidden"
                      name="user_phone"
                      value={phoneDigits ? `+91 ${phoneDigits}` : ""}
                    />
                  </div>

                  <div className="sm:col-span-1">
                    <label htmlFor="subject" className="block text-xs uppercase tracking-[0.2em] text-muted-foreground mb-2">
                      {t.contact_page.form.subject}
                    </label>
                    <Input
                      id="subject"
                      data-testid="contact-input-subject"
                      name="subject"
                      type="text"
                      required
                      placeholder={lang === "hi" ? "विषय" : "Subject"}
                      className="h-12 rounded-xl"
                    />
                  </div>

                  <div className="sm:col-span-2">
                    <label htmlFor="message" className="block text-xs uppercase tracking-[0.2em] text-muted-foreground mb-2">
                      {t.contact_page.form.message}
                    </label>
                    <Textarea
                      id="message"
                      data-testid="contact-input-message"
                      name="message"
                      required
                      rows={5}
                      placeholder={lang === "hi" ? "आपका संदेश यहाँ लिखें…" : "Tell us how we can help…"}
                      className="rounded-xl resize-none"
                    />
                  </div>

                  <div className="sm:col-span-2 flex flex-col sm:flex-row gap-3 sm:items-center sm:justify-between pt-2">
                    <p className="text-xs text-muted-foreground max-w-md">
                      {lang === "hi"
                        ? "हम 24 घंटे के भीतर उत्तर देंगे। आपातकाल के लिए कृपया फ़ोन करें।"
                        : "We typically respond within 24 hours. For emergencies, please call directly."}
                    </p>
                    <button
                      type="submit"
                      data-testid="contact-submit"
                      disabled={sending}
                      className="inline-flex items-center justify-center gap-2 rounded-full bg-primary text-primary-foreground px-7 py-4 text-sm font-medium transition-all hover:-translate-y-1 hover:shadow-xl disabled:opacity-60 disabled:cursor-not-allowed disabled:translate-y-0"
                    >
                      {sending ? t.actions.sending : t.actions.send}
                      <Send className="w-4 h-4" />
                    </button>
                  </div>
                </form>
              </div>
            </Reveal>
          </div>

          {/* Info cards */}
          <div className="lg:col-span-5 space-y-5">
            <Reveal>
              <div className="rounded-3xl bg-primary text-primary-foreground p-7 sm:p-8">
                <div className="flex items-center justify-center w-12 h-12 rounded-2xl bg-primary-foreground/10 border border-primary-foreground/20 mb-5">
                  <Phone className="w-5 h-5" strokeWidth={2} />
                </div>
                <div className="text-xs uppercase tracking-[0.25em] opacity-70 mb-2">
                  {t.contact_page.info.phone_title}
                </div>
                <a href={`tel:${PHONES.primary}`} data-testid="contact-phone-1" className="block font-display text-2xl sm:text-3xl tracking-tight underline-grow">
                  {t.contact_page.info.phone_value_a}
                </a>
                <a href={`tel:${PHONES.secondary}`} data-testid="contact-phone-2" className="block mt-1 font-display text-2xl sm:text-3xl tracking-tight underline-grow opacity-90">
                  {t.contact_page.info.phone_value_b}
                </a>
                <a
                  href={`https://wa.me/${PHONES.primary.replace("+", "")}`}
                  target="_blank"
                  rel="noopener noreferrer"
                  data-testid="contact-whatsapp"
                  className="mt-5 inline-flex items-center gap-2 rounded-full bg-accent text-accent-foreground px-5 py-2.5 text-sm font-medium hover:-translate-y-0.5 transition-transform"
                >
                  <MessageCircle className="w-4 h-4" /> WhatsApp
                </a>
              </div>
            </Reveal>

            <Reveal delay={0.05}>
              <div className="rounded-3xl bg-card border border-border p-7 sm:p-8">
                <div className="flex items-center justify-center w-12 h-12 rounded-2xl bg-accent/15 text-accent mb-5">
                  <MapPin className="w-5 h-5" strokeWidth={2} />
                </div>
                <div className="text-xs uppercase tracking-[0.25em] text-muted-foreground mb-2">
                  {t.contact_page.info.address_title}
                </div>
                <p className="font-display text-lg tracking-tight text-foreground leading-snug">
                  {t.contact_page.info.address_value}
                </p>
                <a
                  href="https://www.google.com/maps/search/?api=1&query=Mahaveer+Multi+Speciality+Hospital+Adarsh+Nagar+Samastipur"
                  target="_blank"
                  rel="noopener noreferrer"
                  data-testid="contact-maps-link"
                  className="mt-4 inline-flex items-center gap-2 text-sm font-medium text-primary underline-grow"
                >
                  {t.actions.open_maps} <ArrowRight className="w-3.5 h-3.5" />
                </a>
              </div>
            </Reveal>

            <Reveal delay={0.1}>
              <div className="grid grid-cols-2 gap-4">
                <div className="rounded-3xl bg-card border border-border p-6">
                  <div className="flex items-center justify-center w-10 h-10 rounded-xl bg-accent/15 text-accent mb-4">
                    <Mail className="w-4 h-4" />
                  </div>
                  <div className="text-[10px] uppercase tracking-[0.2em] text-muted-foreground mb-1">
                    {t.contact_page.info.email_title}
                  </div>
                  <a href={`mailto:${t.contact_page.info.email_value}`} data-testid="contact-email" className="text-sm text-foreground underline-grow break-all">
                    {t.contact_page.info.email_value}
                  </a>
                </div>
                <div className="rounded-3xl bg-card border border-border p-6">
                  <div className="flex items-center justify-center w-10 h-10 rounded-xl bg-accent/15 text-accent mb-4">
                    <Clock className="w-4 h-4" />
                  </div>
                  <div className="text-[10px] uppercase tracking-[0.2em] text-muted-foreground mb-1">
                    {t.contact_page.info.hours_title}
                  </div>
                  <div className="text-sm text-foreground leading-snug">{t.contact_page.info.hours_value}</div>
                </div>
              </div>
            </Reveal>
          </div>
        </div>
      </Section>

      <Section className="pt-0" testId="contact-map">
        <Reveal>
          <div className="relative w-full rounded-3xl overflow-hidden border border-border aspect-[16/8]">
            <iframe
              title="Mahaveer Hospital Map"
              src="https://www.google.com/maps?q=Adarsh+Nagar,+Samastipur,+Bihar&output=embed"
              loading="lazy"
              referrerPolicy="no-referrer-when-downgrade"
              className="absolute inset-0 w-full h-full"
            />
          </div>
        </Reveal>
      </Section>
    </main>
  );
}
