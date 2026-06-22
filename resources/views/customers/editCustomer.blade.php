@extends('layouts.app')

@section('title', 'Edit Customer')

@section('content')
    <div class="p-4 md:p-6 lg:p-8 flex justify-center items-start md:items-center min-h-[80vh]">

        <div class="w-full max-w-lg bg-white rounded-2xl shadow-lg overflow-hidden">

            {{-- Header --}}
            <div class="flex items-center justify-between px-6 pt-6 pb-3">
                <h2 class="text-lg font-bold text-gray-900">Edit Customer</h2>
                <a href="{{ route('customers.index') }}"
                   class="w-8 h-8 rounded-lg flex items-center justify-center text-gray-400 hover:bg-gray-100 hover:text-gray-600 transition-colors"
                   title="Batal">
                    <i class="bi bi-x-lg"></i>
                </a>
            </div>

            <form action="{{ route('customers.update', $customer->id) }}" method="POST">
                @csrf
                @method('PUT')

                <div class="px-6 pb-2">
                    {{-- Profile + Name --}}
                    <div class="flex items-center gap-4 mb-5">
                        <div class="w-16 h-16 rounded-full bg-blue-100 text-blue-600 flex items-center justify-center text-2xl flex-shrink-0 border-2 border-blue-200">
                            <i class="bi bi-person-fill"></i>
                        </div>
                        <div class="flex-1">
                            <label for="name" class="block text-xs font-medium text-gray-500 mb-1">Nama Customer <span class="text-red-500">*</span></label>
                            <input type="text" name="name" id="name"
                                   class="w-full text-base font-bold text-gray-900 border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors"
                                   value="{{ old('name', $customer->name) }}" required placeholder="Masukkan nama customer">
                        </div>
                    </div>

                    <hr class="border-gray-100 mb-5">

                    {{-- Form Fields --}}
                    <div class="space-y-4">
                        {{-- Gender --}}
                        <div>
                            <label for="gender" class="block text-sm font-medium text-gray-500 mb-1.5">Jenis Kelamin</label>
                            <select name="gender" id="gender"
                                    class="w-full border border-gray-300 rounded-lg px-3 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors">
                                <option value="" disabled>Pilih Jenis Kelamin</option>
                                <option value="L" {{ old('gender', $customer->gender) == 'L' ? 'selected' : '' }}>Laki-laki</option>
                                <option value="P" {{ old('gender', $customer->gender) == 'P' ? 'selected' : '' }}>Perempuan</option>
                            </select>
                        </div>

                        {{-- Phone --}}
                        <div>
                            <label for="phone" class="block text-sm font-medium text-gray-500 mb-1.5">No. Telepon</label>
                            <input type="text" name="phone" id="phone"
                                   class="w-full border border-gray-300 rounded-lg px-3 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors"
                                   value="{{ old('phone', $customer->phone) }}" placeholder="Contoh: 08123456789">
                        </div>

                        {{-- Address --}}
                        <div>
                            <label for="address" class="block text-sm font-medium text-gray-500 mb-1.5">Alamat</label>
                            <textarea name="address" id="address" rows="3"
                                      class="w-full border border-gray-300 rounded-lg px-3 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors resize-none"
                                      placeholder="Masukkan alamat lengkap">{{ old('address', $customer->address) }}</textarea>
                        </div>

                    </div>
                </div>

                {{-- Footer --}}
                <div class="flex items-center justify-end gap-2 px-6 py-4 bg-gray-50 mt-4">
                    <a href="{{ route('customers.index') }}"
                       class="px-4 py-2.5 text-sm font-semibold text-gray-600 bg-white border border-gray-300 rounded-lg shadow-sm hover:bg-gray-50 transition-colors">
                        Batal
                    </a>
                    <button type="submit"
                            class="inline-flex items-center gap-2 px-4 py-2.5 text-sm font-semibold text-white bg-blue-600 rounded-lg shadow-sm hover:bg-blue-700 transition-colors">
                        <i class="bi bi-save"></i> Simpan Perubahan
                    </button>
                </div>
            </form>
        </div>
    </div>
@endsection
