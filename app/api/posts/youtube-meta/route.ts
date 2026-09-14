import { NextRequest, NextResponse } from "next/server";
import { cookies } from "next/headers";
import { ADMIN_SESSION_COOKIE, verifySessionValue } from "@/lib/session";
import { fetchYoutubeMeta } from "@/lib/youtube";

export async function GET(request: NextRequest) {
  const store = await cookies();
  const valid = await verifySessionValue(store.get(ADMIN_SESSION_COOKIE)?.value);
  if (!valid) {
    return NextResponse.json({ message: "Unauthorized." }, { status: 401 });
  }

  const url = request.nextUrl.searchParams.get("url");
  if (!url) {
    return NextResponse.json({ message: "URL is required." }, { status: 422 });
  }

  try {
    const meta = await fetchYoutubeMeta(url);
    return NextResponse.json({ title: meta.title, thumbnail_url: meta.thumbnailUrl });
  } catch {
    return NextResponse.json({ message: "Video not found or is private." }, { status: 422 });
  }
}
