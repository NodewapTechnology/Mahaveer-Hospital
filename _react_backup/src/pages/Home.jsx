import React from "react";
import { Link } from "react-router-dom";
import { useApp } from "@/context/AppContext";
import { ASSETS, PHONES } from "@/lib/translations";
import DoctorPicture from "@/components/DoctorPicture";
import Seo from "@/components/Seo";
import {
  HOSPITAL_SCHEMA,
  DR_AMARDEEP_SCHEMA,
  WEBSITE_SCHEMA,
  breadcrumbSchema,
  faqSchema,
} from "@/lib/schema";
import { Section, Reveal, Overline } from "@/components/Section";
import CountUp from "@/components/CountUp";
import {
  Phone,
  Calendar,
  Activity,
  Scissors,
  Bone,
  Baby,
  Stethoscope,
  Ambulance,
  ShieldCheck,
  HeartHandshake,
  Sparkles,
  ArrowRight,
  Quote,
  CheckCircle2,
  GraduationCap,
} from "lucide-react";
function HeroBlock() {
  const { t, lang } = useApp();
  const featured = t.doctors.list.find((d) => d.featured);
  const heroStats = t.hero.stats || [];

  return (
    <section
      className="relative w-full overflow-hidden bg-background"
      data-testid="hero-section"
    >
      {/* Ambient layered backgrounds */}
      <div
        className="absolute inset-0 pointer-events-none"
        style={{
          background:
            "radial-gradient(60% 50% at 18% 22%, hsl(var(--accent) / 0.16) 0%, transparent 60%), radial-gradient(45% 45% at 82% 88%, hsl(var(--primary) / 0.18) 0%, transparent 60%)",
        }}
      />
      <div className="absolute inset-0 grain pointer-events-none opacity-[0.18]" />
      {/* Decorative dotted curve top-left */}
      <div
        className="absolute -top-8 -left-10 w-72 h-72 rounded-full opacity-30 pointer-events-none"
        style={{
          background:
            "radial-gradient(circle at center, hsl(var(--accent)/0.35) 0%, transparent 70%)",
        }}
      />

      <div className="relative z-10 max-w-7xl mx-auto px-5 sm:px-8 lg:px-12 pt-28 sm:pt-32 lg:pt-36 pb-12 sm:pb-16 lg:pb-24">
        <div className="grid lg:grid-cols-12 gap-y-10 lg:gap-x-12 xl:gap-x-16 items-center">
          {/* LEFT — text column */}
          <div className="lg:col-span-7 space-y-6 sm:space-y-7 lg:space-y-8">
            <Reveal>
              <span
                className="inline-flex items-center gap-2 rounded-full bg-accent/15 text-foreground px-4 py-1.5 text-[11px] sm:text-xs font-semibold border border-accent/30"
                data-testid="hero-badge"
              >
                <HeartHandshake className="w-3.5 h-3.5 text-accent" strokeWidth={2.4} />
                <span className="tracking-wide">{t.hero.badge}</span>
              </span>
            </Reveal>

            <Reveal delay={0.06}>
              <h1
                className="font-display tracking-tight leading-[1.02] text-balance text-foreground text-4xl sm:text-5xl lg:text-6xl xl:text-7xl"
                data-testid="hero-title"
              >
                <span className="block">{t.hero.title_a}</span>
                <span className="block">
                  <span className="relative inline-block">
                    <span className="relative z-10 text-accent">{t.hero.title_c}</span>
                    <span
                      aria-hidden="true"
                      className="absolute left-0 right-0 bottom-1 sm:bottom-1.5 h-[0.28em] sm:h-[0.30em] bg-accent/30 rounded-sm -z-0"
                    />
                  </span>
                </span>
              </h1>
            </Reveal>

            <Reveal delay={0.14}>
              <p className="max-w-xl text-sm sm:text-base lg:text-lg text-muted-foreground leading-relaxed">
                {t.hero.subtitle}
              </p>
            </Reveal>

            <Reveal delay={0.22}>
              <div className="flex flex-col sm:flex-row gap-3 sm:gap-4 pt-2">
                <Link
                  to="/contact"
                  data-testid="hero-cta-book"
                  className="group inline-flex items-center justify-center gap-2 rounded-full bg-primary text-primary-foreground px-6 sm:px-7 py-3.5 sm:py-4 text-sm font-semibold transition-all hover:-translate-y-1 hover:shadow-2xl hover:shadow-primary/40"
                >
                  <Calendar className="w-4 h-4" />
                  {t.hero.cta_primary}
                  <ArrowRight className="w-4 h-4 transition-transform group-hover:translate-x-1" />
                </Link>
                <Link
                  to="/contact"
                  data-testid="hero-cta-call"
                  className="inline-flex items-center justify-center gap-2 rounded-full border border-border bg-card text-foreground px-6 sm:px-7 py-3.5 sm:py-4 text-sm font-semibold transition-all hover:-translate-y-1 hover:border-accent hover:text-accent"
                >
                  <Phone className="w-4 h-4" />
                  {t.hero.cta_secondary}
                </Link>
              </div>
            </Reveal>

            {/* Stats row */}
            <Reveal delay={0.30}>
              <div className="pt-4 sm:pt-6 grid grid-cols-3 gap-3 sm:gap-6 lg:gap-8 max-w-lg">
                {heroStats.map((s, i) => (
                  <div key={i} className="flex flex-col" data-testid={`hero-stat-${i}`}>
                    <span className="font-display text-2xl sm:text-3xl lg:text-4xl text-primary tracking-tight leading-none whitespace-nowrap">
                      {s.value}
                    </span>
                    <span className="mt-2 text-[10px] sm:text-xs uppercase tracking-[0.15em] text-muted-foreground font-medium leading-tight">
                      {s.label}
                    </span>
                  </div>
                ))}
              </div>
            </Reveal>
          </div>

          {/* RIGHT — doctor card */}
          <div className="lg:col-span-5 relative">
            <Reveal delay={0.12}>
              <div className="relative" data-testid="hero-doctor-card">
                {/* Doctor card */}
                <div
                  className="relative rounded-[2rem] overflow-hidden aspect-[4/5] shadow-2xl shadow-primary/20 border border-border"
                  style={{
                    background:
                      "linear-gradient(160deg, hsl(var(--primary)) 0%, hsl(var(--primary) / 0.85) 45%, hsl(var(--accent) / 0.7) 100%)",
                  }}
                >
                  {/* Subtle pattern lines */}
                  <div className="absolute inset-0 opacity-[0.07] mix-blend-overlay" style={{ backgroundImage: "repeating-linear-gradient(45deg, white 0 1px, transparent 1px 18px)" }} />

                  {/* Doctor image — anchored bottom, fills card */}
                  <DoctorPicture
                    alt={featured.name}
                    loading="eager"
                    fetchPriority="high"
                    sizes="(max-width: 640px) 90vw, (max-width: 1024px) 80vw, 480px"
                    className="absolute inset-x-0 bottom-0 w-full h-[98%] object-contain object-bottom z-10 select-none"
                  />

                  {/* Bottom dark gradient + name overlay */}
                  <div className="absolute inset-x-0 bottom-0 z-20 pt-24 pb-7 px-7 bg-gradient-to-t from-black/85 via-black/55 to-transparent">
                    <div className="font-display text-2xl sm:text-3xl lg:text-[2rem] tracking-tight text-white leading-tight">
                      {t.hero.doctor_overlay.name}
                    </div>
                    <div className="mt-1.5 text-xs sm:text-sm text-white/85 font-medium">
                      {t.hero.doctor_overlay.credentials}
                    </div>
                    <div className="mt-0.5 text-[11px] sm:text-xs text-white/70">
                      {t.hero.doctor_overlay.role}
                    </div>
                  </div>
                </div>

                {/* Floating "100% Safe Care" badge — normal flow below card on mobile, absolute on desktop */}
                <div
                  className="static mt-3 inline-flex sm:absolute sm:mt-0 sm:-bottom-5 sm:-right-5 z-30 items-center gap-3 rounded-2xl bg-card border border-border shadow-xl px-3.5 py-2.5 sm:px-4 sm:py-3 animate-in fade-in slide-in-from-bottom-2 duration-700"
                  style={{ animationDelay: "450ms", animationFillMode: "both" }}
                  data-testid="hero-floating-badge"
                >
                  <span className="flex items-center justify-center w-9 h-9 sm:w-10 sm:h-10 rounded-full bg-emerald-500/15 text-emerald-600 dark:text-emerald-400 flex-shrink-0">
                    <ShieldCheck className="w-5 h-5" strokeWidth={2.2} />
                  </span>
                  <div className="leading-tight">
                    <div className="font-display text-sm sm:text-base text-foreground">
                      {t.hero.floating_badge.title}
                    </div>
                    <div className="text-[10px] sm:text-xs text-muted-foreground">
                      {t.hero.floating_badge.subtitle}
                    </div>
                  </div>
                </div>

                {/* Floating Emergency mini-badge — top-right of card */}
                <div
                  className="absolute -top-3 right-3 sm:right-4 z-30 inline-flex items-center gap-2 rounded-full bg-destructive text-destructive-foreground px-3 py-1.5 text-[10px] sm:text-[11px] font-semibold uppercase tracking-wider shadow-lg pulse-ring animate-in fade-in slide-in-from-top-2 duration-700"
                  style={{ animationDelay: "550ms", animationFillMode: "both" }}
                  data-testid="hero-emergency-pill"
                >
                  <span className="w-1.5 h-1.5 rounded-full bg-white animate-pulse" />
                  <span>{lang === "hi" ? "24×7 आपातकाल" : "24/7 Emergency"}</span>
                </div>
              </div>
            </Reveal>
          </div>
        </div>

        {/* Trust badges row — below grid */}
        <Reveal delay={0.38}>
          <div className="mt-14 sm:mt-16 lg:mt-20 pt-8 border-t border-border flex flex-wrap items-center gap-x-8 gap-y-3 text-xs sm:text-sm">
            {[t.hero.trust_a, t.hero.trust_b, t.hero.trust_c].map((trust, i) => (
              <div key={i} className="flex items-center gap-2 text-muted-foreground font-medium">
                <CheckCircle2 className="w-4 h-4 text-accent" strokeWidth={2.2} />
                <span>{trust}</span>
              </div>
            ))}
          </div>
        </Reveal>
      </div>
    </section>
  );
}

