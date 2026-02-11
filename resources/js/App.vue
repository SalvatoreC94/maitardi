<template>
  <div class="min-h-screen bg-brand-peach/5 text-brand-dark flex flex-col">
    <!-- Topbar -->
    <div class="text-xs bg-brand-wine text-white">
      <div class="max-w-6xl mx-auto px-2 md:px-4 h-9 flex items-center justify-between gap-2">
        <span class="tracking-wide flex items-center gap-2 md:gap-4 min-w-0">
          <span class="hidden sm:inline">📍 San Valentino Torio</span>
          <span class="sm:hidden">📍 S. Valentino T.</span>

          <!-- WhatsApp (pill) -->
          <a
            href="https://wa.me/393348169141?text=Ciao%2C%20sarei%20interessato%20a..."
            target="_blank"
            rel="noopener noreferrer"
            class="inline-flex items-center gap-1 md:gap-2 px-2 md:px-3 py-1 md:py-1.5 border border-brand-peach/60 rounded-full
                   text-white hover:bg-brand-peach/20 transition text-[10px] md:text-xs whitespace-nowrap"
          >
            <i class="fa-brands fa-whatsapp text-brand-peach"></i>
            <span class="hidden sm:inline">WhatsApp 3348169141</span>
            <span class="sm:hidden">WhatsApp</span>
          </a>

          <!-- Telefono (pill) -->
          <a
            href="tel:+393348169141"
            class="hidden sm:inline-flex items-center gap-2 px-3 py-1.5 border border-brand-peach/60 rounded-full
                   text-white hover:bg-brand-peach/20 transition"
          >
            ☎️ 3348169141
          </a>
        </span>

        <RouterLink to="/contatti" class="hover:underline text-brand-peach whitespace-nowrap">
          Contattaci
        </RouterLink>
      </div>
    </div>

    <!-- Header / Navbar -->
    <header class="bg-white/90 backdrop-blur sticky top-0 z-50 border-b border-brand-peach/40 shadow-sm">
      <div class="max-w-7xl mx-auto px-4 h-24 md:h-28 flex items-center justify-between relative">
        <!-- 🔹 Logo sinistro -->
        <RouterLink to="/" class="flex items-center gap-3">
          <img
            :src="logo"
            alt="Pasticceria Maitardi"
            class="h-24 md:h-32 w-auto object-contain"
            style="max-height: 110px;"
          />
        </RouterLink>

        <!-- 🔸 Logo centrale -->
        <div class="absolute left-1/2 transform -translate-x-1/2">
          <img
            :src="logoSf"
            alt="Logo Secondario"
            class="h-24 md:h-32 w-auto object-contain"
            style="max-height: 110px;"
          />
        </div>

        <!-- 🔹 Nav destra -->
        <nav class="hidden lg:flex items-center gap-4 text-sm font-medium">
          <RouterLink :class="nav('home')" to="/">Home</RouterLink>
          <RouterLink :class="nav('about')" to="/chi-siamo">Chi siamo</RouterLink>
          <RouterLink :class="nav('shop')" to="/shop">Shop</RouterLink>
          <RouterLink :class="nav('contacts')" to="/contatti">Contatti</RouterLink>
          <a
            href="/carrello"
            class="inline-flex items-center gap-2 rounded-lg border border-brand-peach/60 text-brand-red hover:bg-brand-peach/20 px-3 py-1.5 transition"
          >
            🛒 Carrello
          </a>
        </nav>

        <!-- 🔸 Mobile trigger -->
        <button
          class="lg:hidden inline-flex items-center gap-2 rounded-lg border px-3 py-1.5 text-brand-wine border-brand-peach/50"
          @click="toggle"
          :aria-expanded="open ? 'true' : 'false'"
          aria-controls="mobile-menu"
        >
          <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none"
               viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
            <path stroke-linecap="round" stroke-linejoin="round"
                  d="M3.75 6.75h16.5M3.75 12h16.5M3.75 17.25h16.5" />
          </svg>
          Menu
        </button>
      </div>

      <!-- Mobile overlay -->
      <div v-show="open" class="fixed inset-0 z-40 bg-black/30 lg:hidden" @click="close" />

      <!-- Mobile menu -->
      <transition name="fade">
        <div v-show="open" id="mobile-menu" class="lg:hidden border-t bg-white relative z-50">
          <div class="max-w-6xl mx-auto px-4 py-6 flex flex-col items-center gap-4 text-sm font-medium">
            <img
              :src="logo"
              alt="Pasticceria Maitardi"
              class="h-10 w-auto object-contain mb-2"
            />
            <RouterLink :class="nav('home')" to="/" @click="close">Home</RouterLink>
            <RouterLink :class="nav('about')" to="/chi-siamo" @click="close">Chi siamo</RouterLink>
            <RouterLink :class="nav('shop')" to="/shop" @click="close">Shop</RouterLink>
            <RouterLink :class="nav('contacts')" to="/contatti" @click="close">Contatti</RouterLink>
            <a
              href="/carrello"
              class="inline-flex items-center gap-2 rounded-lg border px-3 py-1.5 border-brand-peach/50 text-brand-red"
              @click="close"
            >
              🛒 Carrello
            </a>
          </div>
        </div>
      </transition>
    </header>

    <!-- Main content -->
    <main class="flex-grow w-full max-w-7xl mx-auto px-4 py-10">
      <RouterView />
    </main>

    <!-- Footer -->
    <footer class="bg-brand-dark text-white mt-16">
      <div class="max-w-6xl mx-auto px-4 py-14 grid gap-8 sm:grid-cols-2 lg:grid-cols-4 text-sm">
        <div>
          <h4 class="font-semibold mb-3 text-brand-peach">Dove siamo</h4>
          <p class="text-white/80 leading-relaxed">
            Strada Provinciale Giovanni Amendola, 5 
            84010 San Valentino Torio SA <br>
            ✉️ infomaitardi@gmail.com<br>
            ☎️ 3348169141
          </p>
        </div>
        <div>
          <h4 class="font-semibold mb-3 text-brand-peach">Servizio clienti</h4>
          <p class="text-white/80 flex flex-col gap-2">
  <a
  href="https://wa.me/393348169141?text=Ciao%2C%20sarei%20interessato%20a..."
  target="_blank"
  rel="noopener noreferrer"
  class="inline-flex items-center gap-2 px-3 py-1.5 border border-brand-peach/60 rounded-full 
         text-white hover:bg-brand-peach/20 transition"
