# 🔥 Spawanie Trzebnica - Modernizacja Strony WWW

<div align="center">

[![WordPress](https://img.shields.io/badge/WordPress-6.x-blue.svg)](https://wordpress.org/)
[![PHP](https://img.shields.io/badge/PHP-8.0%2B-777BB4.svg)](https://php.net/)
[![WPBakery](https://img.shields.io/badge/WPBakery-Compatible-orange.svg)](https://wpbakery.com/)
[![License](https://img.shields.io/badge/License-GPL--2.0%2B-green.svg)](LICENSE)
[![PageSpeed](https://img.shields.io/badge/PageSpeed-Target%2090%2B-brightgreen.svg)](https://developers.google.com/speed/pagespeed/insights/)

**Kompleksowa modernizacja strony internetowej firmy TOLL-SPAW**  
*Spawalnictwo | Ślusarstwo | Konstrukcje stalowe*

[🌐 Na żywo](https://spawanietrzebnica.pl) | [📋 Zadania](https://github.com/PB-MEDIA-Strony-Sklepy-Marketing/spawanietrzebnica-pl-modernize-website-modernity/issues) | [📖 Dokumentacja](docs/) | [🎨 Brand](docs/_brand-spawanie-trzebnica/)

</div>

---

## 📌 O projekcie

Projekt modernizacji strony internetowej **spawanietrzebnica.pl** dla firmy TOLL-SPAW - lidera usług spawalniczych w regionie Trzebnica/Twardogóra. Celem jest stworzenie nowoczesnej, wydajnej i zoptymalizowanej pod SEO strony WordPress z zachowaniem kompatybilności WPBakery Page Builder.

### 🎯 Główne cele

- **🚀 Wydajność** - PageSpeed Insights 90+ (mobile/desktop)
- **📱 Mobile-first** - Pełna responsywność RWD
- **🔍 SEO** - Strukturalne dane, Open Graph, pozycjonowanie lokalne
- **♿ Dostępność** - WCAG 2.2 AA compliance
- **🔒 Bezpieczeństwo** - WordPress Security best practices
- **🎨 Nowoczesny design** - Spójny z branżą spawalniczą

## 🛠️ Stack technologiczny

| Kategoria | Technologie |
|-----------|------------|
| **CMS** | WordPress 6.x |
| **PHP** | 8.0+ z namespace `SpawanieTrzebnica\Theme` |
| **Builder** | WPBakery Page Builder (js_composer) |
| **CSS** | SCSS, BEM, CSS Custom Properties |
| **JavaScript** | jQuery (WP), Vanilla JS ES6+ |
| **Optymalizacja** | Critical CSS, Lazy Loading, WebP |
| **SEO** | Schema.org, Open Graph, XML Sitemap |
| **Narzędzia** | Composer, npm/yarn, Webpack, PHPCS |

## 🚀 Szybki start

### Wymagania

- PHP >= 8.0
- MySQL >= 5.7 / MariaDB >= 10.3
- WordPress >= 6.0
- Node.js >= 18.x
- Composer >= 2.0

### Instalacja lokalna

```bash
# 1. Klonuj repozytorium
git clone https://github.com/PB-MEDIA-Strony-Sklepy-Marketing/spawanietrzebnica-pl-modernize-website-modernity.git
cd spawanietrzebnica-pl-modernize-website-modernity

# 2. Zainstaluj zależności PHP
composer install

# 3. Zainstaluj zależności Node.js
npm install

# 4. Konfiguracja WordPress
cp wp-config-sample.php wp-config.php
# Edytuj wp-config.php z danymi twojej bazy

# 5. Build assetów
npm run build

# 6. Uruchom środowisko deweloperskie
npm run dev
```

### Konfiguracja Docker (opcjonalnie)

```bash
# Uruchom kontener WordPress + MySQL
docker-compose up -d

# Strona dostępna pod: http://localhost:8080
# phpMyAdmin: http://localhost:8081
```

## 📁 Struktura projektu

```
spawanietrzebnica-pl-modernize-website-modernity/
├── 📁 .github/
│   └── workflows/         # GitHub Actions CI/CD
├── 📁 docs/               # Dokumentacja projektu
│   ├── _brand-spawanie-trzebnica/  # Branding assets
│   ├── BRIEF-PROJECT.md
│   └── KOLORYSTYKA-ROOT-BRAND-COLOR-CSS.md
├── 📁 wp-content/
│   ├── 📁 themes/
│   │   └── spawanie-trzebnica/    # Custom theme
│   │       ├── assets/            # CSS, JS, images
│   │       ├── inc/              # PHP includes
│   │       ├── template-parts/   # Części szablonów
│   │       ├── wpbakery/         # Custom VC elements
│   │       ├── functions.php
│   │       └── style.css
│   └── 📁 plugins/               # Wymagane wtyczki
├── 📁 tests/                     # Testy jednostkowe i E2E
├── 📄 .env.example              # Zmienne środowiskowe
├── 📄 composer.json             # Zależności PHP
├── 📄 package.json              # Zależności Node.js
├── 📄 phpcs.xml                # WordPress Coding Standards
├── 📄 webpack.config.js         # Konfiguracja Webpack
└── 📄 docker-compose.yml        # Docker setup
```

## 🎨 Kolorystyka marki

System kolorów oparty na CSS Custom Properties:

```css
:root {
    --color-theme-primary: #EEB313;      /* Złoty - spawalnictwo */
    --color-theme-secondary: #2C5F7C;    /* Stalowy niebieski */
    --color-theme-accent: #E85D04;       /* Pomarańcz - płomień */
    --background-theme-color: #F7F4E9;   /* Kremowe tło */
}
```

## ⚡ Funkcjonalności

### ✅ Zaimplementowane

- [x] System kolorów CSS Custom Properties
- [x] Dokumentacja brandingowa
- [x] Brief projektu

### 🔄 W trakcie

- [ ] Struktura motywu WordPress
- [ ] Custom elementy WPBakery
- [ ] Optymalizacja wydajności

### 📋 Planowane

- [ ] Schema.org dla LocalBusiness
- [ ] Lazy loading obrazów
- [ ] Critical CSS inline
- [ ] PWA Support
- [ ] Wielojęzyczność (WPML ready)

## 🧪 Testowanie

```bash
# Lintowanie PHP (WPCS)
npm run lint:php

# Napraw błędy PHP
npm run fix:php

# Lintowanie JavaScript
npm run lint:js

# Testy jednostkowe PHP
npm run test:php

# Testy E2E (Playwright)
npm run test:e2e

# Wszystkie testy
npm run test
```

## 📊 Metryki wydajności

| Metryka | Cel | Status |
|---------|-----|--------|
| **PageSpeed Mobile** | 90+ | 🔄 W trakcie |
| **PageSpeed Desktop** | 95+ | 🔄 W trakcie |
| **FCP** | < 1.8s | ⏳ |
| **LCP** | < 2.5s | ⏳ |
| **CLS** | < 0.1 | ⏳ |
| **FID** | < 100ms | ⏳ |

## 🚀 Deployment

### Staging

```bash
# Automatyczny deploy przy push do develop
git push origin develop
```

### Produkcja

```bash
# Ręczny deploy przez GitHub Actions
# 1. Utwórz release tag
git tag -a v1.0.0 -m "Release v1.0.0"
git push origin v1.0.0

# 2. Deploy zostanie uruchomiony automatycznie
```

## 🔧 Komendy npm

| Komenda | Opis |
|---------|------|
| `npm run dev` | Uruchom webpack w trybie watch |
| `npm run build` | Build produkcyjny |
| `npm run lint` | Sprawdź kod (PHP + JS) |
| `npm run fix` | Napraw błędy formatowania |
| `npm run test` | Uruchom wszystkie testy |
| `npm run analyze` | Analizuj bundle size |

## 📚 Dokumentacja

- [Brief projektu](docs/BRIEF-PROJECT.md)
- [System kolorów](docs/KOLORYSTYKA-ROOT-BRAND-COLOR-CSS.md)
- [Instrukcje WordPress](instructions/wordpress.instructions.md)
- [Dokumentacja WPBakery](docs/wpbakery-integration.md)
- [Przewodnik SEO](docs/seo-guidelines.md)

## 🤝 Współpraca

### Proces rozwoju

1. Utwórz branch z `develop`
2. Wprowadź zmiany według standardów WPCS
3. Napisz/zaktualizuj testy
4. Utwórz Pull Request do `develop`
5. Po review i testach - merge

### Konwencja commitów

```
feat: Dodaj nową funkcjonalność
fix: Napraw błąd
docs: Aktualizacja dokumentacji
style: Formatowanie kodu
refactor: Refaktoryzacja kodu
perf: Optymalizacja wydajności
test: Dodaj/popraw testy
chore: Zadania utrzymaniowe
```

## 📝 Licencja

Ten projekt jest licencjonowany na podstawie [GPL-2.0-or-later](LICENSE) - szczegóły w pliku LICENSE.

## 👥 Zespół

**PB MEDIA - Strony, Sklepy, Marketing**

- 🌐 [Strona firmowa](https://pb-media.pl)
- 📧 Kontakt: kontakt@pb-media.pl
- 💼 GitHub: [@PB-MEDIA-Strony-Sklepy-Marketing](https://github.com/PB-MEDIA-Strony-Sklepy-Marketing)

**Klient: TOLL-SPAW**

- 🌐 [spawanietrzebnica.pl](https://spawanietrzebnica.pl)
- 📞 +48 883 485 324
- 📧 kontakt@spawanietrzebnica.pl

---

<div align="center">

**🔨 Crafted with passion by PB MEDIA**

[![WordPress](https://img.shields.io/badge/WordPress-Expert-21759B?logo=wordpress)](https://wordpress.org/)
[![GitHub](https://img.shields.io/badge/GitHub-Copilot%20Ready-181717?logo=github)](https://github.com/features/copilot)

</div>