function EmergencyBanner() {
  const { t } = useApp();
  return (
    <Section className="py-12 sm:py-16" testId="emergency-banner-section">
      <Reveal>
        <div className="relative overflow-hidden rounded-3xl bg-destructive text-destructive-foreground p-8 sm:p-12">
          <div className="absolute -top-20 -right-20 w-72 h-72 rounded-full bg-white/10 blur-3xl" />
          <div className="absolute -bottom-20 -left-20 w-72 h-72 rounded-full bg-black/10 blur-3xl" />
          <div className="relative grid md:grid-cols-12 gap-8 items-center">
            <div className="md:col-span-2 flex items-center justify-start">
              <div className="flex items-center justify-center w-20 h-20 rounded-2xl bg-white/15 backdrop-blur-sm pulse-ring">
                <Ambulance className="w-10 h-10" strokeWidth={1.8} />
              </div>
            </div>
            <div className="md:col-span-6">
              <h3 className="font-display text-3xl sm:text-4xl tracking-tight">{t.emergency_banner.title}</h3>
              <p className="mt-3 text-sm sm:text-base opacity-90 max-w-xl">{t.emergency_banner.subtitle}</p>
            </div>
            <div className="md:col-span-4 flex flex-col gap-3">
              <a
                href={`tel:${PHONES.primary}`}
                data-testid="emergency-call-1"
                className="flex items-center justify-between gap-3 rounded-2xl bg-white/15 backdrop-blur-sm hover:bg-white/25 transition-colors px-5 py-4 group"
              >
                <span className="flex items-center gap-3">
                  <Phone className="w-4 h-4" />
                  <span className="text-base font-medium">{t.emergency_banner.line1}</span>
                </span>
                <ArrowRight className="w-4 h-4 transition-transform group-hover:translate-x-1" />
              </a>
              <a
                href={`tel:${PHONES.secondary}`}
                data-testid="emergency-call-2"
                className="flex items-center justify-between gap-3 rounded-2xl bg-white/15 backdrop-blur-sm hover:bg-white/25 transition-colors px-5 py-4 group"
              >
                <span className="flex items-center gap-3">
                  <Phone className="w-4 h-4" />
                  <span className="text-base font-medium">{t.emergency_banner.line2}</span>
                </span>
                <ArrowRight className="w-4 h-4 transition-transform group-hover:translate-x-1" />
              </a>
            </div>
          </div>
        </div>
      </Reveal>
    </Section>
  );
}

