"use client";

import { useState } from "react";
import { showToast } from "./Toast";

export default function ContactForm({ email }: { email: string | null }) {
  const [name, setName] = useState("");
  const [replyTo, setReplyTo] = useState("");
  const [subject, setSubject] = useState("");
  const [message, setMessage] = useState("");

  if (!email) {
    return (
      <div className="rounded-2xl border border-slate-200 dark:border-white/10 p-6 sm:p-8 text-sm text-slate-600 dark:text-slate-400">
        Reach out using one of the links to the left — this site doesn&apos;t have a contact email configured.
      </div>
    );
  }

  function handleSubmit(e: React.FormEvent<HTMLFormElement>) {
    e.preventDefault();

    const body = `${message}\n\n— ${name} (${replyTo})`;
    const mailto = `mailto:${email}?subject=${encodeURIComponent(subject || `Message from ${name}`)}&body=${encodeURIComponent(body)}`;

    window.location.href = mailto;
    showToast("Opening your email client to send the message...", "info");
  }

  return (
    <form onSubmit={handleSubmit} className="rounded-2xl border border-slate-200 dark:border-white/10 p-6 sm:p-8 space-y-5">
      <div>
        <label htmlFor="name" className="block text-sm font-medium text-slate-700 dark:text-slate-300">Name</label>
        <input
          type="text"
          name="name"
          id="name"
          required
          maxLength={255}
          value={name}
          onChange={(e) => setName(e.target.value)}
          className="mt-1 block w-full rounded-xl border-slate-300 dark:border-white/10 dark:bg-white/5 shadow-sm focus:border-fuchsia-500 focus:ring-fuchsia-500 text-sm"
        />
      </div>
      <div>
        <label htmlFor="email" className="block text-sm font-medium text-slate-700 dark:text-slate-300">Email</label>
        <input
          type="email"
          name="email"
          id="email"
          required
          maxLength={255}
          value={replyTo}
          onChange={(e) => setReplyTo(e.target.value)}
          className="mt-1 block w-full rounded-xl border-slate-300 dark:border-white/10 dark:bg-white/5 shadow-sm focus:border-fuchsia-500 focus:ring-fuchsia-500 text-sm"
        />
      </div>
      <div>
        <label htmlFor="subject" className="block text-sm font-medium text-slate-700 dark:text-slate-300">Subject</label>
        <input
          type="text"
          name="subject"
          id="subject"
          maxLength={255}
          value={subject}
          onChange={(e) => setSubject(e.target.value)}
          className="mt-1 block w-full rounded-xl border-slate-300 dark:border-white/10 dark:bg-white/5 shadow-sm focus:border-fuchsia-500 focus:ring-fuchsia-500 text-sm"
        />
      </div>
      <div>
        <label htmlFor="message" className="block text-sm font-medium text-slate-700 dark:text-slate-300">Message</label>
        <textarea
          name="message"
          id="message"
          rows={5}
          required
          maxLength={5000}
          value={message}
          onChange={(e) => setMessage(e.target.value)}
          className="mt-1 block w-full rounded-xl border-slate-300 dark:border-white/10 dark:bg-white/5 shadow-sm focus:border-fuchsia-500 focus:ring-fuchsia-500 text-sm"
        />
      </div>
      <button
        type="submit"
        className="inline-flex items-center px-6 py-3 rounded-full bg-gradient-to-r from-pink-600 to-fuchsia-500 text-white text-sm font-semibold hover:opacity-90 transition"
      >
        Send Message
      </button>
    </form>
  );
}
