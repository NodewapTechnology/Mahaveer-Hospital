import React from "react";
import { Link } from "react-router-dom";
import { useApp } from "@/context/AppContext";
import { NODEWAP_URL, PHONES } from "@/lib/translations";
import { Phone, MapPin, Mail, Diamond } from "lucide-react";
import Logo from "@/components/Logo";

export default function Footer() {
  const { t, lang } = useApp();
  const year = new Date().getFullYear();

  return (
    <footer className="relative footer-bg" data-testid="site-footer">
      <div className="absolute inset-0 grain pointer-events-none opacity-25" />

      <div className="relative max-w-7xl mx-auto px-6 sm:px-10 lg:px-12 py-16 sm:py-24">
        <div className="grid grid-cols-1 md:grid-cols-12 gap-10 md:gap-12">
          {/* Brand block — full width on mobile, 5 cols on desktop */}
          <div className="md:col-span-5 space-y-6">
            <div className="flex items-center gap-3 group">
              <Logo className="w-12 h-12" />
              <div className="leading-tight">
                <div className="font-display text-lg tracking-tight">
                  {t.meta.hospital_name}
                </div>
                <div className="text-[10px] uppercase tracking-[0.3em] opacity-70">
                  {t.footer.tagline}
                </div>
              </div>
            </div>
            <p className="text-sm leading-relaxed opacity-80 max-w-md">
              {lang === "hi"
                ? "उत्तर बिहार का भरोसेमंद मल्टी-स्पेशलिटी हॉस्पिटल — सर्जरी, ऑर्थोपेडिक्स, स्त्री-रोग एवं 24×7 आपातकालीन सेवा।"
                : "North Bihar's trusted multi-speciality hospital — laparoscopic surgery, orthopaedics, gynaecology and 24×7 emergency care."}
            </p>
            <div className="flex items-start gap-3 text-sm opacity-90">
              <MapPin className="w-4 h-4 mt-1 flex-shrink-0 text-accent" />
              <span>{t.footer.address}</span>
            </div>
          </div>

          {/* Mobile: 2-column row holding Explore + Reach Us side-by-side */}
          <div className="grid grid-cols-2 gap-6 md:contents">
            <div className="md:col-span-3 space-y-4">
              <h4 className="font-display text-sm sm:text-base mb-2 text-accent uppercase tracking-[0.18em]">{t.footer.explore_title}</h4>
              <ul className="space-y-2 text-sm opacity-85">
                <li><Link to="/" className="underline-grow inline-block">{t.nav.home}</Link></li>
                <li><Link to="/about" className="underline-grow inline-block">{t.nav.about}</Link></li>
                <li><Link to="/specialities" className="underline-grow inline-block">{t.nav.specialities}</Link></li>
                <li><Link to="/doctors" className="underline-grow inline-block">{t.nav.doctors}</Link></li>
                <li><Link to="/gallery" className="underline-grow inline-block">{t.nav.gallery}</Link></li>
                <li><Link to="/contact" className="underline-grow inline-block">{t.nav.contact}</Link></li>
              </ul>
            </div>

            <div className="md:col-span-4 space-y-4">
              <h4 className="font-display text-sm sm:text-base mb-2 text-accent uppercase tracking-[0.18em]">{t.footer.contact_title}</h4>
              <ul className="space-y-3 text-sm opacity-90">
                <li className="flex items-center gap-3">
                  <Phone className="w-3.5 h-3.5 flex-shrink-0 text-accent" />
                  <a href={`tel:${PHONES.primary}`} data-testid="footer-phone-1" className="underline-grow inline-block break-all">{PHONES.primary_display}</a>
                </li>
                <li className="flex items-center gap-3">
                  <Phone className="w-3.5 h-3.5 flex-shrink-0 text-accent" />
                  <a href={`tel:${PHONES.secondary}`} data-testid="footer-phone-2" className="underline-grow inline-block break-all">{PHONES.secondary_display}</a>
                </li>
                <li className="flex items-start gap-3">
                  <Mail className="w-3.5 h-3.5 flex-shrink-0 text-accent mt-1" />
                  <a href="mailto:info@mahaveerhospital.com" data-testid="footer-email" className="underline-grow inline-block break-all">info@mahaveerhospital.com</a>
                </li>
              </ul>

              <div className="pt-4 mt-4 border-t border-white/15">
                <div className="text-[10px] uppercase tracking-[0.25em] opacity-70 mb-2">
                  {lang === "hi" ? "आपातकाल" : "Emergency"}
                </div>
                <a
                  href={`tel:${PHONES.primary}`}
                  data-testid="footer-emergency-cta"
                  className="inline-flex items-center gap-2 rounded-full bg-destructive text-destructive-foreground px-3.5 sm:px-4 py-2 sm:py-2.5 text-xs sm:text-sm font-medium hover:-translate-y-0.5 transition-transform"
                >
                  <Phone className="w-3 h-3 sm:w-3.5 sm:h-3.5" strokeWidth={2.5} /> {t.nav.emergency}
                </a>
              </div>
            </div>
          </div>
        </div>

        <div className="mt-16 pt-8 border-t border-white/15 flex flex-col sm:flex-row items-start sm:items-center justify-between gap-4">
          <div className="text-xs opacity-70">
            {t.footer.copyright.replace("{year}", year)}
          </div>

          <a
            href={NODEWAP_URL}
            target="_blank"
            rel="noopener noreferrer"
            data-testid="nodewap-credit-link"
            className="group inline-flex items-center gap-2 text-xs sm:text-sm font-medium opacity-90 hover:opacity-100 transition-all"
          >
            <span>{t.footer.built_by}</span>
            <Diamond className="w-3.5 h-3.5 text-accent fill-accent transition-transform group-hover:rotate-180 duration-700" />
            <span className="underline-grow">{t.footer.built_by_suffix}</span>
          </a>
        </div>
      </div>
    </footer>
  );
}
