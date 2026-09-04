<x-site-layout :title="'About — ' . $settings->headline">

    <section class="relative overflow-hidden">
        <div class="absolute inset-0 -z-10">
            <div class="absolute top-0 left-1/2 -translate-x-1/2 w-[50rem] h-[24rem] bg-gradient-to-tr from-pink-600/20 via-fuchsia-600/10 to-orange-500/10 blur-3xl rounded-full"></div>
        </div>

        <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8 pt-16 sm:pt-24 pb-16 grid sm:grid-cols-3 gap-12 items-center">
            <div class="flex justify-center sm:justify-start sm:col-span-1">
                <x-avatar size="md" />
            </div>
            <div class="sm:col-span-2">
                <p class="text-sm font-medium bg-gradient-to-r from-pink-500 to-fuchsia-400 bg-clip-text text-transparent mb-1">About</p>
                <h1 class="text-3xl sm:text-4xl font-extrabold text-white">Hi, I'm {{ $settings->headline }}</h1>
                <div class="mt-5 prose prose-invert max-w-none text-gray-400 space-y-4">
                    <p>
                        I'm a Senior IT Manager with over ten years in the insurance industry, growing from
                        IT Helpdesk Technician into enterprise technology leadership. I led the end-to-end
                        modernization of our Insurance Core System, migrating it from a legacy FileMaker
                        platform to a modern web-based system that now powers our CRM, customer portal, and
                        agent portal.
                    </p>
                    <p>
                        More recently I've been designing AI-powered features for our CRM, including a
                        Google Gemini-based assistant and automated market intelligence reporting. I enjoy
                        bridging business stakeholders and technical teams, and building and mentoring
                        development teams along the way.
                    </p>
                </div>
                <x-social-links class="mt-6 text-gray-500" />
            </div>
        </div>
    </section>

    @if ($skills->isNotEmpty())
    <section class="border-t border-white/10">
        <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8 py-16">
            <p class="text-sm font-medium bg-gradient-to-r from-pink-500 to-fuchsia-400 bg-clip-text text-transparent mb-1">Toolkit</p>
            <h2 class="text-2xl sm:text-3xl font-bold text-white mb-10">Skills</h2>
            <div class="grid sm:grid-cols-2 gap-x-12 gap-y-10">
                @foreach ($skills as $category => $items)
                    <div>
                        <h3 class="text-sm font-semibold text-gray-500 uppercase tracking-wide mb-4">{{ $category }}</h3>
                        <div class="space-y-4">
                            @foreach ($items as $skill)
                                <div>
                                    <div class="flex justify-between text-sm text-gray-300 mb-1.5">
                                        <span class="font-medium">{{ $skill->name }}</span>
                                        <span class="text-gray-500">{{ $skill->level }}%</span>
                                    </div>
                                    <div class="h-2 bg-white/5 rounded-full overflow-hidden border border-white/10">
                                        <div class="h-full rounded-full bg-gradient-to-r from-pink-500 to-fuchsia-400" style="width: {{ $skill->level }}%"></div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </section>
    @endif

</x-site-layout>
