import React from "react";
import { DOCTOR_IMAGE } from "@/lib/images";

/**
 * Responsive picture element for Dr. Amardeep's photo.
 *
 * • Serves WebP at 360w / 600w / 900w (29 KB → 131 KB depending on viewport).
 * • Falls back to an optimised PNG (~460 KB) for browsers without WebP.
 * • Reserves space via `width` / `height` to avoid layout shift.
 * • Caller controls `loading` / `fetchPriority`:
 *      - Above-the-fold hero: loading="eager"  fetchPriority="high"
 *      - Below-the-fold cards: loading="lazy"  fetchPriority="auto"
 */
export default function DoctorPicture({
  alt,
  className,
  loading = "lazy",
  fetchPriority = "auto",
  sizes = "(max-width: 640px) 90vw, (max-width: 1024px) 45vw, 480px",
  testId,
}) {
  return (
    <picture>
      <source
        type="image/webp"
        srcSet={DOCTOR_IMAGE.webpSrcSet}
        sizes={sizes}
      />
      <img
        src={DOCTOR_IMAGE.pngFallback}
        srcSet={DOCTOR_IMAGE.webpSrcSet}
        sizes={sizes}
        alt={alt}
        width={DOCTOR_IMAGE.width}
        height={DOCTOR_IMAGE.height}
        loading={loading}
        fetchPriority={fetchPriority}
        decoding="async"
        className={className}
        draggable={false}
        data-testid={testId}
      />
    </picture>
  );
}
