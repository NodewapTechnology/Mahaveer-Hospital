import React from "react";
import { motion } from "framer-motion";
import { cn } from "@/lib/utils";

export function Section({
  id,
  children,
  className,
  containerClassName,
  bleed = false,
  testId,
}) {
  return (
    <section
      id={id}
      data-testid={testId}
      className={cn("relative w-full py-16 sm:py-24 lg:py-32", className)}
    >
      {bleed ? (
        children
      ) : (
        <div className={cn("max-w-7xl mx-auto px-6 sm:px-10 lg:px-12", containerClassName)}>
          {children}
        </div>
      )}
    </section>
  );
}

export function Reveal({ children, delay = 0, className, as = "div", y = 18 }) {
  const MotionTag = motion[as] || motion.div;
  return (
    <MotionTag
      initial={{ opacity: 0, y }}
      whileInView={{ opacity: 1, y: 0 }}
      viewport={{ once: true, margin: "-60px" }}
      transition={{ duration: 0.5, delay, ease: [0.16, 1, 0.3, 1] }}
      className={className}
    >
      {children}
    </MotionTag>
  );
}

export function Overline({ children, className }) {
  return (
    <div
      className={cn(
        "text-xs sm:text-sm uppercase tracking-[0.3em] font-semibold text-accent",
        className
      )}
    >
      <span className="inline-flex items-center gap-3">
        <span className="inline-block h-px w-8 bg-accent/60" />
        {children}
      </span>
    </div>
  );
}