>
  <i class="fa-brands fa-whatsapp text-brand-peach"></i>
  WhatsApp 3348169141
</a>


  <a
    href="tel:+393348169141"
    class="inline-flex items-center gap-2 px-3 py-1.5 border border-brand-peach/60 rounded-full 
           text-white hover:bg-brand-peach/20 transition"
  >
    ☎️ 3348169141
  </a>
</p>

        </div>
        <div>
          <h4 class="font-semibold mb-3 text-brand-peach">Prodotti</h4>
          <ul class="space-y-2 text-white/80">
            <li><RouterLink class="hover:text-brand-peach" to="/shop">Panettoni</RouterLink></li>
            <li><RouterLink class="hover:text-brand-peach" to="/shop">Colombe</RouterLink></li>
          </ul>
        </div>
        <div>
          <h4 class="font-semibold mb-3 text-brand-peach">Informazioni</h4>
          <ul class="space-y-2 text-white/80">
            <li><RouterLink class="hover:text-brand-peach" to="/">Home</RouterLink></li>
            <li><RouterLink class="hover:text-brand-peach" to="/chi-siamo">Chi siamo</RouterLink></li>
           <li>
  <RouterLink to="/termini-condizioni" class="hover:text-brand-peach">
    Termini e Condizioni
  </RouterLink>
</li>

            <!-- 🔹 Iubenda Privacy & Cookie Policy -->
            <li>
              <a
                href="https://www.iubenda.com/privacy-policy/94037718"
                class="iubenda-white iubenda-noiframe iubenda-embed hover:text-brand-peach"
                title="Privacy Policy"
              >
                Privacy Policy
              </a>
            </li>
            <li>
              <a
                href="https://www.iubenda.com/privacy-policy/94037718/cookie-policy"
                class="iubenda-white iubenda-noiframe iubenda-embed hover:text-brand-peach"
                title="Cookie Policy"
              >
                Cookie Policy
              </a>
            </li>
</ul>
        </div>
      </div>
      <div class="text-center text-xs text-white/60 pb-6">
        © {{ new Date().getFullYear() }} Pasticceria Maitardi — Tutti i diritti riservati
        <p>P.iva: 05085580651</p>
      </div>
    </footer>
  </div>
  <!-- Floating WhatsApp Button -->
<div class="fixed bottom-5 right-5 z-50 group">
  <!-- Tooltip -->
  <div
    class="absolute right-full mr-3 top-1/2 -translate-y-1/2 bg-brand-dark text-white text-xs 
           px-3 py-1.5 rounded-lg opacity-0 group-hover:opacity-100 transition 
           whitespace-nowrap shadow-lg"
  >
    Scrivici su WhatsApp
  </div>

  <!-- Button -->
<a
  href="https://wa.me/393348169141?text=Ciao%2C%20sarei%20interessato%20a..."
  target="_blank"
  rel="noopener noreferrer"
  class="inline-flex items-center gap-2 px-3 py-1.5 border border-brand-peach/60 rounded-full 
         text-white hover:bg-brand-peach/20 transition"
>
  <i class="fa-brands fa-whatsapp text-3xl text-white"></i>

</a>

</div>

</template>

<script setup>
import { ref, onMounted } from 'vue'
import { useRoute, RouterLink, RouterView } from 'vue-router'

// ✅ Per immagini in /public, usa percorsi diretti (senza import)
const logo = '/images/maitardi-logo.png'
const logoSf = '/images/logo-sf.png'

const route = useRoute()
const open = ref(false)

const nav = (name) =>
  route.name === name
    ? 'font-semibold text-brand-red'
    : 'text-brand-dark/70 hover:text-brand-red transition'

const toggle = () => (open.value = !open.value)
const close = () => (open.value = false)

// ✅ Caricamento script Iubenda lato client
onMounted(() => {
  if (!document.querySelector('script[src="https://cdn.iubenda.com/iubenda.js"]')) {
    const script = document.createElement('script')
    script.src = 'https://cdn.iubenda.com/iubenda.js'
    script.async = true
    document.body.appendChild(script)
  }
})
</script>

<style>
.fade-enter-active, .fade-leave-active {
  transition: opacity 0.2s ease;
}
.fade-enter-from, .fade-leave-to {
  opacity: 0;
}
</style>
