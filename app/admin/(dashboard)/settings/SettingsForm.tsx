"use client";

import { useRef, useState } from "react";
import { updateSettings } from "./actions";

type Settings = {
  headline: string;
  tagline: string;
  heroDescription: string;
  email: string | null;
  githubUrl: string | null;
  linkedinUrl: string | null;
  twitterUrl: string | null;
  telegramUrl: string | null;
  avatarPath: string | null;
  avatarPositionX: number;
  avatarPositionY: number;
};

const inputClass = "mt-1 block w-full rounded-xl border-[#94a3b8] shadow-[inset_0_1px_2px_rgba(0,0,0,.07)] focus:border-[#4f46e5] focus:ring-1 focus:ring-[#4f46e5] text-[14px]";
const labelClass = "block text-[13px] font-semibold text-[#0f172a]";

export default function SettingsForm({ settings, currentAvatarUrl }: { settings: Settings; currentAvatarUrl: string | null }) {
  const [preview, setPreview] = useState<string | null>(currentAvatarUrl);
  const [removeChecked, setRemoveChecked] = useState(false);
  const [posX, setPosX] = useState(settings.avatarPositionX);
  const [posY, setPosY] = useState(settings.avatarPositionY);
  const boxRef = useRef<HTMLDivElement>(null);
  const draggingRef = useRef(false);

  const hasImage = !!preview && !removeChecked;

  function onFileChange(e: React.ChangeEvent<HTMLInputElement>) {
    const file = e.target.files?.[0];
    if (file) {
      setPreview(URL.createObjectURL(file));
      setRemoveChecked(false);
    }
  }

  function updatePositionFromEvent(clientX: number, clientY: number) {
    const box = boxRef.current;
    if (!box) return;
    const rect = box.getBoundingClientRect();
    const x = Math.min(100, Math.max(0, ((clientX - rect.left) / rect.width) * 100));
    const y = Math.min(100, Math.max(0, ((clientY - rect.top) / rect.height) * 100));
    setPosX(Math.round(x));
    setPosY(Math.round(y));
  }

  return (
    <form action={updateSettings} className="space-y-6" encType="multipart/form-data">
      <div className="bg-white border border-[#e2e8f0] rounded-xl p-6">
        <h2 className="text-[14px] font-semibold text-[#0f172a] mb-4">Profile photo</h2>
        <div className="flex items-center gap-6">
          <div className="w-24 h-24 rounded-full overflow-hidden bg-slate-100 shrink-0">
            {hasImage ? (
              // eslint-disable-next-line @next/next/no-img-element
              <img src={preview} alt="Avatar preview" className="w-full h-full object-cover" style={{ objectPosition: `${posX}% ${posY}%` }} />
            ) : (
              <div className="w-full h-full flex items-center justify-center bg-blue-500 text-white text-2xl font-bold">
                {settings.headline.slice(0, 1).toUpperCase()}
              </div>
            )}
          </div>
          <div>
            <label className="inline-flex items-center px-4 py-2 rounded-lg border border-[#94a3b8] text-[13px] font-medium text-[#0f172a] cursor-pointer hover:bg-[#f8fafc]">
              Choose Photo
              <input type="file" name="avatar" accept="image/*" className="hidden" onChange={onFileChange} />
            </label>
            <p className="mt-1 text-[12px] text-[#94a3b8]">PNG or JPG, up to 2MB.</p>
            {currentAvatarUrl && (
              <label className="mt-2 flex items-center gap-2 text-[13px] text-[#64748b]">
                <input type="checkbox" name="removeAvatar" checked={removeChecked} onChange={(e) => setRemoveChecked(e.target.checked)} className="rounded-[2px] border-[#94a3b8]" />
                Remove current photo
              </label>
            )}
          </div>
        </div>

        {hasImage && (
          <div className="mt-5">
            <p className="text-[13px] font-medium text-[#0f172a] mb-2">Photo position</p>
            <div
              ref={boxRef}
              className="relative w-full max-w-sm aspect-[16/10] rounded-lg overflow-hidden cursor-crosshair select-none"
              onMouseDown={(e) => { draggingRef.current = true; updatePositionFromEvent(e.clientX, e.clientY); }}
              onMouseMove={(e) => { if (draggingRef.current) updatePositionFromEvent(e.clientX, e.clientY); }}
              onMouseUp={() => { draggingRef.current = false; }}
              onMouseLeave={() => { draggingRef.current = false; }}
              onTouchStart={(e) => { const t = e.touches[0]; if (!t) return; draggingRef.current = true; updatePositionFromEvent(t.clientX, t.clientY); }}
              onTouchMove={(e) => { const t = e.touches[0]; if (draggingRef.current && t) updatePositionFromEvent(t.clientX, t.clientY); }}
              onTouchEnd={() => { draggingRef.current = false; }}
            >
              {/* eslint-disable-next-line @next/next/no-img-element */}
              <img src={preview!} alt="" className="absolute inset-0 w-full h-full object-cover pointer-events-none" style={{ objectPosition: `${posX}% ${posY}%` }} />
              <div
                className="absolute w-4 h-4 rounded-full bg-white border-2 border-[#4f46e5] shadow -translate-x-1/2 -translate-y-1/2 pointer-events-none"
                style={{ left: `${posX}%`, top: `${posY}%` }}
              />
            </div>
            <input type="hidden" name="avatarPositionX" value={posX} />
            <input type="hidden" name="avatarPositionY" value={posY} />
          </div>
        )}
      </div>

      <div className="bg-white border border-[#e2e8f0] rounded-xl p-6 space-y-5">
        <h2 className="text-[14px] font-semibold text-[#0f172a]">Hero section</h2>
        <div>
          <label htmlFor="headline" className={labelClass}>Headline</label>
          <input type="text" name="headline" id="headline" defaultValue={settings.headline} required maxLength={255} className={inputClass} />
        </div>
        <div>
          <label htmlFor="tagline" className={labelClass}>Tagline</label>
          <input type="text" name="tagline" id="tagline" defaultValue={settings.tagline} required maxLength={255} className={inputClass} />
        </div>
        <div>
          <label htmlFor="heroDescription" className={labelClass}>Description</label>
          <textarea name="heroDescription" id="heroDescription" rows={4} defaultValue={settings.heroDescription} required maxLength={1000} className={inputClass} />
        </div>
      </div>

      <div className="bg-white border border-[#e2e8f0] rounded-xl p-6 space-y-5">
        <h2 className="text-[14px] font-semibold text-[#0f172a]">Contact & social links</h2>
        <div>
          <label htmlFor="email" className={labelClass}>Email</label>
          <input type="email" name="email" id="email" defaultValue={settings.email ?? ""} className={inputClass} />
        </div>
        <div className="grid sm:grid-cols-2 gap-5">
          <div>
            <label htmlFor="githubUrl" className={labelClass}>GitHub URL</label>
            <input type="url" name="githubUrl" id="githubUrl" defaultValue={settings.githubUrl ?? ""} placeholder="https://" className={inputClass} />
          </div>
          <div>
            <label htmlFor="linkedinUrl" className={labelClass}>LinkedIn URL</label>
            <input type="url" name="linkedinUrl" id="linkedinUrl" defaultValue={settings.linkedinUrl ?? ""} placeholder="https://" className={inputClass} />
          </div>
          <div>
            <label htmlFor="twitterUrl" className={labelClass}>Twitter/X URL</label>
            <input type="url" name="twitterUrl" id="twitterUrl" defaultValue={settings.twitterUrl ?? ""} placeholder="https://" className={inputClass} />
          </div>
          <div>
            <label htmlFor="telegramUrl" className={labelClass}>Telegram URL</label>
            <input type="url" name="telegramUrl" id="telegramUrl" defaultValue={settings.telegramUrl ?? ""} placeholder="https://" className={inputClass} />
          </div>
        </div>
      </div>

      <div className="flex justify-end gap-3">
        <a href="/" target="_blank" className="px-4 py-2 text-sm font-medium text-gray-700">Preview site</a>
        <button type="submit" className="px-5 py-2.5 rounded-md bg-[#4f46e5] text-white text-sm font-medium hover:bg-[#4338ca]">Save Changes</button>
      </div>
    </form>
  );
}
