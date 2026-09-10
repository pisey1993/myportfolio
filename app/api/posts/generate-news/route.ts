import { NextResponse } from "next/server";
import { auth } from "@/lib/auth";
import { generatePostFromNews } from "@/lib/gemini";

export async function POST() {
  const session = await auth();
  if (!session?.user) {
    return NextResponse.json({ message: "Unauthorized." }, { status: 401 });
  }

  try {
    const data = await generatePostFromNews();
    return NextResponse.json({
      title: data.title,
      excerpt: data.excerpt,
      body: data.body,
      image_url: data.imageUrl,
    });
  } catch (error) {
    return NextResponse.json(
      { message: error instanceof Error ? error.message : "Could not generate a post right now." },
      { status: 502 },
    );
  }
}
