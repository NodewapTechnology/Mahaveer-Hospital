import React, { useRef, useState } from "react";
import { AnimatePresence, motion } from "framer-motion";
import emailjs from "@emailjs/browser";
import { toast } from "sonner";
import { useApp } from "@/context/AppContext";
import { Input } from "@/components/ui/input";
import { Textarea } from "@/components/ui/textarea";
import {
  Select,
  SelectContent,
  SelectItem,
  SelectTrigger,
  SelectValue,
} from "@/components/ui/select";
import { Popover, PopoverContent, PopoverTrigger } from "@/components/ui/popover";
import { Calendar as CalendarComponent } from "@/components/ui/calendar";
import { format } from "date-fns";
import { hi as hiLocale } from "date-fns/locale";
import { CalendarDays, X, ArrowRight, Sparkles } from "lucide-react";

const SERVICE_ID = process.env.REACT_APP_EMAILJS_SERVICE_ID;
const TEMPLATE_ID = process.env.REACT_APP_EMAILJS_TEMPLATE_ID;
const PUBLIC_KEY = process.env.REACT_APP_EMAILJS_PUBLIC_KEY;
const RECIPIENT = process.env.REACT_APP_RECIPIENT_EMAIL;

function isConfigured() {
  return (
    SERVICE_ID &&
    TEMPLATE_ID &&
    PUBLIC_KEY &&
    !SERVICE_ID.startsWith("YOUR_") &&
    !TEMPLATE_ID.startsWith("YOUR_") &&
    !PUBLIC_KEY.startsWith("YOUR_")
  );
}

