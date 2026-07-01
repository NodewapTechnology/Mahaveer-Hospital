import React, { useState } from "react";
import { AnimatePresence, motion } from "framer-motion";
import { useApp } from "@/context/AppContext";
import { ASSETS } from "@/lib/translations";
import { Section, Reveal, Overline } from "@/components/Section";
import Seo from "@/components/Seo";
import { HOSPITAL_SCHEMA, breadcrumbSchema } from "@/lib/schema";
import { X } from "lucide-react";

export default function Gallery() {
  const { t, lang } = useApp();
  const [activeIndex, setActiveIndex] = useState(null);
  const open = activeIndex !== null;

  // Bento-style spans: large, normal, tall, wide…
  const spans = [
    "md:col-span-2 md:row-span-2",
    "md:col-span-1 md:row-span-1",
    "md:col-span-1 md:row-span-2",
    "md:col-span-1 md:row-span-1",
    "md:col-span-2 md:row-span-1",
    "md:col-span-1 md:row-span-1",
    "md:col-span-1 md:row-span-2",
    "md:col-span-2 md:row-span-1",
  ];

  const title = lang === "hi" ? "गैलरी — हॉस्पिटल इन्फ्रास्ट्रक्चर एवं देखभाल" : "Gallery — Hospital Infrastructure & Care";
  const description = lang === "hi"
    ? "महावीर मल्टी-स्पेशलिटी हॉस्पिटल, समस्तीपुर की तस्वीरें — आधुनिक ऑपरेशन थिएटर, आईसीयू, मरीज़ की देखभाल एवं टीम।"
    : "See Mahaveer Multi-Speciality Hospital, Samastipur — our modern operation theatres, ICU, patient care and dedicated team through images.";

  return (
    <main data-testid="page-gallery" className="pt-8">
      <Seo
        title={title}
        description={description}
        canonicalPath="/gallery"
        keywords="Mahaveer Hospital photos, hospital gallery Samastipur, operation theatre pictures, ICU photos, hospital infrastructure Bihar"
        structuredData={[
          HOSPITAL_SCHEMA,
          breadcrumbSchema([{ name: "Gallery", path: "/gallery" }]),
        ]}
      />
      <Section className="pt-12 pb-12" testId="gallery-hero">
        <div className="max-w-4xl space-y-6">
          <Reveal><Overline>{t.gallery_page.overline}</Overline></Reveal>
          <Reveal delay={0.05}>
            <h1 className="font-display text-5xl sm:text-6xl lg:text-7xl tracking-tight leading-[0.97] text-balance text-foreground">
              {t.gallery_page.title}
            </h1>
          </Reveal>
          <Reveal delay={0.15}>
            <p className="text-base sm:text-lg text-muted-foreground leading-relaxed">
              {t.gallery_page.subtitle}
            </p>
          </Reveal>
        </div>
      </Section>

      <Section testId="gallery-grid">
        <div className="grid grid-cols-1 md:grid-cols-4 md:auto-rows-[220px] gap-4">
          {ASSETS.gallery.map((src, i) => (
            <Reveal key={i} delay={i * 0.04} className={spans[i % spans.length]}>
              <button
                data-testid={`gallery-item-${i}`}
                type="button"
                onClick={() => setActiveIndex(i)}
                className="relative w-full h-full min-h-[220px] rounded-3xl overflow-hidden group border border-border bg-muted"
              >
                <img
                  src={src}
                  alt={`Hospital gallery ${i + 1}`}
                  loading="lazy"
                  decoding="async"
                  width={800}
                  height={600}
                  className="absolute inset-0 w-full h-full object-cover transition-transform duration-700 group-hover:scale-110"
                />
                <div className="absolute inset-0 bg-foreground/0 group-hover:bg-foreground/30 transition-colors" />
                <div className="absolute bottom-4 left-4 right-4 flex items-end opacity-0 group-hover:opacity-100 transition-opacity">
                  <div className="text-background text-xs uppercase tracking-[0.25em]">
                    {`${String(i + 1).padStart(2, "0")} / ${String(ASSETS.gallery.length).padStart(2, "0")}`}
                  </div>
                </div>
              </button>
            </Reveal>
          ))}
        </div>
      </Section>

      <AnimatePresence>
        {open && (
          <motion.div
            initial={{ opacity: 0 }}
            animate={{ opacity: 1 }}
            exit={{ opacity: 0 }}
            transition={{ duration: 0.25 }}
            className="fixed inset-0 z-[90] flex items-center justify-center p-4"
            data-testid="gallery-lightbox"
            onClick={() => setActiveIndex(null)}
          >
            <div className="absolute inset-0 bg-foreground/85 backdrop-blur-md" />
            <motion.img
              initial={{ scale: 0.94, opacity: 0 }}
              animate={{ scale: 1, opacity: 1 }}
              exit={{ scale: 0.95, opacity: 0 }}
              transition={{ duration: 0.4, ease: [0.22, 1, 0.36, 1] }}
              src={ASSETS.gallery[activeIndex]}
              alt=""
              className="relative max-h-[85vh] max-w-[92vw] rounded-2xl object-contain"
              onClick={(e) => e.stopPropagation()}
            />
            <button
              type="button"
              data-testid="gallery-lightbox-close"
              onClick={() => setActiveIndex(null)}
              className="absolute top-6 right-6 w-11 h-11 rounded-full bg-background text-foreground flex items-center justify-center hover:scale-110 transition-transform"
              aria-label="Close gallery"
            >
              <X className="w-5 h-5" />
            </button>
          </motion.div>
        )}
      </AnimatePresence>
    </main>
  );
}