function IntroBlock() {
  const { t } = useApp();
  return (
    <Section testId="intro-section">
      <div className="grid lg:grid-cols-12 gap-12 lg:gap-20 items-start">
        <div className="lg:col-span-6 space-y-6">
          <Reveal>
            <Overline>{t.intro.overline}</Overline>
          </Reveal>
          <Reveal delay={0.05}>
            <h2 className="font-display text-4xl sm:text-5xl lg:text-6xl tracking-tight leading-[1.05] text-balance text-foreground">
              {t.intro.title}
            </h2>
          </Reveal>
        </div>
        <div className="lg:col-span-6 space-y-6 lg:pt-6">
          <Reveal delay={0.1}>
            <p className="text-base sm:text-lg leading-relaxed text-muted-foreground">{t.intro.body_1}</p>
          </Reveal>
          <Reveal delay={0.2}>
            <p className="text-base sm:text-lg leading-relaxed text-muted-foreground">{t.intro.body_2}</p>
          </Reveal>
          <Reveal delay={0.3}>
            <Link
              to="/about"
              data-testid="intro-learn-more"
              className="inline-flex items-center gap-2 text-sm font-medium text-primary underline-grow"
            >
              {t.actions.learn_more} <ArrowRight className="w-3.5 h-3.5" />
            </Link>
          </Reveal>
        </div>
      </div>

      <div className="mt-20 grid grid-cols-2 lg:grid-cols-4 gap-6 lg:gap-8">
        {t.intro.stats.map((s, i) => (
          <Reveal key={i} delay={i * 0.08}>
            <div className="rounded-3xl border border-border bg-card p-6 sm:p-8 h-full">
              <CountUp to={s.value} suffix={s.suffix} />
              <div className="mt-3 text-xs sm:text-sm uppercase tracking-[0.18em] text-muted-foreground">
                {s.label}
              </div>
            </div>
          </Reveal>
        ))}
      </div>
    </Section>
  );
}

