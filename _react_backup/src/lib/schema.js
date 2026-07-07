// Schema.org / JSON-LD structured data for Mahaveer Multi-Speciality Hospital.
// Reference: https://developers.google.com/search/docs/appearance/structured-data
// Approximate coordinates for Adarsh Nagar, Samastipur, Bihar.
const LAT = 25.8542;
const LON = 85.7817;

const SITE_ORIGIN =
  process.env.REACT_APP_SITE_ORIGIN ||
  (typeof window !== "undefined" ? window.location.origin : "https://mahaveerhospital.com");

const ADDRESS = {
  "@type": "PostalAddress",
  streetAddress: "Adarsh Nagar, Near NH-28 Bypass",
  addressLocality: "Samastipur",
  addressRegion: "Bihar",
  postalCode: "848101",
  addressCountry: "IN",
};

const PHONES = ["+91-6287797276", "+91-6287797277"];

/**
 * Root Hospital / MedicalOrganization / LocalBusiness schema.
 * Included on every page so search engines learn the organisation once.
 */
export const HOSPITAL_SCHEMA = {
  "@context": "https://schema.org",
  "@type": ["Hospital", "MedicalOrganization", "LocalBusiness"],
  "@id": `${SITE_ORIGIN}/#hospital`,
  name: "Mahaveer Multi-Speciality Hospital",
  alternateName: ["Mahaveer Hospital Samastipur", "महावीर मल्टी-स्पेशलिटी हॉस्पिटल"],
  description:
    "Multi-speciality hospital in Samastipur, Bihar offering advanced laparoscopic surgery, orthopaedics & joint replacement, gynaecology and 24×7 emergency care. AIIMS-trained surgeons led by Dr. Amardeep.",
  url: SITE_ORIGIN,
  logo: `${SITE_ORIGIN}/images/dr-amardeep-360.webp?v=1`,
  image: [
    `${SITE_ORIGIN}/images/dr-amardeep-900.webp?v=1`,
    `${SITE_ORIGIN}/images/dr-amardeep-600.webp?v=1`,
  ],
  telephone: PHONES,
  email: "info@mahaveerhospital.com",
  address: ADDRESS,
  geo: {
    "@type": "GeoCoordinates",
    latitude: LAT,
    longitude: LON,
  },
  openingHoursSpecification: [
    {
      "@type": "OpeningHoursSpecification",
      dayOfWeek: [
        "Monday",
        "Tuesday",
        "Wednesday",
        "Thursday",
        "Friday",
        "Saturday",
        "Sunday",
      ],
      opens: "00:00",
      closes: "23:59",
      description: "24×7 Emergency Services",
    },
    {
      "@type": "OpeningHoursSpecification",
      dayOfWeek: [
        "Monday",
        "Tuesday",
        "Wednesday",
        "Thursday",
        "Friday",
        "Saturday",
      ],
      opens: "09:00",
      closes: "20:00",
      description: "OPD & Consultations",
    },
  ],
  areaServed: [
    { "@type": "City", name: "Samastipur" },
    { "@type": "State", name: "Bihar" },
    { "@type": "AdministrativeArea", name: "North Bihar" },
  ],
  medicalSpecialty: [
    "GeneralSurgery",
    "LaparoscopicSurgery",
    "OrthopedicSurgery",
    "ObstetricsAndGynecology",
    "Emergency",
  ],
  availableService: [
    {
      "@type": "MedicalProcedure",
      name: "Laparoscopic Gallbladder Surgery",
      procedureType: "https://schema.org/SurgicalProcedure",
    },
    {
      "@type": "MedicalProcedure",
      name: "Hernia Repair",
      procedureType: "https://schema.org/SurgicalProcedure",
    },
    {
      "@type": "MedicalProcedure",
      name: "Appendix Surgery",
      procedureType: "https://schema.org/SurgicalProcedure",
    },
    {
      "@type": "MedicalProcedure",
      name: "Joint Replacement",
      procedureType: "https://schema.org/SurgicalProcedure",
    },
    {
      "@type": "MedicalProcedure",
      name: "Cesarean & Normal Delivery",
      procedureType: "https://schema.org/SurgicalProcedure",
    },
  ],
  currenciesAccepted: "INR",
  paymentAccepted: "Cash, Credit Card, Debit Card, UPI, Bank Transfer, Insurance",
  priceRange: "₹₹",
  aggregateRating: {
    "@type": "AggregateRating",
    ratingValue: "4.9",
    reviewCount: "1128",
    bestRating: "5",
    worstRating: "1",
  },
  sameAs: [
    "https://www.google.com/maps/search/?api=1&query=Mahaveer+Multi+Speciality+Hospital+Adarsh+Nagar+Samastipur",
  ],
};

