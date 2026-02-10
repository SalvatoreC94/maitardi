<template>
  <section class="py-20 bg-white text-brand-dark">
    <div class="max-w-6xl mx-auto px-4 grid md:grid-cols-2 gap-12 items-center">
      <div>
        <h1 class="text-4xl font-bold mb-4 text-brand-wine">Chi siamo: Passione e Lievito Madre</h1>
        <p class="text-lg text-brand-blue mb-6 leading-relaxed">
          Ogni dolce racconta una storia, e la nostra inizia nel 2015. L'incontro tra la Campania e la Sicilia
          ha dato vita a <strong>MaiTardi</strong> a <strong>San Valentino Torio</strong>, per mano di <strong>Francesco e Concetto</strong>. L'obiettivo
          era chiaro: portare l'autentica qualità e l'inconfondibile gusto siciliano – dai <strong>Cannoli croccanti</strong>
          agli <strong>Arancini fragranti</strong> – a tutti i nostri clienti.
          <br><br>
          Mentre Concetto gestisce l'accoglienza e l'atmosfera vibrante del nostro bar, Francesco, spinto da una
          profonda curiosità, si è immerso nell'arte del laboratorio. È lì che ha scoperto e coltivato la sua vera
          passione: i <strong>Grandi Lievitati</strong>.
          <br><br>
          I nostri <strong>Panettoni Artigianali</strong> e le <strong>Colombe</strong> sono veri capolavori, realizzati con il nostro
          <strong>Lievito Madre vivo</strong>, custodito gelosamente. È il cuore pulsante del nostro processo, garante di una
          sofficità unica, di profumi intensi e di una digeribilità superiore.
        </p>
        <p class="text-brand-dark/80 mb-8 leading-relaxed">
          La Promessa MaiTardi: Uniamo la <strong>tradizione senza tempo</strong> a uno sguardo sempre moderno. L'impiego di
          <strong>ingredienti genuini di altissima qualità</strong> e la costante <strong>ricerca dell'eccellenza</strong> in ogni fase della
          lavorazione non sono un segreto, ma una dedizione quotidiana. Scegliere MaiTardi significa abbracciare
          l'eccellenza artigianale che fa la differenza.
        </p>
        <RouterLink
          to="/shop"
          class="bg-brand-red hover:bg-brand-wine text-white px-6 py-3 rounded-lg font-semibold shadow-md transition"
        >
          Scopri i nostri prodotti
        </RouterLink>
      </div>

      <!-- ✅ fix definitivo -->
      <img
        :src="getImage('francesco-1.jpg')"
        alt="Francesco - Maestro Pasticcere MaiTardi"
        class="rounded-2xl shadow-lg object-cover w-full h-[420px]"
      />
    </div>
  </section>

  <section class="py-20 bg-brand-peach/10 text-brand-dark">
    <div class="max-w-6xl mx-auto px-4 text-center">
      <h2 class="text-3xl font-semibold mb-10 text-brand-wine">I nostri valori</h2>
      <div class="grid md:grid-cols-3 gap-10">
        <div class="p-6 rounded-xl bg-white shadow">
          <h3 class="font-semibold text-brand-red mb-3">Qualità</h3>
          <p>Solo ingredienti genuini e di prima scelta per garantire sapori autentici.</p>
        </div>
        <div class="p-6 rounded-xl bg-white shadow">
          <h3 class="font-semibold text-brand-red mb-3">Tradizione</h3>
          <p>Ricette tramandate e perfezionate negli anni, con passione artigianale.</p>
        </div>
        <div class="p-6 rounded-xl bg-white shadow">
          <h3 class="font-semibold text-brand-red mb-3">Innovazione</h3>
          <p>Ricerchiamo nuovi abbinamenti e tecniche per stupire ogni palato.</p>
        </div>
      </div>
    </div>
  </section>
</template>

<script setup>
import { RouterLink } from 'vue-router'

// ✅ helper per le immagini da /public/images
const getImage = (file) => `/images/${file}`
</script>
