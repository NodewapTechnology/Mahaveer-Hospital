import React from "react";
import { useApp } from "@/context/AppContext";
import { PHONES } from "@/lib/translations";
import { Section, Reveal, Overline } from "@/components/Section";
import { Sparkles, GraduationCap, Phone, Calendar, CheckCircle2, ArrowRight } from "lucide-react";
import { Link } from "react-router-dom";
import DoctorPicture from "@/components/DoctorPicture";
import Seo from "@/components/Seo";
import { HOSPITAL_SCHEMA, DR_AMARDEEP_SCHEMA, breadcrumbSchema } from "@/lib/schema";

export default function Doctors() {
  const { t, lang } = useApp();
  const featured = t.doctors.list.find((d) => d.featured);
  const others = t.doctors.list.filter((d) => !d.featured);
  const title = lang === "hi"
    ? "डॉक्टर्स — डॉ. अमरदीप एवं टीम · महावीर हॉस्पिटल"
    : "Doctors — Meet Dr. Amardeep & Team · Mahaveer Hospital";
  const description = lang === "hi"
    ? "डॉ. अमरदीप (MBBS, MS, FMAS) — वरिष्ठ सलाहकार एवं सर्जरी प्रमुख। AIIMS-प्रशिक्षित सर्जनों की टीम — लैप्रोस्कोपिक सर्जरी, ऑर्थोपेडिक्स एवं स्त्री-रोग विशेषज्ञ। समस्तीपुर में सर्वश्रेष्ठ देखभाल।"
    : "Meet Dr. Amardeep (MBBS, MS, FMAS) — Senior Consultant & Head of Surgery at Mahaveer Multi-Speciality Hospital, Samastipur. AIIMS-trained team of laparoscopic surgeons, orthopaedic specialists and gynaecologists.";

  return (
    <main data-testid="page-doctors" className="pt-8">
      <Seo
        title={title}
        description={description}
        canonicalPath="/doctors"
        keywords="Dr Amardeep Samastipur, best surgeon Bihar, laparoscopic surgeon FMAS, MBBS MS surgeon, orthopaedic doctor Samastipur, gynaecologist near me, senior consultant surgery"
        structuredData={[
          HOSPITAL_SCHEMA,
          DR_AMARDEEP_SCHEMA,
          breadcrumbSchema([{ name: "Doctors", path: "/doctors" }]),
        ]}
      />
      <Section className="pt-12 pb-12" testId="doc-hero">
        <div className="max-w-4xl space-y-6">
          <Reveal><Overline>{t.doctors_page.overline}</Overline></Reveal>
          <Reveal delay={0.05}>
            <h1 className="font-display text-5xl sm:text-6xl lg:text-7xl tracking-tight leading-[0.97] text-balance text-foreground">
              {t.doctors_page.title}
            </h1>
          </Reveal>
          <Reveal delay={0.15}>
            <p className="text-base sm:text-lg text-muted-foreground leading-relaxed">
              {t.doctors_page.subtitle}
            </p>
          </Reveal>
        </div>
      </Section>

      {/* Featured doctor — Dr. Amardeep — large editorial layout. Mobile: image-on-top + details below in one unified card. */}
      <Section testId="doctor-featured-page">
        <Reveal>
          <div className="relative rounded-3xl border border-border bg-card overflow-hidden shadow-sm">
            <div className="absolute top-0 inset-x-0 h-1 bg-accent z-10" />
            <div className="grid lg:grid-cols-12 items-stretch">
              <div
                className="lg:col-span-5 relative overflow-hidden aspect-[880/1094] lg:aspect-auto lg:min-h-[680px]"
                style={{
                  background:
                    "linear-gradient(155deg, hsl(var(--primary)) 0%, hsl(var(--primary) / 0.85) 60%, hsl(var(--accent) / 0.65) 100%)",
                }}
              >
                <div className="absolute inset-x-0 top-0 h-1/4 bg-gradient-to-b from-foreground/15 to-transparent pointer-events-none z-[5]" />
                <div className="hidden sm:inline-flex absolute top-4 left-4 items-center gap-2 rounded-full bg-background/15 backdrop-blur-md border border-white/20 px-3 py-1.5 text-[10px] font-semibold uppercase tracking-[0.2em] text-white z-10 max-w-[calc(100%-2rem)]">
                  <Sparkles className="w-3 h-3 text-accent flex-shrink-0" />
                  <span className="truncate">{t.doctors.featured_overline}</span>
                </div>
                <DoctorPicture
                  alt={featured.name}
                  loading="eager"
                  fetchPriority="high"
                  sizes="(max-width: 640px) 90vw, (max-width: 1024px) 80vw, 480px"
                  className="absolute inset-x-0 bottom-0 w-full h-full object-contain object-bottom z-10"
                />
              </div>

              <div className="lg:col-span-7 p-6 sm:p-9 lg:p-14 flex flex-col gap-4 sm:gap-5">
                <div className="text-[10px] sm:text-xs uppercase tracking-[0.3em] text-accent font-semibold">
                  {featured.role}
                </div>
                <h2 className="font-display text-3xl sm:text-4xl lg:text-5xl xl:text-6xl tracking-tight leading-[1] text-foreground">
                  {featured.name}
                </h2>
                <div className="inline-flex items-center gap-2 rounded-full border border-border bg-muted/40 px-3.5 py-1.5 text-xs sm:text-sm text-foreground self-start">
                  <GraduationCap className="w-3.5 h-3.5 sm:w-4 sm:h-4 text-accent" />
                  <span>{featured.credentials}</span>
                </div>
                <p className="text-sm sm:text-base lg:text-lg text-muted-foreground leading-relaxed">
                  {featured.bio}
                </p>

                {/* Highlights */}
                <ul className="grid grid-cols-1 sm:grid-cols-2 gap-x-5 gap-y-2 mt-1">
                  {featured.highlights?.map((h, i) => (
                    <li key={i} className="flex items-start gap-2 text-xs sm:text-sm text-foreground/85">
                      <CheckCircle2 className="w-3.5 h-3.5 sm:w-4 sm:h-4 text-accent mt-0.5 flex-shrink-0" />
                      <span>{h}</span>
                    </li>
                  ))}
                </ul>

                {/* Conditions chips */}
                <div className="pt-2">
                  <div className="text-[10px] uppercase tracking-[0.25em] text-muted-foreground mb-2.5 font-semibold">
                    {lang === "hi" ? "मुख्य उपचार" : "Conditions treated"}
                  </div>
                  <div className="flex flex-wrap gap-2">
                    {featured.conditions?.map((c, j) => (
                      <span
                        key={j}
                        className="inline-flex items-center rounded-full border border-border bg-muted/30 px-3 py-1.5 text-xs text-foreground/85"
                      >
                        {c}
                      </span>
                    ))}
                  </div>
                </div>

                <div className="flex flex-col sm:flex-row gap-3 pt-3">
                  <Link
                    to="/contact"
                    data-testid="featured-page-book"
                    className="inline-flex items-center justify-center gap-2 rounded-full bg-primary text-primary-foreground px-5 sm:px-6 py-3 sm:py-3.5 text-sm font-semibold hover:-translate-y-1 hover:shadow-xl transition-all"
                  >
                    <Calendar className="w-4 h-4" />
                    {t.nav.book}
                  </Link>
                  <a
                    href={`tel:${PHONES.primary}`}
                    data-testid="featured-page-call"
                    className="inline-flex items-center justify-center gap-2 rounded-full border border-border px-5 sm:px-6 py-3 sm:py-3.5 text-sm font-semibold hover:border-accent hover:text-accent transition-colors"
                  >
                    <Phone className="w-4 h-4" /> {t.actions.call_now}
                  </a>
                </div>
              </div>
            </div>
          </div>
        </Reveal>
      </Section>

      {/* Other doctors — premium text-only cards, no images */}
      <Section className="bg-muted/30" testId="doctors-other-section">
        <div className="mb-10 max-w-2xl">
          <Reveal>
            <Overline>{lang === "hi" ? "अन्य सलाहकार" : "Other Consultants"}</Overline>
          </Reveal>
          <Reveal delay={0.05}>
            <h3 className="mt-4 font-display text-3xl sm:text-4xl tracking-tight text-foreground">
              {lang === "hi" ? "हमारी विशेषज्ञ टीम।" : "Our specialist team."}
            </h3>
          </Reveal>
        </div>

        <div className="grid grid-cols-1 md:grid-cols-2 gap-6 lg:gap-7">
          {others.map((d, i) => (
            <Reveal key={i} delay={i * 0.1}>
              <div
                data-testid={`doctor-other-${i}`}
                className="rounded-3xl border border-border bg-card p-7 sm:p-9 h-full flex flex-col gap-5 hover:-translate-y-1 hover:shadow-xl transition-all"
              >
                <div className="flex items-center gap-4">
                  <span className="flex items-center justify-center w-14 h-14 rounded-2xl bg-primary text-primary-foreground font-display text-xl">
                    {d.name.split(" ").slice(-1)[0].charAt(0)}
                  </span>
                  <div className="flex-1 min-w-0">
                    <div className="font-display text-2xl tracking-tight text-foreground leading-tight">{d.name}</div>
                    <div className="text-[10px] uppercase tracking-[0.2em] text-accent font-semibold mt-1">{d.role}</div>
                  </div>
                </div>
                <div className="inline-flex items-center gap-2 rounded-full border border-border bg-muted/40 px-3 py-1.5 text-xs text-foreground self-start">
                  <GraduationCap className="w-3.5 h-3.5 text-accent" />
                  <span>{d.credentials}</span>
                </div>
                <p className="text-sm sm:text-base text-muted-foreground leading-relaxed">{d.bio}</p>

                {d.conditions && d.conditions.length > 0 && (
                  <div className="pt-1">
                    <div className="text-[10px] uppercase tracking-[0.25em] text-muted-foreground mb-2.5 font-semibold">
                      {lang === "hi" ? "मुख्य उपचार" : "Conditions treated"}
                    </div>
                    <div className="flex flex-wrap gap-2">
                      {d.conditions.map((c, j) => (
                        <span
                          key={j}
                          className="inline-flex items-center rounded-full border border-border bg-background px-3 py-1 text-xs text-foreground/80"
                        >
                          {c}
                        </span>
                      ))}
                    </div>
                  </div>
                )}

                <div className="flex flex-col sm:flex-row gap-3 pt-2">
                  <Link
                    to="/contact"
                    data-testid={`doctor-other-${i}-book`}
                    className="inline-flex items-center justify-center gap-2 rounded-full bg-primary text-primary-foreground px-5 py-3 text-sm font-semibold hover:-translate-y-1 hover:shadow-xl transition-all"
                  >
                    <Calendar className="w-3.5 h-3.5" /> {t.nav.book}
                  </Link>
                  <a
                    href={`tel:${PHONES.primary}`}
                    data-testid={`doctor-other-${i}-call`}
                    className="inline-flex items-center justify-center gap-2 rounded-full border border-border px-5 py-3 text-sm font-semibold hover:border-accent hover:text-accent transition-colors"
                  >
                    <Phone className="w-3.5 h-3.5" /> {t.actions.call_now}
                  </a>
                </div>
              </div>
            </Reveal>
          ))}
        </div>
      </Section>
    </main>
  );
}
