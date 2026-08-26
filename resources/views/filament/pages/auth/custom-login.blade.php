<x-filament-panels::page.simple>
    <style>
        .sellify-login-wrapper {
            position: fixed;
            top: 0;
            left: 0;
            width: 100vw;
            height: 100vh;
            display: flex;
            background: #000;
            z-index: 9999;
            overflow-y: auto;
        }
        .sellify-images-side {
            display: none;
            flex: 1;
            align-items: center;
            justify-content: center;
            gap: 12px;
            padding: 2rem;
        }
        @media (min-width: 1024px) {
            .sellify-images-side { display: flex; }
        }
        .sellify-img-card {
            position: relative;
            border-radius: 16px;
            overflow: hidden;
            width: 160px;
            height: 380px;
            flex-shrink: 0;
        }
        .sellify-img-card.short {
            height: 320px;
            align-self: flex-end;
        }
        .sellify-img-card img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            display: block;
        }
        .sellify-img-label {
            position: absolute;
            bottom: 12px;
            left: 12px;
            right: 12px;
            text-align: center;
            background: rgba(0,0,0,0.7);
            color: white;
            font-size: 13px;
            padding: 6px;
            border-radius: 8px;
        }
        .sellify-form-side {
            flex: 0 0 480px;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 1.5rem;
            background: #000;
        }
        .sellify-form-container {
            width: 100%;
            max-width: 380px;
        }
        .sellify-logo {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 12px;
            margin-bottom: 2rem;
        }
        .sellify-logo-icon {
            height: 48px;
            width: 48px;
            border-radius: 50%;
            background: #7c3aed;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-size: 24px;
            flex-shrink: 0;
        }
        .sellify-logo-text {
            color: white;
            font-size: 22px;
            font-weight: bold;
            white-space: nowrap;
        }
        .sellify-card {
            background: white;
            border-radius: 16px;
            padding: 2rem;
            box-shadow: 0 25px 50px -12px rgba(0,0,0,0.5);
        }
    </style>

    <div class="sellify-login-wrapper">

        <div class="sellify-images-side">
            <div class="sellify-img-card">
                <img src="{{ asset('storage/car.jpg') }}" />
                <span class="sellify-img-label">بيع سيارة</span>
            </div>
            <div class="sellify-img-card short">
                <img src="{{ asset('storage/flat.jpg') }}" />
                <span class="sellify-img-label">بيع عقارك</span>
            </div>
            <div class="sellify-img-card">
                <img src="{{ asset('storage/bike.jpg') }}" />
                <span class="sellify-img-label">بيع دراجة</span>
            </div>
            <div class="sellify-img-card short">
                <img src="{{ asset('storage/phone.jpg') }}" />
                <span class="sellify-img-label">بيع هاتف</span>
            </div>
        </div>

        <div class="sellify-form-side">
            <div class="sellify-form-container">
                <div class="sellify-logo">
                    <div class="sellify-logo-icon">🛒</div>
                    <span class="sellify-logo-text">{{ app()->getLocale() === 'ar' ? 'Basary Souq' : 'Basary Souq' }}</span>
                </div>

                <div class="sellify-card">
                    <h2 style="font-size: 24px; font-weight: bold; color: #111; text-align: center; margin-bottom: 4px;">
                        تسجيل الدخول
                    </h2>
                    <p style="color: #6b7280; text-align: center; margin-bottom: 24px;">
                        أدخل بريدك وكلمة السر للدخول
                    </p>

                    <x-filament-panels::form wire:submit="authenticate">
                        {{ $this->form }}

                        <x-filament-panels::form.actions
                            :actions="$this->getCachedFormActions()"
                            :full-width="true"
                        />
                    </x-filament-panels::form>
                </div>
            </div>
        </div>
    </div>
</x-filament-panels::page.simple>