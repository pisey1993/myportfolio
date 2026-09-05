<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h1 class="text-2xl font-semibold tracking-tight text-[#0f172a]">Message from {{ $message->name }}</h1>
            <a href="{{ route('admin.messages.index') }}" class="text-[13px] text-[#64748b] hover:text-[#4f46e5] no-underline hover:underline">&larr; Back to messages</a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white border border-[#e2e8f0] rounded-xl shadow-sm p-6">
                <dl class="grid sm:grid-cols-2 gap-4 mb-6 pb-6 border-b border-[#f1f5f9]">
                    <div>
                        <dt class="text-[11px] font-semibold text-[#94a3b8] uppercase tracking-wide">From</dt>
                        <dd class="mt-1 text-[13px] text-[#0f172a]">{{ $message->name }}</dd>
                    </div>
                    <div>
                        <dt class="text-[11px] font-semibold text-[#94a3b8] uppercase tracking-wide">Email</dt>
                        <dd class="mt-1 text-[13px] text-[#0f172a]">
                            <a href="mailto:{{ $message->email }}" class="text-[#4f46e5] hover:text-[#4338ca]">{{ $message->email }}</a>
                        </dd>
                    </div>
                    @if ($message->subject)
                        <div class="sm:col-span-2">
                            <dt class="text-[11px] font-semibold text-[#94a3b8] uppercase tracking-wide">Subject</dt>
                            <dd class="mt-1 text-[13px] text-[#0f172a]">{{ $message->subject }}</dd>
                        </div>
                    @endif
                    <div>
                        <dt class="text-[11px] font-semibold text-[#94a3b8] uppercase tracking-wide">Received</dt>
                        <dd class="mt-1 text-[13px] text-[#0f172a]">{{ $message->created_at->format('F j, Y g:i A') }}</dd>
                    </div>
                </dl>

                <p class="text-[13px] text-[#0f172a] whitespace-pre-line">{{ $message->message }}</p>

                <div class="mt-8 flex justify-between items-center">
                    <a href="mailto:{{ $message->email }}?subject=Re: {{ $message->subject ?: 'Your message' }}"
                        class="inline-flex items-center px-3 py-1.5 rounded-lg border border-[#4f46e5] bg-[#4f46e5] text-white text-[13px] font-medium shadow-[0_1px_0_rgba(0,0,0,.15)] hover:bg-[#4338ca] hover:border-[#4338ca]">
                        Reply by Email
                    </a>
                    <form action="{{ route('admin.messages.destroy', $message) }}" method="POST" onsubmit="return confirm('Delete this message?');">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="text-[13px] text-[#dc2626] hover:text-[#b91c1c]">Delete</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