/**
 * Featured Physician (Dr. Amardeep) — appears on Home + Doctors pages.
 */
export const DR_AMARDEEP_SCHEMA = {
  "@context": "https://schema.org",
  "@type": "Physician",
  "@id": `${SITE_ORIGIN}/#dr-amardeep`,
  name: "Dr. Amardeep",
  honorificPrefix: "Dr.",
  alternateName: "डॉ. अमरदीप",
  jobTitle: "Senior Consultant · Head of Surgery",
  medicalSpecialty: ["GeneralSurgery", "LaparoscopicSurgery"],
  hasCredential: [
    { "@type": "EducationalOccupationalCredential", credentialCategory: "degree", name: "MBBS" },
    { "@type": "EducationalOccupationalCredential", credentialCategory: "degree", name: "MS (General Surgery)" },
    { "@type": "EducationalOccupationalCredential", credentialCategory: "certification", name: "FMAS (Fellowship in Minimal Access Surgery)" },
  ],
  worksFor: { "@id": `${SITE_ORIGIN}/#hospital` },
  affiliation: { "@id": `${SITE_ORIGIN}/#hospital` },
  image: `${SITE_ORIGIN}/images/dr-amardeep-900.webp?v=1`,
  telephone: PHONES[0],
  address: ADDRESS,
  areaServed: [
    { "@type": "City", name: "Samastipur" },
    { "@type": "AdministrativeArea", name: "North Bihar" },
  ],
};

/**
 * Website schema — enables Google's sitelinks searchbox and canonical name.
 */
export const WEBSITE_SCHEMA = {
  "@context": "https://schema.org",
  "@type": "WebSite",
  "@id": `${SITE_ORIGIN}/#website`,
  url: SITE_ORIGIN,
  name: "Mahaveer Multi-Speciality Hospital",
  publisher: { "@id": `${SITE_ORIGIN}/#hospital` },
  inLanguage: ["en-IN", "hi-IN"],
};

/**
 * BreadcrumbList — pass the current page's crumbs; the Home item is always position 1.
 * Usage:  breadcrumbSchema([{name: "About", path: "/about"}])
 */
export function breadcrumbSchema(crumbs = []) {
  return {
    "@context": "https://schema.org",
    "@type": "BreadcrumbList",
    itemListElement: [
      {
        "@type": "ListItem",
        position: 1,
        name: "Home",
        item: `${SITE_ORIGIN}/`,
      },
      ...crumbs.map((c, i) => ({
        "@type": "ListItem",
        position: i + 2,
        name: c.name,
        item: `${SITE_ORIGIN}${c.path}`,
      })),
    ],
  };
}

/**
 * FAQPage schema — pass an array of `{q, a}` and render on the Home/About page.
 */
export function faqSchema(items = []) {
  return {
    "@context": "https://schema.org",
    "@type": "FAQPage",
    mainEntity: items.map(({ q, a }) => ({
      "@type": "Question",
      name: q,
      acceptedAnswer: { "@type": "Answer", text: a },
    })),
  };
}
