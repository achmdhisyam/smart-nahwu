@extends('layouts.app')

@section('title', 'Log Analisis - Admin Smart Nahwu')

@section('content')
<div class="max-w-5xl mx-auto space-y-6">
    <!-- Header -->
    <div class="flex items-center space-x-2">
        <a href="{{ route('admin.dashboard') }}" class="text-sm text-[#1b4332] hover:text-[#b45309] font-bold">← Dashboard</a>
    </div>

    <div>
        <h1 class="text-3xl font-extrabold text-[#1b4332]">Log Riwayat Analisis</h1>
        <p class="text-sm text-[#5c6f60]">Pemantauan aktivitas analisis kalimat Arab oleh pengguna secara real-time.</p>
    </div>

    <!-- Table Card -->
    <div class="glass bg-white rounded-3xl overflow-hidden shadow-sm border border-[#e6dec9]">
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-[#fcfbfa] border-b border-[#e6dec9] text-[#4a5d4e] text-xs uppercase tracking-wider font-bold">
                        <th class="px-6 py-4">Pengguna</th>
                        <th class="px-6 py-4">Kalimat Arab</th>
                        <th class="px-6 py-4">Struktur</th>
                        <th class="px-6 py-4">Waktu</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-[#e6dec9] text-[#2b3a32] text-sm">
                    @forelse($analyses as $analysis)
                        <tr class="hover:bg-[#fbf8f1]/40 transition">
                            <td class="px-6 py-4 font-bold text-[#1b4332]">{{ $analysis->user->name ?? 'Guest/Tamu' }}</td>
                            <td class="px-6 py-4">
                                <p class="text-2xl font-arabic text-[#133827] dir-rtl" dir="rtl">
                                    {{ $analysis->input_text }}
                                </p>
                            </td>
                            <td class="px-6 py-4 text-xs font-semibold">
                                <span class="px-2.5 py-1 bg-[#1b4332]/10 border border-[#1b4332]/20 text-[#1b4332] rounded-lg">
                                    {{ $analysis->hasil_analisis['sentence_structure'] ?? 'Jumlah Ismiyah' }}
                                </span>
                            </td>
                            <td class="px-6 py-4 text-xs text-[#5c6f60]">{{ $analysis->created_at->diffForHumans() }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="px-6 py-8 text-center text-[#5c6f60]">Belum ada aktivitas analisis.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($analyses->hasPages())
            <div class="px-6 py-4 bg-[#fcfbfa] border-t border-[#e6dec9]">
                {{ $analyses->links() }}
            </div>
        @endif
    </div>
</div>
@endsection
