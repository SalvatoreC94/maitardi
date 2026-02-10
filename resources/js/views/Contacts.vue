<template>
  <section class="max-w-5xl mx-auto py-16 px-4 text-brand-dark">
    <!-- Header -->
    <header class="text-center mb-10">
      <h1 class="text-4xl font-bold text-brand-wine mb-3">Contattaci</h1>
      <p class="text-brand-blue">
        Hai domande sui nostri prodotti o desideri un ordine personalizzato?  
        Scrivici, saremo felici di risponderti.
      </p>
    </header>

    <div class="grid md:grid-cols-2 gap-10">
      <!-- Form -->
      <form
        action="https://formspree.io/f/mblpgavq"
        method="POST"
        class="bg-white rounded-2xl border border-brand-peach/40 shadow-sm p-8"
      >
        <div class="mb-5">
          <label class="block text-sm font-semibold text-brand-wine mb-2">Nome</label>
          <input
            type="text"
            name="name"
            required
            class="w-full border border-brand-peach/40 rounded-lg px-3 py-2 focus:ring-1 focus:ring-brand-red"
            placeholder="Il tuo nome"
          />
        </div>

        <div class="mb-5">
          <label class="block text-sm font-semibold text-brand-wine mb-2">Email</label>
          <input
            type="email"
            name="email"
            required
            class="w-full border border-brand-peach/40 rounded-lg px-3 py-2 focus:ring-1 focus:ring-brand-red"
            placeholder="email@esempio.it"
          />
        </div>

        <div class="mb-5">
          <label class="block text-sm font-semibold text-brand-wine mb-2">Messaggio</label>
          <textarea
            name="message"
            required
            rows="5"
            class="w-full border border-brand-peach/40 rounded-lg px-3 py-2 focus:ring-1 focus:ring-brand-red resize-none"
            placeholder="Scrivi qui il tuo messaggio..."
          ></textarea>
        </div>

        <button
          type="submit"
          class="w-full bg-brand-red text-white font-semibold rounded-lg py-2.5 hover:bg-brand-wine transition"
        >
          Invia messaggio
        </button>

        <p class="text-xs text-center text-stone-500 mt-3">
          Inviando il modulo accetti la nostra <a href="/privacy-policy" class="underline hover:text-brand-red">Privacy Policy</a>.
        </p>
      </form>

      <!-- Info -->
      <div class="flex flex-col justify-center bg-brand-peach/10 rounded-2xl p-8">
        <h2 class="text-2xl font-semibold text-brand-wine mb-4">Pasticceria Maitardi</h2>

        <p class="mb-3">
          📍Strada Provinciale Giovanni Amendola,5 <br>
          84010 San Valentino Torio SA
        </p>

        <p class="mb-3">☎️ <strong>334 8169141</strong></p>

        <p class="mb-3">✉️ infoamaitardi@gmail.com</p>

      
        <div class="mt-8">
          <iframe
            class="w-full h-64 rounded-lg border border-brand-peach/40"
            src="https://www.google.com/maps?q=Pasticceria+Maitardi,+San+Valentino+Torio&output=embed"
            allowfullscreen
            loading="lazy"
          ></iframe>
        </div>
      </div>
    </div>
  </section>
</template>



<style scoped>
/* piccoli tocchi visivi */
input:focus,
textarea:focus {
  outline: none;
}
</style>
