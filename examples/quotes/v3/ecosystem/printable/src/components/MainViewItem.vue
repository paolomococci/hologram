<script setup>
import { jsPDF } from 'jspdf'

const props = defineProps({
  article: Object
})

/** export article to the pdf format */
function exportToPdf(article) {
  console.log(`Click on article: ${article.title}`)
  const fileName = article.title.replace(/([:,\s])+/g, '_')

  const doc = new jsPDF()

  doc.setDrawColor('#bbb')
  doc.ellipse(100, 50, 90, 45)
  doc.setTextColor('#777')
  doc.setFontSize(24)
  doc.text(article.title.toUpperCase(), 20, 50, { maxWidth: 160 })
  doc.line(10, 110, 160, 110, 'F')

  doc.setTextColor('#333')
  doc.setFontSize(14)
  doc.text('subject:', 15, 120)

  doc.setTextColor('#333')
  doc.setFontSize(14)
  doc.text(article.subject, 15, 125, { maxWidth: 170 })

  doc.setTextColor('#222')
  doc.setFontSize(14)
  doc.text('summary:', 15, 160)

  doc.setTextColor('#222')
  doc.setFontSize(14)
  doc.text(article.summary, 15, 165, { maxWidth: 170 })

  doc.addPage()

  doc.setTextColor('#000')
  doc.setFontSize(18)
  doc.text(article.content, 20, 50, { maxWidth: 170 })

  doc.save(`${fileName}.pdf`)
}
</script>

<template>
  <div class="px-8 pt-8 mx-8 mt-8 rounded-lg card bg-slate-300">
    <button title="click to export in PDF format" @click="exportToPdf(props.article)">
      <span class="p-4 m-4 text-xl font-semibold leading-relaxed text-slate-700" v-text="props.article?.title">
      </span>
    </button>
  </div>
</template>

<style scoped></style>
