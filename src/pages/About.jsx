import React from "react";
import { Link } from "react-router-dom";
import { useApp } from "@/context/AppContext";
import { ASSETS } from "@/lib/translations";
import { Section, Reveal, Overline } from "@/components/Section";
import Seo from "@/components/Seo";
import { HOSPITAL_SCHEMA, breadcrumbSchema } from "@/lib/schema";
import { CheckCircle2, Target, Compass, ShieldCheck, HeartHandshake, ArrowRight } from "lucide-react";

const VALUE_ICONS = [Target, Compass, ShieldCheck, HeartHandshake];

export default function About() {
  const { t, lang } = useApp();
  const title = lang === "hi"
    ? "हमारे बारे में — 15+ वर्षों की देखभाल · महावीर हॉस्पिटल"
    : "About Us — 15+ Years of Trusted Care in North Bihar";
  const description = lang === "hi"
    ? "2010 से समस्तीपुर में मरीज़-केंद्रित देखभाल। हमारा मिशन, दृष्टि, मूल्य एवं यात्रा जानें — 18,000+ मरीज़, AIIMS-प्रशिक्षित सर्जन एवं आधुनिक तकनीक।"
    : "Since 2010, Mahaveer Multi-Speciality Hospital has been Samastipur's trusted destination for patient-centred care. Learn about our mission, vision, values and 15-year journey — 18,000+ patients served by AIIMS-trained surgeons.";
  return (
    <main data-testid="page-about" className="pt-8">
      <Seo
        title={title}
        description={description}
        canonicalPath="/about"
        keywords="about Mahaveer Hospital, history hospital Samastipur, best surgeon Bihar, hospital mission vision, patient care North Bihar, Dr Amardeep about"
        structuredData={[
          HOSPITAL_SCHEMA,
          breadcrumbSchema([{ name: "About Us", path: "/about" }]),
        ]}
      />
      <Section className="pt-12 pb-20" testId="about-hero">
        <div className="grid lg:grid-cols-12 gap-12 items-end">
          <div className="lg:col-span-7 space-y-7">
            <Reveal><Overline>{t.about_page.overline}</Overline></Reveal>
            <Reveal delay={0.05}>
              <h1 className="font-display text-5xl sm:text-6xl lg:text-7xl tracking-tight leading-[0.97] text-balance text-foreground">
                {t.about_page.hero_title}
              </h1>
            </Reveal>
            <Reveal delay={0.15}>
              <p className="text-base sm:text-lg text-muted-foreground leading-relaxed max-w-2xl">
                {t.about_page.hero_subtitle}
              </p>
            </Reveal>
          </div>
          <div className="lg:col-span-5">
            <Reveal delay={0.2}>
              <div className="relative aspect-[4/5] rounded-3xl overflow-hidden border border-border">
                <img
                  src={ASSETS.gallery[0]}
                  alt="Hospital"
                  loading="lazy"
                  decoding="async"
                  width={1000}
                  height={650}
                  className="w-full h-full object-cover"
                />
                <div className="absolute inset-0 bg-gradient-to-t from-foreground/40 to-transparent" />
              </div>
            </Reveal>
          </div>
        </div>
      </Section>

      <Section className="bg-muted/40" testId="about-mission">
        <div className="grid lg:grid-cols-12 gap-12">
          <div className="lg:col-span-6 space-y-5">
            <Reveal><Overline>{t.about_page.mission_overline}</Overline></Reveal>
            <Reveal delay={0.05}>
              <h2 className="font-display text-4xl sm:text-5xl tracking-tight leading-tight text-foreground">
                {t.about_page.mission_title}
              </h2>
            </Reveal>
            <Reveal delay={0.15}>
              <p className="text-base sm:text-lg text-muted-foreground leading-relaxed">{t.about_page.mission_body}</p>
            </Reveal>
          </div>
          <div className="lg:col-span-6 space-y-5">
            <Reveal><Overline>{t.about_page.vision_overline}</Overline></Reveal>
            <Reveal delay={0.05}>
              <h2 className="font-display text-4xl sm:text-5xl tracking-tight leading-tight text-foreground">
                {t.about_page.vision_title}
              </h2>
            </Reveal>
            <Reveal delay={0.15}>
              <p className="text-base sm:text-lg text-muted-foreground leading-relaxed">{t.about_page.vision_body}</p>
            </Reveal>
          </div>
        </div>
      </Section>

      <Section testId="about-values">
        <div className="mb-14 max-w-3xl">
          <Reveal><Overline>{lang === "hi" ? "मूल्य" : "Values"}</Overline></Reveal>
          <Reveal delay={0.05}>
            <h2 className="mt-4 font-display text-4xl sm:text-5xl tracking-tight text-foreground">
              {lang === "hi" ? "हमारे मूल्य।" : "The principles that anchor us."}
            </h2>
          </Reveal>
        </div>
        <div className="grid grid-cols-1 md:grid-cols-2 gap-5 lg:gap-7">
          {t.about_page.values.map((v, i) => {
            const Icon = VALUE_ICONS[i] || Target;
            return (
              <Reveal key={i} delay={i * 0.08}>
                <div className="h-full rounded-3xl border border-border bg-card p-7 sm:p-9 hover:-translate-y-1 hover:shadow-lg transition-all">
                  <div className="flex items-center justify-center w-12 h-12 rounded-2xl bg-primary text-primary-foreground mb-5">
                    <Icon className="w-5 h-5" strokeWidth={2} />
                  </div>
                  <h3 className="font-display text-2xl tracking-tight text-foreground">{v.title}</h3>
                  <p className="mt-3 text-sm sm:text-base text-muted-foreground leading-relaxed">{v.body}</p>
                </div>
              </Reveal>
            );
          })}
        </div>
      </Section>

      <Section className="bg-primary text-primary-foreground" testId="about-timeline">
        <div className="grid lg:grid-cols-12 gap-12 items-end mb-14">
          <div className="lg:col-span-7 space-y-6">
            <Reveal>
              <div className="text-xs sm:text-sm uppercase tracking-[0.3em] font-semibold text-accent">
                <span className="inline-flex items-center gap-3">
                  <span className="inline-block h-px w-8 bg-accent/60" />
                  {t.about_page.timeline_overline}
                </span>
              </div>
            </Reveal>
            <Reveal delay={0.05}>
              <h2 className="font-display text-4xl sm:text-5xl lg:text-6xl tracking-tight leading-[1.05] text-balance">
                {t.about_page.timeline_title}
              </h2>
            </Reveal>
          </div>
        </div>

        <div className="relative">
          <div className="absolute left-3 sm:left-5 top-0 bottom-0 w-px bg-primary-foreground/20" />
          <div className="space-y-10">
            {t.about_page.timeline.map((tl, i) => (
              <Reveal key={i} delay={i * 0.08}>
                <div className="relative pl-12 sm:pl-16">
                  <div className="absolute left-0 sm:left-2 top-1 flex items-center justify-center w-7 h-7 rounded-full bg-accent text-accent-foreground text-xs font-bold">
                    <CheckCircle2 className="w-3.5 h-3.5" strokeWidth={2.5} />
                  </div>
                  <div className="flex flex-col sm:flex-row sm:items-baseline gap-2 sm:gap-6">
                    <div className="font-display text-3xl sm:text-4xl tracking-tight text-accent">{tl.year}</div>
                    <div className="flex-1">
                      <h4 className="font-display text-xl sm:text-2xl tracking-tight">{tl.title}</h4>
                      <p className="mt-2 text-sm sm:text-base opacity-85 leading-relaxed max-w-2xl">{tl.body}</p>
                    </div>
                  </div>
                </div>
              </Reveal>
            ))}
          </div>
        </div>
      </Section>

      <Section testId="about-cta">
        <Reveal>
          <div className="text-center max-w-2xl mx-auto">
            <h3 className="font-display text-3xl sm:text-4xl tracking-tight text-foreground">
              {lang === "hi" ? "हमारी टीम से मिलना चाहेंगे?" : "Want to meet the team?"}
            </h3>
            <p className="mt-3 text-muted-foreground">{t.doctors.subtitle}</p>
            <Link
              to="/doctors"
              data-testid="about-meet-doctors"
              className="mt-8 inline-flex items-center gap-2 rounded-full bg-primary text-primary-foreground px-7 py-4 text-sm font-medium hover:-translate-y-1 hover:shadow-xl transition-all"
            >
              {t.actions.view_all} {t.nav.doctors} <ArrowRight className="w-3.5 h-3.5" />
            </Link>
          </div>
        </Reveal>
      </Section>
    </main>
  );
}
