<style>
    .inventra-splash-lock {
        overflow: hidden !important;
    }

    .inventra-splash {
        position: fixed;
        inset: 0;
        z-index: 99999;
        display: flex;
        align-items: center;
        justify-content: center;
        background:
            radial-gradient(circle at 50% 42%, rgba(255, 44, 44, 0.08), transparent 34%),
            linear-gradient(135deg, #ffffff 0%, #f8fafc 100%);
        transition: opacity 0.55s ease, visibility 0.55s ease;
    }

    .inventra-splash.is-hidden {
        opacity: 0;
        visibility: hidden;
        pointer-events: none;
    }

    .inventra-splash-card {
        width: min(520px, calc(100% - 40px));
        min-height: 360px;
        padding: 46px 34px 38px;
        border-radius: 34px;
        background: rgba(255, 255, 255, 0.88);
        border: 1px solid rgba(226, 232, 240, 0.85);
        box-shadow: 0 28px 80px rgba(15, 23, 42, 0.12);
        backdrop-filter: blur(18px);
        -webkit-backdrop-filter: blur(18px);
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
    }

    .inventra-splash-logo-wrap {
        width: 160px;
        height: 160px;
        border-radius: 42px;
        display: flex;
        align-items: center;
        justify-content: center;
        background: #ffffff;
        border: 1px solid rgba(226, 232, 240, 0.9);
        box-shadow: 0 20px 50px rgba(255, 44, 44, 0.16);
        animation: inventraLogoPop 0.8s cubic-bezier(.2, .9, .2, 1.25) both;
    }

    .inventra-splash-logo {
        width: 125px;
        height: auto;
        display: block;
    }

    .inventra-splash-title {
        margin-top: 30px;
        display: flex;
        flex-wrap: wrap;
        justify-content: center;
        gap: 8px;
        text-align: center;
        font-size: 30px;
        line-height: 1.25;
        font-weight: 900;
        color: #0f172a;
        letter-spacing: -0.04em;
    }

    .inventra-splash-title span {
        opacity: 0;
        transform: translateY(18px);
        animation: inventraWordIn 0.55s cubic-bezier(.2, .85, .2, 1) forwards;
    }

    .inventra-splash-title span:nth-child(1) {
        animation-delay: 0.45s;
    }

    .inventra-splash-title span:nth-child(2) {
        animation-delay: 0.58s;
    }

    .inventra-splash-title span:nth-child(3) {
        animation-delay: 0.71s;
    }

    .inventra-splash-title span:nth-child(4) {
        animation-delay: 0.84s;
    }

    .inventra-splash-title span:nth-child(5) {
        animation-delay: 0.97s;
        color: #FF2C2C;
    }

    .inventra-splash-subtitle {
        margin-top: 14px;
        max-width: 360px;
        text-align: center;
        font-size: 15px;
        line-height: 1.7;
        color: #64748b;
        opacity: 0;
        transform: translateY(12px);
        animation: inventraSubtitleIn 0.55s ease forwards;
        animation-delay: 1.18s;
    }

    .inventra-splash-progress {
        width: 220px;
        height: 8px;
        margin-top: 32px;
        border-radius: 999px;
        background: #fee2e2;
        overflow: hidden;
    }

    .inventra-splash-progress span {
        display: block;
        width: 100%;
        height: 100%;
        border-radius: inherit;
        background: linear-gradient(90deg, #FF2C2C, #ff7a18);
        transform: translateX(-100%);
        animation: inventraProgress 2.55s ease forwards;
        animation-delay: 0.7s;
    }

    @keyframes inventraLogoPop {
        0% {
            opacity: 0;
            transform: scale(0.72) translateY(18px);
        }

        70% {
            opacity: 1;
            transform: scale(1.04) translateY(0);
        }

        100% {
            opacity: 1;
            transform: scale(1) translateY(0);
        }
    }

    @keyframes inventraWordIn {
        0% {
            opacity: 0;
            transform: translateY(18px);
            filter: blur(5px);
        }

        100% {
            opacity: 1;
            transform: translateY(0);
            filter: blur(0);
        }
    }

    @keyframes inventraSubtitleIn {
        0% {
            opacity: 0;
            transform: translateY(12px);
        }

        100% {
            opacity: 1;
            transform: translateY(0);
        }
    }

    @keyframes inventraProgress {
        0% {
            transform: translateX(-100%);
        }

        100% {
            transform: translateX(0);
        }
    }

    @media (max-width: 520px) {
        .inventra-splash-card {
            min-height: 320px;
            padding: 38px 24px 32px;
            border-radius: 28px;
        }

        .inventra-splash-logo-wrap {
            width: 132px;
            height: 132px;
            border-radius: 34px;
        }

        .inventra-splash-logo {
            width: 104px;
        }

        .inventra-splash-title {
            font-size: 25px;
        }

        .inventra-splash-subtitle {
            font-size: 14px;
        }
    }

    @media (prefers-reduced-motion: reduce) {
        .inventra-splash-logo-wrap,
        .inventra-splash-title span,
        .inventra-splash-subtitle,
        .inventra-splash-progress span {
            animation: none !important;
            opacity: 1 !important;
            transform: none !important;
            filter: none !important;
        }
    }
</style>

<div class="inventra-splash"
     data-inventra-splash
     role="status"
     aria-live="polite">
    <div class="inventra-splash-card">
        <div class="inventra-splash-logo-wrap">
            <img src="{{ asset('images/inventra-logo-full.png') }}?v=130"
                 alt="Inventra"
                 class="inventra-splash-logo">
        </div>

        <div class="inventra-splash-title">
            <span>Selamat</span>
            <span>datang</span>
            <span>di</span>
            <span>aplikasi</span>
            <span>Inventra</span>
        </div>

        <p class="inventra-splash-subtitle">
            Sistem manajemen inventaris untuk memantau barang, stok, peminjaman, dan laporan.
        </p>

        <div class="inventra-splash-progress">
            <span></span>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const splash = document.querySelector('[data-inventra-splash]');

        if (!splash) {
            return;
        }

        const params = new URLSearchParams(window.location.search);
        const forceSplash = params.get('splash') === '1';
        const storageKey = 'inventra_login_splash_seen';

        let hasSeenSplash = false;

        try {
            hasSeenSplash = sessionStorage.getItem(storageKey) === 'true';
        } catch (error) {
            hasSeenSplash = false;
        }

        if (hasSeenSplash && !forceSplash) {
            splash.remove();
            return;
        }

        document.body.classList.add('inventra-splash-lock');

        window.setTimeout(function () {
            splash.classList.add('is-hidden');
        }, 3500);

        window.setTimeout(function () {
            splash.remove();
            document.body.classList.remove('inventra-splash-lock');

            try {
                sessionStorage.setItem(storageKey, 'true');
            } catch (error) {
                //
            }
        }, 4100);
    });
</script>
