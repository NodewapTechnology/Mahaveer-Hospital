import React from "react";
import { cn } from "@/lib/utils";

/**
 * Premium "M" monogram for Mahaveer Multi-Speciality Hospital.
 * - Container: deep green rounded-square with subtle inner ring
 * - Glyph: bold cream "M" with a tiny gold medical cross at the apex
 * - Top-right gold dot acts as the floating medical accent
 *
 * Reusable across navbar + footer. Size via className (default w-11 h-11).
 */
export default function Logo({ className, animated = true, withRing = true }) {
  return (
    <div
      className={cn(
        "relative flex items-center justify-center rounded-2xl bg-primary text-primary-foreground shrink-0",
        animated && "group-hover:rotate-[-6deg] transition-transform duration-300",
        className || "w-11 h-11"
      )}
    >
      {withRing && (
        <span
          aria-hidden
          className="absolute inset-[3px] rounded-[12px] border border-accent/35 pointer-events-none"
        />
      )}

      <svg
        viewBox="0 0 28 28"
        className="w-[58%] h-[58%]"
        fill="none"
        aria-hidden
      >
        {/* Bold M letterform */}
        <path
          d="M 5 22 V 6 L 14 16 L 23 6 V 22"
          stroke="currentColor"
          strokeWidth="2.6"
          strokeLinecap="round"
          strokeLinejoin="round"
        />
        {/* tiny gold medical + at the centre apex of M */}
        <g stroke="hsl(38 36% 56%)" strokeWidth="1.6" strokeLinecap="round">
          <line x1="14" y1="0.5" x2="14" y2="3.5" />
          <line x1="12.5" y1="2" x2="15.5" y2="2" />
        </g>
      </svg>

      {/* floating gold accent dot — heartbeat */}
      <span
        aria-hidden
        className="absolute -top-1 -right-1 w-3 h-3 rounded-full bg-accent border-2 border-background"
      />
    </div>
  );
}
