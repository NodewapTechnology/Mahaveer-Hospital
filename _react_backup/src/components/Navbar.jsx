import React, { useEffect, useState } from "react";
import { Link, NavLink, useLocation } from "react-router-dom";
import { motion, AnimatePresence } from "framer-motion";
import { Menu, X, Sun, Moon, Phone } from "lucide-react";
import { useApp } from "@/context/AppContext";
import { PHONES } from "@/lib/translations";
import Logo from "@/components/Logo";

export default function Navbar() {
  const { t, lang, toggleLang, theme, toggleTheme } = useApp();
  const [open, setOpen] = useState(false);
  const [scrolled, setScrolled] = useState(false);
  const { pathname } = useLocation();

  useEffect(() => {
    const onScroll = () => setScrolled(window.scrollY > 30);
    window.addEventListener("scroll", onScroll, { passive: true });
    onScroll();
    return () => window.removeEventListener("scroll", onScroll);
  }, []);

  useEffect(() => {
    setOpen(false);
  }, [pathname]);

  // Also auto-close the mobile drawer whenever language is switched.
  useEffect(() => {
    setOpen(false);
  }, [lang]);

  const links = [
    { to: "/", label: t.nav.home, testId: "nav-home" },
    { to: "/about", label: t.nav.about, testId: "nav-about" },
    { to: "/specialities", label: t.nav.specialities, testId: "nav-specialities" },
    { to: "/doctors", label: t.nav.doctors, testId: "nav-doctors" },
    { to: "/gallery", label: t.nav.gallery, testId: "nav-gallery" },
    { to: "/contact", label: t.nav.contact, testId: "nav-contact" },
  ];

  return (
    <>
      <header
        data-testid="site-navbar"
        className={`fixed top-0 inset-x-0 z-50 transition-all duration-500 glass-strong ${
          scrolled ? "border-b border-border/60 py-3" : "py-5"
        }`}
      >
        <div className="max-w-7xl mx-auto px-6 sm:px-10 lg:px-12 flex items-center justify-between gap-4">
          <Link to="/" className="flex items-center gap-2.5 sm:gap-3 group min-w-0" data-testid="brand-logo">
            <Logo className="w-10 h-10 sm:w-11 sm:h-11" />
            <div className="leading-tight min-w-0">
              <div className="font-display text-sm sm:text-base lg:text-lg tracking-tight text-foreground whitespace-nowrap">
                {lang === "hi" ? "महावीर हॉस्पिटल" : "Mahaveer Hospital"}
              </div>
              <div className="text-[9px] sm:text-[10px] uppercase tracking-[0.22em] sm:tracking-[0.25em] text-muted-foreground whitespace-nowrap">
                {lang === "hi" ? "मल्टी-स्पेशलिटी" : "Multi-Speciality"}
              </div>
            </div>
          </Link>

          {/* Desktop nav */}
          <nav className="hidden lg:flex items-center gap-1">
            {links.map((l) => (
              <NavLink
                key={l.to}
                to={l.to}
                data-testid={l.testId}
                className={({ isActive }) =>
                  `relative px-3 py-2 text-sm font-medium transition-colors ${
                    isActive
                      ? "text-foreground"
                      : "text-muted-foreground hover:text-foreground"
                  }`
                }
              >
                {({ isActive }) => (
                  <span className="relative inline-block">
                    {l.label}
                    {isActive && (
                      <motion.span
                        layoutId="nav-underline"
                        className="absolute -bottom-1 left-0 right-0 h-[2px] bg-accent rounded-full"
                      />
                    )}
                  </span>
                )}
              </NavLink>
            ))}
          </nav>

          <div className="flex items-center gap-2">
            <button
              data-testid="toggle-lang-btn"
              type="button"
              onClick={toggleLang}
              className="hidden sm:inline-flex items-center justify-center px-3 py-2 rounded-full text-xs font-semibold uppercase tracking-wider border border-border hover:border-primary hover:text-primary transition-colors"
              aria-label="Switch language"
            >
              {t.actions.switch_lang}
            </button>

            <button
              data-testid="toggle-theme-btn"
              type="button"
              onClick={toggleTheme}
              className="inline-flex items-center justify-center w-10 h-10 rounded-full border border-border hover:border-primary hover:text-primary transition-colors"
              aria-label="Toggle theme"
            >
              {theme === "light" ? (
                <Moon className="w-4 h-4" strokeWidth={2} />
              ) : (
                <Sun className="w-4 h-4" strokeWidth={2} />
              )}
            </button>

            <a
              data-testid="navbar-emergency-call"
              href={`tel:${PHONES.primary}`}
              className="hidden md:inline-flex items-center gap-2 rounded-full bg-destructive text-destructive-foreground px-4 py-2.5 text-sm font-medium pulse-ring transition-transform hover:-translate-y-0.5"
            >
              <Phone className="w-3.5 h-3.5" strokeWidth={2.5} />
              <span>{t.nav.emergency}</span>
            </a>

            <button
              data-testid="mobile-menu-toggle"
              type="button"
              onClick={() => setOpen((o) => !o)}
              className="lg:hidden inline-flex items-center justify-center w-10 h-10 rounded-full border border-border"
              aria-label="Menu"
            >
              {open ? <X className="w-5 h-5" /> : <Menu className="w-5 h-5" />}
            </button>
          </div>
        </div>
      </header>

      {/* Mobile drawer */}
      <AnimatePresence>
        {open && (
          <motion.div
            initial={{ opacity: 0 }}
            animate={{ opacity: 1 }}
            exit={{ opacity: 0 }}
            transition={{ duration: 0.3 }}
            className="fixed inset-0 z-40 lg:hidden"
            data-testid="mobile-menu"
          >
            <div
              className="absolute inset-0 bg-foreground/40 backdrop-blur-md"
              onClick={() => setOpen(false)}
            />
            <motion.div
              initial={{ x: "100%" }}
              animate={{ x: 0 }}
              exit={{ x: "100%" }}
              transition={{ duration: 0.45, ease: [0.22, 1, 0.36, 1] }}
              className="absolute right-0 top-0 bottom-0 w-[88%] max-w-sm bg-card border-l border-border p-8 flex flex-col gap-6 overflow-y-auto"
            >
              <div className="flex items-center justify-between mt-12">
                <div className="font-display text-xl text-foreground">
                  {lang === "hi" ? "मेनू" : "Menu"}
                </div>
                <button
                  type="button"
                  onClick={() => setOpen(false)}
                  className="w-9 h-9 rounded-full border border-border flex items-center justify-center"
                  data-testid="mobile-menu-close"
                  aria-label="Close menu"
                >
                  <X className="w-4 h-4" />
                </button>
              </div>

              <nav className="flex flex-col gap-1">
                {links.map((l) => (
                  <NavLink
                    key={l.to}
                    to={l.to}
                    data-testid={`mobile-${l.testId}`}
                    className={({ isActive }) =>
                      `text-2xl font-display py-3 border-b border-border/40 ${
                        isActive ? "text-accent" : "text-foreground"
                      }`
                    }
                  >
                    {l.label}
                  </NavLink>
                ))}
              </nav>

              <div className="flex flex-col gap-3 mt-2">
                <button
                  type="button"
                  onClick={toggleLang}
                  data-testid="mobile-toggle-lang"
                  className="w-full rounded-full border border-border py-3 text-sm font-semibold uppercase tracking-wider"
                >
                  {t.actions.switch_lang}
                </button>
                <a
                  href={`tel:${PHONES.primary}`}
                  data-testid="mobile-emergency-call"
                  className="w-full inline-flex items-center justify-center gap-2 rounded-full bg-destructive text-destructive-foreground py-3 text-sm font-medium"
                >
                  <Phone className="w-4 h-4" /> {t.nav.emergency}
                </a>
              </div>
            </motion.div>
          </motion.div>
        )}
      </AnimatePresence>

      {/* spacer to offset fixed nav on pages without hero */}
      <div aria-hidden className="h-20" />
    </>
  );
}