const SPECIALITY_VISUALS = [
  { key: "surgery", icon: Scissors, image: ASSETS.speciality_images.surgery },
  { key: "ortho", icon: Bone, image: ASSETS.speciality_images.ortho },
  { key: "gynae", icon: Baby, image: ASSETS.speciality_images.gynae },
];

function SpecialitiesBlock() {
  const { t } = useApp();
  return (
    <Section className="bg-muted/40" testId="specialities-section">
      <div className="grid lg:grid-cols-12 gap-12 items-end mb-14">
        <div className="lg:col-span-7 space-y-6">
          <Reveal><Overline>{t.specialities.overline}</Overline></Reveal>
          <Reveal delay={0.05}>
            <h2 className="font-display text-4xl sm:text-5xl lg:text-6xl tracking-tight leading-[1.05] text-balance text-foreground">
              {t.specialities.title}
            </h2>
          </Reveal>
        </div>
        <div className="lg:col-span-5">
          <Reveal delay={0.15}>
            <p className="text-base sm:text-lg text-muted-foreground leading-relaxed">{t.specialities.subtitle}</p>
          </Reveal>
        </div>
      </div>

      <div className="grid grid-cols-1 md:grid-cols-3 gap-6 lg:gap-8">
        {t.specialities.list.map((sp, i) => {
          const visual = SPECIALITY_VISUALS[i];
          const Icon = visual.icon;
          return (
            <Reveal key={sp.key} delay={i * 0.12}>
              <div
                data-testid={`speciality-card-${sp.key}`}
                className="group relative rounded-2xl bg-card border border-border overflow-hidden h-full flex flex-col transition-all duration-500 hover:-translate-y-2 hover:shadow-2xl hover:border-accent/50"
              >
                {/* Premium gold top accent */}
                <div className="absolute top-0 inset-x-0 h-[3px] bg-accent z-10" />
                <div className="relative aspect-[4/3] overflow-hidden">
                  <img
                    src={visual.image}
                    alt={sp.name}
                    loading="lazy"
                    decoding="async"
                    width={800}
                    height={600}
                    className="w-full h-full object-cover transition-transform duration-700 group-hover:scale-110"
                  />
                  <div className="absolute inset-0 bg-gradient-to-t from-primary/80 via-primary/20 to-transparent" />
                  <div className="absolute top-5 left-5 flex items-center justify-center w-12 h-12 rounded-full bg-card/90 backdrop-blur-md text-primary border border-accent/40 shadow-lg">
                    <Icon className="w-5 h-5" strokeWidth={2.2} />
                  </div>
                  <div className="absolute top-5 right-5">
                    <span className="inline-flex items-center rounded-full bg-card/90 backdrop-blur-md text-primary px-3 py-1 text-[10px] font-bold tracking-[0.2em] border border-accent/30">
                      {`0${i + 1}`}
                    </span>
                  </div>
                </div>
                <div className="p-6 sm:p-7 flex-1 flex flex-col">
                  <h3 className="font-display text-2xl tracking-tight text-foreground leading-tight">{sp.name}</h3>
                  <p className="mt-3 text-sm text-muted-foreground leading-relaxed">{sp.headline}</p>
                  <ul className="mt-5 space-y-2.5 flex-1">
                    {sp.bullets.slice(0, 4).map((b, j) => (
                      <li key={j} className="flex items-start gap-2.5 text-sm text-foreground/80">
                        <CheckCircle2 className="w-4 h-4 text-accent mt-0.5 flex-shrink-0" />
                        <span>{b}</span>
                      </li>
                    ))}
                  </ul>
                  <Link
                    to="/specialities"
                    data-testid={`speciality-link-${sp.key}`}
                    className="mt-6 inline-flex items-center gap-2 text-sm font-semibold text-primary underline-grow self-start"
                  >
                    {t.actions.learn_more} <ArrowRight className="w-3.5 h-3.5" />
                  </Link>
                </div>
              </div>
            </Reveal>
          );
        })}
      </div>
    </Section>
  );
}

