import React from "react";
import { Helmet } from "react-helmet-async";
import { useApp } from "@/context/AppContext";

// Canonical origin — used to build absolute URLs for og:image, canonical, structured data etc.
// Falls back to the current window origin at runtime.
export const SITE_ORIGIN =
  process.env.REACT_APP_SITE_ORIGIN ||
  (typeof window !== "undefined" ? window.location.origin : "https://mahaveerhospital.com");

// Default OG image — the hospital doctor card (best-known visual asset).
const DEFAULT_OG_IMAGE = `${SITE_ORIGIN}/images/dr-amardeep-900.webp?v=1`;

/**
 * Route-level SEO component.
 * Supply overrides via props; anything omitted falls back to sensible defaults.
 *
 * Props:
 *   title            – page <title> (will be suffixed with " | Mahaveer Multi-Speciality Hospital")
 *   description      – meta description (max ~155 chars)
 *   canonicalPath    – e.g. "/about"   (root will be resolved via SITE_ORIGIN)
 *   keywords         – comma-separated (optional; Google largely ignores but Bing/DDG use)
 *   ogImage          – override for og:image / twitter:image (absolute URL)
 *   noIndex          – set true on WIP / private routes
 *   structuredData   – array of JSON-LD objects to embed
 */
export default function Seo({
  title,
  description,
  canonicalPath = "/",
  keywords,
  ogImage,
  noIndex = false,
  structuredData = [],
}) {
  const { lang } = useApp();
  const fullTitle = title
    ? `${title} | Mahaveer Multi-Speciality Hospital`
    : "Mahaveer Multi-Speciality Hospital · Samastipur · Best Laparoscopic Surgery & 24×7 Emergency Care";
  const desc =
    description ||
    "Mahaveer Multi-Speciality Hospital, Samastipur — best hospital in North Bihar for laparoscopic surgery, orthopaedics, gynaecology and 24×7 emergency care. AIIMS-trained surgeons led by Dr. Amardeep. Book an appointment online.";
  const canonical = `${SITE_ORIGIN}${canonicalPath === "/" ? "" : canonicalPath}`;
  const img = ogImage || DEFAULT_OG_IMAGE;
  const localeTag = lang === "hi" ? "hi_IN" : "en_IN";
  const altLocale = lang === "hi" ? "en_IN" : "hi_IN";

  return (
    <Helmet>
      {/* Primary */}
      <html lang={lang === "hi" ? "hi" : "en"} />
      <title>{fullTitle}</title>
      <meta name="description" content={desc} />
      {keywords && <meta name="keywords" content={keywords} />}
      <link rel="canonical" href={canonical} />
      {noIndex ? (
        <meta name="robots" content="noindex, nofollow" />
      ) : (
        <meta
          name="robots"
          content="index, follow, max-snippet:-1, max-image-preview:large, max-video-preview:-1"
        />
      )}
      <meta name="googlebot" content="index, follow, max-image-preview:large" />
      <meta name="author" content="Mahaveer Multi-Speciality Hospital" />
      <meta name="publisher" content="Mahaveer Multi-Speciality Hospital" />

      {/* hreflang — declare both language variants of every page */}
      <link rel="alternate" hrefLang="en-IN" href={canonical} />
      <link rel="alternate" hrefLang="hi-IN" href={canonical} />
      <link rel="alternate" hrefLang="x-default" href={canonical} />

      {/* Open Graph */}
      <meta property="og:type" content="website" />
      <meta property="og:site_name" content="Mahaveer Multi-Speciality Hospital" />
      <meta property="og:locale" content={localeTag} />
      <meta property="og:locale:alternate" content={altLocale} />
      <meta property="og:title" content={fullTitle} />
      <meta property="og:description" content={desc} />
      <meta property="og:url" content={canonical} />
      <meta property="og:image" content={img} />
      <meta property="og:image:type" content="image/webp" />
      <meta property="og:image:width" content="900" />
      <meta property="og:image:height" content="1118" />
      <meta property="og:image:alt" content="Dr. Amardeep — Senior Consultant, Mahaveer Multi-Speciality Hospital, Samastipur" />

      {/* Twitter */}
      <meta name="twitter:card" content="summary_large_image" />
      <meta name="twitter:title" content={fullTitle} />
      <meta name="twitter:description" content={desc} />
      <meta name="twitter:image" content={img} />

      {/* Geo — helps local search */}
      <meta name="geo.region" content="IN-BR" />
      <meta name="geo.placename" content="Samastipur, Bihar" />
      <meta name="geo.position" content="25.8542;85.7817" />
      <meta name="ICBM" content="25.8542, 85.7817" />

      {/* Structured data (JSON-LD) */}
      {structuredData.map((obj, i) => (
        <script key={i} type="application/ld+json">
          {JSON.stringify(obj)}
        </script>
      ))}
    </Helmet>
  );
}
