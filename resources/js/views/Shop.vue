<template>
  <section class="max-w-6xl mx-auto py-16 px-4 text-brand-dark">
    <!-- Header -->
    <header
      class="mb-10 flex flex-col md:flex-row gap-6 md:items-end md:justify-between border-b border-brand-peach/40 pb-6"
    >
      <div>
        <h1 class="text-4xl font-bold text-brand-wine">Shop</h1>
        <p class="text-brand-blue mt-1">Scopri le nostre specialità artigianali.</p>
      </div>

      <!-- Filtri -->
      <div class="w-full md:w-auto flex flex-col md:flex-row gap-3 text-sm">
        <div class="flex items-center gap-2">
          <input
            v-model="ui.q"
            @input="onSearch"
            type="search"
            placeholder="Cerca prodotti…"
            class="w-full md:w-64 border border-brand-peach/40 rounded-lg px-3 py-2 focus:ring-1 focus:ring-brand-red"
          />
        </div>

        <div class="flex items-center gap-2">
          <input
            v-model.number="ui.minPrice"
            type="number"
            min="0"
            step="1"
            placeholder="Min €"
            class="w-28 border border-brand-peach/40 rounded-lg px-3 py-2 focus:ring-1 focus:ring-brand-red"
          />
          <input
            v-model.number="ui.maxPrice"
            type="number"
            min="0"
            step="1"
            placeholder="Max €"
            class="w-28 border border-brand-peach/40 rounded-lg px-3 py-2 focus:ring-1 focus:ring-brand-red"
          />
          <button
            @click="applyFilters"
            class="rounded-lg bg-brand-red text-white px-4 py-2 hover:bg-brand-wine transition"
          >
            Filtra
          </button>
          <button
            @click="resetFilters"
            class="rounded-lg border border-brand-peach/60 px-4 py-2 hover:bg-brand-peach/20 disabled:opacity-40"
            :disabled="!ui.activeCategory && !ui.q && !ui.minPrice && !ui.maxPrice"
          >
            Reset
          </button>
        </div>
      </div>
    </header>

<!-- Banner Spedizione Gratuita -->
    <div class="mb-8 bg-gradient-to-r from-brand-wine to-brand-red text-white rounded-xl p-4 text-center shadow-md">
      <p class="text-lg font-semibold">
        🚚 Spedizione gratuita per ordini di almeno 69 €
      </p>
    </div>

    <!-- Categorie -->
    <div class="flex flex-wrap gap-2 mb-8">
      <button
        class="inline-flex items-center px-4 py-1.5 rounded-full border text-sm transition"
        :class="!ui.activeCategory
          ? 'bg-brand-wine text-white border-brand-wine'
          : 'bg-white border-brand-peach/60 hover:bg-brand-peach/20'"
        @click="setCategory(null)"
      >
        Tutti
      </button>
      <button
        v-for="c in categories"
        :key="c.slug"
        class="inline-flex items-center px-4 py-1.5 rounded-full border text-sm transition"
        :class="ui.activeCategory === c.slug
          ? 'bg-brand-wine text-white border-brand-wine'
          : 'bg-white border-brand-peach/60 hover:bg-brand-peach/20'"
        @click="setCategory(c.slug)"
      >
        {{ c.name }}
      </button>
    </div>

    <!-- Stato caricamento -->
    <div v-if="loading" class="text-center text-stone-500 py-12">
      Caricamento prodotti…
    </div>

    <!-- Nessun prodotto -->
    <div v-else-if="products.length === 0" class="text-center text-stone-600 py-16">
      Nessun prodotto trovato.
    </div>

    <!-- Griglia prodotti -->
    <div v-else class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-8">
      <article
        v-for="p in products"
        :key="p.id"
        class="bg-white rounded-2xl border border-brand-peach/40 overflow-hidden shadow-sm hover:shadow-md transition flex flex-col"
      >
        <a :href="`/prodotti/${p.slug}`" class="block">
          <img
            :src="p.image_url"
            :alt="p.name"
            class="w-full h-60 object-cover"
          />
        </a>

        <div class="p-5 flex-1 flex flex-col">
          <h3 class="font-semibold mb-1 text-brand-wine">
            <a :href="`/prodotti/${p.slug}`">{{ p.name }}</a>
          </h3>

          <template v-if="p.is_visible">
            <div class="text-brand-red font-semibold mb-4">
              {{ formatPrice(p.price_cents) }}
            </div>

            <form method="POST" action="/carrello/aggiungi" class="mt-auto">
              <input type="hidden" name="_token" :value="csrf" />
              <input type="hidden" name="product_id" :value="p.id" />
              <input type="hidden" name="qty" value="1" />

              <button
                class="w-full bg-brand-red text-white py-2 rounded-lg hover:bg-brand-wine transition"
              >
                Aggiungi al carrello
              </button>
            </form>
          </template>
          <div v-else class="mt-auto">
            <span class="inline-block bg-gray-200 text-gray-600 font-semibold py-2 px-4 rounded-lg w-full text-center">
              Non disponibile
            </span>
          </div>
        </div>
      </article>
    </div>

    <!-- Paginazione -->
    <div
      v-if="totalPages > 1"
      class="mt-12 flex items-center gap-3 justify-center text-sm"
    >
      <button
        class="px-3 py-1.5 rounded border border-brand-peach/50 hover:bg-brand-peach/20"
        :disabled="page <= 1"
        @click="goTo(page - 1)"
      >
        «
      </button>
      <span>Pagina {{ page }} / {{ totalPages }}</span>
      <button
        class="px-3 py-1.5 rounded border border-brand-peach/50 hover:bg-brand-peach/20"
        :disabled="page >= totalPages"
        @click="goTo(page + 1)"
      >
        »
      </button>
    </div>
  </section>