function DoctorsBlock() {
  const { t } = useApp();
  const featured = t.doctors.list.find((d) => d.featured);
  const others = t.doctors.list.filter((d) => !d.featured);

  return (
    <Section testId="doctors-preview-section">
      <div className="grid lg:grid-cols-12 gap-12 items-end mb-14">
        <div className="lg:col-span-7 space-y-6">
          <Reveal><Overline>{t.doctors.overline}</Overline></Reveal>
          <Reveal delay={0.05}>
            <h2 className="font-display text-4xl sm:text-5xl lg:text-6xl tracking-tight leading-[1.05] text-balance text-foreground">
              {t.doctors.title}
            </h2>
          </Reveal>
        </div>
        <div className="lg:col-span-5">
          <Reveal delay={0.15}>
            <p className="text-base sm:text-lg text-muted-foreground leading-relaxed">{t.doctors.subtitle}</p>
          </Reveal>
        </div>
      </div>

      {/* Featured doctor — Dr. Amardeep with transparent image. Mobile: image-on-top + details below in one unified card. */}
      <Reveal>
        <div
          data-testid="doctor-featured-amardeep"
          className="relative rounded-3xl border border-border bg-card overflow-hidden mb-8 lg:mb-10 shadow-sm"
        >
          <div className="absolute top-0 inset-x-0 h-1 bg-accent z-10" />
          <div className="grid lg:grid-cols-12 items-stretch">
            {/* Image — top on mobile (compact), left on desktop */}
            <div
              className="lg:col-span-5 relative overflow-hidden aspect-[880/1094] lg:aspect-auto lg:min-h-[560px]"
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
                loading="lazy"
                sizes="(max-width: 640px) 90vw, (max-width: 1024px) 80vw, 420px"
                className="absolute inset-x-0 bottom-0 w-full h-full object-contain object-bottom z-10"
              />
            </div>

            {/* Details */}
            <div className="lg:col-span-7 p-6 sm:p-9 lg:p-12 flex flex-col gap-4 sm:gap-5">
              <div className="text-[10px] sm:text-xs uppercase tracking-[0.3em] text-accent font-semibold">
                {featured.role}
              </div>
              <h3 className="font-display text-3xl sm:text-4xl lg:text-5xl xl:text-6xl tracking-tight leading-[1] text-foreground">
                {featured.name}
              </h3>
              <div className="inline-flex items-center gap-2 rounded-full border border-border bg-muted/40 px-3.5 py-1.5 text-xs sm:text-sm text-foreground self-start">
                <GraduationCap className="w-3.5 h-3.5 sm:w-4 sm:h-4 text-accent" />
                <span>{featured.credentials}</span>
              </div>
              <p className="text-sm sm:text-base text-muted-foreground leading-relaxed">
                {featured.bio}
              </p>

              {/* Highlights — 2 cols */}
              <ul className="grid grid-cols-1 sm:grid-cols-2 gap-x-5 gap-y-2 mt-1">
                {featured.highlights?.map((h, i) => (
                  <li key={i} className="flex items-start gap-2 text-xs sm:text-sm text-foreground/85">
                    <CheckCircle2 className="w-3.5 h-3.5 sm:w-4 sm:h-4 text-accent mt-0.5 flex-shrink-0" />
                    <span>{h}</span>
                  </li>
                ))}
              </ul>

              <div className="flex flex-col sm:flex-row gap-3 pt-3">
                <Link
                  to="/doctors"
                  data-testid="featured-doctor-cta"
                  className="inline-flex items-center justify-center gap-2 rounded-full bg-primary text-primary-foreground px-5 sm:px-6 py-3 sm:py-3.5 text-sm font-semibold hover:-translate-y-1 hover:shadow-xl transition-all"
                >
                  {t.doctors.featured_meet} <ArrowRight className="w-4 h-4" />
                </Link>
                <a
                  href={`tel:${PHONES.primary}`}
                  data-testid="featured-doctor-call"
                  className="inline-flex items-center justify-center gap-2 rounded-full border border-border px-5 sm:px-6 py-3 sm:py-3.5 text-sm font-semibold hover:border-accent hover:text-accent transition-colors"
                >
                  <Phone className="w-4 h-4" /> {t.actions.call_now}
                </a>
              </div>
            </div>
          </div>
        </div>
      </Reveal>

      {/* Other doctors — compact text cards, no images */}
      <div className="grid grid-cols-1 md:grid-cols-2 gap-5 lg:gap-6">
        {others.map((d, i) => (
          <Reveal key={i} delay={i * 0.08}>
            <div
              data-testid={`doctor-card-other-${i}`}
              className="rounded-2xl border border-border bg-card p-6 sm:p-7 h-full flex flex-col gap-4 hover:-translate-y-1 hover:shadow-xl hover:border-accent/40 transition-all"
            >
              <div className="flex items-center gap-3">
                <span className="flex items-center justify-center w-11 h-11 rounded-full bg-primary/10 border border-primary/20 text-primary font-display text-base">
                  {d.name.split(" ").slice(-1)[0].charAt(0)}
                </span>
                <div className="flex-1 min-w-0">
                  <div className="font-display text-lg tracking-tight text-foreground leading-tight">{d.name}</div>
                  <div className="text-[10px] uppercase tracking-[0.2em] text-accent font-semibold mt-0.5">{d.role}</div>
                </div>
              </div>
              <div className="inline-flex items-center gap-2 rounded-full border border-border bg-muted/40 px-3 py-1.5 text-xs text-foreground self-start">
                <GraduationCap className="w-3.5 h-3.5 text-accent" />
                <span>{d.credentials}</span>
              </div>
              <p className="text-sm text-muted-foreground leading-relaxed">{d.short_bio || d.bio}</p>
            </div>
          </Reveal>
        ))}
      </div>

      <div className="mt-10 text-center">
        <Reveal>
          <Link
            to="/doctors"
            data-testid="doctors-view-all"
            className="inline-flex items-center gap-2 rounded-full border border-border px-6 py-3 text-sm font-semibold hover:border-primary hover:text-primary transition-colors"
          >
            {t.actions.view_all} <ArrowRight className="w-3.5 h-3.5" />
          </Link>
        </Reveal>
      </div>
    </Section>
  );
}

