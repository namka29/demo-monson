<!doctype html>
<html lang="vi">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Thiết lập xác thực hai lớp</title>
    @vite(['resources/css/app.css'])
</head>
<body class="min-h-screen bg-slate-100 text-slate-900">
    <div class="mx-auto flex min-h-screen w-full max-w-2xl items-center px-4 py-10">
        <div class="w-full rounded-2xl bg-white p-6 shadow-sm ring-1 ring-slate-200">
            <h1 class="text-xl font-semibold">Thiết lập xác thực 2 lớp (TOTP)</h1>
            <p class="mt-2 text-sm text-slate-600">
                Quét QR bằng Google Authenticator / Microsoft Authenticator / Authy, sau đó nhập mã 6 số để kích hoạt.
            </p>

            @if (session('status'))
                <div class="mt-4 rounded-lg border border-emerald-200 bg-emerald-50 px-3 py-2 text-sm text-emerald-700">
                    {{ session('status') }}
                </div>
            @endif

            @if ($errors->any())
                <div class="mt-4 rounded-lg border border-rose-200 bg-rose-50 px-3 py-2 text-sm text-rose-700">
                    {{ $errors->first() }}
                </div>
            @endif

            <div class="mt-6 grid gap-6 md:grid-cols-[220px_minmax(0,1fr)]">
                <div class="flex items-start justify-center md:justify-start">
                    <img src="{{ $qrUrl }}" alt="QR TOTP" class="rounded-lg border border-slate-200 bg-white p-2">
                </div>
                <div class="space-y-3">
                    <p class="text-sm text-slate-700">
                        Nếu không quét được QR, nhập thủ công khóa bí mật:
                    </p>
                    <code class="block break-all rounded-lg bg-slate-100 px-3 py-2 text-sm">{{ $secret }}</code>
                    <details class="text-sm text-slate-600">
                        <summary class="cursor-pointer font-medium">Hiển thị liên kết otpauth</summary>
                        <code class="mt-2 block break-all rounded-lg bg-slate-100 px-3 py-2 text-xs">{{ $otpAuthUri }}</code>
                    </details>
                </div>
            </div>

            <form action="{{ route('admin.totp.confirm') }}" method="post" class="mt-6 space-y-4">
                @csrf
                <label for="code" class="block text-sm font-medium text-slate-700">Mã 6 số từ ứng dụng</label>
                <input
                    id="code"
                    name="code"
                    inputmode="numeric"
                    pattern="[0-9]{6}"
                    maxlength="6"
                    autocomplete="one-time-code"
                    placeholder="123456"
                    class="w-full rounded-lg border border-slate-300 px-3 py-2 tracking-[0.2em] outline-none ring-amber-500 focus:ring-2 md:max-w-xs"
                    required
                >
                <button
                    type="submit"
                    class="inline-flex items-center justify-center rounded-lg bg-amber-500 px-4 py-2 font-medium text-slate-900 transition hover:bg-amber-400"
                >
                    Kích hoạt xác thực 2 lớp
                </button>
            </form>

            @if (! empty($recoveryCodes))
                <div class="mt-6 rounded-lg border border-amber-200 bg-amber-50 p-4">
                    <h2 class="text-sm font-semibold text-amber-900">Mã khôi phục (lưu lại ở nơi an toàn)</h2>
                    <p class="mt-1 text-xs text-amber-800">Mỗi mã chỉ dùng được một lần.</p>
                    <div class="mt-3 grid gap-2 sm:grid-cols-2">
                        @foreach ($recoveryCodes as $recoveryCode)
                            <code class="rounded bg-white px-2 py-1 text-sm text-slate-800 ring-1 ring-amber-200">{{ $recoveryCode }}</code>
                        @endforeach
                    </div>
                </div>
            @endif
        </div>
    </div>
</body>
</html>
