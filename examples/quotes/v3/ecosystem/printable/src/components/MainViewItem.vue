<script setup>
import { jsPDF } from 'jspdf'

const props = defineProps({
  article: Object
})

/** collects the authors in a text string */
function authorsToString(authors) {
  let stringOfAuthors = ''
  authors.forEach(contributor => {
    console.log(`function authorToString, contributor: ${JSON.stringify(contributor)}`)
    if (!contributor.author.suspended) {
      if (!stringOfAuthors.length < 1) {
        stringOfAuthors += ', '
      }
      stringOfAuthors += contributor.author.name + ' ' + contributor.author.surname
    }
  })
  return stringOfAuthors
}

/** export article to the pdf format */
function exportToPdf(article) {
  console.log(`Click on article: ${article.title}`)
  const fileName = article.title.replace(/([:,\s])+/g, '_')

  let mainAuthors = new Array()
  let contributors = new Array()
  article.contributors.forEach(contributor => {
    if (contributor.isMain) {
      mainAuthors.push(contributor)
    } else {
      contributors.push(contributor)
    }
  })

  const doc = new jsPDF('p', 'in', 'a4')

  // fist page
  // set margin
  doc.setDrawColor('#eee')
  doc.setLineWidth(1 / 72)
  doc.line(0.635, 0.845, 7.0, 0.845)
  doc.line(7.0, 0.845, 7.0, 10.0)
  doc.line(7.0, 10.0, 0.635, 10.0)
  doc.line(0.635, 10.0, 0.635, 0.845)

  doc.setTextColor('#777')
  doc.setFontSize(24)
  doc.text(article.title.toUpperCase(), 0.787, 1.968, { maxWidth: 6.0 })

  doc.line(0.7, 3.3, 5.0, 3.3, 'F')

  // main authors
  if (authorsToString(mainAuthors).length > 0) {
    doc.setFontSize(14)
    doc.text('main authors:', 0.9, 4.5)
    doc.setFontSize(16)
    doc.text(authorsToString(mainAuthors), 0.9, 4.75, { maxWidth: 6.0 })
  }

  // contributors
  if (authorsToString(contributors).length > 0) {
    doc.setFontSize(14)
    doc.text('contributors:', 0.9, 5.3)
    doc.setFontSize(16)
    doc.text(authorsToString(contributors), 0.9, 5.55, { maxWidth: 6.0 })
  }

  doc.setTextColor('#333')
  doc.setFontSize(14)
  doc.text('subject:', 0.9, 7.1)

  doc.setFontSize(16)
  doc.text(article.subject, 0.9, 7.35, { maxWidth: 6.0 })

  if (article.summary.length > 0) {
    doc.setTextColor('#444')
    doc.setFontSize(14)
    doc.text('summary:', 0.9, 8.3)
    doc.setFontSize(16)
    doc.text(article.summary, 0.9, 8.55, { maxWidth: 6.0 })
  }

  // second page
  doc.addPage()
  // set margin
  doc.setDrawColor('#eee')
  doc.setLineWidth(1 / 72)
  doc.line(0.635, 0.845, 7.0, 0.845)
  doc.line(7.0, 0.845, 7.0, 10.0)
  doc.line(7.0, 10.0, 0.635, 10.0)
  doc.line(0.635, 10.0, 0.635, 0.845)

  doc.setTextColor('#222')
  doc.setFontSize(18)
  doc.text(article.content, 0.9, 1.968, { maxWidth: 6.0 })

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