const WHY_ICONS = [Stethoscope, Activity, Ambulance, ShieldCheck, HeartHandshake];

function WhyBlock() {
  const { t } = useApp();
  return (
    <Section className="bg-primary text-primary-foreground" testId="why-section">
      <div className="grid lg:grid-cols-12 gap-12 mb-14">
        <div className="lg:col-span-6 space-y-6">
          <Reveal><div className="text-xs sm:text-sm uppercase tracking-[0.3em] font-semibold text-accent"><span className="inline-flex items-center gap-3"><span className="inline-block h-px w-8 bg-accent/60" />{t.why.overline}</span></div></Reveal>
          <Reveal delay={0.05}>
            <h2 className="font-display text-4xl sm:text-5xl lg:text-6xl tracking-tight leading-[1.05] text-balance">
              {t.why.title}
            </h2>
          </Reveal>
        </div>
      </div>
      <div className="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-5 gap-4 lg:gap-6">
        {t.why.points.map((p, i) => {
          const Icon = WHY_ICONS[i] || Sparkles;
          return (
            <Reveal key={i} delay={i * 0.08}>
              <div className="h-full rounded-3xl bg-primary-foreground/[0.07] border border-primary-foreground/15 p-7 flex flex-col gap-4 hover:bg-primary-foreground/[0.12] transition-colors">
                <div className="flex items-center justify-center w-12 h-12 rounded-2xl bg-accent/20 text-accent">
                  <Icon className="w-5 h-5" strokeWidth={2} />
                </div>
                <div>
                  <h4 className="font-display text-lg tracking-tight">{p.title}</h4>
                  <p className="mt-2 text-sm leading-relaxed opacity-80">{p.body}</p>
                </div>
              </div>
            </Reveal>
          );
        })}
      </div>
    </Section>
  );
}

function FacilitiesBlock() {
  const { t } = useApp();
  return (
    <Section testId="facilities-section">
      <div className="grid lg:grid-cols-12 gap-12 items-end mb-14">
        <div className="lg:col-span-7 space-y-6">
          <Reveal><Overline>{t.facilities.overline}</Overline></Reveal>
          <Reveal delay={0.05}>
            <h2 className="font-display text-4xl sm:text-5xl lg:text-6xl tracking-tight leading-[1.05] text-balance text-foreground">
              {t.facilities.title}
            </h2>
          </Reveal>
        </div>
      </div>
      <div className="grid grid-cols-2 md:grid-cols-4 gap-3 sm:gap-5">
        {t.facilities.items.map((f, i) => (
          <Reveal key={i} delay={i * 0.05}>
            <div className="rounded-2xl border border-border bg-card p-5 sm:p-6 h-full hover:border-primary/40 hover:-translate-y-1 transition-all">
              <div className="flex items-center justify-center w-10 h-10 rounded-xl bg-accent/15 text-accent mb-4">
                <Sparkles className="w-4 h-4" />
              </div>
              <div className="font-display text-base sm:text-lg tracking-tight text-foreground leading-snug">
                {f.name}
              </div>
            </div>
          </Reveal>
        ))}
      </div>
    </Section>
  );
}

