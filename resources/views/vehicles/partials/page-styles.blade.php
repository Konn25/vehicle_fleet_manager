<style>
    :root {
        --fleet-ink: #172033;
        --fleet-muted: #697386;
        --fleet-line: #e7ebf2;
        --fleet-surface: #ffffff;
        --fleet-soft: #f5f7fb;
        --fleet-primary: #3157d5;
        --fleet-primary-dark: #243fae;
        --fleet-success: #168467;
        --fleet-warning: #bc7211;
        --fleet-danger: #c73e55;
        --fleet-radius-lg: 24px;
        --fleet-radius-md: 16px;
        --fleet-shadow: 0 18px 48px rgba(30, 42, 73, .09);
        --fleet-shadow-sm: 0 8px 24px rgba(30, 42, 73, .07);
    }

    body.bg-light {
        background: #f4f6fa !important;
        color: var(--fleet-ink);
        transition: background-color .2s ease, color .2s ease;
    }
    .fleet-page { width: 100%; color: var(--fleet-ink); }
    .fleet-page .min-w-0 { min-width: 0; }

    .fleet-hero {
        position: relative;
        overflow: hidden;
        padding: clamp(1.5rem, 4vw, 2.75rem);
        border-radius: var(--fleet-radius-lg);
        background: linear-gradient(135deg, #172554 0%, #273c98 52%, #3157d5 100%);
        box-shadow: 0 22px 50px rgba(37, 59, 147, .22);
        color: #fff;
    }

    .fleet-hero__glow {
        position: absolute;
        width: 18rem;
        height: 18rem;
        border-radius: 50%;
        background: rgba(255, 255, 255, .1);
        pointer-events: none;
    }

    .fleet-hero__glow--one { top: -11rem; right: -3rem; }
    .fleet-hero__glow--two { bottom: -14rem; left: 28%; }

    .fleet-eyebrow {
        display: inline-flex;
        align-items: center;
        gap: .5rem;
        color: #cbd7ff;
        font-size: .75rem;
        font-weight: 700;
        letter-spacing: .1em;
        text-transform: uppercase;
    }

    .fleet-hero__title {
        font-size: clamp(2rem, 5vw, 3.25rem);
        font-weight: 750;
        letter-spacing: -.045em;
        line-height: 1.05;
    }

    .fleet-hero__subtitle { max-width: 38rem; color: rgba(255, 255, 255, .72); font-size: 1rem; }

    .fleet-stats {
        position: relative;
        display: grid;
        grid-template-columns: repeat(4, minmax(0, 1fr));
        gap: .75rem;
    }

    .fleet-stat {
        display: flex;
        align-items: center;
        gap: .75rem;
        min-width: 0;
        padding: .9rem;
        border: 1px solid rgba(255, 255, 255, .12);
        border-radius: 14px;
        background: rgba(255, 255, 255, .08);
        backdrop-filter: blur(10px);
    }

    .fleet-stat__icon {
        display: grid;
        flex: 0 0 auto;
        width: 2.5rem;
        height: 2.5rem;
        place-items: center;
        border-radius: 11px;
        background: rgba(255, 255, 255, .13);
    }

    .fleet-stat__icon--green { color: #6ee7b7; }
    .fleet-stat__icon--amber { color: #fcd34d; }
    .fleet-stat__icon--slate { color: #cbd5e1; }
    .fleet-stat__icon--blue { color: #bfdbfe; }
    .fleet-stat strong, .fleet-stat small { display: block; }
    .fleet-stat strong { font-size: 1.25rem; line-height: 1.1; }
    .fleet-stat small { margin-top: .2rem; color: rgba(255, 255, 255, .65); }

    .fleet-btn {
        display: inline-flex;
        min-height: 2.75rem;
        align-items: center;
        justify-content: center;
        gap: .6rem;
        padding: .65rem 1rem;
        border: 0;
        border-radius: 12px;
        font-weight: 700;
        transition: transform .18s ease, box-shadow .18s ease, background .18s ease;
    }

    .fleet-btn:hover { transform: translateY(-1px); }
    .fleet-btn--light { background: #fff; color: #243fae; box-shadow: 0 10px 24px rgba(12, 23, 66, .18); }
    .fleet-btn--light:hover { background: #f2f5ff; color: #172b7a; }
    .fleet-btn--primary { background: var(--fleet-primary); color: #fff; box-shadow: 0 8px 18px rgba(49, 87, 213, .2); }
    .fleet-btn--primary:hover { background: var(--fleet-primary-dark); color: #fff; }
    .fleet-btn--soft { background: #eef2ff; color: var(--fleet-primary-dark); }
    .fleet-btn--soft:hover { background: #e0e7ff; color: #172b7a; }
    .fleet-btn--danger { background: #fff0f2; color: var(--fleet-danger); }
    .fleet-btn--danger:hover { background: #ffe1e6; color: #a9253c; }

    .fleet-alert { border: 0; border-radius: var(--fleet-radius-md); box-shadow: var(--fleet-shadow-sm); }
    .fleet-alert--danger { background: #fff1f3; color: #9f2339; }
    .fleet-alert--success { background: #ecfdf5; color: #116149; }

    .fleet-toolbar {
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 1rem;
        padding: .75rem;
        border: 1px solid var(--fleet-line);
        border-radius: var(--fleet-radius-md);
        background: var(--fleet-surface);
        box-shadow: var(--fleet-shadow-sm);
    }

    .fleet-search { position: relative; flex: 1 1 22rem; max-width: 30rem; }
    .fleet-search > i { position: absolute; top: 50%; left: 1rem; z-index: 2; transform: translateY(-50%); color: #9099aa; }
    .fleet-search .form-control { min-height: 2.75rem; padding-left: 2.75rem; border: 1px solid transparent; border-radius: 11px; background: var(--fleet-soft); }
    .fleet-search .form-control:focus { border-color: #9fb1f5; background: #fff; box-shadow: 0 0 0 .2rem rgba(49, 87, 213, .12); }

    .fleet-filter-group { display: flex; gap: .25rem; padding: .25rem; border-radius: 11px; background: var(--fleet-soft); }
    .fleet-filter { padding: .55rem .85rem; border: 0; border-radius: 9px; background: transparent; color: var(--fleet-muted); font-size: .875rem; font-weight: 700; white-space: nowrap; }
    .fleet-filter:hover { color: var(--fleet-ink); }
    .fleet-filter.is-active { background: #fff; color: var(--fleet-primary); box-shadow: 0 3px 10px rgba(30, 42, 73, .08); }

    .vehicle-card, .fleet-panel { overflow: hidden; border: 1px solid var(--fleet-line); border-radius: var(--fleet-radius-lg); background: var(--fleet-surface); box-shadow: var(--fleet-shadow-sm); }
    .vehicle-card { display: flex; flex-direction: column; transition: transform .22s ease, box-shadow .22s ease, border-color .22s ease; }
    .vehicle-card:hover { transform: translateY(-4px); border-color: #d5dcf0; box-shadow: var(--fleet-shadow); }
    .vehicle-card__topline { height: 4px; background: #94a3b8; }
    .vehicle-card__topline--active { background: #22a67f; }
    .vehicle-card__topline--service { background: #e8a126; }
    .vehicle-card__topline--inactive { background: #94a3b8; }
    .vehicle-card__topline--unknown { background: #e35d73; }
    .vehicle-card__body { flex: 1 1 auto; padding: 1.35rem; }
    .vehicle-card__avatar { display: grid; flex: 0 0 auto; width: 3.25rem; height: 3.25rem; place-items: center; border-radius: 14px; background: #eef2ff; color: var(--fleet-primary); font-size: 1.2rem; }
    .vehicle-card__brand { color: var(--fleet-muted); font-size: .8rem; font-weight: 700; letter-spacing: .045em; text-transform: uppercase; }
    .vehicle-card__plate { font-size: 1.3rem; font-weight: 800; letter-spacing: .035em; }

    .fleet-status { display: inline-flex; flex: 0 0 auto; align-items: center; gap: .35rem; padding: .38rem .6rem; border-radius: 999px; font-size: .72rem; font-weight: 750; }
    .fleet-status--active { background: #e8f8f2; color: #137357; }
    .fleet-status--service { background: #fff5df; color: #9a5a08; }
    .fleet-status--inactive { background: #eef1f5; color: #5f6b7c; }
    .fleet-status--unknown { background: #fff0f2; color: #ad2a41; }

    .vehicle-specs { display: grid; grid-template-columns: repeat(2, minmax(0, 1fr)); gap: .75rem; }
    .vehicle-spec { display: flex; min-width: 0; align-items: center; gap: .65rem; padding: .75rem; border-radius: 12px; background: var(--fleet-soft); }
    .vehicle-spec > i { width: 1rem; flex: 0 0 auto; color: #7180a1; text-align: center; }
    .vehicle-spec span { min-width: 0; }
    .vehicle-spec small, .vehicle-spec strong { display: block; overflow: hidden; text-overflow: ellipsis; white-space: nowrap; }
    .vehicle-spec small { margin-bottom: .1rem; color: var(--fleet-muted); font-size: .7rem; }
    .vehicle-spec strong { font-size: .85rem; }

    .vehicle-card__insights { border-top: 1px solid var(--fleet-line); }
    .vehicle-insight { display: flex; align-items: center; gap: .7rem; padding: .85rem 0; }
    .vehicle-insight + .vehicle-insight { border-top: 1px solid var(--fleet-line); }
    .vehicle-insight__icon { display: grid; flex: 0 0 auto; width: 2rem; height: 2rem; place-items: center; border-radius: 9px; background: #edf2ff; color: var(--fleet-primary); font-size: .8rem; }
    .vehicle-insight small, .vehicle-insight strong { display: block; }
    .vehicle-insight small { color: var(--fleet-muted); font-size: .72rem; }
    .vehicle-insight strong { margin-top: .1rem; font-size: .85rem; }
    .vehicle-insight--success .vehicle-insight__icon { background: #e8f8f2; color: var(--fleet-success); }
    .vehicle-insight--warning .vehicle-insight__icon { background: #fff5df; color: var(--fleet-warning); }
    .vehicle-insight--danger .vehicle-insight__icon { background: #fff0f2; color: var(--fleet-danger); }
    .vehicle-insight--danger strong { color: var(--fleet-danger); }

    .vehicle-card__footer { display: flex; align-items: stretch; gap: .55rem; padding: 1rem 1.35rem; border-top: 1px solid var(--fleet-line); background: #fbfcfe; }
    .fleet-icon-btn { display: grid; flex: 0 0 2.75rem; width: 2.75rem; height: 2.75rem; place-items: center; border: 1px solid var(--fleet-line); border-radius: 12px; background: #fff; color: #536079; }
    .fleet-icon-btn:hover { border-color: #aeb9d0; background: #f5f7fb; color: var(--fleet-primary); }
    .fleet-icon-btn--danger:hover { border-color: #f4b7c1; background: #fff0f2; color: var(--fleet-danger); }

    .fleet-empty { padding: clamp(2.5rem, 8vw, 5rem) 1.5rem; border: 1px dashed #cdd4e2; border-radius: var(--fleet-radius-lg); background: rgba(255, 255, 255, .72); text-align: center; }
    .fleet-empty__icon { display: grid; width: 4rem; height: 4rem; margin: 0 auto 1rem; place-items: center; border-radius: 18px; background: #eef2ff; color: var(--fleet-primary); font-size: 1.4rem; }
    .fleet-empty h2 { margin-bottom: .4rem; font-size: 1.25rem; font-weight: 750; }
    .fleet-empty p { margin: 0 auto 1.25rem; color: var(--fleet-muted); }

    .fleet-modal .modal-content { overflow: hidden; border: 0; border-radius: 20px; box-shadow: 0 24px 70px rgba(20, 29, 52, .2); }
    .fleet-modal .modal-header { padding: 1.25rem 1.5rem; border-bottom: 1px solid var(--fleet-line); background: #fff; }
    .fleet-modal .modal-title { font-weight: 750; color: var(--fleet-ink); }
    .fleet-modal .modal-body { padding: 1.5rem; }
    .fleet-modal .modal-footer { padding: 1rem 1.5rem; border-top: 1px solid var(--fleet-line); background: #fbfcfe; }
    .fleet-modal .form-label { margin-bottom: .4rem; color: #414c61; font-size: .84rem; font-weight: 700; }
    .fleet-modal .form-control, .fleet-modal .form-select { min-height: 2.8rem; border-color: #dce1eb; border-radius: 11px; }
    .fleet-modal textarea.form-control { min-height: auto; }
    .fleet-modal .form-control:focus, .fleet-modal .form-select:focus { border-color: #8fa5f0; box-shadow: 0 0 0 .2rem rgba(49, 87, 213, .1); }

    .fleet-modal-icon {
        display: grid;
        flex: 0 0 auto;
        width: 2.4rem;
        height: 2.4rem;
        place-items: center;
        border-radius: 11px;
        background: #eef2ff;
        color: var(--fleet-primary);
        font-size: .9rem;
    }

    .fleet-breadcrumb a {
        display: inline-flex;
        align-items: center;
        gap: .5rem;
        color: var(--fleet-muted);
        font-size: .88rem;
        font-weight: 700;
        text-decoration: none;
    }

    .fleet-breadcrumb a:hover { color: var(--fleet-primary); }

    .vehicle-detail-hero {
        position: relative;
        overflow: hidden;
        padding: clamp(1.35rem, 4vw, 2.25rem);
        border-radius: var(--fleet-radius-lg);
        background: linear-gradient(135deg, #172554 0%, #273c98 55%, #3157d5 100%);
        box-shadow: 0 22px 50px rgba(37, 59, 147, .2);
        color: #fff;
    }

    .vehicle-detail-hero__pattern {
        position: absolute;
        inset: 0;
        opacity: .1;
        background-image: radial-gradient(circle at 1px 1px, #fff 1px, transparent 0);
        background-size: 22px 22px;
        mask-image: linear-gradient(to left, #000, transparent 75%);
    }

    .vehicle-detail-hero__icon {
        display: grid;
        flex: 0 0 auto;
        width: clamp(4rem, 10vw, 5.5rem);
        height: clamp(4rem, 10vw, 5.5rem);
        place-items: center;
        border: 1px solid rgba(255, 255, 255, .14);
        border-radius: 20px;
        background: rgba(255, 255, 255, .1);
        color: #fff;
        font-size: clamp(1.45rem, 4vw, 2rem);
        backdrop-filter: blur(10px);
    }

    .vehicle-detail-hero__title { font-size: clamp(1.75rem, 5vw, 2.8rem); font-weight: 800; letter-spacing: .035em; }
    .vehicle-detail-hero__subtitle { color: rgba(255, 255, 255, .7); }
    .vehicle-detail-hero .fleet-eyebrow { color: #cbd7ff; }
    .vehicle-detail-hero .fleet-status { border: 1px solid rgba(255, 255, 255, .12); }

    .vehicle-detail-actions { display: flex; flex: 0 0 auto; gap: .65rem; }
    .fleet-btn--hero { background: #fff; color: #243fae; }
    .fleet-btn--hero:hover { background: #eef2ff; color: #172b7a; }
    .fleet-btn--hero-danger { background: rgba(255, 255, 255, .1); color: #fff; box-shadow: inset 0 0 0 1px rgba(255, 255, 255, .18); }
    .fleet-btn--hero-danger:hover { background: #fff0f2; color: #a9253c; }

    .detail-metrics {
        display: grid;
        grid-template-columns: repeat(4, minmax(0, 1fr));
        gap: 1rem;
    }

    .detail-metric {
        display: flex;
        min-width: 0;
        align-items: center;
        gap: .85rem;
        padding: 1.1rem;
        border: 1px solid var(--fleet-line);
        border-radius: var(--fleet-radius-md);
        background: #fff;
        box-shadow: var(--fleet-shadow-sm);
    }

    .detail-metric__icon {
        display: grid;
        flex: 0 0 auto;
        width: 2.75rem;
        height: 2.75rem;
        place-items: center;
        border-radius: 12px;
    }

    .detail-metric__icon--blue { background: #eef2ff; color: var(--fleet-primary); }
    .detail-metric__icon--cyan { background: #e8f8f7; color: #16847c; }
    .detail-metric__icon--amber { background: #fff5df; color: var(--fleet-warning); }
    .detail-metric__icon--green { background: #e8f8f2; color: var(--fleet-success); }
    .detail-metric span:last-child { min-width: 0; }
    .detail-metric small, .detail-metric strong { display: block; overflow: hidden; text-overflow: ellipsis; white-space: nowrap; }
    .detail-metric small { margin-bottom: .15rem; color: var(--fleet-muted); font-size: .72rem; }
    .detail-metric strong { font-size: .92rem; }

    .fleet-panel__header {
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 1rem;
        padding: 1.25rem 1.5rem;
        border-bottom: 1px solid var(--fleet-line);
    }

    .fleet-section-label { display: block; margin-bottom: .25rem; color: var(--fleet-primary); font-size: .7rem; font-weight: 800; letter-spacing: .1em; text-transform: uppercase; }
    .fleet-panel__title { margin: 0; font-size: 1.12rem; font-weight: 780; letter-spacing: -.015em; }
    .fleet-panel__meta { margin-top: .25rem; color: var(--fleet-muted); font-size: .78rem; }
    .fleet-panel__body { padding: 1.5rem; }

    .detail-grid { display: grid; grid-template-columns: repeat(4, minmax(0, 1fr)); gap: 1px; overflow: hidden; border: 1px solid var(--fleet-line); border-radius: 16px; background: var(--fleet-line); }
    .detail-item { display: flex; min-width: 0; align-items: center; gap: .8rem; padding: 1rem; background: #fff; }
    .detail-item__icon { display: grid; flex: 0 0 auto; width: 2.5rem; height: 2.5rem; place-items: center; border-radius: 11px; background: var(--fleet-soft); color: #67738c; font-size: .86rem; }
    .detail-item span:last-child { min-width: 0; }
    .detail-item small, .detail-item strong { display: block; overflow: hidden; text-overflow: ellipsis; white-space: nowrap; }
    .detail-item small { margin-bottom: .15rem; color: var(--fleet-muted); font-size: .7rem; }
    .detail-item strong { font-size: .86rem; }
    .detail-item--success .detail-item__icon { background: #e8f8f2; color: var(--fleet-success); }
    .detail-item--warning .detail-item__icon { background: #fff5df; color: var(--fleet-warning); }
    .detail-item--danger .detail-item__icon { background: #fff0f2; color: var(--fleet-danger); }
    .detail-item--danger strong { color: var(--fleet-danger); }

    .fleet-table-wrap { overflow-x: auto; }
    .fleet-table { --bs-table-bg: transparent; }
    .fleet-table > :not(caption) > * > * { padding: .95rem 1.5rem; border-color: var(--fleet-line); }
    .fleet-table thead th { border-bottom-width: 1px; background: #fbfcfe; color: var(--fleet-muted); font-size: .7rem; font-weight: 800; letter-spacing: .055em; text-transform: uppercase; white-space: nowrap; }
    .fleet-table tbody td { color: #485268; font-size: .84rem; }
    .fleet-table tbody tr:last-child td { border-bottom: 0; }
    .fleet-table tbody tr:hover { background: #fafbfe; }
    .fleet-table__description { min-width: 15rem; max-width: 28rem; }
    .fleet-currency, .fleet-consumption { display: inline-flex; padding: .32rem .55rem; border-radius: 8px; background: #f0f3f8; color: #566176; font-size: .72rem; font-weight: 750; white-space: nowrap; }
    .fleet-consumption { background: #e8f8f7; color: #13726c; }
    .fleet-row-actions { display: flex; justify-content: flex-end; gap: .4rem; }
    .fleet-row-actions .fleet-icon-btn { width: 2.2rem; height: 2.2rem; min-height: 2.2rem; flex-basis: 2.2rem; border-radius: 9px; font-size: .75rem; }

    .fleet-panel-empty { padding: 3.25rem 1.5rem; color: #8993a5; text-align: center; }
    .fleet-panel-empty i { margin-bottom: .75rem; font-size: 1.6rem; }
    .fleet-panel-empty p { margin: 0; font-size: .9rem; }

    .fleet-panel__header--controls { align-items: flex-end; }
    .fleet-selects { display: flex; gap: .6rem; }
    .fleet-selects label { display: block; color: var(--fleet-muted); font-size: .68rem; font-weight: 700; }
    .fleet-selects label > span { display: block; margin: 0 0 .28rem .15rem; }
    .fleet-selects .form-select { min-width: 6rem; border-color: #dce1eb; border-radius: 9px; font-weight: 650; }
    .fleet-selects--summary .form-select { min-width: 5.5rem; }
    .fleet-chart { position: relative; height: 360px; }
    .fleet-summary-table { max-height: 465px; overflow-y: auto; }
    .fleet-summary-table tfoot { position: sticky; bottom: 0; background: #f8f9fc; font-weight: 800; }

    [data-bs-theme="dark"] {
        --fleet-ink: #edf1f8;
        --fleet-muted: #9ca8bc;
        --fleet-line: #303a4c;
        --fleet-surface: #1b2433;
        --fleet-soft: #222c3d;
        --fleet-primary: #7895ff;
        --fleet-primary-dark: #9eb1ff;
        --fleet-success: #5fd4ae;
        --fleet-warning: #f0b95d;
        --fleet-danger: #ff8196;
        --fleet-shadow: 0 18px 48px rgba(0, 0, 0, .24);
        --fleet-shadow-sm: 0 8px 24px rgba(0, 0, 0, .18);
    }

    [data-bs-theme="dark"] body.bg-light { background: #111722 !important; }
    [data-bs-theme="dark"] .fleet-hero,
    [data-bs-theme="dark"] .vehicle-detail-hero {
        background: linear-gradient(135deg, #111936 0%, #202f76 55%, #304eb2 100%);
        box-shadow: 0 22px 50px rgba(0, 0, 0, .3);
    }

    [data-bs-theme="dark"] .fleet-toolbar,
    [data-bs-theme="dark"] .vehicle-card,
    [data-bs-theme="dark"] .fleet-panel,
    [data-bs-theme="dark"] .detail-metric,
    [data-bs-theme="dark"] .fleet-modal .modal-content,
    [data-bs-theme="dark"] .fleet-modal .modal-header,
    [data-bs-theme="dark"] .detail-item {
        background: var(--fleet-surface);
        color: var(--fleet-ink);
    }

    [data-bs-theme="dark"] .fleet-search .form-control,
    [data-bs-theme="dark"] .fleet-filter-group,
    [data-bs-theme="dark"] .vehicle-spec,
    [data-bs-theme="dark"] .detail-item__icon {
        background: var(--fleet-soft);
        color: var(--fleet-ink);
    }

    [data-bs-theme="dark"] .fleet-search .form-control:focus {
        border-color: #607bdc;
        background: #182131;
        color: var(--fleet-ink);
    }

    [data-bs-theme="dark"] .fleet-filter.is-active {
        background: #34425a;
        color: #b6c4ff;
        box-shadow: 0 3px 10px rgba(0, 0, 0, .2);
    }

    [data-bs-theme="dark"] .vehicle-card__footer,
    [data-bs-theme="dark"] .fleet-modal .modal-footer,
    [data-bs-theme="dark"] .fleet-table thead th,
    [data-bs-theme="dark"] .fleet-summary-table tfoot {
        background: #182130;
    }

    [data-bs-theme="dark"] .fleet-icon-btn {
        border-color: var(--fleet-line);
        background: #222c3d;
        color: #b4bfd1;
    }

    [data-bs-theme="dark"] .fleet-icon-btn:hover {
        border-color: #60708c;
        background: #2a364a;
        color: #aebeff;
    }

    [data-bs-theme="dark"] .fleet-icon-btn--danger:hover {
        border-color: #8f4251;
        background: #3b2029;
        color: #ff9bac;
    }

    [data-bs-theme="dark"] .fleet-btn--soft {
        background: #293754;
        color: #bdc9ff;
    }

    [data-bs-theme="dark"] .fleet-btn--soft:hover { background: #344466; color: #dce3ff; }
    [data-bs-theme="dark"] .fleet-btn--primary { background: #526fd9; color: #fff; }
    [data-bs-theme="dark"] .fleet-btn--primary:hover { background: #6884e8; color: #fff; }

    [data-bs-theme="dark"] .fleet-empty {
        border-color: #3b4659;
        background: rgba(27, 36, 51, .72);
    }

    [data-bs-theme="dark"] .fleet-modal .modal-title,
    [data-bs-theme="dark"] .fleet-modal .form-label { color: var(--fleet-ink); }
    [data-bs-theme="dark"] .fleet-modal .form-control,
    [data-bs-theme="dark"] .fleet-modal .form-select {
        border-color: var(--fleet-line);
        background-color: #151d2a;
        color: var(--fleet-ink);
    }

    [data-bs-theme="dark"] .fleet-modal .form-control::placeholder { color: #768399; }
    [data-bs-theme="dark"] .fleet-table tbody td { color: #c4ccda; }
    [data-bs-theme="dark"] .fleet-table tbody tr:hover { background: #202a3a; }
    [data-bs-theme="dark"] .fleet-currency { background: #2b3546; color: #c1cad9; }
    [data-bs-theme="dark"] .fleet-consumption { background: #173d3a; color: #7bd9ce; }
    [data-bs-theme="dark"] .fleet-panel-empty { color: #8491a6; }
    [data-bs-theme="dark"] .fleet-selects .form-select { border-color: var(--fleet-line); background-color: #151d2a; color: var(--fleet-ink); }

    [data-bs-theme="dark"] .fleet-status--active { background: #163a31; color: #72d8b7; }
    [data-bs-theme="dark"] .fleet-status--service { background: #402f16; color: #f1c26f; }
    [data-bs-theme="dark"] .fleet-status--inactive { background: #303949; color: #bdc5d2; }
    [data-bs-theme="dark"] .fleet-status--unknown { background: #43232b; color: #ff9bad; }

    [data-bs-theme="dark"] .vehicle-card__avatar,
    [data-bs-theme="dark"] .vehicle-insight__icon,
    [data-bs-theme="dark"] .fleet-empty__icon,
    [data-bs-theme="dark"] .fleet-modal-icon,
    [data-bs-theme="dark"] .detail-metric__icon--blue {
        background: #293754;
        color: #9eb1ff;
    }

    [data-bs-theme="dark"] .vehicle-insight--success .vehicle-insight__icon,
    [data-bs-theme="dark"] .detail-item--success .detail-item__icon,
    [data-bs-theme="dark"] .detail-metric__icon--green { background: #173b31; color: #65d4af; }
    [data-bs-theme="dark"] .vehicle-insight--warning .vehicle-insight__icon,
    [data-bs-theme="dark"] .detail-item--warning .detail-item__icon,
    [data-bs-theme="dark"] .detail-metric__icon--amber { background: #402f16; color: #f1c26f; }
    [data-bs-theme="dark"] .vehicle-insight--danger .vehicle-insight__icon,
    [data-bs-theme="dark"] .detail-item--danger .detail-item__icon { background: #43232b; color: #ff9bad; }
    [data-bs-theme="dark"] .detail-metric__icon--cyan { background: #173b3a; color: #72d8d1; }

    [data-bs-theme="dark"] .fleet-alert--danger { background: #43232b; color: #ffb1be; }
    [data-bs-theme="dark"] .fleet-alert--success { background: #173b31; color: #8be0c3; }

    @media (max-width: 767.98px) {
        [data-bs-theme="dark"] .fleet-data-table tbody tr { background: var(--fleet-surface); }
    }

    @media (max-width: 991.98px) {
        .fleet-stats { grid-template-columns: repeat(2, minmax(0, 1fr)); }
        .fleet-toolbar { align-items: stretch; flex-direction: column; }
        .fleet-search { max-width: none; }
        .fleet-filter-group { overflow-x: auto; }
        .detail-metrics { grid-template-columns: repeat(2, minmax(0, 1fr)); }
        .detail-grid { grid-template-columns: repeat(2, minmax(0, 1fr)); }
    }

    @media (max-width: 767.98px) {
        .fleet-table-wrap { overflow: visible; padding: .75rem; }
        .fleet-data-table,
        .fleet-data-table tbody,
        .fleet-data-table tr,
        .fleet-data-table td { display: block; width: 100%; }
        .fleet-data-table thead { display: none; }
        .fleet-data-table tbody { display: grid; gap: .75rem; }
        .fleet-data-table tbody tr { overflow: hidden; border: 1px solid var(--fleet-line); border-radius: 14px; background: #fff; }
        .fleet-data-table tbody td { display: flex; align-items: flex-start; justify-content: space-between; gap: 1rem; padding: .7rem .85rem; border-bottom: 1px solid var(--fleet-line); text-align: right !important; }
        .fleet-data-table tbody td::before { content: attr(data-label); flex: 0 0 auto; color: var(--fleet-muted); font-size: .7rem; font-weight: 800; letter-spacing: .04em; text-align: left; text-transform: uppercase; }
        .fleet-data-table tbody td:last-child { border-bottom: 0; }
        .fleet-table__description { min-width: 0; max-width: none; }
        .fleet-row-actions { width: auto; }
    }

    @media (max-width: 575.98px) {
        .fleet-hero { border-radius: 18px; }
        .fleet-hero .fleet-btn--light { width: 100%; }
        .fleet-stats { grid-template-columns: 1fr 1fr; }
        .fleet-stat { padding: .7rem; }
        .fleet-stat__icon { display: none; }
        .fleet-stat strong { font-size: 1.05rem; }
        .fleet-stat small { font-size: .68rem; }
        .vehicle-card, .fleet-panel { border-radius: 18px; }
        .vehicle-card__body { padding: 1.1rem; }
        .vehicle-card__footer { padding: .9rem 1.1rem; }
        .fleet-status { padding: .35rem .5rem; }
        .fleet-filter-group { width: 100%; }
        .fleet-filter { flex: 1 0 auto; }
        .fleet-modal .modal-dialog { margin: .75rem; }
        .fleet-modal .modal-body { padding: 1.1rem; }
        .vehicle-detail-hero { border-radius: 18px; }
        .vehicle-detail-hero__icon { border-radius: 16px; }
        .vehicle-detail-actions { width: 100%; }
        .vehicle-detail-actions > * { flex: 1 1 0; }
        .vehicle-detail-actions .fleet-btn { width: 100%; }
        .detail-metrics { grid-template-columns: 1fr 1fr; gap: .7rem; }
        .detail-metric { align-items: flex-start; flex-direction: column; gap: .55rem; padding: .85rem; }
        .detail-metric__icon { width: 2.25rem; height: 2.25rem; }
        .detail-grid { grid-template-columns: 1fr; }
        .fleet-panel__header { align-items: stretch; flex-direction: column; padding: 1rem; }
        .fleet-panel__header > .fleet-btn { width: 100%; }
        .fleet-panel__body { padding: 1rem; }
        .fleet-panel__header--controls { align-items: stretch; }
        .fleet-selects { width: 100%; }
        .fleet-selects label { flex: 1 1 0; }
        .fleet-selects .form-select { width: 100%; min-width: 0; }
        .fleet-chart { height: 280px; }
    }

    @media (prefers-reduced-motion: reduce) {
        .vehicle-card, .fleet-btn { transition: none; }
        .vehicle-card:hover, .fleet-btn:hover { transform: none; }
    }
</style>
