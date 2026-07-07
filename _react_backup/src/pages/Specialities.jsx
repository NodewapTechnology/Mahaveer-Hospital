import React from "react";
import { Link } from "react-router-dom";
import { useApp } from "@/context/AppContext";
import { ASSETS, PHONES } from "@/lib/translations";
import { Section, Reveal, Overline } from "@/components/Section";
import Seo from "@/components/Seo";
import { HOSPITAL_SCHEMA, breadcrumbSchema } from "@/lib/schema";
import { Scissors, Bone, Baby, CheckCircle2, ArrowRight, Phone } from "lucide-react";

const VISUALS = [
  { key: "surgery", icon: Scissors, image: ASSETS.speciality_images.surgery },
  { key: "ortho", icon: Bone, image: ASSETS.speciality_images.ortho },
  { key: "gynae", icon: Baby, image: ASSETS.speciality_images.gynae },
];

export default function Specialities() {
  const { t, lang } = useApp();
  const title = lang === "hi"
    ? "विशेषज्ञताएँ — लैप्रोस्कोपिक सर्जरी, ऑर्थोपेडिक्स, स्त्री-रोग"
    : "Specialities — Laparoscopic Surgery, Orthopaedics, Gynaecology";
  const description = lang === "hi"
    ? "समस्तीपुर में एडवांस्ड लैप्रोस्कोपिक (दूरबीन) सर्जरी, ऑर्थोपेडिक्स एवं जॉइंट रिप्लेसमेंट, स्त्री-रोग एवं प्रसूति सेवाएँ। पित्ताशय, हर्निया, अपेंडिक्स, घुटना बदलाव, सामान्य एवं सिज़ेरियन डिलीवरी।"
    : "Advanced laparoscopic (keyhole) surgery, orthopaedics & joint replacement, and gynaecology & obstetrics in Samastipur. Gallbladder, hernia, appendix, knee replacement, normal & cesarean delivery — performed by AIIMS-trained specialists.";
  return (
    <main data-testid="page-specialities" className="pt-8">
      <Seo
        title={title}
        description={description}
        canonicalPath="/specialities"
        keywords="laparoscopic surgery Samastipur, gallbladder surgery Bihar, hernia surgery, appendix surgery, orthopaedic surgeon Samastipur, joint replacement Bihar, knee replacement, gynaecologist Samastipur, cesarean delivery, normal delivery hospital"
        structuredData={[
          HOSPITAL_SCHEMA,
          breadcrumbSchema([{ name: "Specialities", path: "/specialities" }]),
        ]}
      />
      <Section className="pt-12 pb-16" testId="spec-hero">
        <div className="max-w-4xl space-y-6">
          <Reveal><Overline>{t.specialities_page.overline}</Overline></Reveal>
          <Reveal delay={0.05}>
            <h1 className="font-display text-5xl sm:text-6xl lg:text-7xl tracking-tight leading-[0.97] text-balance text-foreground">
              {t.specialities_page.title}
            </h1>
          </Reveal>
          <Reveal delay={0.15}>
            <p className="text-base sm:text-lg text-muted-foreground leading-relaxed">
              {t.specialities_page.subtitle}
            </p>
          </Reveal>
        </div>
      </Section>

      {t.specialities.list.map((sp, i) => {
        const v = VISUALS[i];
        const Icon = v.icon;
        const reverse = i % 2 === 1;
        return (
          <Section key={sp.key} className={i % 2 === 1 ? "bg-muted/40" : ""} testId={`spec-detail-${sp.key}`}>
            <div className={`grid lg:grid-cols-12 gap-12 lg:gap-16 items-center`}>
              <div className={`lg:col-span-6 ${reverse ? "lg:order-2" : ""}`}>
                <Reveal>
                  <div className="relative aspect-[4/5] rounded-3xl overflow-hidden border border-border">
                    <img
                      src={v.image}
                      alt={sp.name}
                      loading="lazy"
                      decoding="async"
                      width={800}
                      height={1000}
                      className="w-full h-full object-cover"
                    />
                    <div className="absolute top-6 left-6 flex items-center justify-center w-14 h-14 rounded-2xl bg-background/90 backdrop-blur-md text-primary shadow-lg">
                      <Icon className="w-6 h-6" strokeWidth={2} />
                    </div>
                  </div>
                </Reveal>
              </div>
              <div className={`lg:col-span-6 space-y-6 ${reverse ? "lg:order-1" : ""}`}>
                <Reveal delay={0.1}>
                  <div className="text-xs uppercase tracking-[0.3em] font-semibold text-accent">
                    {`0${i + 1}`} · {sp.name.split(" ")[0]}
                  </div>
                </Reveal>
                <Reveal delay={0.15}>
                  <h2 className="font-display text-4xl sm:text-5xl tracking-tight leading-tight text-foreground">
                    {sp.name}
                  </h2>
                </Reveal>
                <Reveal delay={0.2}>
                  <p className="text-base sm:text-lg text-muted-foreground leading-relaxed">{sp.headline}</p>
                </Reveal>
                <Reveal delay={0.25}>
                  <ul className="mt-4 grid grid-cols-1 sm:grid-cols-2 gap-3">
                    {sp.bullets.map((b, j) => (
                      <li key={j} className="flex items-start gap-3 text-sm sm:text-base text-foreground/85">
                        <CheckCircle2 className="w-5 h-5 text-accent mt-0.5 flex-shrink-0" />
                        <span>{b}</span>
                      </li>
                    ))}
                  </ul>
                </Reveal>
                <Reveal delay={0.3}>
                  <div className="flex flex-col sm:flex-row gap-3 pt-4">
                    <Link
                      to="/contact"
                      data-testid={`spec-${sp.key}-book`}
                      className="inline-flex items-center gap-2 rounded-full bg-primary text-primary-foreground px-6 py-3.5 text-sm font-medium hover:-translate-y-1 hover:shadow-xl transition-all"
                    >
                      {t.nav.book} <ArrowRight className="w-3.5 h-3.5" />
                    </Link>
                    <a
                      href={`tel:${PHONES.primary}`}
                      data-testid={`spec-${sp.key}-call`}
                      className="inline-flex items-center gap-2 rounded-full border border-border px-6 py-3.5 text-sm font-medium hover:border-primary hover:text-primary transition-colors"
                    >
                      <Phone className="w-3.5 h-3.5" /> {t.actions.call_now}
                    </a>
                  </div>
                </Reveal>
              </div>
            </div>
          </Section>
        );
      })}
    </main>
  );
}
