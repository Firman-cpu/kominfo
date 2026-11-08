@if (session('success'))
    <div x-data="{ show: true }" x-show="show" x-transition class="mb-6 flex items-center justify-between p-4 bg-emerald-50 border border-emerald-200 text-emerald-800 rounded-xl shadow-xs">
        <div class="flex items-center gap-3">
            <div class="w-8 h-8 rounded-lg bg-emerald-100 flex items-center justify-center text-emerald-600 shrink-0">
                <i data-lucide="check-circle-2" class="w-5 h-5"></i>
            </div>
            <p class="text-sm font-medium">{{ session('success') }}</p>
        </div>
        <button @click="show = false" type="button" class="text-emerald-500 hover:text-emerald-700 p-1 rounded-lg">
            <i data-lucide="x" class="w-4 h-4"></i>
        </button>
    </div>
@endif

@if (session('error'))
    <div x-data="{ show: true }" x-show="show" x-transition class="mb-6 flex items-center justify-between p-4 bg-rose-50 border border-rose-200 text-rose-800 rounded-xl shadow-xs">
        <div class="flex items-center gap-3">
            <div class="w-8 h-8 rounded-lg bg-rose-100 flex items-center justify-center text-rose-600 shrink-0">
                <i data-lucide="alert-triangle" class="w-5 h-5"></i>
            </div>
            <p class="text-sm font-medium">{{ session('error') }}</p>
        </div>
        <button @click="show = false" type="button" class="text-rose-500 hover:text-rose-700 p-1 rounded-lg">
            <i data-lucide="x" class="w-4 h-4"></i>
        </button>
    </div>
@endif

@if ($errors->any())
    <div x-data="{ show: true }" x-show="show" x-transition class="mb-6 p-4 bg-rose-50 border border-rose-200 text-rose-800 rounded-xl shadow-xs">
        <div class="flex items-center justify-between mb-2">
            <div class="flex items-center gap-3">
                <div class="w-8 h-8 rounded-lg bg-rose-100 flex items-center justify-center text-rose-600 shrink-0">
                    <i data-lucide="alert-octagon" class="w-5 h-5"></i>
                </div>
                <h4 class="text-sm font-semibold">Terdapat kesalahan pada isian form:</h4>
            </div>
            <button @click="show = false" type="button" class="text-rose-500 hover:text-rose-700 p-1 rounded-lg">
                <i data-lucide="x" class="w-4 h-4"></i>
            </button>
        </div>
        <ul class="list-disc list-inside text-xs space-y-1 text-rose-700 ml-11">
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif
