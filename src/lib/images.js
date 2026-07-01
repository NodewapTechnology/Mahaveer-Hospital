// Image optimisation helpers. Used to keep image weight low on slow networks.

// Append Unsplash CDN params for size + modern format + quality compression.
// Unsplash auto-serves WebP/AVIF when ?auto=format is requested.
export function unsplashSrc(url, width = 1200, quality = 72) {
  if (!url || typeof url !== "string" || !url.includes("unsplash.com")) {
    return url;
  }
  try {
    const u = new URL(url);
    u.searchParams.set("w", String(width));
    u.searchParams.set("q", String(quality));
    u.searchParams.set("auto", "format,compress");
    u.searchParams.set("fit", "crop");
    return u.toString();
  } catch {
    return url;
  }
}

// Build a responsive `srcSet` string for an Unsplash URL at multiple widths.
export function unsplashSrcSet(url, widths = [400, 800, 1200], quality = 72) {
  if (!url || typeof url !== "string" || !url.includes("unsplash.com")) {
    return undefined;
  }
  return widths.map((w) => `${unsplashSrc(url, w, quality)} ${w}w`).join(", ");
}

// Local doctor image — responsive WebP variants (locally generated)
const V = "1"; // bump to invalidate browser cache when image changes
export const DOCTOR_IMAGE = {
  webpSrcSet: `/images/dr-amardeep-360.webp?v=${V} 360w, /images/dr-amardeep-600.webp?v=${V} 600w, /images/dr-amardeep-900.webp?v=${V} 900w`,
  webp360: `/images/dr-amardeep-360.webp?v=${V}`,
  webp600: `/images/dr-amardeep-600.webp?v=${V}`,
  webp900: `/images/dr-amardeep-900.webp?v=${V}`,
  pngFallback: `/images/dr-amardeep-fallback.png?v=${V}`,
  // Intrinsic dimensions (full-size source). Used for `width`/`height` to prevent CLS.
  width: 880,
  height: 1094,
};
