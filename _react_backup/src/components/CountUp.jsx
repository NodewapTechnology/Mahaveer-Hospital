import React, { useEffect, useRef, useState } from "react";
import { useInView } from "framer-motion";

export default function CountUp({ to = 0, suffix = "", duration = 1.6 }) {
  const ref = useRef(null);
  const inView = useInView(ref, { once: true, margin: "-50px" });
  const [val, setVal] = useState(0);

  useEffect(() => {
    if (!inView) return;
    const start = performance.now();
    let raf = 0;
    const tick = (now) => {
      const elapsed = (now - start) / 1000;
      const progress = Math.min(elapsed / duration, 1);
      // ease-out cubic
      const eased = 1 - Math.pow(1 - progress, 3);
      setVal(Math.round(to * eased));
      if (progress < 1) raf = requestAnimationFrame(tick);
    };
    raf = requestAnimationFrame(tick);
    return () => cancelAnimationFrame(raf);
  }, [inView, to, duration]);

  const formatted = val.toLocaleString("en-IN");
  return (
    <span
      ref={ref}
      className="font-display text-[clamp(1.75rem,7vw,3rem)] sm:text-4xl lg:text-5xl xl:text-[3.25rem] tracking-tight leading-none text-foreground inline-block whitespace-nowrap"
    >
      {formatted}
      <span className="text-accent">{suffix}</span>
    </span>
  );
}