export default function AppointmentModal() {
  const { t, lang, showApptPopup, dismissApptPopup } = useApp();
  const formRef = useRef(null);
  const [sending, setSending] = useState(false);
  const [dept, setDept] = useState(t.appt_modal.departments[0]);
  const [date, setDate] = useState(null);
  const [phoneDigits, setPhoneDigits] = useState("");
  const [dateOpen, setDateOpen] = useState(false);

  const handlePhoneChange = (e) => {
    // Strip everything except digits, max 10
    const digitsOnly = (e.target.value || "").replace(/\D/g, "").slice(0, 10);
    setPhoneDigits(digitsOnly);
  };

  const formattedDate = date
    ? format(date, "dd MMM yyyy", { locale: lang === "hi" ? hiLocale : undefined })
    : "";
  const dateInputValue = date ? format(date, "yyyy-MM-dd") : "";

  const onSubmit = async (e) => {
    e.preventDefault();
    if (!formRef.current) return;

    if (!isConfigured()) {
      toast.error(t.appt_modal.config_error);
      return;
    }

    setSending(true);
    try {
      await emailjs.sendForm(SERVICE_ID, TEMPLATE_ID, formRef.current, {
        publicKey: PUBLIC_KEY,
      });
      toast.success(t.appt_modal.success);
      dismissApptPopup();
    } catch (err) {
      console.error("Appointment EmailJS error", err);
      toast.error(t.appt_modal.error);
    } finally {
      setSending(false);
    }
  };

  return (
    <AnimatePresence>
      {showApptPopup && (
        <motion.div
          key="appt-overlay"
          initial={{ opacity: 0 }}
          animate={{ opacity: 1 }}
          exit={{ opacity: 0 }}
          transition={{ duration: 0.25 }}
          className="fixed inset-0 z-[95] flex items-center justify-center p-4 sm:p-6"
          data-testid="appointment-modal-overlay"
        >
          {/* Backdrop */}
          <div
            className="absolute inset-0 bg-foreground/55 backdrop-blur-md"
            onClick={dismissApptPopup}
          />

          <motion.div
            initial={{ opacity: 0, scale: 0.94, y: 16 }}
            animate={{ opacity: 1, scale: 1, y: 0 }}
            exit={{ opacity: 0, scale: 0.96, y: 8 }}
            transition={{ duration: 0.35, ease: [0.16, 1, 0.3, 1] }}
            className="relative w-full max-w-2xl rounded-3xl bg-card border border-border shadow-2xl overflow-hidden max-h-[92vh] flex flex-col"
            data-testid="appointment-modal"
          >
            {/* Decorative gold lines */}
            <div className="absolute top-0 inset-x-0 h-1 bg-accent" />
            <div className="absolute -top-16 -right-16 w-48 h-48 rounded-full bg-accent/20 blur-3xl pointer-events-none" />
            <div className="absolute -bottom-16 -left-16 w-48 h-48 rounded-full bg-primary/15 blur-3xl pointer-events-none" />

            {/* Close button */}
            <button
              type="button"
              data-testid="appointment-modal-close"
              onClick={dismissApptPopup}
              aria-label={t.appt_modal.close}
              className="absolute top-4 right-4 z-10 w-9 h-9 rounded-full bg-background/80 backdrop-blur-md border border-border flex items-center justify-center hover:bg-muted transition-colors"
            >
              <X className="w-4 h-4" />
            </button>

            <div className="relative p-6 sm:p-9 overflow-y-auto">
              <div className="flex items-center gap-2 text-xs uppercase tracking-[0.25em] font-semibold text-accent mb-3">
                <Sparkles className="w-3.5 h-3.5" />
                {t.appt_modal.eyebrow}
              </div>
              <h2 className="font-display text-2xl sm:text-3xl tracking-tight text-foreground leading-tight">
                {t.appt_modal.title}
              </h2>
              <p className="mt-2 text-sm sm:text-base text-muted-foreground leading-relaxed max-w-md">
                {t.appt_modal.subtitle}
              </p>

              <form
                ref={formRef}
                onSubmit={onSubmit}
                className="mt-6 grid grid-cols-1 sm:grid-cols-2 gap-4"
                data-testid="appointment-form"
              >
                <input type="hidden" name="to_email" value={RECIPIENT || ""} />
                <input
                  type="hidden"
                  name="subject"
                  value="Appointment Request — Mahaveer Hospital"
                />
                <input
                  type="hidden"
                  name="user_email"
                  value="appointment-popup@mahaveerhospital.com"
                />

                {/* Name */}
                <div className="sm:col-span-1">
                  <label
                    htmlFor="appt-name"
                    className="block text-[10px] uppercase tracking-[0.2em] text-muted-foreground mb-1.5 font-semibold"
                  >
                    {t.appt_modal.name}
                  </label>
                  <Input
                    id="appt-name"
                    data-testid="appt-input-name"
                    name="user_name"
                    type="text"
                    required
                    placeholder={t.appt_modal.name}
                    className="h-11 rounded-xl"
                  />
                </div>

                {/* Phone with sticky +91 prefix */}
                <div className="sm:col-span-1">
                  <label
                    htmlFor="appt-phone"
                    className="block text-[10px] uppercase tracking-[0.2em] text-muted-foreground mb-1.5 font-semibold"
                  >
                    {t.appt_modal.phone}
                  </label>
                  <div className="flex h-11 rounded-xl border border-input bg-background focus-within:ring-2 focus-within:ring-ring overflow-hidden">
                    <span
                      className="flex items-center justify-center px-3.5 bg-muted/60 border-r border-input text-sm font-semibold text-foreground/80 select-none"
                      aria-hidden="true"
                    >
                      +91
                    </span>
                    <input
                      id="appt-phone"
                      data-testid="appt-input-phone"
                      type="tel"
                      inputMode="numeric"
                      autoComplete="tel-national"
                      required
                      minLength={10}
                      maxLength={10}
                      pattern="[0-9]{10}"
                      value={phoneDigits}
                      onChange={handlePhoneChange}
                      placeholder={t.appt_modal.phone_placeholder}
                      className="flex-1 min-w-0 bg-transparent px-3 text-sm placeholder:text-muted-foreground focus:outline-none"
                      aria-label={t.appt_modal.phone}
                    />
                  </div>
                  {/* Hidden field that includes the full E.164 number for email submission */}
                  <input
                    type="hidden"
                    name="user_phone"
                    value={phoneDigits ? `+91 ${phoneDigits}` : ""}
                  />
                </div>

                {/* Department */}
                <div className="sm:col-span-1">
                  <label className="block text-[10px] uppercase tracking-[0.2em] text-muted-foreground mb-1.5 font-semibold">
                    {t.appt_modal.specialty}
                  </label>
                  <Select value={dept} onValueChange={setDept}>
                    <SelectTrigger
                      className="h-11 rounded-xl"
                      data-testid="appt-input-specialty"
                    >
                      <SelectValue placeholder={t.appt_modal.specialty} />
                    </SelectTrigger>
                    <SelectContent
                      className="z-[110]"
                      position="popper"
                      sideOffset={4}
                    >
                      {t.appt_modal.departments.map((d) => (
                        <SelectItem
                          key={d}
                          value={d}
                          data-testid={`appt-specialty-option-${d.split(" ")[0].toLowerCase()}`}
                        >
                          {d}
                        </SelectItem>
                      ))}
                    </SelectContent>
                  </Select>
                  <input type="hidden" name="specialty" value={dept} />
                </div>

                {/* Date — Popover + Calendar */}
                <div className="sm:col-span-1">
                  <label className="block text-[10px] uppercase tracking-[0.2em] text-muted-foreground mb-1.5 font-semibold">
                    {t.appt_modal.date}
                  </label>
                  <Popover open={dateOpen} onOpenChange={setDateOpen}>
                    <PopoverTrigger asChild>
                      <button
                        type="button"
                        data-testid="appt-input-date"
                        className={`flex h-11 w-full items-center justify-between rounded-xl border border-input bg-background px-3.5 text-sm font-medium transition-colors hover:bg-muted/40 focus:outline-none focus:ring-2 focus:ring-ring ${
                          formattedDate ? "text-foreground" : "text-muted-foreground"
                        }`}
                        aria-haspopup="dialog"
                      >
                        <span>{formattedDate || t.appt_modal.date_placeholder}</span>
                        <CalendarDays className="w-4 h-4 opacity-70" />
                      </button>
                    </PopoverTrigger>
                    <PopoverContent
                      className="z-[110] w-auto p-0"
                      align="start"
                      sideOffset={6}
                      data-testid="appt-date-popover"
                    >
                      <CalendarComponent
                        mode="single"
                        selected={date}
                        onSelect={(d) => {
                          setDate(d || null);
                          if (d) setDateOpen(false);
                        }}
                        disabled={(d) => {
                          const today = new Date();
                          today.setHours(0, 0, 0, 0);
                          return d < today;
                        }}
                        initialFocus
                        locale={lang === "hi" ? hiLocale : undefined}
                      />
                    </PopoverContent>
                  </Popover>
                  {/* Hidden input for EmailJS payload */}
                  <input type="hidden" name="preferred_date" value={dateInputValue} />
                </div>

                {/* Message */}
                <div className="sm:col-span-2">
                  <label
                    htmlFor="appt-msg"
                    className="block text-[10px] uppercase tracking-[0.2em] text-muted-foreground mb-1.5 font-semibold"
                  >
                    {t.appt_modal.message}
                  </label>
                  <Textarea
                    id="appt-msg"
                    data-testid="appt-input-message"
                    name="message"
                    rows={3}
                    placeholder={t.appt_modal.message}
                    className="rounded-xl resize-none"
                  />
                </div>

                <div className="sm:col-span-2 flex flex-col sm:flex-row gap-3 items-stretch sm:items-center justify-between mt-2">
                  <button
                    type="button"
                    data-testid="appt-skip"
                    onClick={dismissApptPopup}
                    className="text-sm text-muted-foreground underline-grow self-start sm:self-auto"
                  >
                    {t.appt_modal.skip}
                  </button>
                  <button
                    type="submit"
                    data-testid="appt-submit"
                    disabled={sending}
                    className="inline-flex items-center justify-center gap-2 rounded-full bg-primary text-primary-foreground px-6 py-3.5 text-sm font-semibold transition-all hover:-translate-y-1 hover:shadow-xl disabled:opacity-60 disabled:cursor-not-allowed disabled:translate-y-0"
                  >
                    {sending ? t.appt_modal.sending : t.appt_modal.submit}
                    <ArrowRight className="w-4 h-4" />
                  </button>
                </div>
              </form>
            </div>
          </motion.div>
        </motion.div>
      )}
    </AnimatePresence>
  );
}
