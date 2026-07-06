<style>
    :root {
        --inventra-red: #FF2C2C;
        --inventra-red-dark: #D91F1F;
        --inventra-dark: #111827;
        --inventra-muted: #6b7280;
        --inventra-border: #d1d5db;
    }

    html,
    body {
        margin: 0;
        padding: 0;
        overflow-x: hidden;
        background: #ffffff;
    }

    .auth-page {
        min-height: 100svh;
        width: 100%;
        background: #ffffff;
        display: grid;
        grid-template-columns: minmax(0, 56%) minmax(430px, 44%);
    }

    .auth-illustration {
        position: relative;
        height: 100svh;
        min-height: 100svh;
        overflow: hidden;
        background: #eef7fb;
    }

    .auth-illustration img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        object-position: center center;
        display: block;
    }

    .auth-illustration::after {
        content: "";
        position: absolute;
        inset: 0;
        background: linear-gradient(
            180deg,
            rgba(255, 255, 255, 0.02) 0%,
            rgba(255, 44, 44, 0.06) 100%
        );
        pointer-events: none;
    }

    .auth-glass {
        position: absolute;
        left: clamp(26px, 3vw, 42px);
        bottom: clamp(26px, 3vw, 42px);
        width: min(420px, calc(100% - 52px));
        padding: clamp(22px, 2.4vw, 30px);
        border-radius: 24px;
        background: rgba(17, 24, 39, 0.54);
        border: 1px solid rgba(255, 255, 255, 0.18);
        backdrop-filter: blur(16px);
        -webkit-backdrop-filter: blur(16px);
        color: #ffffff;
        box-shadow: 0 20px 50px rgba(0, 0, 0, 0.22);
        z-index: 2;
    }

    .auth-glass h2 {
        margin: 0 0 12px;
        font-size: clamp(28px, 2.8vw, 36px);
        line-height: 1.18;
        font-weight: 800;
        letter-spacing: -0.03em;
    }

    .auth-glass p {
        margin: 0;
        font-size: clamp(14px, 1.2vw, 16px);
        line-height: 1.75;
        color: rgba(255, 255, 255, 0.92);
    }

    .auth-content {
        min-height: 100svh;
        background: #ffffff;
        display: flex;
        justify-content: center;
        align-items: stretch;
        padding: clamp(24px, 3.5vh, 40px) clamp(42px, 5vw, 72px);
        overflow-y: auto;
    }

    .auth-form-wrap {
        width: 100%;
        max-width: 450px;
        margin-block: auto;
    }

    .auth-form-wrap.is-compact {
        max-width: 435px;
    }

    .auth-logo {
        width: clamp(195px, 14vw, 235px);
        height: auto;
        display: block;
        margin: 0 auto 6px;
    }

    .auth-form-wrap.is-compact .auth-logo {
        width: clamp(175px, 13vw, 215px);
    }

    .auth-subtitle {
        margin: 0 0 clamp(24px, 3.4vh, 34px);
        text-align: center;
        font-size: clamp(14px, 1.05vw, 15px);
        line-height: 1.55;
        color: var(--inventra-muted);
    }

    .auth-title {
        margin: 0 0 10px;
        font-size: clamp(30px, 3vw, 38px);
        line-height: 1.15;
        font-weight: 800;
        color: var(--inventra-dark);
        letter-spacing: -0.03em;
    }

    .auth-description {
        margin: 0 0 24px;
        font-size: clamp(14px, 1.15vw, 16px);
        line-height: 1.65;
        color: var(--inventra-muted);
    }

    .form-group {
        margin-bottom: 17px;
    }

    .form-label {
        display: block;
        margin-bottom: 8px;
        font-size: 14px;
        font-weight: 700;
        color: var(--inventra-dark);
    }

    .form-input {
        width: 100%;
        height: 54px;
        border: 1px solid var(--inventra-border);
        border-radius: 17px;
        padding: 0 18px;
        background: #ffffff;
        font-size: 15px;
        color: var(--inventra-dark);
        transition: all 0.2s ease;
    }

    .form-input::placeholder {
        font-size: 14px;
        color: #9ca3af;
    }

    .form-input:focus {
        border-color: var(--inventra-red);
        box-shadow: 0 0 0 4px rgba(255, 44, 44, 0.14);
        outline: none;
    }

    .password-box {
        position: relative;
    }

    .password-box .form-input {
        padding-right: 108px;
    }

    .toggle-password {
        position: absolute;
        top: 50%;
        right: 18px;
        transform: translateY(-50%);
        border: none;
        background: transparent;
        color: var(--inventra-muted);
        font-size: 13px;
        font-weight: 700;
        cursor: pointer;
    }

    .toggle-password:hover {
        color: var(--inventra-dark);
    }

    .auth-button {
        width: 100%;
        height: 56px;
        border: none;
        border-radius: 17px;
        background: var(--inventra-red);
        color: #ffffff;
        font-size: 15px;
        font-weight: 800;
        cursor: pointer;
        box-shadow: 0 14px 30px rgba(255, 44, 44, 0.25);
        transition: all 0.2s ease;
    }

    .auth-button:hover {
        background: var(--inventra-red-dark);
        transform: translateY(-1px);
        box-shadow: 0 16px 34px rgba(217, 31, 31, 0.3);
    }

    .auth-secondary-button {
        width: 100%;
        height: 52px;
        border: 1px solid #e5e7eb;
        border-radius: 17px;
        background: #f8fafc;
        color: var(--inventra-dark);
        font-size: 14px;
        font-weight: 800;
        cursor: pointer;
        transition: all 0.2s ease;
    }

    .auth-secondary-button:hover {
        background: #f1f5f9;
    }

    .auth-link {
        color: var(--inventra-red);
        font-size: 14px;
        font-weight: 700;
        text-decoration: none;
        transition: color 0.2s ease;
    }

    .auth-link:hover {
        color: var(--inventra-red-dark);
        text-decoration: underline;
    }

    .auth-helper-text {
        margin-top: 20px;
        text-align: center;
        font-size: 14px;
        color: var(--inventra-muted);
    }

    .auth-status {
        margin-bottom: 22px;
        padding: 14px 16px;
        border-radius: 16px;
        background: #ecfdf5;
        color: #047857;
        font-size: 14px;
        line-height: 1.6;
        font-weight: 600;
    }

    .auth-info-box {
        margin-bottom: 24px;
        padding: 18px 20px;
        border-radius: 18px;
        background: #f8fafc;
        border: 1px solid #e5e7eb;
        color: var(--inventra-muted);
        font-size: 14px;
        line-height: 1.7;
    }

    .auth-actions {
        margin-top: 24px;
        display: grid;
        gap: 12px;
    }

    @media (max-width: 1366px) {
        .auth-page {
            grid-template-columns: minmax(0, 55%) minmax(420px, 45%);
        }

        .auth-content {
            padding: 26px 48px;
        }

        .auth-form-wrap {
            max-width: 425px;
        }

        .auth-form-wrap.is-compact {
            max-width: 415px;
        }

        .auth-logo {
            width: 210px;
        }

        .auth-form-wrap.is-compact .auth-logo {
            width: 190px;
        }

        .auth-subtitle {
            margin-bottom: 24px;
            font-size: 14px;
        }

        .auth-title {
            font-size: 32px;
        }

        .auth-description {
            margin-bottom: 20px;
            font-size: 14px;
        }

        .form-group {
            margin-bottom: 14px;
        }

        .form-input {
            height: 50px;
            border-radius: 16px;
        }

        .auth-button {
            height: 52px;
            border-radius: 16px;
        }

        .auth-glass {
            width: min(390px, calc(100% - 52px));
        }
    }

    @media (max-width: 1180px) {
        .auth-page {
            grid-template-columns: minmax(0, 52%) minmax(410px, 48%);
        }

        .auth-content {
            padding: 24px 38px;
        }

        .auth-glass {
            width: min(350px, calc(100% - 48px));
        }

        .auth-glass h2 {
            font-size: 28px;
        }
    }

    @media (max-width: 1024px) {
        .auth-page {
            grid-template-columns: 1fr;
        }

        .auth-illustration {
            display: none;
        }

        .auth-content {
            min-height: 100svh;
            padding: 42px 28px;
        }

        .auth-form-wrap,
        .auth-form-wrap.is-compact {
            max-width: 460px;
        }

        .auth-logo,
        .auth-form-wrap.is-compact .auth-logo {
            width: 220px;
        }
    }

    @media (max-width: 520px) {
        .auth-content {
            padding: 34px 22px;
        }

        .auth-logo,
        .auth-form-wrap.is-compact .auth-logo {
            width: 205px;
        }

        .auth-subtitle {
            margin-bottom: 30px;
            font-size: 14px;
        }

        .auth-title {
            font-size: 29px;
        }

        .auth-description {
            font-size: 14px;
            margin-bottom: 24px;
        }

        .form-input {
            height: 52px;
            font-size: 14px;
            border-radius: 16px;
        }

        .password-box .form-input {
            padding-right: 96px;
        }

        .auth-button {
            height: 52px;
            border-radius: 16px;
        }
    }

    @media (max-height: 760px) and (min-width: 1025px) {
        .auth-content {
            padding-top: 20px;
            padding-bottom: 20px;
        }

        .auth-logo,
        .auth-form-wrap.is-compact .auth-logo {
            width: 170px;
        }

        .auth-subtitle {
            margin-bottom: 18px;
            font-size: 13px;
        }

        .auth-title {
            font-size: 28px;
        }

        .auth-description {
            margin-bottom: 16px;
            font-size: 13px;
        }

        .form-group {
            margin-bottom: 11px;
        }

        .form-label {
            margin-bottom: 6px;
            font-size: 13px;
        }

        .form-input {
            height: 46px;
        }

        .auth-button {
            height: 48px;
        }

        .auth-helper-text {
            margin-top: 16px;
        }
    }
</style>
