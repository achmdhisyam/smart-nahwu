@extends('layouts.app')

@section('title', 'Manajemen Pengguna - Admin Smart Nahwu')

@section('content')
<div class="max-w-5xl mx-auto space-y-6">
    <!-- Header -->
    <div class="flex items-center justify-between">
        <div class="space-y-1">
            <a href="{{ route('admin.dashboard') }}" class="text-xs text-[#1b4332] hover:text-[#b45309] font-bold">← Kembali ke Dashboard</a>
            <h1 class="text-3xl font-extrabold text-[#1b4332]">Manajemen Pengguna</h1>
            <p class="text-sm text-[#5c6f60]">Tambah, edit, dan hapus data santri maupun admin sistem.</p>
        </div>
        
        <a href="{{ route('admin.pengguna.create') }}" class="bg-[#1b4332] hover:bg-[#255641] text-white font-bold py-2.5 px-4 rounded-xl text-xs transition border border-[#1b4332] shadow-sm flex items-center gap-1.5 cursor-pointer">
            <i class="fa-solid fa-user-plus"></i> Tambah Pengguna
        </a>
    </div>

    <!-- Alert Banner Success -->
    @if(session('success'))
        <div class="p-4 bg-emerald-500/10 border border-emerald-500/20 rounded-xl text-emerald-700 text-sm flex items-center gap-2 font-medium">
            <i class="fa-solid fa-circle-check text-emerald-600"></i>
            {{ session('success') }}
        </div>
    @endif

    <!-- Alert Banner Error -->
    @if(session('error'))
        <div class="p-4 bg-rose-500/10 border border-rose-500/20 rounded-xl text-rose-700 text-sm flex items-center gap-2 font-medium">
            <i class="fa-solid fa-circle-exclamation text-rose-600"></i>
            {{ session('error') }}
        </div>
    @endif

    <!-- Table Card -->
    <div class="glass bg-white rounded-3xl overflow-hidden shadow-sm border border-[#e6dec9]">
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-[#fcfbfa] border-b border-[#e6dec9] text-[#4a5d4e] text-xs uppercase tracking-wider font-bold">
                        <th class="px-6 py-4">Nama</th>
                        <th class="px-6 py-4">Email</th>
                        <th class="px-6 py-4">Role</th>
                        <th class="px-6 py-4">Terdaftar Pada</th>
                        <th class="px-6 py-4 text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-[#e6dec9] text-[#2b3a32] text-sm">
                    @forelse($users as $user)
                        <tr class="hover:bg-[#fbf8f1]/40 transition">
                            <td class="px-6 py-4 font-bold text-[#1b4332]">{{ $user->name }}</td>
                            <td class="px-6 py-4">{{ $user->email }}</td>
                            <td class="px-6 py-4">
                                <span class="px-2.5 py-0.5 text-xs font-bold rounded-lg border {{ $user->role === 'admin' ? 'bg-[#b45309]/10 text-[#b45309] border-[#b45309]/20' : 'bg-[#1b4332]/10 text-[#1b4332] border-[#1b4332]/20' }}">
                                    {{ $user->role === 'admin' ? 'Admin' : 'Santri' }}
                                </span>
                            </td>
                            <td class="px-6 py-4 text-xs text-[#5c6f60]">{{ $user->created_at->format('d M Y, H:i') }}</td>
                            <td class="px-6 py-4 text-right flex items-center justify-end space-x-2">
                                <!-- Edit -->
                                <a 
                                    href="{{ route('admin.pengguna.edit', $user->id) }}" 
                                    class="px-2.5 py-1.5 bg-[#dfb15b]/10 text-[#a1782b] border border-[#dfb15b]/20 hover:bg-[#dfb15b] hover:text-white rounded-lg text-xs font-bold transition flex items-center gap-1"
                                >
                                    <i class="fa-solid fa-user-pen"></i> Edit
                                </a>

                                <!-- Delete (Disable if current active admin) -->
                                @if($user->id !== auth()->id())
                                    <form action="{{ route('admin.pengguna.destroy', $user->id) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus pengguna {{ $user->name }}? Semua data kuis dan riwayat analisis terkait juga akan terhapus.');" class="inline m-0 p-0">
                                        @csrf
                                        @method('DELETE')
                                        <button 
                                            type="submit" 
                                            class="px-2.5 py-1.5 bg-rose-500/10 text-rose-600 border border-rose-500/20 hover:bg-rose-500 hover:text-white rounded-lg text-xs font-bold transition flex items-center gap-1 cursor-pointer"
                                        >
                                            <i class="fa-solid fa-trash-can"></i> Hapus
                                        </button>
                                    </form>
                                @else
                                    <span class="px-2.5 py-1.5 bg-gray-100 text-gray-400 border border-gray-200 rounded-lg text-xs font-bold select-none cursor-not-allowed flex items-center gap-1" title="Akun Anda yang sedang aktif">
                                        <i class="fa-solid fa-lock"></i> Aktif
                                    </span>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="px-6 py-8 text-center text-[#5c6f60]">Belum ada pengguna terdaftar.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($users->hasPages())
            <div class="px-6 py-4 bg-[#fcfbfa] border-t border-[#e6dec9]">
                {{ $users->links() }}
            </div>
        @endif
    </div>
</div>
@endsection