function TestimonialsBlock() {
  const { t } = useApp();
  return (
    <Section className="bg-muted/40" testId="testimonials-section">
      <div className="grid lg:grid-cols-12 gap-12 items-end mb-14">
        <div className="lg:col-span-7 space-y-6">
          <Reveal><Overline>{t.testimonials.overline}</Overline></Reveal>
          <Reveal delay={0.05}>
            <h2 className="font-display text-4xl sm:text-5xl lg:text-6xl tracking-tight leading-[1.05] text-balance text-foreground">
              {t.testimonials.title}
            </h2>
          </Reveal>
        </div>
      </div>
      <div className="grid grid-cols-1 md:grid-cols-3 gap-6 lg:gap-8">
        {t.testimonials.list.map((tm, i) => (
          <Reveal key={i} delay={i * 0.1}>
            <figure
              data-testid={`testimonial-${i}`}
              className="h-full rounded-3xl bg-card border border-border p-7 sm:p-8 flex flex-col gap-5 hover:-translate-y-1 hover:shadow-lg transition-all"
            >
              <Quote className="w-9 h-9 text-accent" strokeWidth={1.4} />
              <blockquote className="text-base sm:text-lg leading-relaxed font-serif-accent text-foreground">
                "{tm.quote}"
              </blockquote>
              <figcaption className="mt-auto">
                <div className="font-display text-base text-foreground">{tm.name}</div>
                <div className="text-xs uppercase tracking-[0.2em] text-muted-foreground mt-1">{tm.role}</div>
              </figcaption>
            </figure>
          </Reveal>
        ))}
      </div>
    </Section>
  );
}

function InsuranceBlock() {
  const { t } = useApp();
  return (
    <Section testId="insurance-section">
      <div className="grid lg:grid-cols-12 gap-12 items-end mb-14">
        <div className="lg:col-span-7 space-y-6">
          <Reveal><Overline>{t.insurance.overline}</Overline></Reveal>
          <Reveal delay={0.05}>
            <h2 className="font-display text-3xl sm:text-4xl lg:text-5xl tracking-tight leading-[1.05] text-balance text-foreground">
              {t.insurance.title}
            </h2>
          </Reveal>
        </div>
        <div className="lg:col-span-5">
          <Reveal delay={0.15}>
            <p className="text-base text-muted-foreground leading-relaxed">{t.insurance.subtitle}</p>
          </Reveal>
        </div>
      </div>
      <div className="overflow-hidden border-y border-border py-8">
        <div className="flex gap-12 scroll-marquee whitespace-nowrap">
          {[...t.insurance.list, ...t.insurance.list].map((name, i) => (
            <span
              key={i}
              className="font-display text-2xl sm:text-3xl tracking-tight text-foreground/70 inline-flex items-center gap-12"
            >
              {name}
              <span className="text-accent">◆</span>
            </span>
          ))}
        </div>
      </div>
    </Section>
  );
}

function CtaStripBlock() {
  const { t } = useApp();
  return (
    <Section testId="cta-strip-section">
      <Reveal>
        <div className="relative overflow-hidden rounded-3xl bg-card border border-border p-10 sm:p-16">
          <div className="absolute inset-y-0 right-0 w-1/2 opacity-20 pointer-events-none">
            <img
              src={ASSETS.gallery[3]}
              alt=""
              loading="lazy"
              decoding="async"
              width={1000}
              height={650}
              className="w-full h-full object-cover"
              aria-hidden="true"
            />
          </div>
          <div className="absolute inset-0 bg-gradient-to-r from-card via-card/95 to-transparent" />
          <div className="relative max-w-2xl">
            <h2 className="font-display text-4xl sm:text-5xl tracking-tight text-foreground leading-tight">
              {t.cta_strip.title}
            </h2>
            <p className="mt-4 text-base sm:text-lg text-muted-foreground leading-relaxed">
              {t.cta_strip.subtitle}
            </p>
            <div className="mt-8 flex flex-col sm:flex-row gap-3">
              <Link
                to="/contact"
                data-testid="cta-strip-book"
                className="inline-flex items-center justify-center gap-2 rounded-full bg-primary text-primary-foreground px-7 py-4 text-sm font-medium transition-all hover:-translate-y-1 hover:shadow-xl"
              >
                <Calendar className="w-4 h-4" /> {t.cta_strip.cta_primary}
              </Link>
              <a
                href={`tel:${PHONES.primary}`}
                data-testid="cta-strip-call"
                className="inline-flex items-center justify-center gap-2 rounded-full bg-destructive text-destructive-foreground px-7 py-4 text-sm font-medium transition-all hover:-translate-y-1 hover:shadow-xl"
              >
                <Phone className="w-4 h-4" /> {t.cta_strip.cta_secondary}
              </a>
            </div>
          </div>
        </div>
      </Reveal>
    </Section>
  );
}

