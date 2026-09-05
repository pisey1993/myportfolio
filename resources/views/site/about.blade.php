<x-site-layout :title="'About — ' . $settings->headline">

    <section class="relative overflow-hidden">
        <div class="absolute inset-0 -z-10">
            <div class="absolute top-0 left-1/2 -translate-x-1/2 w-[50rem] h-[24rem] bg-gradient-to-tr from-pink-600/20 via-fuchsia-600/10 to-orange-500/10 blur-3xl rounded-full"></div>
        </div>

        <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8 pt-16 sm:pt-24 pb-16 grid sm:grid-cols-3 gap-12 items-start">
            <div class="flex justify-center sm:justify-start sm:col-span-1">
                <x-avatar size="md" />
            </div>
            <div class="sm:col-span-2">
                <p class="text-sm font-medium bg-gradient-to-r from-pink-500 to-fuchsia-400 bg-clip-text text-transparent mb-1">About</p>
                <h1 class="text-3xl sm:text-4xl font-extrabold text-slate-900 dark:text-white">Hi, I'm {{ $settings->headline }}</h1>
                <div class="mt-5 prose dark:prose-invert max-w-none text-slate-600 dark:text-slate-400 space-y-4">
                    <p>
                        I'm a Senior IT Manager with over ten years in the insurance industry, growing from
                        IT Helpdesk Technician into enterprise technology leadership. I originally designed
                        and built our Insurance Core System in FileMaker, and years later led its end-to-end
                        migration to a modern web-based platform that now powers our CRM, customer portal,
                        and agent portal.
                    </p>
                    <p>
                        More recently I've been designing AI-powered features for our CRM, including a
                        Google Gemini-based assistant and automated market intelligence reporting. I enjoy
                        bridging business stakeholders and technical teams, and building and mentoring
                        development teams along the way.
                    </p>
                    <p>
                        My background is in business analysis, not formal software engineering — so I lean on
                        AI coding tools like Claude Code to turn business problems into working solutions,
                        moving from a user's request straight to shipped code. That same analyst mindset is
                        how I approach IT operations: after auditing how support requests actually came in, I
                        designed our IT Service Level Agreement (SLA) framework, then designed and built the IT
                        Support Request System so every request is routed and assigned to the right person on
                        the team — closing the gaps that used to leave tasks pending.
                    </p>
                </div>

                <div class="mt-8">
                    <p class="text-sm font-medium bg-gradient-to-r from-pink-500 to-fuchsia-400 bg-clip-text text-transparent mb-3">Current Responsibilities</p>
                    <ul class="space-y-2.5">
                        @foreach ([
                            'Leading enterprise IT strategy and the internal technology team for the company',
                            'Owning the Insurance Core System, CRM, customer portal, and agent portal — architecture, uptime, and roadmap',
                            'Designing and shipping AI-powered features, including a Google Gemini-based assistant and automated market intelligence reporting',
                            'Translating business problems into coding solutions — using AI coding tools like Claude Code to go from user request to working feature',
                            'Designed the company\'s IT Service Level Agreement (SLA) framework, based on an audit of how support requests were actually being received and handled',
                            'Designed and built the IT Support Request System — routing and assigning every incoming request to the right team member so nothing is left pending',
                            'Bridging business stakeholders and technical teams to translate operational needs into working software',
                            'Building, mentoring, and growing the development team',
                        ] as $item)
                            <li class="flex items-start gap-2.5 text-slate-600 dark:text-slate-400">
                                <svg class="w-5 h-5 mt-0.5 text-fuchsia-600 dark:text-fuchsia-400 shrink-0" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="20 6 9 17 4 12"/></svg>
                                <span>{{ $item }}</span>
                            </li>
                        @endforeach
                    </ul>
                </div>

                <x-social-links class="mt-6" />
            </div>
        </div>
    </section>

    @if ($experiences->isNotEmpty())
    <section class="border-t border-slate-200 dark:border-white/10">
        <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8 py-16">
            <div class="anim-stagger">
                <p class="text-sm font-medium bg-gradient-to-r from-pink-500 to-fuchsia-400 bg-clip-text text-transparent mb-1">Career</p>
                <h2 class="text-2xl sm:text-3xl font-bold text-slate-900 dark:text-white mb-10">Experience</h2>
            </div>

            <div class="relative">
                <div class="absolute left-[7px] top-2 bottom-2 w-px bg-slate-200 dark:bg-white/10"></div>
                <div class="anim-stagger space-y-10">
                    @foreach ($experiences as $experience)
                        <div class="relative pl-8">
                            <span class="absolute left-0 top-1.5 w-[15px] h-[15px] rounded-full border-2 {{ $experience->isCurrent() ? 'border-fuchsia-500 bg-fuchsia-500' : 'border-slate-300 dark:border-slate-700 bg-white dark:bg-slate-950' }}"></span>

                            <div class="flex flex-wrap items-baseline justify-between gap-x-4 gap-y-1">
                                <h3 class="font-semibold text-slate-900 dark:text-white">{{ $experience->title }}</h3>
                                <span class="text-xs font-medium text-slate-500 shrink-0">
                                    {{ $experience->start_label }} &ndash; {{ $experience->end_label ?: 'Present' }}
                                </span>
                            </div>
                            <p class="text-sm font-medium bg-gradient-to-r from-pink-500 to-fuchsia-400 bg-clip-text text-transparent mt-0.5">{{ $experience->company }}</p>

                            @if ($experience->highlightList())
                                <ul class="mt-3 space-y-1.5">
                                    @foreach ($experience->highlightList() as $highlight)
                                        <li class="flex items-start gap-2 text-sm text-slate-600 dark:text-slate-400">
                                            <span class="mt-2 w-1 h-1 rounded-full bg-slate-400 dark:bg-slate-600 shrink-0"></span>
                                            <span>{{ $highlight }}</span>
                                        </li>
                                    @endforeach
                                </ul>
                            @endif
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </section>
    @endif

    @if ($skills->isNotEmpty())
    <section class="border-t border-slate-200 dark:border-white/10">
        <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8 py-16">
            <div class="anim-stagger">
                <p class="text-sm font-medium bg-gradient-to-r from-pink-500 to-fuchsia-400 bg-clip-text text-transparent mb-1">Toolkit</p>
                <h2 class="text-2xl sm:text-3xl font-bold text-slate-900 dark:text-white mb-10">Skills</h2>
            </div>
            <div class="anim-stagger grid sm:grid-cols-2 gap-x-12 gap-y-10">
                @foreach ($skills as $category => $items)
                    <div>
                        <h3 class="text-sm font-semibold text-slate-500 uppercase tracking-wide mb-4">{{ $category }}</h3>
                        <div class="space-y-4">
                            @foreach ($items as $skill)
                                <div>
                                    <div class="flex justify-between text-sm text-slate-700 dark:text-slate-300 mb-1.5">
                                        <span class="font-medium">{{ $skill->name }}</span>
                                        <span class="text-slate-500">{{ $skill->level }}%</span>
                                    </div>
                                    <div class="h-2 bg-slate-100 dark:bg-white/5 rounded-full overflow-hidden border border-slate-200 dark:border-white/10">
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