</template>

<script setup>
import { ref, reactive, onMounted } from 'vue'
import axios from 'axios'

const csrf = document.querySelector('meta[name="csrf-token"]')?.content

const categories = ref([])
const products = ref([])
const loading = ref(true)
const page = ref(1)
const perPage = ref(9)
const total = ref(0)
const totalPages = ref(1)

const ui = reactive({
  activeCategory: null,
  q: '',
  minPrice: null,
  maxPrice: null,
})

let searchTimer = null

const formatPrice = (c) =>
  new Intl.NumberFormat('it-IT', { style: 'currency', currency: 'EUR' }).format((c || 0) / 100)

const cents = (eur) => {
  if (!eur) return undefined
  const n = Number(eur)
  return Number.isFinite(n) ? Math.max(0, Math.round(n * 100)) : undefined
}

const normalize = (list) => list.map((p) => ({ ...p }))

const loadCategories = async () => {
  const { data } = await axios.get('/api/categories')
  categories.value = data
}

const loadProducts = async () => {
  loading.value = true
  try {
    const params = { page: page.value, per_page: perPage.value }
    if (ui.activeCategory) params.category = ui.activeCategory
    if (ui.q) params.q = ui.q.trim()
    const minC = cents(ui.minPrice)
    const maxC = cents(ui.maxPrice)
    if (minC !== undefined) params.min_price = minC
    if (maxC !== undefined) params.max_price = maxC

    const { data } = await axios.get('/api/products', { params })
    products.value = normalize(data.data)
    total.value = data.meta?.total ?? products.value.length
    perPage.value = data.meta?.per_page ?? perPage.value
    page.value = data.meta?.current_page ?? page.value
    totalPages.value = Math.max(1, Math.ceil(total.value / perPage.value))
  } finally {
    loading.value = false
  }
}

const setCategory = (slug) => {
  ui.activeCategory = slug
  page.value = 1
  loadProducts()
}

const applyFilters = () => {
  page.value = 1
  loadProducts()
}

const resetFilters = () => {
  ui.activeCategory = null
  ui.q = ''
  ui.minPrice = null
  ui.maxPrice = null
  page.value = 1
  loadProducts()
}

const onSearch = () => {
  clearTimeout(searchTimer)
  searchTimer = setTimeout(() => {
    page.value = 1
    loadProducts()
  }, 400)
}

const goTo = (p) => {
  if (p < 1 || p > totalPages.value) return
  page.value = p
  loadProducts()
}

onMounted(async () => {
  await loadCategories()
  await loadProducts()
})
</script>
