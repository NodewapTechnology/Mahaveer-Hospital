import React, { createContext, useContext, useEffect, useMemo, useRef, useState } from "react";
import { translations } from "@/lib/translations";

const AppContext = createContext(null);

const LANG_KEY = "mahaveer:lang";
const THEME_KEY = "mahaveer:theme";
const LANG_CHOSEN_KEY = "mahaveer:lang_chosen";

// Appointment popup — sessionStorage + cross-tab sync via BroadcastChannel.
// Persists across tabs of the same browser session; resets on full browser close.
const APPT_SESSION_KEY = "mahaveer:appt_dismissed";
const APPT_BROADCAST = "mahaveer-appt-popup";

export function AppProvider({ children }) {
  const [lang, setLang] = useState(() => {
    if (typeof window === "undefined") return "en";
    const v = window.localStorage.getItem(LANG_KEY);
    return v === "en" || v === "hi" ? v : "en";
  });
  const [theme, setTheme] = useState(() => {
    if (typeof window === "undefined") return "light";
    const v = window.localStorage.getItem(THEME_KEY);
    return v === "light" || v === "dark" ? v : "light";
  });
  const [hasChosenLang, setHasChosenLang] = useState(() => {
    if (typeof window === "undefined") return false;
    return window.localStorage.getItem(LANG_CHOSEN_KEY) === "true";
  });
  const [showApptPopup, setShowApptPopup] = useState(false);
  const apptChannelRef = useRef(null);

  // Apply theme class to <html>
  useEffect(() => {
    const root = document.documentElement;
    if (theme === "dark") root.classList.add("dark");
    else root.classList.remove("dark");
    localStorage.setItem(THEME_KEY, theme);
  }, [theme]);

  // Persist lang
  useEffect(() => {
    localStorage.setItem(LANG_KEY, lang);
    document.documentElement.lang = lang;
  }, [lang]);

  // Decide whether to show the appointment popup once the user has chosen a language.
  // Logic: if sessionStorage flag set → don't show. Else, broadcast "query" — if any
  // other tab in the same browser session has dismissed it, inherit that. Otherwise
  // wait ~300ms and show. On browser close, sessionStorage clears → fresh popup.
  useEffect(() => {
    if (typeof window === "undefined") return;
    if (!hasChosenLang) return;

    if (sessionStorage.getItem(APPT_SESSION_KEY) === "true") {
      setShowApptPopup(false);
      return;
    }

    let resolved = false;
    let channel = null;
    if ("BroadcastChannel" in window) {
      try {
        channel = new BroadcastChannel(APPT_BROADCAST);
        apptChannelRef.current = channel;
        channel.onmessage = (e) => {
          if (!e || !e.data) return;
          if (e.data.type === "query") {
            const dismissed = sessionStorage.getItem(APPT_SESSION_KEY) === "true";
            channel.postMessage({ type: "state", dismissed });
          } else if (e.data.type === "state" && e.data.dismissed === true) {
            if (!resolved) {
              resolved = true;
              sessionStorage.setItem(APPT_SESSION_KEY, "true");
              setShowApptPopup(false);
            }
          }
        };
        channel.postMessage({ type: "query" });
      } catch (_) {
        channel = null;
      }
    }

    const timer = setTimeout(() => {
      if (!resolved) setShowApptPopup(true);
    }, 350);

    return () => {
      clearTimeout(timer);
      if (channel) {
        try { channel.close(); } catch (_) {}
      }
      apptChannelRef.current = null;
    };
  }, [hasChosenLang]);

  const chooseLanguage = (selected) => {
    setLang(selected);
    setHasChosenLang(true);
    localStorage.setItem(LANG_CHOSEN_KEY, "true");
  };

  const dismissApptPopup = () => {
    if (typeof window !== "undefined") {
      sessionStorage.setItem(APPT_SESSION_KEY, "true");
    }
    setShowApptPopup(false);
    // Tell other tabs of the same browser session
    try {
      const ch = new BroadcastChannel(APPT_BROADCAST);
      ch.postMessage({ type: "state", dismissed: true });
      ch.close();
    } catch (_) {}
  };

  const toggleTheme = () => setTheme((t) => (t === "light" ? "dark" : "light"));
  const toggleLang = () => setLang((l) => (l === "en" ? "hi" : "en"));

  const t = useMemo(() => translations[lang], [lang]);

  const value = useMemo(
    () => ({
      lang,
      setLang,
      theme,
      setTheme,
      toggleTheme,
      toggleLang,
      hasChosenLang,
      chooseLanguage,
      showApptPopup,
      dismissApptPopup,
      t,
    }),
    // eslint-disable-next-line react-hooks/exhaustive-deps
    [lang, theme, hasChosenLang, showApptPopup, t]
  );

  return <AppContext.Provider value={value}>{children}</AppContext.Provider>;
}

export function useApp() {
  const ctx = useContext(AppContext);
  if (!ctx) throw new Error("useApp must be used inside <AppProvider>");
  return ctx;
}
