import { getSiteSettings, avatarUrl } from "@/lib/db/queries";
import PageHeader from "@/components/admin/PageHeader";
import SettingsForm from "./SettingsForm";

export default async function AdminSettingsPage() {
  const settings = await getSiteSettings();

  return (
    <>
      <PageHeader title="Settings" />
      <div className="px-4 sm:px-6 lg:px-8 pb-8 max-w-2xl">
        <SettingsForm settings={settings} currentAvatarUrl={avatarUrl(settings)} />
      </div>
    </>
  );
}