export default function Home() {
  const { lang } = useApp();
  const homeFaq = lang === "hi"
    ? [
        {
          q: "क्या महावीर हॉस्पिटल में 24×7 आपातकालीन सेवा उपलब्ध है?",
          a: "हाँ, महावीर मल्टी-स्पेशलिटी हॉस्पिटल में ट्रॉमा एवं इमरजेंसी टीम चौबीसों घंटे उपलब्ध है। +91 6287797276 पर कॉल करें।",
        },
        {
          q: "क्या यहाँ लैप्रोस्कोपिक (दूरबीन) सर्जरी होती है?",
          a: "हाँ, डॉ. अमरदीप (MBBS, MS, FMAS) 4K हाई-डेफिनिशन लैप्रोस्कोपिक सर्जरी करते हैं — पित्ताशय, अपेंडिक्स, हर्निया एवं पेट के ट्यूमर।",
        },
        {
          q: "अपॉइंटमेंट कैसे बुक करें?",
          a: "वेबसाइट पर 'Book Appointment' बटन पर क्लिक करें या +91 6287797276 पर कॉल करें। हमारी टीम आपको कॉलबैक करेगी।",
        },
        {
          q: "हॉस्पिटल कहाँ स्थित है?",
          a: "आदर्श नगर, समस्तीपुर, बिहार 848101 (NH-28 बाईपास के पास)।",
        },
      ]
    : [
        {
          q: "Does Mahaveer Hospital offer 24×7 emergency services?",
          a: "Yes, our trauma & emergency team at Mahaveer Multi-Speciality Hospital is available round-the-clock. Call +91 6287797276 immediately.",
        },
        {
          q: "Is laparoscopic (keyhole) surgery available here?",
          a: "Yes, Dr. Amardeep (MBBS, MS, FMAS) performs 4K high-definition laparoscopic surgery for gallbladder, appendix, hernia and abdominal tumours.",
        },
        {
          q: "How do I book an appointment?",
          a: "Click the 'Book Appointment' button on the site or call +91 6287797276. Our team will call you back to confirm your slot.",
        },
        {
          q: "Where is the hospital located?",
          a: "Adarsh Nagar, Samastipur, Bihar 848101 (near NH-28 Bypass).",
        },
      ];

  const homeTitle = lang === "hi"
    ? "समस्तीपुर का सबसे भरोसेमंद हॉस्पिटल — लैप्रोस्कोपिक सर्जरी & 24×7 आपातकाल"
    : "Best Hospital in Samastipur · Laparoscopic Surgery · 24×7 Emergency Care";
  const homeDesc = lang === "hi"
    ? "महावीर मल्टी-स्पेशलिटी हॉस्पिटल, समस्तीपुर — उत्तर बिहार का प्रमुख मल्टी-स्पेशलिटी हॉस्पिटल। AIIMS-प्रशिक्षित सर्जन डॉ. अमरदीप के नेतृत्व में लैप्रोस्कोपिक सर्जरी, ऑर्थोपेडिक्स, स्त्री-रोग एवं 24×7 इमरजेंसी सेवा। अभी अपॉइंटमेंट बुक करें।"
    : "Mahaveer Multi-Speciality Hospital in Samastipur — the best multi-speciality hospital in North Bihar. AIIMS-trained surgeon Dr. Amardeep leads laparoscopic surgery, orthopaedics, gynaecology and 24×7 emergency care. Book your appointment online.";

  return (
    <main data-testid="page-home">
      <Seo
        title={homeTitle}
        description={homeDesc}
        canonicalPath="/"
        keywords="best hospital in Samastipur, laparoscopic surgery Samastipur, Dr Amardeep surgeon, 24x7 emergency hospital Bihar, orthopaedic surgeon Samastipur, gynaecologist Samastipur, gallbladder surgery Samastipur, joint replacement Bihar, multi speciality hospital North Bihar, hospital Adarsh Nagar Samastipur, महावीर हॉस्पिटल समस्तीपुर, समस्तीपुर सर्जन"
        structuredData={[
          HOSPITAL_SCHEMA,
          WEBSITE_SCHEMA,
          DR_AMARDEEP_SCHEMA,
          breadcrumbSchema([]),
          faqSchema(homeFaq),
        ]}
      />
      <HeroBlock />
      <EmergencyBanner />
      <IntroBlock />
      <SpecialitiesBlock />
      <DoctorsBlock />
      <WhyBlock />
      <FacilitiesBlock />
      <TestimonialsBlock />
      <InsuranceBlock />
      <CtaStripBlock />
    </main>
  );
}
