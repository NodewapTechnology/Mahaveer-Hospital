import React, { useEffect } from "react";
import "@/App.css";
import { BrowserRouter, Routes, Route, useLocation } from "react-router-dom";
import { Toaster } from "sonner";
import { HelmetProvider } from "react-helmet-async";

import { AppProvider } from "@/context/AppContext";
import Navbar from "@/components/Navbar";
import Footer from "@/components/Footer";
import LanguageModal from "@/components/LanguageModal";
import AppointmentModal from "@/components/AppointmentModal";

import Home from "@/pages/Home";
import About from "@/pages/About";
import Specialities from "@/pages/Specialities";
import Doctors from "@/pages/Doctors";
import Gallery from "@/pages/Gallery";
import Contact from "@/pages/Contact";

function ScrollToTop() {
  const { pathname } = useLocation();
  useEffect(() => {
    window.scrollTo({ top: 0, left: 0, behavior: "instant" });
  }, [pathname]);
  return null;
}

function AppShell() {
  return (
    <>
      <Navbar />
      <ScrollToTop />
      <Routes>
        <Route path="/" element={<Home />} />
        <Route path="/about" element={<About />} />
        <Route path="/specialities" element={<Specialities />} />
        <Route path="/doctors" element={<Doctors />} />
        <Route path="/gallery" element={<Gallery />} />
        <Route path="/contact" element={<Contact />} />
        <Route path="*" element={<Home />} />
      </Routes>
      <Footer />
      <LanguageModal />
      <AppointmentModal />
      <Toaster
        position="top-right"
        toastOptions={{
          classNames: {
            toast:
              "!bg-card !text-foreground !border !border-border !rounded-2xl !shadow-xl",
            description: "!text-muted-foreground",
          },
        }}
      />
    </>
  );
}

function App() {
  return (
    <HelmetProvider>
      <div className="App min-h-screen bg-background text-foreground">
        <AppProvider>
          <BrowserRouter>
            <AppShell />
          </BrowserRouter>
        </AppProvider>
      </div>
    </HelmetProvider>
  );
}

export default App;
