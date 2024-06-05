<script setup>
import { Printable } from '@/controllers/Printable'

const props = defineProps({
  article: Object
})

/** generate PDF from JSON data */
function generatePdf() {
  const printable = new Printable(props.article)
  printable.generatePdf()
}
</script>

<template>
  <div class="px-8 pt-8 mx-8 mt-8 rounded-lg card bg-slate-300">
    <button title="click to export in PDF format" @click="generatePdf()">
      <span class="p-4 m-4 text-xl font-semibold leading-relaxed text-slate-700" v-text="props.article?.title">
      </span>
    </button>
  </div>
</template>
