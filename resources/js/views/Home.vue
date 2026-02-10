<template>
  <div class="home-page">
    <!-- Hero -->
    <section
      class="relative bg-brand-wine/5 text-brand-dark flex items-center justify-center min-h-[75vh]"
    >
      <div class="absolute inset-0 bg-white"></div>

      <div class="relative max-w-6xl mx-auto px-6 grid md:grid-cols-2 gap-12 items-center z-10">
        <!-- Testi -->
        <div class="text-left">
          <h1 class="text-4xl md:text-6xl font-bold mb-4 text-brand-wine">
            L'Eccellenza del Lievito Madre
          </h1>
          <p class="text-lg md:text-xl mb-8 text-brand-blue leading-relaxed">
            <strong>Panettoni</strong>, <strong>Colombe</strong> e sapori autentici:
            la tradizione dal <strong>2015</strong>.
          </p>
          <RouterLink
            to="/shop"
            class="bg-brand-red hover:bg-brand-wine text-white font-semibold px-6 py-3 rounded-lg shadow"
          >
            Scopri i Grandi Lievitati
          </RouterLink>
        </div>

        <!-- Immagine -->
        <div class="flex justify-center">
          <img
            :src="getImage('francesco-1.jpg')"
            alt="Maestro Francesco nel laboratorio"
            class="rounded-2xl shadow-xl object-cover w-[420px] h-[420px] md:h-[500px] md:w-[500px]"
          />
        </div>
      </div>
    </section>

    <!-- Chi siamo -->
    <section class="py-20 bg-brand-peach/10 text-brand-dark">
      <div class="max-w-6xl mx-auto px-4 grid md:grid-cols-2 gap-12 items-center">
        <div>
          <h2 class="text-3xl font-semibold mb-4 text-brand-wine">Passione Campana, Gusto Siciliano</h2>
          <p class="text-brand-blue leading-relaxed mb-6">
            MaiTardi nasce nel <strong>2015</strong> a <strong>San Valentino Torio</strong> con l'obiettivo di unire
            l'autentica qualità siciliana (Cannoli e Arancini) e l'eccellenza dei
            <strong>Grandi Lievitati</strong>.
            <br />
            La nostra arte si basa su <strong>Lievito Madre vivo</strong>, ingredienti di prima scelta
            e una lavorazione lenta che garantisce sofficità e alta digeribilità.
          </p>
          <RouterLink to="/chi-siamo" class="text-brand-red font-medium hover:underline">
            Scopri la nostra storia completa →
          </RouterLink>
        </div>

        <!-- 🔄 Suggerimento per nuova foto -->
        <!-- <img
          :src="getImage('laboratorio-impasto.jpg')"
          alt="Laboratorio artigianale in azione"
          class="rounded-2xl shadow-lg object-cover w-full h-[420px]"
        /> -->
      </div>
    </section>

    <!-- Prodotti in evidenza -->
    <section class="py-20 bg-white text-center">
      <h2 class="text-3xl font-semibold mb-2 text-brand-wine">I nostri prodotti artigianali</h2>
      <p class="text-lg text-brand-dark/70 mb-10">
        I capolavori del nostro laboratorio: dai Grandi Lievitati ai dolci siciliani.
      </p>

      <div
        v-if="featured.length"
        class="max-w-6xl mx-auto grid sm:grid-cols-2 md:grid-cols-3 gap-8 px-4"
      >
        <div
          v-for="p in featured"
          :key="p.id"
          class="border border-brand-peach/40 rounded-2xl overflow-hidden hover:shadow-lg transition duration-300 transform hover:-translate-y-1"
        >
          <img
            :src="p.image_url"
            :alt="p.name"
            class="w-full h-56 object-cover bg-white"
          />
          <div class="p-4 text-left">
            <h3 class="font-semibold mb-2 text-brand-dark">{{ p.name }}</h3>
            <p class="text-brand-red font-semibold text-lg">
              {{ formatPrice(p.price_cents) }}
            </p>
          </div>
        </div>
      </div>

      <RouterLink
        to="/shop"
        class="inline-block mt-10 bg-brand-red hover:bg-brand-wine text-white font-semibold px-6 py-3 rounded-lg shadow transition"
      >
        Vai allo shop completo
      </RouterLink>
    </section>
  </div>
</template>

<script setup>
import { ref, onMounted } from 'vue'
import axios from 'axios'
import { RouterLink } from 'vue-router'

const featured = ref([])

const getImage = (file) => `/images/${file}`

const formatPrice = (c) =>
  new Intl.NumberFormat('it-IT', { style: 'currency', currency: 'EUR' }).format((c || 0) / 100)

onMounted(async () => {
  try {
    // Se hai un campo "is_featured" nel database
    const { data } = await axios.get('/api/products', { params: { featured: true, per_page: 3 } })
    featured.value = data.data?.length ? data.data : []

    // fallback: se non esistono prodotti featured, prendi gli ultimi 3 visibili
    if (!featured.value.length) {
      const res = await axios.get('/api/products', { params: { per_page: 3 } })
      featured.value = res.data.data
    }
  } catch (e) {
    console.error('Errore caricamento prodotti in evidenza:', e)
  }
})
</script>

<style scoped>
.home-page {
  scroll-behavior: smooth;
}
</style>
