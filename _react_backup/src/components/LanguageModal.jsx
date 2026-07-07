import React, { useState } from "react";
import { AnimatePresence, motion } from "framer-motion";
import { useApp } from "@/context/AppContext";
import { Languages, Check } from "lucide-react";

export default function LanguageModal() {
  const { hasChosenLang, chooseLanguage } = useApp();
  const [selected, setSelected] = useState("en");

  return (
    <AnimatePresence>
      {!hasChosenLang && (
        <motion.div
          initial={{ opacity: 0 }}
          animate={{ opacity: 1 }}
          exit={{ opacity: 0 }}
          transition={{ duration: 0.3 }}
          className="fixed inset-0 z-[100] flex items-center justify-center p-4"
          data-testid="language-modal-overlay"
        >
          {/* Backdrop */}
          <div className="absolute inset-0 bg-foreground/40 backdrop-blur-md" />

          <motion.div
            initial={{ opacity: 0, scale: 0.92, y: 20 }}
            animate={{ opacity: 1, scale: 1, y: 0 }}
            exit={{ opacity: 0, scale: 0.95 }}
            transition={{ duration: 0.45, ease: [0.22, 1, 0.36, 1] }}
            className="relative w-full max-w-md rounded-3xl bg-card border border-border shadow-2xl overflow-hidden"
            data-testid="language-modal"
          >
            <div className="absolute -top-16 -right-16 w-48 h-48 rounded-full bg-accent/20 blur-3xl" />
            <div className="absolute -bottom-16 -left-16 w-48 h-48 rounded-full bg-primary/20 blur-3xl" />

            <div className="relative p-8 sm:p-10">
              <div className="flex items-center justify-center w-14 h-14 rounded-2xl bg-primary text-primary-foreground mb-6">
                <Languages className="w-7 h-7" strokeWidth={1.8} />
              </div>

              <h2 className="font-display text-2xl sm:text-3xl tracking-tight mb-1 text-foreground">
                Choose your language
              </h2>
              <p className="font-display text-2xl sm:text-3xl tracking-tight text-muted-foreground mb-8">
                अपनी भाषा चुनें
              </p>

              <div className="grid grid-cols-1 gap-3">
                <button
                  data-testid="lang-option-en"
                  type="button"
                  onClick={() => setSelected("en")}
                  className={`group flex items-center justify-between w-full rounded-2xl border-2 transition-all px-5 py-4 text-left ${
                    selected === "en"
                      ? "border-primary bg-primary/5"
                      : "border-border hover:border-primary/40"
                  }`}
                >
                  <div>
                    <div className="font-display text-lg text-foreground">English</div>
                    <div className="text-sm text-muted-foreground">Continue in English</div>
                  </div>
                  <span
                    className={`flex items-center justify-center w-6 h-6 rounded-full transition-colors ${
                      selected === "en" ? "bg-primary text-primary-foreground" : "bg-muted"
                    }`}
                  >
                    {selected === "en" && <Check className="w-3.5 h-3.5" strokeWidth={3} />}
                  </span>
                </button>

                <button
                  data-testid="lang-option-hi"
                  type="button"
                  onClick={() => setSelected("hi")}
                  className={`group flex items-center justify-between w-full rounded-2xl border-2 transition-all px-5 py-4 text-left ${
                    selected === "hi"
                      ? "border-primary bg-primary/5"
                      : "border-border hover:border-primary/40"
                  }`}
                >
                  <div>
                    <div className="font-display text-lg text-foreground">हिन्दी (Hindi)</div>
                    <div className="text-sm text-muted-foreground">हिन्दी में जारी रखें</div>
                  </div>
                  <span
                    className={`flex items-center justify-center w-6 h-6 rounded-full transition-colors ${
                      selected === "hi" ? "bg-primary text-primary-foreground" : "bg-muted"
                    }`}
                  >
                    {selected === "hi" && <Check className="w-3.5 h-3.5" strokeWidth={3} />}
                  </span>
                </button>
              </div>

              <button
                data-testid="lang-continue-btn"
                type="button"
                onClick={() => chooseLanguage(selected)}
                className="mt-8 w-full rounded-full bg-primary text-primary-foreground font-medium py-3.5 px-6 transition-all hover:bg-primary/90 hover:-translate-y-0.5 hover:shadow-lg"
              >
                Continue / जारी रखें
              </button>

              <p className="mt-4 text-center text-xs text-muted-foreground">
                You can change this anytime from the menu.
              </p>
            </div>
          </motion.div>
        </motion.div>
      )}
    </AnimatePresence>
  );
}
